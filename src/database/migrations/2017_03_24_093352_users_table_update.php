<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UsersTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('active')->default(0)->after('id');
            $table->string('first_name')->nullable()->after('active');
            $table->string('last_name')->nullable()->after('first_name');
            $table->dateTime('last_login')->nullable();
        });

        // Drop column in another call for sqlite
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['active', 'first_name', 'last_name', 'last_login']);
            $table->string('name');
        });
    }
}
