<?php
// Main Dashboard Class to control the interface and operations
class dashboard
{

    public function template($title = "Welcome ", $sub = "MAAIF E-extesnion - Uganda", $content = 'Welcome')
    {

		echo'    
        <!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="'.ROOT.'/favicon.jpg">
    <title>'.$title.' : E-Extesnion</title>
    
    
    <!-- Custom CSS -->
    <link href="'.ROOT.'/includes/theme/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="'.ROOT.'/includes/theme/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="'.ROOT.'/includes/theme/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    
    <link href="'.ROOT.'/includes/theme/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">    
    <link href="'.ROOT.'/includes/theme/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="'.ROOT.'/includes/theme/dist/css/style.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="'.ROOT.'/includes/theme/assets/libs/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
    
    <link href="'.ROOT.'/includes/theme/maps/css/mapsvg.css" rel="stylesheet">
     <link rel="stylesheet" href="'.ROOT.'/includes/theme/lightbox/dist/css/lightbox.min.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

   <style type="text/css">
   
   
   .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #137eff;
    border: 1px solid #137eff;
    border-radius: 4px;
    cursor: default;
    float: left;
    font-weight: 300;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #FFF;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px;
}
.select2-selection__choice__remove {
        display: none !important;
    }
    label {
        margin-left: 10px;
        display: inline-block;
        margin-bottom: 0px;
	}
	

	.zoom {
		padding: 50px;
		transition: transform .2s;
		width: 200px;
		height: 200px;
		margin: 0 auto;
	  }
	  
	  .zoom:hover {
		-ms-transform: scale(2.2); /* IE 9 */
		-webkit-transform: scale(2.2); /* Safari 3-8 */
		transform: scale(2.2);
	  }
</style>



</head>
<body onload="getLocationConstant()">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
 
     
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <a href="'.ROOT.'" class="logo">
                            <!-- Logo icon -->
                            
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="'.ROOT.'/logo-sm.png" alt="homepage" class="dark-logo"  style="width: 100%"/>
                                <!-- Light Logo text -->
                            <!--    <img src="'.ROOT.'/includes/theme/assets/images/logo-light-text.png" class="light-logo" alt="homepage" />-->
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
				<!-- End Logo -->
				
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto" style=""border-right:0px>
                        
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="'.ROOT.'/images/users/'.$_SESSION['user']['photo'].'" alt="user" class="rounded-circle" width="40">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block">'.$_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'].'  <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class="">
                                        <img src="'.ROOT.'/images/users/'.$_SESSION['user']['photo'].'" alt="user" class="rounded-circle" width="60">
                                    </div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0">'.$_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'].'</h4>
                                        <p class=" m-b-0"><b>'.user::getUserCategory($_SESSION['user']['user_category_id']).'</b></p>
                                        <p class=" m-b-0">'.$_SESSION['user']['email'].'</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="'.ROOT.'/?action=viewProfile">
                                    <i class="ti-user m-r-5 m-l-5"></i> My Profile</a>';
                                    //Show if account is admin
									if(self::checkIfSuperAdminAccount()){

									echo '<a class="dropdown-item" href="'.ROOT.'/?action=manageUsers&district_id='.$_SESSION['user']['district_id'].'">
														<i class="fas fa-users m-r-5 m-l-5"></i> User Management</a>';

									}
                                    else if($_SESSION['user']['user_category_id'] == 5){

									echo '<a class="dropdown-item" href="'.ROOT.'/?action=manageUsersButtons">
														<i class="fas fa-users m-r-5 m-l-5"></i> User Management</a>';

									}

        							echo'                             
                                 		<a class="dropdown-item" href="'.ROOT.'/?action=logout">
                                    	<i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                
                            </div>
						</li>
						<li class="nav-item dropdown">

						<!-- <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
						id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="font-22 mdi mdi-bell-outline"><sup id="message-count" class = "badge badge-danger">
							</sup></i>
						</a>

                       <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
							<span class="with-arrow">
								<span class="bg-danger"></span>
							</span>
							<ul class="list-style-none">
								<li>
								
									<div class="drop-title text-white bg-danger">
										<h4 class="m-b-0 m-t-5"><span></span></h4>
										<span class="font-light">Notifications</span>
									</div>
								
								</li>
								
								<li>
								
									<a href="'.ROOT.'/?action=viewAllUserNotifications">
									<div class="message-center message-body" >
									<div class="message-item">
										<div class="mail-contnet" id="notification-messages">

										</div>
									</div>
										<div style="text-align:center;">
										<a href="'.ROOT.'/?action=viewAllUserNotifications">
										view all notifications
										</a>
										</div>
									</div>
									</a>
								</li>
							</ul>
						</div>-->
					</li>
				</ul>				
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        
                        '.self::prepMenu().'
                        
                     </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center">
                         <div class="d-flex align-items-center justify-content-start">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="'.ROOT.'">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">'.$title.'</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-4 align-self-center">
                       
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                '.$content.'
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved. Designed and Developed by
                <a href="https://agriculture.co.ug">MAAIF Uganda</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    
    <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
     
    <!-- lightgallery plugins -->
   
    <!-- Bootstrap tether Core JavaScript -->
    <script src="'.ROOT.'/includes/theme/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="'.ROOT.'/includes/theme/dist/js/app.min.js"></script>
    <script src="'.ROOT.'/includes/theme/dist/js/app.init.horizontal.js"></script>
    <script src="'.ROOT.'/includes/theme/dist/js/app-style-switcher.horizontal.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="'.ROOT.'/includes/theme/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="'.ROOT.'/includes/theme/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="'.ROOT.'/includes/theme/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="'.ROOT.'/includes/theme/dist/js/custom.js"></script>
    <!--This page JavaScript -->
    <!--This page plugins -->
    <script src="'.ROOT.'/includes/theme/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/magnific-popup/meg.init.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="'.ROOT.'/includes/theme/dist/js/pages/datatable/datatable-basic.init.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="'.ROOT.'/includes/theme/dist/js/pages/forms/select2/select2.init.js"></script>
    <script src="'.ROOT.'/includes/theme/dist/js/pages/email/email.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/summernote/dist/summernote-bs4.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
    <script src="'.ROOT.'/includes/theme/lightbox/dist/js/lightbox.min.js"></script>

