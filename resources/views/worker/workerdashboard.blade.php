@include('layout.workerheader')
{{--<body>--}}
    <div class="d-flex" id="wrapper">
        @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
        <button class="btn b-db-color" id="menu-toggle">
        	<span style="display:none;">Menu</span>
        	<span class="fas fa-bars" style="font-size: 1.4rem"></span>
        </button>
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
                <a class="dropdown-item" href="{{route('worker-profile')}}">Profile</a>
                <a class="dropdown-item" href="#">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#signout-modal">Sign Out</a>

              </div>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid">

{{--      	<div class="d-flex clearfix mt-4">--}}
{{--      		<h5 class="d-inline-block text-info"><i class="fas fa-tachometer-alt"></i>Dashboard</h5>--}}
{{--      		<span class="ml-auto d-inline-block align-self-center"><button type="button" class="btn"><span class="fas fa-download fa-sm"></span> Report</button></span>--}}
{{--      	</div>--}}
        <!-- Content Row -->

        <div class="my-5" id="b-homedb">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="card border border-success">
                <div class="card-body">
                   <h5 class="text-center">Application Status : @if($worker->status == 'A')<span class=" badge badge-danger">Application Submitted</span>
                       @elseif($worker->status == 'B')<span class="badge badge-primary">Application is at Registering Officer</span>
                       @elseif($worker->status == 'C')<span class="badge badge-warning">Application is at Dealing Assistant</span>
                       @elseif($worker->status == 'F')<span class="badge badge-success">Application is Approved</span>
                       @endif</h5>

                </div>
            </div>
			</div>
		</div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->
  <!-- Signup Modal -->
	<div class="modal fade" id="signout-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header text-center d-block p-5 border-bottom-0">
					<h3 class="modal-title">Sign Out?</h3>
					<button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<p class="text-center">Are you sure you want to Log Out?</p>
					<div class="text-center py-4">
						<form action="{{route('user-logout')}}" method="post">
                            @csrf
							<button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
							<button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <strong>{!! $message !!} </strong>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        @if ($message = Session::get('success'))
        $(document).ready(function(){
            $('#successModal').modal({backdrop: 'static', keyboard: false}, 'show');

        });
        @endif
        </script>
</body>
@include('layout.footer');
</html>
