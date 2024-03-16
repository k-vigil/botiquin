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
        Schema::create('medicamentos_presentaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 12);
            $table->string('descripcion', 255);
            $table->string('composicion', 255)->nullable();
            $table->string('registro_dnm', 25);
            $table->integer('stock_min');

            $table->unsignedBigInteger('medicamento_id');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('presentacion_id');
            $table->foreign('presentacion_id')->references('id')->on('presentaciones')
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
        Schema::dropIfExists('medicamentos_presentaciones');
    }
};
