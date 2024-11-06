<?php

namespace App\Models\EmployeePayroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBonuse extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
