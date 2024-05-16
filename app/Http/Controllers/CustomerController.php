<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
class CustomerController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';


    public function add(Request $request)
    {
        $data=[];
        return view('customer.add',$data);
    }
    public function store(Request $request)
    {
        //echo 1;
        //dd("hello world");
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100',
            'phone' => 'required|min:10|max:12',
            'email' => 'nullable|email|min:10|max:100',
            'address' => 'required|string|min:5|max:255',
        ]);



        //$userWithEmail = Customer::where('email', $request->email)->exists();
        $userWithPhone = Customer::where('phone', $request->phone)->exists();
        // if($userWithEmail)
        // {
        //     return back()->withInput()->withErrors(['error' => 'use another email']);

        // }
        if($userWithPhone)
        {
            return back()->withInput()->withErrors(['error' => 'Use another phone number']);

        }
        if(!$userWithPhone)
        {
            $customer = new Customer();
            $validatedData['created_by'] = auth()->user()->id;
            $validatedData['customer_id'] = $customer->getCustomerId();
            //dd($validatedData);
            $user = Customer::create($validatedData);
            return redirect()->back()->with('success', 'Customer created successfully.');
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
        return view('customer.list', compact('user'));
    }

    public function edit($encrypted_user_id)
    {

        // Decrypt the encrypted user ID
            $user_id = Crypt::decryptString($encrypted_user_id);

            // Retrieve the user based on the decrypted ID
            $user = Customer::findOrFail($user_id);

            // Pass the decrypted user to the view
            return view('customer.edit', compact('user'));
    }

    public function update(Request $request)
    {

        $user = Customer::findOrFail((int)$request->id);
        // Validation
       // dd((int)$user->id);
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100',
            'phone' => ['required', 'min:10', 'max:12', function ($attribute, $value, $fail) use ($user) {
                $existingUser = Customer::where('phone', $value)->where('id', '!=', $user->id)->first();
                if ($existingUser) {
                    $fail('The '.$value.' has already been taken.');
                }
            }],
            // 'email' => ['required', 'email', 'min:10', 'max:100', function ($attribute, $value, $fail) use ($user) {
            //     $existingUser = Customer::where('email', $value)->where('id', '!=', $user->id)->first();
            //     if ($existingUser) {
            //         $fail('The '.$value.' has already been taken.');
            //     }
            // }],
            'email' => 'nullable|string|min:6',
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
            return redirect()->back()->with('success', 'Customer Updated successfully.');

        }


        return back()->withInput()->withErrors(['error' => 'failed to save. Please check your inputs']);

    }

    public function destroy(Customer $user)
    {

        //dd($user);
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
       // $totalRecords = Customer::where('role','stuff')->count();

        // Calculate the offset
       // $offset = max(0, $totalRecords - $limit);

        // Fetch the last 10 records using limit and offset
       // $last10Records = User::orderBy('created_at', 'desc')->offset($offset)->limit( $limit)->get();
       $user = Auth::user();
       $records=[];
       //dd($user->isStuff());
       if($user->isAdmin())
       {
         return Customer::orderBy('id', 'desc')->get();
       }
       return  Customer::where('created_by',$user->id)->orderBy('id', 'desc')->get();


    }
    public function statusUpdate(Request $request,$encrypted_user_id)
    {
        $array = $request->all();

        $status = $request->input('active', 0);

       // dd(  $status  );
        $user_id = Crypt::decryptString($encrypted_user_id);
        $user = Customer::findOrFail($user_id);

        //dd( $user );
         $update['status']= (int) $status;
        if($update)
         {
            //dd($update);
            $isDone =  $user->update($update);
             //dd( $isDone );
             return redirect()->back()->with('success', 'Customer Updated successfully.');

         }
         return redirect()->back()->with('error', 'failed.');
    }
}

