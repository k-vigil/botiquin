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
        Schema::create('salida_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->float('precio', 8, 4);

            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('salida_id');
            $table->foreign('salida_id')->references('id')->on('salidas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salida_detalles');
    }
};
