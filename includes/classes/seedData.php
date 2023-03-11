<?php

class seedData
{


    // Start Manage Districts/Cities
    public static function manageDistricts(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewDistrict">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New District</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>District/City Name</th>
                                                <th>District/City Status</th>
                                                <th>Land Type</th>
                                                <th>Zone/ZARDI</th>
                                                <th>Sub-Region</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllDistrictData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>District/City Name</th>
                                                <th>District/City Status</th>
                                                <th>Land Type</th>
                                                <th>Zone/ZARDI</th>
                                                <th>Sub-Region</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllDistrictData(){



        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){

                if($data['district_status'] == 1)
                    $status = 'District';
                else
                    $status = 'City';

                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                <td>'.$status.'</td>
                                                <td>'.self::getLandTypeByID($data['land_type_id']).'</td>
                                                <td>'.self::getZoneByID($data['zone_id']).'</td>
                                                <td>'.self::getSubRegionByID($data['subregion_id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editDistrict&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this District/City?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteDistrict&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getLandTypeByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM land_type WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function getZoneByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM zone WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function getSubRegionByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM sub_region WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function addNewDistrict(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New District/City</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="District/City name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Status</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="status" required>
                                                            <option selected="">Select Option</option>
                                                            <option value="1">This is a District</option>
                                                            <option value="0">This is a City</option>                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Zone</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="zone" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllZonesList().'                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Land Type</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="land_type" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllLandTypesList().'                                         
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Sub-Region</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="sub_region" required>
                                                            <option selected="">Select Option</option>
                                                          '.self::getAllSubRegionsList().'                                       
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewDistrict"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New District</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function editDistrict($id){

        $sql = database::performQuery("SELECT * FROM district WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit District/City</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Status</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="status" required>
                                                            <option selected="">Select Option</option>
                                                            '.self::getAllLDistrictCitySelected($data['district_status']).'                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Zone</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="zone" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllZonesListSelected($data['zone_id']).'                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Land Type</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="land_type" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllLandTypesListSelected($data['land_type_id']).'                                         
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Sub-Region</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="sub_region" required>
                                                            <option selected="">Select Option</option>
                                                          '.self::getAllSubRegionsListSelected($data['subregion_id']).'                                       
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditDistrict"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit District/City</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


         }

        return $content;
    }

    public static function getAllSubRegionsList(){
        $sql = database::performQuery("SELECT * FROM sub_region ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllSubRegionsListSelected($id){
        $sql = database::performQuery("SELECT * FROM sub_region ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllLandTypesList(){
        $sql = database::performQuery("SELECT * FROM land_type ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllLandTypesListSelected($id){
        $sql = database::performQuery("SELECT * FROM land_type ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllZonesList(){
        $sql = database::performQuery("SELECT * FROM zone ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllZonesListSelected($id){
        $sql = database::performQuery("SELECT * FROM zone ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
            $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllLDistrictCitySelected($id){
        $content = "";

            if($id == 1){
            $content .= "<option value='1' SELECTED>This is a District</option>
                             <option value='0'>This is a City</option>";
             }
            else{
                $content .= "<option value='1'>This is a District</option>
                             <option value='0' SELECTED>This is a City</option>";
            }

        return $content;
    }

    public static function processNewDistrict(){

        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);



        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `district`( `name`, `district_status`,  `subregion_id`,  `zone_id`, `land_type_id`, `user_id`)
                                                       VALUES('$name','$status','$sub_region','$zone','$land_type',$user_id)");

        if($sql)
          redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processEditDistrict(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);


        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `district` SET `name`='$name', `district_status`='$status', `subregion_id`='$sub_region',  `zone_id`='$zone', `land_type_id`='$land_type', `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processDeleteDistrict(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!
         $sql = database::performQuery("DELETE FROM `district` WHERE id=$id ");
           if($sql)
        */
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }


    //End Manage Districts/Cities




    //Start Manage Counties

    public static function manageCounties(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewCounty">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New County/Municipality</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF_ID</th>                                                
                                                <th>County/Municipality Name</th>
                                                <th>County/Municipality Status</th>
                                                <th>District/City Attached</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllCountyData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>County/Municipality Name</th>
                                                <th>County/Municipality Status</th>
                                                <th>District/City Attached</th>                                                
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllCountyData(){



        $sql = database::performQuery("SELECT * FROM county ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){

                if($data['municipality'] == 1)
                    $status = 'Municipality';
                else
                    $status = 'County';

                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                <td>'.$status.'</td>
                                                <td>'.self::getDistrictByID($data['district_id']).'</td>
                                                 <td><a href="' . ROOT . '/?action=editCounty&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myCounty'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myCounty'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this County/Municipality?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteCounty&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                   
                    </tr>';
        }

        return $rt;
    }

    public static function getDistrictByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM district WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function addNewCounty(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New County/Municipality</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="County/Municipality name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">County/Municipality Status</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="status" required>
                                                            <option value="1">This is a Municipality</option>
                                                            <option value="0" SELECTED>This is a County</option>                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select style="width:70%"  class="custom-select mr-sm-2 select2  select2-search form-select-lg select2-search--dropdown" name="district_id" required>
                                                             '.self::getAllDistrictsList().'                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                           
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewCounty"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New County/Municipality</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function editCounty($id){

        $sql = database::performQuery("SELECT * FROM county WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit County/Municipality</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">County/Municipality Status</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="status" required>
                                                            <option selected="">Select Option</option>
                                                            '.self::getAllMunicipalitySelected($data['municipality']).'                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                           
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="district_id" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllDistrictsListSelected($data['district_id']).'                                         
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditCounty"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit County/Municipality</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function getAllDistrictsList(){
        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllDistrictsListSelected($id){
        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllMunicipalitySelected($id){
        $content = "";

        if($id == 1){
            $content .= "<option value='1' SELECTED>This is a Municipality</option>
                             <option value='0'>This is a County</option>";
        }
        else{
            $content .= "<option value='1'>This is a Municipality</option>
                             <option value='0' SELECTED>This is a County</option>";
        }

        return $content;
    }

    public static function processNewCounty(){

        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $district_id = database::prepData($_REQUEST['district_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `county`( `name`, `district_id`, `municipality`, `user_id`,  `changed`) 
                                                       VALUES('$name','$district_id','$status','$user_id',1)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageCounty');

    }

    public static function processEditCounty(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $district_id = database::prepData($_REQUEST['district_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `county` SET `name`='$name', `municipality`='$status', `district_id`='$district_id',  `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageCounty');

    }

    public static function processDeleteCounty(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!*/
         $sql = database::performQuery("DELETE FROM `county` WHERE id=$id ");
           if($sql)

        redirect_to(ROOT.'/?action=dmManageCounty');

    }




    //End Manage Counties

    public static function manageSubcounties(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewSubcounty">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Subcounties/Town Councils</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF_ID</th>                                                
                                                <th>Subcounty/Town Council Name</th>
                                                 <th>District/City Attached</th>
                                                 <th>County/Municipality Attached</th>
                                                 <th>No. Parishes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllSubcountyData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Subcounty/Town Council Name</th>
                                                 <th>District/City Attached</th>
                                                 <th>County/Municipality Attached</th>
                                                 <th>No. Parishes</th>                                          
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getDistrictIdByCountyID($id){
        $sql = database::performQuery("SELECT district_id FROM county WHERE county.id=$id");
        return $sql->fetch_assoc()['district_id'];
    }

    public static function getAllSubcountyData(){



        $sql = database::performQuery("SELECT * FROM subcounty ORDER BY county_id,name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){

                         $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                <td>'.self::getDistrictCountyByID($data['county_id']).'</td>
                                                <td>'.self::getCountyByID($data['county_id']).'</td>
                                                <td>'.self::getSubcountyParishCount($data['id']).'</td>
                                                <td>
                                                  <a href="' . ROOT . '/?action=editSubcounty&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#mySubCounty'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="mySubCounty'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Subcounty/Town Council?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteSubcounty&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                   
                   
                    </tr>';
        }

        return $rt;
    }

    public static function getCountyByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM county WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function getDistrictCountyByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT district.name FROM district,county WHERE district.id = county.district_id AND county.id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function getSubcountyParishCount($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id");
        return $sql->num_rows;

    }

    public static function addNewSubcounty(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Subcounty/Town Council</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Subcounty Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Subcounty / Town Council name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                                      
                                              <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select style="width:70%"  class="custom-select mr-sm-2 select2  select2-search form-select-lg select2-search--dropdown" name="district_id"  id="sel_district" required>
                                                             '.self::getAllDistrictsList().'                                          
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>         
                                                                                        
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">County/Municipality Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select style="width:70%"  class="custom-select mr-sm-2 select2  select2-search form-select-lg select2-search--dropdown" name="county_id" id="sel_county" required>
                                                                                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                           
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewSubcounty"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Subcounty/Town Council</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function editSubcounty($id){

        $sql = database::performQuery("SELECT district_id,county_id,subcounty.id, subcounty.name as subcounty, subcounty.id as id FROM county,subcounty WHERE subcounty.id=$id AND county.id = subcounty.county_id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Subcounty/Town Council</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['subcounty'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">District/City Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="status" id="sel_district" required>
                                                            <option selected="">Select Option</option>
                                                            '.self::getAllDistrictsListSelected($data['district_id']).'                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                           
                                            
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">County/Municipality Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="county_id"  id="sel_county" required>
                                                         <option selected="">Select Option</option>
                                                             '.self::getAllCountiesListSelected($data['county_id']).'                                         
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                            
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditSubcounty"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Subcunty/Town Council</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function getAllCountiesList(){
        $sql = database::performQuery("SELECT * FROM county ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllCountiesListByDistrict(){
        $id = $_REQUEST['id'];
        $sql = database::performQuery("SELECT * FROM county WHERE district_id=$id ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllCountiesListSelected($id){
        $sql = database::performQuery("SELECT * FROM county ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function processNewSubcounty(){

        $name = database::prepData($_REQUEST['name']);
        $county_id = database::prepData($_REQUEST['county_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `subcounty`(`name`, `county_id`, `user_id`,  `changed`) 
                                                       VALUES('$name','$county_id','$user_id',1)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageSubcounty');

    }

    public static function processEditSubcounty(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $county_id = database::prepData($_REQUEST['county_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `subcounty` SET `name`='$name', `county_id`='$county_id',  `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageSubcounty');

    }

    public static function processDeleteSubcounty(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!*/
        $sql = database::performQuery("DELETE FROM `subcounty` WHERE id=$id ");
        if($sql)

            redirect_to(ROOT.'/?action=dmManageSubcounty');

    }



    //Manage Parishes

    public static function manageParishesAll(){


        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF_ID</th>                                                
                                                <th>Subcounty/Town Council Name</th>
                                                 <th>District/City Attached</th>
                                                 <th>County/Municipality Attached</th>
                                                 <th>No. Parishes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllSubcountyParishData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Subcounty/Town Council Name</th>
                                                 <th>District/City Attached</th>
                                                 <th>County/Municipality Attached</th>
                                                 <th>No. Parishes</th>                                          
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllSubcountyParishData(){



        $sql = database::performQuery("SELECT * FROM subcounty ORDER BY county_id,name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){

                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                <td>'.self::getDistrictCountyByID($data['county_id']).'</td>
                                                <td>'.self::getCountyByID($data['county_id']).'</td>
                                                <td>'.self::getSubcountyParishCount($data['id']).'</td>
                                                <td>
                                                <a href="' . ROOT . '/?action=dmManageParish&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-success">Manage Parishes</button></a>
                                                
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                   
                   
                    </tr>';
        }

        return $rt;
    }

    public static function manageParishes(){
        $id = $_REQUEST['id'];
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewParish&id='.$id.'">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Parish/Ward</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF_ID</th>                                                
                                                <th>Parish/Ward</th>                                                
                                                <th>District/City <br / <small>County/Municipality</small> </th>
                                                <th>Subcounty/Town Council</th>
                                                <th>No. Villages</th>  
                                                <th>Location</th>  
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllParishData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Parish/Ward</th>
                                                <th>District/City <br / <small>County/Municipality</small> </th>
                                                <th>Subcounty/Town Council</th>                                     
                                                <th>No. Villages</th>   
                                                <th>Location</th>                                    
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }



    public static function getAllParishData(){

        $id = $_REQUEST['id'];

        $sql = database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){



                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                 <td>'.self::getDistrictCountyBySubcountyID($data['subcounty_id'])['district'].'  / <br /><small>'.self::getDistrictCountyBySubcountyID($data['subcounty_id'])['county'].'</small></td>
                                                 <td>'.self::getSubcountyByID($data['subcounty_id']).'</td>
                                                 <td>'.self::getVillageCountByParishID($data['id']).'</td>
                                                 <td>'.$data['parish_latitude'].','.$data['parish_longitude'].'</td>
                                                 <td>
                                                   <a href="' . ROOT . '/?action=dmManageVillage&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-success">Manage Villages</button></a>
                                                 <br />
                                                 <br />
                                                   <a href="' . ROOT . '/?action=editParish&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myCounty'.$data['id'].'" >Delete</button></td>
                                      
                                               
                                      
                                          <!-- Delete District modal content -->
                                <div id="myCounty'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Parish/Ward?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteParish&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                            
                                            
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                
                                
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                   
                    </tr>';
        }

        return $rt;
    }

    public static function getSubcountyByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM subcounty WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }


    public static function getDistrictCountyBySubcountyID($id){
        $content = "";
        $sql =  database::performQuery("SELECT district.name as district, county.name as county FROM district,county,subcounty WHERE district.id = county.district_id AND county.id=subcounty.county_id AND  subcounty.id=$id");
        return $sql->fetch_assoc();

    }

    public static function getVillageCountByParishID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM village WHERE parish_id=$id");
        return $sql->num_rows;

    }

    public static function addNewParish(){

        $id = $_REQUEST['id'];

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Parish/Ward</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Parish/Ward name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Subcounty/Town Council Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <input type="text" id="name" class="form-control" placeholder="'.self::getSubcountyByID($id).'" name="name" disabled>
                                                        <input type="hidden" id="id" class="form-control"  value="'.$id.'" name="id" required>
                                                       
                                                  
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Latitude</label>
                                                    <input type="text" id="name" class="form-control" placeholder="e.g 0.2312445" name="lat" required>
                                                    </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Longitude</label>
                                                    <input type="text" id="name" class="form-control" placeholder="e.g 32.2839292" name="lng" required>
                                                    </div>
                                            </div>
                                            
                                                                                   
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewParish"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Parish/Ward</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function editParish($id){

        $sql = database::performQuery("SELECT * FROM parish WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Parish/Ward</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Subcounty/Town Council</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="subcounty_id" required>
                                                            <option selected="">Select Option</option>
                                                            '.self::getAllSubcountiesInDistrictBySubcountyID($data['subcounty_id']).'                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Latitude</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['parish_latitude'].'" name="lat" required>
                                                    </div>
                                            </div>
                                            
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Longitude</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['parish_longitude'].'" name="lng" required>
                                                    </div>
                                            </div>
                                           
                                            
                                            
                                            
                                            
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditParish"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Parish/Ward</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function getAllSubcountiesList(){
        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllSubcountiesListSelected($id){
        $sql = database::performQuery("SELECT * FROM district ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }
    public static function getAllSubcountiesInDistrictBySubcountyID($id){
        $sql = database::performQuery("SELECT district_id FROM county,subcounty WHERE county.id =subcounty.county_id AND subcounty.id=$id");
        $result = $sql->fetch_assoc()['district_id'];

        $sql = database::performQuery("SELECT subcounty.id,subcounty.name FROM district,county,subcounty WHERE 
                                           district.id = county.district_id AND county.id = subcounty.county_id 
                                           AND district.id = $result ORDER BY name ASC");

        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function processNewParish(){

        $name = database::prepData($_REQUEST['name']);
        $id = database::prepData($_REQUEST['id']);
        $lat = database::prepData($_REQUEST['lat']);
        $lng = database::prepData($_REQUEST['lng']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `parish`(`name`, subcounty_id, `parish_latitude`, `parish_longitude`, `user_id`,  `changed`) 
                                                       VALUES('$name','$id','$lat','$lng','$user_id',1)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageParish&id='.$id);

    }

    public static function processEditParish(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $latitude = database::prepData($_REQUEST['lat']);
        $longitude = database::prepData($_REQUEST['lng']);
        $subcounty_id = database::prepData($_REQUEST['subcounty_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `parish` SET `name`='$name', `parish_latitude`='$latitude',`parish_longitude`='$longitude', `subcounty_id`='$subcounty_id',  `user_id`='$user_id', changed=1
                                                      WHERE id=$id ");

        if($sql)
          redirect_to(ROOT.'/?action=dmManageParish&id='.$subcounty_id);

    }

    public static function processDeleteParish(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!*/
        $sql = database::performQuery("DELETE FROM `parish` WHERE id=$id ");
        if($sql)

            redirect_to($_SERVER['HTTP_REFERER']);

    }



    //Manage Villages
    public static function manageVillages(){
        $id = $_REQUEST['id'];

        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewVillage&id='.$id.'">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Village/Cell</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF_ID</th>                                                
                                                <th>Village/Cell Name</th>                                                
                                                <th>District/City <br /><small>County/Municipality</small></th>
                                                <th>Subcounty/Town Council <br /> Parish/Ward></th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllVillageData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Village/Cell Name</th>                                                
                                                <th>District/City <br /><small>County/Municipality</small></th>
                                                <th>Subcounty/Town Council <br /> Parish/Ward></th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllVillageData(){

        $id = $_REQUEST['id'];


        $sql = database::performQuery("SELECT * FROM village WHERE parish_id=$id ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>
                                                <td>'.self::getLocationInfoByParishID($data['parish_id'])['district'].' <br /> <small>'.self::getLocationInfoByParishID($data['parish_id'])['county'].'</small></td>
                                                <td>'.self::getLocationInfoByParishID($data['parish_id'])['subcounty'].' <br /> <small>'.self::getLocationInfoByParishID($data['parish_id'])['parish'].'</small></td>
                                                 <td><a href="' . ROOT . '/?action=editVillage&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myCounty'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myCounty'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Village/Cell?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteVillage&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                   
                    </tr>';
        }

        return $rt;
    }

    public static function getParishByID($id){
        $content = "";
        $sql =  database::performQuery("SELECT * FROM parish WHERE id=$id");
        return $sql->fetch_assoc()['name'];

    }

    public static function getLocationInfoByParishID($id){
        $content = "";
        $sql =  database::performQuery("SELECT district.name as district,county.name as county, subcounty.name as subcounty, parish.name as parish
                                            FROM district,county,subcounty,parish 
                                            WHERE parish.id=$id AND district.id = county.district_id AND county.id = subcounty.county_id AND subcounty.id = parish.subcounty_id");
        return $sql->fetch_assoc();

    }

    public static function addNewVillage(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Village/Cell</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Village/Cell name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                   <label class="control-label">Parish Attached</label>
                                                   <input type="text" id="name" class="form-control" value="'.self::getParishByID($_REQUEST['id']).'" name="parish" disabled>
                                                   <input type="hidden" class="form-control" value="'.self::getParishByID($_REQUEST['id']).'" name="parish_id" required>
                                                  </div>
                                            </div>
                                                  <!--/span-->
                                        </div>
                                        <!--/row-->
                                         
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewVillage"/>
                                             <input type="hidden" name="parish_id" value="'.$_REQUEST['id'].'"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Village/Cell</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function editVillage($id){

        $sql = database::performQuery("SELECT * FROM village WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Village/Cell</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Parish Attached</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        <select class="custom-select mr-sm-2" name="parish_id" required>
                                                            <option selected="">Select Option</option>
                                                            '.self::getAllParishesInDistrictByVillageID($data['parish_id']).'                                     
                                                        </select>
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                    
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditVillage"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Village/Cell</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function getAllParishesList(){
        $sql = database::performQuery("SELECT * FROM parish ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllParishesListSelected($id){
        $sql = database::performQuery("SELECT * FROM parish ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function getAllParishesInDistrictByVillageID($id){
        $sql = database::performQuery("SELECT subcounty_id FROM subcounty,parish WHERE subcounty.id =parish.subcounty_id AND parish.id=$id");
        $result = $sql->fetch_assoc()['subcounty_id'];

        $sql = database::performQuery("SELECT parish.id,parish.name FROM subcounty,parish,village WHERE 
                                           subcounty.id = parish.subcounty_id AND parish.id = village.parish_id 
                                           AND subcounty.id = $result GROUP BY parish.name ORDER BY name ASC");

        $content = "";
        while($data=$sql->fetch_assoc()){
            if($data['id']  == $id)
                $content .="<option value='$data[id]' SELECTED/>$data[name]";
            else
                $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function processNewVillage(){

        $name = database::prepData($_REQUEST['name']);
        $parish_id = database::prepData($_REQUEST['parish_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `village`(`name`, `parish_id`, `user_id`,  `changed`) 
                                                       VALUES('$name','$parish_id','$user_id',1)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageVillage&id='.$parish_id);

    }

    public static function processEditVillage(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $parish_id = database::prepData($_REQUEST['parish_id']);
        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `village` SET `name`='$name', `parish_id`='$parish_id',  `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageVillage&id='.$parish_id);

    }

    public static function processDeleteVillage(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!*/
        $sql = database::performQuery("DELETE FROM `village` WHERE id=$id ");
        if($sql)

            redirect_to($_SERVER['HTTP_REFERER']);

    }



    //Manage Topics

    public static function manageTopics(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewTopic">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Topic</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target User Group(s)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllTopicData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target User Group(s)</th>                                              
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllTopicData(){



        $sql = database::performQuery("SELECT * FROM ext_topics ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getTopicUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editTopic&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Topic?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteTopic&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getTopicUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,ext_topics_user_group WHERE ext_topics_id=$id AND user_group.id = ext_topics_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function getAllUserGroupsList(){
        $sql = database::performQuery("SELECT * FROM user_group ORDER BY name ASC");
        $content = "";
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]' />$data[name]";
        }
        return $content;
    }

    public static function addNewTopic(){

        $fieldHTML = "<div class='row' style='margin-top: 20px; margin-bottom: 15px;'><div class='col-7'><input type='text' class='form-control col-6' placeholder='Enter Topic' name='topic[]' value=''/></div><div class='col-5'><a href='javascript:void(0);' class='remove_button'><img width='40' height='40' src='".ROOT."/images/trash.png'/></a></div></div>";


        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Topic Name</label>
                                                    <div class="field_wrapper">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <input type="text" class="form-control col-6" name="topic[]" placeholder="Enter Topic" value="" required/>
                                                        </div>

                                                        <div class="col-5">
                                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img width="40" height="40" src="'.ROOT.'/images/plus.png"/></a>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                           
                                               
                                          <div class="col-md-12">
                                               
                                                    <label class="control-label">Select User Group which apply to this topic</label>
                                                    <select id="mycheckboxlist" placeholder="Select User Group(s)"  name="user_groups[]" multiple required>
                                                            '.self::getAllTopicsListCheckbox().'                                          
                                                    </select>                                                 
                                                    
                                                 </div>

                                                 <div class="form-group col-md-12">
                                               
                                                <label class="control-label">Select Category this topic  belongs to</label>
                                                <select  class="form-control" placeholder="Select Category"  name="category"  required>
                                                <option value="">--select a category--</option>
                                                        '.self::getTopicCategories().'                                          
                                                </select>                                                 
                                                
                                            </div>

                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> 
                <script type="text/javascript">

                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $(".add_button");
                        var wrapper = $(".field_wrapper");
                        
                        var x = 1;
    
                        $(addButton).click(function(){
                            
                            if(x < maxField){ 
                                x++;
                                $(wrapper).append('.'"'.$fieldHTML.'"'.');
                            }
                        });
                        
                
                        $(wrapper).on("click", ".remove_button", function(e){
                            e.preventDefault();
                            $(this).parent("div").parent("div").remove();
                            
                            x--; 
                        });
                    });
                </script>';

        return $content;
    }

    public static function getAllTopicsListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_topics_user_group,user_group WHERE user_group.id = ext_topics_user_group.user_group_id AND ext_topics_id = $id ORDER BY name ASC");
       $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_groups[]' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_groups[]' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }


    public static function getAllTopicsListCheckbox(){
       $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]'>$data[name]";
        }
        return $content;
    }

    public static function editTopic($id){

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this topic</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllTopicsListSelected($data['id']).'                                     
                                                        
                                                    </div>

                                                    <div class="form-group m-b-30"> 
                                                        <label class="control-label">Select Category this activity belongs to</label>
                                                        <select  class="form-control" placeholder="Select Category"  name="category"  required>
                                                        <option value="">--select a category--</option>                                     
                                                            '.self::getTopicCategorySelected($data['id']).'       
                                                        </select>                              
                                                        
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewTopic(){

        $topics =  $_REQUEST['topic'];
        $user_groups = $_REQUEST['user_groups'];
        $category = $_REQUEST['category'];

        foreach($topics as $topic){

            $name = database::prepData($topic);

            $sql = database::performQuery("INSERT INTO `ext_topics`(`name`, `category`) VALUES('$name', $category)");

            $idx = database::getLastInsertID();

            
            if(count($user_groups) > 0){

                foreach($user_groups as $user_group){

                    $sqlb =  database::performQuery(" INSERT INTO ext_topics_user_group (`ext_topics_id`, `user_group_id`) VALUES($idx,$user_group)");

                }
            }

        }
    
        if($sql)
            redirect_to(ROOT.'/?action=dmManageTopics');
    }

    public static function processEditTopic(){

      $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $user_groups =$_REQUEST['user_groups'];
        $category =  $_REQUEST['category'];


        $sql = database::performQuery("UPDATE `ext_topics` SET name='$name', category=$category WHERE id=$id");

        //Modify the User_group logic
        if(count($user_groups) > 0)
        {
            //Delete Existing associations
            $sqlc  =  database::performQuery("DELETE  FROM ext_topics_user_group WHERE ext_topics_id=$id");

            //Insert New Data!
            foreach($user_groups as $user_group){
                $sqlb =  database::performQuery(" INSERT INTO ext_topics_user_group (`ext_topics_id`, `user_group_id`) VALUES($id,$user_group)");
            }
        }


       redirect_to(ROOT.'/?action=dmManageTopics');
    }

    public static function processDeleteTopic(){

        $id = database::prepData($_REQUEST['id']);



        /*TODO enable or disable in production by uncommenting this block! */
         $sql = database::performQuery("DELETE FROM `ext_topics_user_group` WHERE ext_topics_id=$id ");
         $sql2 = database::performQuery("DELETE FROM `ext_topics` WHERE id=$id ");
           if($sql2)

        redirect_to(ROOT.'/?action=dmManageTopics');

    }


    //End Manage Topics


    //Start Manage Activities
    public static function manageActivities(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewActivity">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Activity</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Activity Name</th>
                                                <th>Target Group(s)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllActivityData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Activity Name</th>
                                                <th>Target Group(s)</th>                                             
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllActivityData(){



        $sql = database::performQuery("SELECT * FROM ext_activitys ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getActivityUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editActivity&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Activity?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteActivity&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                                              </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }



    public static function getActivityUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,ext_activitys_user_group WHERE ext_activitys_id=$id AND user_group.id = ext_activitys_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function addNewActivity(){

         $fieldHTML = "<div class='row' style='margin-top: 20px; margin-bottom: 15px;'><div class='col-7'><input type='text' class='form-control col-6' placeholder='Enter Activity' name='activity[]' value=''/></div><div class='col-5'><a href='javascript:void(0);' class='remove_button'><img width='40' height='40' src='".ROOT."/images/trash.png'/></a></div></div>";

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Activity</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Activity Name</label>
                                                    <div class="field_wrapper">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <input type="text" class="form-control col-6" name="activity[]" placeholder="Enter Activity " value="" required/>
                                                        </div>

                                                        <div class="col-5">
                                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img width="40" height="40" src="'.ROOT.'/images/plus.png"/></a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <!--/span-->
                                           
                                               
                                          <div class="col-md-12">
                                               
                                                <label class="control-label">Select User Group which apply to this activity</label>
                                                <select id="mycheckboxlist" placeholder="Select User Group(s)"  name="user_groups[]" multiple required>
                                                        '.self::getAllTopicsListCheckbox().'                                          
                                                </select>                                                 
                                                    
                                             </div>
                                            

                                            <div class="form-group col-md-12">
                                               
                                                <label class="control-label">Select Category this activity belongs to</label>
                                                <select  class="form-control" placeholder="Select Category"  name="category"  required>
                                                <option value="">--select a category--</option>
                                                        '.self::getActivityCategories().'                                          
                                                </select>                                                 
                                                
                                            </div> 
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewActivity"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Activity</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> 
                <script type="text/javascript">

                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $(".add_button");
                        var wrapper = $(".field_wrapper");
                        
                        var x = 1;
    
                        $(addButton).click(function(){
                            
                            if(x < maxField){ 
                                x++;
                                $(wrapper).append('.'"'.$fieldHTML.'"'.');
                            }
                        });
                        
                
                        $(wrapper).on("click", ".remove_button", function(e){
                            e.preventDefault();
                            $(this).parent("div").parent("div").remove();
                            
                            x--; 
                        });
                    });
                </script>';

        return $content;
    }

    public static function getAllActivitiesListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_activitys_user_group,user_group WHERE user_group.id = ext_activitys_user_group.user_group_id AND ext_activitys_id = $id ORDER BY name ASC");
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_groups[]' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_groups[]' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }


    public static function getAllActivitiesListCheckbox(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function editActivity($id){

        $sql = database::performQuery("SELECT * FROM ext_activitys WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Activity</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this activity</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllActivitiesListSelected($data['id']).'                                     
                                                        
                                                    </div>

                                                    <div class="form-group m-b-30"> 
                                                        <label class="control-label">Select Category this activity belongs to</label>
                                                        <select  class="form-control" placeholder="Select Category"  name="category"  required>
                                                        <option value="">--select a category--</option>                                     
                                                            '.self::getActivityCategorySelected($data['id']).'       
                                                        </select>                              
                                                        
                                                    </div>

                                                    
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditActivity"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Activity</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewActivity(){

        $activities =$_REQUEST['activity'];

        $user_groups = $_REQUEST['user_groups'];

        $category = $_REQUEST['category'];

        foreach($activities as $activity){

            $name = database::prepData($activity);


            $sql = database::performQuery("INSERT INTO `ext_activitys`(`name`, `category`)
            VALUES('$name', $category)");

            $idx = database::getLastInsertID();

            if(count($user_groups) > 0){


                foreach($user_groups as $user_group){

                    $sqlb =  database::performQuery(" INSERT INTO ext_activitys_user_group (`ext_activitys_id`, `user_group_id`) VALUES($idx,$user_group)");
                    
                }
            }

        }

        if($sql)
            redirect_to(ROOT.'/?action=dmManageActivities'); 

 }

    public static function processEditActivity(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $user_groups =$_REQUEST['user_groups'];
        $category =  $_REQUEST['category'];


        $sql = database::performQuery("UPDATE `ext_activitys` SET name='$name', category=$category WHERE id=$id");

        //Modify the User_group logic
        if(count($user_groups) > 0)
        {
            //Delete Existing associations
            $sqlc  =  database::performQuery("DELETE  FROM ext_activitys_user_group WHERE ext_activitys_id=$id");

            //Insert New Data!
            foreach($user_groups as $user_group){
                $sqlb =  database::performQuery(" INSERT INTO ext_activitys_user_group (`ext_activitys_id`, `user_group_id`) VALUES($id,$user_group)");
            }
        }


        redirect_to(ROOT.'/?action=dmManageActivities');

    }

    public static function processDeleteActivity(){


        $id = database::prepData($_REQUEST['id']);
        /*TODO enable or disable in production by uncommenting this block! */
        $sql = database::performQuery("DELETE FROM `ext_activitys_user_group` WHERE ext_activitys_id=$id ");
        $sql2 = database::performQuery("DELETE FROM `ext_activitys` WHERE id=$id ");
        if($sql2)

            redirect_to(ROOT.'/?action=dmManageActivities');

    }
    //End Manage Acitvities


    //Manage Entreprizes
    public static function manageEntreprizes(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewEntreprize">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Entreprize/Approach</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Entreprize/Approach Name</th>
                                                <th>Parent Category Name</th>
                                                <th>Target Group(s)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllEntreprizeData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Entreprize/Approach Name</th>
                                                <th>Parent Category Name</th>
                                                <th>Target Group(s)</th>                                            
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getParentEntreprizCateory($id){
        $sql = database::performQuery("SELECT name FROM km_category WHERE id=$id");
        if($sql->num_rows > 0)
            return $sql->fetch_assoc()['name'];
        else
            return 'None!';
    }

    public static function getAllEntreprizeData(){



        $sql = database::performQuery("SELECT * FROM km_category ORDER BY id ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getParentEntreprizCateory($data['parent_id']).'</td>                                               
                                                <td>'.self::getEntreprizeUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editEntreprize&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Entreprize/Approach?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteEntreprize&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getEntreprizeUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,km_category_user_group WHERE km_category_id=$id AND user_group.id = km_category_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function addNewEntreprize(){

        $fieldHTML = "<div class='row' style='margin-top: 20px; margin-bottom: 15px;'><div class='col-7'><input type='text' class='form-control col-6' placeholder='Enter Entreprize/Approach Name' name='enterprise[]' value=''/></div><div class='col-5'><a href='javascript:void(0);' class='remove_button'><img width='40' height='40' src='".ROOT."/images/trash.png'/></a></div></div>";

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Entreprize/Approach</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <div class="field_wrapper">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <input type="text" class="form-control col-6" name="enterprise[]" placeholder="Enter Entreprize/Approach Name" value="" required/>
                                                        </div>

                                                        <div class="col-5">
                                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img width="40" height="40" src="'.ROOT.'/images/plus.png"/></a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                   
                                            </div>
                                            <!--/span-->
                                           
                                               
                                          <div class="col-md-12">
                                               
                                                    <label class="control-label">Parent Entreprize/Approach</label>
                                                    <select class="form-control form-select select2 select2-dropdown select2-container--default" style="width:100%" name="parent_id"  required>
                                                            '.self::getAllEntreprizesList().'                                          
                                                    </select>                                                 
                                                    
                                                 </div>
                                                 <br />
                                                 <br />
                                                 
                                                 <div class="col-md-12">
                                               
                                                    <label class="control-label">Select User Group which apply to this Entreprize/Approach</label>
                                                    <select id="mycheckboxlist" placeholder="Select User Group(s)"  name="user_groups[]" multiple required>
                                                            '.self::getAllTopicsListCheckbox().'                                          
                                                    </select>                                                 
                                                    
                                                 </div>
                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewEntreprize"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Enterprise</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> 
                <script type="text/javascript">

                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $(".add_button");
                        var wrapper = $(".field_wrapper");
                        
                        var x = 1;
    
                        $(addButton).click(function(){
                            
                            if(x < maxField){ 
                                x++;
                                $(wrapper).append('.'"'.$fieldHTML.'"'.');
                            }
                        });
                        
                
                        $(wrapper).on("click", ".remove_button", function(e){
                            e.preventDefault();
                            $(this).parent("div").parent("div").remove();
                            
                            x--; 
                        });
                    });
                </script>';

        return $content;
    }

    public static function getAllEntreprizesListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_topics_user_group,user_group WHERE user_group.id = ext_topics_user_group.user_group_id AND ext_topics_id = $id ORDER BY name ASC");
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function getAllEntreprizesListCheckbox(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function getAllEntreprizesList(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM km_category ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]'>$data[name]</option>";
        }
        return $content;
    }

    public static function editEntreprize($id){

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this topic</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllTopicsListSelected($data['id']).'                                     
                                                        
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewEntreprize(){

        
        $enterprise = $_POST['enterprise'];
        $parent_id = database::prepData($_REQUEST['parent_id']);
        $user_id = $_SESSION['user']['id'];

        foreach($enterprise as $ent){

            $name = database::prepData($ent);

            $sql = database::performQuery("INSERT INTO `km_category`(`name`, `parent_id`)
            VALUES('$name','$parent_id')");
        }

     

        if($sql)
            redirect_to(ROOT.'/?action=dmManageEntreprizes');
    }

    public static function processEditEntreprize(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);


        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `district` SET `name`='$name', `district_status`='$status', `subregion_id`='$sub_region',  `zone_id`='$zone', `land_type_id`='$land_type', `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processDeleteEntreprize(){

        $id = database::prepData($_REQUEST['id']);

       
         $sql = database::performQuery("DELETE FROM `km_category` WHERE id=$id ");
         if($sql){
        
       		 redirect_to(ROOT.'/?action=dmManageEntreprizes');
	}
    }


    //End Manage Entreprizes

    //Manage User Associations
    public static function manageUserAssociations(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewUserAssociation">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New User Association</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>User Category</th>
                                                <th>Child Catgeory(Rights)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllUserAssociationData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>User Category</th>
                                                <th>Child Catgeory(Rights)</th>                                           
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllUserAssociationData(){



        $sql = database::performQuery("SELECT * FROM ext_topics ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getTopicUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editTopic&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Topic?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteDistrict&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getUserAssociationUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,ext_topics_user_group WHERE ext_topics_id=$id AND user_group.id = ext_topics_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function addNewUserAssociation(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New User Association</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h4>Parent Category</h4>
                                                    <select data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" name="user_parents[]" multiple required>
                                                            '.self::getAllUserAssociationListParent().'                                          
                                                    </select>  
                                                   
                                                    </div>
                                            </div>
                                            <!--/span-->
                                           
                                           
                                           <div class="col-md-12">
                                               
                                                    <h4>Select Child Category(s)</h4>
                                                    <select data-border-color="success" data-border-variation="darken-2" class="select2 select2-with-border border-sucess form-control custom-select" style="width: 100%; height:36px;" name="user_children[]" multiple required>
                                                            '.self::getAllUserAssociationListCheckbox().'                                          
                                                    </select>                                                 
                                                    <br />
                                                 </div>
                                               
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                <br />
                                                    <h4>Select Rights applied to users </h4>
                                                   
                                                            <input type="checkbox" id="view" name="view" value="view">
                                                            <label for="view"> View</label><br>
                                                            <input type="checkbox" id="manage" name="manage" value="maange">
                                                            <label for="manage"> Manage</label><br>
                                                            <input type="checkbox" id="transfer" name="transfer" value="transfer">
                                                            <label for="transfer"> Transfer</label><br>                                     
                                                       
                                                 
                                                    
                                                 </div>
                                            </div>
                                            
                                            
                                             
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewUserAssociation"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New User Association</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function getAllUserAssociationListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_topics_user_group,user_group WHERE user_group.id = ext_topics_user_group.user_group_id AND ext_topics_id = $id ORDER BY name ASC");
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function getAllUserAssociationListCheckbox(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){

           $content .='<optgroup label="'.$data['name'].'">';
            $sqlb = database::performQuery("SELECT * FROM user_category WHERE user_group_id = $data[id]");
            while($datab = $sqlb->fetch_assoc()){
                $content .="<option value='$datab[id]'>$datab[name]";
            }

            $content .='</optgroup>';
                   }
        return $content;
    }



    public static function getAllUserAssociationListParent(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group WHERE id IN (1,2,3,4,5,6)ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){

            $content .='<optgroup label="'.$data['name'].'">';
            $sqlb = database::performQuery("SELECT * FROM user_category WHERE user_group_id = $data[id]");
            while($datab = $sqlb->fetch_assoc()){
                $content .="<option value='$datab[id]'>$datab[name]";
            }

            $content .='</optgroup>';
        }
        return $content;
    }


    public static function editUserAssociation($id){

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this topic</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllTopicsListSelected($data['id']).'                                     
                                                        
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewUserAssociation(){

        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);



        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `district`(`id`, `name`, `district_status`,  `subregion_id`,  `zone_id`, `land_type_id`, `user_id`)
                                                       VALUES('','$name','$status','$sub_region','$zone','$land_type',$user_id)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processEditUserAssociation(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);


        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `district` SET `name`='$name', `district_status`='$status', `subregion_id`='$sub_region',  `zone_id`='$zone', `land_type_id`='$land_type', `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processDeleteUserAssociation(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!
         $sql = database::performQuery("DELETE FROM `district` WHERE id=$id ");
           if($sql)
        */
        redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    //End Manage User Associations

    //Manage User Transfers
    public static function manageUserTransfers(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewTopic">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Topic</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target Group(s)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllTopicData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target Group(s)</th>                                              
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;

    }

    public static function getAllUserTransferData(){



        $sql = database::performQuery("SELECT * FROM ext_topics ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getTopicUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editTopic&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Topic?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteDistrict&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getUserTransferUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,ext_topics_user_group WHERE ext_topics_id=$id AND user_group.id = ext_topics_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function addNewUserTransfer(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Topic Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Topic name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                           
                                               
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Select User Group which apply to this topic</label>
                                                    
                                                            '.self::getAllTopicsListCheckbox().'                                          
                                                       
                                                 
                                                    
                                                 </div>
                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function getAllUserTransferListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_topics_user_group,user_group WHERE user_group.id = ext_topics_user_group.user_group_id AND ext_topics_id = $id ORDER BY name ASC");
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function getAllUserTransferListCheckbox(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function editUserTransfer($id){

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this topic</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllTopicsListSelected($data['id']).'                                     
                                                        
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewUserTransfer(){

        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);



        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `district`(`id`, `name`, `district_status`,  `subregion_id`,  `zone_id`, `land_type_id`, `user_id`)
                                                       VALUES('','$name','$status','$sub_region','$zone','$land_type',$user_id)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processEditUserTransfer(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);


        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `district` SET `name`='$name', `district_status`='$status', `subregion_id`='$sub_region',  `zone_id`='$zone', `land_type_id`='$land_type', `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processDeleteUserTransfer(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!
         $sql = database::performQuery("DELETE FROM `district` WHERE id=$id ");
           if($sql)
        */
        redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    //End User Tranfers


    //Manage User Permissions
    public static function manageUserPermissions(){
        $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addNewTopic">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Topic</button>
                    </a>
                    <br />
                    <br />
                    </div>';

        $content = '<div class="row">'.$addd_btn.'
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target Group(s)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getAllTopicData().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>REF-ID</th>                                                
                                                <th>Topic Name</th>
                                                <th>Target Group(s)</th>                                              
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';

    }

    public static function getAllUserPermissions(){



        $sql = database::performQuery("SELECT * FROM ext_topics ORDER BY name ASC");
        $rt =  '';
        if($sql->num_rows > 0){

            while($data=$sql->fetch_assoc()){


                $rt .='<tr>
                                                <td><a href="#">'.$data['id'].'</a></td>
                                                <td>'.$data['name'].'</td>                                               
                                                <td>'.self::getTopicUserGroup($data['id']).'</td>
                                                <td><a href="' . ROOT . '/?action=editTopic&id='.$data['id'].'"><button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-warning">Edit</button></a>
                                                <button type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger"  data-toggle="modal" data-target="#myModal'.$data['id'].'" >Delete</button></td>
                                          <!-- Delete District modal content -->
                                <div id="myModal'.$data['id'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete '.ucwords(strtolower($data['name'])).'</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Are you sure you want to delete this Topic?</h4>
                                                <p>Pleas note, you will not be able to undo this action.</p>
                                                   <a href="' . ROOT . '/?action=deleteDistrict&id='.$data['id'].'"><button  type="button btn-rounded" class="btn waves-effect waves-light btn-xs btn-danger">Yes, delete '.ucwords(strtolower($data['name'])).'</button></a></td>
                               
                                           
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                         
                                            </tr>';
            }
        }
        else
        {
            $rt .= '<tr>
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td> 
                    </tr>';
        }

        return $rt;
    }

    public static function getUserPermissionsUserGroup($id){
        $content = "<ul>";
        $sql = database::performQuery("SELECT user_group.name FROM user_group,ext_topics_user_group WHERE ext_topics_id=$id AND user_group.id = ext_topics_user_group.user_group_id ORDER BY name ASC");

        while($data=$sql->fetch_assoc()){
            $content .='<li>'.$data['name'].'</li>';
        }
        $content .='</ul>';

        return $content;
    }

    public static function addNewUserPermissions(){

        $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Add New Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Topic Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="Topic name" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                           
                                               
                                          <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Select User Group which apply to this topic</label>
                                                    
                                                            '.self::getAllTopicsListCheckbox().'                                          
                                                       
                                                 
                                                    
                                                 </div>
                                            </div>
                                     
                                            
                                                  
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="action" value="processNewTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Add New Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

        return $content;
    }

    public static function getAllUserPermissionsListSelected($id){
        $sql = database::performQuery("SELECT user_group_id FROM ext_topics_user_group,user_group WHERE user_group.id = ext_topics_user_group.user_group_id AND ext_topics_id = $id ORDER BY name ASC");
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $ids[] = $data['user_group_id'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if(in_array($data['id'], $ids))
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]' checked>$data[name]</div>";
            else
                $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function getAllUserPermissionsListCheckbox(){
        $content = "";

        $sql = database::performQuery("SELECT * FROM user_group ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<div class='form-check'><input type='checkbox' class='form-check-input' name='user_group' value='$data[id]'>$data[name]</div>";
        }
        return $content;
    }

    public static function editUserPermissions($id){

        $sql = database::performQuery("SELECT * FROM ext_topics WHERE id=$id");

        while($data=$sql->fetch_assoc())
        {
            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Edit Topic</h4>
                            </div>
                            <form action="" method="POST">
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" id="name" class="form-control" value="'.$data['name'].'" name="name" required>
                                                    </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group has-danger">
                                                    <label class="control-label"> User Group which apply to this topic</label>
                                                    
                                                    <div class="form-group m-b-30">                                      
                                                        
                                                            '.self::getAllTopicsListSelected($data['id']).'                                     
                                                        
                                                    </div>
                                                    
                                                 </div>
                                            </div>
                                            
                                                     <!--/span-->
                                        </div>
                                        <!--/row-->
                                       
                                                                              
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                             <input type="hidden" name="id" value="'.$data['id'].'"/>
                                             <input type="hidden" name="action" value="processEditTopic"/>
                                            <button type="submit" class="btn btn-success btn-rounded"> <i class="fa fa-check"></i> Edit Topic</button>
                                            <button type="reset" class="btn btn-dark btn-rounded">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';


        }

        return $content;
    }

    public static function processNewUserPermissions(){

        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);



        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("INSERT INTO `district`(`id`, `name`, `district_status`,  `subregion_id`,  `zone_id`, `land_type_id`, `user_id`)
                                                       VALUES('','$name','$status','$sub_region','$zone','$land_type',$user_id)");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processEditUserPermissions(){

        $id = database::prepData($_REQUEST['id']);
        $name = database::prepData($_REQUEST['name']);
        $status = database::prepData($_REQUEST['status']);
        $zone = database::prepData($_REQUEST['zone']);
        $land_type = database::prepData($_REQUEST['land_type']);
        $sub_region = database::prepData($_REQUEST['sub_region']);


        $user_id = $_SESSION['user']['id'];

        $sql = database::performQuery("UPDATE `district` SET `name`='$name', `district_status`='$status', `subregion_id`='$sub_region',  `zone_id`='$zone', `land_type_id`='$land_type', `user_id`='$user_id'
                                                      WHERE id=$id ");

        if($sql)
            redirect_to(ROOT.'/?action=dmManageDistrict');

    }

    public static function processDeleteUserPermissions(){

        $id = database::prepData($_REQUEST['id']);

        /*TODO enable or disable in production by uncommenting this block!
         $sql = database::performQuery("DELETE FROM `district` WHERE id=$id ");
           if($sql)
        */
        redirect_to(ROOT.'/?action=dmManageDistrict');

    }

//End User Permissions


    public static function getActivityCategories(){

        $content = "";

        $sql = database::performQuery("SELECT * FROM ext_activity_category ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]'>$data[name]";
        }
        return $content;

    }


     public static function getTopicCategories(){

        $content = "";

        $sql = database::performQuery("SELECT * FROM ext_topic_category ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            $content .="<option value='$data[id]'>$data[name]";
        }
        return $content;

    }

    public static function getActivityCategorySelected($id){

        $sql = database::performQuery("SELECT category FROM ext_activitys WHERE id = $id" );
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $category = $data['category'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM ext_activity_category ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if($data['id'] == $category)
            $content .="<option value='$data[id]' selected>$data[name]";
            else
            $content .="<option value='$data[id]'>$data[name]";
        }

        return $content;
    }


    public static function getTopicCategorySelected($id){

        $sql = database::performQuery("SELECT category FROM ext_topics WHERE id = $id" );
        $ids = [];
        while($data=$sql->fetch_assoc()){
            $category = $data['category'];
        }

        $content = "";

        $sql = database::performQuery("SELECT * FROM ext_topic_category ORDER BY id ASC");
        while($data=$sql->fetch_assoc()){
            if($data['id'] == $category)
            $content .="<option value='$data[id]' selected>$data[name]";
            else
            $content .="<option value='$data[id]'>$data[name]";
        }

        return $content;
    }

}
