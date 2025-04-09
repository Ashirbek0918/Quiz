<?php
declare(strict_types = 1);
namespace App\ActionData\Quiz\Topic;

use Akbarali\ActionData\ActionDataBase;

class CreateTopicActionData extends ActionDataBase{

    public ?int $id;

    public ?array $name;

    public int $organization_id = 1;

    protected array $rules = [
        'name' => "required|array|max:255",
        'name.*' => "required|string|max:255",
    ];
}
