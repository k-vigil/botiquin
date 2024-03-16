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
        Schema::create('movimientos_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('descripcion', 255);
            $table->string('lote', 12);
            $table->enum('tipo', ['Entrada', 'Salida']);
            $table->integer('cantidad');
            $table->float('valor', 8, 4);
            $table->integer('saldo_cantidad');
            $table->float('saldo_valor', 8, 4);
            $table->float('costo_prom', 8, 4);
            $table->float('costo_unit', 8, 4);
            $table->string('referencia', 12);

            $table->unsignedBigInteger('medicamento_presentacion_id');
            $table->foreign('medicamento_presentacion_id')->references('id')->on('medicamentos_presentaciones')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_medicamentos');
    }
};
