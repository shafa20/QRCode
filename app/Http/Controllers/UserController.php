<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
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
    public function adminQrCode(Request $request)
    {
        $qrCodeData = $request->qr_code_data;
        $user = Admin::where('id', $qrCodeData)->first();
        return view('admin-details', ['user' => $user]);
    }

    public function downloadPDF($userId)
    {
        $user = User::findOrFail($userId);

        $pdf = PDF::loadView('user-details-pdf', compact('user'));

        return $pdf->download('user_details.pdf');
    }
    public function downloadAdminPDF($userId)
    {
        $user = Admin::findOrFail($userId);

        $pdf = PDF::loadView('admin-details-pdf', compact('user'));

        return $pdf->download('admin_details.pdf');
    }
}
