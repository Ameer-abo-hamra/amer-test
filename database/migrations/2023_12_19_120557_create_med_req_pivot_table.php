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
        Schema::create('med_req_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId("medication_id")->constrained("medications");
            $table->foreignId("req_id")->constrained("reqs");
            $table->integer("quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('med_req_pivot');
    }
};
