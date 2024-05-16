<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\Emi;
use App\Models\Customer;
use App\Models\Recurring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class LoanController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/login';



    public function add($customer_id)
    {
        $customer_id = Crypt::decryptString($customer_id);
        //dd($customer_id);
        $customer = Customer::where('customer_id',$customer_id)->first();
        return view('loan.add_loan',compact('customer_id','customer'));
    }
    public function store(Request $request)
    {
        //echo 1;
        //dd("hello world");
        // Validation
        $validatedData = $request->validate([
            'type' => 'required|string|min:1',
            'customer_acc_id' => 'required|min:5',
            'amount' => 'required|numeric|min:0.01|max:1000000',
            'rate' => 'required|numeric|min:0.01|max:50',
            'duration' => 'required|numeric|min:1',
            'no_of_emi' => 'required|numeric|min:1',
            'amount_of_emi' => 'required|numeric|min:1',
            'pa' => 'required|numeric|min:1000',
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
            $loan_id = Loan::create($validatedData)->loan_id;
           // dd($loan_id );
            $done = $this->createEMI($loan_id);



            return redirect()->back()->with('success', 'Loan('.$loan_id.') is created successfully.');
        }


        return back()->withInput()->withErrors(['error' => 'failed to save. Please check your inputs']);


       // Or with errors: ->withErrors(['error' => 'Error message']);    }
    }

    public function createEMI($loan_id)
    {



                                // Get current date
                                $currentDate = Carbon::now();

                                // Get the loan details from the database
                                $loan = Loan::where('loan_id', $loan_id)->firstOrFail();

                               // dd(   $loan );
                                // Initialize an array to store EMI records
                                $emis = [];

                                // Loop through the next 12 months
                                for ($i = 1; $i <= $loan->duration; $i++) {
                                    // Add $i months to the current date
                                    $emiDate = $currentDate->copy()->addMonths($i);
                                  //  dd(   $emiDate );

                                    // Create EMI record
                                    $emis[] = [
                                        'loan_id' => $loan_id,
                                        'emi_no'=>$i,
                                        'due_date' => $emiDate,
                                        'amount_of_emi' => $loan->amount_of_emi,
                                        // Add other EMI fields as needed
                                    ];
                                }

                                // Insert EMI records into the database
                                $emi = Emi::insert($emis);
                                return $emi;
    }
    public function show(Request $request)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // get soft deleted users
        // $softDeletedUsers = User::withTrashed()->where('id', 43)->get();
        // dd($softDeletedUsers);

        $loan = $this->fetchUsers();
        //dd($loan);
        //return response()->json($user);
        //$customer = Customer::where('customer_id',$customer_id)->first();
        return view('loan.list_loan', compact('loan'));
    }
    public function showByCust($encrypted_user_id)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // get soft deleted users
        // $softDeletedUsers = User::withTrashed()->where('id', 43)->get();
        // dd($softDeletedUsers);
        $customer_id = Crypt::decryptString($encrypted_user_id);
        $loan =$this->fetchLoan($customer_id);
        $rd =$this->fetchRecurr($customer_id);

        $customer = Customer::where('customer_id',$customer_id)->first();
        return view('loan.list_loan', compact('loan','customer','rd'));
    }

    public function showEmi($encrypted_user_id)
    {
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;
        $loan_id = Crypt::decryptString($encrypted_user_id);
        //$emi = Emi::where('loan_id', $loan_id)->get();
        $emi = Emi::select('emis.*','users.name as customer_name')
        ->join('loans', 'loans.loan_id', '=', 'emis.loan_id')
        ->leftJoin('users', 'users.id', '=', 'emis.collected_by')
        ->where('emis.loan_id', $loan_id)->paginate(10);

        $customer = Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.*','loans.amount','loans.ti','loans.pa','loans.created_at as loan_created_at')
                    ->where('loan_id',$loan_id)
                    ->first();
       $totalEmis = Emi::selectRaw('SUM(emis.amount_of_emi) as total_emi_paid, SUM(emis.fine) as total_fines')
                    ->join('loans', 'loans.loan_id', '=', 'emis.loan_id')
                    ->where('loans.loan_id', $loan_id)
                    ->first();
        //dd( $totalEmis);
        return view('loan.collect_emi', compact('emi','customer','totalEmis'));
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

        $emi = Emi::findOrFail((int) $emi_id);
        // Validation
        //dd($emi);
        // $validatedData = $request->validate([
        //     'fine' => 'required|string|min:3' . $emi->id,
        // ]);
       // $validatedData['added_by'] = 'admin';
        // Remove 'password' from $validatedData if it's null
        //  if((int) $request->input('fine') == 0 || (int) $request->input('fine') == null)
        //  {
        //     return redirect()->back()->with('error', 'Collection failed.');
        //  }
        $validatedData['fine']=(int) $request->input('fine') ??  0 ;
        $validatedData['is_paid']=1;
        $validatedData['collected_by']=auth()->user()->id;

        // Update user

           // dd( $validatedData);
        if($validatedData)
        {
            $emi->update($validatedData);
            $loan = Loan::where('loan_id',$emi->loan_id)->first();
            $total_emis = Emi::where('loan_id', $emi->loan_id)->count();
            $is_paid = Emi::where('loan_id', $emi->loan_id)
                         ->where('is_paid',1)->count();
          // dd($loan);
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
         return Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
                    ->select('customers.name','customers.phone', 'loans.*')->orderBy('id', 'desc')->get();
       }
       return  Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.name','customers.phone', 'loans.*')
                    ->where('assigned_to',$user->id)->orderBy('id', 'desc')->get();


    }
    public function fetchLoan($customer_id)
    {

       $user = Auth::user();
       $records=[];
       //dd($user->isStuff());
       if($user->isAdmin())
       {
         return Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
                    ->select('customers.name','customers.phone', 'loans.*')
                    ->where('customer_id',$customer_id)
                    ->orderBy('id', 'desc')->get();
       }
       return  Loan::join('customers', 'loans.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.name','customers.phone', 'loans.*')
                    ->where('assigned_to',$user->id)
                    ->where('customer_id',$customer_id)
                    ->orderBy('id', 'desc')->get();


    }

    public function fetchRecurr($customer_id)
    {

       $user = Auth::user();
       $records=[];
       //dd($user->isStuff());
       if($user->isAdmin())
       {
         return Recurring::join('customers', 'recurrings.customer_acc_id', '=', 'customers.customer_id')
                    ->select('customers.name','customers.phone', 'recurrings.*')
                    ->where('customer_id',$customer_id)
                    ->orderBy('id', 'desc')->get();
       }
       return  Recurring::join('customers', 'recurrings.customer_acc_id', '=', 'customers.customer_id')
                     ->select('customers.name','customers.phone', 'recurrings.*')
                    ->where('assigned_to',$user->id)
                    ->where('customer_id',$customer_id)
                    ->orderBy('id', 'desc')->get();


    }
}

