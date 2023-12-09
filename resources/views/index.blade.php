@include('layout.header')
	<style type="text/css">
		.bar1, .bar2, .bar3 {
		    width: 25px;
		    height: 3px;
		    background-color: #fff;
		    margin: 5px 0;
		    transition: 0.4s;
		}
        label.bold{
            font-weight: 600;
            font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
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
		/* .registration_form_main{
			padding: 40px 30px 0;
		} */
		.registration_form{
			margin: 0 0px 112px;
	    border: 1px solid #f2cc5f;
	    padding: 20px 20px 0;
	    border-radius: 23px;
		}
		.about-heading h1{
			font-size: 50px;
	    text-transform: uppercase;
	    font-weight: 400;
	    color: #0f4547;
		}
		.about-text-bold{
			font-weight: 600!important;
		}
		.break-line{
			display: inline-block;
	    background-color: #f2cc5f;
	    width: 40%;
	    height: 2px;
	    margin: 15px auto 40px;
		}
		.section-counter{
			margin: 10px 0 0;
	    background-color: #0f4547;
	    padding: 30px 0;
		}
		.counter-item{
			color: #f2cc5f;
			font-size: 45px;
		}
		.counter-text{
			font-size: 16px;
			font-weight: 500;
		}
		.carousel-section{
			padding: 100px 0;
			background-color: #f2cc5f;
    	margin: 0px 25px;
		}
		div#carouselExampleIndicators {
    	margin: 0 -20px;
		}
		.carousel-text{
			padding: 80px 0;
			margin: -20px 50px;
		}
		ol.carousel-indicators {
    	bottom: -40px;
		}
		.section-bg-image{
			background-image: url("/assets/template/images/welcomebanner.png");
			height: 600px;
    	background-size: cover;
		}
		.section-bg-text{
			padding: 150px 0;
		}
		.footer-text{
			background-color: #f2cc5f;
	    margin: 60px 0;
	    padding: 20px 20px 10px;
		}
        .btn {
            display: flex;
            align-items: center;
            background-color: #0f3a47;
            color:white;
        }
        .material-symbols-outlined {
            margin-right: 5px; /* Adjust this value to control the spacing between the icon and text. */
        }
        .modal-image{
            background-image: url("/assets/template/images/modal_1.png");
        }
	</style>
<script>
	function myFunction(x) {
	  x.classList.toggle("change");
	}
</script>
<!-- Background -->
<!-- <section class="b-bg-image" style="height: 624px;">	 -->
	<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
		  <div class="carousel-item active">
			<img class="d-block w-100"  src="{{URL::asset('assets/template/images/banner_1.png')}}" alt="First slide"  >
		  </div>
		  <div class="carousel-item">
			<img class="d-block w-100" src="{{URL::asset('assets/template/images/banner_2.png')}}" alt="Second slide">
		  </div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
		  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
		  <span class="carousel-control-next-icon" aria-hidden="true"></span>
		  <span class="sr-only">Next</span>
		</a>
	  </div>
<!-- </section> -->
<!-- Services -->
<div class="mt-5" id="b-homedb" style="position: relative; top: -170px; margin-bottom: -110px;"></div>
<div class="container">
	<div class="row text-center">
		<div class="col-lg-4">
			<div class="m-auto">

                <a href="javascript:void(0)" data-toggle="modal" data-target="#register-modal"><img src="{{URL::asset('assets/template/images/icon_1.png')}}" class="img-fluid" ></a>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="m-auto">
			<img src="{{URL::asset('assets/template/images/icon_2.png')}}" class="img-fluid">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="m-auto">
				<img src="{{URL::asset('assets/template/images/icon_3.png')}}" class="img-fluid">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="m-auto">
				<img src="{{URL::asset('assets/template/images/icon_4.png')}}" class="img-fluid">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="m-auto">
				<img src="{{URL::asset('assets/template/images/icon_5.png')}}" class="img-fluid">
			</div>
		</div>
		<div class="col-lg-4">
			<div class="m-auto">
				<img src="{{URL::asset('assets/template/images/icon_6.png')}}" class="img-fluid">
			</div>
		</div>
	</div>
</div>
<!-- Welcome Banner -->
<section class="section-bg-image" style="height: 620px;">
	<div class="row">
		<div class="col-lg-6 col-md-6 m-auto text-center section-bg-text">
			<div class="row">
				<div class="col-lg-12 text-center about-heading">
					<h1 class="text-white">Welcome To</h1>
					<h1 class="about-text-bold text-white">Labour Department</h1>
				</div>
				<div class="break-line"></div>
				<p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
			</div>
		</div>
	</div>
