<?php 

class farmer 
{
    public static function getFarmersByLocation($group_id = null){

        $id = $_SESSION['user']['location_id'];

        $add_group = (!is_null($group_id)) ? "and db_farmers.parent_id=$group_id" : "";


        $content = '';
        switch($_SESSION['user']['user_category_id']){

            //National
            case 6:
            case 15:
            case 16:
            case 17:
            case 18:
            case 5:

            $content = "SELECT db_farmers.id,db_farmers.name,db_farmers.parent_id,db_farmers.id_str,db_farmers.gender,nin,contact,education_level.name as education_level,km_language.name as main_language,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
            FROM db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id join education_level on db_farmers.education_level_id=education_level.id join km_language on db_farmers.main_language = km_language.id where db_farmers.id is not null $add_group
                                 
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

         $content = "SELECT db_farmers.id,db_farmers.parent_id,db_farmers.name,db_farmers.id_str,db_farmers.gender,nin,contact,education_level.name as education_level,km_language.name as main_language,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
         FROM db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id join education_level on db_farmers.education_level_id=education_level.id join km_language on db_farmers.main_language = km_language.id 
          WHERE district.id =".$_SESSION['user']['district_id']." $add_group ";

                break;


            //Subcounty
            case 1:
            case 7:
            case 8:
            case 9:
            case 25:

            $content = "SELECT db_farmers.id,db_farmers.name,db_farmers.parent_id,db_farmers.id_str,db_farmers.gender,nin,contact,education_level.name as education_level,km_language.name as main_language,parish.name as parish_name, subcounty.name as subcounty_name, county.name as county_name, district.name as district_name
            FROM db_farmers join parish on db_farmers.parish_id=parish.id join subcounty on parish.subcounty_id=subcounty.id join county on subcounty.county_id = county.id join district on county.district_id=district.id join education_level on db_farmers.education_level_id=education_level.id join km_language on db_farmers.main_language = km_language.id 
               WHERE subcounty.id =  ".$_SESSION['user']['location_id']." $add_group  ";

            break;

            default:
                $content ='';
                break;

        }


        return $content;
    }

    public static function getFarmers($group){



        $sql = database::performQuery(self::getFarmersByLocation($group));
               $rt =  '';
        if($sql->num_rows > 0){

        while($data=$sql->fetch_assoc()){

           
            // get enterprises 
            $g_id = $data['parent_id'];
            $f_id = $data['id'];
            $sql_e = ($g_id) ? "select name from entreprize_category where id in(select enterprise_id from farmer_group_enterprises where farmer_group_id=$g_id)" : "select name from entreprize_category where id in(select enterprise_id from farmers_enterprises where farmer_id=$f_id)";
            $ent_r = database::performQuery($sql_e);
            

            $rt .='<tr>                          <td><a href="">ID-'.$data['id'].'</a></td>
                                                <td><a href="">'.$data['name'].'</a> </td><td>';

                             while($edata = $ent_r->fetch_assoc()){
                                    $rt .=''.$edata['name'].',';
                             }                   
                                           $rt .='</td>
                                                <td>'.$data['gender'].'</td>
                                                <td>'.$data['contact'].'</td>
                                                <td>'.$data['education_level'].'</td>
                                                <td>'.$data['main_language'].'</td>
                                                <td>'.$data['parish_name'].'</td>
                                                <td>'.$data['subcounty_name'].' </td>
                                                <td>'.$data['district_name'].'</td>
                                                <td><a href="#">View on Map</td>
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
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>   
                    <td>None.</td>
                    </tr>';
        }

        return $rt;
    }

    public static function viewFarmers($group)
{
    $group_id = (!is_null($group)) ? $group : null;
    $group_name = "";
    if($group_id)
    {
        $sql_group = "select name from db_farmer_groups where id=$group limit 1";
        $r = database::performQuery($sql_group);
        
        if($r->num_rows > 0)
        {
            $g = $r->fetch_assoc();
            $group_name = " Group: ".$g['name'];
        }
    }
              $addd_btn = '<div class="col-lg-12">
                    <a href="' . ROOT . '/?action=addQuestion">
                    <button type="button" class="btn btn-success btn-rounded"><i class="fas fa-user-plus"></i> Add New Farmer</button>
                    </a>
                    <br />
                    <br />'.$group_name.'
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
                                                <th>Gender</th>
                                                <th>Tel</th>
                                                <th>Education</th>
                                                <th>Language</th>
                                                <th>Parish</th>
                                                <th>Subcounty</th>
                                                <th>District</th>                                                                                               
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getFarmers($group_id).'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <th>ID</th>                                                
                                                <th>Name</th>
                                                <th>Enterprises</th>
                                                <th>Gender</th>
                                                <th>Tel</th>
                                                <th>Education</th>
                                                <th>Language</th>
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
                </div>
                ';
        return $content;
    }
}