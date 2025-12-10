<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'magazine_id',
    'total_price', 'purchase_history'];

  public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
