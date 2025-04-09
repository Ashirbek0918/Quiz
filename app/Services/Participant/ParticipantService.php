<?php

namespace App\Services\Participant;

use Akbarali\DataObject\DataObjectCollection;
use App\ActionData\Participant\CreateParticipantActionData;
use App\DataObjects\Participant\ParticipantData;
use App\DataObjects\Participant\ParticipantWithExamAttemptData;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ParticipantService
{
    public function paginate(int $page = 1, int $limit = 10, ?iterable $filters = null): DataObjectCollection
    {
        $query = Participant::applyEloquentFilters($filters)
            ->orderBy('id', 'desc');
        $total = $query->count();
        $skip = ($page - 1) * $limit;
        $items = $query->skip($skip)->take($limit)->get();

        $items->transform(fn(Participant $employee) => ParticipantData::fromModel($employee));
        return new DataObjectCollection($items, $total, $limit, $page);
    }

    public function createParticipant(CreateParticipantActionData $actionData): ParticipantData
    {
        $data = $actionData->all();
        $employee = Participant::query()->create([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
        return ParticipantData::createFromEloquentModel($employee);
    }

    /**
     * @param CreateParticipantActionData $actionData
     * @param int $id
     * @return ParticipantData
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateParticipant(CreateParticipantActionData $actionData, int $id): ParticipantData
    {
        $actionData->addValidationRule('username', 'unique:participants,username,' . $id);
        $actionData->validateException();
        $participant = $this->getParticipant($id);
        $data = $actionData->all();
        unset($data['password']);
        if ($actionData->password != null && request()->user()->hasPermissionTo('update_password')) {
            $data['password'] = bcrypt($actionData->password);
        }
        $participant->update($data);
        return ParticipantData::createFromEloquentModel($participant);
    }


    /**
     * @param int $id
     * @return void
     */
    public function deleteParticipant(int $id): void
    {
        $participant = $this->getParticipant($id);
        $participant->delete();
    }

    /**
     * @param int $id
     * @return Model|Builder|Participant
     */
    public function getParticipant(int $id): Model|Builder|Participant
    {
        return Participant::query()->findOrFail($id);
    }

    public function edit(int $id): ParticipantData
    {
        return ParticipantData::fromModel($this->getParticipant($id));
    }

    public function getParticipants(array $filters)
    {
        $participants = Participant::applyEloquentFilters($filters)->get();
        return $participants->transform(fn(Participant $participant) => ParticipantData::fromModel($participant));
    }


    public function participantsCount(): int
    {
        return Participant::query()->count();
    }



    public function paginateParticipant(int $examId, int $page = 1, int $limit = 10, ?iterable $filters = null): DataObjectCollection
    {
        $query = Participant::applyEloquentFilters($filters)->with([ 'participantExamAttempts' => function ($query) use ($examId) {
            $query->where('exam_id', '=', $examId)->orderByDesc('correct_answers_count');
        }])->orderBy('id', 'desc');
        $total = $query->count();
        $skip = ($page - 1) * $limit;
        $items = $query->skip($skip)->take($limit)->get();

        $items->transform(fn(Participant $participant) => ParticipantWithExamAttemptData::fromModel($participant));
        return new DataObjectCollection($items, $total, $limit, $page);
    }
}
