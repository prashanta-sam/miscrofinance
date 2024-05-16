
@extends('layout.app')

@section('title', 'Loan Collection')

@section('content')

    @php

        //$encrypted_id = Crypt::encryptString(123);
            //dd($encrypted_id);
    @endphp
    <style>

        #divHide{
            display: block;
        }
    </style>
      <!--start content-->
      <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="ps-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">List of EMIs</li>
              </ol>
            </nav>
          </div>

        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase"></h6>
        <hr/>
        @php
           // dd($errors);
        @endphp
        @if ($errors->has('error'))
                <div style="color: red" >{{ $errors->first('error') }}.</div>
        @endif
        <div class="card">
            @if(!empty($customer))
            <div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-3">
                <div class="col">
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
                </div>
                <div class="col">
                    <div class="card border shadow-none radius-10">
                      <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                          <div class="icon-box bg-light-danger border-0">
                            <i class="bi bi-geo-alt text-danger"></i>
                          </div>
                          <div class="info">
                            <h6 class="mb-2">Loan Summary</h6>
                            @php
                                $customFormatDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $customer->loan_created_at )->format('d/m/Y');
                            @endphp
                            <p class="mb-1"><strong>Created Date </strong> : {{ $customFormatDate}}</p>
                            <p class="mb-1"><strong>Loan Amount {{ env('DB_RUPEE') }}</strong> : &#8377 {{ $customer->amount }}</p>
                            <p class="mb-1"><strong>Interest Charged {{ env('DB_RUPEE') }}</strong> : &#8377 {{ $customer->ti }}</p>
                            <p class="mb-1"><strong>Total Amount to be paid {{ env('DB_RUPEE') }}</strong> : &#8377 {{ $customer->pa }}</p>
                            <p class="mb-1"><strong>Total EMI paid  {{ env('DB_RUPEE') }}</strong> : &#8377 {{ $totalEmis->total_emi_paid }}</p>
                            <p class="mb-1"><strong>Total fines {{ env('DB_RUPEE') }}</strong> : &#8377 {{ $totalEmis->total_fines }}</p>
                          </div>
                        </div>
                      </div>
                     </div>
                </div>
            </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table id="emi_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>

                                <th>EMI No.</th>
                                <th>EMI Amount{{ env('DB_RUPEE') }}</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Fine{{ env('DB_RUPEE') }}</th>
                                <th>Action</a>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emi as $item)

                            <tr>
                                {{-- <td data-name="{{ $item->id }}">{{ $item->customer_acc_id }}</td> --}}
                                <td>{{ $item->emi_no }}</td>
                                <td>&#8377 {{ $item->amount_of_emi }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->due_date  )->format('d/m/Y') }}</td>

                                <td>
                                    @if($item->is_paid ==0)
                                        {{-- <div class="form-check-danger form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDanger" checked="">
                                            <label class="form-check-label" for="flexSwitchCheckCheckedDanger">Collect</label>
                                        </div> --}}
                                        {{-- <span class="badge bg-light-success text-success w-100">Paid</span> --}}
                                        <span class="badge bg-light-warning w-100" style="color: #cca32a;">Due</span>
                                    @else
                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
                                            <label class="form-check-label" for="flexCheckChecked">Collected</label>
                                        </div> --}}
                                        <span class="badge bg-light-success text-success w-100">Paid</span>
                                    @endif


                                </td>
                                <td>{{ $item->fine }}</td>
                                <td>
                                    @if($item->is_paid ==0)
                                    <div class="row">
                                        <div class="col-4" >
                                            <div class="form-check-danger form-check form-switch" >
                                                <input class="form-check-input collectChk" type="checkbox" data-id="{{ $item->id}}" id="collect" style="cursor: pointer;">
                                                <label class="form-check-label" for="collect">Collect</label>
                                            </div>
                                        </div>



                                            <form method="POST" id="divHide" action="{{ route('update_emi',Crypt::encryptString($item->id)) }}">
                                                @csrf
                                                @method('PUT')
                                                         <input type="hidden" name="emi_id" value="{{ $item->id }}">

                                                    <div class="col-4">
                                                        <input class="form-control" type="number" id="fine" name="fine" placeholder="Enter fine">
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-primary btnCollect"  id="div_{{ $item->id}}_btn" type="submit">collect</button>
                                                    </div>
                                                </form>

                                        </div>
                                    @else
                                        <div class="form-check-danger form-check form-switch" >
                                            <input class="form-check-input collectChk" type="checkbox" checked disabled>
                                        </div>
                                        @php
                                            $updated_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$item->updated_at  )->format('d/m/Y h:i A');
                                        @endphp
                                        <label class="form-check-label" for="collect">Collected by
                                            <span style="font-size:18px;">{{ $item->customer_name }}</span></br>
                                            <span style="font-size:15px;"> on {{ $updated_at }}</span>
                                        </label>

                                    @endif


                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>

                </div>

                {{ $emi->links('pagination.custom') }}

            </div>
        </div>
        @if (session('success'))
            <script>
                // Open a popup window
                window.onload = function() {
                    alert("{{ session('success') }}")
                };
            </script>
        @endif


      </main>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <script>

          $(document).ready(function() {
            // Check if elements with class "btnCollect" exist
            if ($('.btnCollect').length === 0) {
                console.warn('No elements with class "btnCollect" found');
            } else {
                console.log('Found elements with class "btnCollect"');
                // Hide elements with class "btnCollect"
                $('.btnCollect').hide();
            }

            // Check if elements with class "collectChk" exist
            if ($('.collectChk').length === 0) {
                    console.warn('No elements with class "collectChk" found');
                } else {
                    console.log('Found elements with class "collectChk"');
                    // Attach change event listener to elements with class "collectChk"
                    $(document).on('change','.collectChk',function(){
                        let id = $(this).data('id');
                        let btn = `div_${id}_btn`;
                        let checked = $(this).is(':checked');
                        if(checked)
                        {

                            $(`#${btn}`).show();
                        }
                        else  {

                            $(`#${btn}`).hide();}
                    });
                }
            // Add more tables as needed
        });
    </script>


   <!--end page main-->
   @endsection
