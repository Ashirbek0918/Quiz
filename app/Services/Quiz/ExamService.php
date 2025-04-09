<?php

namespace App\Services\Quiz;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Quiz\Exam\CreateExamActionData;
use App\DataObjects\Participant\ParticipantExamAttemptData;
use App\DataObjects\Quiz\Exam\ExamData;
use App\DataObjects\Quiz\Question\QuestionData;
use App\Models\ParticipantExamAttemptModel;
use App\Models\ExamModel;
use App\Models\QuestionModel;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use function App\Helpers\participant;

class ExamService
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 15, ?iterable $filters = []): DataObjectCollection
    {
        $model = ExamModel::applyEloquentFilters($filters)
            ->with('participant')
            ->orderBy('exams.id', 'desc');

        $totalCount = $model->count();
        $skip = $limit * ($page - 1);
        $items = $model->skip($skip)->take($limit)->get();
        $items->transform(function (ExamModel $exam) {
            return ExamData::createFromEloquentModel($exam);
        });
        return new DataObjectCollection($items, $totalCount, $limit, $page);
    }

    /**
     * @param CreateExamActionData $actionData
     * @return void
     */
    public function createExam(CreateExamActionData $actionData): void
    {
        $data = $actionData->all();
        ExamModel::query()->create($data);
    }


    /**
     * @param CreateExamActionData $actionData
     * @param int $id
     * @return ExamData
     * @throws ValidationException
     */
    public function updateExam(CreateExamActionData $actionData, int $id): ExamData
    {
        $data = $actionData->all();
        $exam = $this->getExam($id);
        $exam->update($data);
        return ExamData::createFromEloquentModel($exam);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteExam(int $id): void
    {
        $exam = $this->getExam($id);
        $exam->delete();

    }
    public function getOneData(int $examId)
    {
        return ExamData::fromModel($this->getOne($examId));
    }

    public function getOne(int $examId): ExamModel
    {
        return ExamModel::query()->with('participantAttempt')->findOrFail($examId);
    }

    /**
     * @param int $id
     * @return ExamModel
     */
    public function getExam(int $id): ExamModel
    {
        return ExamModel::query()->findOrFail($id);
    }

    /**
     * @param int $id
     * @return ExamData
     */
    public function edit(int $id): ExamData
    {
        $exam = $this->getExam($id);
        return ExamData::fromModel($exam);
    }

    /**
     * @param int $id
     * @return ParticipantExamAttemptData
     */
    public function getOneAttempt(int $id): ParticipantExamAttemptData
    {
        return ParticipantExamAttemptData::fromModel(ParticipantExamAttemptModel::query()->findOrFail($id));
    }

    /**
     * @param array $idS
     * @param int $type
     * @return Collection
     */
    public function getQuestions(array $idS, int $type = 3): Collection
    {
        $questions = QuestionModel::query()
            ->where('type', '=', $type)
            ->whereIn('id', $idS)
            ->get();
        return $questions->transform(fn(QuestionModel $model) => QuestionData::fromModel($model));
    }

    public function getQuestionsById(array $idS): Collection
    {
        $questions = QuestionModel::query()->with(['answers' => function ($query) {
            $query->inRandomOrder();
        }])
            ->whereIn('id', $idS)
            ->get();
        return $questions->transform(fn(QuestionModel $model) => QuestionData::fromModel($model));
    }

    public function checkExam(ExamData $exam): bool
    {
        $participantAttemptCount = ParticipantExamAttemptModel::query()
            ->where('exam_id', '=', $exam->id)
            ->where('participant_id', '=', participant()->id)
            ->count();
        return $exam->attempts_count <= $participantAttemptCount;
    }
    public function checkExamExpire(ExamData $exam): bool
    {
        if ($exam->to_date < date("Y-m-d H:i:s") || !$exam->status) return true;
        return false;
    }

    public function checkAttempt(ParticipantExamAttemptData $attempt, array $checkedAnswers = []): void
    {
        ParticipantExamAttemptModel::query()
            ->where('id', $attempt->id)
            ->update([
                "correct_answers_count" => $attempt->correct_answers_count + count($checkedAnswers),
                "checked_answers" => $checkedAnswers,
                "checked_by" => auth()->id()
            ]);
    }

    public function export()
    {

    }

    public function all(): array
    {
        $exams = [];
        $all = ExamModel::query()->count();
        $active = ExamModel::query()->where("status", "=", 1)
            ->where('from_date', '<', now())
            ->where('to_date', '>', now())
            ->count();
        $exams['all'] = $all;
        $exams['active'] = $active;
        return $exams;
    }
}
