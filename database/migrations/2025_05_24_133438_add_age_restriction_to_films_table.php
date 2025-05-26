<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeRestrictionToFilmsTable extends Migration
{
    public function up()
    {
        Schema::table('films', function (Blueprint $table) {
            $table->enum('age_restriction', ['Semua Umur', 'Anak-anak', 'Remaja', 'Dewasa'])->default('Remaja');
        });
    }

    public function down()
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropColumn('age_restriction');
        });
    }
}

