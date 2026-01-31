<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Core employee data with temporal versioning support
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number', 20)->unique();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('id_number', 30)->nullable(); // KTP/NIK
            $table->string('tax_number', 30)->nullable(); // NPWP
            $table->string('bank_account', 30)->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('employment_status', ['active', 'resigned', 'terminated', 'retired'])->default('active');
            $table->enum('employment_type', ['permanent', 'contract', 'probation', 'internship'])->default('permanent');
            $table->string('photo')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Link to auth user
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('employment_status');
            $table->index('employment_type');
            $table->index('is_active');
            $table->index('hire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
