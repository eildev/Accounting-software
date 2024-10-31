<?php

namespace App\Models\ConvenienceBill;

use App\Models\EmployeePayroll\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenience extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    } //
}
