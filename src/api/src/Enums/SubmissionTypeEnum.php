<?php declare(strict_types = 1);

namespace App\Enums;

enum SubmissionTypeEnum: string
{
    case Form6th = self::TYPE_FORM_6TH;
    case Form9th = self::TYPE_FORM_9TH;
    protected const TYPE_FORM_6TH = 'FORM_6TH';
    protected const TYPE_FORM_9TH = 'FORM_9TH';
}
