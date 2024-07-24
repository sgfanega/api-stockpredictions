<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register {name} {email} {password} {password_confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->doesAUserExist();

        $data = $this->arguments();

        $request = new StoreUserRequest();

        $request->replace($data);

        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            foreach( $validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        };

        $validatedData = $validator->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        $this->info("User {$user->name} registered successfully with email {$user->email}.");
    }

    /**
     * Checks whether a User already exists.
     * 
     * @return
     */
    private function doesAUserExist()
    {
        if (User::count() > 0) {
            $this->error("A user already exists. Only one is allowed. Registration is not allowed.");
            return;
        }
    }
}
