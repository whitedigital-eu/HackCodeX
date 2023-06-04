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
            $respondents = $this->respondentRepository->findRespondentsOrderedBySimilar($data);
            /** @var Respondent $respondent */
            foreach ($respondents as $respondent) {
                foreach (array_keys($submitterScores) as $priority => $subject) {
                    $getter = 'get' . ucfirst($subject);
                    $school = $respondent->getForm()?->getSchool();
                    $formLetter = $respondent->getForm()?->getFormLetter();
                    $grade = $respondent->{$getter}();
                    //summarize grade coefficients, grouped by school - formLetter - subject - grades
                    //each grade will have summarized coefficient, so that the grade with largest coefficient
                    //will be used as final grade for subject
                    if (empty($formGroups[$school][$formLetter][$subject][$grade])) {
                        $formGroups[$school][$formLetter][$subject][$grade] = 3;
                    } else {
                        $formGroups[$school][$formLetter][$subject][$grade] += 4;
                    }
                }
            }

            //here we get summary grades for each subject of each class group
            $this->calculateSummaryGrades($formGroups);
        }
        $this->submissionRepository->save($data);

        return $data;
    }

    private function calculateSummaryGrades(array &$formGroups): void
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
}
