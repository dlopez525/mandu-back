<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperiorDivision extends Model
{
    use HasFactory;

    public function division() {
        return $this->hasOne(Division::class);
    }
}
