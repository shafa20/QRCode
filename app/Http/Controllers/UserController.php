<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PDF;
class UserController extends Controller
{

    public function scanQrCode(Request $request)
    {
        $qrCodeData = $request->qr_code_data;
        $user = User::where('id', $qrCodeData)->first();
        return view('user-details', ['user' => $user]);
    }

    public function downloadPDF($userId)
    {
        $user = User::findOrFail($userId);

        $pdf = PDF::loadView('user-details-pdf', compact('user'));

        return $pdf->download('user_details.pdf');
    }
}
