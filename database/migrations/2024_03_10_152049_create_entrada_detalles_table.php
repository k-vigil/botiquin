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
        Schema::create('entrada_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->float('costo', 8, 4);
            $table->float('precio', 8, 4);

            $table->unsignedBigInteger('medicamento_presentacion_id');
            $table->foreign('medicamento_presentacion_id')->references('id')->on('medicamentos_presentaciones')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('entrada_id');
            $table->foreign('entrada_id')->references('id')->on('entradas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('lote_id');
            $table->foreign('lote_id')->references('id')->on('lotes')
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
        Schema::dropIfExists('entrada_detalles');
    }
};
