<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'due_date', 'price', 'domain_material_id', 'hosting_material_id', 'ssl_material_id'];


    public function domainMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'domain_material_id', 'id');
    }

    public function hostingMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'hosting_material_id', 'id');
    }

    public function sslMaterial(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'ssl_material_id', 'id');
    }
}
