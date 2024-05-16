<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function index()
    {

        return view('admin.settings');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string|min:10|max:12',
            'password' => 'required|min:6',
        ]);
        //'email' => 'required|string|email|max:255|unique:users',
       echo "sdfsfsfdsf";
        if (Auth::attempt($credentials))
        {
            $user = Auth::user();
            return redirect('dashboard');

        }

        // Authentication failed...
        return back()->withInput()->withErrors(['email' => 'Invalid credentials']);
    }



    public function addCustomer(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|min:10|max:100',
            'email' => 'sometimes|nullable|email|unique:users,email', // optional
            'address' => 'required|string|min:6|max:255',
            'phone' => 'required|string|min:10|max:12',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Create user
        $user = Customer::create($validatedData);
        return redirect()->back()->with('success', 'User created successfully.');
        // Or with errors: ->withErrors(['error' => 'Error message']);    }
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update user
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}

