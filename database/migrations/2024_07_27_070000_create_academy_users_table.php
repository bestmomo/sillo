<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('academy_users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('firstname');
			$table->string('email')->unique();
			$table->enum('gender', ['female', 'male', 'other']);
			$table->string('password');
			$table->enum('role', ['user', 'redac', 'admin'])->default('user');
			$table->boolean('valid')->default(false);
			$table->boolean('isStudent')->default(false);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('academy_users');
	}
};
