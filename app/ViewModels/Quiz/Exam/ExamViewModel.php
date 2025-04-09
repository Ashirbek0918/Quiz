<?php
declare(strict_types=1);
namespace App\ViewModels\Quiz\Exam;

use Akbarali\ViewModel\BaseViewModel;
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
    public int $is_protected;
    public string $lang;
    public int $show_correct_answers;
    public ?string $created_at;
    public ?array $topics;
    public ?string $updated_at;
//    public ?DepartmentData $department;
    public ?string $departmentName;
    protected function populate():void
    {
//        if (isset($this->department)){
//            $this->departmentName = $this->trans($this->department->name);
//        }
//        $this->hname = $this->trans($this->name);
//        $this->name_ru = $this->trans($this->name, 'ru');
//        $this->name_uz = $this->trans($this->name, 'uz');
        $this->created_at = Carbon::parse($this->created_at)->format('d-m-y H:i');
        $this->fromDate = Carbon::parse($this->from_date)->format('d-m-y H:i');
        $this->toDate = Carbon::parse($this->to_date)->format('d-m-y H:i');
    }
}
