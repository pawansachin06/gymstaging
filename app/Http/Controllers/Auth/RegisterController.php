<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    public function join(Request $request)
    {
        $services = Service::query()
            ->whereNotNull('variant')
            ->get(['id', 'name', 'slug', 'type'])
            ->groupBy('type');
        $steps = [[
            'title' => 'Get Discovered',
            'icon' => 'icons.fa.magnifying-glass',
            'content' => 'Appear when people are actively searching for your business.',
        ], [
            'title' => 'Win Enquiries',
            'icon' => 'icons.fa.comment-dots',
            'content' => 'Turn traffic into direct enquiries with a clear, trusted listing.',
        ], [
            'title' => 'Member Perks',
            'icon' => 'icons.fa.gift',
            'content' => 'Access exclusive perks from trusted industry partners.',
        ], ];
        return view('auth.join', [
            'steps' => $steps,
            'services' => $services,
        ]);
    }

    public function joinService(Request $request, Service $service)
    {
        $user = $request->user();
        return view('auth.join-service', ['service' => $service]);
    }

    public function register(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'newsletter' => ['nullable', 'boolean'],
        ]);
        try {
            return resJson('Testing', 422);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }
}
