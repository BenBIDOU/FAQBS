<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('discussion_id')->nullable()->after('discussion_title');
            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['discussion_id']);
            $table->dropColumn('discussion_id');
        });
    }
};
