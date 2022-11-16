<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;

class LogViewerPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            'name'         => 'logs',
            'display_name' => 'boilerplate::permissions.logs.display_name',
            'description'  => 'boilerplate::permissions.logs.description',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('name', 'logs')->delete();
    }
}
