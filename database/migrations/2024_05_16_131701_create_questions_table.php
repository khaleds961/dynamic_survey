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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->index('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string('question_text')->nullable();
            $table->enum('question_type',['text','multiple_choices','option','select'])->nullable();
            $table->integer('order_num')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
