<?php
declare(strict_types = 1);
namespace App\ActionData\Quiz\Question;

use Akbarali\ActionData\ActionDataBase;
use App\Enums\QuestionEnum;
use Illuminate\Validation\Rule;

class CreateQuestionActionData extends ActionDataBase{

    public ?string $content;
    public ?int $type;
    public ?string $lang;
    public ?array $answer;
    public ?int $topic_id;
    public int $organization_id = 1;

    public function prepare():void
    {
        $this->rules = [
            'content' => "required",
            'type' => "required|in:1,2,3",
            'lang' => "required|in:uz,ru",
            'topic_id' => "required",
            'answer' => "nullable|array",
            'answer.*.content' => [
                Rule::requiredIf(function (){
                    if ($this->type !== QuestionEnum::TYPE_PRACTICAL->value){
                        return true;
                    }
                    return false;
                }),
                ],
            'answer.*.is_correct' => "nullable|boolean",
        ];

    }
}
