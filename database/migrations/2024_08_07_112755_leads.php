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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('countrycode', 3)->nullable(true)->default(null);
            $table->boolean('termsaccepted')->nullable(true)->default(0);
            $table->timestamps();
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->string('email', 30)->nullable(false)->index();
        });

        Schema::create('leads_encryption', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lead')->unsigned()->index()->nullable(false);
            $table->text('firstname')->nullable(false);
            $table->text('lastname')->nullable(true)->default(null);
            $table->text('email')->nullable(false);
            $table->text('mobile')->nullable(true)->default(null);
            $table->text('notes')->nullable(true)->default(null);
            $table->text('referral')->nullable(true)->default(null);
            $table->timestamps();
            $table->foreign('lead')->references('id')
                ->on('leads')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
