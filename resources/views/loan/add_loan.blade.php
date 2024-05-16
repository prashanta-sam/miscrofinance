
@extends('layout.app')

@section('title', 'Add Loan')

@section('content')
     <!--start content-->
     <main class="page-content">
      <!--breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          {{-- <div class="breadcrumb-title pe-3">Forms</div> --}}
          <div class="ps-3">
              <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                      <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">Add Loan</li>
                  </ol>
              </nav>
          </div>

      </div>
      <!--end breadcrumb-->
      <div class="row">
          <div class="col-xl-9 mx-auto">
              {{-- <h6 class="mb-0 text-uppercase">Browser defaults</h6>
              <hr/> --}}
              <div class="card">
                     <div class="card-body">
                        <div class="card border shadow-none radius-10">
                            <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                            <div class="icon-box bg-light-primary border-0">
                                <i class="bi bi-person text-primary"></i>
                            </div>
                            <div class="info">
                                <h6 class="mb-2">{{'Customer Details'}}</h6>
                                <p class="mb-1">Name :<strong>  {{ $customer->name }}</strong> </p>
                                <p class="mb-1">Phone :<strong> {{ $customer->phone }}</strong> </p>
                                <p class="mb-1">Registration Date :<strong> {{ $customer->created_at }}</strong> </p>
                            </div>
                            </div>
                        </div>
                      </div>

                      <div class="p-4 border rounded">
                          <form class="row g-3" method="POST" action="{{ route('store_loan') }}">
                              @csrf
                              @php
                              //   dd($errors);
                             @endphp

                            <div class="col-md-6">
                                <label for="validationDefault04" class="form-label">Account Number</label>

                                {{-- <select class="form-select" id="validationDefault04"
                                 name="custome_acc_id"  required>
                                 <option selected  value="">Select</option>
                                    @foreach ($customer as $item)
                                        <option value="{{ $item->customer_id }}" {{ old('custome_acc_id') == $item->customer_id  ? 'selected' : '' }}>{{ $item->customer_id }}</option>
                                    @endforeach
                                </select> --}}
                                <input type="number" class="form-control change" id="customer_acc_id"
                                    aria-describedby="inputGroupPrepend2" readonly   name="customer_acc_id" value="{{ $customer_id}}">
                                @if ($errors->has('customer_acc_id'))
                                        <div >{{ $errors->first('customer_acc_id') }}.</div>
                                @endif
                            </div>


                              <div class="col-md-6">
                                    <label for="type" class="form-label">Type of loan</label>
                                    <select class="form-select change" id="type"
                                     name="type" required>
                                        <option selected  value="">Select</option>
                                        {{-- <option value="D" {{ old('type') ==  'D' ? 'selected' : '' }}>Daily</option> --}}
                                        <option value="W" data-number="52" {{ old('type') == 'W'  ? 'selected' : '' }}>Weekly</option>
                                        <option value="M" data-number="12" {{ old('type') ==  'M' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <div >{{ $errors->first('type') }}.</div>
                                    @endif
                                </div>

                              <div class="col-md-4">
                                <label for="amount" class="form-label">Loan amount</label>
                                    <input type="number" class="form-control change" id="amount"
                                    aria-describedby="inputGroupPrepend2"   name="amount" value="{{ old('amount') }}" required>
                                    @if ($errors->has('amount'))
                                        <div >{{ $errors->first('amount') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="rate" class="form-label">Rate of Interest</label>
                                    <input type="text" class="form-control change" id="rate"
                                    aria-describedby="inputGroupPrepend2"  name="rate" value="{{ old('rate') }}" required>
                                    @if ($errors->has('rate'))
                                        <div >{{ $errors->first('rate') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="duration" class="form-label">duration</label>
                                    <input type="number" class="form-control change" id="duration"
                                    aria-describedby="inputGroupPrepend2"   name="duration" value="{{ old('duration') }}" required>
                                    @if ($errors->has('duration'))
                                        <div >{{ $errors->first('duration') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="no_of_emi" class="form-label">no of emi</label>
                                    <input type="number" class="form-control" id="no_of_emi"
                                    aria-describedby="inputGroupPrepend2"  readonly name="no_of_emi" value="{{ old('no_of_emi') }}" required>
                                    @if ($errors->has('no_of_emi'))
                                        <div >{{ $errors->first('no_of_emi') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="amount_of_emi" class="form-label">amout of emi</label>
                                    <input type="number" class="form-control" id="amount_of_emi"
                                    aria-describedby="inputGroupPrepend2" readonly  name="amount_of_emi" value="{{ old('amount_of_emi') }}" required>
                                    @if ($errors->has('amount_of_emi'))
                                        <div >{{ $errors->first('amount_of_emi') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="pa" class="form-label">Principle Amount</label>
                                    <input type="number" class="form-control" id="pa"
                                    aria-describedby="inputGroupPrepend2" readonly  name="pa" value="{{ old('pa') }}" required>
                                    @if ($errors->has('pa'))
                                        <div >{{ $errors->first('pa') }}.</div>
                                    @endif

                            </div>
                            <div class="col-md-4">
                                <label for="ti" class="form-label">Interest Amount</label>
                                    <input type="number" class="form-control" id="ti"
                                    aria-describedby="inputGroupPrepend2" readonly  name="ti" value="{{ old('ti') }}" required>
                                    @if ($errors->has('ti'))
                                        <div >{{ $errors->first('ti') }}.</div>
                                    @endif

                            </div>

                              {{-- <div class="col-md-3">
                                  <label for="validationDefault05" class="form-label">Zip</label>
                                  <input type="text" class="form-control" id="validationDefault05" required>
                              </div> --}}
                              {{-- <div class="col-12">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                                      <label class="form-check-label" for="invalidCheck2">Agree to terms and conditions</label>
                                  </div>
                              </div> --}}
                              <div class="col-12">
                                  <button class="btn btn-primary" type="submit">Save</button>
                              </div>
                              {{-- <button type="button" class="btn btn-success px-5" onclick="success_noti()">
                                  <i class="bx bx-check-circle mr-1"></i> Success</button> --}}
                              @if ($errors->has('error'))
                                  <div style="color: red" >{{ $errors->first('error') }}.</div>
                             @endif
                             @if (session('success'))
                                <div class="alert alert-success" id="successMessage">
                                    {{ session('success') }}
                                </div>
                                <script>
                                    // Use setTimeout to remove the success message after 2 seconds
                                    setTimeout(function() {
                                        var successMessage = document.getElementById('successMessage');
                                        if (successMessage) {
                                            successMessage.remove();
                                        }
                                    }, 2000); // 2000 milliseconds = 2 seconds
                                </script>
                            @endif
                          </form>
                      </div>
                  </div>
              </div>


          </div>
      </div>
      <!--end row-->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

      <script>
        // Calculate EMI function
        // monthy : 24 max  min: 2
        //weekly : 104 weeks max, min : 4
        // 1000 *10= Total loan amount = 1100/12 =
        $(document).ready(function() {
            $(document).on('change', '.change', function() {
                // This function will be called when the value of any element with the class 'change' changes
                console.log('Dropdown value changed');
                document.getElementById('no_of_emi').value=0
                document.getElementById('amount_of_emi').value=0
                document.getElementById('pa').value=0
                document.getElementById('ti').value=0
                calculateEMI(); // Call your function here
            });
        });

        function calculateEMI() {
            let type = $("#type").find('option:selected');

            // Get the value and data attribute of the selected option
            let optionValue = type.val();
            let week_cum_month = type.data('number');

            let loanAmount = parseFloat(document.getElementById('amount').value);
            let interestRate = parseFloat(document.getElementById('rate').value);
            let loanDuration = parseFloat(document.getElementById('duration').value);
            //let week_cum_month = type =='W' ?
            let monthlyInterestRate = (interestRate / week_cum_month) / 100;
            let emi = loanAmount * monthlyInterestRate * Math.pow((1 + monthlyInterestRate), loanDuration) / (Math.pow((1 + monthlyInterestRate), loanDuration) - 1);

            // Round off EMI to 2 decimal places
            emi = Math.round(emi * 100) / 100;
            let pa= (emi * loanDuration)
            document.getElementById('no_of_emi').value =  loanDuration;
            document.getElementById('pa').value=Math.round(pa);
            document.getElementById('ti').value=Math.round(pa - loanAmount);
            // Display EMI result
            document.getElementById('amount_of_emi').value = Math.round(emi);
        }

                // Get the input element
            var input = document.getElementById('rate');
            // Add event listener for input event
            input.addEventListener('input', function(event) {
                // Get the input value
                var value = input.value;

                // Replace any non-numeric characters with an empty string
                value = value.replace(/[^0-9.]/g, '');
                // Ensure only one decimal point is allowed
                var decimalCount = (value.match(/\./g) || []).length;
                    if (decimalCount > 1) {
                        value = value.substr(0, value.lastIndexOf('.'));
                    }

                // Update the input value
                input.value = value;
           });
    </script>
  </main>
<!--end page main-->
  @endsection
