<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail; 
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Str;
use App\Mail\TokenMail;
use App\Mail\CodeMail;
use App\Mail\TokenLMail;
use App\Models\Token;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('login');
    }
    
    public  function regsiterindex(){
        return view('register');
    }
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'role' => 'required|in:1,2',
            'password' => 'required|string',
        ]);
    
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $code = Str::random(6);
        Mail::to($user->email)->send(new CodeMail($code, $user));
        
        session(['verification_code' => $code, 'user_data' => $user]);
    
        return redirect()->route('verify.code')->with('message', 'Verification code sent. Please enter it to complete registration.');
    }
    public function verifyCode(Request $request){
        $request->validate([
            'verification_code' => 'required|string|max:6',
        ]);
        if($request->verification_code === session('verification_code')){
            $user = session('user_data');
            $user->save();
            session()->forget(['verification_code', 'user_data']);
            return redirect()->route('login')->with('success', 'Account verified successfully. You can now log in.');
        }else{
            return redirect()->back()->withErrors('Invalid verification code. Please try again.');
        }
        }   
    
    public function login(Request $request){
        $request->validate([
            'email_or_username' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email_or_username)
                    ->orWhere('username', $request->email_or_username)
                    ->first();

    if ($user && Hash::check($request->password, $user->password)) {
        if (Carbon::parse($user->token_generated_at)->diffInDays(now()) >= 30) {
            $token = Token::generateToken($user->id);
            $user->token_generated_at = now();
            $user->save();
            Mail::to($user->email)->send(new TokenLMail($user, $token));
        }
        

            Auth::login(user: $user);
            Session::put('user', $user);    
            return redirect()->route('home')->with('message', 'Login successful. Your token has been sent to your email.');
        } else {
            return back()->withErrors(['email_or_username' => 'Invalid login details']);
        }
    }

    
    
    public function logout(Request $request){
        Auth::logout();    
        return redirect()->route('login')->with('message', 'Logged out successfully');
    }

    public function edit(){
        return view('edit');
    }
    public function update($id, Request $request) {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role' => 'required|in:1,2',
            'password' => 'nullable|string',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->route('home')->with('success', 'Account updated successfully.');
    }
    public function verifyToken(Request $request)
    {
        $request->validate([
            'api_token' => 'required|string',
        ]);
    
        try {
            $user = JWTAuth::setToken($request->api_token)->authenticate();
            
            if ($user) {
                session(['token_valid' => true, 'user_token' => $request->api_token]);
                return redirect()->route('apis.index')->with('message', 'Token verified successfully.');
            }
        } catch (TokenExpiredException $e) {
            return redirect()->back()->withErrors(['api_token' => 'Token has expired.']);
        } catch (TokenInvalidException $e) {
            return redirect()->back()->withErrors(['api_token' => 'Token is invalid.']);
        } catch (JWTException $e) {
            return redirect()->back()->withErrors(['api_token' => 'Could not decode token.']);
        }
    
        return redirect()->back()->withErrors(['api_token' => 'Token is invalid or not found.']);
    }

    
    public function sendToken(Request $request)
    {
        try {
            if (!$request->user()) {
                return redirect()->route('login')->withErrors(['message' => 'You need to login first.']);
            }
    
            $user = $request->user();
    
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
    
            Session::put('jwt_token', $token);
    
            Mail::to($user->email)->send(new TokenMail($user, $token));
    
            return redirect()->back()->with('message', 'Token sent to your email successfully.');
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }
    
    
    
}
