<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {



        // Password::sendResetLink($credentials);
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', "message" => $validation->messages()]);
        }
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['status' => 'success', "message" => 'Reset password link sent on your email id.']);
    }


    public function reset(Request $request)
    {
        
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);


        if ($validation->fails()) {
            return response()->json(['status' => 'error', "message" => $validation->messages()]);
        }
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['status' => 'error', "message" => 'Invalid token!']);

        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return response()->json(['status' => 'success', "message" => 'Your password has been changed!']);

    }
}
