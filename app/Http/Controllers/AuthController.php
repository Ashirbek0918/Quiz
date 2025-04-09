<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Akbarali\ActionData\ActionDataException;
use App\ActionData\User\LoginUserActionData;
use App\Services\AuthService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {

    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        } elseif (auth('participants')->check()) {
            return redirect()->route('participants.dashboard.home');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('dashboard.index')->with('res', [
                'method' => 'success',
                'msg' => trans('messages.auth.success')
            ]);
        }
        try {
            if(!$this->service->login(LoginUserActionData::createFromRequest($request))){
                return redirect()->route('login')->with('res', [
                    'method' => 'error',
                    'msg' => trans('messages.auth.failed')
                ]);
            }
            return to_route('dashboard.index')->with('res', [
                'method' => 'success',
                'msg' => trans('messages.auth.success')
            ]);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * @throws ValidationException
     * @throws ActionDataException
     */
    public function loginParticipant(Request $request): RedirectResponse
    {
        if (auth()->guard('participants')->check()) {
            return redirect()->route('participants.dashboard.home')->with('res', [
                'method' => 'success',
                'msg' => trans('messages.auth.success')
            ]);
        }
        if(!$this->service->loginParticipant(LoginUserActionData::createFromRequest($request))){
            return redirect()->route('login')->with('res', [
                'method' => 'error',
                'msg' => trans('messages.auth.failed')
            ]);
        }

        return to_route('participants.dashboard.home')->with('res', [
            'method' => 'success',
            'msg' => trans('messages.auth.success')
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        return to_route('login')->with('res', [
            'method' => 'success',
            'msg' => trans('messages.auth.logout')
        ]);
    }
}
