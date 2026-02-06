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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('content');
            $table->text('excerpt')->nullable(); // Short summary
            $table->string('image')->nullable();
            $table->enum('type', ['announcement', 'info', 'event', 'policy', 'achievement'])->default('announcement');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete(); // null = all orgs
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_published');
            $table->index('is_pinned');
            $table->index('type');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
