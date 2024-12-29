<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    public function leave_requests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
