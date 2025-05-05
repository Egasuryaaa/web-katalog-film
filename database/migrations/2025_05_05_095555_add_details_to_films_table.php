<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToFilmsTable extends Migration
{
    public function up()
    {
        Schema::table('films', function (Blueprint $table) {
            if (! Schema::hasColumn('films', 'release_date')) {
                $table->date('release_date')->nullable();
            }
            if (! Schema::hasColumn('films', 'duration')) {
                $table->integer('duration')->nullable();
            }
            if (! Schema::hasColumn('films', 'genre')) {
                $table->string('genre')->nullable();
            }
            if (! Schema::hasColumn('films', 'trailer_url')) {
                $table->string('trailer_url')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('films', function (Blueprint $table) {
            if (Schema::hasColumn('films', 'release_date')) {
                $table->dropColumn('release_date');
            }
            if (Schema::hasColumn('films', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('films', 'genre')) {
                $table->dropColumn('genre');
            }
            if (Schema::hasColumn('films', 'trailer_url')) {
                $table->dropColumn('trailer_url');
            }
        });
    }
}
