<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\Meter\Status as StatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->string("code", 255)->nullable();
            $table->foreignId('industry_id')->constrained()->onDelete('cascade');
            $table->string('name', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->enum('status', StatusEnum::values())->default(StatusEnum::ACTIVE->value);
            $table->timestamp('last_reading_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('meter_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meter_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'meter_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meter_user');
        Schema::dropIfExists('meters');
    }
};
