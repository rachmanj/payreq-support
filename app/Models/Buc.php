<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buc extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payreqs()
    {
        return $this->hasMany(Payreq::class, 'buc_id', 'id');
    }

    public function advance()
    {
        return Payreq::where('buc_id', $this->id)->whereNotNull('outgoing_date')->sum('payreq_idr');
    }

    public function realization()
    {
        return Payreq::where('buc_id', $this->id)->whereNotNull('realization_date')->sum('payreq_idr');
    }
}
