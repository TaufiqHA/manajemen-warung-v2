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
            $table->id(); // id bigint [pk, increment]
            $table->foreignId('warung_id')->constrained('warungs')->onDelete('cascade'); // warung_id bigint
            $table->foreignId('category_id')->nullable()->constrained('categories'); // category_id bigint [null]
            $table->string('name'); // name varchar
            $table->text('description')->nullable(); // description text [null]
            $table->bigInteger('price'); // price bigint
            $table->integer('order')->default(0); // order int [default: 0]
            $table->integer('stock')->default(0); // stock int [default: 0]
            $table->string('unit')->default('pcs'); // unit varchar [default: 'pcs']
            $table->string('image_url')->nullable(); // image_url varchar [null]
            $table->boolean('is_active')->default(true); // is_active boolean [default: true]
            $table->timestamps(); // created_at, updated_at
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
