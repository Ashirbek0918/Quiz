<?php
declare(strict_types=1);
namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id;
 * @property int $organization_id;
 * @property array $name;
 * @property string $created_at;
 */
class TopicModel extends Model
{
    use HasFactory, EloquentFilterTrait;

    protected $table = 'topics';
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        "name" => "array"
    ];

    public function questions():HasMany
    {
        return $this->hasMany(QuestionModel::class, 'topic_id');
    }
}
