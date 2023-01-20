<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
            $table->string('phone_number');
            $table->date('recruitment_date');
            $table->string('email');
            $table->string('image_path')->nullable();
            $table->string('payment');
            $table->unsignedBigInteger('head_id')->nullable();
            //$table->string('head')->nullable();
            $table->timestamps();
            $table->string('admin_created_id');
            $table->string('admin_updated_id');
        });

        Schema::table('employees',function (Blueprint $table){
            $table->foreign('head_id')->references('id')->on('employees')->cascadeOnUpdate()->nullOnDelete();
    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
