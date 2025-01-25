<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function userRegistration(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'mobile' => 'required|unique:users',
                'password' => 'required|min:6'
            ]);

            User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'mobile' => $validateData['mobile'],
                'password' => Hash::make($validateData['password'])
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User registration successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function userLogin(Request $request)
    {
        // $count = User::where('email', '=', $request->input('email'))
        //     ->where('password', '=', $request->input('password'))
        //     ->select('id')->first();

        $user = User::where('email', '=', $request->input('email'))->firstOr();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = JWTToken::createToken($request->input('email'), $user->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User login successful',
                'token' => $token
            ], 200)->cookie('token', $token, time() + 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'User login failed'
            ], 400);
        }




        // if ($count !== null) {
        //     $token = JWTToken::createToken($request->input('email'), $count->id);
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'User login successful',
        //         'token' => $token
        //     ], 200)->cookie('token', $token, time() + 60 * 24 * 30);
        // } else {
        //     return response()->json([
        //         'status' => 'unauthorized',
        //         'message' => 'User login failed'
        //     ], 400);
        // }
    }

    function userLogout(Request $request)
    {
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'User logout successful'
        // ], 200)->cookie('token', '', time() - 60 * 24 * 30);


        return redirect('/')->cookie('token', '', time() - 60 * 24 * 30);
    }

    function sendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => "OTP code {$otp} has been sent to your email"

            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email not found'
            ], 400);
        }
    }


    function verifyOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if ($count) {
            User::where('email', '=', $email)->update(['otp' => '0']);
            $token = JWTToken::createTokenForSetPassword($email);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP code verified'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'OTP code not verified'
            ], 400);
        }
    }

    function resetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');


            User::where('email', '=', $email)->update(['password' => Hash::make($password)]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    function userProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], 200);
    }

    function userUpdateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $validateData = $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'mobile' => 'required|unique:users',
                'password' => 'required|min:6'
            ]);

            User::where('email', '=', $email)->update([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'mobile' => $validateData['mobile'],
                'password' => Hash::make($validateData['password'])
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User profile updated'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
