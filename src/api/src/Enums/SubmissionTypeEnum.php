<?php

namespace App\Enums;

enum SubmissionTypeEnum: string
{
    protected const TYPE_FORM_6TH = 'FORM_6TH';
    protected const TYPE_FORM_9TH = 'FORM_9TH';

    case Form6th = self::TYPE_FORM_6TH;
    case Form9th = self::TYPE_FORM_9TH;
}