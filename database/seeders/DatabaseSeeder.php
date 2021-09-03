<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'writer']);
        Role::create(['name' => 'everyone']);


        // Create user table
        \App\Models\Table::create([
            'display_name' => 'users',
            'table_name' => 'users',
            'model_name' => 'User',
            'slug' => 'users',
            'fields' => json_encode([
                [
                    "field_name" => "id",
                    "field_type" => "id",
                    "unique" => false,
                    "default" => null,
                    "nullable" => false,
                    "accepts_file" => false,
                    "file_type" => "image",
                  ],
                [
                  "field_name" => "email",
                  "field_type" => "string",
                  "unique" => true,
                  "default" => null,
                  "nullable" => false,
                  "accepts_file" => false,
                  "file_type" => "image",
                ],
                [
                  "field_name" => "name",
                  "field_type" => "string",
                  "unique" => false,
                  "default" => null,
                  "nullable" => false,
                  "accepts_file" => false,
                  "file_type" => "image",
                ],
                [
                  "field_name" => "email_verified_at",
                  "field_type" => "timestamp",
                  "unique" => false,
                  "default" => null,
                  "nullable" => true,
                  "accepts_file" => false,
                  "file_type" => "image",
                ],
                [
                  "field_name" => "password",
                  "field_type" => "string",
                  "unique" => false,
                  "default" => null,
                  "nullable" => false,
                  "accepts_file" => false,
                  "file_type" => "image",
                ],
                [
                  "field_name" => "remember_token",
                  "field_type" => "rememberToken",
                  "unique" => false,
                  "default" => null,
                  "nullable" => false,
                  "accepts_file" => false,
                  "file_type" => "image",
                ],
              ]),
            'configure_fields' => json_encode([
                "id" => true,
                "name" => true,

                "email" => true,
                "email_verified_at" => false,
                "password" => false,
                "remember_token" => false,
            ])

        ]);

        // Create users table permissions
        Permission::create(['name' => 'can create users']);
        Permission::create(['name' => 'can read users']);
        Permission::create(['name' => 'can edit users']);
        Permission::create(['name' => 'can update users']);
    }
}
