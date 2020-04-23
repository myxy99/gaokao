<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaokaoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('province', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('form')->nullable($value = true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('batch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('school', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('code')->unique()->unsigned();
            $table->string('name')->unique();
            $table->text('web1')->nullable($value = true);
            $table->text('web2')->nullable($value = true);
            $table->text('web3')->nullable($value = true);

            $table->bigInteger('province_id')->unsigned()->nullable($value = true);
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');

            $table->bigInteger('batch_id')->unsigned()->nullable($value = true);
            $table->foreign('batch_id')->references('id')->on('batch')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('collage_scoreline', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('year', 64);

            $table->bigInteger('province_id')->unsigned()->nullable($value = true);
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');

            $table->bigInteger('project_id')->unsigned()->nullable($value = true);
            $table->foreign('project_id')->references('id')->on('project')->onDelete('set null');

            $table->bigInteger('batch_id')->unsigned()->nullable($value = true);
            $table->foreign('batch_id')->references('id')->on('batch')->onDelete('set null');
            $table->softDeletes();
            $table->bigInteger('score');
            $table->timestamps();
        });

        Schema::create('school_scoreline', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('school_code')->unsigned()->nullable($value = true);
                $table->foreign('school_code')->references('code')->on('school')->onDelete('set null');

            $table->string('year', 64);
            $table->string('majar')->default('-1');
            $table->bigInteger('province_id')->unsigned()->nullable($value = true);
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');

            $table->bigInteger('project_id')->unsigned()->nullable($value = true);
            $table->foreign('project_id')->references('id')->on('project')->onDelete('set null');

            $table->bigInteger('batch_id')->unsigned()->nullable($value = true);
            $table->foreign('batch_id')->references('id')->on('batch')->onDelete('set null');

            $table->integer('max')->nullable($value = true);
            $table->integer('min')->nullable($value = true);
            $table->integer('aver')->nullable($value = true);
            $table->softDeletes();
            $table->integer('forecast')->nullable($value = true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
        Schema::dropIfExists('province');
        Schema::dropIfExists('batch');
        Schema::dropIfExists('school');
        Schema::dropIfExists('collage_scoreline');
        Schema::dropIfExists('school_scoreline');
    }
}
