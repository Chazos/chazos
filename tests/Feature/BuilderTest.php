<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BuilderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory(User::class)->create();

        try{
            $this->user->assignRole('admin');
        }catch(\Exception $e){
            $role = Role::create(['name' => 'admin']);
            $this->user->assignRole($role);
        }

    }


    public function test_can_create_table()
    {

        $response = $this->actingAs($this->user)
                         ->post('/tables/create', [
            "name" => "dogs",
            "display_name" => "Dogs",
            "configure_fields" => [
                "name" => true,
                "breed" => true,
                "age" => true
            ],
            "fields" => [
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "name",
                    "field_type" => "string",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ],
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "breed",
                    "field_type" => "string",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ],
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "age",
                    "field_type" => "integer",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ]
            ],
            "actions" => [
                [
                    "identifier" => "approve_client",
                    "display_name" => "Approve Client",
                    "svg_icon" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                ]
            ],
        ]);



        $response->assertJson(['status' => 'success',
        'message' => 'Table Created',]);

        $this->assertDatabaseHas("table_list", [
            "table_name" => "dogs"
        ]);
    }

    public function test_can_add_entry_to_table(){

        $response = $this->actingAs($this->user)
                         ->post('/manage/dogs/create', [
                            "name" => "Tom",
                            "breed" => "Tibetan Mastiff",
                            "age" => 10
                         ]);

        $response->assertJson([
            'status' => 'success',
            'message' => 'Entry created successfully']);

    }

    public function test_can_update_entry_in_table(){

        DB::table('dogs')->insert([
            "name" => "Tom",
            "breed" => "Tibetan Mastiff",
            "age" => 10
        ]);
        $dog = DB::table('dogs')->where('name', 'Tom')->first();


        $response = $this->actingAs($this->user)
                         ->post("/manage/dogs/update/$dog->id", [
                            "name" => "Tom",
                            "breed" => "Tibetan Mastiff",
                            "age" => 10
                         ]);

        $response->assertJson([
            'status' => 'success',
            'message' => 'Entry edited successfully']);

    }

    public function test_can_delete_entry_in_table(){

        DB::table('dogs')->insert([
            "name" => "Terry",
            "breed" => "German Shepherd",
            "age" => 5
        ]);
        $dog = DB::table('dogs')->where('name', 'Terry')->first();

            $response = $this->actingAs($this->user)
                            ->post("/manage/dogs/delete/$dog->id");

            $response->assertJson([
                'status' => 'success',
            'message' => 'Record has been deleted successfully.']);

    }

    public function test_can_update_table(){
        $table = DB::table('table_list')->where('table_name', "dogs")->first();
        $response = $this->actingAs($this->user)
                         ->post("/tables/update/$table->id", [
            "table_name" => "dogs",
            "display_name" => "Dogs",
            "configure_fields" => [
                "name" => true,
                "breed" => true,
                "age" => true
            ],
            "fields" => [
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "name",
                    "field_type" => "string",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ],
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "breed",
                    "field_type" => "string",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ],
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "age",
                    "field_type" => "integer",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ],
                [
                    "accepts_file" => "false",
                    "default" => "",
                    "field_name" => "color",
                    "field_type" => "string",
                    "file_type" => "image",
                    "nullable" => "true",
                    "unique" => "true"
                ]
            ],
            "actions" => [
                [
                    "identifier" => "approve_client",
                    "display_name" => "Approve Client",
                    "svg_icon" => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                ],

            ],
            "perms" => [
                "admin" => [
                    "read" => true
                ]
            ]
        ]);

        $response->assertJson(['status' => 'success',
        'message' => 'Table Updated']);
    }

    public function test_can_delete_table(){
        $table = DB::table('table_list')->where('table_name', "dogs")->first();
        $response = $this->actingAs($this->user)
                         ->post("/tables/delete/$table->id");

        $response->assertJson(['status' => 'success',
        'message' => 'Table Deleted Successfully']);

        $this->assertDatabaseMissing("table_list", [
            "table_name" => "dogs"
        ]);
    }
}
