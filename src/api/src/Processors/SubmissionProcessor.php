<?php

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
    public function __construct(
        protected readonly RespondentRepository $respondentRepository,
        protected readonly SubmissionRepository $submissionRepository
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof Submission) {
            $formGroups = [];
            $pos = 1;
            //check if 6th or 9th form
            if ($data->getType() === SubmissionTypeEnum::Form6th) {
                //select only respondents between 7-9 form
                $respondents = $this->respondentRepository->findRespondentsOrderedBySimilair($data);
                /** @var Respondent $respondent */
                foreach ($respondents as $respondent) {
                    foreach (['languages', 'sport', 'music'] as $subject) {
                        $getter = 'get' . ucfirst($subject);
                        $school = $respondent->getForm()?->getSchool();
                        $formLetter = $respondent->getForm()?->getFormLetter();
                        $grade = $respondent->$getter();
                        if (empty($formGroups[$school][$formLetter][$subject][$grade])) {
                            $formGroups[$school][$formLetter][$subject][$grade] = 3;
                        } else {
                            $formGroups[$school][$formLetter][$subject][$grade] += 4;
                        }
                    }
                }
                $this->calculateSummaryGrades($formGroups);
            }
        }
        $this->submissionRepository->save($data);
        return $data;
    }

    private function calculateSummaryGrades(array &$formGroups): void
    {
        foreach ($formGroups as $school => $formLetterArray) {
            foreach ($formLetterArray as $formLetter => $subjectArray) {
                foreach ($subjectArray as $subject => $gradeArray) {
                    $grade = array_keys($gradeArray, max($gradeArray))[0];
                    $formGroups[$school][$formLetter][$subject] = $grade;
                }
            }
        }
    }
}