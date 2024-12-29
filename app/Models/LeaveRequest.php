<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function action()
    {
        return $this->belongsTo(User::class , 'action_by');
    }
}
