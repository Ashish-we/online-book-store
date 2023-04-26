<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_mtr extends Model
{
    use HasFactory;
    public function book()
    {
        return $this->hasOne(book::class);
    }
}
