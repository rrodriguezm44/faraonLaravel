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
            $table->id();
            $table->string('code')->unique();
            $table->string('document')->nullable();
            $table->string('description');
            $table->decimal('priceCompra', 10, 2);
            $table->decimal('porcentual', 10, 2);
            $table->decimal('priceVenta', 10, 2);
            $table->decimal('priceFeria', 10, 2);
            $table->decimal('priceOferta', 10, 2);
            $table->decimal('descuento', 10, 2);
            $table->integer('stock');
            $table->boolean('is_active')->default(true);
            $table->string('unidad_medida')->nullable();
            $table->foreignId('category_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            $table->foreignId('sub_category_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            $table->foreignId('supplier_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            $table->timestamps();
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
