<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\General;
use App\Models\Role;
use App\Models\Smtp;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
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
    protected function create(array $data)
    {
        $company = new Company();
        $company->name = $data['company_name'];
        $company->save();

        $designation = new Designation();
        $designation->name = 'Ceo / Founder';
        $designation->company_id = $company->id;
        $designation->is_default = 1;
        $designation->save();

        $department = new Department();
        $department->name = 'Ownership';
        $department->company_id = $company->id;
        $department->is_default = 1;
        $department->save();

        $role = new Role();
        $role->name = 'Admin';
        $role->company_id = $company->id;
        $role->is_default = 1;
        $role->save();

        $general = new General();
        $general->title = $data['company_name'];
        $general->company_id = $company->id;
        $general->save();

        $smtp = new Smtp();
        $smtp->company_id = $company->id;
        $smtp->save();

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'department_id' => $department->id,
            'designation_id' => $designation->id,
            'company_id' => $company->id
        ]);
    }
}
