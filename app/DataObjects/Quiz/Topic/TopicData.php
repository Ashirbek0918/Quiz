<?php
declare(strict_types=1);
namespace App\DataObjects\Quiz\Topic;
use Akbarali\DataObject\DataObjectBase;

class TopicData extends DataObjectBase
{
    public int $id;
    public ?array  $name;
    public int $questions_count = 0;

    public ?string $created_at;
}
