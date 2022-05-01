<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function ambassador() {
        return $this->belongsTo(Ambassador::class);
    }

    public function superiorDivision() {
        return $this->belongsTo(SuperiorDivision::class);
    }

    public function subDivisions() {
        return $this->hasMany(SubDivision::class);
    }
}
