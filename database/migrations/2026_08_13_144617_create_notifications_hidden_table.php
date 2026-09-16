<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications_hidden', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('type');

            $table->unsignedBigInteger('reference_id');

            $table->timestamps();

            $table->unique([
                'user_id',
                'type',
                'reference_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications_hidden');
    }
};