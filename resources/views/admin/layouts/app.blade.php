<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
		<title>@yield('title', 'Admin Growdesa')</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
	  
		<!-- General CSS Files -->
		<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
	  
		<!-- CSS Libraries -->
		<link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
	  
		<!-- Template CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
	  
		<!-- Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){ dataLayer.push(arguments); }
		  gtag('js', new Date());
	  
		  gtag('config', 'UA-94034622-3');
		</script>
		<!-- /END Google Analytics -->

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  </head>
	  
    <body>
        <div class="d-flex">
            <div class="flex-grow-1 d-flex flex-column">
                @include('admin.layouts.navbar') <!-- Navbar -->
                @include('admin.layouts.sidebar') <!-- Sidebar -->
                <div class="p-4 flex-grow-1">
                    @yield('content') <!-- Konten Utama -->
                </div>
                @include('admin.layouts.footer') <!-- Footer -->
            </div>
        </div>
    </body>
</html>

 {{-- Js --}}
 <!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/modules/chart.min.js') }}"></script>
<script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/index.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
