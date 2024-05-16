
@extends('layout.app')

@section('title', 'Microfinance')

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
                <li class="breadcrumb-item active" aria-current="page">List of Employee</li>
              </ol>
            </nav>
          </div>

        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase"></h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                {{-- <th>Address</th> --}}
                                <th>Phone</th>
                                <th>Email</th>
                                <td style="display: none">Created at</th>
                                <th>Action</a>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)

                            <tr>
                                <td data-name="{{ $item->id }}">{{ $item->name }}</td>
                                {{-- <td>{{ $item->address }}</td> --}}
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
                                <td style="display: none">{{ $item->created_at }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">

                                        <a href="{{ route('edit_user', ['user' => Crypt::encryptString($item->id)]) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><button type="button" class="btn btn-sm btn-warning"><i class="bi bi-pencil-fill pe-1"></i>Edit</button></a>

                                        <a href="{{ route('delete_user', $item->id) }}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this usere?');"><button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill pe-1"></i>Delete</button></a>
                                        <form method="POST"  id="statusForm{{  $item->id  }}" action="{{ route('update_user_status',Crypt::encryptString($item->id)) }}">
                                            @csrf
                                            @method('PUT')
                                                     <input type="hidden" name="id" value="{{ $item->id }}">
                                                     <div class="col-4" >
                                                        <div class="form-check-danger form-check form-switch" >
                                                            <input class="form-check-input collectChk"  type="checkbox"  @if ($item->status==1) checked @endif data-id="{{ $item->id}}"
                                                            name="active" style="cursor: pointer;"  value="{{ $item->status==1 ? 0 : 1 }}">
                                                            <label class="form-check-label" for="collect">{{ $item->status==1 ? 'Active' :'Inactive' }}</label>

                                                        </div>
                                                    </div>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>

        $(document).ready(function() {

          // Check if elements with class "collectChk" exist
          if ($('.collectChk').length === 0) {
                  console.warn('No elements with class "collectChk" found');
              } else {
                  console.log('Found elements with class "collectChk"');
                  // Attach change event listener to elements with class "collectChk"
                  $(document).on('click','.collectChk',function(){
                      let id = $(this).data('id');
                      let checked = $(this).is(':checked');

                      document.getElementById("statusForm"+id).submit();


                  });
              }
          // Add more tables as needed
      });
  </script>

   <!--end page main-->
   @endsection
