<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['delivery_address_id', 'user_profile_id', 'delivery_date_time', 'delivery_status', 'checklist_top_id'];
}
