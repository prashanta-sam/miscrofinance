<?php

namespace App\Http\Controllers;
use App\Models\Emi;
use App\Models\RecurringsEmi;
use App\Models\Recurring;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class RecurringDipositeController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';



    public function add($customer_id)
    {
        $customer_id = Crypt::decryptString($customer_id);
        //dd($customer_id);
        $customer = Customer::where('customer_id',$customer_id)->first();
        return view('RD.add_rd',compact('customer_id','customer'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'type' => 'required|string|min:1',
            'customer_acc_id' => 'required|min:5',
            'amount' => 'required|numeric|min:0.01|max:1000000',
            'rate' => 'required|numeric|min:0.01|max:50',
            'duration' => 'required|numeric|min:1',
            'no_of_emi' => 'required|numeric|min:1',
            'amount_of_emi' => 'required|numeric|min:1',
            'pa' => 'required|numeric|min:100',
            'ti' => 'required|numeric|min:10',
        ],
        [
            'customer_acc_id.required'=> 'Account number is Required', // custom message
            'code.numeric'=> 'Account number must be Number', // custom message

         ]
    );


        $validatedData['assigned_to'] = auth()->user()->id;
        if($validatedData)
        {
            $rd_id = Recurring::create($validatedData)->rd_id;
            //dd($rd_id );
            $done = $this->createEMIDaily($rd_id);


            //return redirect()->route('route_name')->with('success', 'Collection('.$rd_id.') is created successfully.');
            return redirect()->back()->with('success', 'Collection('.$rd_id.') is created successfully.');
        }


        return back()->withInput()->withErrors(['error' => 'failed to save. Please check your inputs']);


       // Or with errors: ->withErrors(['error' => 'Error message']);    }
    }

    public function createEMIDaily($rd_id)
    {



                                // Get current date
                                $currentDate = Carbon::now();

                                // Get the loan details from the database
                                $loan = Recurring::where('rd_id', $rd_id)->firstOrFail();

                                //dd(   $loan );
                                // Initialize an array to store EMI records
                                $emis = [];

                                // Loop through the next 12 months
                                for ($i = 1; $i <= $loan->duration; $i++) {
                                    // Add $i months to the current date
                                    $emiDate = $currentDate->copy()->addDays($i);
                                  //  dd(   $emiDate );

                                    // Create EMI record
                                    $emis[] = [
                                        'rd_id' => $rd_id,
                                        'emi_no'=>$i,
                                        'due_date' => $emiDate,
                                        'amount_of_emi' => $loan->amount_of_emi,
                                        // Add other EMI fields as needed
                                    ];
                                }

                                // Insert EMI records into the database
                                $emi = RecurringsEmi::insert($emis);
                                return $emi;
    }

    public function show(Request $request)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // get soft deleted users
        // $softDeletedUsers = User::withTrashed()->where('id', 43)->get();
        // dd($softDeletedUsers);

        $rd = $this->fetchUsers();

        return view('RD.list_rd', compact('rd'));
    }
    public function showByCust($encrypted_user_id)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // get soft deleted users
        // $softDeletedUsers = User::withTrashed()->where('id', 43)->get();
        // dd($softDeletedUsers);
        $customer_id = Crypt::decryptString($encrypted_user_id);
        $rd =$this->fetchUsers($customer_id);
        $customer = Customer::where('customer_id',$customer_id)->first();
        return view('RD.list_rd', compact('rd','customer'));
    }

    public function showEmi($encrypted_user_id)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;
        $rd_id = Crypt::decryptString($encrypted_user_id);


        $emi = RecurringsEmi::select('recurrings_emis.*','users.name as customer_name')
        ->join('recurrings', 'recurrings.rd_id', '=', 'recurrings_emis.rd_id')
        ->leftJoin('users', 'users.id', '=', 'recurrings_emis.collected_by')
        ->where('recurrings_emis.rd_id', $rd_id)->paginate(10);



        $customer = Recurring::join('customers', 'recurrings.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.*','recurrings.ti','recurrings.pa','recurrings.created_at as loan_created_at')
                    ->where('rd_id',$rd_id)
                    ->first();
        $totalEmis = RecurringsEmi::selectRaw('SUM(recurrings_emis.amount_of_emi) as total_emi_paid, SUM(recurrings_emis.fine) as total_fines')
                ->join('recurrings', 'recurrings.rd_id', '=', 'recurrings_emis.rd_id')
                ->where('recurrings.rd_id', $rd_id)
                ->first();

        return view('RD.collect_rd_emi', compact('emi','customer','totalEmis'));
    }

    public function edit($encrypted_user_id)
    {

        // Decrypt the encrypted user ID
            $user_id = Crypt::decryptString($encrypted_user_id);

            // Retrieve the user based on the decrypted ID
            $user = User::findOrFail($user_id);

            // Pass the decrypted user to the view
            return view('loan.edit_stuff', compact('user'));
    }

    public function updateEmi(Request $request,$encrypted_user_id)
    {
        $emi_id = Crypt::decryptString($encrypted_user_id);

        $emi = RecurringsEmi::findOrFail((int) $emi_id);

        //  if((int) $request->input('fine') == 0 || (int) $request->input('fine') == null)
        //  {
        //     return redirect()->back()->with('error', 'Collection failed.');
        //  }
        $validatedData['fine']=(int) $request->input('fine') ;
        $validatedData['is_paid']=1;
        $validatedData['collected_by']=auth()->user()->id;

        // Update user

           // dd( $validatedData);
        if($validatedData)
        {
            $emi->update($validatedData);

            $loan = Recurring::where('rd_id',$emi->rd_id)->first();
            $total_emis = RecurringsEmi::where('rd_id', $emi->rd_id)->count();
            $is_paid = RecurringsEmi::where('rd_id', $emi->rd_id)
                         ->where('is_paid',1)->count();
          // dd($loan);
         // dd($is_paid ,$total_emis);
            if($is_paid == $total_emis)
            {
                //dd($loan);
                $update['status']=2;
                $loan->update($update);
            }

            return redirect()->back()->with('success', 'Collection is Updated successfully.');

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
    public function fetchUsers($limit=0,$offset=0)
    {

       $user = Auth::user();
       $records=[];
       //dd($user->isStuff());
       if($user->isAdmin())
       {
         return Recurring::join('customers', 'recurrings.customer_acc_id', '=', 'customers.customer_id')
                    ->select('customers.name','customers.phone', 'recurrings.*')->orderBy('id', 'desc')->get();
       }
       return  Recurring::join('customers', 'recurrings.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.name','customers.phone', 'recurrings.*')
                    ->where('assigned_to',$user->id)->orderBy('id', 'desc')->get();


    }
    // public function fetchLoan($customer_id)
    // {

    //    $user = Auth::user();
    //    $records=[];
    //    //dd($user->isStuff());
    //    if($user->isAdmin())
    //    {
    //      return Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
    //                 ->select('customers.name','customers.phone', 'loans.*')
    //                 ->where('customer_id',$customer_id)
    //                 ->orderBy('id', 'desc')->get();
    //    }
    //    return  Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
    //                  ->select('customers.name','customers.phone', 'loans.*')
    //                 ->where('assigned_to',$user->id)
    //                 ->where('customer_id',$customer_id)
    //                 ->orderBy('id', 'desc')->get();


    // }
}

