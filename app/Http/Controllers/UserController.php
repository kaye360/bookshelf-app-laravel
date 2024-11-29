<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        Auth::login($user);

        $communityPost = new CommunityPostController;
        $communityPost->store(null, 'JOIN');
        return redirect('/books');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if( !Auth::attempt($validated) ) {
            throw ValidationException::withMessages([
                'username' => 'Incorrect username or password. Please try again.'
            ]);
        }
        $request->session()->regenerate();
        return redirect('/books');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
