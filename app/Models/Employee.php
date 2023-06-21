<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'password', 'hourly_rate']; // Добавьте 'hourly_rate' в этот массив

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
