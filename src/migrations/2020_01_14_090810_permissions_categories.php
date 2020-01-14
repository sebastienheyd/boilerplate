<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PermissionsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable()->after('id');
            $table->foreign('category_id')->references('id')->on('permissions_categories')->onDelete('set null');
        });

        $id = DB::table('permissions_categories')->insertGetId([
            'name'         => 'users',
            'display_name' => 'boilerplate::permissions.categories.users',
        ]);

        DB::table('permissions')->where('name', 'users_crud')
            ->orWhere('name', 'roles_crud')
            ->update(['category_id' => $id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign('permissions_category_id_foreign');
            $table->dropColumn('category_id');
        });

        Schema::drop('permissions_categories');
    }
}
