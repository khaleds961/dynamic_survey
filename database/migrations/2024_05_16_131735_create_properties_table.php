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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->index('survey_id');
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->boolean('show_personal')->default(true);
            $table->text('logo')->nullable();
            $table->text('logoFooter')->nullable();
            $table->string('backgroundColor')->nullable();
            $table->text('backgroundImage')->nullable();
            $table->string('mainColor')->nullable();
            $table->integer('fontFamily')->nullable();
            $table->boolean('wizard')->default(false);
            $table->longText('footer_ar')->nullable();
            $table->longText('footer_en')->nullable();
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
        Schema::dropIfExists('properties');
    }
};
