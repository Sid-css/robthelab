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
        Schema::create('clients', function (Blueprint $table) {
            
        $table->id();
        $table->string('name');
        $table->string('ph_no', 15);
        $table->string('email')->nullable();
        $table->text('address')->nullable();

        // $table->foreignId('source_id')
        //       ->nullable()
        //       ->constrained('source_master')
        //       ->nullOnDelete();
        $table->unsignedBigInteger('source_id')->nullable();


        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
