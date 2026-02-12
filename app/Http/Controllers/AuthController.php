<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

    use App\Models\Task;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $token = Str::random(64);

        try {
            $user = User::create([
                'name'               => $request->name,
                'email'              => $request->email,
                'password'           => Hash::make($request->password),
                'is_verified'        => false,
                'verification_token' => $token,
            ]);
        } catch (\Throwable $e) {
            Log::error('[Register] User creation error: '.$e->getMessage());
            return back()->withErrors(['register' => 'Failed to create account; please try again.']);
        }

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');
            $mail->Password   = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = env('MAIL_PORT', 587);
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', config('app.name')));
            $mail->addAddress($request->email, $request->name);
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email';
            $verificationLink = url('/verify-email?token='.$token);
            $mail->Body = "Hello {$request->name},<br><br>Please verify your email:<br><a href=\"{$verificationLink}\">Verify Email</a>";

            if (!$mail->send()) {
                Log::error('[Register] Mail send failed: '.$mail->ErrorInfo);
                return back()->withErrors(['mail' => 'Failed to send verification email.']);
            }
        } catch (Exception $e) {
            Log::error('[Register] Mail exception: '.$e->getMessage());
            return back()->withErrors(['mail' => 'Verification email could not be sent.']);
        }

        return redirect('/login')->with('success', 'Account created! Check your email to verify.');
    }

    public function showVerifyEmailLinkForm()
    {
        return view('verify-email');
    }

    public function verifyEmailLink(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return $this->verificationView('danger', 'No verification token provided.');
        }

        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return $this->verificationView('danger', 'Invalid or expired token.');
        }

        if ($user->is_verified) {
            return $this->verificationView('info', 'Email already verified.');
        }

        $user->update(['is_verified' => true, 'verification_token' => null]);

        return $this->verificationView('success', 'Email verified! You may now log in.');
    }

    private function verificationView(string $status, string $message)
    {
        return view('verify-email', compact('status', 'message'));
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            if (!auth()->user()->is_verified) {
                auth()->logout();
                return back()->withErrors(['email' => 'Please verify your email.']);
            }

            $request->session()->regenerate();
            session()->put('username', auth()->user()->name);

            return redirect(auth()->user()->user_type === 'admin' ? '/admin/dashboard' : '/home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // JWT API METHODS 

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                            'success' => false,
                            'error' => 'unauthorized',
                            'message' => 'Invalid credentials'
                        ], 401);

        }

        if (!auth('api')->user()->is_verified) {
            auth('api')->logout();
            return response()->json(['message' => 'Please verify your email'], 403);
        }

        return $this->respondWithToken($token);
    }

    public function apiLogout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out']);
    }

    public function apiRefresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
    }

    public function apiMe()
    {
        return response()->json(auth('api')->user());
    }

    private function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            'user'         => auth('api')->user()->only('id', 'name', 'email', 'user_type'),
        ]);
    }

    public function webLogout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.form')
            ->with('success', 'Logged out successfully.');
    }


      public function TaskApiController()
     {
        return response()->json(
            Task::select('title', 'description', 'long_description', 'completed')->get()
        );
    }


}
