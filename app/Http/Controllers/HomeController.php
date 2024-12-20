<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $is_punch_in = Attendance::where(['user_id' => auth()->user()->id , 'date' => date('Y-m-d')])->whereNotNull('punch_in')->exists();
        return view('home',compact('is_punch_in'));
    }
}
