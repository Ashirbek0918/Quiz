<?php
declare(strict_types=1);
namespace App\ViewModels\Quiz\Topic;

use Akbarali\ViewModel\BaseViewModel;
use Carbon\Carbon;

class TopicViewModel extends BaseViewModel
{
    public int $id;

    public array $name;
    public ?string $hname;
    public ?string $name_uz;
    public ?string $name_ru;
    public int $questions_count = 0;
    public ?string $created_at;
    protected function populate():void
    {
        $this->hname = $this->trans($this->name);
        $this->name_ru = $this->trans($this->name, 'ru');
        $this->name_uz = $this->trans($this->name, 'uz');
        $this->created_at = Carbon::parse($this->created_at)->format('d-m-y H:i');
    }
}
