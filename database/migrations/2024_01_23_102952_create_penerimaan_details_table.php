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
        Schema::create('penerimaan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penerimaan_id')->nullable();
            $table->foreign('penerimaan_id')->references('id')->on('penerimaans');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('product_items');
            $table->unsignedBigInteger('pembelian_detail_id')->nullable();
            $table->foreign('pembelian_detail_id')->references('id')->on('pembelian_details');
            $table->integer('jumlah_penerimaan');
            $table->date('date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_details');
    }
};
