<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTables extends Migration
{
    private $roles = [
        [
            'name'         => 'admin',
            'display_name' => 'boilerplate::role.admin.display_name',
            'description'  => 'boilerplate::role.admin.description',
        ],
        [
            'name'         => 'backend_user',
            'display_name' => 'boilerplate::role.backend_user.display_name',
            'description'  => 'boilerplate::role.backend_user.description',
        ],
    ];

    private $permissions = [
        [
            'name'         => 'backend_access',
            'display_name' => 'boilerplate::permissions.backend_access.display_name',
            'description'  => 'boilerplate::permissions.backend_access.description',
        ],
        [
            'name'         => 'users_crud',
            'display_name' => 'boilerplate::permissions.users_crud.display_name',
            'description'  => 'boilerplate::permissions.users_crud.description',
        ],
        [
            'name'         => 'roles_crud',
            'display_name' => 'boilerplate::permissions.roles_crud.display_name',
            'description'  => 'boilerplate::permissions.roles_crud.description',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many To Many Polymorphic)
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->integer('role_id')->unsigned();
            $table->string('user_type');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'user_id', 'user_type']);
        });

        // Insert default roles
        foreach ($this->roles as $role) {
            $role['created_at'] = date('Y-m-d H:i:s');
            $role['updated_at'] = date('Y-m-d H:i:s');
            DB::table('roles')->insert($role);
        }
        // Insert default permissions
        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            DB::table('permissions')->insert($permission);
        }

        DB::table('permission_role')->insert(['permission_id' => 1, 'role_id' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->where('name', $permission['name'])->delete();
        }

        foreach ($this->roles as $role) {
            DB::table('roles')->where('name', $role['name'])->delete();
        }

        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
