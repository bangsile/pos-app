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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code'); // kode unik per company
            $table->string('barcode')->nullable(); // bisa null kalau pakai SKU saja
            $table->timestamps();

            $table->unique(['company_id', 'code']);     // SKU unik dalam satu company
            $table->unique(['company_id', 'barcode']); // Barcode unik dalam satu company
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
