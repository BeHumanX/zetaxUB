<?php

namespace App\Models;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'author',
        'publisher',
        'year',
        'category_id'
    ];
    public function peminjamans(){
        return $this->hasMany(Peminjaman::class);
    }
    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
