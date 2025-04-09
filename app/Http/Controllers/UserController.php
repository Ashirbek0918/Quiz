<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\User\CreateUserActionData;
use App\ActionData\User\UpdateUserActionData;
use App\ActionData\User\UpdateUserProfileActionData;
use App\DataObjects\User\UserData;
use App\Filters\Users\UsersSearchFilter;
use App\Services\RoleService;
use App\Services\UserService;
use App\ViewModels\Admin\Users\UserProfieViewModel;
use App\ViewModels\Admin\Users\UserViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
        protected RoleService $roleService
    )
    {
        //
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {

        $filters[] = UsersSearchFilter::getRequest($request);
        $users = $this->service->paginate(page: (int)$request->get('page'), limit: (int)$request->get('limit', 10), filters: $filters);

        $roles = $this->roleService->getRoles();

        return (new PaginationViewModel($users, UserViewModel::class))->toView('admin.users.index', compact('roles'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $roles = $this->roleService->getRoles();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * @param CreateUserActionData $actionData
     * @return RedirectResponse
     */
    public function store(CreateUserActionData $actionData): RedirectResponse
    {
        $this->service->createUser($actionData);
        return redirect()->route('users.index')
            ->with('success', trans('form.success_create', ['attribute' => trans('form.users.user')]));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $roles = $this->roleService->getRoles();
        $user = $this->service->getOne($id);
        $viewModel = UserViewModel::fromDataObject(UserData::fromModel($user));
        return $viewModel->toView('admin.users.edit', compact('roles'));
    }

    /**
     * @param UpdateUserActionData $actionData
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(UpdateUserActionData $actionData, int $id): RedirectResponse
    {
        $this->service->updateUser($actionData, $id);
        return redirect()->route('users.index')
            ->with('success', trans('form.success_update', ['attribute' => trans('form.users.user')]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->service->deleteUser($id);
        return redirect()->route('users.index')
            ->with('success', trans('form.success_delete', ['attribute' => trans('form.users.user')]));
    }

    /**
     * @return View
     */
    public function profile(): View
    {
        $viewModel = UserProfieViewModel::fromDataObject($this->service->edit(auth()->id()));
        return $viewModel->toView('admin.users.profile');
    }

    /**
     * @param UpdateUserProfileActionData $actionData
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateProfile(UpdateUserProfileActionData $actionData): RedirectResponse
    {
        $this->service->updateProfile($actionData);
        return redirect()->route('dashboard.index')
            ->with('success', trans('form.success_update', ['attribute' => trans('form.users.user')]));
    }
}
