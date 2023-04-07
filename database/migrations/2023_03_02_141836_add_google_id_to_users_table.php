<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('google_id')->nullable();
            $table->string('password')->nullable()->change();
            $table->string('id_number')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });
    }
};
