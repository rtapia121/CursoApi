<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Rating extends Pivot
{
    use HasFactory;

    public $incrementing = true;
    protected $table = 'ratings';

    public function rateable(){
        return $this->morphTo();
    }

    public function qualifer(){
        return $this->morphTo();
    }

    public function approve(){
        dd("llego");
        $this->approved_at = Carbon::now();
    }
}
