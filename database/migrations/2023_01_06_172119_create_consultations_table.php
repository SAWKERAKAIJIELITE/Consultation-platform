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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->unsignedFloat('cost');
            $table->unsignedFloat('rate')->nullable();
            $table->string('Specialises');
            $table->foreignId('person_id')
                ->constrained('people')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('person_expert_id')
                ->constrained('people')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('isfinished')->default(false);
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
        Schema::dropIfExists('consultations');
    }
};
