<?php

namespace App\Services\Quiz;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Quiz\Question\CreateQuestionActionData;
use App\ActionData\Quiz\Question\ImportQuestionFileActionData;
use App\DataObjects\Quiz\Question\QuestionData;
use App\Enums\QuestionEnum;
use App\Imports\Question\QuestionImport;
use App\Models\AnswerModel;
use App\Models\QuestionModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class QuestionService
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $topicId, int $page = 1, int $limit = 15, ?iterable $filters = []): DataObjectCollection
    {
        $model = QuestionModel::applyEloquentFilters($filters)
            ->withCount('answers')
            ->where('topic_id', '=', $topicId)
            ->orderBy('questions.id', 'desc');

        $totalCount = $model->count();
        $skip = $limit * ($page - 1);
        $items = $model->skip($skip)->take($limit)->get();
        $items->transform(function (QuestionModel $question) {
            return QuestionData::createFromEloquentModel($question);
        });
        return new DataObjectCollection($items, $totalCount, $limit, $page);
    }

    /**
     * @param CreateQuestionActionData $actionData
     * @return QuestionData
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createQuestion(CreateQuestionActionData $actionData): void
    {
//        $actionData->addValidationRules([
//            'name.uz' => 'required|string|unique:questions,name->uz',
//            'name.ru' => 'required|string|unique:questions,name->ru'
//        ]);
//        $actionData->validateException();
        $answers = [];
        if ($actionData->type !== QuestionEnum::TYPE_PRACTICAL->value) {
            $isCorrect = false;
            $date = date("Y-m-d H:i:s");
            foreach ($actionData->answer as $answer) {
                if (isset($answer['is_correct'])) {
                    $isCorrect = true;
                }
                $items['content'] = $answer['content'];
                $items['is_correct'] = isset($answer['is_correct']);
                $items['created_at'] = $date;
                $answers[] = $items;
            }
            if (!$isCorrect) {
                throw ValidationException::withMessages([
                    "type" => trans("quiz.questions.type.error_type")
                ]);
            }
        }
        $question = QuestionModel::query()->create([
            "content" => $actionData->content,
            "type" => $actionData->type,
            "topic_id" => $actionData->topic_id,
            "lang" => $actionData->lang,
            "organization_id" => $actionData->organization_id,
        ]);
        if ($actionData->type !== QuestionEnum::TYPE_PRACTICAL->value) {
            foreach ($answers as &$item) {
                $item['question_id'] = $question->id;
            }
            AnswerModel::query()->insert($answers);
        }
    }

    /**
     * @param CreateQuestionActionData $actionData
     * @param int $id
     * @return QuestionData
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateQuestion(CreateQuestionActionData $actionData, int $id): QuestionData
    {
        if ($actionData->type !== QuestionEnum::TYPE_PRACTICAL->value) {
            $answerId = array_column($actionData->answer, 'id');
            AnswerModel::query()->where('question_id', '=', $id)
                ->whereNotIn('id', $answerId)
                ->delete();
            foreach ($actionData->answer as $newAnswer) {
                if (isset($newAnswer['id'])) {
                    $answer = AnswerModel::query()->find($newAnswer['id']);
                } else {
                    $answer = new AnswerModel();
                }
                $answer->content = $newAnswer['content'];
                $answer->question_id = $id;
                $answer->is_correct = isset($newAnswer['is_correct']);
                $answer->save();
            }
        } else {
            AnswerModel::query()->where('question_id', '=', $id)
                ->delete();
        }

        $question = $this->getQuestion($id);
        $question->content = $actionData->content;
        $question->type = $actionData->type;
        $question->lang = $actionData->lang;
        $question->update();
        return QuestionData::createFromEloquentModel($question);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteQuestion(int $id): void
    {
        $question = $this->getQuestion($id);
        $question->answers()->delete();
        $question->delete();

    }

    /**
     * @param int $id
     * @return Model|QuestionModel|Builder
     */
    public function getQuestion(int $id): Model|QuestionModel|Builder
    {
        return QuestionModel::query()->with('answers')->findOrFail($id);
    }

    /**
     * @param int $id
     * @return QuestionData
     */
    public function edit(int $id): QuestionData
    {
        $question = $this->getQuestion($id);
        return QuestionData::fromModel($question);
    }

    public function import( ImportQuestionFileActionData $actionData, int $topic){
        if ($actionData->has('file') && isset($actionData->file)){
            Excel::import( new QuestionImport($actionData, $topic), $actionData->file);
        }
    }
}
