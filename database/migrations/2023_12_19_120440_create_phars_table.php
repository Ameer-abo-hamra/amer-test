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
        Schema::create('phars', function (Blueprint $table) {
            $table->id();
            $table->string("username");
<<<<<<< HEAD
            $table->integer("phone_number");
=======
            $table->bigInteger("phone_number");
>>>>>>> 535bc87032b1c3e1d50b2434698169e9cdad3d7d
            $table->string("password");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phars');
    }
};
