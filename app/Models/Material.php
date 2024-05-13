<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['item', 'price', 'billing_cycle',  'due_date', 'material'];


    public function domainCustomer(): HasMany
    {
        return $this->hasMany(Customer::class, 'domain_material_id');
    }

    public function hostingCustomer(): HasMany
    {
        return $this->hasMany(Customer::class, 'hosting_material_id');
    }

    public function sslCustomer(): HasMany
    {
        return $this->hasMany(Customer::class, 'ssl_material_id');
    }
}
