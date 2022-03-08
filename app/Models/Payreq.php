<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payreq extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tbl_payreq';
    protected $with = ['employee'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
