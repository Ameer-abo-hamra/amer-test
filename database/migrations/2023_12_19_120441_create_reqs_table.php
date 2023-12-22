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
        Schema::create('reqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("phar_id")->constrained("phars");
            $table->text("payment_state")->default("غير مدفوع");
            $table->text("receive_state")->default("قيد التحضير");
            $table->unsignedFloat("price");
            $table->boolean("isUpdated")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reqs');
    }
};
