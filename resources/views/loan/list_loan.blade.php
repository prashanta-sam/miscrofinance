
@extends('layout.app')

@section('title', 'List of Loans')

@section('content')

    @php

        //$encrypted_id = Crypt::encryptString(123);
            //dd($encrypted_id);
    @endphp
      <!--start content-->
      <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
          <div class="ps-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">List of Loans</li>
              </ol>
            </nav>
          </div>

        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase"></h6>
        <hr/>
        <div class="card">
            @if(!empty($customer))
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
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table id="loans_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>A/C Number</th>
                                {{-- <th>Customer Name</th>
                                <th>Phone</th> --}}
                                <th>Loan ID</th>
                                {{-- <th>Created at</th> --}}
                                <th>Loan Amount</th>
                                <th>Emi Amount</th>
                                <th>No of EMI(s)</th>
                                <th>Status</th>
                                <th>Action</a>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan as $item)
                                <tr>
                                    <td data-name="{{ $item->id }}">{{ $item->customer_acc_id }}</td>
                                    {{-- <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td> --}}
                                    <td>{{ $item->loan_id }}</td>
                                    {{-- <td>{{ $item->created_at }}</td> --}}
                                    <td>&#8377 {{ $item->amount }}</td>
                                    <td>&#8377 {{ $item->amount_of_emi }}</td>
                                    <td>{{ $item->no_of_emi }}</td>
                                    <td>{{ $item->status ==1? 'Active' : 'closed'}}</td>
                                    <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">

                                        <a href="{{ route('show_emi',Crypt::encryptString($item->loan_id)) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Views"><button type="button" class="btn btn-sm btn-primary"><i class="fadeIn animated bx bx-plus pe1 fs-5"></i>Collect</button></a>
                                        {{-- <a href="{{ route('edit_user',Crypt::encryptString($item->id)) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a> --}}

                                        {{-- <a href="{{ route('edit_loan', ['loan' => Crypt::encryptString($item->id)]) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a> --}}

                                        {{-- <a href="{{ route('delete_user', $item->id) }}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Delete" onclick="return confirm('Are you sure you want to delete this usere?');"><i class="bi bi-trash-fill"></i></a> --}}

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <hr/>



                        @if(!empty($rd))
                            @foreach ($rd as $item)

                            <tr>
                                <td data-name="{{ $item->id }}">{{ $item->customer_acc_id }}</td>
                                {{-- <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td> --}}
                                <td>{{ $item->rd_id }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->amount_of_emi }}</td>
                                <td>{{ $item->no_of_emi }}</td>
                                <td>{{ $item->pa}}</td>
                                <td>{{ $item->status ==1? 'Active' : 'Closed'}}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">

                                      <a href="{{ route('show_rd_emi',Crypt::encryptString($item->rd_id)) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Views"><i class="bi bi-eye-fill"></i></a>
                                      {{-- <a href="{{ route('edit_user',Crypt::encryptString($item->id)) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a> --}}

                                      {{-- <a href="{{ route('edit_loan', ['loan' => Crypt::encryptString($item->id)]) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a> --}}

                                      {{-- <a href="{{ route('delete_user', $item->id) }}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                      title="Delete" onclick="return confirm('Are you sure you want to delete this usere?');"><i class="bi bi-trash-fill"></i></a> --}}

                                    </div>
                                  </td>
                            </tr>
                             @endforeach
                        @endif
                        </tbody>

                    </table>
                </div>
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

      <script>
      $(document).ready(function() {
            $('#loan_table').DataTable({
                "order": [
                    { "data": "name", "orderable": true }
                ]
            });
        });

    </script>

   <!--end page main-->
   @endsection
