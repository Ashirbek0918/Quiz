<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Akbarali\ActionData\ActionDataException;
use Akbarali\ViewModel\PaginationViewModel;
use App\ActionData\Permission\CreatePermissionActionData;
use App\DataObjects\Permission\PermissionData;
use App\Filters\Permissions\PermissionsFilter;
use App\Services\PermissionService;
use App\ViewModels\Admin\Permission\PermissionViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct(protected PermissionService $service)
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filters[] = PermissionsFilter::getRequest($request);
        $collection = $this->service->paginate(page: (int)$request->get('page'), limit: (int)$request->get('limit', 10), filters: $filters);
        return (new PaginationViewModel($collection, PermissionViewModel::class))->toView('admin.permissions.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $viewModel = PermissionViewModel::createEmpty();
        return $viewModel->toView('admin.permissions.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ActionDataException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->service->createPermission(CreatePermissionActionData::createFromRequest($request));
        return redirect()->route('permissions.index')
            ->with('success', trans('form.success_create', ['attribute' => trans('form.permissions.permission')]));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $permission = Permission::query()->findOrFail($id);
        $viewModel = new PermissionViewModel(PermissionData::fromModel($permission));

        return $viewModel->toView('admin.permissions.edit');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ActionDataException
     */
    public function update(Request $request, int $id): RedirectResponse
    {

        $actionDAta = CreatePermissionActionData::fromRequest($request);
        $this->service->updatePermission($actionDAta, $id);
        return redirect()->route('permissions.index')
            ->with('success', trans('form.success_update', ['attribute' => trans('form.permissions.permission')]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->service->deletePermission($id);
        return redirect()->route('permissions.index')
            ->with('success', trans('form.success_delete', ['attribute' => trans('form.permissions.permission')]));
    }
}
