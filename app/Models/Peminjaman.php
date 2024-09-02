<?php

namespace App\Models;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'tanggalPeminjaman',
        'tanggalPengembalian',
        'status'
    ];
    public function books(){
        return $this->belongsTo(Book::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
