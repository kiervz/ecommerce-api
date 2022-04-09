<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "seller_id",
        "name",
        "slug",
        "bio",
        "last_log",
        "deleted_at"
    ];
}
