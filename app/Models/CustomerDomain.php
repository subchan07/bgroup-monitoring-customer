<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDomain extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'material_id'];
}