</section>

    <!--Modal Start-->
    <div class="modal fade" id="register-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block  border-bottom-0 bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Worker Register</h5>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="col-md-12 mb-2 modal-image" style="background-color:#bd362f; padding: 10px;color: whitesmoke;">
                    <h3>Please Note :</h3>
                    <p>If you are working in Guwahati, then please select Guwahati as your nearest WFC location or if you are working in Ichalkaranji, then please select Ichalkaranji as your nearest WFC location.
                        Kalyan talukas - Ambernath, Kalyan, Murbad, Shahapur, Ulhasnagar
                        Ichalkaranji talukas - Shirol, Hathkangle</p>
                </div>
                <div class="login-tab">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#workerRegister">New Register</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#alreadyRegister">Already Registered</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content mt-3">
                        <!---Worker Register ---->
                        <div class="tab-pane container active" id="workerRegister">
                            <div id="workerregistermsg"></div>
{{--                            <form id="dataForm">--}}
                            <div class="form-group">
                                <label class="control-label bold col-md-8">Select District:</label>
                                <div class="col-md-12">
                                    <select name="district" class="form-control" id="district_code">
                                        <option value="">--Select District--</option>
                                        @foreach($dists as $district)
                                            <option value="{{$district->district_code}}">{{$district->district_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('district'))
                                        <span class="text-warning font-weight-normal">{{ $errors->first('district') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label bold col-md-8" for="office">Concerned Office:</label>
                                <div class="col-md-12">
                                    <select name="office_id" class="form-control" id="office_id" >
                                        <option value="">--Select Office--</option>
                                    </select>
                                </div>
                            </div>
{{--                            <div id="loader" style="display: none;">--}}
{{--                                --}}{{--    <img src="spinner.gif" alt="Loading..." />--}}
{{--                                <div class="d-flex justify-content-center">--}}
{{--                                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">--}}
{{--                                        <span class="sr-only">Loading...</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label class="control-label bold col-md-5" for="adhaarno">Aadhaar Number:</label>
                                <div class="col-md-12" style="position: relative;display: inline-block;">
                                    <input type="text" class="form-control invalid-input" id="adhaarno" name="adhaarno" placeholder="Enter Adhaar No" maxlength="12"/>
                                    <span id="adhaarnoError" class="error-message text-danger"></span>
                                    @if ($errors->has('adhaarno'))
                                        <span class="text-warning font-weight-normal">{{ $errors->first('adhaarno') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 bold" for="email">Mobile No:</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter Phone No" maxlength="10"/>
                                    <p class="error text-danger" id="phone_noError"></p>
                                    @if ($errors->has('phone_no'))
                                        <span class="text-warning font-weight-normal">{{ $errors->first('phone_no') }}</span>
                                    @endif
                                </div>
                            </div>
{{--                            </form>--}}
                            <div class="d-flex justify-content-center py-4">
                                <button type="submit" id="register-btn-worker" class=" btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbspRegister</button>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="alreadyRegister">
                            <div id="allresuserloginmsg"></div>
                            <form action="#" method="post" enctype = "multipart/form-data" class="mt-3" >
                                <div class="form-group ">
                                    <label for="username" class="bold" >Username:</label>
                                    <input type="text" class="form-control" id="regusername" placeholder="Enter Username" name="username" value="{{ old('username') }}">
                                </div>
                                <div class="form-group">
                                    <label for="reglogin-pwd-1" class="bold" >Password:</label>
                                    <input type="password" class="form-control" id="reglogin-pwd-1" placeholder="Enter password" name="password">
                                </div>
                                <div class="d-flex justify-content-center py-4">
                                    <button type="button" class="btn btn-primary b-btn" id="allreguser-btt"><i class="fas fa-sign-in-alt"></i>&nbspLog In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--modal end-->

	<!-- Dashboard -->
<div class="mt-5" id="b-homedb" style="position: relative; top: -170px; margin-bottom: -110px;">
	<div class="container">
		<div class="row text-center">
			<!-- <h2 class="col-md-12">Figures tell the story</h2> -->
			<div class="col-lg-4 p-4">
				<div class="bg-light py-4 b-dbcard">
					<p><span class="fas fa-users" style="font-size:40px"></span></p>
					<!-- <p> <img src="images/wheat.svg" width="40px"></span></p> -->
					<h3 style="font-size: 16px;"><strong>No. of Beneficiaries</strong></h3>
					<div class="text-left ">
						<p class="px-5">So Far  <span class="float-right">39.04 Cr</span></p>

						<p class="px-5">and Counting...</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4 p-4">
				<div class="bg-light py-4 b-dbcard">
					<p><span class="fas fa-rupee-sign" style="font-size:40px"></span></p>
					<h3 style="font-size: 16px;"><strong>Total Amount Deposited</strong></h3>
					<div class="text-left ">
						<p class="px-5">So far <span class="float-right">131,339.59 Cr</span></p>

						<p class="px-5">and Counting...</p>
					</div>

				</div>
			</div>

			<div class="col-lg-4 p-4">
				<div class="bg-light py-4 b-dbcard">
					<p><span class="fas fa-credit-card" style="font-size:40px"></span></p>
					<h3 style="font-size: 16px;"><strong>No. of Rupay Debit Cards Issued</strong></h3>
					<div class="text-left ">
						<p class="px-5">So far  <span class="float-right">29.27 Cr</span></p>

						<p class="px-5">and Counting...</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- <section class="container"> -->
	<!-- <div class="row">
		<div class="col-lg-8 col-md-8 m-auto text-center">
			<div class="row">
				<div class="col-lg-12 text-center about-heading">
					<h1>Welcome To</h1>
					<h1 class="about-text-bold">Labour Department</h1>
				</div>
				<div class="break-line"></div>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
			</div>
		</div>
	</div> -->
<!-- </section> -->
<section class="section-counter">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 m-auto text-center">
				<div class="row">
					<div class="col-lg-12 col-md-12"><h4 class="counter-item" akhi="2500">0</h4></div>
					<div class="col-lg-12 col-md-12"><p class="counter-text text-white">REGISTRATION</p></div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 m-auto text-center">
				<div class="row">
					<div class="col-lg-12 col-md-12"><h4 class="counter-item" akhi="300">0</h4></div>
					<div class="col-lg-12 col-md-12"><p class="counter-text text-white">CONTRACTOR</p></div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 m-auto text-center">
				<div class="row">
					<div class="col-lg-12 col-md-12"><h4 class="counter-item" akhi="120">0</h4></div>
					<div class="col-lg-12 col-md-12"><p class="counter-text text-white">EMPLOYER</p></div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 m-auto text-center">
				<div class="row">
					<div class="col-lg-12 col-md-12"><h4 class="counter-item" akhi="30">0</h4></div>
					<div class="col-lg-12 col-md-12"><p class="counter-text text-white">REGISTERED TRADE <br> UNION</p></div>
				</div>
			</div>
		</div>
	</div>
</section>

</section>
<section class="footer-text">
	<div class="container">
		<div class="row">
			<h6 class="col-lg-12 col-md-12 text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>
		</div>
	</div>
</section>
	<!----------- Footer ------------>
	<div class="footer-bs">
	    <footer class="container">
	        <div class="row">
	        	<div class="row col-md-7 col-sm-12 footer-nav">
	            	<p class="col-md-12">Quick Links —</p>
	            	<div class="col-sm-6">
	                    <ul class="list">
	                        <li><a href="inner.html">Terms of Use</a></li>
	                        <li><a href="contactus.html">Contact Us</a></li>
	                        <li><a href="inner.html">Accessibility Options</a></li>
	                    </ul>
	                </div>
	                <div class="col-sm-6">
	                    <ul class="list">
	                    	<li data-toggle="modal" data-target="#feedback-modal"><a href="javascript:void(0)">Feedback</a></li>
	                        <li><a href="inner.html">Copyright Policy</a></li>
	                        <li><a href="javascript:void(0);">Privacy Policy</a></li>
	                    </ul>
	                </div>
	            </div>
	        	<div class="col-md-3 col-sm-8 footer-social d-flex">
        			<div class="d-inline-block align-self-center">
	        			<p class="bg-light"><img src="{{URL::asset('assets/template/images/NIC.png')}}" alt="NIC logo"></p>
	        			<p class="bg-light mb-0"><img src="{{URL::asset('assets/template/images/digital-india.png')}}" alt="digital india logo"></p>
	        		</div>
	            </div>
	        	<div class="col-md-2 col-sm-4 footer-ns d-flex">
	        			<a class="backtotop align-self-center d-flex text-center text-decoration-none text-white" title="Back to top" href="#b-accessibility">
	        				<span style="display:none;">Back to top</span>
		            		<span style="font-size: 24px;" class="fas fa-angle-up align-self-center mx-auto"></span>
		            	</a>
	            </div>
	        </div>
	        <div class="text-center mt-5 b-footer-credit" style="color: #FFF!important">
	        	This website belongs to Department of <a class="font-weight-bold" href="#">Department name goes here</a>, <a class="font-weight-bold" href="#">Ministry name goes here</a>, <a class="font-weight-bold" href="https://www.india.gov.in/">Govt. of India.</a>
	        </div>
	    </footer>
	</div>

	<!-- Login Modal -->
	<div class="modal fade" id="login-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block  border-bottom-0">
				<h5 class="modal-title" id="exampleModalLabel">Login</h5>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->

				<div class="modal-body">
					<div class="col-md-12 mb-2 modal-image" style="background-color:#bd362f; padding: 10px;color: whitesmoke;">
                        <h3>Please Note :</h3>
                        <p>Use Different tabs for different Stakeholders Login.</p>
                    </div>
					<!--<form action="dashboard.html" autocomplete="off" method="POST">
						<div class="form-group">
							<label for="login-email">Email:</label>
							<input type="email" class="form-control" id="login-email" placeholder="Enter email" name="login-email">
						</div>
						<div class="form-group">
							<label for="login-pwd">Password:</label>
							<input type="password" class="form-control" id="login-pwd" placeholder="Enter password" name="login-pwd">
						</div>
						<div class="form-group form-check">
							<label class="form-check-label" for="login-rem">
								<input class="form-check-input" type="checkbox" id="login-rem" name="remember"> Remember me
							</label>
						</div>
						<p class="text-right b-notreg">Don't have an account? <a href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a></p>
						<div class="text-center py-4">
							<button type="submit" class="btn btn-primary b-btn">Log In</button>
						</div>

					</form>-->
					<div class="login-tab">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#workerLogin">Worker Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#officialLogin">Official Login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#adminLogin">Admin Login</a>
							</li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
						<div class="tab-pane container active" id="workerLogin">
								<div id="workeruserloginmsg" class="text-danger"></div>
									<div class="form-group mt-4">
										<label for="phone_no" class="bold">Phone Number</label>
										<input type="text" class="form-control" id="login_phone_no" placeholder="Enter Phone Number" name="phone_no" value="{{ old('phone_no') }}">
										@if ($errors->has('phone_no'))
											<span class="text-danger font-weight-bold">{{ $errors->first('phone_no') }}</span>
										@endif
									</div>
									<div class="form-group">
										<label for="otp" class="bold">OTP:</label>
										<span class="badge badge-primary">45789</span>
										<input type="text" class="form-control" id="otp" placeholder="Enter OTP" name="otp">
										@if ($errors->has('otp'))
											<span class="text-danger font-weight-bold">{{ $errors->first('otp') }}</span>
										@endif
									</div>
									<div class="d-flex justify-content-center py-4">
										<button type="submit" id="login-btn-worker" class=" btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbspLogin</button>
									</div>
						</div>
						<div class="tab-pane container fade" id="officialLogin">
							<div id="officialuserloginmsg"class="mt-2"></div>
							<form action="#" method="post" enctype = "multipart/form-data" class="mt-3" >
								@csrf
								<div class="form-group ">
										<label for="offusername" class="bold" >Username:</label>
										<input type="text" class="form-control" id="offusername" placeholder="Enter Username" name="offusername" value="{{ old('username') }}">
									</div>
									<div class="form-group">
										<label for="off-login-pwd-1" class="bold" >Password:</label>
										<input type="password" class="form-control" id="off-login-pwd-1" placeholder="Enter password" name="offpassword">
									</div>
									<div class="form-group mt-4 mb-4">
										<div class="captcha ">
											<span style="margin-right: 10px;float: left;margin-top: 2px;">{!! captcha_img() !!}</span>
											<button type="button" class="btn btn-danger" class="reload" id="offreload">
												&#x21bb;
											</button>
										</div>
									</div>
									<div class="form-group mb-4">
										<input id="offcaptcha" type="text" class="form-control" placeholder="Enter Captcha" name="offcaptcha">
									</div>
									<!-- <p class="text-right b-notreg ">Don't have an account? <a href="">Sign Up</a></p> -->
									<div class="d-flex justify-content-center py-4">
										<button type="button" class="btn btn-primary b-btn" id="officiallogin-btt">Log In</button>
									</div>
								</form>
						</div>
						<div class="tab-pane container fade" id="adminLogin">
							<div id="adminuserloginmsg"class="mt-2"></div>
								<form action="#" method="post" enctype = "multipart/form-data" class="mt-3" >
								@csrf
								<div class="form-group ">
										<label for="username" class="bold" >Username:</label>
										<input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" value="{{ old('username') }}">
									</div>
									<div class="form-group">
										<label for="login-pwd-1" class="bold" >Password:</label>
										<input type="password" class="form-control" id="login-pwd-1" placeholder="Enter password" name="password">
									</div>
									<div class="form-group mt-4 mb-4">
										<div class="captcha ">
											<span style="margin-right: 10px;float: left;margin-top: 2px;">{!! captcha_img() !!}</span>
											<button type="button" class="btn btn-danger" class="reload" id="reload">
												&#x21bb;
											</button>
										</div>
									</div>
									<div class="form-group mb-4">
										<input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
									</div>
									<!-- <p class="text-right b-notreg ">Don't have an account? <a href="">Sign Up</a></p> -->
									<div class="d-flex justify-content-center py-4">
										<button type="button" class="btn btn-primary b-btn" id="adminlogin-btt">Log In</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	<!-- Signup Modal -->
	<div class="modal fade" id="signup-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-5 border-bottom-0">
					<h2 class="modal-title">Sign Up</h2>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form action="" autocomplete="off">
						<div class="form-group">
							<label for="signup-name">Name:</label>
							<input type="text" class="form-control" id="signup-name" placeholder="Enter name" name="signup-name">
						</div>
						<div class="form-group">
							<label for="signup-email">Email:</label>
							<input type="email" class="form-control" id="signup-email" placeholder="Enter email" name="signup-email">
						</div>
						<div class="form-group">
							<label for="signup-mobile">Mobile no.:</label>
							<input type="number" class="form-control" id="signup-mobile" placeholder="Enter mobile no." name="signup-mobile">
						</div>
						<div class="form-group">
							<label for="signup-pwd">Password:</label>
							<input type="password" class="form-control" id="signup-pwd" placeholder="Enter password" name="signup-pwd">
						</div>

						<p class="text-right b-already-reg">Already Registered? <a href="" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In</a></p>
						<div class="text-center py-4">
							<button type="submit" class="btn btn-primary b-btn">Sign Up</button>
						</div>

					</form>
				</div>


			</div>
		</div>
	</div>

	<!-- Feedback Modal -->
	<div class="modal fade" id="feedback-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-5 border-bottom-0">
					<h2 class="modal-title">Feedback</h2>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form action="" autocomplete="off">
						<div class="form-group">
							<label for="fdbk-name">Name:</label>
							<input type="text" class="form-control" id="fdbk-name" placeholder="Enter name" name="fdbk-name">
						</div>
						<div class="form-group">
							<label for="fdbk-email">Email:</label>
							<input type="email" class="form-control" id="fdbk-email" placeholder="Enter email" name="fdbk-email">
						</div>
						<div class="form-group">
							<label for="fdbk-subject">Subject:</label>
							<select class="form-control" id="fdbk-subject" name="fdbk-subject">
								<option>Application issue</option>
								<option>Design issue</option>
								<option>Any other</option>
							</select>
						</div>
						<div class="form-group">
							<label for="fdbk-comment">Comment:</label>
							<textarea class="form-control" id="fdbk-comment" placeholder="Enter feedback" name="fdbk-comment" rows="5" style="resize: none;"></textarea>
						</div>

						<div class="text-center py-4">
							<button type="submit" class="btn btn-primary b-btn">Submit</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

    <script src="{{URL::asset('assets/template/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('assets/template/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/jquery.slicknav.min.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/dashboard.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/general.js')}}"></script>
    <script src="{{URL::asset('assets/template/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/popper.min.js')}}"></script>
  <!-- Bootstrap core JavaScript -->

  <!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

  // Menu items show hide
	$(document).ready(function() {
		$(".b-navdropdown-click").click(function() {
			if($(".b-navdropdown").hasClass("hide")) {
				$(".b-navdropdown").addClass("show");
				$(".b-navdropdown").removeClass("hide");
				// $(".b-icon-up").show();
				// $(".b-icon-down").hide();
			}
			else if($(".b-navdropdown").hasClass("show")) {
				$(".b-navdropdown").addClass("hide");
				$(".b-navdropdown").removeClass("show");
				// $(".b-icon-down").show();
				// $(".b-icon-up").hide();
			}
	});
	});

// counter
const counters = document.querySelectorAll('.counter-item');
const speed = 200;

counters.forEach( counter => {
   const animate = () => {
      const value = +counter.getAttribute('akhi');
      const data = +counter.innerText;

      const time = value / speed;
     if(data < value) {
          counter.innerText = Math.ceil(data + time);
          setTimeout(animate, 1);
        }else{
          counter.innerText = value + '+';
        }
   }
   animate();
});

</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#pop").click(function () {
                $('#firstModal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#myModal').modal({backdrop: 'static', keyboard: false}, 'show');

        });

    </script>
    @if($errors->any())
        <script>
            $(document).ready(function(){
                $('#myModal').modal({backdrop: 'static', keyboard: false}, 'show');

            });
        </script>

    @endif

</body>
</html>
