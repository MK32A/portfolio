<?php

namespace App\Http\Controllers\PaidMember\Auth;

use App\Http\Controllers\Controller;
use App\Models\PaidMember;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('PaidMember/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // 'name' => 'required|string|max:255',
            // 'kana' => 'required|string|max:255',
            // 'tel' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:'.PaidMember::class,
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'postcode' => 'required|string|max:255',
            // 'address' => 'required|string|max:255',
            // 'birthday' => 'date',
            // 'gender' => 'required|tinyInt',
            // 'memo' => 'text|max:1000',
        ]);

        Auth::guard('paid_members')->login($user = PaidMember::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'postcode' => $request->postcode,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'memo' => $request->memo,
        ]));

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::PAID_MEMBER_HOME);
    }
}