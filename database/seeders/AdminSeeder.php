<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminData = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ];

        // Generate QR code content
        $detailsUrl = route('scan.qr.code', ['qr_code_data' => 1]); // Change 1 to the admin ID
        $qrCodeContent = "Name: {$adminData['name']}\nEmail: {$adminData['email']}\nPassword: password\nDetails URL: {$detailsUrl}";

        // Generate QR code
        $qrCode = QrCode::size(300)->generate($qrCodeContent);

        // Insert admin data into the database
        DB::table('admins')->insert([
            'name' => $adminData['name'],
            'email' => $adminData['email'],
            'password' => $adminData['password'],
            'qr_code' => $qrCode, // Store QR code content in the qr_code column
        ]);
    }
}
