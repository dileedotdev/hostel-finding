<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_rooms', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user1_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('user2_id')->constrained('users', 'id')->cascadeOnDelete();

            $table->unique(['user1_id', 'user2_id']);
            $table->timestamps();
        });
    }
};
