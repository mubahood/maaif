<?php

/**
 * Created by PhpStorm.
 * User: Herbert
 * Date: 24/11/2016
 * Time: 19:17
 */
class js
{
  public static function prepJs(){
   $content ='
  <script type="text/javascript"> 
//Count Schools in District
function countSchoolDistrict(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: "'.ROOT.'/?action=mapsDistrict",
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert("Error occured");
        }
    });
    //line added to return ajax response
    return result;
}



//Count outbreaks in District
function countAllDistrictOutbreaks(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: "'.ROOT.'/?action=countAllDistrictOutbreaks",
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert("Error occured");
        }
    });
    //line added to return ajax response
    return result;
}


function countSchoolDistrictProduce(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: "'.ROOT.'/?action=mapsDistrictProduce",
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert("Error occured");
        }
    });
    //line added to return ajax response
    return result;
}

function regionMajor(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: "'.ROOT.'/?action=mapsRegionColor",
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert("Error occured");
        }
    });
    //line added to return ajax response
    return result;
}

function regionMajorFill(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: "'.ROOT.'/?action=mapsRegionColorFill",
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert("Error occured");
        }
    });
    //line added to return ajax response
    return result;
}



function subRegionColor(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=mapsSubRegionColor\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}



function subRegionColorFill(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=mapsSubRegionColorFill\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}


function districtSchoolDetails(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=districtSchoolDetails\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}


function districtOubreaksDetails(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=districtOubreaksDetails\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}



function districtSchoolDetailsGender(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=districtSchoolDetailsGender\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}



