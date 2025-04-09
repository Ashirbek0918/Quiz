<?php
declare(strict_types = 1);
namespace App\ActionData\Quiz\Exam;

use Akbarali\ActionData\ActionDataBase;

class CreateExamActionData extends ActionDataBase{


    public ?string $name;
    public ?int $attempts_count;
    public ?string $duration;
    public ?string $from_date;
    public ?string $to_date;
    public ?bool $status = false;
    public ?int $is_protected = 0;
    public ?string $lang;
    public ?int $show_correct_answers;
    public ?array $topics = [];

    protected array $rules = [
        'name' => "required|string",
        'attempts_count' => "required|min:1",
        'duration' => "required|date_format:H:i:s",
        'from_date' => "required|date",
        'to_date' => "required|date|after:from_date",
        'status' => "nullable|bool",
        'lang' => "required|in:ru,uz",
        'topics' => "required|array",
        'topics.*.topic_id' => "required|exists:topics,id",
    ];
}
