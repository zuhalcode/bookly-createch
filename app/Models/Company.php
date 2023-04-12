<?php

namespace App\Models;

use App\Models\City;
use App\Models\Slot;
use App\Models\User;
use App\Models\Cover;
use App\Models\Branch;
use App\Models\Holiday;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function city() {
        return $this->belongsTo(City::class);
    }

    public function holidays() {
        return $this->hasMany(Holiday::class);
    }

    public function covers() {
        return $this->hasMany(Cover::class);
    }

    public function branches() {
        return $this->hasMany(Branch::class);
    }

    public function subcriptions() {
        return $this->hasMany(Subscription::class);
    }

    public function slots() {
        return $this->hasMany(Slot::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}