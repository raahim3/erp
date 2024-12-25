<?php

use App\Models\Smtp;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

function configureMail($companyId)
{
    $smtp = Smtp::where('company_id', $companyId)->firstOrFail();
    if(!$smtp) {
        return redirect()->back()->with('error', 'SMTP configuration not found');
    }
    Config::set('mail.mailers.smtp.transport', $smtp->smtp_driver);
    Config::set('mail.mailers.smtp.host', $smtp->smtp_host);
    Config::set('mail.mailers.smtp.port', $smtp->smtp_port);
    Config::set('mail.mailers.smtp.encryption', $smtp->smtp_encryption);
    Config::set('mail.mailers.smtp.username', $smtp->smtp_username);
    Config::set('mail.mailers.smtp.password', $smtp->smtp_password);
    Config::set('mail.from.address', $smtp->from_email);
    Config::set('mail.from.name', $smtp->from_name);
}

function profileImage($image)
{
    if($image && file_exists(public_path('uploads/profile'.'/'.$image))) {
        return asset('uploads/profile'.'/'.$image);
    }
    return asset('default.jpg');
}
