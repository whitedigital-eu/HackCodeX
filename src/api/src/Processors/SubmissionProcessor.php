<?php declare(strict_types = 1);

namespace App\Processors;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Respondent;
use App\Entity\Submission;
use App\Enums\SubmissionTypeEnum;
use App\Repository\RespondentRepository;
use App\Repository\SubmissionRepository;

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
        protected readonly RespondentRepository $respondentRepository,
        protected readonly SubmissionRepository $submissionRepository,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Submission) {
            $formGroups = $submitterScores = [];
            //lets sort submitters most valued subjects
            foreach ($this->subjectAttributes as $subjectAttribute) {
                $getter = 'get' . ucfirst($subjectAttribute);
                $submitterScores[$subjectAttribute] = $data->$getter();
                asort($submitterScores);
            }
            //select required respondents for school/grade groups - sort by most similar respondents
            $respondents = $this->respondentRepository->findRespondentsOrderedByDifference($data);
            foreach ($respondents as $respondentData) {
                /** @var Respondent $respondent */
                $respondent = $respondentData[0];
                $respondent->setDifference($respondentData['difference']);
                foreach (array_keys($submitterScores) as $priority => $subject) {
                    $this->calculateRespondentGradeCoefficients($respondent, $subject, $formGroups);
                }
            }
            //here we get summary grades for each subject of each class group
            $this->calculateClassgroupSummaryGrades($formGroups);
        }

        dump($formGroups);
        exit();
        $this->submissionRepository->save($data);


        return $data;
    }

    private function calculateClassgroupSummaryGrades(array &$formGroups): void
    {
        foreach ($formGroups as $school => $formLetterArray) {
            foreach ($formLetterArray as $formLetter => $subjectArray) {
                foreach ($subjectArray as $subject => $gradeArray) {
                    $grade = array_keys($gradeArray, max($gradeArray), true)[0];
                    $formGroups[$school][$formLetter][$subject] = $grade;
                }
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
        $school = $respondent->getForm()?->getSchool();
        $formLetter = $respondent->getForm()?->getFormLetter();
        $grade = $respondent->{$getter}();
        //summarize grade coefficients, grouped by school - formLetter - subject - grades
        //each grade will have summarized coefficient, so that the grade with largest coefficient
        //will be used as final grade for subject
        if (empty($formGroups[$school][$formLetter][$subject][$grade])) {
            $formGroups[$school][$formLetter][$subject][$grade] = 1/$respondent->getDifference();
        } else {
            $formGroups[$school][$formLetter][$subject][$grade] += 1/$respondent->getDifference();
        }
    }
}
