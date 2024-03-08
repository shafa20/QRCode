<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    // protected function create(array $data)
    // {
    //     $qrCode = QrCode::size(300)->generate($data['email']);
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'qr_code' => $qrCode,
    //     ]);
    // }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $detailsUrl = route('scan.qr.code', ['qr_code_data' => $user->id]);
        $qrCodeContent = "Name: {$data['name']}\nEmail: {$data['email']}\nPassword: {$data['password']}\nDetails URL: {$detailsUrl}";
       // $qrCodeContent = "Name: {$data['name']}\nEmail: {$data['email']}\nPassword: {$data['password']}\nDetails URL: {$detailsUrl}\n\n<a style='color: blue;' href='{$detailsUrl}' download='user_details.pdf'>Download as PDF</a>";
        $qrCode = QrCode::size(300)->generate($qrCodeContent);

        $user->qr_code = $qrCode;
        $user->save();

        return $user;
    }

}
