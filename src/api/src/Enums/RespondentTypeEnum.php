<?php

namespace App\Enums;

enum RespondentTypeEnum: string
{
    protected const TYPE_PUPIL = 'PUPIL';
    protected const TYPE_STUDENT = 'STUDENT';
    protected const TYPE_EMPLOYEE = 'EMPLOYEE';

    case Pupil = self::TYPE_PUPIL;
    case Student = self::TYPE_STUDENT;
    case Employee = self::TYPE_EMPLOYEE;
}