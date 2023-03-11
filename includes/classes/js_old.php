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
}