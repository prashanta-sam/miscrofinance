<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
class UserController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function login()
    {
        // $users = User::all();

        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string|min:10|max:12',
            'password' => 'required|min:6',
        ]);
        //'email' => 'required|string|email|max:255|unique:users',

        if (Auth::attempt($credentials))
        {
            //dd(Auth::attempt($credentials));
            $user = Auth::user();
           // dd( $user);
            if($user->status==1)
            {
                $loginHistory = LoginHistory::create([
                    'user_id' => $user->id,
                    'login_at' => now(),
                    'ip_address' => request()->ip(),
                ]);
                 return redirect('/dashboard');
            }
            else
            {
                return back()->withInput()->withErrors(['error' => 'Login failed. User is inactive,please contact admin']);
            }

        }
         // Set errors array based on input errors
         $errors = $request->hasAny(['phone', 'password']);

        // If login fails, return back with error message
        return back()->withInput()->withErrors(['error' => 'Login failed. Please check your credentials.']);
    }


    public function add(Request $request)
    {
        $data=[];
        return view('stuff.add_user',$data);
    }
    public function store(Request $request)
    {
        //echo 1;
        //dd("hello world");
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100',
            'phone' => 'required|min:10|max:12',
            'email' => 'required|email|min:10|max:100',
            'password' => 'required|string|min:6',
            'address' => 'required|string|min:5|max:255',
        ]);



        $userWithEmail = User::where('email', $request->email)->exists();
        $userWithPhone = User::where('phone', $request->phone)->exists();
        if($userWithEmail)
        {
            return back()->withInput()->withErrors(['error' => 'use another email']);

        }
        if($userWithPhone)
        {
            return back()->withInput()->withErrors(['error' => 'Use another phone number']);

        }
        if(!$userWithEmail && !$userWithPhone)
        {
            $user = User::create($validatedData);
            return redirect()->back()->with('success', 'User created successfully.');
        }


        return back()->withInput()->withErrors(['error' => 'failed to save. Please check your inputs']);


       // Or with errors: ->withErrors(['error' => 'Error message']);    }
    }
    public function show(Request $request)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // get soft deleted users
        // $softDeletedUsers = User::withTrashed()->where('id', 43)->get();
        // dd($softDeletedUsers);

        $user = $this->fetchUsers($limit,$offset);
        //return response()->json($user);
        return view('stuff.list_stuff', compact('user'));
    }

    public function edit($encrypted_user_id)
    {

        // Decrypt the encrypted user ID
            $user_id = Crypt::decryptString($encrypted_user_id);

            // Retrieve the user based on the decrypted ID
            $user = User::findOrFail($user_id);

            // Pass the decrypted user to the view
            return view('stuff.edit_stuff', compact('user'));
    }

    public function update(Request $request)
    {

        $user = User::findOrFail((int)$request->id);
        // Validation
       // dd((int)$user->id);
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100',
            'phone' => ['required', 'min:10', 'max:12', function ($attribute, $value, $fail) use ($user) {
                $existingUser = User::where('phone', $value)->where('id', '!=', $user->id)->first();
                if ($existingUser) {
                    $fail('The '.$value.' has already been taken.');
                }
            }],
            'email' => ['required', 'email', 'min:10', 'max:100', function ($attribute, $value, $fail) use ($user) {
                $existingUser = User::where('email', $value)->where('id', '!=', $user->id)->first();
                if ($existingUser) {
                    $fail('The '.$value.' has already been taken.');
                }
            }],
            'password' => 'nullable|string|min:6',
            'address' => 'required|string|min:5|max:255,' . $user->id,
        ]);
       // $validatedData['added_by'] = 'admin';
        // Remove 'password' from $validatedData if it's null
        if ($request->filled('password')) {
            $validatedData['password'] = $validatedData['password'];
        } else {
            unset($validatedData['password']);
        }

        // Update user
        if($validatedData)
        {
            $user->update($validatedData);
            return redirect()->back()->with('success', 'User Updated successfully.');

        }


        return back()->withInput()->withErrors(['error' => 'failed to save. Please check your inputs']);

    }

    public function destroy(User $user)
    {

        // $user->delete();
        // return redirect()->back()->with('success', 'User deleted successfully.');
        $user->delete();
        // Check if soft deleted
        if ($user->trashed()) {
            return redirect()->back()->with('success', 'User soft deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'User delete failed.');
        }
    }

    public function fetchUsers($limit,$offset)
    {
        // Count the total number of records
        $totalRecords = User::where('role','stuff')->count();

        // Calculate the offset
       // $offset = max(0, $totalRecords - $limit);

        // Fetch the last 10 records using limit and offset
       // $last10Records = User::orderBy('created_at', 'desc')->offset($offset)->limit( $limit)->get();
        $last10Records = User::where('role','stuff')->orderBy('id', 'desc')->get();
        //dd($last10Records );
        return $last10Records;
    }


   public function statusUpdate(Request $request,$encrypted_user_id)
   {
       $array = $request->all();

       $status = $request->input('active', 0);

       //dd(  $status  );
       $user_id = Crypt::decryptString($encrypted_user_id);
       $user = User::findOrFail($user_id);

        $update['status']= (int) $status;
       if($update)
        {
            $user->update($update);
            return redirect()->back()->with('success', 'User Updated successfully.');

        }
   }
}

