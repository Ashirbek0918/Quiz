<?php

namespace App\Services\Quiz;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Quiz\Topic\CreateTopicActionData;
use App\DataObjects\Quiz\Topic\TopicData;
use App\Models\TopicModel;
use Illuminate\Support\Collection;

class TopicService
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 15, ?iterable $filters = []): DataObjectCollection
    {
        $model = TopicModel::applyEloquentFilters($filters)
            ->withCount('questions')
            ->orderBy('topics.id', 'desc');

        $totalCount = $model->count();
        $skip = $limit * ($page - 1);
        $items = $model->skip($skip)->take($limit)->get();
        $items->transform(function (TopicModel $topic) {
            return TopicData::createFromEloquentModel($topic);
        });
        return new DataObjectCollection($items, $totalCount, $limit, $page);
    }

    /**
     * @param CreateTopicActionData $actionData
     * @return TopicData
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createTopic(CreateTopicActionData $actionData): void
    {
        $actionData->addValidationRules([
            'name.uz' => 'required|string|unique:topics,name->uz',
            'name.ru' => 'required|string|unique:topics,name->ru'
        ]);
        $actionData->validateException();
        $data = $actionData->all();
        TopicModel::query()->create($data);
    }


    /**
     * @param CreateTopicActionData $actionData
     * @param int $id
     * @return TopicData
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateTopic(CreateTopicActionData $actionData, int $id): TopicData
    {
        $actionData->addValidationRules([
            'name.uz' => 'required|string|unique:topics,name->uz' . $id,
            'name.ru' => 'required|string|unique:topics,name->ru' . $id
        ]);
        $actionData->validateException();
        $data = $actionData->all();
        $topic = $this->getTopic($id);
        $topic->update($data);
        return TopicData::createFromEloquentModel($topic);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteTopic(int $id): void
    {
        $topic = $this->getTopic($id);
        $topic->delete();

    }

    public function getAll(string $lang): Collection|TopicModel
    {
        $topics = TopicModel::query()
            ->withCount(['questions' => function($query) use ($lang){
                $query->where('lang', '=', $lang);
            }])
//            ->where('lang', $lang)
            ->get();
        return $topics->transform(fn($topic) => TopicData::fromModel($topic));
    }

    /**
     * @param int $id
     * @return TopicModel
     */
    public function getTopic(int $id): TopicModel
    {
        return TopicModel::query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return TopicData
     */
    public function edit(int $id): TopicData
    {
        $topic = $this->getTopic($id);
        return TopicData::fromModel($topic);
    }
}
