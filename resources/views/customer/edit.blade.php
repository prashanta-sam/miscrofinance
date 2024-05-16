
@extends('layout.app')

@section('title', 'Edit Employee')
@php
    //dd($user);
@endphp
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
                      <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
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
                      <div class="p-4 border rounded">
                          <form class="row g-3" method="POST" action="{{ route('update_customer', ['id' =>$user->id]) }}">
                              @csrf
                              @method('PUT')
                              @php
                              //   dd($errors);
                             @endphp
                              <input type="hidden" value="{{ $user->id}}" name="id"/>
                              <div class="col-md-4">
                                  <label for="validationDefault01" class="form-label">Name</label>
                                  <input type="text" class="form-control" id="validationDefault01"

                                  value="{{ old('name', $user->name) }}"
                                  name="name" required>
                                  @if ($errors->has('name'))
                                       <div >{{ $errors->first('name') }}.</div>
                                  @endif

                              </div>
                              <div class="col-md-4">
                                  <label for="validationDefault02" class="form-label">Address</label>
                                  <input type="text" class="form-control" id="validationDefault02"   value="{{ old('address', $user->address) }}" name="address"  required>
                                      @if ($errors->has('address'))
                                              <div >{{ $errors->first('address') }}.</div>
                                      @endif

                              </div>
                              <div class="col-md-4">
                                  <label for="validationDefault02" class="form-label">Phone</label>
                                  <input type="number" class="form-control" id="validationDefault02"
                                  value="{{ old('phone', $user->phone) }}"   name="phone" required>
                                  @if ($errors->has('phone'))
                                          <div >{{ $errors->first('phone') }}.</div>
                                  @endif
                              </div>
                              <div class="col-md-4">
                                  <label for="validationDefaultUsername" class="form-label">Email</label>
                                  <div class="input-group"> <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                      <input type="text" class="form-control" id="validationDefaultUsername"
                                      aria-describedby="inputGroupPrepend2"
                                      name="email"  value="{{ old('email', $user->email) }}"  >
                                      @if ($errors->has('email'))
                                          <div >{{ $errors->first('email') }}.</div>
                                      @endif
                                  </div>

                              </div>

                              <div class="col-12">
                                  <button class="btn btn-primary" type="submit">Update</button>
                              </div>
                              {{-- <button type="button" class="btn btn-success px-5" onclick="success_noti()">
                                  <i class="bx bx-check-circle mr-1"></i> Success</button> --}}
                              @if ($errors->has('error'))
                                  <div style="color: red" >{{ $errors->first('error') }}.</div>
                             @endif
                             @if (session('success'))
                                  <div class="alert alert-success">
                                      {{ session('success') }}
                                  </div>
                              @endif
                          </form>
                      </div>
                  </div>
              </div>


          </div>
      </div>
      <!--end row-->
  </main>
<!--end page main-->
  @endsection
