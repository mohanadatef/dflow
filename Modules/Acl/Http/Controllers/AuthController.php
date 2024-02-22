<?php

namespace Modules\Acl\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Modules\Acl\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('acl::auth.login');
    }

    public function resetPasswordForm()
    {
        return view('acl::auth.reset_password');
    }

    /**
     * Display a listing of the resource.
     */
    public function resetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)]);
    }

    /**
     * Show the form for creating a new resource.
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            Cache::put('competitive_start_' . user()->id, null);
            Cache::put('competitive_end_' . user()->id, null);
            Cache::put('market_start_' . user()->id, null);
            Cache::put('market_end_' . user()->id, null);;
            $request->session()->regenerate();
            user()->update(['session'=>$request->session()->token()]);
            if(permissionShow('admin_dashboard_users'))
            {
                return redirect(route('admin.dashboard'));
            }
            if(permissionShow('show_researcher_dashboard_users'))
            {
                return redirect(route('researcher_dashboard.researcherDashboard'));
            }
            return redirect(route('home'));
        }
        return redirect(route('auth.login.form'))->with(['message_false' => 'username or password is wrong']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id)
    {
        return view('acl::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('acl::edit');
    }

    public function logout(Request $request)
    {
        if(user())
        {
            Cache::put('user_' . user()->id, false);
            Cache::put('competitive_start_' . user()->id, null);
            Cache::put('competitive_end_' . user()->id, null);
            Cache::put('market_start_' . user()->id, null);
            Cache::put('market_end_' . user()->id, null);
            User::where('id', user()->id)->update([
                'is_login' => 0,
                'last_seen_at' => null,
            ]);
        }
        Auth::logout();
        return redirect('/login');
    }

    public function showResetPasswordForm($token)
    {
        return view('acl::auth.new_password', [
                'email' => request()->all()['email'],
                'token' => $token
            ]
        );
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();
        $user = User::where('email', $request->email)->first();
        $status = Password::tokenExists($user, $request->token);
        if(!$status)
        {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
