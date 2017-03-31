<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UsersTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('name');
            $table->boolean('active')->default(0)->after('id');
            $table->string('first_name')->after('active');
            $table->string('last_name')->after('first_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn(['active', 'first_name', 'last_name']);
            $table->string('name');
        });
    }
}
