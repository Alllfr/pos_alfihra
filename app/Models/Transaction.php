<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi dengan nama transactionDetails
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}