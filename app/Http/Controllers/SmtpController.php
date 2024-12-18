<?php

namespace App\Http\Controllers;

use App\Models\Smtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SmtpController extends Controller
{
    public function index()
    {
        $smtp = Smtp::where('company_id', auth()->user()->company_id)->first();
        return view('settings.smtp', compact('smtp'));
    }

    public function update(Request $request , $id)
    {
        $request->validate([
            'from_name' => 'required',
            'from_email' => 'required',
            'smtp_driver' => 'required',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_encryption' => 'required',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
        ]);
        
        $smtp = Smtp::find($id);
        $smtp->from_name = $request->from_name;
        $smtp->from_email = $request->from_email;
        $smtp->smtp_driver = $request->smtp_driver;
        $smtp->smtp_host = $request->smtp_host;
        $smtp->smtp_port = $request->smtp_port;
        $smtp->smtp_encryption = $request->smtp_encryption;
        $smtp->smtp_username = $request->smtp_username;
        $smtp->smtp_password = $request->smtp_password;
        $smtp->update();

        return redirect()->route('smtp.index')->with('success', 'SMTP Configuration is updated successfully');
    }

    public function test(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        
        configureMail(auth()->user()->company_id);
        $toEmail = $request->email;
        $subject = 'SMTP Test';
        $message = 'This is a test mail';
        Mail::raw($message, function ($mail) use ($toEmail, $subject) {
            $mail->to($toEmail)
                 ->subject($subject);
        });

        return redirect()->route('smtp.index')->with('success', 'Test email sent successfully');
    }
}
