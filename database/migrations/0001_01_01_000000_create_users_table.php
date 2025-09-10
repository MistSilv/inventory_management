<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['pracownik','ksiegowy','kierownik','admin'])->default('pracownik');
            $table->timestamps();
        });

        // PRODUCTS
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->nullable(); // np. id_abaco
            $table->enum('unit', ['szt', 'kg', 'm', 'l', 'opak']);
            $table->timestamps();
        });

        // BARCODES
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('code', 13); // np. EAN-13
            $table->timestamps();
        });

        // STOCKTAKINGS (nagłówki spisów)
        Schema::create('stocktakings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description')->nullable();
            $table->enum('status', ['draft', 'in_progress', 'closed'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // STOCKTAKING ITEMS (pozycje w spisie)
        Schema::create('stocktaking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stocktaking_id')->constrained('stocktakings')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('quantity', 12, 2); 
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        //do chech boxów w trakcie tworzenia spisu
        Schema::create('stocktaking_temp_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stocktaking_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id'); 
            $table->boolean('selected')->default(false);
            $table->decimal('quantity', 12, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('stocktaking_id')->references('id')->on('stocktakings')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // AUDYT / LOGI DODANIA POZYCJI
        Schema::create('stocktaking_item_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stocktaking_item_id')->constrained('stocktaking_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // kto wykonał akcję
            $table->enum('action', ['create', 'update', 'delete'])->default('create');
            $table->timestamps();
        });

	Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocktaking_items');
        Schema::dropIfExists('stocktakings');
        Schema::dropIfExists('barcodes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
	    Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::blueprintResolver('stocktaking_item_logs');
        Schema::dropIfExists('stocktaking_temp_items');
    }
};
