<?php

namespace App\Console\Commands;

use App\Models\Table;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make project ready for deployment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // Remove non-core tables stuff
        print("🔥 Removing non-core tables, models, permissions etc");
        $tables = Table::all();


        $whitelist = ['users'];

        foreach ($tables as $table) {
            if (!in_array($table->table_name, $whitelist)) {
                $table_name = $table->table_name;
                cg_delete_model($table_name);
                cg_delete_resource($table_name);
                cg_delete_table($table_name);
                tb_delete_perms($table_name);
            }
        }

        return 0;
    }
}
