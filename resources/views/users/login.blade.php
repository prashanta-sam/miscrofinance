<!doctype html>
<html lang="en" class="semi-dark">
   <head>
      <title>Purabi Micro Finance @yield('title')</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
      <!-- Bootstrap CSS -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
      <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
      <link href="assets/css/style.css" rel="stylesheet" />
      <link href="assets/css/icons.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

      <!-- loader-->
        <link href="assets/css/pace.min.css" rel="stylesheet" />
   </head>
   <body class="bg-login">
      @yield('content')
      @php
       //   dd($errors);
      @endphp
      <!--start wrapper-->
      <div class="wrapper">
         <!--start content-->
         <main class="authentication-content mt-5">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-12 col-lg-4 mx-auto">
                     <div class="card shadow rounded-5 overflow-hidden">
                        <div class="card-body p-4 p-sm-5">
                           <h5 class="card-title">Sign In</h5>
                           <form method="POST" action="{{ route('auth') }}" class="form-body">
                            @csrf
                              <div class="row g-3">
                                 <div class="col-12">
                                    <label class="form-label">Phone Number</label>
                                    <div class="ms-auto position-relative">
                                       <div class="position-absolute top-50 translate-middle-y search-icon px-3" style="{{ $errors->has('phone') ? ' top:30% !important;' : '' }}"><i class="bi bi-phone-fill"></i></div>
                                       <input type="text" id="phone" name="phone" class="form-control radius-30 ps-5
                                       {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       placeholder="Phone Number" value="{{ old('phone') }}" >
                                       @if ($errors->has('phone'))
                                          <div class="invalid-feedback">{{ $errors->first('phone') }}.</div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <label class="form-label">Enter Password</label>
                                    <div class="ms-auto position-relative">
                                      <div class="position-absolute top-50 translate-middle-y search-icon px-3" style="{{ $errors->has('password') ? ' top:30% !important;' : ' ' }}"><i class="bi bi-lock-fill"></i></div>

                                       <input type="password" id="pass" name="password" class="form-control radius-30 ps-5 {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password" value="{{ old('password') }}" >
                                       @if ($errors->has('password'))
                                          <div class="invalid-feedback">{{ $errors->first('password') }}.</div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-6">
                                    <div class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
                                       <label class="form-check-label"  name="remember" {{ old('remember') ? 'checked' : '' }} for="flexSwitchCheckChecked">Remember Me</label>
                                    </div>
                                 </div>
                                 {{-- <div class="col-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a> --}}
                                 </div>
                                 <div class="col-12 mt-3">
                                    <div class="d-grid">
                                       <button type="submit" class="btn btn-primary radius-30">Sign In</button>
                                    </div>

                                    @if($errors->has('error'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('error') }}
                                            </div>
                                        @endif
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </main>
         <!--end page main-->
      </div>
      <!--end wrapper-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/pace.min.js"></script>

   </body>
</html>
