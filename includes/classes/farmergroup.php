<?php 

class farmergroup 
{
    public static function getFarmerGroupsByLocation(){

        $id = $_SESSION['user']['location_id'];




        $content = '';
        switch($_SESSION['user']['user_category_id']){

            //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

            $content = "SELECT db_farmer_groups.id,db_farmer_groups.name,db_farmer_groups.id_str,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
            FROM db_farmer_groups join parish on db_farmer_groups.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id 
             ORDER BY db_farmer_groups.id DESC                      
            ";

            break;

            //District
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
            case 23:
            case 24:

         $content = "SELECT db_farmer_groups.id,db_farmer_groups.name,db_farmer_groups.id_str,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
                   FROM db_farmer_groups join parish on db_farmer_groups.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id WHERE district.id =".$_SESSION['user']['district_id']."   
                    ORDER BY db_farmer_groups.id DESC                      
                   ";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

            $content = "SELECT db_farmer_groups.id,db_farmer_groups.name,db_farmer_groups.id_str,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
            FROM db_farmer_groups join parish on db_farmer_groups.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id
                   WHERE subcounty.id =  ".$_SESSION['user']['location_id']."    
                   ORDER BY db_farmer_groups.id DESC                    
                   ";

            break;

            default:
                $content ='';
                break;

        }


        return $content;
    }

    public static function getFarmerGroups(){



        $sql = database::performQuery(self::getFarmerGroupsByLocation());
               $rt =  '';
        if($sql->num_rows > 0){

        while($data=$sql->fetch_assoc()){

           
            // get enterprises 
            $g_id = $data['id'];
            $sql_e = "select name from entreprize_category where id in(select enterprise_id from farmer_group_enterprises where farmer_group_id=$g_id)";
            $ent_r = database::performQuery($sql_e);
            

            $rt .='<tr>                          <td><a href="">ID-'.$data['id'].'</a></td>
                                                <td><a href="">'.$data['name'].'</a> </td><td>';

                             while($edata = $ent_r->fetch_assoc()){
                                    $rt .=''.$edata['name'].',';
                             }                   
                                           $rt .='</td><td>'.$data['parish_name'].'</td>
                                                <td>'.$data['subcounty_name'].' </td>
                                                <td>'.$data['district_name'].'</td>
                                                <td><a href="?action=viewFarmers&group='.$data['id'].'">View Farmers</td>
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

    public static function viewFarmerGroups()
{
              $addd_btn = '<div class="col-lg-12">
                    <a href="#">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Group</button>
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
                                                <th>ID</th>                                                
                                                <th>Name</th>
                                                <th>Enterprises</th>
                                                <th>Parish</th>
                                                <th>Subcounty</th>
                                                <th>District</th>                                                                                               
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getFarmerGroups().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Name</th>
                                                <th>Enterprises</th>
                                                <th>Parish</th>
                                                <th>Subcounty</th>
                                                <th>District</th>                                                                                               
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';

        return $content;
    }


    
}