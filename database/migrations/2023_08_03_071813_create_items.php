<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->string('item_stock')->nullable();
            $table->string('item_stock_reminder')->nullable();
            $table->string('price')->nullable();
            $table->string('vendor')->nullable();
            $table->string('picture')->nullable();
            $table->string('classification')->nullable();
            $table->string('active', '2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
