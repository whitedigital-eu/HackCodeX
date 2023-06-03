<?php declare(strict_types = 1);

namespace App\Enums;

enum RespondentTypeEnum: string
{
    case Pupil = self::TYPE_PUPIL;
    case Student = self::TYPE_STUDENT;
    case Employee = self::TYPE_EMPLOYEE;
    protected const TYPE_PUPIL = 'PUPIL';
    protected const TYPE_STUDENT = 'STUDENT';
    protected const TYPE_EMPLOYEE = 'EMPLOYEE';
}
