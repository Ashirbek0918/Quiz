<?php

namespace App\Enums;
enum QuestionEnum: int
{
    case TYPE_SINGLE = 1;
    case TYPE_MULTIPLE = 2;
    case TYPE_PRACTICAL = 3;

    public static function getTypesTranslate(): array
    {
        return [
            QuestionEnum::TYPE_SINGLE->value => trans('quiz.questions.types.single'),
            QuestionEnum::TYPE_MULTIPLE->value => trans('quiz.questions.types.multiple'),
            QuestionEnum::TYPE_PRACTICAL->value => trans('quiz.questions.types.practical'),
        ];
    }

    public static function getTypeTranslate(int $type): string
    {
        return match ($type) {
            QuestionEnum::TYPE_SINGLE->value => trans('quiz.questions.types.single'),
            QuestionEnum::TYPE_MULTIPLE->value => trans('quiz.questions.types.multiple'),
            QuestionEnum::TYPE_PRACTICAL->value => trans('quiz.questions.types.practical'),
            default => ""
        };
    }
}
