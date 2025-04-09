<?php
declare(strict_types=1);
namespace App\ViewModels\Quiz\Question;

use Akbarali\ViewModel\BaseViewModel;
use App\Enums\QuestionEnum;
use Carbon\Carbon;

class QuestionViewModel extends BaseViewModel
{
    public int $id;
    public string  $content;
    public int  $type;
    public ?string  $typeName = '';
    public string  $lang;
    public int  $topic_id;
    public ?string $created_at;
    public array $answers = [];
    public ?int $answers_count = 0;
    protected function populate():void
    {
        $this->typeName = QuestionEnum::getTypeTranslate($this->type);
        $this->created_at = Carbon::parse($this->created_at)->format('d-m-y H:i');
    }
}
