<?php
declare(strict_types=1);
namespace App\DataObjects\Quiz\Question;
use Akbarali\DataObject\DataObjectBase;
use App\DataObjects\Answer\AnswerData;

class QuestionData extends DataObjectBase
{
    public int $id;
    public string  $content;
    public int  $type;
    public string  $lang;
    public int  $topic_id;
    public ?string $created_at;
    public array|AnswerData $answers = [];
    public ?int $answers_count;
}
