<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payreq extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'tbl_payreq';
    protected $with = ['employee'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function buc()
    {
        return $this->belongsTo(Buc::class, 'buc_id', 'id');
    }

    public function splits()
    {
        return $this->hasMany(Split::class, 'payreq_id', 'id');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     // updating created_by and updated_by when model is created
    //     static::creating(function ($model) {
    //         if (!$model->isDirty('created_by')) {
    //             $model->created_by = auth()->user()->username;
    //         }
    //         if (!$model->isDirty('updated_by')) {
    //             $model->updated_by = auth()->user()->username;
    //         }
    //     });

    //     // updating updated_by when model is updated
    //     static::updating(function ($model) {
    //         if (!$model->isDirty('updated_by')) {
    //             $model->updated_by = auth()->user()->username;
    //         }
    //     });

    // }
}
