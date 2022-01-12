<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\UseCases\Users\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @var $userReposiroty
     * @return Application|Factory|View
     * @package App\Http\Controllers\Blog\Admin
     */
    private $userRepository;
    private $service;

    function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->service = app(UserService::class);

    }

    public function index(Request $request)
    {

        $users = $this->userRepository->getAllWithPaginate(5);

        if (empty($users)){

            return redirect()->route('admin.roles.create');
        }

        return view('admin.users.index',compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = $this->userRepository->getRoles();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {

        try {
            $user = $this->service->create($request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('users.index', $user)
            ->with(['success' => 'User created successfully!']);

    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        $user = $this->userRepository->getUser($user->id);
        return view('admin.users.show',compact('user'));
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $user = $this->userRepository->getUser($user->id);
        $roles = $this->userRepository->getRoles();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('admin.users.edit',compact('user','roles','userRole'));
    }

    /**
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        try {
            $this->service->update($user->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('users.index')
            ->with(['success' => 'User updated successfully!']);

    }

    /**
     * @return RedirectResponse
     */
    public function destroy($id)
    {

        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->back()
            ->with(['success' => 'Successful deleted!']);

    }
}
