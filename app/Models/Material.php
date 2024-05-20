<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\CustomerMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['item', 'price', 'billing_cycle',  'due_date', 'material', 'is_multiple'];


    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_domains', 'material_id', 'customer_id');
    }

    public function hostingCustomer(): HasMany
    {
        return $this->hasMany(Customer::class, 'hosting_material_id');
    }

    public function sslCustomer(): HasMany
    {
        return $this->hasMany(Customer::class, 'ssl_material_id');
    }

    public static function checkTableName($column, $order = 'asc')
    {
        $validColumns = Schema::getColumnListing('materials');
        $validOrder = ['asc', 'desc'];

        if (!in_array($column, $validColumns)) $column = 'due_date';
        if (!in_array($order, $validOrder)) $order = 'asc';

        return [$column, $order];
    }
}
