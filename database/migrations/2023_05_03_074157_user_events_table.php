<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private const TABLE_NAME = 'user_events';
    private const USER_TABLE_NAME = 'users';
    private const EVENTS_TABLE_NAME = 'events';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(self::USER_TABLE_NAME);
            $table->foreignId('event_id')->constrained(self::EVENTS_TABLE_NAME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
