<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'service', 'domain', 'due_date', 'price', 'hosting_material_id', 'ssl_material_id'];


    public function domainMaterials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'customer_domains', 'customer_id', 'material_id')
            ->withTimestamps()
            ->where('material', 'domain');
    }

    public function hostingMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'hosting_material_id');
    }

    public function sslMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'ssl_material_id');
    }

    public static function checkTableName($column, $order = 'asc')
    {
        $validColumns = Schema::getColumnListing('customers');
        $validOrder = ['asc', 'desc'];

        if (!in_array($column, $validColumns)) $column = 'due_date';
        if (!in_array($order, $validOrder)) $order = 'asc';

        return [$column, $order];
    }
}
