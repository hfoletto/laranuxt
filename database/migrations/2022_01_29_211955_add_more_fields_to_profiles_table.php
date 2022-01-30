<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('job_title')->after('last_name');
            $table->string('phone_number')->after('email')->nullable();
            $table->longText('introduction')->after('location')->nullable();
            $table->string('github_url')->after('introduction')->nullable();
            $table->string('linkedin_url')->after('github_url')->nullable();
            $table->string('twitter_url')->after('linkedin_url')->nullable();
            $table->string('website_url')->after('twitter_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('job_title');
            $table->dropColumn('phone_number');
            $table->dropColumn('introduction');
            $table->dropColumn('github_url');
            $table->dropColumn('linkedin_url');
            $table->dropColumn('twitter_url');
            $table->dropColumn('website_url');
        });
    }
}
