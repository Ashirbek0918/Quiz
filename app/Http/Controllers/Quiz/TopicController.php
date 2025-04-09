<?php

namespace App\Http\Controllers\Quiz;

use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\Quiz\Question\CreateQuestionActionData;
use App\ActionData\Quiz\Question\ImportQuestionFileActionData;
use App\ActionData\Quiz\Topic\CreateTopicActionData;
use App\Enums\QuestionEnum;
use App\Filters\Question\QuestionFilter;
use App\Http\Controllers\Controller;
use App\Services\Quiz\QuestionService;
use App\Services\Quiz\TopicService;
use App\ViewModels\Quiz\Question\QuestionViewModel;
use App\ViewModels\Quiz\Topic\TopicViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TopicController extends Controller
{
    function __construct(
        protected TopicService    $service,
        protected QuestionService $questionService
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
        $collection = $this->service->paginate(page: (int)$request->get('page'), filters: $filters);
        return (new PaginationViewModel($collection, TopicViewModel::class))->toView('admin.quiz.topics.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.quiz.topics.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(CreateTopicActionData $actionData): RedirectResponse
    {
        $this->service->createTopic($actionData);
        return redirect()->route('topics.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_create', ['attribute' => trans('quiz.topics.topic')]),
        ]);
    }

    public function edit(int $id): View
    {
        $data = $this->service->edit($id);
        $viewModel = new TopicViewModel($data);
        return $viewModel->toView('admin.quiz.topics.edit');
    }

    /**
     * @param CreateTopicActionData $actionData
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(CreateTopicActionData $actionData, int $id): RedirectResponse
    {
        $this->service->updateTopic($actionData, $id);
        return redirect()->route('topics.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_update', ['attribute' => trans('quiz.topics.topic')]),
        ]);
    }


    public function delete(int $id): RedirectResponse
    {
        $this->service->deleteTopic($id);
        return redirect()->route('topics.index')->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_delete', ['attribute' => trans('quiz.topics.topic')]),
        ]);
    }

    public function getAll(string $lang):View
    {
        $topics = $this->service->getAll($lang);
        $topics->transform(fn($topic) => TopicViewModel::fromDataObject($topic));
//        dd($topics);
        return view('admin.quiz.topics.all', compact('topics'));
    }


    /**
     * @param Request $request
     * @return View
     */
    public function getQuestions(Request $request, int $topic): View
    {
        $filters = [];
        $filters[] = QuestionFilter::getRequest($request);
        $collection = $this->questionService->paginate(topicId: $topic, page: (int)$request->get('page'), filters: $filters);
        $types = QuestionEnum::getTypesTranslate();
        return (new PaginationViewModel($collection, QuestionViewModel::class))
            ->toView('admin.quiz.questions.index', compact('topic', 'types'));
    }

    /**
     * @return View
     */
    public function createQuestion(int $topic): View
    {
        $this->service->getTopic($topic);
        $types = QuestionEnum::getTypesTranslate();
        return view('admin.quiz.questions.create', compact('topic', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function storeQuestion(CreateQuestionActionData $actionData, int $topic): RedirectResponse
    {
        $this->service->getTopic($topic);
        $this->questionService->createQuestion($actionData);
        return redirect()->route('questions.index', [$topic])->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_create', ['attribute' => trans('quiz.questions.question')]),
        ]);
    }

    public function editQuestion(int $topic, int $id): View
    {
        $this->service->getTopic($topic);
        $data = $this->questionService->edit($id);
        $types = QuestionEnum::getTypesTranslate();
        $viewModel = QuestionViewModel::fromDataObject($data);
        return $viewModel->toView('admin.quiz.questions.edit', compact('topic', 'types'));
    }

    /**
     * @param CreateQuestionActionData $actionData
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateQuestion(CreateQuestionActionData $actionData, int $topic, int $id): RedirectResponse
    {
        $this->service->getTopic($topic);
        $this->questionService->updateQuestion($actionData, $id);
        return redirect()->route('questions.index', [$topic])->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_update', ['attribute' => trans('quiz.questions.question')]),
        ]);
    }


    public function deleteQuestion(int $topic, int $id): RedirectResponse
    {
        $this->service->getTopic($topic);
        $this->questionService->deleteQuestion($id);
        return redirect()->route('questions.index', [$topic])->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_delete', ['attribute' => trans('quiz.questions.question')]),
        ]);
    }

    public function import(ImportQuestionFileActionData $actionData , int $topic):RedirectResponse
    {
//        dd($actionData->all());
        $this->questionService->import($actionData, $topic);
        return redirect()->route('questions.index', [$topic])->with('res', [
            'method' => 'success',
            'msg' => trans('form.success_upload', ['attribute' => trans('quiz.questions.question')]),
        ]);
    }
}
