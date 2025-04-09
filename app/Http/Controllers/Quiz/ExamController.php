<?php
declare(strict_types=1);

namespace App\Http\Controllers\Quiz;

use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\Employees\EmployeeExamAttempt\ParticipantAttemptCheckActionData;
use App\ActionData\Quiz\Exam\CreateExamActionData;
use App\Enums\QuestionEnum;
use App\Http\Controllers\Controller;
use App\Services\Participant\ParticipantService;
use App\Services\Quiz\ExamService;
use App\Services\Quiz\TopicService;
use App\ViewModels\Participiant\ParticipantAttemptViewModel;
use App\ViewModels\Participiant\ParticipantExamAttemptViewModel;
use App\ViewModels\Quiz\Exam\ExamViewModel;
use App\ViewModels\Quiz\Topic\TopicViewModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExamController extends Controller
{
    function __construct(
        protected ExamService       $service,
        protected ParticipantService $participantService,
    )
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {

        $filters = [];
        $collection = $this->service->paginate(page: (int)$request->get('page'), limit: (int)$request->get('limit', 10), filters: $filters);
        return (new PaginationViewModel($collection, ExamViewModel::class))->toView('admin.quiz.exams.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.quiz.exams.create');
    }

    /**
     * @param CreateExamActionData $actionData
     * @return RedirectResponse
     */
    public function store(CreateExamActionData $actionData): RedirectResponse
    {
        $this->service->createExam($actionData);
        return redirect()->route('exams.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_create', ['attribute' => trans('quiz.quiz')]),
        ]);
    }

    public function edit(int $id): View
    {
        $data = $this->service->edit($id);
        $viewModel = new ExamViewModel($data);


        $topics = (new TopicService())->getAll($data->lang);
        $topics->transform(fn($topic) => TopicViewModel::fromDataObject($topic));
        return $viewModel->toView('admin.quiz.exams.edit', compact( 'topics'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function show(Request $request, int $id): View
    {
        $exam = $this->service->edit($id);


        $topics = (new TopicService())->getAll($exam->lang);
        $topics->transform(fn($topic) => TopicViewModel::fromDataObject($topic));

        $employees = $this->participantService
            ->paginateParticipant(examId: $id,  page: (int)$request->get('page', 1), limit: (int)$request->get('limit', 10));
        return (new PaginationViewModel($employees, ParticipantExamAttemptViewModel::class))
            ->toView('admin.quiz.exams.show', compact( 'topics', 'exam'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function showAttempt(int $id): View
    {
        $attempt = $this->service->getOneAttempt($id);
        $questions = $this->service->getQuestions($attempt->questions, QuestionEnum::TYPE_PRACTICAL->value);

        $viewModel = ParticipantAttemptViewModel::fromDataObject($attempt);
        return $viewModel->toView('admin.quiz.exams.attempts', compact('questions'));
    }

    /**
     * @param ParticipantAttemptCheckActionData $actionData
     * @param int $attemptId
     * @return RedirectResponse
     */
    public function checkAttempt(ParticipantAttemptCheckActionData $actionData, int $attemptId): RedirectResponse
    {
        $attempt = $this->service->getOneAttempt($attemptId);
        if ($attempt->checked_by) {
            return redirect()->route('exams.show', [$attempt->exam_id])->with('res', [
                'method' => 'info',
                'msg' => trans('quiz.already_evaluation'),
            ]);
        }
        $this->service->checkAttempt($attempt, $actionData->checked_answers);
        return redirect()->route('exams.show', [$attempt->exam_id]);
    }

    /**
     * @param CreateExamActionData $actionData
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(CreateExamActionData $actionData, int $id): RedirectResponse
    {
        $this->service->updateExam($actionData, $id);
        return redirect()->route('exams.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_update', ['attribute' => trans('quiz.quiz')]),
        ]);
    }


    public function delete(int $id): RedirectResponse
    {
        $this->service->deleteExam($id);
        return redirect()->route('exams.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_delete', ['attribute' => trans('quiz.quiz')]),
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return BinaryFileResponse
     */

    public function result(int $id):View
    {
        $attempt = $this->service->getOneAttempt($id);
        $questions = $this->service->getQuestionsById($attempt->questions);
        $viewModel = ParticipantExamAttemptViewModel::fromDataObject($attempt);
        return  $viewModel->toView('admin.quiz.exams.result', compact( 'questions'));
    }
}
