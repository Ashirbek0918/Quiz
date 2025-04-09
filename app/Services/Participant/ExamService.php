<?php
declare(strict_types=1);

namespace App\Services\Participant;

use Akbarali\DataObject\DataObjectCollection;
use App\DataObjects\Participant\ParticipantExamAttemptData;
use App\DataObjects\Quiz\Exam\ExamData;
use App\DataObjects\Quiz\Question\QuestionData;
use App\Models\ExamModel;
use App\Models\ParticipantExamAttemptModel;
use App\Models\QuestionModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use function App\Helpers\participant;

class ExamService
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectCollection
     */
    public function paginate(int $page = 1, int $limit = 10, ?iterable $filters = []): DataObjectCollection
    {
        $model = ExamModel::applyEloquentFilters($filters)
            ->with( 'participantAttempt')
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
     * @param int $examId
     * @return ExamModel
     */
    public function getOne(int $examId): ExamModel
    {
        return ExamModel::query()->findOrFail($examId);
    }

    public function getOneData(int $examId): ExamData
    {
        return ExamData::fromModel($this->getOne($examId));
    }

    public function getRandQuestions(int $topicId, int $questionsCount): Collection
    {
        return QuestionModel::query()
            ->where('topic_id', '=', $topicId)
//            ->with(['answers' => function ($query) {
//                $query->inRandomOrder();
//            }])
            ->limit($questionsCount)
            ->inRandomOrder()
            ->get();
    }

    public function getQuestions(ExamData $exam): Collection
    {
        $questions = collect();
        foreach ($exam->topics as $item) {
            $questions = $questions->merge($this->getRandQuestions((int)$item["topic_id"], (int)$item['questions_count']));
        }
        return $questions->transform(fn(QuestionModel $questionModel) => QuestionData::fromModel($questionModel));
    }

    public function checkExam(ExamData $exam): bool
    {
        $employeeAttemptCount = ParticipantExamAttemptModel::query()
            ->where('exam_id', '=', $exam->id)
            ->where('participant_id', '=', participant()->id)
            ->count();
        return $exam->attempts_count <= $employeeAttemptCount;
    }
    public function checkExamExpire(ExamData $exam): bool
    {
        if ($exam->to_date < date("Y-m-d H:i:s") || !$exam->status) return true;
        return false;
    }

    public function createNewAttempt(ExamData $exam, int $questionCount, array $questions = []):ParticipantExamAttemptData
    {
        $duration = explode(':', $exam->duration);
        $endTime = Carbon::now()->addHour((int)$duration[0])->addMinute((int)$duration[1])->addSecond((int)$duration[2]);
        $participant_id = (int)participant()->id;
        $participantAttempt = ParticipantExamAttemptData::fromArray([
            "participant_id" =>$participant_id,
            "start_time" => now(),
            "end_time" => $endTime,
            "exam_id" => $exam->id,
            "question_count" => $questionCount,
            "questions" => $questions,
            'attempt_completed' => false,
        ]);
        $newAttempt = ParticipantExamAttemptModel::query()->create($participantAttempt->toArray());
        return ParticipantExamAttemptData::fromModel($newAttempt);
    }
}
