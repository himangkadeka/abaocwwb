<!DOCTYPE html>
<html lang="en">
<head>
	<title>ABAOCWWB | Homepage</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bootstrap Template created by UxDT division, National Informatics Centre">
  	<meta name="keywords" content="HTML, Bootstrap, CSS, JS">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" href="{{URL::asset('assets/template/css/dataTables.bootstrap5.min.css')}}" />
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <script src="{{URL::asset('assets/template/js/popper.min.js')}}"></script>
</head>
<body>
	<div style="display:none;">
		<h1>Heading1</h1><h2>Heading2</h2>
	</div>
	<!-- Accessibility -->
	<div class="container d-flex clearfix" id="b-accessibility">
		<div class="b-ministryname">
			<div class="text-right d-inline-block font-weight-bold b-acc-goi pr-sm-2">
				<a href="#" target="_blank"><span>Government of Assam</span></a>
			</div>
			<div class="d-inline-block font-weight-bold b-acc-ministry pl-sm-2">
				<a href="#" target="_blank"><span>Labour Department</span></a>
			</div>
		</div>
		<div class="ml-auto d-flex b-acc-icons">
			<div class="align-self-center">

				<div class="d-inline-block h-100 px-3">
					<img src="{{URL::asset('assets/template/images/icons/ico-site-search.png')}}" alt="site search icon" title="Site search" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

					<div class="dropdown-menu p-0 border-0 b-search">
						<label for="site-search" style="display:none;">Site search</label>
				        <input type="text" class="form-control float-left b-site-search" id="site-search" placeholder="Search" style="width: 150px; border-radius: 0;">
					    <div class="input-group-btn float-left">
					      <button class="btn" type="submit" style="border-radius: 0; background: #505050; color: white; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0);"> 
					      	<span style="display:none;">Search</span>
					        <span class="fas fa-search"></span>
					      </button>
					    </div>
				    </div>
				</div>

				<div class="d-inline-block h-100 px-3 dropdown">
					<img src="{{URL::asset('assets/template/images/icons/ico-social.png')}}" alt="social sites links" title="Social links" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

					<div class="dropdown-menu b-social-dropdown" style="min-width: 50px; width: 50px">
				        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Facebook link</span><span class="fab fa-facebook-f"></span> </a>
				        <a href="javascript:void(0);" class="dropdown-item"> <span style="display:none;">Twitter link</span><span class="fab fa-twitter"></span> </a>
				        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Youtube link</span><span class="fab fa-youtube"></span> </a>
				    </div>
				</div>
				

				<div class="d-inline-block h-100 px-3">
					<a href="#b-homedb" class="align-self-center b-skiptomain" title="Skip to main content">
						<img src="{{URL::asset('assets/template/images/icons/ico-skip.png')}}" alt="skip to main content icon">
					</a>
				</div>

				<div class="d-inline-block h-100 px-3">
					<img src="{{URL::asset('assets/template/images/icons/ico-accessibility.png')}}" alt="accessibility icon" title="Accessibility Dropdown" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

					<div class="dropdown-menu b-accessibility-dropdown" style="min-width: 50px; width: 50px">
				        <a href="javascript:void(0);" class="dropdown-item" title="Increase font size"> <span class="font-weight-bold"> A<sup>+</sup> </span> </a>
				        <a href="javascript:void(0)" class="dropdown-item" title="Reset font size"> <span class="font-weight-bold"> A </span> </a>
				        <a href="javascript:void(0);" class="dropdown-item" title="Decrease font size"> <span class="font-weight-bold"> A<sup>-</sup> </span> </a>
				        <a href="javascript:void(0)" class="dropdown-item bg-dark" title="High contrast"> <span class="font-weight-bold text-white"> A </span> </a>
				    </div>
				</div>

				<div class="d-inline-block h-100 px-3">
					<a href="site-map.html" title="Sitemap">
						<img src="{{URL::asset('assets/template/images/icons/ico-sitemap.png')}}" alt="sitemap icon">
					</a>
				</div>

				
			</div>
			
		</div>
		
	</div>


	<!-- Header -->
	<div class="container clearfix" id="b-header">
		<div class="float-left d-flex h-100">
			<img src="{{URL::asset('assets/template/images/emblem-dark.png')}}" class="align-self-center b-emblem-image" title="National Emblem of India" alt="emblem of india logo">
		</div>

		<div class="float-left d-flex h-100">
			<h2 class="align-self-center pl-3 b-appname"><span class="font-weight-bold">Assam Building & Other Construction Worker's Welfare Board</span> <br><span class="b-appfullname">Social Security To Building & Other Construction Workers</span></h2>
		</div>
	</div>

	<style type="text/css">
		.bar1, .bar2, .bar3 {
		    width: 25px;
		    height: 3px;
		    background-color: #fff;
		    margin: 5px 0;
		    transition: 0.4s;
		}

		.change .bar1 {
		  -webkit-transform: rotate(-45deg) translate(-5px, 5px);
		  transform: rotate(-45deg) translate(-5px, 5px);
		}

		.change .bar2 {opacity: 0;}

		.change .bar3 {
		  -webkit-transform: rotate(45deg) translate(-5px, -7px);
		  transform: rotate(45deg) translate(-5px, -7px);
		}
	</style>


	<!-- Global Navigation -->
	<div class="globalnav-bg">
		<div class="container">
			<nav class="navbar navbar-expand-sm navbar-dark px-0">
				<div class="d-flex w-100 b-nav-mobile">
					<button class="navbar-toggler align-self-center b-btn-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" onclick="myFunction(this)">
						<span style="display:none;">Menu</span>
						<div>
						  <div class="bar1"></div>
						  <div class="bar2"></div>
						  <div class="bar3"></div>
						</div>
					</button>
					<!-- <button class="btn btn-outline-light align-self-center ml-auto b-btn-login" type="button" data-toggle="modal" data-target="#login-modal">
						Log In
					</button> --> 
				</div>
				
				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav main-menu d-flex">
						<li class="nav-item d-block"> <a href="index.html" class="nav-link active">Home</a> </li>
						<li class="nav-item d-block"> <a href="inner.html" class="nav-link">About</a></li>
						<li class="nav-item d-block"> <a href="inner.html" class="nav-link">Progress Report</a></li>
						<li class="nav-item d-block"> <a href="contactus.html" class="nav-link">Contact Us</a></li>
						<li class="nav-item d-block ml-auto b-loginbut" data-toggle="modal" data-target="#login-modal">
							<!-- <a class="nav-link" href="javascript:void(0);">Log In</a> -->
							<button type="button" class="btn btn-outline-warning">LOG IN</button>
						</li>
					</ul>
				</div>

			</nav>
		</div>
	</div>

<script>
function myFunction(x) {
  x.classList.toggle("change");
}
</script>