<?php

namespace App\Services\Participant;

use App\DataObjects\Participant\ParticipantExamAttemptData;
use App\DataObjects\Quiz\Question\QuestionData;
use App\Enums\QuestionEnum;
use App\Models\ParticipantExamAttemptModel;
use App\Models\QuestionModel;
use Illuminate\Support\Collection;
use function App\Helpers\participant;

class ParticipantAttemptService
{

    public function getOneAttempt(int $attemptId): ParticipantExamAttemptModel
    {
        return ParticipantExamAttemptModel::query()->where('participant_id', '=', participant()->id)->findOrFail($attemptId);
    }
    public function  getOne(int $id):ParticipantExamAttemptData
    {
        return ParticipantExamAttemptData::fromModel(ParticipantExamAttemptModel::query()->findOrFail($id));
    }

    public function getAttempts(int $examId):Collection
    {
        $attempts = ParticipantExamAttemptModel::query()
            ->where('participant_id', '=', participant()->id)
            ->where('exam_id', '=', $examId)
            ->get();
        return $attempts->transform(fn (ParticipantExamAttemptModel $model) => ParticipantExamAttemptData::fromModel($model));
    }

    public function getOneAttemptData(int $attemptId): ParticipantExamAttemptData
    {
        return ParticipantExamAttemptData::fromModel($this->getOneAttempt($attemptId));
    }

    public function checkAttempt(ParticipantExamAttemptData $attemptData): bool
    {
        $now = date("Y-m-d H:i:s");
        if ($attemptData->attempt_completed) {
            return false;
        }
        return $now >= $attemptData->start_time && $now <= $attemptData->end_time;
    }

    public function getRandQuestions(array $questionId): Collection
    {
        return QuestionModel::query()
            ->whereIn('id', $questionId)
            ->with(['answers' => function ($query) {
                $query->inRandomOrder();
            }])
            ->get();
    }

    public function getQuestions(array $questionId): Collection
    {
        $questions = $this->getRandQuestions($questionId);

        return $questions->transform(fn(QuestionModel $questionModel) => QuestionData::fromModel($questionModel));
    }

    public function checkAnswers(ParticipantExamAttemptData $attemptData, array $answers): void
    {
        $questions = QuestionModel::query()->with(['answers' => function ($query) {
            $query->where('is_correct', '=', true);
        }])
            ->whereIn('id', $attemptData->questions)
            ->get();
        $correctAnswers = 0;
        $practicalAnswers = [];
        $participantAnswers = [];
        $existsPractical = false;
        foreach ($questions as $question) {
            if ($question->type != QuestionEnum::TYPE_PRACTICAL->value){
                if (array_key_exists($question->id, $answers)
                    && !array_diff($question->answers->pluck('id')->toArray(), $answers[$question->id])
                    && !array_diff($answers[$question->id], $question->answers->pluck('id')->toArray())) {
                    $correctAnswers++;
                }
                $participantAnswers[$question->id] = $answers[$question->id];
            }else{
                $existsPractical = true;
                $practicalAnswers[$question->id] = $answers[$question->id];
            }
        }
        ParticipantExamAttemptModel::query()
            ->where('id', $attemptData->id)
            ->update([
                "correct_answers_count" => $correctAnswers,
                "participant_answers" => $participantAnswers,
                "body" => json_encode($practicalAnswers),
                "attempt_completed" => true,
                "exists_practical" => $existsPractical,
                "finished_at" => date("Y-m-d H:i:s"),
            ]);
    }
}
