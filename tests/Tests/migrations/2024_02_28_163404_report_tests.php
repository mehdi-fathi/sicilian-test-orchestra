<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('report_tests', function (Blueprint $table) {
            $table->id();
            $table->integer('report_id');
            $table->integer('order');
            $table->string('route');
            $table->string('method');
            $table->text('request');
            $table->integer('status');
            $table->text('response');
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
