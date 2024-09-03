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
        Schema::create('application_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->index();
            $table->bigInteger('assignee_id')->unsigned();
            $table->string('assignee_type');
            $table->text('reason')->nullable();

            // Indices for foreign keys and assignee
            $table->index(['assignee_id', 'assignee_type']);

            // Foreign key constraint
            $table->foreign('application_id')->references('id')->on('applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_assignments');
    }
};
