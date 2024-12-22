<?php

namespace App\Models\LeaveApplication;

use App\Models\EmployeePayroll\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveLimits extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function employee() {
        return $this->belongsTo(Employee::class,'employee_id', 'id');
    }
    public function leaveType() {
        return $this->belongsTo(LeaveType::class,'leave_types_id', 'id');
    }
 
}
