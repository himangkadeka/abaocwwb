@include('layout.header');

<div class="b-bg-image py-5" style="padding-bottom: 200px!important">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 d-flex b-heading-sec">
					<div class="align-self-center pr-5 b-head-in">
						<h1 class="text-left b-left-head">What is Lorem Ipsum?</h1>
                        <h6 class="text-justify  b-left-head">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h6>
					</div>
				</div>

				<div class="col-lg-6 b-login-sec">
					<div class="d-block px-5 pt-5 pb-4 border-bottom-0">
						<h2 class="b-login-head">Log In</h2>
					</div>

					<div class="">
						<form action="checklogin" autocomplete="off" method="POST" class="px-5">
						@csrf
							@if ($errors->has('loginfailmsg'))
                    				<span class="text-danger font-weight-bold">{{ $errors->first('loginfailmsg') }}</span>
               				@endif
							@if ($errors->has('usernotfoundmsg'))
                    				<span class="text-danger font-weight-bold">{{ $errors->first('usernotfoundmsg') }}</span>
               				@endif
							<div class="form-group ">
								<label for="username" class="text-white">Username:</label>
								<input type="text" class="form-control" id="username" placeholder="Enter Username" name="username" value="{{ old('username') }}">
								@if ($errors->has('username'))
                    				<span class="text-danger font-weight-bold">{{ $errors->first('username') }}</span>
               					@endif
							</div>
							<div class="form-group">
								<label for="login-pwd-1" class="text-white">Password:</label>
								<input type="password" class="form-control" id="login-pwd-1" placeholder="Enter password" name="password">
								@if ($errors->has('password'))
								<span class="text-danger font-weight-bold">{{ $errors->first('password') }}</span>
               					@endif
							</div>
							<div class="form-group custom-control custom-checkbox">
								<input class="custom-control-input" id="login-rem-1" type="checkbox" name="remember"> 
								<label class="custom-control-label text-white" for="login-rem-1">Remember me</label>
							</div>


							<!-- <p class="text-right b-notreg ">Don't have an account? <a href="">Sign Up</a></p> -->
							<div class="text-center py-4">
								<button type="submit" class="btn btn-primary b-btn">Log In</button>
							</div>
							
						</form>
					</div>
				</div>

			</div>
		</div>
</div>
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
@include('layout.footer');