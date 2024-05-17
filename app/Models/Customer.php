<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'due_date', 'price', 'hosting_material_id', 'ssl_material_id'];


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
}
