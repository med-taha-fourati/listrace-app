<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Admin\Admin;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listrace:make-admin {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a regular user an admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = $this->argument('userId');
        
        $userData = User::where('id', $user)->first();

        $newAdmin = Admin::create([
            'name' => $userData["name"],
            'email' => $userData["email"],
            'password' => $userData["password"]
        ]);
        $userData['admin_id'] = $newAdmin->id;
        $userData->save();

        echo "Made ". $userData["name"] . " an admin";
    }
}
