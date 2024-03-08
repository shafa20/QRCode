<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Check validation failure
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Generate QR code
        $detailsUrl = route('scan.qr.code', ['qr_code_data' => $user->id]);
        $qrCodeContent = "Name: {$user->name}\nEmail: {$user->email}\nPassword: {$request->input('password')}\nDetails URL: {$detailsUrl}";
        $qrCode = QrCode::size(300)->generate($qrCodeContent);

        $user->qr_code = $qrCode;
        $user->save();

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Return response
        return response()->json(compact('user', 'token'), 201);
    }


    public function login(Request $request)
    {
        // Extract credentials from request
        $credentials = $request->only('email', 'password');

        // Authenticate user
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Return JWT token
        return response()->json(compact('token'));
    }
}
