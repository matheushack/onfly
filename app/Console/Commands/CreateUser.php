<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onfly:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->ask('What is your name?');
            $email = $this->ask('What is your email?');
            $password = $this->ask('What is your password?');

            User::updateOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'password' => Hash::make($password),
            ]);

            $this->info('User created!');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