    <script>
    $(\'#summernote\').summernote({
        placeholder: \'Type your email Here\',
        tabsize: 2,
        height: 250
    });
    $("#dzid").dropzone({ url: "/file/post" });
    </script>
    
     <script>
        
 $(document).ready(function(){

	function loadNotifications() {

		$.ajax({
			url: \''.ROOT.'/?action=getUserNotifications\',
			method: \'GET\',
			
			success:function(response){
				
				response = JSON.parse(response);	
				console.log(response);	
				
			
				data =  response.notifications;
				count =  response.count.unread_messages;

				$("#notification-messages").empty();
				$("#message-count").text(count);

				$.each(data, function (key, entry) {

					if(entry.is_read == 0){
						$("#notification-messages").append(
							"<div>"+
							"<h5><b>" +entry.title + "</b></h5>" +
							"<span>" + entry.message + "</span>"+
							"<i> sent on " + entry.publish_date + 
							"<p>" + entry.id + "</p>" + "<br/></i></div><hr/><br/> "
						);
					}
					else{
						$("#notification-messages").append(
							"<div>"+
							"<h5>" +entry.title + "</h5>" +
							"<span>" + entry.message + "</span>"+
							"<i> sent on " + entry.publish_date + 
							"<p>" + entry.id + "</p>" + "<br/></i></div><hr/><br/> "
						);
					}

					
				});

				$("#notification-messages").find($("h5")).addClass("message-title");
				$("#notification-messages").find($("span")).addClass("mail-desc text-wrap");
				$("#notification-messages").find($("i")).addClass("time");
				
				$("#notification-messages").find($("p")).addClass("updateIsRead");
				$("#notification-messages").find($("p")).css("display", "none");
				
		}
		});
	}

	loadNotifications();
  
     
        $("#sel_region").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getSubRegionByRegion\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_subregion").empty();
                        $("#sel_district").empty();
                        $("#sel_county").empty();
                        $("#sel_subcounty").empty();
                        $("#sel_parish").empty();
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_subregion").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
        
        
        
        
         $("#sel_subregion").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getDistrictBySubRegion\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_district").empty();
                        $("#sel_county").empty();
                        $("#sel_subcounty").empty();
                        $("#sel_parish").empty();
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_district").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
       
        
        
         $("#sel_district").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getCountyByDistrict\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_county").empty();
                        $("#sel_subcounty").empty();
                        $("#sel_parish").empty();
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_county").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
       
        
        
         $("#sel_county").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getSubcountyByCounty\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_subcounty").empty();
                        $("#sel_parish").empty();
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_subcounty").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
       
        
        
         $("#sel_subcounty").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getParishBySubcounty\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_parish").empty();
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_parish").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
         
         
         $("#sel_parish").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \''.ROOT.'/?action=getVillageByParish\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#sel_village").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#sel_village").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    }
                });
			});
			
			
 			setInterval(function(){

				loadNotifications();

			   }, 60000);
			   

		
			$("#notifications-table").DataTable( {
				
			});

			$("#content-categories").change(function(){

				console.log($("#content-categories").val());

				if( $("#content-categories").val() === "1") {

					$("#file-content-one").show(); 
					$("#file-content-two").hide(); 

				}
				else {

					$("#file-content-two").show(); 
					$("#file-content-one").hide(); 

				} 

			});
           
   
    
        

 
     });
 

 
 </script>
 
 
 <!-- Select 2 Checkboxes in Dropdown-->
 <script type="text/javascript">
    $(document).ready(function() {
        let branch_all = [];
        
        function formatResult(state) {
            if (!state.id) {
                var btn = $(\'<div class="text-right"><button id="all-branch" style="margin-right: 10px;" class="btn btn-default">Select All</button><button id="clear-branch" class="btn btn-default">Clear All</button></div>\')
                return btn;
            }
            
            branch_all.push(state.id);
            var id = \'state\' + state.id;
            var checkbox = $(\'<div class="checkbox"><input id="\'+id+\'" type="checkbox" \'+(state.selected ? \'checked\': \'\')+\'><label for="checkbox1">\'+state.text+\'</label></div>\', { id: id });
            return checkbox;   
        }
        
        function arr_diff(a1, a2) {
            var a = [], diff = [];
            for (var i = 0; i < a1.length; i++) {
                a[a1[i]] = true;
            }
            for (var i = 0; i < a2.length; i++) {
                if (a[a2[i]]) {
                    delete a[a2[i]];
                } else {
                    a[a2[i]] = true;
                }
            }
            for (var k in a) {
                diff.push(k);
            }
            return diff;
        }
        
        let optionSelect2 = {
            templateResult: formatResult,
            closeOnSelect: false,
            width: \'100%\'
        };
        
        let $select2 = $("#mycheckboxlist").select2(optionSelect2);
        
        var scrollTop;
        
        $select2.on("select2:selecting", function( event ){
            var $pr = $( \'#\'+event.params.args.data._resultId ).parent();
            scrollTop = $pr.prop(\'scrollTop\');
        });

        $select2.on("select2:select", function( event ){
            $(window).scroll();

            var $pr = $( \'#\'+event.params.data._resultId ).parent();
            $pr.prop(\'scrollTop\', scrollTop );

            $(this).val().map(function(index) {
                $("#state"+index).prop(\'checked\', true);
            });
        });

        $select2.on("select2:unselecting", function ( event ) {
            var $pr = $( \'#\'+event.params.args.data._resultId ).parent();
            scrollTop = $pr.prop(\'scrollTop\');
        });

        $select2.on("select2:unselect", function ( event ) {
            $(window).scroll();

            var $pr = $( \'#\'+event.params.data._resultId ).parent();
            $pr.prop(\'scrollTop\', scrollTop );

            var branch  =   $(this).val() ? $(this).val() : [];
            var branch_diff = arr_diff(branch_all, branch);
            branch_diff.map(function(index) {
                $("#state"+index).prop(\'checked\', false);
            });
        });

        $(document).on("click", "#all-branch",function(){
            $("#mycheckboxlist > option").not(\':first\').prop("selected", true);// Select All Options
            $("#mycheckboxlist").trigger("change")
            $(".select2-results__option").not(\':first\').attr("aria-selected", true);
            $("[id^=state]").prop("checked", true);
            $(window).scroll();
        });

        $(document).on("click", "#clear-branch", function(){
            $("#mycheckboxlist > option").not(\':first\').prop("selected", false);
            $("#mycheckboxlist").trigger("change");
            $(".select2-results__option").not(\':first\').attr("aria-selected", false);
            $("[id^=state]").prop("checked", false);
            $(window).scroll();
        });
    });
</script>

 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="'.ROOT.'/includes/theme/maps/js/mapsvg.min.js"></script>
        ';
		echo ''.js::prepJs().'';
		
        switch($_SESSION['action'])
        {
            case 'home':
                map::plotRegionMap();
                break;
            case 'districts':
                map::plotAllDistrictsMap();
                break;
            case 'regions':
                map::plotRegionMap();
                break;
            case 'district':
            case 'subcounty':
                map::plotDistrictMap($_REQUEST['name']);
                break;
            case 'subregion':
                map::plotSubRegionMapFill();
                break;
            case 'region':
                map::plotRegionMapFill();
                break;
            case 'gender':
                map::plotGenderGradientMap();
                break;
            case 'location':
                map::plotLocationGradientMap();
                break;
            case 'foundingbody':
                map::plotFoundingBodyGradientMap();
                break;
            case 'profile':
			case 'admin':

			case 'addUsers':
				echo ''.js::prepAddUserJS($_SESSION['user']['user_category_id']).'';
				break;

			case 'editUserDetails':
			echo ''.js::prepAddUserJS($_SESSION['user']['user_category_id']).'';
			break;
            default:
                break;
        }
        echo'

  
 
</body>

</html>
               
        ';

    }

    public function templateOld($title = "Welcome ", $sub = "MAAIF E-Extesnion - Uganda", $content = 'Welcome'){

        echo'
<!DOCTYPE html>
<!--
System: Electronic Agricultural Extension and Advisory System
Author: M-Omulimisa/Herbert Musoke
Website: http://www.herbertmusoke.com/
Contact: me@herbertmusoke.com
Follow: www.twitter.com/HerbertMusoke
Like: www.facebook.com/s0kie
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../">
		<meta charset="utf-8" />
		<title>E-EAES | Home</title>
		<meta name="description" content="Aside light theme example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="assets/favicon.jpg" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="index.html">
				<img alt="Logo" src="assets/logo-sm.png" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Header Menu Mobile Toggle-->
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="index.html" class="brand-logo">
							<img alt="Logo" src="assets/logo-sm.png" />
						</a>
						<!--end::Logo-->
						<!--begin::Toggle-->
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</button>
						<!--end::Toolbar-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
								<li class="menu-item" aria-haspopup="true">
									<a href="index.html" class="menu-link">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
													<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">Dashboard</span>
									</a>
								</li>
								<li class="menu-section">
									<h4 class="menu-text">Modules</h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Box2.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000" />
													<path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">E-Extesnion</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">Workplans</span>
												</span>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/typography.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Annual Workplan</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/navs.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">District Quaterly Workplan</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/typography.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Quaterly Plan/Acitivities</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/buttons.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Evaluation</span>
												</a>
											</li>

											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/button-group.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Daily Activities</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/bootstrap/buttons.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">My Evaluation</span>
												</a>
											</li>





										</ul>
									</div>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Files/Pictures1.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3" />
													<polygon fill="#000000" opacity="0.3" points="4 19 10 11 16 19" />
													<polygon fill="#000000" points="11 19 15 14 19 19" />
													<path d="M18,12 C18.8284271,12 19.5,11.3284271 19.5,10.5 C19.5,9.67157288 18.8284271,9 18,9 C17.1715729,9 16.5,9.67157288 16.5,10.5 C16.5,11.3284271 17.1715729,12 18,12 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">E-GRM</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">Custom</span>
												</span>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/custom/utilities.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Manage Meetings</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/custom/label.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Redress Mechanisms</span>
												</a>
											</li>


										</ul>
									</div>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-arrange.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M5.5,4 L9.5,4 C10.3284271,4 11,4.67157288 11,5.5 L11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L5.5,8 C4.67157288,8 4,7.32842712 4,6.5 L4,5.5 C4,4.67157288 4.67157288,4 5.5,4 Z M14.5,16 L18.5,16 C19.3284271,16 20,16.6715729 20,17.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,17.5 C13,16.6715729 13.6715729,16 14.5,16 Z" fill="#000000" />
													<path d="M5.5,10 L9.5,10 C10.3284271,10 11,10.6715729 11,11.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L14.5,14 C13.6715729,14 13,13.3284271 13,12.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">E-Market</span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
											<li class="menu-item menu-item-parent" aria-haspopup="true">
												<span class="menu-link">
													<span class="menu-text">E-market</span>
												</span>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/cards/general.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Buyer Requests</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/cards/stacked.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Seller Requests</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/cards/tabbed.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Price Information</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/cards/draggable.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Manage Markets</span>
												</a>
											</li>
											<li class="menu-item" aria-haspopup="true">
												<a href="features/cards/tools.html" class="menu-link">
													<i class="menu-bullet menu-bullet-dot">
														<span></span>
													</i>
													<span class="menu-text">Manage Market Players</span>
												</a>
											</li>

										</ul>
									</div>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Diagnostics.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<rect fill="#000000" opacity="0.3" x="2" y="3" width="20" height="18" rx="2" />
													<path d="M9.9486833,13.3162278 C9.81256925,13.7245699 9.43043041,14 9,14 L5,14 C4.44771525,14 4,13.5522847 4,13 C4,12.4477153 4.44771525,12 5,12 L8.27924078,12 L10.0513167,6.68377223 C10.367686,5.73466443 11.7274983,5.78688777 11.9701425,6.75746437 L13.8145063,14.1349195 L14.6055728,12.5527864 C14.7749648,12.2140024 15.1212279,12 15.5,12 L19,12 C19.5522847,12 20,12.4477153 20,13 C20,13.5522847 19.5522847,14 19,14 L16.118034,14 L14.3944272,17.4472136 C13.9792313,18.2776054 12.7550291,18.143222 12.5298575,17.2425356 L10.8627389,10.5740611 L9.9486833,13.3162278 Z" fill="#000000" fill-rule="nonzero" />
													<circle fill="#000000" opacity="0.3" cx="19" cy="6" r="1" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">Weather Advisory</span>

									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M11.7573593,15.2426407 L8.75735931,15.2426407 C8.20507456,15.2426407 7.75735931,15.6903559 7.75735931,16.2426407 C7.75735931,16.7949254 8.20507456,17.2426407 8.75735931,17.2426407 L11.7573593,17.2426407 L11.7573593,18.2426407 C11.7573593,19.3472102 10.8619288,20.2426407 9.75735931,20.2426407 L5.75735931,20.2426407 C4.65278981,20.2426407 3.75735931,19.3472102 3.75735931,18.2426407 L3.75735931,14.2426407 C3.75735931,13.1380712 4.65278981,12.2426407 5.75735931,12.2426407 L9.75735931,12.2426407 C10.8619288,12.2426407 11.7573593,13.1380712 11.7573593,14.2426407 L11.7573593,15.2426407 Z" fill="#000000" opacity="0.3" transform="translate(7.757359, 16.242641) rotate(-45.000000) translate(-7.757359, -16.242641)" />
													<path d="M12.2426407,8.75735931 L15.2426407,8.75735931 C15.7949254,8.75735931 16.2426407,8.30964406 16.2426407,7.75735931 C16.2426407,7.20507456 15.7949254,6.75735931 15.2426407,6.75735931 L12.2426407,6.75735931 L12.2426407,5.75735931 C12.2426407,4.65278981 13.1380712,3.75735931 14.2426407,3.75735931 L18.2426407,3.75735931 C19.3472102,3.75735931 20.2426407,4.65278981 20.2426407,5.75735931 L20.2426407,9.75735931 C20.2426407,10.8619288 19.3472102,11.7573593 18.2426407,11.7573593 L14.2426407,11.7573593 C13.1380712,11.7573593 12.2426407,10.8619288 12.2426407,9.75735931 L12.2426407,8.75735931 Z" fill="#000000" transform="translate(16.242641, 7.757359) rotate(-45.000000) translate(-16.242641, -7.757359)" />
													<path d="M5.89339828,3.42893219 C6.44568303,3.42893219 6.89339828,3.87664744 6.89339828,4.42893219 L6.89339828,6.42893219 C6.89339828,6.98121694 6.44568303,7.42893219 5.89339828,7.42893219 C5.34111353,7.42893219 4.89339828,6.98121694 4.89339828,6.42893219 L4.89339828,4.42893219 C4.89339828,3.87664744 5.34111353,3.42893219 5.89339828,3.42893219 Z M11.4289322,5.13603897 C11.8194565,5.52656326 11.8194565,6.15972824 11.4289322,6.55025253 L10.0147186,7.96446609 C9.62419433,8.35499039 8.99102936,8.35499039 8.60050506,7.96446609 C8.20998077,7.5739418 8.20998077,6.94077682 8.60050506,6.55025253 L10.0147186,5.13603897 C10.4052429,4.74551468 11.0384079,4.74551468 11.4289322,5.13603897 Z M0.600505063,5.13603897 C0.991029355,4.74551468 1.62419433,4.74551468 2.01471863,5.13603897 L3.42893219,6.55025253 C3.81945648,6.94077682 3.81945648,7.5739418 3.42893219,7.96446609 C3.0384079,8.35499039 2.40524292,8.35499039 2.01471863,7.96446609 L0.600505063,6.55025253 C0.209980772,6.15972824 0.209980772,5.52656326 0.600505063,5.13603897 Z" fill="#000000" opacity="0.3" transform="translate(6.014719, 5.843146) rotate(-45.000000) translate(-6.014719, -5.843146)" />
													<path d="M17.9142136,15.4497475 C18.4664983,15.4497475 18.9142136,15.8974627 18.9142136,16.4497475 L18.9142136,18.4497475 C18.9142136,19.0020322 18.4664983,19.4497475 17.9142136,19.4497475 C17.3619288,19.4497475 16.9142136,19.0020322 16.9142136,18.4497475 L16.9142136,16.4497475 C16.9142136,15.8974627 17.3619288,15.4497475 17.9142136,15.4497475 Z M23.4497475,17.1568542 C23.8402718,17.5473785 23.8402718,18.1805435 23.4497475,18.5710678 L22.0355339,19.9852814 C21.6450096,20.3758057 21.0118446,20.3758057 20.6213203,19.9852814 C20.2307961,19.5947571 20.2307961,18.9615921 20.6213203,18.5710678 L22.0355339,17.1568542 C22.4260582,16.76633 23.0592232,16.76633 23.4497475,17.1568542 Z M12.6213203,17.1568542 C13.0118446,16.76633 13.6450096,16.76633 14.0355339,17.1568542 L15.4497475,18.5710678 C15.8402718,18.9615921 15.8402718,19.5947571 15.4497475,19.9852814 C15.0592232,20.3758057 14.4260582,20.3758057 14.0355339,19.9852814 L12.6213203,18.5710678 C12.2307961,18.1805435 12.2307961,17.5473785 12.6213203,17.1568542 Z" fill="#000000" opacity="0.3" transform="translate(18.035534, 17.863961) scale(1, -1) rotate(45.000000) translate(-18.035534, -17.863961)" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">E-Advisory</span>

									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Select.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M18.5,8 C17.1192881,8 16,6.88071187 16,5.5 C16,4.11928813 17.1192881,3 18.5,3 C19.8807119,3 21,4.11928813 21,5.5 C21,6.88071187 19.8807119,8 18.5,8 Z M18.5,21 C17.1192881,21 16,19.8807119 16,18.5 C16,17.1192881 17.1192881,16 18.5,16 C19.8807119,16 21,17.1192881 21,18.5 C21,19.8807119 19.8807119,21 18.5,21 Z M5.5,21 C4.11928813,21 3,19.8807119 3,18.5 C3,17.1192881 4.11928813,16 5.5,16 C6.88071187,16 8,17.1192881 8,18.5 C8,19.8807119 6.88071187,21 5.5,21 Z" fill="#000000" opacity="0.3" />
													<path d="M5.5,8 C4.11928813,8 3,6.88071187 3,5.5 C3,4.11928813 4.11928813,3 5.5,3 C6.88071187,3 8,4.11928813 8,5.5 C8,6.88071187 6.88071187,8 5.5,8 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 C14,5.55228475 13.5522847,6 13,6 L11,6 C10.4477153,6 10,5.55228475 10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,18 L13,18 C13.5522847,18 14,18.4477153 14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 C10,18.4477153 10.4477153,18 11,18 Z M5,10 C5.55228475,10 6,10.4477153 6,11 L6,13 C6,13.5522847 5.55228475,14 5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 C18.4477153,14 18,13.5522847 18,13 L18,11 C18,10.4477153 18.4477153,10 19,10 Z" fill="#000000" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">Knowledge Management</span>
										
									</a>
								</li>
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
													<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
													<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
													<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
									<span class="menu-text">Outbreaks and Crises</span>
									</a>
								</li>
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
									<!--begin::Header Nav-->
									<ul class="menu-nav">
										<li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Reports</span>
												<i class="menu-arrow"></i>
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">

													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="javascript:;" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Code/CMD.svg-->
																<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M9,15 L7.5,15 C6.67157288,15 6,15.6715729 6,16.5 C6,17.3284271 6.67157288,18 7.5,18 C8.32842712,18 9,17.3284271 9,16.5 L9,15 Z M9,15 L9,9 L15,9 L15,15 L9,15 Z M15,16.5 C15,17.3284271 15.6715729,18 16.5,18 C17.3284271,18 18,17.3284271 18,16.5 C18,15.6715729 17.3284271,15 16.5,15 L15,15 L15,16.5 Z M16.5,9 C17.3284271,9 18,8.32842712 18,7.5 C18,6.67157288 17.3284271,6 16.5,6 C15.6715729,6 15,6.67157288 15,7.5 L15,9 L16.5,9 Z M9,7.5 C9,6.67157288 8.32842712,6 7.5,6 C6.67157288,6 6,6.67157288 6,7.5 C6,8.32842712 6.67157288,9 7.5,9 L9,9 L9,7.5 Z M11,13 L13,13 L13,11 L11,11 L11,13 Z M13,11 L13,7.5 C13,5.56700338 14.5670034,4 16.5,4 C18.4329966,4 20,5.56700338 20,7.5 C20,9.43299662 18.4329966,11 16.5,11 L13,11 Z M16.5,13 C18.4329966,13 20,14.5670034 20,16.5 C20,18.4329966 18.4329966,20 16.5,20 C14.5670034,20 13,18.4329966 13,16.5 L13,13 L16.5,13 Z M11,16.5 C11,18.4329966 9.43299662,20 7.5,20 C5.56700338,20 4,18.4329966 4,16.5 C4,14.5670034 5.56700338,13 7.5,13 L11,13 L11,16.5 Z M7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 C9.43299662,4 11,5.56700338 11,7.5 L11,11 L7.5,11 Z" fill="#000000" fill-rule="nonzero" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
															<span class="menu-text">E-Extesnion Report</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">National Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">District Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Subcounty Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Extension Officer Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-dot">
																			<span></span>
																		</i>
																		<span class="menu-text">Expenditure Report</span>
																	</a>
																</li>

															</ul>
														</div>
													</li>
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="#" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-box.svg-->
																<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M22,15 L22,19 C22,20.1045695 21.1045695,21 20,21 L4,21 C2.8954305,21 2,20.1045695 2,19 L2,15 L6.27924078,15 L6.82339262,16.6324555 C7.09562072,17.4491398 7.8598984,18 8.72075922,18 L15.381966,18 C16.1395101,18 16.8320364,17.5719952 17.1708204,16.8944272 L18.118034,15 L22,15 Z" fill="#000000" />
																		<path d="M2.5625,13 L5.92654389,7.01947752 C6.2807805,6.38972356 6.94714834,6 7.66969497,6 L16.330305,6 C17.0528517,6 17.7192195,6.38972356 18.0734561,7.01947752 L21.4375,13 L18.118034,13 C17.3604899,13 16.6679636,13.4280048 16.3291796,14.1055728 L15.381966,16 L8.72075922,16 L8.17660738,14.3675445 C7.90437928,13.5508602 7.1401016,13 6.27924078,13 L2.5625,13 Z" fill="#000000" opacity="0.3" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
															<span class="menu-text">E-GRM Report</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">National RM Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">District RM Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Subcounty RM Report</span>
																	</a>
																</li>


															</ul>
														</div>
													</li>
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="#" class="menu-link menu-toggle">
															<i class="fa fa-money-bill">

															</i>
															  &nbsp; &nbsp; <span class="menu-text">E-Market</span>
															<i class="menu-arrow"></i>
														</a>
														<div class="menu-submenu menu-submenu-classic menu-submenu-right">
															<ul class="menu-subnav">
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">National Commodity Price Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">District Commodity Price Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Subcounty Commodity Price Report</span>
																	</a>
																</li>
																<li class="menu-item" aria-haspopup="true">
																	<a href="javascript:;" class="menu-link">
																		<i class="menu-bullet menu-bullet-line">
																			<span></span>
																		</i>
																		<span class="menu-text">Market Players Report</span>
																	</a>
																</li>




															</ul>
														</div>
													</li>

												</ul>
											</div>
										</li>
										<li class="menu-item menu-item-submenu" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">Data dumps</span>
												<i class="menu-arrow"></i>
											</a>
										</li>
										<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
											<a href="javascript:;" class="menu-link menu-toggle">
												<span class="menu-text">General Settings</span>
												<i class="menu-arrow"></i>
											</a>
											<div class="menu-submenu menu-submenu-classic menu-submenu-left">
												<ul class="menu-subnav">
													<li class="menu-item" aria-haspopup="true">
														<a href="javascript:;" class="menu-link">
															<span class="svg-icon menu-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
																<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z" fill="#000000" opacity="0.3" />
																		<path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
															<span class="menu-text">System Users</span>
														</a>
													</li>
													<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
														<a href="javascript:;" class="menu-link menu-toggle">
															<span class="svg-icon menu-icon">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Send.svg-->
																<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M3,13.5 L19,12 L3,10.5 L3,3.7732928 C3,3.70255344 3.01501031,3.63261921 3.04403925,3.56811047 C3.15735832,3.3162903 3.45336217,3.20401298 3.70518234,3.31733205 L21.9867539,11.5440392 C22.098181,11.5941815 22.1873901,11.6833905 22.2375323,11.7948177 C22.3508514,12.0466378 22.2385741,12.3426417 21.9867539,12.4559608 L3.70518234,20.6826679 C3.64067359,20.7116969 3.57073936,20.7267072 3.5,20.7267072 C3.22385763,20.7267072 3,20.5028496 3,20.2267072 L3,13.5 Z" fill="#000000" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
															<span class="menu-text">My Account Settings</span>

														</a>
														</li>

												</ul>
											</div>
										</li>
									</ul>
									<!--end::Header Nav-->
								</div>
								<!--end::Header Menu-->
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="topbar">
								<!--begin::Search-->
								<div class="dropdown" id="kt_quick_search_toggle">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
												<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</div>
									</div>
									<!--end::Toggle-->
									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
											<!--begin:Form-->
											<form method="get" class="quick-search-form">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
																<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																		<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
														</span>
													</div>
													<input type="text" class="form-control" placeholder="Search..." />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="quick-search-close ki ki-close icon-sm text-muted"></i>
														</span>
													</div>
												</div>
											</form>
											<!--end::Form-->
											<!--begin::Scroll-->
											<div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200"></div>
											<!--end::Scroll-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
								<!--end::Search-->
								<!--begin::Notifications-->
								<div class="dropdown">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
												<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
														<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
											<span class="pulse-ring"></span>
										</div>
									</div>
									<!--end::Toggle-->
									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<form>
											<!--begin::Header-->
											<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(assets/media/misc/bg-1.jpg)">
												<!--begin::Title-->
												<h4 class="d-flex flex-center rounded-top">
													<span class="text-white">User Notifications</span>
													<span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">23 new</span>
												</h4>
												<!--end::Title-->
												<!--begin::Tabs-->
												<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
													<li class="nav-item">
														<a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">Alerts</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#topbar_notifications_events">Events</a>
													</li>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#topbar_notifications_logs">Logs</a>
													</li>
												</ul>
												<!--end::Tabs-->
											</div>
											<!--end::Header-->
											<!--begin::Content-->
											<div class="tab-content">
												<!--begin::Tabpane-->
												<div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
													<!--begin::Scroll-->
													<div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300" data-mobile-height="200">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-primary mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-primary">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
																				<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Cool App</a>
																<span class="text-muted">Marketing campaign planning</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-warning mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-warning">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																				<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg">Awesome SAAS</a>
																<span class="text-muted">Project status update meeting</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-success mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-success">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
																				<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Claudy Sys</a>
																<span class="text-muted">Project Deployment &amp; Launch</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-danger mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-danger">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/General/Attachment2.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M11.7573593,15.2426407 L8.75735931,15.2426407 C8.20507456,15.2426407 7.75735931,15.6903559 7.75735931,16.2426407 C7.75735931,16.7949254 8.20507456,17.2426407 8.75735931,17.2426407 L11.7573593,17.2426407 L11.7573593,18.2426407 C11.7573593,19.3472102 10.8619288,20.2426407 9.75735931,20.2426407 L5.75735931,20.2426407 C4.65278981,20.2426407 3.75735931,19.3472102 3.75735931,18.2426407 L3.75735931,14.2426407 C3.75735931,13.1380712 4.65278981,12.2426407 5.75735931,12.2426407 L9.75735931,12.2426407 C10.8619288,12.2426407 11.7573593,13.1380712 11.7573593,14.2426407 L11.7573593,15.2426407 Z" fill="#000000" opacity="0.3" transform="translate(7.757359, 16.242641) rotate(-45.000000) translate(-7.757359, -16.242641)" />
																				<path d="M12.2426407,8.75735931 L15.2426407,8.75735931 C15.7949254,8.75735931 16.2426407,8.30964406 16.2426407,7.75735931 C16.2426407,7.20507456 15.7949254,6.75735931 15.2426407,6.75735931 L12.2426407,6.75735931 L12.2426407,5.75735931 C12.2426407,4.65278981 13.1380712,3.75735931 14.2426407,3.75735931 L18.2426407,3.75735931 C19.3472102,3.75735931 20.2426407,4.65278981 20.2426407,5.75735931 L20.2426407,9.75735931 C20.2426407,10.8619288 19.3472102,11.7573593 18.2426407,11.7573593 L14.2426407,11.7573593 C13.1380712,11.7573593 12.2426407,10.8619288 12.2426407,9.75735931 L12.2426407,8.75735931 Z" fill="#000000" transform="translate(16.242641, 7.757359) rotate(-45.000000) translate(-16.242641, -7.757359)" />
																				<path d="M5.89339828,3.42893219 C6.44568303,3.42893219 6.89339828,3.87664744 6.89339828,4.42893219 L6.89339828,6.42893219 C6.89339828,6.98121694 6.44568303,7.42893219 5.89339828,7.42893219 C5.34111353,7.42893219 4.89339828,6.98121694 4.89339828,6.42893219 L4.89339828,4.42893219 C4.89339828,3.87664744 5.34111353,3.42893219 5.89339828,3.42893219 Z M11.4289322,5.13603897 C11.8194565,5.52656326 11.8194565,6.15972824 11.4289322,6.55025253 L10.0147186,7.96446609 C9.62419433,8.35499039 8.99102936,8.35499039 8.60050506,7.96446609 C8.20998077,7.5739418 8.20998077,6.94077682 8.60050506,6.55025253 L10.0147186,5.13603897 C10.4052429,4.74551468 11.0384079,4.74551468 11.4289322,5.13603897 Z M0.600505063,5.13603897 C0.991029355,4.74551468 1.62419433,4.74551468 2.01471863,5.13603897 L3.42893219,6.55025253 C3.81945648,6.94077682 3.81945648,7.5739418 3.42893219,7.96446609 C3.0384079,8.35499039 2.40524292,8.35499039 2.01471863,7.96446609 L0.600505063,6.55025253 C0.209980772,6.15972824 0.209980772,5.52656326 0.600505063,5.13603897 Z" fill="#000000" opacity="0.3" transform="translate(6.014719, 5.843146) rotate(-45.000000) translate(-6.014719, -5.843146)" />
																				<path d="M17.9142136,15.4497475 C18.4664983,15.4497475 18.9142136,15.8974627 18.9142136,16.4497475 L18.9142136,18.4497475 C18.9142136,19.0020322 18.4664983,19.4497475 17.9142136,19.4497475 C17.3619288,19.4497475 16.9142136,19.0020322 16.9142136,18.4497475 L16.9142136,16.4497475 C16.9142136,15.8974627 17.3619288,15.4497475 17.9142136,15.4497475 Z M23.4497475,17.1568542 C23.8402718,17.5473785 23.8402718,18.1805435 23.4497475,18.5710678 L22.0355339,19.9852814 C21.6450096,20.3758057 21.0118446,20.3758057 20.6213203,19.9852814 C20.2307961,19.5947571 20.2307961,18.9615921 20.6213203,18.5710678 L22.0355339,17.1568542 C22.4260582,16.76633 23.0592232,16.76633 23.4497475,17.1568542 Z M12.6213203,17.1568542 C13.0118446,16.76633 13.6450096,16.76633 14.0355339,17.1568542 L15.4497475,18.5710678 C15.8402718,18.9615921 15.8402718,19.5947571 15.4497475,19.9852814 C15.0592232,20.3758057 14.4260582,20.3758057 14.0355339,19.9852814 L12.6213203,18.5710678 C12.2307961,18.1805435 12.2307961,17.5473785 12.6213203,17.1568542 Z" fill="#000000" opacity="0.3" transform="translate(18.035534, 17.863961) scale(1, -1) rotate(45.000000) translate(-18.035534, -17.863961)" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Trilo Service</a>
																<span class="text-muted">Analytics &amp; Requirement Study</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-info mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-info">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
																				<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
																				<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Bravia SAAS</a>
																<span class="text-muted">Reporting Application</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-danger mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-danger">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
																				<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Express Wind</a>
																<span class="text-muted">Software Analytics &amp; Design</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-40 symbol-light-success mr-5">
																<span class="symbol-label">
																	<span class="svg-icon svg-icon-lg svg-icon-success">
																		<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
																		<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000)" />
																				<path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#000000" opacity="0.3" />
																			</g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span>
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Text-->
															<div class="d-flex flex-column font-weight-bold">
																<a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Bruk Fitness</a>
																<span class="text-muted">Web Design &amp; Development</span>
															</div>
															<!--end::Text-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Scroll-->
													<!--begin::Action-->
													<div class="d-flex flex-center pt-7">
														<a href="#" class="btn btn-light-primary font-weight-bold text-center">See All</a>
													</div>
													<!--end::Action-->
												</div>
												<!--end::Tabpane-->
												<!--begin::Tabpane-->
												<div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
													<!--begin::Nav-->
													<div class="navi navi-hover scroll my-4" data-scroll="true" data-height="300" data-mobile-height="200">
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-line-chart text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New report has been received</div>
																	<div class="text-muted">23 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-paper-plane text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Finance report has been generated</div>
																	<div class="text-muted">25 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-user flaticon2-line- text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New order has been received</div>
																	<div class="text-muted">2 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-pin text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer is registered</div>
																	<div class="text-muted">3 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-sms text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Application has been approved</div>
																	<div class="text-muted">3 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-pie-chart-3 text-warning"></i>
																</div>
																<div class="navinavinavi-text">
																	<div class="font-weight-bold">New file has been uploaded</div>
																	<div class="text-muted">5 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-pie-chart-1 text-info"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New user feedback received</div>
																	<div class="text-muted">8 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-settings text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">System reboot has been successfully completed</div>
																	<div class="text-muted">12 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-safe-shield-protection text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New order has been placed</div>
																	<div class="text-muted">15 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-notification text-primary"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Company meeting canceled</div>
																	<div class="text-muted">19 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-fax text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New report has been received</div>
																	<div class="text-muted">23 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-download-1 text-danger"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">Finance report has been generated</div>
																	<div class="text-muted">25 hrs ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon-security text-warning"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer comment recieved</div>
																	<div class="text-muted">2 days ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="navi-item">
															<div class="navi-link">
																<div class="navi-icon mr-2">
																	<i class="flaticon2-analytics-1 text-success"></i>
																</div>
																<div class="navi-text">
																	<div class="font-weight-bold">New customer is registered</div>
																	<div class="text-muted">3 days ago</div>
																</div>
															</div>
														</a>
														<!--end::Item-->
													</div>
													<!--end::Nav-->
												</div>
												<!--end::Tabpane-->
												<!--begin::Tabpane-->
												<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
													<!--begin::Nav-->
													<div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
													<br />No new notifications.</div>
													<!--end::Nav-->
												</div>
												<!--end::Tabpane-->
											</div>
											<!--end::Content-->
										</form>
									</div>
									<!--end::Dropdown-->
								</div>
								<!--end::Notifications-->
								
								
								
								<!--begin::Languages-->
								<div class="dropdown">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
											<img class="h-20px w-20px rounded-sm" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/flags/009-uganda.svg" alt="Uganda Flag" />
										</div>
									</div>
									<!--end::Toggle-->
									
								</div>
								<!--end::Languages-->
								<!--begin::User-->
								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Angella</span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">A</span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard | E-EAES </h5>
									<!--end::Page Title-->
									
								</div>
								<!--end::Info-->
								<!--begin::Toolbar-->
								<div class="d-flex align-items-center">
									<!--begin::Daterange-->
									<a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
										<span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
										<span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date">Aug 16</span>
									</a>
									<!--end::Daterange-->

								</div>
								<!--end::Toolbar-->
							</div>
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Dashboard-->
								<!--begin::Row-->
								<div class="row">
									<div class="col-lg-6 col-xxl-4">
									
									
									
									</div>																
								</div>
								<!--end::Row-->
							<!--end::Dashboard-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">&copy; 2021</span>
								<a href="http://agriculture.go.ug" target="_blank" class="text-dark-75 text-hover-primary">Ministry of Agriculture Animal Husbandry and Fisheries</a>
							</div>
							<!--end::Copyright-->
							
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		<!-- begin::User Panel-->
		<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">User Profile
				<small class="text-muted font-size-sm ml-2">12 messages</small></h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
				<!--begin::Header-->
				<div class="d-flex align-items-center mt-5">
					<div class="symbol symbol-100 mr-5">
						<div class="symbol-label" style="background-image:url(assets/media/users/300_21.jpg)"></div>
						<i class="symbol-badge bg-success"></i>
					</div>
					<div class="d-flex flex-column">
						<a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">James Jones</a>
						<div class="text-muted mt-1">Application Developer</div>
						<div class="navi mt-2">
							<a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
											<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary">jm@softplus.com</span>
								</span>
							</a>
							<a href="#" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
						</div>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Separator-->
				<div class="separator separator-dashed mt-8 mb-5"></div>
				<!--end::Separator-->
				<!--begin::Nav-->
				<div class="navi navi-spacer-x-0 p-0">
					<!--begin::Item-->
					<a href="custom/apps/user/profile-1/personal-information.html" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success">
										<!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
										<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Profile</div>
								<div class="text-muted">Account settings and more
								<span class="label label-light-danger label-inline font-weight-bold">update</span></div>
							</div>
						</div>
					</a>
					<!--end:Item-->
					<!--begin::Item-->
					<a href="custom/apps/user/profile-3.html" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-warning">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
										<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5" />
												<rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5" />
												<path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero" />
												<rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Messages</div>
								<div class="text-muted">Inbox and tasks</div>
							</div>
						</div>
					</a>
					<!--end:Item-->
					<!--begin::Item-->
					<a href="custom/apps/user/profile-2.html" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-danger">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Files/Selected-file.svg-->
										<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24" />
												<path d="M4.85714286,1 L11.7364114,1 C12.0910962,1 12.4343066,1.12568431 12.7051108,1.35473959 L17.4686994,5.3839416 C17.8056532,5.66894833 18,6.08787823 18,6.52920201 L18,19.0833333 C18,20.8738751 17.9795521,21 16.1428571,21 L4.85714286,21 C3.02044787,21 3,20.8738751 3,19.0833333 L3,2.91666667 C3,1.12612489 3.02044787,1 4.85714286,1 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
												<path d="M6.85714286,3 L14.7364114,3 C15.0910962,3 15.4343066,3.12568431 15.7051108,3.35473959 L20.4686994,7.3839416 C20.8056532,7.66894833 21,8.08787823 21,8.52920201 L21,21.0833333 C21,22.8738751 20.9795521,23 19.1428571,23 L6.85714286,23 C5.02044787,23 5,22.8738751 5,21.0833333 L5,4.91666667 C5,3.12612489 5.02044787,3 6.85714286,3 Z M8,12 C7.44771525,12 7,12.4477153 7,13 C7,13.5522847 7.44771525,14 8,14 L15,14 C15.5522847,14 16,13.5522847 16,13 C16,12.4477153 15.5522847,12 15,12 L8,12 Z M8,16 C7.44771525,16 7,16.4477153 7,17 C7,17.5522847 7.44771525,18 8,18 L11,18 C11.5522847,18 12,17.5522847 12,17 C12,16.4477153 11.5522847,16 11,16 L8,16 Z" fill="#000000" fill-rule="nonzero" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Activities</div>
								<div class="text-muted">Logs and notifications</div>
							</div>
						</div>
					</a>
					<!--end:Item-->
					<!--begin::Item-->
					<a href="custom/apps/userprofile-1/overview.html" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-primary">
										<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
										<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3" />
												<path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Tasks</div>
								<div class="text-muted">latest tasks and projects</div>
							</div>
						</div>
					</a>
					<!--end:Item-->
				</div>
				<!--end::Nav-->
				
			</div>
			<!--end::Content-->
		</div>
		<!-- end::User Panel-->

		
		
	
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="assets/plugins/custom/gmaps/gmaps.js"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="assets/js/pages/widgets.js"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>';
    }

    public static function LetsLoginOld(){

        echo'
        
        <!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" sizes="16x16" href="'.ROOT.'/favicon.jpg">
    <title>MAAIF E-Extesnion Login</title>
    <!-- Custom CSS -->
    <link href="'.ROOT.'/includes/theme/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
     
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url('.ROOT.'/coffee_man.jpg) repeat center center;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="'.ROOT.'/logo.png" alt="logo" /></span>
                        <br />
                        <br />
                        <h5 class="font-medium m-b-20">Login to the E-Extesnion System</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" id="loginform" action="" method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="Email/Username" aria-label="Username" name="username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1">
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <input type="hidden" name="action"  value="doLogin" />
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                                    </div>
                                </div>
                                
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <span class="db"><img src="'.ROOT.'/includes/theme/assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Recover Password</h5>
                        <span>Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" action="'.ROOT.'">
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control form-control-lg" type="email" required="" placeholder="Username">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="'.ROOT.'/includes/theme/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="'.ROOT.'/includes/theme/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->

</body>

</html> 
       
        
        ';
    }

    public static function countChildrenMenuBuilder($id){
        $sql = database::performQuery("SELECT * FROM km_category WHERE parent_id=$id");

        return $sql->num_rows;
    }
    public static function KMUMenuBuilder($id)
    {
    $content = '';

    $sql = database::performQuery("SELECT * FROM km_category WHERE id=$id");
    while($data=$sql->fetch_assoc()) {

        $randz = ['success','info','primary','warning','danger','dark','grey-500'];
        $used_color = array_rand($randz);
        $content .= '
                <!-- Loop main item -->
                          <li>
                            <i class="fas fa-'.$data['icon'].' text-'.$randz[$used_color].' categories"></i> '.$data['name'];

                            $getCount = self::countChildrenMenuBuilder($id);

                            //There are some children, build menu
                             //First Level Accordian here
                            if($getCount > 0){

                                $content .= '<ul>

                                    <!-- loop level 1 -->';

                                $sqlb = database::performQuery("SELECT * FROM km_category WHERE parent_id=$id");
                                while($datab=$sqlb->fetch_assoc()) {

                                    $getCountb = self::countChildrenMenuBuilder($datab['id']);

                                    //There are some children, build menu
                                    //Second Level Accordian here
                                    if($getCountb > 0) {

                                        $content .= '
                                                <li>'.$datab['name'].'                                                 
                                                     <ul>';


                                        $sqlc = database::performQuery("SELECT * FROM km_category WHERE parent_id=$datab[id]");
                                        while ($datac = $sqlc->fetch_assoc()) {
                                            $content .= '
                                                              <li><a href="'.ROOT.'/?action=getKMUByCategory&id='.$datac['id'].'">'.$datac['name'].'</a></li>';
                                        }

                                        $content .='</ul>
                                                </li>';
                                    }
                                    //No children, create link to follow
                                    else
                                    {
                                        $content .= '<li><a href="'.ROOT.'/?action=getKMUByCategory&id='.$datab['id'].'">'.$datab['name'].'</a></li>';

                                    }



                                                            

                              }

                              $content .= '</ul>';

                            }



 $content .='
                </li>
            <!-- end loop main item -->';

    }

    return $content;



}

public static function getAsideKMUMenu(){

        return '
                <div class="card categories">
                  <div class="card-body">
                    <h4 class="card-title">Categories</h4>
                    <div class="scrollable">

                    <h5 class="mt-1 text-muted">CROPS</h5>
                    <ul class="tree">
                        '.self::KMUMenuBuilder(4).'     
                        '.self::KMUMenuBuilder(5).' 
                        '.self::KMUMenuBuilder(6).' 
                        '.self::KMUMenuBuilder(7).' 
                        '.self::KMUMenuBuilder(8).' 
                        '.self::KMUMenuBuilder(9).'                                             
                        '.self::KMUMenuBuilder(10).'                                                
                        '.self::KMUMenuBuilder(11).' 
                    </ul>

                    <h5 class="mt-3 text-muted">LIVESTOCK &amp; ENTOMOLOGY</h5>
                    <ul class="tree">
                        '.self::KMUMenuBuilder(2).' 
                        '.self::KMUMenuBuilder(201).'
                    </ul>

                    <h5 class="mt-3 text-muted">AQUACULTURE</h5>
                    <ul class="tree">
                        '.self::KMUMenuBuilder(3).' 
                    </ul>

                    <h5 class="mt-3 text-muted">OTHER APPROACHES</h5>
                    <ul class="tree">
                        '.self::KMUMenuBuilder(103).'                                                       
                        '.self::KMUMenuBuilder(104).'                                                       
                        '.self::KMUMenuBuilder(106).'                                                       
                        '.self::KMUMenuBuilder(108).' 
                    </ul>
                </div>
              </div>
            </div>';

}
    public  function templateFrontEnd($title='Welcome to the E-extension system', $content='Welcome')
    {

        echo '
        
       <!DOCTYPE html>
<!--
Author: Herbert Musoke / M-Omulimsia
Product Name: MAAIF E-Extension
Website: http://www.herbertmusoke.com
Contact: me@herbertmusoke.com
Follow: www.twitter.com/HerbertMusoke
Like: www.facebook.com/HerbertMusokeOfficial
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>' . $title . '</title>
		<meta charset="utf-8" />
		<meta name="description" content="MAAIF E-Extension" />
		<meta name="keywords" content="MAAIF E-Extension" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="MAAIF E-Extension" />
		<meta property="og:url" content="' . ROOT . '/" />
		<meta property="og:site_name" content="E-Extension | MAAIF Uganda" />
		<link rel="canonical" href="' . ROOT . '/" />
		<link rel="shortcut icon" href="' . ROOT . '/favicon.jpg" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="' . ROOT . '/includes/public_html/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="' . ROOT . '/includes/public_html/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="' . ROOT . '/includes/public_html/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<style rel="stylesheet">
		
		.weatherbox {
     max-width: 175px;
        line-height: 26px;
    letter-spacing: .5px;
    min-height: 200px;
    padding: 10px;
    color: #666666;
    background-color: #DFFFFC;
    margin: 5px 15px 5px 5px;
    font-size: 11px;
    border: 1px solid #93FFF4;
    display: inline-block;
}

.datebox {
    padding: 10px;
    text-align: center;
    font-weight: bold;
}

.wicon {
    padding: 10px;
    text-align: center;
}

.wconditinons {
    text-align: center;
}
</style>
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: \'200px\', lg: \'300px\'}">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-grow-1 flex-stack">
							<!--begin::Header Logo-->
							<div class="d-flex align-items-center me-5">
								<!--begin::Heaeder menu toggle-->
								<div class="d-lg-none btn btn-icon btn-active-color-primary w-30px h-30px ms-n2 me-3" id="kt_header_menu_toggle">
									<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
									<span class="svg-icon svg-icon-1">
										<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Heaeder menu toggle-->
								<a href="' . ROOT . '">
									<img alt="Logo" src="' . ROOT . '/logo-sm.png" class="h-20px h-lg-30px" />
								</a>
							</div>
							<!--end::Header Logo-->
							<!--begin::Topbar-->
							<div class="d-flex align-items-center">
								<!--begin::Topbar-->
								<div class="d-flex align-items-center flex-shrink-0">
									<!--begin::Search-->
									<div id="kt_header_search" class="d-flex align-items-center w-lg-225px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
										<!--begin::Tablet and mobile search toggle-->
										<div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
											<div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary w-30px h-30px">
												<!--begin::Svg Icon | path: icons/duotune/general/gen004.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black" />
														<path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
										</div>
										<!--end::Tablet and mobile search toggle-->
										<!--begin::Form-->
										<form data-kt-search-element="form" action="' . ROOT . '" class="d-none d-lg-block w-100 mb-5 mb-lg-0 position-relative" autocomplete="off">
											
										
											<!--begin::Hidden input(Added to disable form autocomplete)-->
											<input type="hidden" />
											<!--	<select name="category" data-control="select2" data-hide-search="true" data-placeholder="Select a Category..." class="form-select form-select-solid">
															<option value="">Select a Category...</option>
															<option value="1">CRM</option>
															<option value="2">Project Alice</option>
															<option value="3">Keenthemes</option>
															<option value="4">General</option>
														</select>-->
											<!--end::Hidden input-->
											<!--begin::Icon-->
											<!--begin::Svg Icon | path: icons/duotune/general/gen004.svg-->
											<span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
												<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black" />
													<path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
											<!--end::Icon-->
											<!--begin::Input-->
											<input type="text" class="form-control bg-transparent ps-13 fs-7 h-40px" name="search" value="" placeholder="Type a topic to search" data-kt-search-element="input" />
											<!--end::Input-->
											<!--begin::Spinner-->
											<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
												<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
											</span>
											<!--end::Spinner-->
											<!--begin::Reset-->
											<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
												<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
													<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
														<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<!--end::Reset-->
										</form>
										<!--end::Form-->
										<!--begin::Menu-->
										<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown w-300px w-md-350px py-7 px-7 overflow-hidden">
											<!--begin::Wrapper-->
											<div data-kt-search-element="wrapper">
												<!--begin::Recently viewed-->
												<div data-kt-search-element="results" class="d-none">
													<!--begin::Items-->
													<div class="scroll-y mh-200px mh-lg-350px">
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-1.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Karina Clark</span>
																<span class="fs-7 fw-bold text-muted">Marketing Manager</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-3.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Olivia Bold</span>
																<span class="fs-7 fw-bold text-muted">Software Engineer</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-8.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Ana Clark</span>
																<span class="fs-7 fw-bold text-muted">UI/UX Designer</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-11.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Nick Pitola</span>
																<span class="fs-7 fw-bold text-muted">Art Director</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-12.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Edward Kulnic</span>
																<span class="fs-7 fw-bold text-muted">System Administrator</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/volicity-9.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Company Rbranding</span>
																<span class="fs-7 fw-bold text-muted">UI Design</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/tvit.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Company Re-branding</span>
																<span class="fs-7 fw-bold text-muted">Web Development</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/misc/infography.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Business Analytics App</span>
																<span class="fs-7 fw-bold text-muted">Administration</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/leaf.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">EcoLeaf App Launch</span>
																<span class="fs-7 fw-bold text-muted">Marketing</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/tower.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Tower Group Website</span>
																<span class="fs-7 fw-bold text-muted">Google Adwords</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM15 17C15 16.4 14.6 16 14 16H8C7.4 16 7 16.4 7 17C7 17.6 7.4 18 8 18H14C14.6 18 15 17.6 15 17ZM17 12C17 11.4 16.6 11 16 11H8C7.4 11 7 11.4 7 12C7 12.6 7.4 13 8 13H16C16.6 13 17 12.6 17 12ZM17 7C17 6.4 16.6 6 16 6H8C7.4 6 7 6.4 7 7C7 7.6 7.4 8 8 8H16C16.6 8 17 7.6 17 7Z" fill="black" />
																			<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Si-Fi Project by AU Themes</span>
																<span class="fs-7 fw-bold text-muted">#45670</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
																			<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
																			<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
																			<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Shopix Mobile App Planning</span>
																<span class="fs-7 fw-bold text-muted">#45690</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black" />
																			<rect x="6" y="12" width="7" height="2" rx="1" fill="black" />
																			<rect x="6" y="7" width="12" height="2" rx="1" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Finance Monitoring SAAS Discussion</span>
																<span class="fs-7 fw-bold text-muted">#21090</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black" />
																			<path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Dashboard Analitics Launch</span>
																<span class="fs-7 fw-bold text-muted">#34560</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
													</div>
													<!--end::Items-->
												</div>
												<!--end::Recently viewed-->
												<!--begin::Recently viewed-->
												<div data-kt-search-element="main">
													<!--begin::Heading-->
													<div class="d-flex flex-stack fw-bold mb-5">
														<!--begin::Label-->
														<span class="text-muted fs-6 me-2">Recently Searched</span>
														<!--end::Label-->
														<!--begin::Toolbar-->
														<div class="d-flex" data-kt-search-element="toolbar">
															<!--begin::Preferences toggle-->
															<div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-2 data-bs-toggle=" title="Show search preferences">
																<!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="black" />
																		<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="black" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</div>
															<!--end::Preferences toggle-->
															<!--begin::Advanced search toggle-->
															<div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-n1" data-bs-toggle="tooltip" title="Show more search options">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</div>
															<!--end::Advanced search toggle-->
														</div>
														<!--end::Toolbar-->
													</div>
													<!--end::Heading-->
													<!--begin::Items-->
													<div class="scroll-y mh-200px mh-lg-325px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/electronics/elc004.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black" />
																			<path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black" />
																			<path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">BoomApp by Keenthemes</a>
																<span class="fs-7 text-muted fw-bold">#45789</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra001.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="black" />
																			<path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"Kept API Project Meeting</a>
																<span class="fs-7 text-muted fw-bold">#84050</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra006.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black" />
																			<path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"KPI Monitoring App Launch</a>
																<span class="fs-7 text-muted fw-bold">#84250</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra002.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 8L12.5 5L5 14V19H20V8Z" fill="black" />
																			<path d="M21 18H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Reference FAQ</a>
																<span class="fs-7 text-muted fw-bold">#67945</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black" />
																			<path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"FitPro App Development</a>
																<span class="fs-7 text-muted fw-bold">#84250</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M20 19.725V18.725C20 18.125 19.6 17.725 19 17.725H5C4.4 17.725 4 18.125 4 18.725V19.725H3C2.4 19.725 2 20.125 2 20.725V21.725H22V20.725C22 20.125 21.6 19.725 21 19.725H20Z" fill="black" />
																			<path opacity="0.3" d="M22 6.725V7.725C22 8.325 21.6 8.725 21 8.725H18C18.6 8.725 19 9.125 19 9.725C19 10.325 18.6 10.725 18 10.725V15.725C18.6 15.725 19 16.125 19 16.725V17.725H15V16.725C15 16.125 15.4 15.725 16 15.725V10.725C15.4 10.725 15 10.325 15 9.725C15 9.125 15.4 8.725 16 8.725H13C13.6 8.725 14 9.125 14 9.725C14 10.325 13.6 10.725 13 10.725V15.725C13.6 15.725 14 16.125 14 16.725V17.725H10V16.725C10 16.125 10.4 15.725 11 15.725V10.725C10.4 10.725 10 10.325 10 9.725C10 9.125 10.4 8.725 11 8.725H8C8.6 8.725 9 9.125 9 9.725C9 10.325 8.6 10.725 8 10.725V15.725C8.6 15.725 9 16.125 9 16.725V17.725H5V16.725C5 16.125 5.4 15.725 6 15.725V10.725C5.4 10.725 5 10.325 5 9.725C5 9.125 5.4 8.725 6 8.725H3C2.4 8.725 2 8.325 2 7.725V6.725L11 2.225C11.6 1.925 12.4 1.925 13.1 2.225L22 6.725ZM12 3.725C11.2 3.725 10.5 4.425 10.5 5.225C10.5 6.025 11.2 6.725 12 6.725C12.8 6.725 13.5 6.025 13.5 5.225C13.5 4.425 12.8 3.725 12 3.725Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Shopix Mobile App</a>
																<span class="fs-7 text-muted fw-bold">#45690</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra002.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 8L12.5 5L5 14V19H20V8Z" fill="black" />
																			<path d="M21 18H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"Landing UI Design" Launch</a>
																<span class="fs-7 text-muted fw-bold">#24005</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
												</div>
												<!--end::Recently viewed-->
												<!--begin::Empty-->
												<div data-kt-search-element="empty" class="text-center d-none">
													<!--begin::Icon-->
													<div class="pt-10 pb-10">
														<!--begin::Svg Icon | path: icons/duotune/files/fil024.svg-->
														<span class="svg-icon svg-icon-4x opacity-50">
															<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black" />
																<path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black" />
																<rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black" />
																<path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Message-->
													<div class="pb-15 fw-bold">
														<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
														<div class="text-muted fs-7">Please try again with a different query</div>
													</div>
													<!--end::Message-->
												</div>
												<!--end::Empty-->
											</div>
											<!--end::Wrapper-->
											<!--begin::Preferences-->
											<form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
												<!--begin::Heading-->
												<h3 class="fw-bold text-dark mb-7">Advanced Search</h3>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Radio group-->
													<div class="nav-group nav-group-fluid">
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="has" checked="checked" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="users" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="orders" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="projects" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
														</label>
														<!--end::Option-->
													</div>
													<!--end::Radio group-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Radio group-->
													<div class="nav-group nav-group-fluid">
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="attachment" value="any" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
														</label>
														<!--end::Option-->
													</div>
													<!--end::Radio group-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<select name="timezone" aria-label="Select a Timezone" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
														<option value="next">Within the next</option>
														<option value="last">Within the last</option>
														<option value="between">Between</option>
														<option value="on">On</option>
													</select>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-8">
													<!--begin::Col-->
													<div class="col-6">
														<input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
													</div>
													<!--end::Col-->
													<!--begin::Col-->
													<div class="col-6">
														<select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
															<option value="days">Days</option>
															<option value="weeks">Weeks</option>
															<option value="months">Months</option>
															<option value="years">Years</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="d-flex justify-content-end">
													<button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
													<a href="../../demo11/dist/pages/search/horizontal.html" class="btn btn-sm fw-bolder btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Preferences-->
											<!--begin::Preferences-->
											<form data-kt-search-element="preferences" class="pt-1 d-none">
												<!--begin::Heading-->
												<h3 class="fw-bold text-dark mb-7">Search Preferences</h3>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="pb-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Projects</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Targets</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Affiliate Programs</span>
														<input class="form-check-input" type="checkbox" value="1" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Referrals</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Users</span>
														<input class="form-check-input" type="checkbox" value="1" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="d-flex justify-content-end pt-7">
													<button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
													<button type="submit" class="btn btn-sm fw-bolder btn-primary">Save Changes</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Preferences-->
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Search-->';
        if ($_SESSION['live']) {
            echo '<!--begin::User-->
									<div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
										<!--begin::Menu- wrapper-->
										<!--begin::User icon(remove this button to use user avatar as menu toggle)-->
										<div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
											<span class="svg-icon svg-icon-1">
												<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
													<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
										<!--end::User icon-->
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<!--begin::Avatar-->
													<div class="symbol symbol-50px me-5">
														<img alt="Logo" src="' . ROOT . '/images/users/' . $_SESSION['user']['photo'] . '" alt="' . $_SESSION['user']['first_name'] . '  />
													</div>
													<!--end::Avatar-->
													<!--begin::Username-->
													<div class="d-flex flex-column">
														<div class="fw-bolder d-flex align-items-center fs-5">' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . '
														</div>
														' . user::getUserCategory($_SESSION['user']['user_category_id']) . '<br />
														<a href="#" class="fw-bold text-muted text-hover-primary fs-7">' . $_SESSION['user']['email'] . '</a>
													</div>
													<!--end::Username-->
												</div>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="#" class="menu-link px-5">My Profile</a>
											</div>
											<!--end::Menu item-->
											
											
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											
											<!--begin::Menu item-->
											<div class="menu-item px-5 my-1">
												<a href="#" class="menu-link px-5">Account Settings</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="' . ROOT . '/?action=logout" class="menu-link px-5">Sign Out</a>
											</div>
											<!--end::Menu item-->
											
										
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::User -->';


        }

        echo '<!--begin::Sidebar Toggler-->
									<!--end::Sidebar Toggler-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
						<!--begin::Separator-->
						<div class="separator"></div>
						<!--end::Separator-->
						<!--begin::Container-->
						<div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px" id="kt_header_nav">
							<!--begin::Menu wrapper-->
							<div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:\'200px\', \'300px\': \'250px\'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: \'#kt_body\', lg: \'#kt_header_nav\'}">
    <!--begin::Menu-->
								<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<a href="' . ROOT . '"><span class="menu-link py-3">
											<span class="menu-title">Home</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>	
									</div>
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=getKMU_FE"><span class="menu-link py-3">
											<span class="menu-title">Knowledge Management</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>	
									</div>
									<div  data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1" >
									<a href="' . ROOT . '/?action=getWeatherAdvisory">	<span class="menu-link py-3">
											<span class="menu-title">Get Weather Advisory</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=getOutbreaksCrises">	<span class="menu-link py-3">
											<span class="menu-title">Outbreaks and Crises</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a target="_target" href="https://www.omulimisa.org/insurance"> <span class="menu-link py-3">
											<span class="menu-title">Agricultural Insurance</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=askQuestion"> <span class="menu-link py-3">
											<span class="menu-title">Ask a question</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=reportGrievance"> <span class="menu-link py-3">
											<span class="menu-title">Report Grievance</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
								</div>
								<!--end::Menu-->

							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					
					
					
					<!--begin::Toolbar-->
					<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
						<!--begin::Container-->
						<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column me-3">
								<!--begin::Title-->
								<h1 class="d-flex text-dark fw-bolder my-1 fs-3">' . $title . '</h1>
								<!--end::Title-->
								<!--begin::Breadcrumb-->
								<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
									<!--begin::Item-->
									<li class="breadcrumb-item text-gray-600">
										<a href="' . ROOT . '/?action=newhome" class="text-gray-600 text-hover-primary">Home</a>
									</li>
									<!--end::Item-->
									<!--begin::Item-->
									<li class="breadcrumb-item text-gray-600">' . $title . '</li>
									<!--end::Item-->
									
									
								</ul>
								<!--end::Breadcrumb-->
							</div>
							<!--end::Page title-->
							
						</div>
						<!--end::Container-->
					</div>
					<!--end::Toolbar-->
					
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
					
					' . $content . '
					
					
				     	</div>
					</div>
					
					
					
					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-bold me-1">&copy; ' . date("Y") . '</span>
								<a href="https://agriculture.go.ug" target="_blank" class="text-gray-800 text-hover-primary">Ministry of Agriculture, Animal Industry and Fisheries | Uganda</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Menu-->
							<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2">About</a>
								</li>
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2">Support</a>
								</li>

							</ul>
							<!--end::Menu-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Drawers-->




		<!--end::Drawers-->

		
		<!--end::Main-->
		<script>var hostUrl = "' . ROOT . '/includes/public_html/dist/assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="' . ROOT . '/includes/public_html/dist/assets/plugins/global/plugins.bundle.js"></script>
		<script src="' . ROOT . '/includes/public_html/dist/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		
        <!--begin::Page Vendors Javascript(used by this page)-->
		<script src="' . ROOT . '/includes/public_html/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="includes/public_html/dist/assets/js/custom/widgets.js"></script>
		<script src="' . ROOT . '/includes/public_html/dist/assets/js/custom/apps/chat/chat.js"></script>
		<script src="' . ROOT . '/includes/public_html/dist/assets/js/custom/modals/create-app.js"></script>
		<script src="' . ROOT . '/includes/public_html/dist/assets/js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		
     	<script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        
        
        ';

if($_SESSION['action']=='getWeatherAdvisory'){
        echo'<script type="text/javascript">

  /*Next Seven Days Temperature */
Highcharts.chart(\'nextseventemp\', {
    title: {
        text: \'Temperature Forecast\'
    },
    subtitle: {
        text:  \'' . $_SESSION['location_title'] . '\'
    },
    yAxis: {
        title: {
            text: \'Temp in Degrees\'
        }
    },
    legend: {
        layout: \'vertical\',
        align: \'right\',
        verticalAlign: \'middle\'
    },
   xAxis: {
        categories: [' . $_SESSION['next7daysdates'] . ']
    },
    series: [{
        name: \'Temperature Min\',
        data: [' . $_SESSION['next7daystempmin'] . ']
    },{
        name: \'Temperature max\',
        data: [' . $_SESSION['next7daystempmax'] . ']
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: \'horizontal\',
                    align: \'center\',
                    verticalAlign: \'bottom\'
                }
            }
        }]
    }

});

 /*Next Seven Days Forecast */
Highcharts.chart(\'nextsevenprec\', {
    title: {
        text: \'Precipitation Forecast\'
    },
    subtitle: {
        text: \'' . $_SESSION['location_title'] . '\'
    },
    yAxis: {
        title: {
            text: \'Chance in %\'
        }
    },
    legend: {
        layout: \'vertical\',
        align: \'right\',
        verticalAlign: \'middle\'
    },
   xAxis: {
         categories: [' . $_SESSION['next7daysdates'] . ']
    },
    series: [{
        name: \'Precipitation Chances\',
        data: [' . $_SESSION['next7daysprecchance'] . ']
    },{
        name: \'Precipitation Amount\',
        data: [' . $_SESSION['next7daysprecamount'] . ']
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: \'horizontal\',
                    align: \'center\',
                    verticalAlign: \'bottom\'
                }
            }
        }]
    }

}); 

</script>';
         }

if($_SESSION['action']=='getOutbreaksCrises') {
    echo '<script type="text/javascript">       
  /*Outbreaks Histo*/
Highcharts.chart(\'outbreakcrisishisto\', {
    title: {
        text: \'Incidents Reported\'
    },
    subtitle: {
        text:  \'' . $_SESSION['outbreaks_title'] . '\'
    },
    yAxis: {
        title: {
            text: \'No. of Incidents Reported\'
        }
    },
    legend: {
        layout: \'vertical\',
        align: \'right\',
        verticalAlign: \'middle\'
    },
   xAxis: {
        categories: [' . $_SESSION['outbreaks_dates'] . ']
    },
    series: [{
        name: \'Crises\',
        data: [' . $_SESSION['outbreaks_crises'] . ']
    },{
        name: \'Outbreaks\',
        data: [' . $_SESSION['outbreaks_outbreaks'] . ']
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: \'horizontal\',
                    align: \'center\',
                    verticalAlign: \'bottom\'
                }
            }
        }]
    }

});


// Build the chart
Highcharts.chart(\'outbreakcrisispie\', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        text: \'Incidents Reported by Type\'
    },
    tooltip: {
        pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
    },
    accessibility: {
        point: {
            valueSuffix: \'%\'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: \'pointer\',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: \'Incidents\',
        colorByPoint: true,
        data: [{
            name: \'Outbreaks\',
            y: '.$_SESSION['outbreaks_all'].',
            sliced: true,
            selected: true
        }, {
            name: \'Crises\',
            y: '.$_SESSION['crises_all'].'
        }]
    }]
});
  
</script>

';
}

echo'
<script>        
 $(document).ready(function(){
        
         $("#district").change(function(){
        var id = $(this).val();

                $.ajax({
                    url: \'' . ROOT . '/?action=getWeatherSubcountyByDistrict\',
                    type: \'post\',
                    data: {id},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#subcounty").empty();
                        $("#parish").empty();
                            for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#subcounty").append("<option value=\'"+name+"\'>"+name+"</option>");
        
                        }
                    }
                });
            });
       
          
         $("#subcounty").change(function(){
        var subcounty = $(this).val();
        var e = document.getElementById("district");
        var district = e.value;
                
                $.ajax({
                    url: \'' . ROOT . '/?action=getWeatherParishBySubcounty\',
                    type: \'post\',
                    data: {\'district\':district,\'subcounty\':subcounty},
                    dataType: \'json\',
                    success:function(response){
        
                        var len = response.length;
        
                        $("#parish").empty();
                        for( var i = 0; i<len; i++){
                            var id = response[i][\'id\'];
                            var name = response[i][\'name\'];
                            
                            $("#parish").append("<option value=\'"+id+"\'>"+name+"</option>");
        
                        }
                    },
                    error: function(jqxhr, status, exception) {
                        alert(\'Exception:\', exception);
                    }
                });
            });
         
         
     });
 
 </script>';

//Include Map code here if it's Outbreaks and crises
     if($_SESSION['action'] == 'getOutbreaksCrises'){
         echo '
         <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="' . ROOT . '/includes/theme/maps/js/mapsvg.min.js"></script>
        ' . js::prepJs();


        //Load other page dependant scripts
        switch ($_SESSION['action']) {
            case 'getOutbreaksCrises':
                map::plotOutbreaksHeatMap();
                break;

            default:
                break;
        }

    }

        echo'
	</body>
	<!--end::Body-->
</html>

        ';
    }

public  function newTemplateFrontEnd($title='Welcome to the E-extension system', $content='Welcome', $styles=null, $scripts=null)
{

    $action = $_SESSION['action'];
    
    ?>

<!DOCTYPE html>
<html>

    <head>
            
        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">   

        <title><?php echo $title; ?></title>    

        <meta name="keywords" content="WebSite Template" />
        <meta name="description" content="MAAIF - Extension">
        <meta name="author" content="">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo ROOT; ?>/includes/landing/img/maaif-favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="<?php echo ROOT; ?>/includes/landing/img/apple-touch-maaif-icon.png">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

        <!-- Web Fonts  -->
        <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&amp;display=swap" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/animate/animate.compat.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/simple-line-icons/css/simple-line-icons.min.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/owl.carousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/owl.carousel/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/magnific-popup/magnific-popup.min.css">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/theme.css?v=6">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/theme-elements.css?v=4">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/theme-maaif-1.css">
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/theme-maaif-2.css">

        <!-- Current Page CSS -->
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/vendor/circle-flip-slideshow/css/component.css">
        <?php echo $styles ?>

        <!-- Skin CSS -->
        <link id="skinCSS" rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/skins/default.css">

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo ROOT; ?>/includes/landing/css/custom.css?v=5">

        <!-- Head Libs -->
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/modernizr/modernizr.min.js"></script>


        <style>
            .weatherbox {
                line-height: 20px;
                letter-spacing: .5px;
                min-height: 300px;
                padding: 10px;
                color: #464040;
                background-color: #EAFBF9;
                margin: 0 0 10px;
                font-size: 11px;
                border: 1px solid #35b02f;
                display: inline-block;
                border-radius: 5px;
            }

            .datebox {
                padding: 10px;
                text-align: center;
                font-weight: bold;
            }

            .wicon {
                padding: 10px;
                text-align: center;
            }

            .wconditinons {
                text-align: center;
            }
        </style>

    </head>
    <body data-plugin-page-transition class="d-flex flex-column min-vh-100">

        <div class="body">
            <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
                <div class="header-body border-top-0">
                    <div class="header-top">
                        <div class="container">
                            <div class="header-row">
                                <div class="header-column justify-content-center">
                                    <div class="header-row">
                                        <nav class="header-nav-top">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item nav-item-anim-icon">
                                                    <a class="nav-link ps-0" href="#"><i class="fas fa-angle-right"></i> About Us</a>
                                                </li>
                                                <li class="nav-item nav-item-anim-icon">
                                                    <a class="nav-link" href="#"><i class="fas fa-angle-right"></i> Support</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-container container">
                        <div class="header-row">
                            <div class="header-column justify-content-end w-50 order-md-1 d-none d-md-flex">
                                <div class="header-row">
                                    <ul class="header-extra-info">
                                        <li class="m-0">
                                            <div class="feature-box feature-box-style-2 align-items-right">
                                                <div class="feature-box-info">
                                                    <p class="pb-0 font-weight-semibold line-height-5 text-5 text-right">Ministry of Agriculture,<br>Animal Industry and Fisheries</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="header-column justify-content-start justify-content-md-center order-1 order-md-2">
                                <div class="header-row">
                                    <div class="header-logo">
                                        <a href="#">
                                            <img alt="MAAIF" width="100" height="70" data-sticky-width="82" data-sticky-height="58" src="<?php echo ROOT; ?>/includes/landing/img/logo-maaif.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="header-column justify-content-start w-50 order-2 order-md-3">
                                <div class="header-row">
                                    <ul class="header-extra-info">
                                        <li class="m-0">
                                            <div class="feature-box reverse-allres feature-box-style-2 align-items-left">
                                                <div class="feature-box-info">
                                                    <p class="pb-0 font-weight-semibold line-height-5 text-5 text-left">MAAIF<br>e-Extension System | Uganda<br></p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-nav-bar header-nav-bar-top-border">
                        <div class="header-container container">
                            <div class="header-row">
                                <div class="header-column">
                                    <div class="header-row justify-content-end">
                                        <div class="header-nav p-0">
                                            <div class="header-nav header-nav-links justify-content-lg-center">
                                                <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-arrow header-nav-main-dropdown-center header-nav-main-dropdown-center-bottom header-nav-main-effect-3 header-nav-main-sub-effect-1">
                                                    <nav class="collapse">
                                                        <ul class="nav nav-pills flex-column flex-lg-row" id="mainNav">
                                                            <li><a href="<?php echo ROOT; ?>">Home</a></li>
                                                            <li><a class="<?php if($action=='getKMU_FE' || $action=='getKMUByCategory') { echo "active"; } ?>" href="<?php echo ROOT; ?>/?action=getKMU_FE">Knowledge Management</a></li>
                                                            <li><a class="<?php if($action=='getWeatherAdvisory') { echo "active"; } ?>" href="<?php echo ROOT; ?>/?action=getWeatherAdvisory">Weather Advisory</a></li>
                                                            <li class="dropdown">
                                                                <a class="<?php if($action=='getOutbreaksCrises' || $action=='reportOutbreaksCrises') { echo "active"; } ?>" class="dropdown-item dropdown-toggle" href="#">Outbreaks and Crises</a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="<?php echo ROOT; ?>/?action=getOutbreaksCrises">Get Outbreaks and Crises</a></li>
                                                                    <li><a class="dropdown-item" href="<?php echo ROOT; ?>/?action=reportOutbreaksCrises">Report Outbreaks and Crises</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown">
                                                                <a class="" class="dropdown-item dropdown-toggle" href="#">Agricultural Services </a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="https://agriculture.go.ug">MAAIF Web Portal</a></li>
                                                                    <li><a class="dropdown-item" href="https://www.omulimisa.org/insurance">Agricultural Insurance</a></li>
                                                                    <li><a class="dropdown-item" href="https://naro.go.ug">Agricultural Inputs </a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a class="<?php if($action=='askQuestion') { echo "active"; } ?>" href="<?php echo ROOT; ?>/?action=askQuestion">Ask a Question</a></li>
                                                            <li><a class="<?php if($action=='reportGrievance') { echo "active"; } ?>" href="<?php echo ROOT; ?>/?action=reportGrievance">Report Grievance</a></li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                                <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                                    <i class="fas fa-bars"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div role="main" class="main">

                <?php if (isset($action) && $action != 'home' && $action != 'newhome' && $action != 'login') { ?>

                <section class="page-header page-header-modern page-header-background page-header-background-sm parallax overlay overlay-color-dark overlay-show overlay-op-5 mt-0" data-plugin-parallax="" data-plugin-options="{'speed': 1.2}" data-image-src="<?php echo ROOT; ?>/includes/landing/img/page-header.jpg" style="position: relative; overflow: hidden;"><div class="parallax-background" style="background-image: url(&quot;<?php echo ROOT; ?>/includes/landing/img/page-header.jpg&quot;); background-size: cover; position: absolute; top: 0px; left: 0px; width: 100%; height: 180%; transform: translate3d(0px, -50.25px, 0px); background-position-x: 50%;"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 order-2 order-md-1 text-center p-static">
                                <h1><?php echo $title ?></h1>
                            </div>
                        </div>
                    </div>
                </section>

                <?php } ?> 

                <?php echo $content; ?>

            </div>

            <footer id="footer">
                <div class="footer-copyright">
                    <div class="container py-2">
                        <div class="row py-2">
                            <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                                <a href="#" class="logo pe-0 pe-lg-3">
                                    <img alt="MAAIF Img" src="<?php echo ROOT; ?>/includes/landing/img/logo-maaif-footer.png" class="" height="32">
                                </a>
                            </div>
                            <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                                <p>© Copyright 2022. Ministry of Agriculture, Animal Industry and Fisheries | Uganda</p>
                            </div>
                            <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                                <nav id="sub-menu">
                                    <ul>
                                        <li><i class="fas fa-angle-right"></i><a href="#" class="ms-1 text-decoration-none"> About Us</a></li>
                                        <li><i class="fas fa-angle-right"></i><a href="#" class="ms-1 text-decoration-none"> Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>   

        <!-- Vendor -->
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery/jquery.min.js"></script>


        <?php echo $scripts ?>

        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.appear/jquery.appear.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.easing/jquery.easing.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.cookie/jquery.cookie.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.validation/jquery.validate.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/jquery.gmap/jquery.gmap.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/lazysizes/lazysizes.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/isotope/jquery.isotope.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/owl.carousel/owl.carousel.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/vide/jquery.vide.min.js"></script>
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/vivus/vivus.min.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo ROOT; ?>/includes/landing/js/theme.js"></script>

        <!-- Circle Flip Slideshow Script -->
        <script src="<?php echo ROOT; ?>/includes/landing/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
        <!-- Current Page Views -->
        <script src="<?php echo ROOT; ?>/includes/landing/js/views/view.home.js"></script>


        <!-- Theme Initialization Files -->
        <script src="<?php echo ROOT; ?>/includes/landing/js/theme.init.js"></script>


    </body>

    </html>


        <?php
}

public static function newLetsLogin()
{

    $content = '
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 ps-lg-0 pe-lg-2 mb-3 appear-animation" data-appear-animation="fadeInRightShorter">
                            <span class="thumb-info thumb-info-no-borders thumb-info-no-borders thumb-info-lighten thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom">
                                <span class="thumb-info-wrapper overlay overlay-show overlay-op-8">
                                    <img src="'.ROOT.'/includes/landing/img/maaif-farmers.jpg" class="img-fluid" alt="">
                                    <span class="thumb-info-title bg-transparent mb-4 ps-4 ms-2">
                                        <span class="thumb-info-inner font-weight-bold text-4 line-height-4">Farmers</span>
                                        <span class="thumb-info-show-more-content pe-3">
                                            <p class="mb-0 text-1 line-height-9 pe-5 pb-3 me-5 mb-3 mt-2">...</p>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                        <div class="col-lg-4 px-lg-1 mb-3 appear-animation" data-appear-animation="fadeInDownShorter" data-appear-animation-delay="600">
                            <span class="thumb-info thumb-info-no-borders thumb-info-no-borders thumb-info-lighten thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom">
                                <span class="thumb-info-wrapper overlay overlay-show overlay-op-8">
                                    <img src="'.ROOT.'/includes/landing/img/maaif-extension.jpg" class="img-fluid" alt="">
                                    <span class="thumb-info-title bg-transparent mb-4 ps-4 ms-2">
                                        <span class="thumb-info-inner font-weight-bold text-4 line-height-4">Extension Officers</span>
                                        <span class="thumb-info-show-more-content pe-3">
                                            <p class="mb-0 text-1 line-height-9 pe-5 pb-3 me-5 mb-3 mt-2">...</p>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                        <div class="col-lg-4 pe-lg-0 ps-lg-2 mb-3 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
                            <span class="thumb-info thumb-info-no-borders thumb-info-no-borders thumb-info-lighten thumb-info-bottom-info thumb-info-bottom-info-dark thumb-info-bottom-info-show-more thumb-info-no-zoom">
                                <span class="thumb-info-wrapper overlay overlay-show overlay-op-8">
                                    <img src="'.ROOT.'/includes/landing/img/maaif-maaif.jpg" class="img-fluid" alt="">
                                    <span class="thumb-info-title bg-transparent mb-4 ps-4 ms-2">
                                        <span class="thumb-info-inner font-weight-bold text-4 line-height-4">MAAIF</span>
                                        <span class="thumb-info-show-more-content pe-3">
                                            <p class="mb-0 text-1 line-height-9 pe-5 pb-3 me-5 mb-3 mt-2">...</p>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>';

        $content .= '<section class="section section-height-2 m-0 border-0">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 pb-sm-4 pb-lg-0 pe-lg-5 mb-sm-5 mb-lg-0">
                                <h2 class="text-color-main font-weight-normal text-6 mb-2"><strong class="font-weight-extra-bold">MAAIF E-Extension</strong> System</h2>
                                <p class="lead">The MAAIF E-Extension system showcases agricultural training videos in local languages, Profile information for key stake holders in the agriculture sector, Weather advisory, Crises and Outbreaks information  from all over Uganda. </p>                                

                                    <div class="row">
                                      <div class="col-lg-12">
                                        <div class="owl-carousel owl-theme dots-morphing owl-loaded owl-drag owl-carousel-init" data-plugin-options="{\'responsive\': {\'0\': {\'items\': 1}, \'479\': {\'items\': 1}, \'768\': {\'items\': 2}, \'979\': {\'items\': 3}, \'1199\': {\'items\': 3}}, \'loop\': true, \'autoHeight\': true, \'margin\': 10, \'autoplay\': true, \'autoplayTimeout\': 4000, \'animateIn\': \'slideInDown\', \'animateOut\': \'slideOutDown\'}" style="height: auto;">
                                          <div class="owl-stage-outer owl-height" style="height: 175.333px;">
                                            <div class="owl-stage" style="transform: translate3d(-926px, 0px, 0px); transition: all 0.5s ease 0s; width: 1483px;">
                                              <div class="owl-item" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-2.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-3.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-4.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item active" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-2.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item active" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-3.jpg">
                                                </div>
                                              </div>
                                              <div class="owl-item active" style="width: 175.333px; margin-right: 10px;">
                                                <div>
                                                  <img alt="" class="img-fluid rounded" src="'.ROOT.'/includes/landing/img/maaif-farmers-4.jpg">
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div class="featured-box featured-box-success text-start mt-0">
                                        <div class="box-content">';

                                        if(!$_SESSION['live']){

                                            $content .= '<h4 class="text-success font-weight-semibold text-4 text-uppercase mb-3">Sign In</h4>
                                                            <form action="#" id="frmSignIn" method="post" class="needs-validation" novalidate="novalidate">
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <label class="form-label">Username or E-mail Address</label>
                                                                        <input type="text" name="username" autocomplete="off" value="" class="form-control form-control-lg" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col">
                                                                        <a class="float-end" href="'.ROOT.'/?action=forgotPassword">(Forgot Password?)</a>
                                                                        <label class="form-label">Password</label>
                                                                        <input type="password" name="password" value="" class="form-control form-control-lg" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-lg-6">
                                                                        &nbsp;
                                                                    </div>
                                                                    <div class="form-group col-lg-6">
                                                                        <input type="hidden" name="action"  value="doLogin" />
                                                                        <input type="submit" value="Login" class="btn btn-success btn-modern float-end" data-loading-text="Loading...">
                                                                    </div>
                                                                </div>
                                                            </form>';

                                        }else{

                                            //Show Dashboard Menu Here

                                        }


                            $content .= '</div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </section>';

        $_content = '
                        <section class="parallax section section-parallax section-center mt-0 mb-0" data-plugin-parallax="" data-plugin-options="{\'speed\': 2}" data-image-src="'.ROOT.'/includes/landing/img/parallax-home.jpg" style="position: relative; overflow: hidden;"><div class="parallax-background" style="background-image: url(&quot;'.ROOT.'/includes/landing/img/parallax-home.jpg&quot;); background-size: cover; position: absolute; top: 0px; left: 0px; width: 100%; height: 180%; transform: translate3d(0px, -77.4286px, 0px); background-position-x: 50%;"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card border-radius-1 bg-color-light box-shadow-1">
                                            <div class="card-body">
                                                <h4 class="card-title text-primary">Weather</h4>
                                                <p class="card-text">Latest Weather 7 Days forecast <br>{Entebbe} District</p>

                                                <div>
                                                    {fetch data here}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">                                        
                                        <div class="card border-radius-1 bg-color-light box-shadow-1">
                                            <div class="card-body">
                                                <h4 class="card-title text-primary">Activities</h4>
                                                <p class="card-text">Summary of Number of activities reported in the last 2 weeks organized by sector and Zardi</p>

                                                <div>
                                                    {fetch data here}
                                                </div>

                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
                        </section>';

        $_content = '
                        <section class="bg-white section section-center mt-0 mb-0">
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card border-radius-1 bg-color-light box-shadow-1 align-items-center">
                                            <div class="card-body">
                                                <h4 class="card-title text-danger">Grievances</h4>
                                                <p class="card-text">Summary of grievances reported in the last 2 weeks by Nature & Type</p>

                                                <div>
                                                    {fetch data here}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">                                        
                                        <div class="card border-radius-1 bg-color-light box-shadow-1 align-items-center">
                                            <div class="card-body">
                                                <h4 class="card-title text-danger">Outbreaks and Crises</h4>
                                                <p class="card-text">Summary of Outbreaks and Crises Reported in the last 2 weeks by Nature & Type</p>

                                                <div>
                                                    {fetch data here}
                                                </div>

                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>                                
                            </div>
                        </section>';

        $content .= '<div id="examples" class="container py-2">

                    <div class="row">
                        <div class="col-md-8">

                            <div class="tabs tabs-bottom tabs-center tabs-simple">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#tabsNavigationSimpleIcons1" data-bs-toggle="tab">
                                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                                    <span class="box-content p-0 m-0">
                                                        <i class="icon-featured fas fa-video"></i>
                                                    </span>
                                                </span>
                                            </span>                                 
                                            <p class="mb-0 pb-0">Latest<br>Videos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tabsNavigationSimpleIcons2" data-bs-toggle="tab">
                                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                                    <span class="box-content p-0 m-0">
                                                        <i class="icon-featured fas fa-seedling"></i>
                                                    </span>
                                                </span>
                                            </span>                                 
                                            <p class="mb-0 pb-0">Crop<br>Videos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tabsNavigationSimpleIcons3" data-bs-toggle="tab">
                                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                                    <span class="box-content p-0 m-0">
                                                        <i class="icon-featured fas fa-paw"></i>
                                                    </span>
                                                </span>
                                            </span>                                 
                                            <p class="mb-0 pb-0">Livestock<br>Videos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tabsNavigationSimpleIcons4" data-bs-toggle="tab">
                                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                                    <span class="box-content p-0 m-0">
                                                        <i class="icon-featured fas fa-fish"></i>
                                                    </span>
                                                </span>
                                            </span>                                 
                                            <p class="mb-0 pb-0">Aquaculture<br>Videos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tabsNavigationSimpleIcons5" data-bs-toggle="tab">
                                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                                    <span class="box-content p-0 m-0">
                                                        <i class="icon-featured fas fa-otter"></i>
                                                    </span>
                                                </span>
                                            </span>                                 
                                            <p class="mb-0 pb-0">Entomology<br>Videos</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabsNavigationSimpleIcons1">
                                        <div class="row">
                                            <div class="col">
                                                <!-- <h4>Customer Support</h4> -->
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideos().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsNavigationSimpleIcons2">
                                        <div class="row">
                                            <div class="col">
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideos().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsNavigationSimpleIcons3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideos().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsNavigationSimpleIcons4">
                                        <div class="row">
                                            <div class="col">
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideos().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabsNavigationSimpleIcons5">
                                        <div class="row">
                                            <div class="col">
                                                <div class="blog-posts">

                                                    <div class="row">

                                                        <!-- videos -->
                                                        '.self::getLatestVideos().'

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            '.self::getAsideKMUMenu().'
                        </div>
                    </div>                   

                </div>';


                $content .= '
                            <section class="bg-white">
                                <div class="container pt-5">
                                    <div class="row">
                                        <div class="col-md-8 col-lg-8">
                                            <h4 class="text-success"><strong>MAAIF</strong> Partners</h4>
                                            <div class="owl-carousel owl-theme owl-loaded owl-drag owl-carousel-init" data-plugin-options="{\'items\': 4, \'autoplay\': true, \'autoplayTimeout\': 3000, \'loop\': true}" style="height: auto;">
                                                <div class="owl-stage-outer">
                                                    <div class="owl-stage" style="transform: translate3d(-1228px, 0px, 0px); transition: all 0.25s ease 0s; width: 3276px;">
                                                        <div class="owl-item cloned" style="width: 136.5px;"><div>
                                                        <img class="img-fluid" src="'.ROOT.'/includes/landing/img/partner.png" alt="">
                                                        </div></div>
                                                        <div class="owl-item cloned" style="width: 136.5px;">
                                                        <div>
                                                            <img class="img-fluid" src="'.ROOT.'/includes/landing/img/partner-2.png" alt="">
                                                        </div>
                                                        </div>
                                                        <div class="owl-item cloned" style="width: 136.5px;"><div>
                                                            <img class="img-fluid" src="'.ROOT.'/includes/landing/img/partner-3.png" alt="">
                                                        </div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">

                                                <div class="appear-animation animated fadeInUpShorter appear-animation-visible" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" style="animation-delay: 800ms;">
                                                    <h4 class="text-success"><strong>DAES</strong> Sectors Contacts</h4>
                                                    <!-- <ul class="list list-icons list-primary">
                                                        <li><i class="fas fa-check"></i> ...</li>
                                                        <li><i class="fas fa-check"></i> ...</li>
                                                        <li><i class="fas fa-check"></i> ...</li>
                                                    </ul> -->
                                                </div>

                                            </div>
                                    </div> 
                                </div>                    
                            </section>';

                $styles = '
                <style type="text/css">
                    .card.categories {
                          /*height: 1172px;*/
                          margin: 10px auto;
                        }
                    .card .scrollable{
                          overflow-y: auto;
                          max-height: 1102px;
                            }
                    .tree,
                    .tree ul {
                      margin: 0;
                      padding: 0;
                      list-style: none;
                    }

                    .tree ul {
                      margin-left: 0.4em;
                      position: relative;
                    }

                    .tree ul ul {
                      margin-left: .3em;
                    }

                    .tree ul:before {
                      content: "";
                      display: block;
                      width: 0;
                      position: absolute;
                      top: 0;
                      bottom: 0;
                      left: 0;
                      border-left: 1px solid;
                    }

                    .tree li {
                      margin: 0;
                      padding: 0 0.8em;
                      line-height: 2em;
                      color: #555;
                      font-weight: 700;
                      position: relative;
                    }

                    .tree ul li:before {
                      content: "";
                      display: block;
                      width: 10px;
                      height: 0;
                      border-top: 1px solid;
                      margin-top: -1px;
                      position: absolute;
                      top: 1em;
                      left: 0;
                    }

                    .tree ul li:last-child:before {
                      background: #fff;
                      height: auto;
                      top: 1em;
                      bottom: 0;
                    }

                    .indicator {
                      /*margin-right: 5px;*/
                      font-size: 9px;
                    }

                    .tree li a {
                      text-decoration: none;
                      color: #06f;
                    }

                    .tree li button,
                    .tree li button:active,
                    .tree li button:focus {
                      text-decoration: none;
                      color: #555;
                      border: none;
                      background: transparent;
                      margin: 0px 0px 0px 0px;
                      padding: 0px 0px 0px 0px;
                      outline: 0;
                    }

                    .tree ul,
                    .tree li {
                      cursor: pointer;
                    }

                    .tree .btn-default.active {
                      background-color: #1c90c1;
                      color: #fff;
                    }

                    .tree .btn-default {
                      background-color: #eee;
                    }

                    .tree .fa-info-circle {
                      color: #1c90c1;
                    }

                    .tree .categories {
                        margin-right: 10px;
                        font-size: 20px;
                    }

                    .tree ul li ul li .indicator {
                        margin-right: 5px !important;
                    }
                    .featured-box-success .box-content {
                        border-top-color: #198754;
                    }
                    .text-color-main {
                        color: #198754;
                    }
                </style> ';

                $scripts = '
                    <script>
                        /* 
                        =========
                        TREEVIEW 
                        =========
                        */

                        $.fn.extend({
                          treed: function() {
                            return this.each(function() {
                              //initialize each of the top levels
                              var tree = $(this);
                              tree.addClass("tree");
                              tree.find(\'li\').has("ul").each(function() {
                                var branch = $(this); //li with children ul
                                branch.prepend("<i class=\'indicator fas fa-plus\'></i>");
                                branch.addClass(\'branch\');
                                branch.on(\'click\', function(e) {
                                  if (this == e.target) {
                                    var icon = $(this).children(\'i:first\');
                                    icon.toggleClass("fa-minus fa-plus");
                                    $(this).children().children().toggle();
                                  }
                                })
                                branch.children().children().toggle();
                              });
                              //fire event from the dynamically added icon
                              $(\'.branch .indicator\').on(\'click\', function() {
                                $(this).closest(\'li\').click();
                              });
                              //fire event to open branch if the li contains an anchor instead of text
                              $(\'.branch a\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                // e.preventDefault();
                              });
                              //fire event to open branch if the li contains a button instead of text
                              $(\'.branch button\').on(\'click\', function(e) {
                                $(this).closest(\'li\').click();
                                e.preventDefault();
                              });
                            });
                          }
                        });

                        $(\'.tree\').treed();
                    </script>';

            return [
                'content' => $content,        
                'styles' => $styles,
                'scripts' => $scripts
            ];
}

public static function LetsLogin()
{

    echo '
        
       <!DOCTYPE html>
<!--
Author: Herbert Musoke / M-Omulimsia
Product Name: MAAIF E-Extension
Website: http://www.herbertmusoke.com
Contact: me@herbertmusoke.com
Follow: www.twitter.com/HerbertMusoke
Like: www.facebook.com/HerbertMusokeOfficial
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>MAAIF E-Extension</title>
		<meta charset="utf-8" />
		<meta name="description" content="MAAIF E-Extension" />
		<meta name="keywords" content="MAAIF E-Extension" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="MAAIF E-Extension" />
		<meta property="og:url" content="'.ROOT.'/" />
		<meta property="og:site_name" content="E-Extension | MAAIF Uganda" />
		<link rel="canonical" href="'.ROOT.'/" />
		<link rel="shortcut icon" href="' . ROOT . '/favicon.jpg" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="' . ROOT . '/includes/public_html/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="' . ROOT . '/includes/public_html/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="' . ROOT . '/includes/public_html/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: \'200px\', lg: \'300px\'}">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-grow-1 flex-stack">
							<!--begin::Header Logo-->
							<div class="d-flex align-items-center me-5">
								<!--begin::Heaeder menu toggle-->
								<div class="d-lg-none btn btn-icon btn-active-color-primary w-30px h-30px ms-n2 me-3" id="kt_header_menu_toggle">
									<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
									<span class="svg-icon svg-icon-1">
										<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Heaeder menu toggle-->
								<a href="' . ROOT . '">
									<img alt="Logo" src="' . ROOT . '/logo-sm.png" class="h-20px h-lg-30px" />
								</a>
							</div>
							<!--end::Header Logo-->
							<!--begin::Topbar-->
							<div class="d-flex align-items-center">
								<!--begin::Topbar-->
								<div class="d-flex align-items-center flex-shrink-0">
									<!--begin::Search-->
									<div id="kt_header_search" class="d-flex align-items-center w-lg-225px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
										<!--begin::Tablet and mobile search toggle-->
										<div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
											<div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary w-30px h-30px">
												<!--begin::Svg Icon | path: icons/duotune/general/gen004.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black" />
														<path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
										</div>
										<!--end::Tablet and mobile search toggle-->
										<!--begin::Form-->
										<form data-kt-search-element="form" action="' . ROOT . '" class="d-none d-lg-block w-100 mb-5 mb-lg-0 position-relative" autocomplete="off">
											
										
											<!--begin::Hidden input(Added to disable form autocomplete)-->
											<input type="hidden" />
											<!--	<select name="category" data-control="select2" data-hide-search="true" data-placeholder="Select a Category..." class="form-select form-select-solid">
															<option value="">Select a Category...</option>
															<option value="1">CRM</option>
															<option value="2">Project Alice</option>
															<option value="3">Keenthemes</option>
															<option value="4">General</option>
														</select>-->
											<!--end::Hidden input-->
											<!--begin::Icon-->
											<!--begin::Svg Icon | path: icons/duotune/general/gen004.svg-->
											<span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
												<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black" />
													<path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
											<!--end::Icon-->
											<!--begin::Input-->
											<input type="text" class="form-control bg-transparent ps-13 fs-7 h-40px" name="search" value="" placeholder="Type a topic to search" data-kt-search-element="input" />
											<!--end::Input-->
											<!--begin::Spinner-->
											<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
												<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
											</span>
											<!--end::Spinner-->
											<!--begin::Reset-->
											<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
												<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
													<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
														<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</span>
											<!--end::Reset-->
										</form>
										<!--end::Form-->
										<!--begin::Menu-->
										<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown w-300px w-md-350px py-7 px-7 overflow-hidden">
											<!--begin::Wrapper-->
											<div data-kt-search-element="wrapper">
												<!--begin::Recently viewed-->
												<div data-kt-search-element="results" class="d-none">
													<!--begin::Items-->
													<div class="scroll-y mh-200px mh-lg-350px">
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-1.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Karina Clark</span>
																<span class="fs-7 fw-bold text-muted">Marketing Manager</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-3.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Olivia Bold</span>
																<span class="fs-7 fw-bold text-muted">Software Engineer</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-8.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Ana Clark</span>
																<span class="fs-7 fw-bold text-muted">UI/UX Designer</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-11.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Nick Pitola</span>
																<span class="fs-7 fw-bold text-muted">Art Director</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<img src="'.ROOT.'/includes/public_html/dist/assets/media/avatars/150-12.jpg" alt="" />
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Edward Kulnic</span>
																<span class="fs-7 fw-bold text-muted">System Administrator</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/volicity-9.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Company Rbranding</span>
																<span class="fs-7 fw-bold text-muted">UI Design</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/tvit.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Company Re-branding</span>
																<span class="fs-7 fw-bold text-muted">Web Development</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/misc/infography.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Business Analytics App</span>
																<span class="fs-7 fw-bold text-muted">Administration</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/leaf.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">EcoLeaf App Launch</span>
																<span class="fs-7 fw-bold text-muted">Marketing</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<img class="w-20px h-20px" src="'.ROOT.'/includes/public_html/dist/assets/media/svg/brand-logos/tower.svg" alt="" />
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column justify-content-start fw-bold">
																<span class="fs-6 fw-bold">Tower Group Website</span>
																<span class="fs-7 fw-bold text-muted">Google Adwords</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Category title-->
														<h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
														<!--end::Category title-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM15 17C15 16.4 14.6 16 14 16H8C7.4 16 7 16.4 7 17C7 17.6 7.4 18 8 18H14C14.6 18 15 17.6 15 17ZM17 12C17 11.4 16.6 11 16 11H8C7.4 11 7 11.4 7 12C7 12.6 7.4 13 8 13H16C16.6 13 17 12.6 17 12ZM17 7C17 6.4 16.6 6 16 6H8C7.4 6 7 6.4 7 7C7 7.6 7.4 8 8 8H16C16.6 8 17 7.6 17 7Z" fill="black" />
																			<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Si-Fi Project by AU Themes</span>
																<span class="fs-7 fw-bold text-muted">#45670</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
																			<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
																			<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
																			<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Shopix Mobile App Planning</span>
																<span class="fs-7 fw-bold text-muted">#45690</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black" />
																			<rect x="6" y="12" width="7" height="2" rx="1" fill="black" />
																			<rect x="6" y="7" width="12" height="2" rx="1" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Finance Monitoring SAAS Discussion</span>
																<span class="fs-7 fw-bold text-muted">#21090</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
														<!--begin::Item-->
														<a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black" />
																			<path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<span class="fs-6 fw-bold">Dashboard Analitics Launch</span>
																<span class="fs-7 fw-bold text-muted">#34560</span>
															</div>
															<!--end::Title-->
														</a>
														<!--end::Item-->
													</div>
													<!--end::Items-->
												</div>
												<!--end::Recently viewed-->
												<!--begin::Recently viewed-->
												<div data-kt-search-element="main">
													<!--begin::Heading-->
													<div class="d-flex flex-stack fw-bold mb-5">
														<!--begin::Label-->
														<span class="text-muted fs-6 me-2">Recently Searched</span>
														<!--end::Label-->
														<!--begin::Toolbar-->
														<div class="d-flex" data-kt-search-element="toolbar">
															<!--begin::Preferences toggle-->
															<div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-2 data-bs-toggle=" title="Show search preferences">
																<!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="black" />
																		<path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="black" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</div>
															<!--end::Preferences toggle-->
															<!--begin::Advanced search toggle-->
															<div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-n1" data-bs-toggle="tooltip" title="Show more search options">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</div>
															<!--end::Advanced search toggle-->
														</div>
														<!--end::Toolbar-->
													</div>
													<!--end::Heading-->
													<!--begin::Items-->
													<div class="scroll-y mh-200px mh-lg-325px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/electronics/elc004.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black" />
																			<path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black" />
																			<path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">BoomApp by Keenthemes</a>
																<span class="fs-7 text-muted fw-bold">#45789</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra001.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="black" />
																			<path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"Kept API Project Meeting</a>
																<span class="fs-7 text-muted fw-bold">#84050</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra006.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black" />
																			<path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"KPI Monitoring App Launch</a>
																<span class="fs-7 text-muted fw-bold">#84250</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra002.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 8L12.5 5L5 14V19H20V8Z" fill="black" />
																			<path d="M21 18H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Reference FAQ</a>
																<span class="fs-7 text-muted fw-bold">#67945</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="black" />
																			<path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"FitPro App Development</a>
																<span class="fs-7 text-muted fw-bold">#84250</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path d="M20 19.725V18.725C20 18.125 19.6 17.725 19 17.725H5C4.4 17.725 4 18.125 4 18.725V19.725H3C2.4 19.725 2 20.125 2 20.725V21.725H22V20.725C22 20.125 21.6 19.725 21 19.725H20Z" fill="black" />
																			<path opacity="0.3" d="M22 6.725V7.725C22 8.325 21.6 8.725 21 8.725H18C18.6 8.725 19 9.125 19 9.725C19 10.325 18.6 10.725 18 10.725V15.725C18.6 15.725 19 16.125 19 16.725V17.725H15V16.725C15 16.125 15.4 15.725 16 15.725V10.725C15.4 10.725 15 10.325 15 9.725C15 9.125 15.4 8.725 16 8.725H13C13.6 8.725 14 9.125 14 9.725C14 10.325 13.6 10.725 13 10.725V15.725C13.6 15.725 14 16.125 14 16.725V17.725H10V16.725C10 16.125 10.4 15.725 11 15.725V10.725C10.4 10.725 10 10.325 10 9.725C10 9.125 10.4 8.725 11 8.725H8C8.6 8.725 9 9.125 9 9.725C9 10.325 8.6 10.725 8 10.725V15.725C8.6 15.725 9 16.125 9 16.725V17.725H5V16.725C5 16.125 5.4 15.725 6 15.725V10.725C5.4 10.725 5 10.325 5 9.725C5 9.125 5.4 8.725 6 8.725H3C2.4 8.725 2 8.325 2 7.725V6.725L11 2.225C11.6 1.925 12.4 1.925 13.1 2.225L22 6.725ZM12 3.725C11.2 3.725 10.5 4.425 10.5 5.225C10.5 6.025 11.2 6.725 12 6.725C12.8 6.725 13.5 6.025 13.5 5.225C13.5 4.425 12.8 3.725 12 3.725Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Shopix Mobile App</a>
																<span class="fs-7 text-muted fw-bold">#45690</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-5">
															<!--begin::Symbol-->
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<!--begin::Svg Icon | path: icons/duotune/graphs/gra002.svg-->
																	<span class="svg-icon svg-icon-2 svg-icon-primary">
																		<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M20 8L12.5 5L5 14V19H20V8Z" fill="black" />
																			<path d="M21 18H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Title-->
															<div class="d-flex flex-column">
																<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">"Landing UI Design" Launch</a>
																<span class="fs-7 text-muted fw-bold">#24005</span>
															</div>
															<!--end::Title-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
												</div>
												<!--end::Recently viewed-->
												<!--begin::Empty-->
												<div data-kt-search-element="empty" class="text-center d-none">
													<!--begin::Icon-->
													<div class="pt-10 pb-10">
														<!--begin::Svg Icon | path: icons/duotune/files/fil024.svg-->
														<span class="svg-icon svg-icon-4x opacity-50">
															<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black" />
																<path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black" />
																<rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black" />
																<path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Message-->
													<div class="pb-15 fw-bold">
														<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
														<div class="text-muted fs-7">Please try again with a different query</div>
													</div>
													<!--end::Message-->
												</div>
												<!--end::Empty-->
											</div>
											<!--end::Wrapper-->
											<!--begin::Preferences-->
											<form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
												<!--begin::Heading-->
												<h3 class="fw-bold text-dark mb-7">Advanced Search</h3>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Radio group-->
													<div class="nav-group nav-group-fluid">
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="has" checked="checked" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="users" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="orders" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="type" value="projects" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
														</label>
														<!--end::Option-->
													</div>
													<!--end::Radio group-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<!--begin::Radio group-->
													<div class="nav-group nav-group-fluid">
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
														</label>
														<!--end::Option-->
														<!--begin::Option-->
														<label>
															<input type="radio" class="btn-check" name="attachment" value="any" />
															<span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
														</label>
														<!--end::Option-->
													</div>
													<!--end::Radio group-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="mb-5">
													<select name="timezone" aria-label="Select a Timezone" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
														<option value="next">Within the next</option>
														<option value="last">Within the last</option>
														<option value="between">Between</option>
														<option value="on">On</option>
													</select>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-8">
													<!--begin::Col-->
													<div class="col-6">
														<input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
													</div>
													<!--end::Col-->
													<!--begin::Col-->
													<div class="col-6">
														<select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
															<option value="days">Days</option>
															<option value="weeks">Weeks</option>
															<option value="months">Months</option>
															<option value="years">Years</option>
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="d-flex justify-content-end">
													<button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
													<a href="../../demo11/dist/pages/search/horizontal.html" class="btn btn-sm fw-bolder btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Preferences-->
											<!--begin::Preferences-->
											<form data-kt-search-element="preferences" class="pt-1 d-none">
												<!--begin::Heading-->
												<h3 class="fw-bold text-dark mb-7">Search Preferences</h3>
												<!--end::Heading-->
												<!--begin::Input group-->
												<div class="pb-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Projects</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Targets</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Affiliate Programs</span>
														<input class="form-check-input" type="checkbox" value="1" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Referrals</span>
														<input class="form-check-input" type="checkbox" value="1" checked="checked" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="py-4 border-bottom">
													<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
														<span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Users</span>
														<input class="form-check-input" type="checkbox" value="1" />
													</label>
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="d-flex justify-content-end pt-7">
													<button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
													<button type="submit" class="btn btn-sm fw-bolder btn-primary">Save Changes</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Preferences-->
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Search-->';
if($_SESSION['live']){
    echo '<!--begin::User-->
									<div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
										<!--begin::Menu- wrapper-->
										<!--begin::User icon(remove this button to use user avatar as menu toggle)-->
										<div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
											<span class="svg-icon svg-icon-1">
												<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
													<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
										<!--end::User icon-->
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<!--begin::Avatar-->
													<div class="symbol symbol-50px me-5">
														<img alt="Logo" src="'.ROOT.'/images/users/'.$_SESSION['user']['photo'].'" alt="'.$_SESSION['user']['first_name'].'  />
													</div>
													<!--end::Avatar-->
													<!--begin::Username-->
													<div class="d-flex flex-column">
														<div class="fw-bolder d-flex align-items-center fs-5">'.$_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'].'
														</div>
														'.user::getUserCategory($_SESSION['user']['user_category_id']).'<br />
														<a href="#" class="fw-bold text-muted text-hover-primary fs-7">'.$_SESSION['user']['email'].'</a>
													</div>
													<!--end::Username-->
												</div>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="#" class="menu-link px-5">My Profile</a>
											</div>
											<!--end::Menu item-->
											
											
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											
											<!--begin::Menu item-->
											<div class="menu-item px-5 my-1">
												<a href="#" class="menu-link px-5">Account Settings</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="'.ROOT.'/?action=logout" class="menu-link px-5">Sign Out</a>
											</div>
											<!--end::Menu item-->
											
										
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::User -->';


}

                        echo'<!--begin::Sidebar Toggler-->
									<!--end::Sidebar Toggler-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
						<!--begin::Separator-->
						<div class="separator"></div>
						<!--end::Separator-->
						<!--begin::Container-->
						<div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px" id="kt_header_nav">
							<!--begin::Menu wrapper-->
							<div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:\'200px\', \'300px\': \'250px\'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: \'#kt_body\', lg: \'#kt_header_nav\'}">
    <!--begin::Menu-->
								<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
									
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<a href="' . ROOT . '"><span class="menu-link py-3">
											<span class="menu-title">Home</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>	
									</div>
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<a href="' . ROOT . '/?action=getKMU_FE"><span class="menu-link py-3">
											<span class="menu-title">Knowledge Management</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>	
									</div>
									<div  data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1" >
									<a href="'.ROOT.'/?action=getWeatherAdvisory">	<span class="menu-link py-3">
											<span class="menu-title">Get Weather Advisory</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="'.ROOT.'/?action=getOutbreaksCrises">	<span class="menu-link py-3">
											<span class="menu-title">Outbreaks and Crises</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>


									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a target="_target" href="https://www.omulimisa.org/insurance"><span class="menu-link py-3">
											<span class="menu-title">Agricultural Insurance</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
                                    <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=askQuestion"> <span class="menu-link py-3">
											<span class="menu-title">Ask a question</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>
									<div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
									<a href="' . ROOT . '/?action=reportGrievance"> <span class="menu-link py-3">
											<span class="menu-title">Report Grievance</span>
											<span class="menu-arrow d-lg-none"></span>
										</span></a>
									</div>

								
								</div>
								<!--end::Menu-->

							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Toolbar-->
					<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
						<!--begin::Container-->
						<div id="kt_toolbar_container" class="container-xxl py-5">
							<!--begin::Row-->
							<div class="row gy-0 gx-10">
								<div class="col-xl-8">
									<!--begin::Engage widget 2-->
									<div class="card card-xl-stretch bg-body border-0 mb-5 mb-xl-0">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-lg-row flex-stack p-lg-15">
											<!--begin::Info-->
											<div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start me-10 text-center text-lg-start">
												<!--begin::Title-->
												<h3 class="fs-2hx line-height-lg mb-5">
													<span class="fw-bold">MAAIF E-Extension </span>
													<br />
													<span class="fw-bolder">System</span>
												</h3>
												<!--end::Title-->
												<div class="fs-4 text-muted mb-7">The MAAIF E-Extension system showcases agricultural training videos in local languages, Profile information for key stake holders in the agriculture sector, Weather advisory, Crises and Outbreaks information  from all over Uganda. </div>
											</div>
											<!--end::Info-->
											<!--begin::Illustration-->
											<img src="./coffee_man.jpg" alt="" class="mw-200px mw-lg-350px mt-lg-n10" />
											<!--end::Illustration-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 2-->
								</div>
								<div class="col-xl-4">
									<!--begin::Mixed Widget 16-->
									<div class="card card-xl-stretch bg-body border-0">
										<!--begin::Body-->
										<div class="card-body pt-5 mb-xl-9 position-relative">
											<!--begin::Heading-->
											<div class="d-flex flex-stack">
												
											</div>
											<!--end::Heading-->

											<!--begin::Content-->
											<div class="w-lg-500px p-10 p-lg-15 mx-auto">';
                                             if(!$_SESSION['live']){

                                                 //Show login form here


												echo'<form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_in_form" action="#">
													<!--begin::Heading-->
													<div class=" mb-8">
														<!--begin::Title-->
														<h1 class="text-dark mb-3">Sign In to E-Extension</h1>
														<!--end::Title-->
														<!--begin::Link-->
														<div class="text-gray-400 fw-bold fs-4">New Here?
															<a href="#" class="link-primary fw-bolder">Create an Account</a></div>
														<!--end::Link-->
													</div>
													<!--begin::Heading-->
													<!--begin::Input group-->
													<div class="fv-row w-50 mb-5 fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="form-label fs-6 fw-bolder text-dark">Email</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input class="form-control form-control-sm form-control-solid" type="text" name="username" autocomplete="off">
														<!--end::Input-->
														<div class="fv-plugins-message-container invalid-feedback"></div></div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row  w-50 mb-5  fv-plugins-icon-container">
														<!--begin::Wrapper-->
														<div class="d-flex flex-stack mb-2">
															<!--begin::Label-->
															<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
															<!--end::Label-->

														</div>
														<!--end::Wrapper-->
														<!--begin::Input-->
														<input class="form-control form-control-sm form-control-solid" type="password" name="password" autocomplete="off">
														<!--end::Input-->
														<div class="fv-plugins-message-container invalid-feedback"></div></div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="">
														<!--begin::Submit button-->
														 <input type="hidden" name="action"  value="doLogin" />
														
														<button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-primary w-50 mb-5">
															<span class="indicator-label">Login</span>

														</button>
														<!--end::Submit button-->
<br />
														<!--begin::Link-->
														<a href="'.ROOT.'/?action=forgotPassword" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
														<!--end::Link-->

													</div>
													<!--end::Actions-->
													<div></div></form>';
                                             }
                                             else
                                             {
                                                 //Show Dashboard Menu Here



                                             }


echo'
											</div>
											<!--end::Content-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Mixed Widget 16-->
								</div>
							</div>
							<!--end::Row-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Toolbar-->
					<!--begin::Container-->
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Row-->
							<div class="row gy-0 gx-10">
								<!--begin::Col-->
								<div class="col-xl-8">
									<!--begin::General Widget 1-->
									<div class="mb-10">
										<!--begin::Tabs-->
										<ul class="nav row mb-10">
											<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
												<a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px  active" data-bs-toggle="tab" href="#kt_general_widget_1_1">
													<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
													<span class="fas fa-video mb-5 mx-0" style="font-size:32px">

													</span>
													<!--end::Svg Icon-->
													<span class="fs-6 fw-bold">Latest
													<br />Videos</span>
												</a>
											</li>
											<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
												<a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_2">
													<!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
													<span class="fas fa-seedling mb-5 mx-0" style="font-size:32px">

													</span>
													<!--end::Svg Icon-->
													<span class="fs-6 fw-bold">Crop
													<br />Videos</span>
												</a>
											</li>
											<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
												<a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_3">
													<!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
													<span class="fas fa-paw mb-5 mx-0" style="font-size:32px">
													</span>
													<!--end::Svg Icon-->
													<span class="fs-6 fw-bold">Livestock
													<br />Videos</span>
												</a>
											</li>
											<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
												<a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_4">
													<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
													<span class="fas fa-fish mb-5 mx-0" style="font-size:32px">
													</span>
													<!--end::Svg Icon-->
													<span class="fs-6 fw-bold">Aquaculture
													<br />Videos</span>
												</a>
											</li>
											<li class="nav-item col-12 col-lg mb-5 mb-lg-0">
												<a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px" data-bs-toggle="tab" href="#kt_general_widget_1_5">
													<!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
													<span class="fas fa-otter mb-5 mx-0" style="font-size:32px">
													</span>
													<!--end::Svg Icon-->
													<span class="fs-6 fw-bold">Entomology
													<br />Videos</span>
												</a>
											</li>
										</ul>
										<!--begin::Tab content-->
										<div class="tab-content">
											<div class="tab-pane fade  show active" id="kt_general_widget_1_1">
												<!--begin::Tables Widget 2-->
												<div class="card">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bolder fs-3 mb-1">Latest Videos</span>
															<span class="text-muted mt-1 fw-bold fs-7">More than 100 new videos</span>
														</h3>
														<div class="card-toolbar">
															<!--begin::Menu-->
															<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
																<span class="fas fa-video">

																</span>
																<!--end::Svg Icon-->
															</button>
															
															<!--end::Menu-->
														</div>
													</div>
													<!--end::Header-->
													<!--begin::Body-->
													<div class="card-body py-3">
														
														
														<div class="row g-10">
														
														
														
														'.self::getLatestVideos().'
											
														
														
													</div>
													</div>
													<!--end::Body-->
												</div>
												<!--end::Tables Widget 2-->
											</div>
											<div class="tab-pane fade" id="kt_general_widget_1_2">
												<!--begin::Tables Widget 3-->
												<div class="card">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bolder fs-3 mb-1">Crop Videos</span>
															<span class="text-muted mt-1 fw-bold fs-7">Over 100 new videos</span>
														</h3>
														<div class="card-toolbar">
															<!--begin::Menu-->
															<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
																			<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																			<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																			<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																		</g>
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</button>
														
															<!--end::Menu-->
														</div>
													</div>
													<!--end::Header-->
													<!--begin::Body-->
													
													<div class="card-body py-3">
														
														
														<div class="row g-10">
														
														
														
														'.self::getLatestVideos().'
											
														
														
													</div>
													</div>
													
													
													<!--begin::Body-->
												</div>
												<!--end::Tables Widget 3-->
											</div>
											<div class="tab-pane fade" id="kt_general_widget_1_3">
												<!--begin::Tables Widget 5-->
												<div class="card">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bolder fs-3 mb-1">Livestock Videos</span>
															<span class="text-muted mt-1 fw-bold fs-7">More than 200 new videos</span>
														</h3>
														
													</div>
													<!--end::Header-->
													<div class="card-body py-3">
														
														
														<div class="row g-10">
														
														
														
														'.self::getLatestVideos().'
											
														
														
													</div>
													</div>
												</div>
												<!--end::Tables Widget 5-->
											</div>
											<div class="tab-pane fade" id="kt_general_widget_1_4">
												<!--begin::Tables Widget 4-->
												<div class="card">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bolder fs-3 mb-1">New Members</span>
															<span class="text-muted mt-1 fw-bold fs-7">More than 400 new members</span>
														</h3>
														
													</div>
													<!--end::Header-->
													<div class="card-body py-3">
														
														
														<div class="row g-10">
														
														
														
														'.self::getLatestVideos().'
											
														
														
													</div>
													</div>
												</div>
												<!--end::Tables Widget 4-->
											</div>
											<div class="tab-pane fade" id="kt_general_widget_1_5">
												<!--begin::Tables Widget 1-->
												<div class="card">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label fw-bolder fs-3 mb-1">Entomology Videos</span>
															<span class="text-muted fw-bold fs-7">Over 10 new videos</span>
														</h3>
														<div class="card-toolbar">
															<!--begin::Menu-->
															<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
																<span class="svg-icon svg-icon-2">
																	<svg xmlns="https://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
																			<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																			<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																			<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																		</g>
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</button>
															
															<!--end::Menu-->
														</div>
													</div>
													<!--end::Header-->
													<div class="card-body py-3">
														
														
														<div class="row g-10">
														
														
														
														'.self::getLatestVideos().'
											
														
														
													</div>
													</div>
												</div>
												<!--endW::Tables Widget 1-->
											</div>
										</div>
										<!--end::Tab content-->
									</div>
									<!--end::General Widget 1-->

								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-xl-4">
									<!--begin::List Widget 5-->
									<div class="card mb-10">
										<!--begin::Header-->
										<div class="card-header align-items-center border-0 mt-4">
											<h3 class="card-title align-items-start flex-column">
												<span class="fw-bolder mb-2 text-dark">Categories</span>

											</h3>

										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body pt-5">

											'.self::getAsideKMUMenu().'


										</div>
										<!--end: Card Body-->
									</div>
									<!--end: List Widget 5-->

								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Container-->


					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-bold me-1">2021©</span>
								<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Ministry of Agriculture, Animal Industry and Fisheries | Uganda</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Menu-->
							<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2">About</a>
								</li>
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2">Support</a>
								</li>

							</ul>
							<!--end::Menu-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Drawers-->




		<!--end::Drawers-->

		
		<!--end::Main-->
		<script>var hostUrl = "'.ROOT.'/includes/public_html/dist/assets/";</script>
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="'.ROOT.'/includes/public_html/dist/assets/plugins/global/plugins.bundle.js"></script>
		<script src="'.ROOT.'/includes/public_html/dist/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="'.ROOT.'/includes/public_html/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="'.ROOT.'/includes/public_html/dist/assets/js/custom/widgets.js"></script>
		<script src="'.ROOT.'/includes/public_html/dist/assets/js/custom/apps/chat/chat.js"></script>
		<script src="'.ROOT.'/includes/public_html/dist/assets/js/custom/modals/create-app.js"></script>
		<script src="'.ROOT.'/includes/public_html/dist/assets/js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>

        ';
    }


    public static function  checkIfAdminAccount(){

         switch($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 10:
            case 11:
            case 12:
            case 14:
            case 15:
            case 16:
            case 17:
            case 18:
            case 19:
            case 20:
            case 21:
            case 22:
            case 24:
             case 31:
             case 32:
             case 33:
             case 34:
             case 35:
             case 36:
             case 37:
             case 38:
             case 39:
             case 40:
             case 41:
             case 42:
             case 43:
             case 44:
             case 45:
             case 46:
             case 47:
             case 48:
             case 53:
             case 84:
               return true;
                break;


                default:
                    return false;
         }
   }


    public static function  checkIfSuperAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 10:
            case 84:
            case 12:
            case 55:
                 return true;
                break;


            default:
                return false;
        }
    }


    public static function  checkIfSystemAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 5:

                return true;
                break;

            default:
                return false;
        }
    }

    public static function  checkIfMAAIFAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {


            case 5:
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 31:
            case 32:
            case 33:
            case 34:
            case 35:
            case 36:
            case 37:
            case 38:
            case 39:
            case 40:
            case 41:
            case 42:
            case 43:
            case 44:
            case 45:
            case 46:
            case 47:
            case 48:

                return true;
                break;
                ;

            default:
                return false;
        }
    }

    public static function  checkIfDistrictAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 2:
            case 3:
            case 4:
            case 10:
            case 11:
            case 12:
            case 14:
            case 19:
            case 20:
            case 21:
            case 22:
            case 24:
            case 84:
                return true;
                break;


            default:
                return false;
        }
    }



    public static function  checkIfDistrictLeadershipAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {


            case 10:
            case 11:
            case 84:
            case 55:

                return true;
                break;


            default:
                return false;
        }
    }


    public static function  checkIfDistrictSubjectMatterSpecialistAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {


            case 2:
            case 3:
            case 4:
            case 12:
            case 56:
            case 57:
            case 58:
            case 59:

                return true;
                break;


            default:
                return false;
        }
    }

    public static function  checkIfSSubcountyAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 1:
            case 11:
            case 49:
            case 84:
                return true;
                break;


            default:
                return false;
        }

    }


    public static function  checkIfDistrictCropAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 2:
            case 19:
            case 22:
                return true;
                break;


            default:
                return false;
        }
    }

    public static function  checkIfDistrictVetAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 3:
            case 20:
                  return true;
                break;


            default:
                return false;
        }
    }

    public static function  checkIfDistrictFishAdminAccount(){

        switch($_SESSION['user']['user_category_id']) {

            case 4:
            case 21:
               return true;
                break;


            default:
                return false;
        }
    }


    public static function prepMenu(){
                $menu ='
                
                  <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark" href="'.ROOT.'" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Home </span></a>
                       
                        </li>
                     
                       
						 <li class="sidebar-item dropdown"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-database"></i><span class="hide-menu">E-Diary </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                            ';
        if(!self::checkIfMAAIFAdminAccount() && !self::checkIfSSubcountyAdminAccount()  && $_SESSION['user']['user_category_id'] !=5  && $_SESSION['user']['user_category_id'] !=53  && $_SESSION['user']['user_category_id'] !=84) {
            $menu .= '
                                 <li class="sidebar-item"><a href="' . ROOT . '?action=viewUserWorkplan&id=' . $_SESSION['user']['id'] . '" class="sidebar-link"><i class="fas fa-calendar"></i><span class="hide-menu"> My Annual Workplan </span></a></li>
                                 <li class="sidebar-item"><a href="' . ROOT . '?action=viewaQuaterlyActivities&user_id=' . $_SESSION['user']['id'] . '" class="sidebar-link"><i class="fas fa-calendar-plus"></i><span class="hide-menu">My Quarterly Activities </span></a></li>
                                 <li class="sidebar-item"><a href="' . ROOT . '?action=viewaDailyActivities&user_id=' . $_SESSION['user']['id'] . '" class="sidebar-link"><i class="fas fa-calendar"></i><span class="hide-menu">My Daily Activities  </span></a></li>
                                 <li class="sidebar-item"><a href="' . ROOT . '?action=viewaEvaluationReport&user_id=' . $_SESSION['user']['id'] . '" class="sidebar-link"><i class="fas fa-chart-area"></i><span class="hide-menu">My Evaluation </span></a></li>
                                  ';
                           }

        // If  subject matter specialists
                               if(self::checkIfDistrictSubjectMatterSpecialistAdminAccount() ){
                                $menu .='
                                <li class="sidebar-item"><a href="'.ROOT.'/?action=manageWorkplans" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Manage Annual Workplans</span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'/?action=manageQuarterlyActivitiesNew" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Manage Quarterly  Activities</span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'/?action=viewEvaluaton" class="sidebar-link"> <i class="fa fa-chart-line"></i>   <span class="hide-menu"> Manage Evaluation </span></a></li>
                            ';
                               }


         // If DPMO or CAO or MAAIF Account
        if($_SESSION['user']['user_category_id'] == 10 ||  $_SESSION['user']['user_category_id'] == 84 ||  $_SESSION['user']['user_category_id'] == 55){
            $menu .='
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageWorkplansButtons" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Manage Annual Workplans</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageQuarterlyActivitiesNewButtons" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Manage Quarterly  Activities</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=viewEvaluatonButtons" class="sidebar-link"> <i class="fa fa-chart-line"></i>   <span class="hide-menu"> Manage Evaluation </span></a></li>
                ';
        }



         // If CAO
        if( $_SESSION['user']['user_category_id'] == 11 || self::checkIfMAAIFAdminAccount()){
            $menu .='
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageWorkplansButtons" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">View Workplans</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageQuarterlyActivitiesNewButtons" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">View Quarterly  Activities</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=viewEvaluatonButtons" class="sidebar-link"> <i class="fa fa-chart-line"></i>   <span class="hide-menu"> View Evaluation </span></a></li>
                ';
        }


         // If Subcounty Chief
        if( $_SESSION['user']['user_category_id'] == 1 || $_SESSION['user']['user_category_id'] == 49){
            $menu .='
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageWorkplans" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">View Workplans</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageQuarterlyActivitiesNew" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">View Quarterly  Activities</span></a></li>
                    <li class="sidebar-item"><a href="'.ROOT.'/?action=viewEvaluaton" class="sidebar-link"> <i class="fa fa-chart-line"></i>   <span class="hide-menu"> View Evaluation </span></a></li>
                ';
        }





                 $menu .='</ul>
                        </li>
                        
                        
                       <li class="sidebar-item dropdown"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-user-md"></i><span class="hide-menu">GRM </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=viewaGRMGrievance" class="sidebar-link"><i class="fas fa-user-circle"></i><span class="hide-menu">Manage Grievances  </span></a></li>
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=manageMeetings" class="sidebar-link"><i class="fas fa-users"></i><span class="hide-menu">Manage Meetings </span></a></li>
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=viewaGRMReport" class="sidebar-link"><i class="fas fa-users"></i><span class="hide-menu">Grievance Report </span></a></li>
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=prepGRMReport" class="sidebar-link"><i class="fas fa-newspaper"></i><span class="hide-menu">Prep Grievance Report </span></a></li>
                               
                  
                                 </ul>
                        </li>
                        
                         <li class="sidebar-item dropdown"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-map-marker"></i><span class="hide-menu">Profiling </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="'.ROOT.'?action=areaProfile" class="sidebar-link"><i class="fas fa-map-pin"></i><span class="hide-menu"> Area Profile</span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=popularCommodities" class="sidebar-link"><i class="fab fa-pagelines"></i><span class="hide-menu">Popular Commodities</span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=potenialCommodities" class="sidebar-link"><i class="fas fa-leaf"></i><span class="hide-menu">Potential Commodities </span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=viewFarmers" class="sidebar-link"><i class="fas fa-user-plus"></i><span class="hide-menu">Farmers </span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=viewFarmerGroups" class="sidebar-link"><i class="fas fa-group"></i><span class="hide-menu">Farmer Groups </span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=#" class="sidebar-link"><i class="fas fa-building"></i><span class="hide-menu">State Actors </span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=#" class="sidebar-link"><i class="fas fa-building"></i><span class="hide-menu">Non State Actors </span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'?action=#" class="sidebar-link"><i class="fas fa-user-md"></i><span class="hide-menu">Parish Chiefs</span></a></li>
                  
                                 </ul>
                        </li>
                        
                        
                    
                        
					
                         <li class="sidebar-item dropdown"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-user-md"></i><span class="hide-menu">Advisory </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=viewQuestions" class="sidebar-link"><i class="fas fa-user-circle"></i><span class="hide-menu">View Farmer Questions  </span></a></li>
                                 <li class="sidebar-item"><a href="'.ROOT.'?action=viewAlerts" class="sidebar-link"><i class="fas fa-users"></i><span class="hide-menu">Send Advisory </span></a></li>
                               
                  
                                 </ul>
                        </li>
                        
                        
                        
                         <li class="sidebar-item dropdown"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-map-marker"></i><span class="hide-menu">Reports </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                               ';

        if(!self::checkIfMAAIFAdminAccount() && !self::checkIfSSubcountyAdminAccount()) {
            $menu .= '   <li class="sidebar-item"><a href="' . ROOT . '?action=viewEOReport&id=' . $_SESSION['user']['id'] . '" class="sidebar-link"><i class="fas fa-address-book"></i><span class="hide-menu">My Report</span></a></li>
                                 ';
        }


        //Populate reports for subject matter specialists
        if($_SESSION['user']['user_category_id'] == 2){
            $menu .='  <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=1" class="sidebar-link"><i class="mdi mdi-leaf"></i><span class="hide-menu">District Crop Report</span></a></li>
                                      ';
        }
        elseif ($_SESSION['user']['user_category_id'] == 3)
        {
            $menu .=' <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=2" class="sidebar-link"><i class="mdi mdi-cow"></i><span class="hide-menu">District Livestock Report</span></a></li>
                                       ';
        }
        elseif ($_SESSION['user']['user_category_id'] == 4)
        {
            $menu .='<li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=3" class="sidebar-link"><i class="mdi mdi-fish"></i><span class="hide-menu">District Fish Report</span></a></li>
                                      ';
        }
        elseif ($_SESSION['user']['user_category_id'] == 12)
        {
            $menu .=' <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=4" class="sidebar-link"><i class="mdi mdi-bug"></i><span class="hide-menu"> District Entomology Report</span></a></li>
                                  ';
        }


        //DPMO manage Budgets & District Reports
        if(self::checkIfDistrictLeadershipAdminAccount()){
            $menu .='

<li class="sidebar-item"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-collage"></i><span class="hide-menu">District Sector Reports</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                       <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=1" class="sidebar-link"><i class="mdi mdi-leaf"></i><span class="hide-menu">District Crop Report</span></a></li>
                                      <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=2" class="sidebar-link"><i class="mdi mdi-cow"></i><span class="hide-menu">District Livestock Report</span></a></li>
                         <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=3" class="sidebar-link"><i class="mdi mdi-fish"></i><span class="hide-menu">District Fish Report</span></a></li>
                         <li class="sidebar-item"><a href="'.ROOT.'/?action=viewManageDistrictSectorReport&district_id='.$_SESSION['user']['district_id'].'&sector=4" class="sidebar-link"><i class="mdi mdi-bug"></i><span class="hide-menu"> District Entomology Report</span></a></li>
                               
                                          
                                          </ul>
                                </li>
 <li class="sidebar-item"><a href="'.ROOT.'/?action=viewEODistrictReport&id='.$_SESSION['user']['district_id'].'" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Generate District Report</span></a></li>
  <li class="sidebar-item"><a href="'.ROOT.'/?action=manageBudgets&district_id='.$_SESSION['user']['district_id'].'" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Manage District Budgets</span></a></li>                                
         
         
      
         
                               ';
        }

if(self::checkIfMAAIFAdminAccount()){
$menu .='                    <li class="sidebar-item"><a href="'.ROOT.'/?action=manageDistrictReportingButtons" class="sidebar-link"><i class="fa fa-user-md"></i>  <span class="hide-menu">Generate District Report</span></a></li>
                                <li class="sidebar-item"><a href="'.ROOT.'/?action=manageZonalReportingButtons" class="sidebar-link"> <i class="fa fa-chart-line"></i>   <span class="hide-menu"> Generate Zonal Report </span></a></li>
                            ';
}




    $menu .='                     
                               
                                 </ul>
                        </li>
                        
                        ';

//MAAIF admins to add KMU content
if(self::checkIfMAAIFAdminAccount())
{
$menu .= '<li class="sidebar-item dropdown"> <a class="sidebar-link waves-effect waves-dark" href="'.ROOT.'?action=manageOutbreaksCrises" aria-expanded="false"><i class="fas fa-bug"></i><span class="hide-menu">Outbreaks </span></a>
             </li>
<li class="sidebar-item dropdown"> <a class="sidebar-link waves-effect waves-dark" href="'.ROOT.'?action=manageKMU" aria-expanded="false"><i class="fas fa-video"></i><span class="hide-menu">KMU </span></a>
             </li>
             
             ';

}
//MAAIF Datamanager/System Admin
if($_SESSION['user']['user_category_id'] == 54 || $_SESSION['user']['user_category_id'] == 5)
{
    $menu .='


   
         <li class="sidebar-item"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-border-none"></i><span class="hide-menu">Seed Data</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                               <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageEntreprizes" class="sidebar-link"><i class="fa fa-leaf"></i>  <span class="hide-menu">Entreprizes and Approaches</span></a></li>                                
                               <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageActivities" class="sidebar-link"><i class="fa fa-check-circle"></i>  <span class="hide-menu">Manage Activities</span></a></li>                                
                               <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageTopics" class="sidebar-link"><i class="fa fa-paperclip"></i>  <span class="hide-menu">Manage Topics</span></a></li>
                               <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageFAQs" class="sidebar-link"><i class="fa fa-question-circle"></i>  <span class="hide-menu">Manage FAQs</span></a></li>
                               <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageDistrictBudget" class="sidebar-link"><i class="fa fa-dollar-sign"></i>  <span class="hide-menu">Manage District Budgets</span></a></li>
                               <li class="sidebar-item"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-map-marker"></i><span class="hide-menu">Manage Location Data</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                       <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageDistrict" class="sidebar-link"><i class="mdi mdi-map-marker"></i><span class="hide-menu">Districts/Cities</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageCounty" class="sidebar-link"><i class="mdi mdi-map-marker"></i><span class="hide-menu">Counties/Municipalities</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageSubcounty" class="sidebar-link"><i class="mdi mdi-map-marker"></i><span class="hide-menu">Subcounties/Towns</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageParishesAll" class="sidebar-link"><i class="mdi mdi-map-marker"></i><span class="hide-menu"> Parishes/Wards</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageParishesAll" class="sidebar-link"><i class="mdi mdi-map-marker"></i><span class="hide-menu"> Villages/Zones</span></a></li>
                                      </ul>
                                </li>
                                <li class="sidebar-item"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Manage User Data</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                      <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageUserAssociations" class="sidebar-link"><i class="fa fa-cogs"></i>  <span class="hide-menu">User Associations</span></a></li>                                
                                      <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageUserTransfers" class="sidebar-link"><i class="fa fa-users"></i>  <span class="hide-menu">User Transfers</span></a></li>                                
                                      <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageUserAnnualDeadLines" class="sidebar-link"><i class="fa fa-times"></i>  <span class="hide-menu">Annual Workplan Deadlines</span></a></li>   
                                      <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageUserAnnualDeadLines" class="sidebar-link"><i class="fa fa-calendar"></i>  <span class="hide-menu">Quarterly Workplan Deadlines</span></a></li>     </ul>
                                    </li>                             
                               <li class="sidebar-item"> <a class="sidebar-link  waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Manage GRM Data</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                       <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageGRMNature" class="sidebar-link"><i class="fa fa-building"></i><span class="hide-menu">GRM Nature</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageGRMTypes" class="sidebar-link"><i class="fa fa-building"></i><span class="hide-menu">GRM Types</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageGRMSettlement" class="sidebar-link"><i class="fa fa-building"></i><span class="hide-menu">GRM Settlement</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageGRMFeedbackModes" class="sidebar-link"><i class="fa fa-building"></i><span class="hide-menu"> GRM Feedback Modes</span></a></li>
                                        <li class="sidebar-item"><a href="'.ROOT.'/?action=dmManageGRMModeofReceipt" class="sidebar-link"><i class="fa fa-building"></i><span class="hide-menu"> GRM Mode of Receipt</span></a></li>
                                      </ul>
                                </li>
                             </ul>
            </li>
         
       
         
                               ';
}

     $menu .='<li class="sidebar-item "> <a class="sidebar-link waves-effect waves-dark" href="'.ROOT.'/?action=logout" aria-expanded="false"><i class="fas fa-lock-open"></i><span class="hide-menu">Logout</span></a>
                           
                        </li>
                
                ';


        return $menu;

}

