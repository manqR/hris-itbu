<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Employee history for temporal tracking of all profile changes.
     * This enables full historical record of appointments, placements, etc.
     */
    public function up(): void
    {
        Schema::create('employee_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->enum('change_type', [
                'profile_update',      // Personal information changes
                'status_change',       // Employment status change
                'assignment_added',    // New organization assignment
                'assignment_updated',  // Assignment modification
                'assignment_ended',    // Assignment terminated
                'position_change',     // Position/title change
                'supervisor_change',   // Supervisor change
                'termination',         // Employment ended
                'reinstatement',       // Re-hired
            ]);
            $table->string('field_name', 100)->nullable(); // Specific field changed
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->date('effective_date'); // When the change takes effect
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamp('created_at');

            $table->index('change_type');
            $table->index('effective_date');
            $table->index(['employee_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_histories');
    }
};
