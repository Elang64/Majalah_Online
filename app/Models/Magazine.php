<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Magazine extends Model
{
    use softDeletes;
    protected $fillable = ['user_id', 'promo_id', 'title', 'description', 'category',
    'price', 'publication_year', 'cover', 'actived'];

      public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function promo() {
        return $this->belongsTo(Promo::class, 'promo_id');
    }



}

