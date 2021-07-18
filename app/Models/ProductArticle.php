<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductArticle extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'title', 'description', 'short_description','picture_link'];
}
