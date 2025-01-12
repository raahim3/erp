<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payslip extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salary()
    {
        return $this->belongsTo(salary::class);
    } 
}
