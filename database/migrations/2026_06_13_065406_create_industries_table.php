<?php

use App\Enums\Industry\Status as StatusEnum;

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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string("owner_name", 255)->nullable();
            $table->string("owner_email", 255)->nullable();
            $table->string("owner_phone", 255)->nullable();
            $table->string("address", 255)->nullable();
            $table->enum("status", StatusEnum::values())->default(StatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
