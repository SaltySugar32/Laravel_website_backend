<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $fillable = ['top_id', 'bot_id', 'purchase_id', 'product_article_id', 'purchase_amount'];
}
