<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('service', 20);
            $table->string('domain');
            $table->date('due_date');
            $table->decimal('price', 12);
            $table->foreignId('hosting_material_id')->nullable()->constrained('materials')->cascadeOnDelete();
            $table->foreignId('ssl_material_id')->nullable()->constrained('materials')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
