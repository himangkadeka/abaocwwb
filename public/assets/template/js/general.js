	$("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  	$(document).ready(function(){ 
		new DataTable('#state-table'); 
	    $('#backtotop').click(function(){ 
	        $("html, body").animate({ scrollTop: 0 }, 600); 
	        return false; 
	    }); 
	});

  	$('.sub-menu ul').hide();
  	$('.sub-sub-menu ul').hide();
	$(".sub-menu a").click(function () {
		$(this).parent(".sub-menu").children("ul").slideToggle("100");
		$(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
	});

	$(".sub-sub-menu a").click(function () {
		$(this).parent(".sub-sub-menu").children("ul").slideToggle("100");
		$(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
	});
	$( function() {
	    $( "#sortable-menu").sortable();
	    $( "#sortable-menu").disableSelection();
	    $( "#sortable-cards").sortable();
	    $( "#sortable-cards").disableSelection();
	});
	$(function() {
	    $("#one-item-row").on("click", function() {
	    	$(".b-customize").addClass("col-lg-12", 300);
	    	$(".b-customize").removeClass("col-lg-4", 300);
	    	$(".b-customize").removeClass("col-lg-6", 300);       
	});
	$("#two-item-row").on("click", function() {
	    	$(".b-customize").addClass("col-lg-6", 300);
	    	$(".b-customize").removeClass("col-lg-4", 300);
	    	$(".b-customize").removeClass("col-lg-12", 300);
	        
	});
	$("#three-item-row").on("click", function() {
	    	$(".b-customize").addClass("col-lg-4", 300);
	    	$(".b-customize").removeClass("col-lg-6", 300);
	    	$(".b-customize").removeClass("col-lg-12", 300);
	        
	});	
    });

/* AJAX Functions. Author:: Bimol Sarkar Dated:11-10-2023*/
	$(document).ready(function () {
		$('#office-table').DataTable();
		$('#user-table').DataTable();
		$('#scheme-table').DataTable();
		//$('.dataTables_length').addClass('bs-select');
	});
	
	$(function (){
		$.ajaxSetup({
			headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$("#state").on("change",function(){
			var statecode = $("#state").val();
			$.ajax
			({
				
				url:'/admin/getdistrict',
				method:'POST',
				data:'statecode='+statecode,
				cache:false,
				dataType:'JSON',
				success:function(response){
					$('#district').html(response.districtinfo);
				}

			});

		});
		$("#searchpo").on("click",function(){
			var statecode = $("#state").val();
			var districtcode = $("#district").val();
			$('#pomsg').html('');
			$('#po-table').DataTable({
				"ajax":{
					"url":'/admin/getpostoffice',
					"method":'POST',
					"data": {
						"statecode": statecode,
						"districtcode": districtcode,
					},
					"processing" : true,
					"serverside" : true,
					error: function (xhr) {
						$('#pomsg').html('');
						$.each(xhr.responseJSON.errors, function(key,value) {
						$('#pomsg').append('<div class="alert alert-danger">'+value+'</div>');
					 });  
					}
				},
				"columns":[
					{"data":"slno"},
					{"data":"Post Office"},
					{"data":"Pin"},
					{"data":"District"},
					{"data":"State"},
					{"data":"Created On"},
					{"data":"Action"},
				],
				"destroy": true
			});

		});
		$("#po-state").on("change",function(){
			var statecode = $("#po-state").val();
			$.ajax
			({
				
				url:'/admin/getdistrict',
				method:'POST',
				data:'statecode='+statecode,
				cache:false,
				dataType:'JSON',
				success:function(response){
					$('#po-district').html(response.districtinfo);
				}

			});

		});
		$("#poaddbutt").on("click",function(){
			var statecode = $("#po-state").val();
			var districtcode = $('#po-district').val();
			var poname = $('#po-name').val();
			var pincode = $('#pincode').val();
			$.ajax({
				"url":'/admin/addpo',
				"method":'POST',
				"data":{
					"statecode":statecode,
					"districtcode":districtcode,
					"poname":poname,
					"pincode":pincode
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#msg').html('');
					$('#msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#subdisaddbutt").on("click",function(){
			var statecode = $("#po-state").val();
			var districtcode = $('#po-district').val();
			var subdiscode = $('#subdiscode').val();
			var subdisname = $('#subdisname').val();
			$.ajax({
				"url":'/admin/addsubdis',
				"method":'POST',
				"data":{
					"statecode":statecode,
					"districtcode":districtcode,
					"subdiscode":subdiscode,
					"subdisname":subdisname
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#msg').html('');
					$('#msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}
			})
		});
		$("#searchbank").on("click",function(){
			var bankname = $("#bank").val();
			$('#msg').html('');
				$('#bank-table').DataTable({
					"ajax":{
						"url":'/admin/getbankdetails',
						"method":'POST',
						"data": {
							"bankname": bankname,
						},
						"processing" : true,
						"serverside" : true,
						error: function (xhr) {
							$('#msg').html('');
								   $.each(xhr.responseJSON.errors, function(key,value) {
								 $('#msg').append('<div class="alert alert-danger">'+value+'</div>');
						 });  
						}
					},
					"columns":[
						{"data":"slno"},
						{"data":"state"},
						{"data":"ifsc"},
						{"data":"branch_name"},
						{"data":"bank_name"},
						{"data":"Created On"},
						{"data":"Action"},
					],
					"destroy": true,
				});
		});
		$("#bankaddbutt").on("click",function(){
			var state = $("#state").val();
			var ifsccode = $('#ifsc-code').val();
			var branchname  = $('#branch-name').val();
			var bankname = $('#bank-name').val();
			$.ajax({
				"url":'/admin/addbank',
				"method":'POST',
				"data":{
					"state":state,
					"ifsccode":ifsccode,
					"branchname":branchname,
					"bankname":bankname
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#bankmsg').html('');
					$('#bankmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#bankmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#bankmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#categoryaddbutt").on("click",function(){
			var categorycode = $("#cat-code").val();
			var categoryname = $('#category-name').val();
			$.ajax({
				"url":'/admin/addcategory',
				"method":'POST',
				"data":{
					"categorycode":categorycode,
					"categoryname":categoryname,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#catmsg').html('');
					$('#catmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#catmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#catmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#educationaddbutt").on("click",function(){
			var educationcode = $("#edu-code").val();
			var educationname = $('#edu-name').val();
			$.ajax({
				"url":'/admin/addeducation',
				"method":'POST',
				"data":{
					"educationcode":educationcode,
					"educationname":educationname,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#edumsg').html('');
					$('#edumsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#edumsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#edumsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#genderaddbutt").on("click",function(){
			var gendercode = $("#gen-code").val();
			var gendername = $('#gen-name').val();
			$.ajax({
				"url":'/admin/addgender',
				"method":'POST',
				"data":{
					"gendercode":gendercode,
					"gendername":gendername,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#genmsg').html('');
					$('#genmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#genmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#genmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#housetypeaddbutt").on("click",function(){
			var housetypecode = $("#housetype-code").val();
			var housetype = $('#house-type').val();
			$.ajax({
				"url":'/admin/addhousetype',
				"method":'POST',
				"data":{
					"housetypecode":housetypecode,
					"housetype":housetype,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#housetypemsg').html('');
					$('#housetypemsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#housetypemsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#housetypemsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#maritalstatusaddbutt").on("click",function(){
			var maritalstatuscode = $("#maritalstatus-code").val();
			var maritalstatus = $('#marital-status').val();
			$.ajax({
				"url":'/admin/addmaritalstatus',
				"method":'POST',
				"data":{
					"maritalstatuscode":maritalstatuscode,
					"maritalstatus":maritalstatus,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#maritalstatusmsg').html('');
					$('#maritalstatusmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#maritalstatusmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#maritalstatusmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#natureofworkaddbutt").on("click",function(){
			var natureofworkcode = $("#now-code").val();
			var natureofwork = $('#now-name').val();
			$.ajax({
				"url":'/admin/addnatureofwork',
				"method":'POST',
				"data":{
					"natureofworkcode":natureofworkcode,
					"natureofwork":natureofwork,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#nowmsg').html('');
					$('#nowmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#nowmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#nowmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#residencetypeaddbutt").on("click",function(){
			var residencetypecode = $("#resitype-code").val();
			var residencetype = $('#resitype-name').val();
			$.ajax({
				"url":'/admin/addresidencetype',
				"method":'POST',
				"data":{
					"residencetypecode":residencetypecode,
					"residencetype":residencetype,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#resimsg').html('');
					$('#resimsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#resimsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#resimsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#issuertypeaddbutt").on("click",function(){
			var issuertypecode = $("#issuertype-code").val();
			var issuertypename = $('#issuertype-name').val();
			$.ajax({
				"url":'/admin/addissuertype',
				"method":'POST',
				"data":{
					"issuertypecode":issuertypecode,
					"issuertypename":issuertypename,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#issuermsg').html('');
					$('#issuermsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#issuermsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#issuermsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#worktypeaddbutt").on("click",function(){
			var worktypecode = $("#worktype-code").val();
			var worktypename = $('#worktype-name').val();
			$.ajax({
				"url":'/admin/addworktype',
				"method":'POST',
				"data":{
					"worktypecode":worktypecode,
					"worktypename":worktypename,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#worktype-msg').html('');
					$('#worktype-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#worktype-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#worktype-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#adminlogin-btt").on("click",function(){
			var username = $("#username").val();
			var password = $('#login-pwd-1').val();
			$.ajax({
				"url":'/admin/checklogin',
				"method":'POST',
				"data":{
					"username":username,
					"password":password,
					"_token":$("input[name=_token]").val(),
					"captcha":$("input[name=captcha]").val(),
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					if(res.msg='sucess')
					{
						window.location.href = location.origin+'/admin/loginsuccess';
					}
				},
				error: function (xhr) {
					$('#adminuserloginmsg').html('');
   					$.each(xhr.responseJSON.errors, function(key,value) {
    					$('#adminuserloginmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$('#reload').click(function () {
			$.ajax({
				type: 'GET',
				url: 'reload-captcha',
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
		});
		$('#offreload').click(function () {
			$.ajax({
				type: 'GET',
				url: 'reload-captcha',
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
		});
		$("#officeaddbutt").on("click",function(){
			var districtcode = $("#district-name").val();
			var officename = $('#office-name').val();
			$.ajax({
				"url":'/admin/addoffice',
				"method":'POST',
				"data":{
					"districtcode":districtcode,
					"officename":officename,
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#office-msg').html('');
					$('#office-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#office-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#office-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#roleaddbutt").on("click",function(){
			$('#role-msg').html('');
			var rolename = $("#role-name").val();
			$.ajax({
				"url":'/admin/addrole',
				"method":'POST',
				"data":{
					"rolename":rolename
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#role-msg').html('');
					$('#role-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#role-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#role-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#designationaddbutt").on("click",function(){
			$('#desig-msg').html('');
			var designame = $("#desig-name").val();
			$.ajax({
				"url":'/admin/adddesignation',
				"method":'POST',
				"data":{
					"designame":designame
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#desig-msg').html('');
					$('#desig-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#desig-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#desig-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#confpwd").focusout(function(){
			$('#conf-msg').html('');
			var pwd = $("#pwd").val();
			var conpwd = $("#confpwd").val();
			var msg = 'Password Doesnot Match';
			if(pwd != conpwd)
			{
				$('#conf-msg').append(msg);
			}
			
		});
		$("#useraddbutt").on("click",function(){
			$('#usr-msg').html('');
			var username = $("#user-name").val();
			var password = $("#pwd").val();
			var firstname = $("#first-name").val();
			var lastname = $("#last-name").val();
			var phone = $("#phone").val();
			var email = $("#email").val();
			var desig = $("#desig").val();
			var officeid = $("#office-name").val();
			var role = $("#role-name").val();
			$.ajax({
				"url":'/admin/adduser',
				"method":'POST',
				"data":{
					"username":username,
					"password":password,
					"firstname":firstname,
					"lastname":lastname,
					"phone":phone,
					"email":email,
					"desig":desig,
					"officeid":officeid,
					"role":role
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#usr-msg').html('');
					$('#usr-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#desig-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#usr-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#ageproofaddbutt").on("click",function(){
			$('#ageproof-msg').html('');
			var ageproof = $("#ageproof-name").val();
			$.ajax({
				"url":'/admin/addageproof',
				"method":'POST',
				"data":{
					"ageproof":ageproof
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#ageproof-msg').html('');
					$('#ageproof-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#ageproof-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#ageproof-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#schemeaddbutt").on("click",function(){
			$('#sch-msg').html('');
			var schemename = $("#scheme-name").val();
			$.ajax({
				"url":'/admin/addscheme',
				"method":'POST',
				"data":{
					"schemename":schemename
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$('#sch-msg').html('');
					$('#sch-msg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#sch-msg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#sch-msg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$(".enable-user").on("click",function(){
			$('#showmsg').html('');
			var currentRow=$(this).closest("tr");
			var id=currentRow.find("td:eq(1)").html();
			$.ajax({
				"url":'/admin/enableuser',
				"method":'POST',
				"data":{
					"id":id
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$("#msg-modal").modal('show');
					$('#showmsg').html('');
					$('#showmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#showmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#showmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});

		});
		$(".disable-user").on("click",function(){
			$('#showmsg').html('');
			var currentRow=$(this).closest("tr");
			var id=currentRow.find("td:eq(1)").html();
			$.ajax({
				"url":'/admin/disableuser',
				"method":'POST',
				"data":{
					"id":id
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					$("#msg-modal").modal('show');
					$('#showmsg').html('');
					$('#showmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
				},
				error: function (xhr) {
					$('#showmsg').html('');
   						$.each(xhr.responseJSON.errors, function(key,value) {
    					 $('#showmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});

		});
		$("#officiallogin-btt").on("click",function(){
			var username = $("#offusername").val();
			var password = $('#off-login-pwd-1').val();
			$.ajax({
				"url":'/admin/checkofficelogin',
				"method":'POST',
				"data":{
					"username":username,
					"password":password,
					"_token":$("input[name=_token]").val(),
					"captcha":$("input[name=offcaptcha]").val(),
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
					if(res.msg='sucess')
					{
						window.location.href = location.origin+'/office/officeloginsuccess';
						//alert('Login Sucess');
					}
				},
				error: function (xhr) {
					$('#officialuserloginmsg').html('');
   					$.each(xhr.responseJSON.errors, function(key,value) {
    					$('#officialuserloginmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});
		$("#pwdchngbutt").on("click",function(){
			var oldusrpwd = $("#oldusrpwd").val();
			var newusrpwd = $('#newusrpwd').val();
			var confusrpwd = $('#confusrpwd').val();
			$.ajax({
				"url":'/office/changepassword',
				"method":'POST',
				"data":{
					"oldusrpwd":oldusrpwd,
					"newusrpwd":newusrpwd,
					"confusrpwd":confusrpwd,
					"_token":$("input[name=_token]").val()
				},
				"cache":false,
				"dataType":'JSON',
				"processing" : true,
				"serverside" : true,
				success: function (res) {
						$('#changepwd-modal').modal('hide');
						$('#signoutchngpwd-modal').modal('show');


				},
				error: function (xhr) {
					$('#chnagepwdmsg').html('');
   					$.each(xhr.responseJSON.errors, function(key,value) {
    					$('#chnagepwdmsg').append('<div class="alert alert-danger">'+value+'</div>');
 					}); 
				}

			});
		});


	});
	
			/** Author : Himangka deka **/
			$("#login-btn-worker").on("click",function(){
				var phone_no = $("#login_phone_no").val();
				 var otp = $('#otp').val();
				 $.ajax({
					 "url":'/worker/user-login',
					 "method":'POST',
					 "data":{
						 "phone_no":phone_no,
						 "otp":otp,
						 "_token" : $('meta[name="csrf-token"]').attr('content')
					 },
					 "cache":false,
					 "dataType":'JSON',
					 "processing" : true,
					 "serverside" : true,
	 
					 success: function (res) {
						 //$('#adminuserloginmsg').html('');
						 //$('#adminuserloginmsg').append('<div class="alert alert-success">'+res.msg+'</div>');
						 console.log(res);
						 if (res.status === 'true') {
							 // Redirect to the specified URL
							 window.location.href = res.redirect;
						 }
						 else if(res.status === 'false'){
							 $('#workeruserloginmsg').html(res.message);
						 }
					 },
					 error: function (xhr) {
						 $('#workeruserloginmsg').html('');
						 $.each(xhr.responseJSON.errors, function(key,value) {
							 $('#workeruserloginmsg').append('<div class="alert alert-danger">'+value+'</div>');
						 });
					 }
	 
				 });
			 });
		 $(document).ready(function() {
	 
			 $('.state').on('change', function() {
				 ajaxStart();
				 var cState = $(this).data('id') ;
				 // console.log(cState);return
	 
				 var state_code = $(this).val();
	 
				 if (state_code) {
					 $.ajax({
						 url: 'get-districts',
						 type: 'GET',
						 data: { state_code: state_code,
							 _token: '{{csrf_token()}}'},
						 dataType: 'json',
						 success: function(data) {
							 ajaxStop();
							 if (cState == 'c')
							 {
								 var dis= '#currentDist';
							 } else if (cState == 'p'){
								 var dis = '#permanentDist';
							 }
							 console.log(data)
							 $(dis).html('<option value="">--Select District--</option>');
							 $.each(data.districts, function(key, value) {
								 $(dis).append('<option value="' + value.district_code + '">' + value.district_name + '</option>');
							 });
	 
						 }
					 });
				 } else {
					 $('#currentDist').empty();
					 // $('#subdistrict').empty();
				 }
			 });
		 });
		 //subdistrict & postoffc
		 $(document).ready(function() {
			 $('.dist').on('change', function() {
				 ajaxStart();
				 var cDist = $(this).data('id');
				 var district_code = $(this).val();
				 if(cDist == 'c')
				 {
					 var state_code = $('#currentState').val();
				 }
				 else if(cDist == 'p'){
					 var state_code = $('#permanentState').val();
				 }
				 if (district_code) {
					 $.ajax({
						 url: 'get-subdistricts-postoffc',
						 type: 'GET',
						 data: { state_code : state_code,
							 district_code: district_code,
							 _token: '{{csrf_token()}}'},
						 dataType: 'json',
						 success: function(data) {
							 ajaxStop();
							 if (cDist == 'c')
							 {
								 var pos = '#currentPost';
								 var dis= '#currentCircle';
							 } else if (cDist == 'p'){
								 var dis = '#permanentCircle';
								 var pos = '#permanentPost';
							 }
							 console.log(data)
							 $(dis).html('<option value="">--Select Sub-district--</option>');
							 $.each(data.subdist, function(key, value) {
								 $(dis).append('<option value="' + value.subdistrict_code + '">' + value.subdistrict_name + '</option>');
							 });
							 $(pos).html('<option value="">--Select Post-office--</option>');
							 $.each(data.postoffice, function(key, value) {
								 $(pos).append('<option value="' + value.poid + '">' + value.poname + '</option>');
							 });
						 }
					 });
				 } else {
	 
					 $('#currentCircle').empty();
				 }
			 });
		 });
		 //postoffice
		 $(document).ready(function() {
			 $('.post').on('change', function() {
				 ajaxStart();
				 var cPost = $(this).data('id');
				 var post_code = $(this).val();
				 if(cPost == 'c')
				 {
					 var state_code = $('#currentState').val();
					 var district_code = $('#currentDist').val();
	 
				 }
				 else if(cPost == 'p'){
					 var state_code = $('#permanentState').val();
					 var district_code = $('#permanentDist').val();
	 
				 }
				 if (post_code) {
					 $.ajax({
						 url: 'get-pincode',
						 type: 'get',
						 data: { state_code : state_code,
							 district_code: district_code,
							 poid: post_code,
							 _token: '{{csrf_token()}}'},
						 dataType: 'json',
						 success: function(data) {
							 ajaxStop();
							 if (cPost == 'c')
							 {
								 var pin= '#currentPin';
							 } else if (cPost == 'p'){
								 var pin = '#permanentPin';
							 }
							 console.log(data)
							 $(pin).val(data.pincode.pincode);
	 
						 }
					 });
				 } else {
	 
					 $('#currentCircle').empty();
				 }
			 });
		 });
		 /** Get office list **/
		 $(document).ready(function() {
	 
			 $('#district_code').on('change', function() {
				 // ajaxStart();
				 var office_id = $(this).val();
				 // console.log(cState);return
				 var district_code = $(this).val();
	 
				 if (district_code) {
					 $.ajax({
						 url: '/worker/get-office',
						 type: 'GET',
						 data: { district_code: district_code,
							 _token: '{{csrf_token()}}'},
						 dataType: 'json',
						 success: function(data) {
							 var dis = '#office_id';
							 console.log(data);
							 $(dis).html('<option value="">--Select Office--</option>');
							 $.each(data.office, function(key, value) {
								 $(dis).append('<option value="' + value.office_id + '">' + value.office_name + '</option>');
							 });
	 
						 }
					 });
				 } else {
					 $('#office_id').empty();
					 // $('#subdistrict').empty();
				 }
			 });
		 });
		 function copyPermanentToCurrent() {
			 let checkBox= document.getElementById('checkBox');
			 const currentResidence = document.getElementById("currentResidence").value;
			 const currentHouse = document.getElementById("currentHouse").value;
			 const currentBuilding = document.getElementById("currentBuilding").value;
			 const currentArea = document.getElementById("currentArea").value;
			 const currentCity = document.getElementById("currentCity").value;
			 const currentDist = $("#currentDist :selected").val();
			 const currentDistText = $("#currentDist :selected").text();
			 const currentRoad = document.getElementById("currentRoad").value;
			 const currentState = document.getElementById("currentState").value;
			 const currentPost = $("#currentPost :selected").val();
			 const currentPostText = $("#currentPost :selected").text();
			 const currentPin = document.getElementById("currentPin").value;
			 const currentStd = document.getElementById("currentStd").value;
			 const currentCircle = $("#currentCircle :selected").val();
			 const currentCircleText = $("#currentCircle :selected").text();
			 if(checkBox.checked === true)
			 {
				 // Set values in current address fields
				 document.getElementById("permanentStd").value = currentStd;
				 $('#permanentStd').attr('readonly',true);
				 document.getElementById("permanentPin").value = currentPin;
	 
				 $('#permanentPin').attr('readonly',true);
				 // document.getElementById("permanentPost").value = currentPost;
				 $('#permanentPost').html('<option value="' + currentPost + '">' + currentPostText + '</option>');
				 $('#permanentPost').attr('readonly',true);
				 document.getElementById("permanentState").value = currentState;
				 $('#permanentState').attr('readonly',true);
				 document.getElementById("permanentRoad").value = currentRoad;
				 $('#permanentRoad').attr('readonly',true);
				 // document.getElementById("permanentDist").value = currentDist;
				 $('#permanentDist').html('<option value="' + currentDist + '">' + currentDistText + '</option>');
				 $('#permanentDist').attr('readonly',true);
				 document.getElementById("permanentCity").value = currentCity;
				 $('#permanentCity').attr('readonly',true);
				 document.getElementById("permanentArea").value = currentArea;
				 $('#permanentArea').attr('readonly',true);
				 document.getElementById("permanentHouse").value = currentHouse;
				 $('#permanentHouse').attr('readonly',true);
				 document.getElementById("permanentResidence").value = currentResidence;
				 $('#permanentResidence').attr('readonly',true);
				 document.getElementById("permanentBuilding").value = currentBuilding;
				 $('#permanentBuilding').attr('readonly',true);
				 // document.getElementById("permanentCircle").value = currentCircle;
				 $('#permanentCircle').html('<option value="' + currentCircle + '">' + currentCircleText + '</option>');
				 $('#permanentCircle').attr('readonly',true);
			 }
			 else{
				 document.getElementById("permanentStd").value = "";
				 document.getElementById("permanentPin").value ="";
				 $('#permanentPost').html('<option value="">--Select Post-office--</option>');
				 document.getElementById("permanentState").value = "";
				 document.getElementById("permanentRoad").value = "";
				 $('#permanentDist').html('<option value="">--Select District--</option>');
				 document.getElementById("permanentCity").value = "";
				 document.getElementById("permanentArea").value = "";
				 document.getElementById("permanentHouse").value = "";
				 document.getElementById("permanentResidence").value = "";
				 document.getElementById("permanentBuilding").value = "";
				 $('#permanentCircle').html('<option value="">--Select Circle-office--</option>');
			 }
			 // Set values in current address fields
		 }
		 $("#register-btn-worker").on("click",function(){
			 var district_code = $("#district_code").val();
			 var phone_no = $('#phone_no').val();
			 var office_id = $('#office_id').val();
			 var adhaarno = $('#adhaarno').val();
			 // sessionStorage.setItem('adhaarno', adhaarno);
			 $.ajax({
				 "url":'worker/worker-registration',
				 "method":'POST',
				 "data":{
					 "_token" : $('meta[name="csrf-token"]').attr('content'),
					 "district":district_code,
					 "phone_no":phone_no,
					 "adhaarno" : adhaarno,
					 "office_id" : office_id,
				 },
				 "cache":false,
				 "dataType":'JSON',
				 "processing" : true,
				 "serverside" : true,
				 success: function (res) {
					 console.log(res)
					 $('#workerregistermsg').html('');
					 // $('#workerregistermsg').append('<div class="alert alert-success">'+res.msg+'</div>');
					 window.location.href =  res.redirect;
				 },
				 error: function (xhr) {
					 $('#workerregistermsg').html('');
					 $.each(xhr.responseJSON.errors, function(key,value) {
						 $('#workerregistermsg').append('<div class="alert alert-danger">'+value+'</div>');
					 });
				 },
	 
	 
			 });
		 });
	 
		 /**Real Time Validation Phone no :Himangka deka**/
		 document.getElementById('phone_no').addEventListener('input', function () {
			 // Get the input value
			 var phone_noInput = this.value;
	 
			 // Remove non-digit characters
			 var phone_no = phone_noInput.replace(/\D/g, '');
	 
			 // Check if the phone_no number is exactly 10 digits
			 if (phone_no.length === 10) {
				 document.getElementById('phone_noError').textContent = '';
			 } else {
				 document.getElementById('phone_noError').textContent = 'Phone number must be 10 digits';
			 }
		 });
		 document.getElementById('phone_no').addEventListener('keydown', function (event) {
			 if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
				 event.preventDefault();
			 }
		 });
		 /**Real Time Validation aadhaar No : Himangka Deka **/
		 const adhaarnoInput = document.getElementById('adhaarno');
		 const adhaarnoError = document.getElementById('adhaarnoError');
		 const clearButton = document.getElementById('clearButton');
	 
		 // Function to validate the input
		 function validateInput() {
			 const adhaarno = adhaarnoInput.value;
			 // Check if the input exceeds the maximum length
			 if (adhaarno.length > parseInt(adhaarnoInput.getAttribute('maxlength'), 12)) {
				 // Truncate the input value to the maximum length
				 adhaarnoInput.value = adhaarno.substring(0, parseInt(adhaarnoInput.getAttribute('maxlength'), 12));
			 }
	 
			 if (adhaarno.length === 12) {
				 // If valid, clear the error message and remove the invalid-input class
				 adhaarnoError.textContent = '';
				 adhaarnoInput.classList.remove('invalid-input');
			 } else {
				 // If invalid, display an error message and add the invalid-input class
				 adhaarnoError.textContent = 'Aadhaar No must be 12 digits long';
				 adhaarnoInput.classList.add('invalid-input');
			 }
	 
			 // Toggle the visibility of the clear button based on whether the input has a value
			 clearButton.style.display = adhaarno.length > 0 ? 'block' : 'none';
		 }
		 // Function to clear the input
		 function clearInput() {
			 adhaarnoInput.value = '';
			 clearButton.style.display = 'none';
			 validateInput(); // Re-run validation after clearing the input
		 }
	 
		 // Attach an input event listener to the input field
		 adhaarnoInput.addEventListener('input', validateInput);
	 
		 // Attach a blur event listener to the input field
		 adhaarnoInput.addEventListener('blur', validateInput);
		 document.getElementById('adhaarno').addEventListener('keydown', function (event) {
			 if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
				 event.preventDefault();
			 }
		 });
	 


