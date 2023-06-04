<?php declare(strict_types=1);

namespace App\Processors;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Form;
use App\Entity\Respondent;
use App\Entity\Submission;
use App\Entity\SubmissionResult;
use App\Repository\RespondentRepository;
use App\Repository\SubmissionRepository;
use App\Repository\SubmissionResultRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubmissionProcessor implements ProcessorInterface
{
    protected $subjectAttributes = [
        'languages',
        'sport',
        'math',
        'physics',
        'geography',
        'chemistry',
        'computers',
        'music',
        'crafts',
        'religion',
        'art',
    ];

    public function __construct(
        protected readonly RespondentRepository       $respondentRepository,
        protected readonly SubmissionRepository       $submissionRepository,
        protected readonly SubmissionResultRepository $submissionResultRepository,
        protected readonly EntityManagerInterface     $entityManager,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Submission) {
            $formGroups = $submitterScores = [];
            //select required respondents for school/grade groups - sort by most similar respondents
            $respondents = $this->respondentRepository->findRespondentsOrderedByDifference($data);
            foreach ($respondents as $respondentData) {
                /** @var Respondent $respondent */
                $respondent = $respondentData[0];
                $respondent->setDifference($respondentData['difference']);
                foreach ($this->subjectAttributes as $subject) {
                    $this->calculateRespondentGradeCoefficients($respondent, $subject, $formGroups);
                }
            }

            //here we get summary grades for each subject of each class group
            $this->calculateClassgroupSummaryGrades($formGroups);

            $weightedFormGroupResults = [];
            $maxScore = 0;
            foreach ($formGroups as $formId => $subjects) {
                $score = $this->calculateWeightedFormGroupScore($data, $subjects);
                $maxScore = max($score, $maxScore);
                $weightedFormGroupResults[$formId] = $score;
            }
            $maxScore += $data->getPeaceful();

            $this->submissionRepository->save($data);

            foreach ($weightedFormGroupResults as $formId => $score) {
                $entity = new SubmissionResult();
                $entity->setSubmission($data)->setForm($this->entityManager->getReference(Form::class, $formId))
                    ->setResult((int)round($score / $maxScore  * 100));
                $this->submissionResultRepository->save($entity);
            }
            $this->entityManager->flush();

            return $data;
        }
    }

    private function calculateClassgroupSummaryGrades(array &$formGroups): void
    {
        foreach ($formGroups as $formGroupId => $subjectArray) {
            foreach ($subjectArray as $subject => $gradeArray) {
                //TODO: we should introduce non-integers, to get proper grade, aka 8.3 or 7.6
                $grade = array_keys($gradeArray, max($gradeArray), true)[0];
                $formGroups[$formGroupId][$subject] = $grade;
            }
        }
    }

    private function calculateRespondentGradeCoefficients(
        Respondent $respondent,
        int|string $subject,
        array      &$formGroups
    ): void
    {
        $getter = 'get' . ucfirst($subject);
        $formGroupId = $respondent->getForm()?->getId();
        $grade = $respondent->{$getter}();
        //summarize grade coefficients, grouped by school - formLetter - subject - grades
        //each grade will have summarized coefficient, so that the grade with largest coefficient
        //will be used as final grade for subject
        if (empty($formGroups[$formGroupId][$subject][$grade])) {
            $formGroups[$formGroupId][$subject][$grade] = 1 / $respondent->getDifference();
        } else {
            $formGroups[$formGroupId][$subject][$grade] += 1 / $respondent->getDifference();
        }
    }

    private function calculateWeightedFormGroupScore(Submission $data, array $subjects): int
    {
        $score = 0;
        foreach ($subjects as $subject => $formSummaryGrade) {
            $getter = 'get' . ucfirst($subject);
            $score += ($formSummaryGrade * $data->$getter());
        }
        return $score;
    }
}
