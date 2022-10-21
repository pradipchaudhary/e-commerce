<?php

namespace App\Http\Controllers\auth;

use App\Helper\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountInfoRequest;
use App\Mail\ApproveUserMail;
use App\Mail\EmailVerificationMail;
use App\Mail\ForgetPasswordMail;
use App\Models\setting\country;
use App\Models\User;
use App\Models\user_detail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->user() != null) {
            $user = (User::query()->where('id', auth()->id())->first())->getRoleNames();
            if ($user->contains(config('CONSTANT.USER_ROLE'))) {
                return redirect()->route('stock_list');
            }
            return redirect()->intended('home');
        } else {
            return view('auth.login');
        }
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::query()
            ->where('email', $credentials['email'])
            ->first();

        if ($user != null) {
            if ($user->load('userDetail')->userDetail == null && !$user->where('id',config('CONSTANT.SUPERADMIN_ID'))->count()) {
                session(['email' => $user->email, 'token' => $user->token]);
                return redirect()->route('account_setup.view');
            }

            if ($user->status == User::STATUS_INACTIVE) {
                Alert::error("your account is under approval");
                return redirect()->route('login');
            }
        }

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            if ($user->hasRole(config('CONSTANT.USER_ROLE'))) {
                return redirect()->route('stock_list');
            }

            return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register()
    {
        if (auth()->user() != null) {
            return redirect()->intended('home');
        } else {
            return view('auth.register');
        }
    }

    public function registerSubmit(Request $request)
    {
        $validate = $request->validate(
            [
                'name' => 'required|unique:users',
                'email' => 'required|unique:users',
                'last_name' => 'required',
                'business_name' => 'required',
                'password' => 'required|confirmed|min:6',
            ]
        );

        DB::beginTransaction();

        try {
            $role = Role::query()
                ->where('name', config('CONSTANT.USER_ROLE'))
                ->first();

            $user = User::create($validate);
            $user->assignRole($role->id);

            $token = getUniqueOTP();
            session(['token' => $token, 'email' => $user->email]);
            Mail::to($user->email)->send(new EmailVerificationMail($user, $token));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }

        return redirect()->route('verify');
    }

    public function verify()
    {
        if (Session::has('token')) {
            return view('auth.verify');
        } else {
            return redirect()->route('login');
        }
    }

    public function verifyEmail(Request $request)
    {
        if ($request->remember_token == session('token')) {
            User::query()
                ->where('email', session('email'))
                ->update(['remember_token' => $request->remember_token]);
            toast('Your email has been verifed . Please enter account detail', 'success');
            return redirect()->route('account_setup.view');
        } else {
            toast('Verification code didnot match', 'error');
        }
        return redirect()->back();
    }

    public function forgetPassword(Request $request)
    {
        if ($request->forget_email == '') {
            Alert::error('Please enter email');
            return redirect()->back();
        }
        $user = User::query()->where('email', $request->forget_email)->first();
        if ($user == null) {
            Alert::error("We don't have an account registered with your email");
            return redirect()->back();
        }
        try {
            Mail::to($user->email)->send(new ForgetPasswordMail($user));
            Alert::success('We just sent an email to ' . $user->email . ' with instructions on how to reset your password.');
        } catch (\Exception $e) {
            Alert::error('Something went wrong...');
        }
        return redirect()->back();
    }

    public function resetPassword($token)
    {
        $user = User::query()->where('remember_token', $token)->first();
        return view('auth.password-reset', ['user' => $user, 'remember_token' => $token]);
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:6']);

        $user = User::query()->where('email', $request->email)->first();
        if ($user == null) {
            Alert::error('something went wrong');
            return redirect()->back();
        } else {
            if ($request->remember_token != $user->remember_token) {
                Alert::error("Session expired");
                return redirect()->back();
            }
        }
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);


        if (
            user_detail::query()
            ->where('user_id')
            ->first() != null
        ) {
            toast('password updated successfully', 'success');
            return redirect('/');
        } else {
            session(['email' => $user->email]);
            toast('password updated successfully', 'success');
            return redirect()->route('account_setup.view');
        }
    }

    public function accountSetup()
    {
        abort_if(!Session::has('email'), 404);
        return view('auth.account-setup', [
            'countries' => country::query()->where('id', 233)->get(),
        ]);
    }

    public function accountSetupSubmit(AccountInfoRequest $request, MediaHelper $mediaHelper): RedirectResponse
    {
        abort_if(!Session::has('email'), 404);
        $user = user::query()->where('email', session('email'))->first();
        abort_if($user == null, 404);
        $document = $mediaHelper->uploadSingleImage($request->document);
        user_detail::create($request->except('document') + ['user_id' => $user->id, 'document' => $document]);
        toast('All infromation updated please wait for admin approval', 'success');
        return redirect()->back();
    }

    // this method for last phase 
    public function approve(User $user)
    {
        try {
            Mail::to($user->email)->send(new ApproveUserMail($user));
            $user->update(['status' => User::STATUS_ACTIVE]);
        } catch (\Exception $e) {
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        toast($user->name . " approved successfully", "success");
        return redirect()->back();
    }

    public function showProfile()
    {
        return view('user.user_profile', [
            'user' => User::query()
                ->where('id', auth()->id())
                ->whereHas('userDetail')
                ->with('userDetail.State', 'userDetail.Country', 'userDetail.City')
                ->first()
        ]);
    }
}
