<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
 <head>
    <title>@yield('title')</title>
   @include('layout.partials.header-script')
   @csrf
 </head>
 <body>
    @include('layout.partials.header')
    @yield('content')
    @include('layout.partials.footer')
    @include('layout.partials.footer-scripts')
 </body>
</html>
