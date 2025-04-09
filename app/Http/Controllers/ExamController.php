<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\ParticipantExamAttempt\ParticipantFinishAttemptActionData;
use App\Filters\Exam\ExamFilter;
use App\Services\Participant\ExamService;
use App\Services\Participant\ParticipantAttemptService;
use App\ViewModels\Participiant\ExamViewModel;
use App\ViewModels\Participiant\ParticipantExamAttemptViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    function __construct(
        protected ExamService $service,
        protected ParticipantAttemptService $participantExamAttemptService,
    )
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->has("session")){
            session()->flash("res", [
                "method" => "success",
                "msg" => $request->get("session"),
            ]);
        }

        $filters[] = ExamFilter::getRequest($request);
        $collection = $this->service->paginate(page: (int)$request->get('page'), filters: $filters);
        return (new PaginationViewModel($collection, ExamViewModel::class))->toView('participants.quiz.exams.index');
    }

    public function showExam(int $examId):View
    {
        $exam = $this->service->getOneData($examId);
        $attempts = $this->participantExamAttemptService->getAttempts($exam->id)->transform(fn($attempt) => ParticipantExamAttemptViewModel::fromDataObject($attempt));
        $viewModel = ExamViewModel::fromDataObject($exam);
        return $viewModel->toView('participants.quiz.exams.exam_show', compact('attempts'));
    }

    public function startTest(int $examId): RedirectResponse
    {
        $exam = $this->service->getOneData($examId);
        if ($this->service->checkExam($exam)) {
            return redirect()->route("participants.exams.showExam", [$exam->id])->with('res', [
                'method' => 'error',
                'msg' => __('quiz.participants.no_attempt'),
            ]);
        }
        if ($this->service->checkExamExpire($exam)){
            return redirect()->route("participants.exams.showExam", [$exam->id])->with('res', [
                'method' => 'error',
                'msg' => __('quiz.participants.exam_expire'),
            ]);
        }
        $questions = $this->service->getQuestions($exam);
        $newAttempt = $this->service->createNewAttempt($exam, $questions->count(), $questions->pluck('id')->toArray());
        return redirect()->route("participants.exams.getAttempt", [$newAttempt->id]);
    }

    public function getAttempt(int $attemptId): View|RedirectResponse
    {
        $attempt = $this->participantExamAttemptService->getOneAttemptData($attemptId);
        if (!$this->participantExamAttemptService->checkAttempt($attempt)) {
            return redirect()->route("participants.exams.showExam", [$attempt->exam_id])->with('res', [
                'method' => 'error',
                'msg' => __('quiz.participant.test_time_is_over') ,
            ]);
        }
        $exam = $this->service->getOneData($attempt->exam_id);
        $questions = $this->participantExamAttemptService->getQuestions($attempt->questions);
        $viewModel = ParticipantExamAttemptViewModel::fromDataObject($attempt);

        return $viewModel->toView('participants.quiz.exams.start_exam', compact('questions', 'exam'));
    }

    public function finishAttempt(ParticipantFinishAttemptActionData $actionData, int $attemptId):RedirectResponse
    {
        $attempt = $this->participantExamAttemptService->getOneAttemptData($attemptId);
        $method = "success";
        $msg = __('quiz.participant.test_finish');
        if (!$this->participantExamAttemptService->checkAttempt($attempt)) {
            $method = "error";
            $msg = __('quiz.participant.test_time_is_over');
        }
        $this->participantExamAttemptService->checkAnswers($attempt, $actionData->answers);
        return redirect()->route("participants.exams.showExam", [$attempt->exam_id])->with('res', [
            'method' => $method,
            'msg' => $msg,
        ]);
    }

}
