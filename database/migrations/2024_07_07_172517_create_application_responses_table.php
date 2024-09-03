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
        Schema::create('application_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->index();
            $table->foreignIdFor(\App\Models\User::class,'user_id')->index();
            $table->text('response_text');
            $table->enum('type',['interim_response', 'note', 'final_response']);

            // Indices for foreign keys and assignee
            $table->index(['application_id', 'type']);

            // Foreign key constraints
            $table->foreign('application_id')->references('id')->on('applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_responses');
    }
};
