<?php

namespace App\UseCases\Users;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @var User $user
     */
    private $userRepository;

    function __construct()
    {
        $this->userRepository = app(UserRepository::class);

    }

    public function create(UserStoreRequest $request)
    {

        return DB::transaction(function () use ($request) {

            $user = User::make([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=> Hash::make($request['password'])
            ]);

            $user->assignRole($request->input('roles'));

            $user->saveOrFail();

            return $user;
        });
    }


    public function update($id, UserUpdateRequest $request): void
    {
        $user = $this->userRepository->getUser($id);
        $user->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=> Hash::make($request['password'])
        ]);
        $user->assignRole($request->input('roles'));

    }

    public function remove($id): void
    {
        $post = $this->userRepository->getUser($id);
        $post->delete();
    }

}
