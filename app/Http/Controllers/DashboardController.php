<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RecurringsEmi;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function index()
    {
       // dd(Auth::check());
        // $users = User::all();
        if (Auth::check())
        {
            $user = Auth::user();
            $data=[];
            if ($user->isAdmin())
            {
            //total collection
                $objCollection = DB::table('recurrings_emis')
                ->select(DB::raw('SUM(amount_of_emi) as totalCollection, IFNULL(SUM(fine),0)  as totalFine'))
                ->where('is_paid', 1)
                ->first();
                $objLoans = DB::table('loans')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->first();
                $objRDs = DB::table('recurrings')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->first();
                $objEmis = DB::table('emis')
                ->select(DB::raw('SUM(amount_of_emi) as  totalCollection,IFNULL(SUM(fine),0) as totalFine'))
                ->where('is_paid', 1)
                ->first();



                $totalActive = DB::table('customers')
                ->select(DB::raw('count(*) as activeCust'))
                ->where('status', 1)
                ->first();

                $totalActiveStuff = DB::table('users')
                ->select(DB::raw('count(*) as activeStuff'))
                ->where('status', 1)
                ->where('role', 'stuff')
                ->first();

                $data['total_loans']=$objLoans->totalLoan ?? 0;
                $data['total_rds'] = $objRDs->totalLoan ?? 0;

                $data['totalCollection']=$objCollection->totalCollection;
                $data['total_emis']=$objEmis->totalCollection;
                $data['totalFine']=$objCollection->totalFine + $objEmis->totalFine;

                $data['activeCust']=$totalActive->activeCust;
                $data['activeStuff']=$totalActiveStuff->activeStuff;




                //==================TODAY's
                $today = Carbon::today()->toDateString();
                $totalCustomers = DB::table('customers')
                ->select(DB::raw('count(*) as totalCust'))
                ->whereDate('created_at', $today)
                ->first();

                $objCollectionToday = DB::table('recurrings_emis')
                ->select(DB::raw('IFNULL(SUM(amount_of_emi),0) as totalCollection, IFNULL(SUM(fine),0)  as totalFine'),)
                ->where('is_paid', 1)
                ->whereDate('updated_at', $today)
                ->first();

                $objEmis = DB::table('emis')
                ->select(DB::raw('IFNULL(SUM(amount_of_emi),0) as totalCollection, IFNULL(SUM(fine),0) as totalFine'))
                ->where('is_paid', 1)
                ->whereDate('updated_at', $today)
                ->first();

                $totalActiveStuffToday = DB::table('users')
                ->select(DB::raw('count(*) as activeStuff'))
                ->where('status', 1)
                ->where('role', 'stuff')
                ->whereDate('created_at', $today)
                ->first();

                $objLoansToday = DB::table('loans')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->whereDate('created_at', $today)
                ->first();


                $objRDsToday = DB::table('recurrings')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->whereDate('created_at', $today)
                ->first();
               // dd($objCollectionToday);
                $data['today_fine']=$objCollectionToday->totalFine + $objEmis->totalFine ;
                $data['today_collection']=$objCollectionToday->totalCollection ?? 0;
                $data['today_emi_collection']=$objEmis->totalCollection ?? 0;
                $data['today_customer']=$totalCustomers->totalCust ?? 0;
                $data['today_stuff']=$totalActiveStuffToday->activeStuff ?? 0;
                $data['today_loans']=$objLoansToday->totalLoan ?? 0;
                $data['today_rds']=$objRDsToday->totalLoan ?? 0;

            }
            else
            {
                $objCollection = DB::table('recurrings_emis')
                ->join('recurrings', 'recurrings.rd_id', '=', 'recurrings_emis.rd_id')
                ->select(DB::raw('SUM(recurrings_emis.amount_of_emi) as totalCollection, IFNULL(SUM(recurrings_emis.fine),0)  as totalFine'))
                ->where('is_paid', 1)
                ->where('collected_by', $user->id)
                ->first();



                $objLoans = DB::table('loans')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->where('assigned_to', $user->id)
                ->first();



                $objRDs = DB::table('recurrings')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->where('assigned_to', $user->id)
                ->first();


                $objEmis = DB::table('emis')
                ->select(DB::raw('SUM(amount_of_emi) as  totalCollection,IFNULL(SUM(fine),0) as totalFine'))
                ->where('is_paid', 1)
                ->where('collected_by', $user->id)
                ->first();



                $totalActive = DB::table('customers')
                ->select(DB::raw('count(*) as activeCust'))
                ->where('status', 1)
                ->where('created_by', $user->id)
                ->first();






                $data['total_loans']=$objLoans->totalLoan ?? 0;
                $data['total_rds'] = $objRDs->totalLoan ?? 0;

                $data['totalCollection']=$objCollection->totalCollection;
                $data['total_emis']=$objEmis->totalCollection;
                $data['totalFine']=$objCollection->totalFine + $objEmis->totalFine;

                $data['activeCust']=$totalActive->activeCust;
                $data['activeStuff']= 0; //$totalActiveStuff->activeStuff;




                //==================TODAY's
                $today = Carbon::today()->toDateString();
                $totalCustomers = DB::table('customers')
                ->select(DB::raw('count(*) as totalCust'))
                ->whereDate('created_at', $today)
                ->where('created_by', $user->id)
                ->first();

                $objCollectionToday = DB::table('recurrings_emis')
                ->select(DB::raw('IFNULL(SUM(amount_of_emi),0) as totalCollection, IFNULL(SUM(fine),0)  as totalFine'),)
                ->where('is_paid', 1)
                ->whereDate('updated_at', $today)
                ->where('collected_by', $user->id)
                ->first();

                $objEmis = DB::table('emis')
                ->select(DB::raw('IFNULL(SUM(amount_of_emi),0) as totalCollection, IFNULL(SUM(fine),0) as totalFine'))
                ->where('is_paid', 1)
                ->whereDate('updated_at', $today)
                ->where('collected_by', $user->id)
                ->first();

                // $totalActiveStuffToday = DB::table('users')
                // ->select(DB::raw('count(*) as activeStuff'))
                // ->where('status', 1)
                // ->where('role', 'stuff')
                // ->whereDate('created_at', $today)
                // ->first();

                $objLoansToday = DB::table('loans')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->whereDate('created_at', $today)
                ->where('assigned_to', $user->id)
                ->first();


                $objRDsToday = DB::table('recurrings')
                ->select(DB::raw('SUM(amount) as totalLoan'))
                ->whereDate('created_at', $today)
                ->where('assigned_to', $user->id)
                ->first();
               // dd($objCollectionToday);
                $data['today_fine']=$objCollectionToday->totalFine + $objEmis->totalFine ;
                $data['today_collection']=$objCollectionToday->totalCollection ?? 0;
                $data['today_emi_collection']=$objEmis->totalCollection ?? 0;
                $data['today_customer']=$totalCustomers->totalCust ?? 0;
                $data['today_stuff']= 0; //$totalActiveStuffToday->activeStuff ?? 0;
                $data['today_loans']=$objLoansToday->totalLoan ?? 0;
                $data['today_rds']=$objRDsToday->totalLoan ?? 0;

            }
            $data['isAdmin']=$user->isAdmin();
            return view('dashboard', $data,compact('user'));
            // if ($user->isAdmin())
            // {
            //     $data=[];
            //     return view('dashboard', $data);

            // }
            // elseif ($user->isStuff())
            // {
            //     $data=[];
            //     return view('dashboard', $data)->render();
            // }

        }
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string|min:10|max:12',
            'password' => 'required|min:6',
        ]);
        //'email' => 'required|string|email|max:255|unique:users',
      // echo "sdfsfsfdsf";
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

