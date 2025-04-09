<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Akbarali\ActionData\ActionDataException;
use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\Role\CreateRoleActionData;
use App\Filters\Role\RolesFilter;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\ViewModels\Admin\Role\RoleViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{

    public function __construct(protected RoleService $service)
    {

    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filters [] = RolesFilter::getRequest($request);
        $collection = $this->service->paginate(page: (int)$request->get('page'), limit: (int)$request->get('limit', 10), filters: $filters);

        return (new PaginationViewModel($collection, RoleViewModel::class))->toView('admin.roles.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $viewModel = RoleViewModel::createEmpty();
        $permissions = (new PermissionService())->getPermissions();
        return $viewModel->toView('admin.roles.create', compact('permissions'));

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ActionDataException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->service->createRole(CreateRoleActionData::createFromRequest($request));
        return redirect()->route('roles.index')
            ->with('success', trans('form.success_create', ['attribute' => trans('form.roles.role')]));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $role = $this->service->getRole($id);
        $viewModel = new RoleViewModel($role);
        $permissions = (new PermissionService())->getPermissions();
        return $viewModel->toView('admin.roles.edit', compact('permissions'));

    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ActionDataException
     * @throws ValidationException
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $actionData = CreateRoleActionData::createFromRequest($request);
        $this->service->updateRole($actionData, $id);
        return redirect()->route('roles.index')
            ->with('success', trans('form.success_update', ['attribute' => trans('form.roles.role')]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->service->deleteRole($id);
        return redirect()->route('roles.index')
            ->with('success', trans('form.success_delete', ['attribute' => trans('form.roles.role')]));
    }

}
