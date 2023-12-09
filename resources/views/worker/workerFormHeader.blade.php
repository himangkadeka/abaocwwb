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
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
{{--    <link rel="stylesheet" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />--}}
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />




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
        <h2 class="align-self-center pl-3 b-appname"><span class="font-weight-bold">Assam Building & Other Construction Worker's Welfare Board</span><br><span class="b-appfullname" style="border-bottom: 2px solid #ffbf49;padding-bottom: 0.2em;font-size: 17px;">Social Security To Building & Other Construction Workers</span></h2>
    </div>
</div>

<style type="text/css">

    body{
        background-color: #f1f1f1;
    }
    * {

        font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

    }

    label.bold{
        font-weight: 600;
        font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

    }
    .btn-primary {
        background-color: #0f4547;
    }
    .bar1, .bar2, .bar3 {
        width: 25px;
        height: 3px;
        background-color: #fff;
        margin: 5px 0;
        transition: 0.4s;
    }
    .label{
        /*font-weight: 300;*/
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
    .card {
        -webkit-box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);
        -moz-box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);
        box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);

    }
    /*box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;*/

    .card:hover {
        /*box-shadow: 0 8px 16px 0 rgba(15,58,71,0.81);*/
        /*box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(15,58,71,0.81) 0px 15px 12px;*/
        /*box-shadow: rgba(15,58,71,0.81) 0px 0px 0px 3px;*/
        /*box-shadow: rgba(15,58,71,0.81) 0px 5px 15px;*/
    }

    .card-title{
        background-image: url("/assets/template/images/frombannercopy.jpg");
        height: 100px;
        background-repeat: no-repeat, no-repeat;
        background-position: center;
        text-align: center;
        color: white;
        /*width:;*/

    }

    .btn-outline-info{
        display: flex;
        align-items: center;
        background-color: #0f3a47;
        color:white;
    }
    .btn-outline-warning{
        display: flex;
        align-items: center;
        background-color: #f17000;
        color:white;
    }
    .btn-outline-success{
        display: flex;
        align-items: center;
        background-color: #0FAA5F;
        color:white;
    }
    .material-symbols-outlined {
        margin-right: 5px; /* Adjust this value to control the spacing between the icon and text. */
    }
    .table,th{
        font-size:13px;
        text-align: center;
        /*background-color: #0f3a47;*/
        color: black;
    }
    input[type='checkbox'] {
        width:20px;
        height:20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    /*td {*/
    /*    border: 1px solid black;*/
    /*}*/


    /* try removing the "hack" below to see how the table overflows the .body */
    .hack1 {
        display: table;
        table-layout: fixed;
        width: 100%;
    }

    .hack2 {
        display: table-cell;
        overflow-x: auto;
        width: 100%;
    }

    .alert-info{
        background-color: #0c5460;
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
    <div class="mb-2"></div>
<script>
    function myFunction(x) {
        x.classList.toggle("change");
    }
</script>
