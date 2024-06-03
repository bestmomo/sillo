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
        Schema::create('comments', function(Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('body');
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('post_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('comments')
                  ->nullable()
                  ->default(null)
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
