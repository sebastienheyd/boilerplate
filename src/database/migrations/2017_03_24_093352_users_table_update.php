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
            $table->renameColumn('name', 'first_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->boolean('active')->default(0)->after('id');
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->after('first_name');
            $table->dateTime('last_login')->nullable();
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
