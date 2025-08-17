<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payslip()
    {
        return $this->belongsTo(Payslip::class);
    }

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
