<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $user = auth()->user();
        $qrCode = $user->qr_code;
        $qrCodeBase64 = base64_encode($qrCode);
        return view('adminpage', ['user' => $user, 'qrCodeBase64' => $qrCodeBase64]);
    }
}
