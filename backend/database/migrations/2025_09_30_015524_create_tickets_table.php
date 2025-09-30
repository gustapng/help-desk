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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('open'); // Status: open, in_progress, close, etc.

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('agent_id')->nullable()->constrained('users');
            $table->foreignId('type_id')->constrained('ticket_types');
            $table->foreignId('priority_id')->constrained('ticket_priorities');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
