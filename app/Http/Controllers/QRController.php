<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generateQR(Request $request)
    {
        $user = auth()->user();
        $qrCode = QrCode::size(300)->generate($user->email);

        return response($qrCode)->header('Content-Type', 'image/png');
    }
}
