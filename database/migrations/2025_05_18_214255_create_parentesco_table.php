<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parentesco', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('parentesco', 30);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parentesco');
    }
};
