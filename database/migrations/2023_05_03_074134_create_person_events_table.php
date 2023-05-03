<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'person_events';
    private const PERSONS_TABLE_NAME = 'persons';
    private const EVENTS_TABLE_NAME = 'events';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained(self::PERSONS_TABLE_NAME);
            $table->foreignId('event_id')->constrained(self::EVENTS_TABLE_NAME);
            $table->boolean('is_attending')->default(true);
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
