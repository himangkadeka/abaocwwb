@include('layout.officeheader')
<body>
    <div class="d-flex" id="wrapper">
        @include('office.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
        <button class="btn b-db-color" id="menu-toggle">
        	<span style="display:none;">Menu</span>
        	<span class="fas fa-bars" style="font-size: 1.4rem"></span>
        </button>

        <!-- Online users -->
        <!--<div class="d-inline-block px-4 py-2 dropdown">
            <div class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">
	            <span class="fas fa-users" style="font-size: 20px;"></span>
            </div>
            <div class="dropdown-menu b-dropmenu-db">
	            <a class="dropdown-item" href="#">User action</a>
	            <a class="dropdown-item" href="#">Another user action</a>
	            <a class="dropdown-item" href="#">Another user action</a>
	            <a class="dropdown-item" href="#">Another user action</a>
            </div>
        </div>-->      

        <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        	<span class="far fa-caret-square-down" style="font-size: 30px; color: #FFF"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <!--<li class="nav-item">
              <a class="nav-link b-db-color" href="#">Notification</a>
            </li>
            <li class="nav-item">
              <a class="nav-link b-db-color" href="#">Inbox</a>
            </li>-->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle b-db-color" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="fas fa-users" style="font-size: 20px; padding-right:10px;"></span>Profile
              </a>
              <div class="dropdown-menu dropdown-menu-right text-center b-dropmenu-db" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="#">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#signout-modal">Sign Out</a>
                
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
      	<div class="d-flex clearfix mt-4">
      		<h3 class="d-inline-block" style="font-size:32px;">Change Password</h3>
     	</div>


        <!-- Content Row -->

        <div class="my-5" id="b-homedb">
			<div class="container">	
				<div class="">
					<div class="row text-center pl-4" id="sortable-cards">
					    <div class="col-lg-12 col-sm-12 p-3 b-customize">
					        <div class="bg-light p-4 b-dbcard">
					        	<div class="" id="showchngpwdmsg"> 
					        		<p class="text-left font-weight-bold" style="font-size: 24px;"><i class="fa fa-warning mr-4" style="font-size:48px;color:red"></i>Dear {{$usernamedisplay}}, Please change your password at first login to acess all the features. To change the password <span class="ml-auto d-inline-block align-self-center"><a href="javascript:void(0);" data-toggle="modal" data-target="#changepwd-modal"><button type="button" class="btn btn-primary b-btn">Click Here</button></a></span> </p>
					        	</div>
					        </div>
					    </div>   		    				    
					</div>
				</div>

			</div>

		</div>     
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <!-- Signup Modal -->
	<div class="modal fade" id="signout-modal" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-5 border-bottom-0">
					<h3 class="modal-title">Sign Out?</h3>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<p class="text-center">Are you sure you want to Sign Out?</p>
					<div class="text-center py-4">
						<form action="logout" method="GET">
							<button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
							<button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
      <!-- Change Password Modal -->
	<div class="modal fade" id="changepwd-modal" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-3 border-bottom-0">
					<h3 class="modal-title"><i class='fas fa-key mr-2' style='font-size:24px;'></i>Change Password</h3>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
                    <div id="chnagepwdmsg"></div>
                        <form action="#"  method="post" enctype = "multipart/form-data" class="w-sm-100 w-auto mx-auto">
                            @csrf
                            <div class="form-group w-100">
                                <label for="oldusrpwd">Old Password*:</label>
                                <input type="password" class="form-control" id="oldusrpwd" name="oldusrpwd" placeholder="Enter Old Password" value="{{ old('oldusrpwd') }}" >
                            </div>
                            <div class="form-group w-100">
                                <label for="newusrpwd">New Password*:</label>
                                <input type="password" class="form-control" id="newusrpwd" name="newusrpwd" placeholder="Enter New Password" value="{{ old('newusrpwd') }}" >
                            </div>
                            <div class="form-group w-100">
                                <label for="confusrpwd">Confirm Password*:</label>
                                <input type="password" class="form-control" id="confusrpwd" name="confusrpwd" placeholder="Confirm Password" value="{{ old('confusrpwd') }}">
                            </div>
                            <div class="d-flex justify-content-center py-4">
								        <button type="button" id="pwdchngbutt" class="btn btn-primary b-btn">RESET PASSWORD</button>
							</div>
                        </form>
					</div>
			</div>
		</div>
	</div>
      <!-- Signup Modal -->
	<div class="modal fade" id="signoutchngpwd-modal" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-5 border-bottom-0">
					<h3 class="modal-title">Sign Out?</h3>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<p class="text-center">Dear {{$usernamedisplay}}, Your Password Has been Changed Sucessfully. Kindly Sign Out and re-Login to access all the Features. </p>
					<div class="text-center py-4">
						<form action="logout" method="GET">
							<button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
							<button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
</body>
@include('layout.footer')
</html>