<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "store_id",
        "firstname",
        "middlename",
        "lastname",
        "gender",
        "birthday",
        "contact_no",
        "address",
        "is_verified",
        "id_number",
        "id_card"
    ];
}