public static function prepYTURL($url){

        return str_replace('watch?v=','embed/',$url);
}

public static function getLatestVideos(){

        $sql = database::performQuery("SELECT * FROM kmu ORDER BY RAND() LIMIT 4");
        $content = '';
        while($data=$sql->fetch_assoc()){

            $url = self::prepYTURL($data['video']);

            $content .='
                        <div class="col-md-6 col-lg-6">
                            <article class="post post-medium border-0 pb-0 mb-5">
                                <div class="post-image">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="'.$url.'" title="'.$data['title'].'" allowfullscreen="" width="640" height="360"></iframe>
                                    </div>
                                </div>

                                <div class="post-content">

                                    <h2 class="font-weight-semibold text-4 line-height-6 mt-3 mb-2"><a href="#">'.$data['title'].'</a></h2>
                                    <p>'.substr($data['description'],0,200).'</p>

                                    <div class="post-meta">
                                        <span><i class="far fa-user"></i> By <a href="#">'.$data['produced_by'].'</a> </span>
                                        <span><i class="far fa-clock"></i> <a href="#">'.date("Y-m-d",strtotime($data['created'])).'</a></span>
                                    </div>

                                </div>
                            </article>
                        </div>';

        }
        return $content;
}




    public static function getLatestVideosByCategory($parent_id){

        $sql = database::performQuery("SELECT * FROM kmu ORDER BY RAND() LIMIT 2");
        $content = '';
        while($data=$sql->fetch_assoc()){

            $url = self::prepYTURL($data['video']);


            $content .='<!--begin::Col-->
											<div class="col-md-6">
												<!--begin::Feature post-->
												<div class="card-xl-stretch me-md-6">
													<!--begin::Image-->
													
													
													<iframe width="330" height="175" src="'.$url.'" title="'.$data['title'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
													
													<!--end::Image-->
													<!--begin::Body-->
													<div class="m-0">
														<!--begin::Title-->
														<a href="#" class="fs-4 text-dark fw-bolder text-hover-primary text-dark lh-base">'.$data['title'].'</a>
														<!--end::Title-->
														<!--begin::Text-->
														<div class="fw-bold fs-5 text-gray-600 text-dark my-4">'.$data['description'].'</div>
														<!--end::Text-->
														<!--begin::Content-->
														<div class="fs-6 fw-bolder">
															<!--begin::Author-->
															<a href="#" class="text-gray-700 text-hover-primary">'.$data['produced_by'].'</a>
															<!--end::Author-->
															<!--begin::Date-->
															<span class="text-muted">on '.date("Y-m-d",strtotime($data['created'])).'</span>
															<!--end::Date-->
														</div>
														<!--end::Content-->
													</div>
													<!--end::Body-->
												</div>
												<!--end::Feature post-->
											</div>
											<!--end::Col-->';

        }
        return $content;
    }

}


?>