function districtProduceDetails(id) {
    //line added for the var that will have the result
    var result = false;
    $.ajax({
        type: "POST",
        url: \''.ROOT.'/?action=districtProduceDetails\',
        data: ({ id: id }),
        dataType: "html",
        //line added to get ajax response in sync
        async: false,
        success: function(data) {
            //line added to save ajax response in var result
            result = data;
        },
        error: function() {
            alert(\'Error occured\');
        }
    });
    //line added to return ajax response
    return result;
}



	</script>  
   
   ';

      return $content;
  }


  public static function prepAddUserJS($id){

    $content = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
    
        $(document).ready(function(){
            // Should be a query to get district level categories
            var district_categories = [2,3,4,10,11,12,14,24,55,56,57,58,59,61,62,63,64];
            
            var municipal_head = [60];
            
            var parish_head = [49,66];

            var maaif_user_categories = [5,6,15,16,17,18,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,52,53,54];

            $("[name=\'user_cat\']").on("change", function() {
                    category = parseInt($(this).val());
          

                    
                    
                    if(jQuery.inArray(category, maaif_user_categories) !== -1){
                       
                        $(\'#maaif_department\').show();
                        $(\'#maaif_directorate\').show();
                        $(\'#maaif_division\').show();
                        $(\'#select_area_subcounty\').hide();
                        $(\'#municipality_box\').hide();
                        $(\'input[name="municipality_id"]\')[0].selectedIndex = 0;
                        $(\'#parish_box\').hide();
                        $(\'input[name="parish_id"]\')[0].selectedIndex = 0;
                        $(\'input[name="location_id"]\')[0].selectedIndex = 0;
                    }
                    
                    else 
                        if(jQuery.inArray(category, municipal_head) !== -1){
                       
                        $(\'#municipality_box\').show();
                        $(\'#parish_box\').hide();
                         $(\'input[name="parish_id"]\')[0].selectedIndex = 0;
                        $(\'#select_area_subcounty\').hide();
                        $(\'input[name="location_id"]\')[0].selectedIndex = 0;
                        $(\'#maaif_department\').hide();
                        $(\'#select_department\')[0].selectedIndex = 0;;
                        $(\'#maaif_directorate\').hide();
                        $(\'#select_directorate\')[0].selectedIndex = 0;
                        $(\'#maaif_division\').hide();
                        $(\'#select_division\')[0].selectedIndex = 0;
                    }
                    
                     else 
                        if(jQuery.inArray(category, parish_head) !== -1){
                       
                        $(\'#parish_box\').show();
                        $(\'#select_area_subcounty\').show();
                        $(\'input[name="location_id"]\')[0].selectedIndex = 0
                        $(\'#maaif_department\').hide();
                        $(\'#select_department\')[0].selectedIndex = 0;;
                        $(\'#maaif_directorate\').hide();
                        $(\'#select_directorate\')[0].selectedIndex = 0;
                        $(\'#maaif_division\').hide();
                        $(\'#select_division\')[0].selectedIndex = 0;
                    }
                    
                    
                    else{
  
                        if(jQuery.inArray(category, district_categories) !== -1){
                            $(\'#maaif_department\').hide();
                            $(\'#select_department\')[0].selectedIndex = 0;;
                            $(\'#maaif_directorate\').hide();
                            $(\'#select_directorate\')[0].selectedIndex = 0;
                            $(\'#maaif_division\').hide();
                            $(\'#select_division\')[0].selectedIndex = 0;
                            $(\'#select_area_subcounty\').hide();
                            $(\'input[name="location_id"]\')[0].selectedIndex = 0;
                            $(\'#municipality_box\').hide();
                             $(\'input[name="municipality_id"]\')[0].selectedIndex = 0;
                            $(\'#parish_box\').hide();
                             $(\'input[name="parish_id"]\')[0].selectedIndex = 0;
                        }
                        else{
                            $(\'#maaif_department\').hide();
                            $(\'#select_department\')[0].selectedIndex = 0;;
                            $(\'#maaif_directorate\').hide();
                            $(\'#select_directorate\')[0].selectedIndex = 0;
                            $(\'#maaif_division\').hide();
                            $(\'#select_division\')[0].selectedIndex = 0;
                            $(\'#select_area_subcounty\').show();
                            $(\'#municipality_box\').hide();
                             $(\'input[name="municipality_id"]\')[0].selectedIndex = 0;
                            $(\'#parish_box\').hide();
                             $(\'input[name="parish_id"]\')[0].selectedIndex = 0;
                        }
                    }
            });


            $("#select_directorate").change(function(){
                var id = $(this).val();
        
                        $.ajax({
                            url: \''.ROOT.'/?action=getDepartmentsByDirectorate\',
                            type: \'post\',
                            data: {id},
                            dataType: \'json\',
                            success:function(response){
                                console.log(response);
                
                                var len = response.length;
                                $("#select_department").empty();
        
                                for( var i = 0; i<len; i++){
                                    var id = response[i][\'id\'];
                                    var name = response[i][\'name\'];
                                    
                                    $("#select_department").append("<option value=\'"+id+"\'>"+name+"</option>");
                
                                }
                            }
                        });
                    });

                    $("#select_department").change(function(){
                        var id = $(this).val();
                
                                $.ajax({
                                    url: \''.ROOT.'/?action=getDivisionsByDepartment\',
                                    type: \'post\',
                                    data: {id},
                                    dataType: \'json\',
                                    success:function(response){
                                        console.log(response);
                        
                                        var len = response.length;
                                        $("#select_division").empty();
                
                                        for( var i = 0; i<len; i++){
                                            var id = response[i][\'id\'];
                                            var name = response[i][\'name\'];
                                            
                                            $("#select_division").append("<option value=\'"+id+"\'>"+name+"</option>");
                        
                                        }
                                    }
                                });
                            });

                    $("#select_district").change(function(){
                        var id = $(this).val(); 
                        console.log(id);  
                        $.ajax({
                            url: \''.ROOT.'/?action=adminGetSubCountiesByDistrict\',
                            method: \'POST\',
                            data: {"id":id},
                            success:function(response){
                                console.log(response);
                                data = JSON.parse(response);
                                
                                $("#select_subcounty").empty();
                              
                                $.each(data, function (key, entry) {
                                    console.log(entry);
                                    $("#select_subcounty").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                });
                            },
                            error:function(response){
                                console.log(response);
                            }
                        });
                    });
                    
                    $("#select_subcounty").change(function(){
                        var id = $(this).val(); 
                        console.log(id);  
                        $.ajax({
                            url: \''.ROOT.'/?action=adminGetParishesBySubcounty\',
                            method: \'POST\',
                            data: {"id":id},
                            success:function(response){
                                console.log(response);
                                data = JSON.parse(response);
                                
                                $("#select_parish").empty();
                              
                                $.each(data, function (key, entry) {
                                    console.log(entry);
                                    $("#select_parish").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                });
                            },
                            error:function(response){
                                console.log(response);
                            }
                        });
                    });

                    $("#add-user-form").validate({
                        rules:{
                            firstname:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },

                            lastname:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },

                            username:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },
                            email:{
                                required: true,
                                email:true
                            },

                            password:{
                                required: true,
                                minlength: 3
                            },
                            phone:{
                                required: true,
                            },
                            user_cat:{
                                required: true
                            }
                        },

                        messages: {
                            firstname:{
                                required: "Please provide a first name"
                                
                            },
                            lastname:{
                                required: "Please provide a last name"
                            },

                            username:{
                                required: "Please provide a username"
                            },
                            email:{
                                required: "Please provide an email address",
                                email: "Please provide a valid email address"
                            },
                            password:{
                                required: "Please provide a password"
                            },
                            phone:{
                                required: "Please provide a phone number"
                            },

                            user_cat:{
                                required: "Please provide a user category"
                            }

                        },

                        errorElement: \'span\',
                        errorPlacement: function (error, element) {
                        error.addClass(\'invalid-feedback\');
                        element.closest(\'.form-group\').append(error);
                        },

                        // Called when the element is invalid:
                        highlight: function (element, errorClass, validClass) {
                            $(element).addClass(\'is-invalid\');
                        },
            
                        // Called when the element is valid:
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).removeClass(\'is-invalid\');
                        },

                        submitHandler: function(form) {

                            var formData = new FormData(form);
              
                            $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit

                            $.ajax({
                                url: \''.ROOT.'/?action=processNewUser\',
                                type: \'post\',
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend:function(){
                                    $(\'#confirmButton\').text(\'Processing...\');
                                },

                                success: function(response) {
                                    $("#Success").empty();
                                    $(\'#confirmButton\').text(\'Add New\');
                                    console.log(response);
                 
                                    $("#Validation-Div").hide();
                                    
					
                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Success-Div").show(); // Unhide the div
                  
                                    $("#Success").append(\'<li>\' + "User created successfully" + \'</li>\');
                                    $("#add-user-form")[0].reset(); // Reset Form
                
                                    $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);
                 
                                }
                            });
                        }
                                

                    });


                    $("#edit-user-form").validate({
                        rules:{
                            firstname:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },

                            lastname:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },

                            username:{
                                required: true,
                                maxlength: 35,
                                minlength: 3
                            },
                            email:{
                                required: true,
                                email:true
                            },

                            password:{
                                required: true,
                            },
                            phone:{
                                required: true,
                            },
                            user_cat:{
                                required: true
                            }
                        },

                        messages: {
                            firstname:{
                                required: "Please provide a first name"
                                
                            },
                            lastname:{
                                required: "Please provide a last name"
                            },

                            username:{
                                required: "Please provide a username"
                            },
                            email:{
                                required: "Please provide an email address",
                                email: "Please provide a valid email address"
                            },
                            password:{
                                required: "Please provide a password"
                            },
                            phone:{
                                required: "Please provide a phone number"
                            },

                            user_cat:{
                                required: "Please provide a user category"
                            }

                        },

                        errorElement: \'span\',
                        errorPlacement: function (error, element) {
                        error.addClass(\'invalid-feedback\');
                        element.closest(\'.form-group\').append(error);
                        },

                        // Called when the element is invalid:
                        highlight: function (element, errorClass, validClass) {
                            $(element).addClass(\'is-invalid\');
                        },
            
                        // Called when the element is valid:
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).removeClass(\'is-invalid\');
                        },

                        submitHandler: function(form) {

                            var formData = new FormData(form);
              
                            $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit

                            $.ajax({
                                url: \''.ROOT.'/?action=processEditUserDetails\',
                                type: \'post\',
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend:function(){
                                    $(\'#confirmButton\').text(\'Processing...\');
                                },

                                success: function(response) {
                                    console.log(response);
                                    $("#Success").empty();
                                    $(\'#confirmButton\').text(\'Submit Changes\');
                                    
                 
                                    $("#Validation-Div").hide();
                                    
					
                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Success-Div").show(); // Unhide the div
                  
                                    $("#Success").append(\'<li>\' + "User updated successfully" + \'</li>\');
                
                                    $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);

                                    location.reload();
                 
                                }
                            });
                        }
                                

                    });

                    $(document).on("submit","#send-user-login-form",function(event){
                        event.preventDefault();
                        $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit
                        var formData = {
                            user_id: $("#login_user_id").val(),
                        
                          };
                            $.ajax({
                                url: \''.ROOT.'/?action=sendUserLogin\',
                                type: \'post\',
                                data: formData,
                                dataType:"json",
                                beforeSend:function(){
                                    $(\'#Send-Logins\').text(\'Processing...\');
                                },

                                success: function(response) {
                                    console.log(response);
                                    $("#Success").empty();
                                    $(\'#Send-Logins\').text(\'Send Logins\');
                                    
                 
                                    $("#Validation-Div").hide();
                                    
					
                                    window.scrollTo(0,0) // Scroll to the top to display error message
                                    $("#Success-Div").show(); // Unhide the div
                  
                                    $("#Success").append(\'<li>\' + "Login Details sent suceesfully" + \'</li>\');
                
                                    $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);

                                    location.reload();
                 
                                }
                            });


                    });
        });

    </script>
    ';
    return $content;
  }
}