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

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number)
    {
        $words = array(
            0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 
            5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 
            10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 
            15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen',
            20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 
            60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );

        $digits = array('', 'hundred', 'thousand', 'lakh', 'million', 'billion');
        $number = (int)$number;

        if ($number == 0) {
            return 'zero';
        }

        $result = '';
        $i = 0;
        while ($number > 0) {
            $divider = ($i == 1) ? 10 : 100;
            $chunk = $number % $divider;
            $number = (int)($number / $divider);

            if ($chunk) {
                $str = '';
                if ($chunk < 20) {
                    $str = $words[$chunk];
                } else {
                    $tens = (int)($chunk / 10) * 10;
                    $unit = $chunk % 10;
                    $str = $words[$tens] . ' ' . $words[$unit];
                }

                if ($i > 0) {
                    $str .= ' ' . $digits[$i];
                }

                $result = $str . ' ' . $result;
            }
            $i++;
        }

        return trim(ucfirst($result));
    }
}
