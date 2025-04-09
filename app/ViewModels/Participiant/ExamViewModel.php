<?php
declare(strict_types=1);

namespace App\ViewModels\Participiant;

use Akbarali\ViewModel\BaseViewModel;
use App\DataObjects\Participant\ParticipantExamAttemptData;
use Carbon\Carbon;

class ExamViewModel extends BaseViewModel
{
    public int $id;
    public string $name;
    public int $attempts_count;
    public string $duration;
    public string $from_date;
    public ?string $fromDate;
    public string $to_date;
    public ?string $toDate;
    public bool $status = false;
    public string $statusName = 'bg-success';
    public bool $statusOriginal = true;
    public int $questions_count = 0;
    public int $is_protected;
    public string $lang;
    public int $show_correct_answers;
    public ?string $created_at;
    public ?array $topics;
    public ?string $updated_at;
    public ?string $departmentName;
    public array|ParticipantExamAttemptData $participantAttempt;

    protected function populate(): void
    {
        $this->questions_count = array_sum(array_column($this->topics, 'questions_count'));
        if ($this->status && count($this->participantAttempt) < $this->attempts_count && date("Y-m-d H:i:s") <= $this->to_date) {
            $this->statusName = "bg-success";
            $this->statusOriginal = true;
        } else {
            $this->statusOriginal = false;
            $this->statusName = "bg-gray-500";
        }
        if (isset($this->department)) {
            $this->departmentName = $this->trans($this->department->name);
        }

        $this->created_at = Carbon::parse($this->created_at)->format('d-m-Y H:i');
        $this->fromDate = Carbon::parse($this->from_date)->format('d-m-Y H:i');
        $this->toDate = Carbon::parse($this->to_date)->format('d-m-Y H:i');
    }
}
