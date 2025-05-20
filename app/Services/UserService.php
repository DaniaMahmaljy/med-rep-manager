<?php
namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\Admin;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\Mail;



class UserService extends Service
{
    public function __construct(protected PasswordService $passwordService)
    {

    }


    public function storeUser($data)
    {
        DB::beginTransaction();

        $userType = $data['user_type'];
        $roleName = UserTypeEnum::roleFromValue($userType);

        $userable = match($userType) {
            UserTypeEnum::ADMIN->value => Admin::create(),

            UserTypeEnum::SUPERVISOR->value => Supervisor::create([
                'city_id' => $data['city_id']
            ]),
            UserTypeEnum::REPRESENTATIVE->value => Representative::create([
                'municipal_id' => $data['municipal_id'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'address' => $data['address']
            ])
        };

        $plainPassword = $this->passwordService->generateTemporaryPassword();

        $user = User::create ([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],

        'username' => $this->generateUsername(
                $data['first_name'],
                $data['last_name']
            ),
        'email' => $data['email'],
        'password' => Hash::make($plainPassword),
       ]);

       $user->userable()->associate($userable);
       $user->save();

       $user->assignRole($roleName);
       Mail::to($user->email)->send(new UserCredentialsMail($user->username, $plainPassword));
       DB::commit();

       return $user;
    }



    protected function generateUsername($firstName, $lastName)
    {
        $base = Str::lower($firstName[0] . $lastName);
        $username = Str::slug($base, '');

        if (!User::where('username', $username)->exists()) {
            return $username;
        }

        do {
            $suffix = rand(1, 999);
            $username = $username . '_' . $suffix;
        } while (User::where('username', $username)->exists());

        return $username;
    }


}
