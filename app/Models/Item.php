<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'description',
        'location_lost',
        'status',
        'image', // <-- Gidugang para sa image upload
    ];

    // Connect sa User nga nag-report
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}