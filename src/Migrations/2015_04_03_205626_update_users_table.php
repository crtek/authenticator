<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('password')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('email')->default(time() . '-no-reply@Authenticator.com')->change();
            $table->string('username')->nullable();
            $table->string('avatar')->nullable();
            $table->string('provider')->default('laravel');
            $table->string('provider_id')->unique()->nullable();
            $table->string('activation_code')->nullable();
            $table->integer('active')->nullable();
            $table->string('tel')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        $table->dropColumn('username');
        $table->string('email')->default()->change();
        $table->dropColumn('avatar');
        $table->dropColumn('provider');
        $table->dropColumn('provider_id');
        $table->dropColumn('activation_code');
        $table->dropColumn('active');
        $table->dropColumn('tel');
	}

}
