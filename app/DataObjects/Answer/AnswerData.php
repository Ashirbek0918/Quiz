<?php
declare(strict_types=1);
namespace App\DataObjects\Answer;
use Akbarali\DataObject\DataObjectBase;

class AnswerData extends DataObjectBase
{
    public int $id;
    public string  $content;
    public int  $question_id;
    public bool  $is_correct;
    public ?string $created_at;
}
