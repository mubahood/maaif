<?php 


class content{



    public static function countVillagesParish($id){
        $sql = database::performQuery("SELECT * FROM village WHERE parish_id=$id");

        return $sql->num_rows;

    }

    public static function getParish($id){
        $sql = database::performQuery("SELECT name FROM parish WHERE parish.id=$id");

        return $sql->fetch_assoc()['name'];

    }

    public static function getParishViallges($id){
        $sql = database::performQuery("SELECT name FROM village WHERE parish_id =$id");
        $use = [];
       while($data = $sql->fetch_assoc()){

           $use[] = '<small>'.$data['name'].'</small><br />';
       }

       return $use;

    }


    public static function myArea(){

        $res = subcounty::getSubCounty($_SESSION['user']['location_id']);

        $content = '
        
               <div class="table-scrollable table-scrollable-borderless">
                     <table class="table table-hover table-stripped table-condensed table-light">
                     
                     <tbody><tr><td><strong>Caledar Year :</strong> <small>'.date("Y").'</small></td></tr>
                     <tr><td><strong>District :</strong>  <small>'.$res['district'].'</small></td></tr>
                     <tr><td><strong>County :</strong> <small>'.$res['county'].'</small></td></tr>
                     <tr><td><strong>Sub-County :</strong> <small>'.$res['subcounty'].'</small></td></tr>
                     <tr><td><strong>No. Parishes :</strong> <small>'.self::countSubcountyParishes($_SESSION['user']['location_id']).'</small></td></tr>
                     <tr><td><strong>No. Villages :</strong> <small>'.self::countSubcountyVillages($_SESSION['user']['location_id']).'</small></td></tr>
                     </tbody></table>
                     
                     <hr />
        ';


        $res = subcounty::getSubCounty($_SESSION['user']['location_id']);

        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM ext_area_profile WHERE user_id=$id");
        if($sql->num_rows > 0) {
 
            $content .= '
        
        <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Parish</th>
                                                                                    <th> Villages</th>
                                                                                    <th> No. of Men</th>
                                                                                    <th> No. of Women</th>
                                                                                    <th> No. of Beneficiary Groups</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                           
                                                                          ';

            $x = 1;
            while($data=$sql->fetch_assoc()){


                $content .='<tr>
                                        <td>'.$x.'</td>
                                        <td><b>'.self::getParish($data['parish_id']).'</b> </td>
                                        <td>'.implode('',self::getParishViallges($data['parish_id'])).'</td>
                                        <td><b>'.$data['pop_males'].'</b></td>
                                        <td><b>'.$data['pop_females'].'</b></td>
                                        <td><b>'.$data['pop_ben_groups'].'</b></td>
                                        </tr>';
                $x++;
            }




            $content .='   
            
                                                                    </tbody>
                                                                        </table>
                                                                    </div>
        ';







        }
        else{


            $content .='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Set Area Profile</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">';










            $sql = database::performQuery("SELECT km_category.name FROM km_category,ext_popular
                                               WHERE km_category.id = ext_popular.km_category_id
                                               AND user_id=$id");


            $content .= '
        
        <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Parish</th>
                                                                                    <th> No. of Villages</th>
                                                                                    <th> No. of Men</th>
                                                                                    <th> No. of Women</th>
                                                                                    <th> No. of Beneficiary Groups</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                           
                                                                          ';

            $sql  = database::performQuery("SELECT parish.name as parish,parish.id FROM subcounty,parish
                                                  WHERE subcounty.id = parish.subcounty_id
                                                   AND subcounty.id =  ".$_SESSION['user']['location_id']);
            $x = 1;
            while($data=$sql->fetch_assoc()){


                $content .='<tr>
                                        <td>'.$x.'</td>
                                        <td><b> 
                                         <input type="hidden" name="parish_id[]" value="'.$data['id'].'"/>
                                        <input type="text" class="form-control" name="parish_name[]"   value="'.$data['parish'].'" disabled> </b></td>
                                        <td><b><input type="text" class="form-control" name="village_count[]"  value="'.self::countVillagesParish($data['id']).'" disabled> </b></td>
                                        <td><div class="form-group"> <input type="text" class="form-control" name="men[]" placeholder="">   </div></td>
                                        <td><div class="form-group"> <input type="text" class="form-control" name="women[]" placeholder="">   </div></td>
                                        <td><div class="form-group"> <input type="text" class="form-control" name="group[]" placeholder="">   </div></td>
                                        </tr>';
                $x++;
            }




            $content .='   
                   <tr>
                   
                   <td colspan="6">
                   
                    <div class="form-actions">
                                        <div class="card-body">
                                           
                                            <input type="hidden" name="user_id" value="'.$_SESSION['user']['id'].'"/>
                                            <input type="hidden" name="action" value="processAreaProfileNew"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Set My Area Profile</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
                                        </div>
                                    </div>
                   
</td>
</tr>
                                                                    </tbody>
                                                                        </table>
                                                                    </div>
        ';









            $content .='    <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';
        }























        return $content;
    }

    public static function countSubcountyParishes($id){
        $sql = database::performQuery("SELECT * FROM parish WHERE subcounty_id=$id");
        return $sql->num_rows;
    }


    public static function countSubcountyVillages($id){
        $sql = database::performQuery("SELECT * FROM parish,village WHERE subcounty_id=$id
        AND parish.id = village.parish_id");
        return $sql->num_rows;
    }


    public static function annualObjectives(){




        $id = 0;
        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM   `ext_objectives_annual` WHERE user_id=$id");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
        while($data=$sql->fetch_assoc()) {

            $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td>'.$data['objective'].'</td>
                        </tr>
                                                                           
                        ';

            $x++;
             }
        }
        else
            $contentz = '<tr><td></td><td>None.</td></tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Objective</th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }


public static function getActivityName($id){


    $sql = database::performQuery("SELECT * FROM `ext_activitys`
                                                 WHERE id=$id
                                                 ");
    if($sql->num_rows < 1)
    return ['name'=>'None'];
    else
    return $data = $sql->fetch_assoc();
}

 public static function annualActivities(){




        $id = 0;
        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM   `ext_area_annual_activity` WHERE user_id=$id");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
        while($data=$sql->fetch_assoc()) {

            $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td>'.self::getActivityName($data['activity'])['name'].'</td>
                              <td> '.$data['num_planned'].'</td>
                               <td> '.$data['num_target_ben'] .'</td>
                        </tr>
                                                                           
                        ';

            $x++;
             }
        }
        else
            $contentz = '<tr><td></td><td>None.</td><td>None.</td><td>None.</td></tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Activity</th>
                                                                                    <th> Planned No.</th>
                                                                                    <th> Target Beneficiaries</th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }




    public static function getActivityNameWithAnnualID($id){
        $sql = database::performQuery("
                                                 
                                               SELECT ext_activitys.id, ext_activitys.name FROM `ext_area_quaterly_activity`,
                                               ext_area_annual_activity,ext_activitys WHERE ext_activitys.id = ext_area_annual_activity.activity 
                                               AND ext_area_annual_activity.id = ext_area_quaterly_activity.annual_id ANd 
                                               ext_area_quaterly_activity.id =$id  
                                                 
                                                 
                                                 ");

        return $data = $sql->fetch_assoc();
    }


    public static function getActivityNameWithAnnualID2($id){
        $sql = database::performQuery("
                                                 
                                               SELECT ext_activitys.id, ext_activitys.name FROM `ext_area_quaterly_activity`,
                                               ext_area_annual_activity,ext_activitys WHERE ext_activitys.id = ext_area_annual_activity.activity 
                                               AND ext_area_annual_activity.id = ext_area_quaterly_activity.annual_id ANd 
                                               annual_id =$id  
                                                 
                                                 
                                                 ");

        return $data = $sql->fetch_assoc();
    }



    public static function quarterlyActivities(){




        $id = 0;
        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE user_id=$id ORDER BY  id DESC,quarter DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td>'.self::getActivityName($data['annual_id'])['name'].'<br />
                              <b style="font-size:10px">Topics</b>
                          <ul style="font-size:12px">                          
                          '.user::getTopicsListed($data['topic']).'
                             
                             </td>
                              <td> <ul style="font-size:12px">                          
                          '.user::getEntListed($data['entreprizes']).'
                          </ul></td>
                              <td> '.$data['num_planned'].'</td>
                               <td> '.$data['num_target_ben'] .'</td>
                               <td> Q'.$data['quarter'] .'</td>
                               <td> '.number_format($data['budget']) .'/=</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Activity& Topics</th>
                                                                                    <th> Entreprize(s)</th>
                                                                                    <th> Planned No.</th>
                                                                                    <th> Beneficiaries</th>
                                                                                    <th>Quarter</th>
                                                                                    <th>Budget</th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }



    public static function countNumberCarriedOut($id,$user_id){


        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE quarterly_activity_id LIKE '$id' AND user_id LIKE '$user_id' ");
        return $sql->num_rows;

    }


    public static function countBeneficiaeriesReached($id,$user_id){

        $sql = database::performQuery("SELECT SUM(num_ben_total) as tot FROM `ext_area_daily_activity` WHERE quarterly_activity_id LIKE '$id'  AND user_id LIKE '$user_id' ");
        return $sql->fetch_assoc()['tot'];

    }

    public static function viewaEvaluationReport(){


            $user_id = $_REQUEST['user_id'];




        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE user_id=$user_id ORDER BY  id DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $to = $data['num_planned'];
              $now =  self::countNumberCarriedOut($data['annual_id'],$user_id);
              $perCarried = ($now/$to)* 100;
              if($perCarried>100)
                  $perCarried = 100;

             //   $pri = 'black';
                  if($perCarried < 50){
                     $pri = 'red';
                  }
                 else if($perCarried > 49 && $perCarried < 80){
                      $pri = '#f7bf18';
                  }

                else if($perCarried > 80){
                      $pri = 'green';
                }



                   $tob = $data['num_target_ben'];


              $nowb =  self::countBeneficiaeriesReached($data['annual_id'],$user_id);
              if($nowb ==0  || $tob == 0)
                  $perCarriedb = 0;

              else
              $perCarriedb = ($nowb/$tob)* 100;

                if($perCarriedb>100)
                    $perCarriedb = 100;

                $prib = 'black';
                  if($perCarriedb < 50){
                     $prib = 'red';
                  }
                 else if($perCarriedb > 49 && $perCarriedb < 80){
                      $prib = '#f7bf18';
                  }

                else if($perCarriedb > 80){
                      $prib = 'green';
                }


                $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td>'.self::getActivityName($data['annual_id'])['name'].'</td>
                              <td> '.$data['num_planned'].'</td>
                               <td> '.$data['num_target_ben'] .'</td>
                               <td>'.self::countNumberCarriedOut($data['annual_id'],$user_id).' </td>
                               <td style="background: '.$pri.';color:#FFF">'. round($perCarried,2).'%</td>
                               <td> '.self::countBeneficiaeriesReached($data['annual_id'],$user_id).' </td>
                               <td style="background: '.$prib.';color:#FFF">'. round($perCarriedb,2).'%</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             </tr>';



        $content .=' 
 
 <div class="row">
 '.user::evaluationDateFilter().'
 
</div>
 
  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Activity</th>
                                                                                    <th> Planned No.</th>
                                                                                    <th> Target Beneficiaries</th>
                                                                                    <th>No. Carried Out</th>
                                                                                    <th>% Carried Out</th>
                                                                                    <th>Beneficiaries Reached</th>
                                                                                    <th>% Beneficiaries Reached</th>
                                                                                    <th></th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }


    public static function viewaEvaluationReportId($id){

        $id = 0;
        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE user_id=$id ORDER BY  id DESC,quarter DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $to = $data['num_planned'];
                $now =  self::countNumberCarriedOut($data['id']);
                $perCarried = ($now/$to)* 100;

                $pri = '';
                if($perCarried < 50){
                    $pri = 'red';
                }
                else if($perCarried > 49 && $perCarried < 80){
                    $pri = '#f7bf18';
                }

                else if($perCarried > 80){
                    $pri = 'green';
                }

                $tob = $data['num_target_ben'];
                $nowb =  self::countBeneficiaeriesReached($data['id']);
                $perCarriedb = ($nowb/$tob)* 100;

                $prib = '';
                if($perCarriedb < 50){
                    $prib = 'red';
                }
                else if($perCarriedb > 49 && $perCarriedb < 80){
                    $prib = '#f7bf18';
                }

                else if($perCarriedb > 80){
                    $prib = 'green';
                }


                $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td>'.self::getActivityNameWithAnnualID2($data['annual_id'])['name'].'</td>
                              <td> '.$data['num_planned'].'</td>
                               <td> '.$data['num_target_ben'] .'</td>
                               <td>'.self::countNumberCarriedOut($data['id']).' </td>
                               <td style="background:'.$pri.';color:#FFF">'. round($perCarried,2).'%</td>
                               <td> '.self::countBeneficiaeriesReached($data['id']).' </td>
                               <td style="background:'.$prib.';color:#FFF">'. round($perCarriedb,2).'%</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Activity</th>
                                                                                    <th> Planned No.</th>
                                                                                    <th> Target Beneficiaries</th>
                                                                                    <th>No. Carried Out</th>
                                                                                    <th>% Carried Out</th>
                                                                                    <th>Beneficiaries Reached</th>
                                                                                    <th>% Beneficiaries Reached</th>
                                                                                    <th></th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }

    public static function viewaEvaluationReportSimple(){


            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM `ext_area_quaterly_activity` WHERE user_id=$id ORDER BY  id DESC,quarter DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $to = $data['num_planned'];
                $now =  self::countNumberCarriedOut($data['annual_id'],$id);
                $perCarried = ($now/$to)* 100;

                $pri = '';
                if($perCarried < 50){
                    $pri = 'red';
                }
                else if($perCarried > 49 && $perCarried < 80){
                    $pri = '#f7bf18';
                }

                else if($perCarried > 80){
                    $pri = 'green';
                }


                $tob = $data['num_target_ben'];
                $nowb =  self::countBeneficiaeriesReached($data['annual_id'],$id);
                $perCarriedb = 0;
                if(($tob != 0) && ($nowb != 0))
                $perCarriedb = ($nowb/$tob)* 100;

                $prib = '';
                if($perCarriedb < 50){
                    $prib = 'red';
                }
                else if($perCarriedb > 49 && $perCarriedb < 80){
                    $prib = '#f7bf18';
                }

                else if($perCarriedb > 80){
                    $prib = 'green';
                }


                $contentz .= '
        
                        <tr>
                             <td>'.self::getActivityName($data['annual_id'])['name'].'</td>
                               <td>'.self::countNumberCarriedOut($data['annual_id'],$id).' </td>
                               <td style="background: '.$pri.';color:#FFF">'. round($perCarried,2).'%</td>
                               <td> '.self::countBeneficiaeriesReached($data['annual_id'],$id).' </td>
                               <td style="background: '.$prib.';color:#FFF">'. round($perCarriedb,2).'%</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
         
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> Activity</th>
                                                                                    <th> Carried Out</th>
                                                                                    <th>% Carried Out</th>
                                                                                    <th>Beneficiaries Reached</th>
                                                                                    <th>% Beneficiaries Reached</th>
                                                                                    <th></th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }





    public static function getTopicName($id){
        $sql = database::performQuery("SELECT name FROM ext_topics WHERE id=$id");
        $ret = $sql->fetch_assoc();
        if($sql->num_rows < 1)
            return 'None';
        else
            return $ret['name'];
    }
    public static function getEntreprizeName($id){

        $sql = database::performQuery("SELECT name FROM km_category WHERE id=$id");
        $ret = $sql->fetch_assoc();

        if($sql->num_rows < 1)
            return 'None';
        else
            return $ret['name'];
    }
    public static function getVillageName($id){
        $sql = database::performQuery("SELECT name FROM village WHERE id=$id");
        $ret = $sql->fetch_assoc();

        if($sql->num_rows < 1)
            return 'None';
        else
            return $ret['name'];
    }





    public static function getActivityUsingQuarterlyID($id){

        $sql = database::performQuery("SELECT * FROM ext_activitys WHERE id=$id LIMIT 1");

        if($sql->num_rows > 0){

            while($data = $sql->fetch_assoc()){

                return $data['id'];
             }

        }
        else
            return 52;




     }

    public static function getActivityUsingQuarterlyIDOLD($id){
        $sql = database::performQuery("SELECT * FROM ext_area_quaterly_activity WHERE id=$id LIMIT 1");

        if($sql->num_rows > 0){

            while($data = $sql->fetch_assoc()){

                return $data['annual_id'];
             }

        }
        else
            return 52;




     }
    public static function dailyActivities($limit = 100){

        if(isset($_REQUEST['user_id'])){
            $id = $_REQUEST['user_id'];
        }
        else{
            $id = $_SESSION['user']['id'];
        }




        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE user_id=$id ORDER BY  id DESC LIMIT $limit");
        $content ='';
        $contentz = '';




        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $idk =  self::getActivityUsingQuarterlyID($data['quarterly_activity_id']);



                $contentz .= '
        
                        <tr>
                            <td> '.date("Y/m/d",strtotime($data['date'])) .'</td>
                             <td>'.self::getActivityName($idk)['name'].'</td>
                             <td> '.self::getVillageName($data['village_id']) .'</td>
                             ';
                if (!dashboard::checkIfMAAIFAdminAccount()){
                $contentz .= ' <td>    
  
  
  <a href="'.ROOT.'/?action=addActivityImages&id='.$data['id'] .'"> 
 <button type="button" class="btn btn-success btn-xs"><i class="far fa-image"></i> Attach Image</button></a>

                                </td>';
                }


                $contentz .= ' <td>    
                             
                           <a href="'.ROOT.'/?action=viewDailyActivity&id='.$data['id'] .'">
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View</button>
                             </a>      
</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             
            
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> Date</th>
                                                                                    <th> Activity</th>
                                                                                    <th> Village</th>
                                                                                    <th></th>
                                                                                   
                                                                                    
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }




    public static function getDistrictHQsCoordinates($id){

        $sql = database::performQuery("SELECT * FROM district_hqs_geo WHERE district_id=$id");
        if($sql->num_rows > 0){
            return $sql->fetch_assoc();
        }
        else
            return ['lat'=>'0.0','lng'=>'0.0'];

    }




    public static function latestDailyActivities($limit = 100,$user_id){


        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE user_id IN ($user_id) AND quarterly_activity_id NOT LIKE '' AND DATE(date) BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_to]'   ORDER BY  id DESC LIMIT $limit");
        $content ='';
        $contentz = '';




        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $idk =  self::getActivityUsingQuarterlyID($data['quarterly_activity_id']);

                $user = user::getUserDetails($data['user_id']);



                $distict_id = $_SESSION['user']['district_id'];

                $district_coordinates = self::getDistrictHQsCoordinates($distict_id);


                if($data['gps_latitude']==0.0 || $data['gps_longitude']==0.0)
                {
                    $distance = 'No GPS Provided';
                }
                else{
                    $distance = round(haversineGreatCircleDistance($district_coordinates['lat'],$district_coordinates['lng'],$data['gps_latitude'],$data['gps_longitude']),2).'Km';
                }

               // echo '<br /><br />';

                $distance =

                $contentz .= '
        
                        <tr>
                            <td> '.date("Y/m/d",strtotime($data['date'])) .'</td>
                             <td>'.self::getActivityName($idk)['name'].'
                             <br />
                              '.self::getAnyActivityImage($data['id']).'
                              </td>
                             <td> '.self::getVillageName($data['village_id']) .'</td>
                             <td> '.$data['num_ben_total'] .'</td>
                             <td> '.$user['first_name'] .'  '.$user['last_name'] .'</td>
                             <td> '.user::getUserCategory($user['user_category_id']) .'</td>
                             <td> '.self::countActivityImages($data['id']) .'</td>
                             <td>'.$distance.'</td>
                            <td>  ';

                if($_SESSION['user']['id'] == $data['user_id'] ){
                $contentz .= '          <a href="'.ROOT.'/?action=addActivityImages&id='.$data['id'] .'"> 
 <button type="button" class="btn btn-success btn-xs"><i class="far fa-image"></i> Attach Image</button></a>
  &nbsp; &nbsp;';
                }

                             
               $contentz .= '            <a href="'.ROOT.'/?action=viewDailyActivity&id='.$data['id'] .'">
                      <button type="button" class="btn btn-default btn-rounded btn-xs"> View Daily Activity</button>
                             </a>      
</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             
            
             </tr>';



        $content .='  
  <div class="row">
  '.user::dailyActivitesDateFilter().'
</div>


<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                 <th> Date</th>
                                                                                    <th> Activity</th>
                                                                                    <th> Village</th>
                                                                                    <th> Beneficiaries</th>
                                                                                    <th> Officer</th>
                                                                                    <th> Category</th>
                                                                                    <th>No. Images</th>
                                                                                    <th>Proximmity <br />District HQs (Km)</th>
                                                                                    <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                            $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }



    public static function managelatestDailyActivities($limit = 50){

        $user_id = user::returnMyUserIDs();



        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE user_id IN ($user_id) ORDER BY  id DESC LIMIT $limit");
        $content ='';
        $contentz = '';






        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {


                $distict_id = $_SESSION['user']['district_id'];

               $district_coordinates = self::getDistrictHQsCoordinates($distict_id);


                if($data['gps_latitude']==0.0 || $data['gps_longitude']==0.0)
                {
                   $distance = 'No GPS Provided';
                }
                else{
                $distance = round(haversineGreatCircleDistance($district_coordinates['lat'],$district_coordinates['lng'],$data['gps_latitude'],$data['gps_longitude']),2);
                }
                $idk =  self::getActivityUsingQuarterlyID($data['quarterly_activity_id']);

                $user = user::getUserDetails($data['user_id']);

               // echo '<br /><br />';

                $contentz .= '
        
                        <tr>
                            <td> '.date("Y/m/d",strtotime($data['date'])) .'</td>
                             <td>'.self::getActivityName($idk)['name'].'</td>
                             <td> '.self::getVillageName($data['village_id']) .'</td>
                             <td> '.$data['num_ben_total'] .'</td>
                             <td> '.$user['first_name'] .'  '.$user['last_name'] .'</td>
                             <td> '.user::getUserCategory($user['user_category_id']) .'</td>
                            <td>    
                             
                           <a href="'.ROOT.'/?action=viewDailyActivity&id='.$data['id'] .'">
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View</button>
                             </a>      
</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             
            
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> Date</th>
                                                                                    <th> Activity</th>
                                                                                    <th> Village</th>
                                                                                    <th> Beneficiaries</th>
                                                                                    <th> Officer</th>
                                                                                    <th> Category</th>
                                                                                    <th></th>
                                                                                   
                                                                                    
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

                                        $content .='</tbody>
                                        <tfoot>
                                             <tr>
                                                 <th> Date</th>
                                                                                    <th> Activity</th>
                                                                                    <th> Village</th>
                                                                                    <th> Beneficiaries</th>
                                                                                    <th> Officer</th>
                                                                                    <th> Category</th>
                                                                                    <th>No. Images</th>
                                                                                     <th>Proximmity <br />District HQs(Km)</th>
                                                                                 
                                                                                    <th>Action</th>
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




    public static function topActivitiesOfficers($limit = 10){

        $user_id = user::returnMyUserIDs();

       $sql = "SELECT user_id,COUNT(*) as total FROM `ext_area_daily_activity` WHERE user_id IN ($user_id) GROUP BY user_id ORDER BY  total DESC LIMIT $limit";
       // echo $sql;
        $sql = database::performQuery($sql);
        $content ='';
        $contentz = '';




        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {


                $user = user::getUserDetails($data['user_id']);

                $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td> '.$user['first_name'] .'  '.$user['last_name'] .'</td>
                             <td> '.user::getUserCategory($user['user_category_id'] ).'</td>
                             <td> '.$data['total'] .'</td>
                            <td>                                
                           <a href="'.ROOT.'/?action=viewaDailyActivities&user_id='.$data['user_id'] .'">
                      <button type="button" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View Activties</button>
                             </a>      
</td>
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
             <td>None.</td>
                     
            
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No.</th>
                                                                                    <th> Name</th>
                                                                                    <th> Category</th>
                                                                                    <th> Activities</th>
                                                                                    <th> Action</th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }



    public static function topActivitiesDistrict($limit = 10){

        $user_id = user::returnMyUserIDs();

       $sql = "SELECT annual_id,COUNT(*) as total FROM `ext_area_daily_activity`,`ext_area_quaterly_activity`
               WHERE ext_area_daily_activity.user_id IN ($user_id) 
               AND ext_area_daily_activity.quarterly_activity_id =ext_area_quaterly_activity.id
               GROUP BY annual_id ORDER BY  total DESC LIMIT $limit";
        //echo $sql;
        $sql = database::performQuery($sql);
        $content ='';
        $contentz = '';




        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {


                //$user = user::getUserDetails($data['user_id']);

                $contentz .= '
        
                        <tr>
                            <td> '.$x .'</td>
                             <td> '.self::getActivityName($data['annual_id'] )['name'].'</td>
                             <td> '.$data['total'] .'</td>
                    
                        </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr>
             <td>1.</td>
             <td>None.</td>
             <td>None.</td>
             
             </tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No.</th>
                                                                                    <th> Name</th>
                                                                                    <th> Activities</th>
                                                                                    
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }



    public static function getLocationInformation($village_id){
        $sql = database::performQuery("SELECT district.name as district, county.name as county, subcounty.name as subcounty, parish.name as parish, village.name as village
         FROM district,county,subcounty,parish,village
         WHERE district.id = county.district_id
         AND county.id = subcounty.county_id
         AND subcounty.id = parish.subcounty_id
         AND parish.id = village.parish_id
         AND village.id = $village_id");

        return $sql->fetch_assoc();

    }


    public static function viewDailyActivitys(){




        $id = 0;
        if(isset($_REQUEST['id']))
            $id = $_REQUEST['id'];
        else
            redirect_to(ROOT.'/');

        $sqli = database::performQuery("SELECT * FROM `ext_area_daily_activity_image` WHERE activity_id=$id ORDER BY  id DESC");
        $images = 'No Images attached.';
        if($sqli->num_rows > 0){
            $show =[];
        while($datai=$sqli->fetch_assoc()){

           $show[] = "<img src='".ROOT."/$datai[url]'> &nbsp;&nbsp;&nbsp;";
        }
           $images = implode(' &nbsp;',$show);


        }

        $sql = database::performQuery("SELECT * FROM `ext_area_daily_activity` WHERE id=$id ORDER BY  id DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {
              $location = self::getLocationInformation($data['village_id']);
                $contentz .= '
        
                         <tr><td colspan="2"><h3>Activity Details</h3></td> <td colspan="2">
                         <form method="POST">
                         <input type="hidden" name="id" value="'.$id.'" />
                         <input type="hidden" name="action" value="deleteDailyActivityReport"/>
                         <button type="submit">Delete Activity</button>
                         </form></td>
                         </tr>
                              <tr> <td style="font-weight: bold;"> Actvity ID : </td> <td> <a href="">'.$data['id'] .'</a></td></tr>
                              <tr> <td style="font-weight: bold;">Date Carried Out: </td> <td> '.date("Y/m/d",strtotime($data['date'])) .'</td></tr> 
                              <tr> <td style="font-weight: bold;">Activity Carried Out: </td> <td>'.self::getActivityName(self::getActivityUsingQuarterlyID($data['quarterly_activity_id']))['name'].'</td></tr>
                              <tr> <td style="font-weight: bold;">Topic Covered</td> <td> '.self::getTopicName($data['topic']).'</td></tr>
                              <tr> <td style="font-weight: bold;">Entreprize Covered: </td> <td> '.self::getEntreprizeName($data['entreprise']) .'</td></tr>
                             <tr><td colspan="2"><h3>Beneficiaries Reached </h3></td></tr>
                              <tr> <td style="font-weight: bold;">Women Beneficiaries:</td> <td> '.$data['num_ben_females'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Men Beneficiaries:</td> <td> '.$data['num_ben_males'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Total Beneficiaries:</td> <td> '.$data['num_ben_total'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Beneficiary Group:</td> <td> '.$data['ben_group'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Reference Name:</td> <td> '.$data['ben_ref_name'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Reference Contact:</td> <td> '.$data['ben_ref_phone'] .'</td></tr>
                               <tr><td colspan="2"><h3>Location Details</h3></td></tr>
                              <tr> <td style="font-weight: bold;">Village :</td> <td> '.self::getVillageName($data['village_id']) .'</td></tr>
                              <tr> <td style="font-weight: bold;">Parish :</td> <td> '.$location['parish'] .'</td></tr>
                              <tr> <td style="font-weight: bold;">Subcounty :</td> <td> '.$location['subcounty'].'</td></tr>
                              <tr> <td style="font-weight: bold;">County :</td> <td> '.$location['county'].'</td></tr>
                              <tr> <td style="font-weight: bold;">District :</td> <td> '.$location['district'] .'</td></tr>
<tr><td colspan="2"><h3>Activity Details</h3></td></tr>';

                                if(!empty($data['financial_year'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Financial Year: </td> <td> '.$data['financial_year'] .'</td></tr> ';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Financial Year: </td> <td></td></tr> ';
                                }

                                if(!empty($data['quarter'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Quarter: </td> <td> Quarter '.$data['quarter'] .'</td></tr>';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Quarter: </td> <td> Quarter</td></tr> ';
                                }

                                if(!empty($data['challenges'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Challenges: </td> <td> '.$data['challenges'] .'</td></tr> ';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Challenges: </td> <td> '.$data['challenges'] .'</td></tr> ';
                                }

                                if(!empty($data['lessons'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Lessons: </td> <td> '.$data['lessons'] .'</td></tr> ';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Lessons: </td> <td></td></tr> ';
                                }

                                if(!empty($data['recommendations'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Recommendations: </td> <td> '.$data['recommendations'] .'</td></tr> ';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Recommendations: </td> <td></td></tr> ';
                                }

                                if(!empty($data['description'])){
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Activity Description: </td> <td> '.$data['description'] .'</td></tr>  ';
                                }
                                else{
                                    $contentz   .= '<tr> <td style="font-weight: bold;">Description: </td> <td></td></tr> ';
                                }
                            	$contentz .= '
                                <tr><td colspan="2"><h3>Location Map</h3></td></tr>        
                              <tr> <td style="font-weight: bold;">Position:</td> <td> '.$data['gps_latitude'].','.$data['gps_longitude'].'</td></tr>
                                 <tr><td><div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="450" id="gmap_canvas" src="https://maps.google.com/maps?q='.$data['gps_latitude'].'%2C'.$data['gps_longitude'].'&t=k&z=16&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net"></a></div><style>.mapouter{text-align:right;height:350px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:350px;width:600px;}</style></div>
                                              </td></tr>
                                                                    
                                <tr><td colspan="2"><h3>Activity Images:</h3></td></tr>  
                                
                                  <tr><td colspan="2">
                                  
                                  '.$images.'
                                  
                                  
</td></tr>                                           
                        ';

                $x++;
            }
        }



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                
                                                                            </thead>
                                                                            <tbody style="font-size:14px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;
    }




    public static function addActivityImages(){

        $content = '
<div class="row">
                        <div class="col-md-12">

<div class="block">
                             
                                <div class="block-content">
                         <form enctype="multipart/form-data" method="post" action="">
                      
                        <div class="form-group row">  <label class="col-12"> Image 1</label>
                                                                <div class="col-8">
                                                                    <div class="custom-file">
                                                                        <input type="file" name="fileToUpload">
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                        
                                     <input type="hidden" name="id" value="'.$_REQUEST['id'].'" />
                                     <input type="hidden" name="action" value="processDailyActivityImages" />
                    
                                     <div class="form-group row">    <div class="col-12">
                                                                    <button type="submit" class="btn btn-alt-success">Submit</button>
                                                                </div>
                                                            </div>
                        
                      </form>
                      
  </div>
  </div>
  </div>
  </div>
  
  
  ';


        return $content;

    }




    public static function processDailyActivityImages(){


        if ($_FILES['fileToUpload']['error'] > 0) {
            echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
        } else {
            // array of valid extensions
            $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
            // get extension of the uploaded file
            $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($fileExtension, $validExtensions)) {
                $newNamePrefix = time() . '_';
                $manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
                // resizing to 750X400
                $newImage = $manipulator->resample(650, 350);

                 $year = date("Y");
                 $month = date("m");
                 $path = 'images/field/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['fileToUpload']['name'];
                 //$path2 = '../aais-ug.site/e-diary/images/field/'.$year.'/'.$month.'/' . $newNamePrefix . $_FILES['fileToUpload']['name'];
                // saving file to uploads folder
                $manipulator->save($path);
 //               $manipulator->save($path2);
//                echo 'Hooray ... Uploaded<br />';
//                echo'Path is '.$path;
                $id = $_REQUEST['id'];
                $sql = database::performQuery("INSERT INTO ext_area_daily_activity_image(url,activity_id)  VALUES('$path',$id)");

                redirect_to(ROOT.'/?action=viewDailyActivity&id='.$id);

            } else {
                echo 'You must upload an image...';
                redirect_to($_SERVER['HTTP_REFERER']);
            }
        }

    }



    public static function viewDailyActivity(){}
    public static function trashDailyActivity($id){

        $sql = database::performQuery("DELETE  FROM ext_area_daily_activity WHERE id=$id");


        redirect_to(ROOT.'/?action=viewaDailyActivities');

    }



    public static function potential(){

        $res = subcounty::getSubCounty($_SESSION['user']['location_id']);




        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM ext_potenial WHERE user_id=$id");
        if($sql->num_rows > 0){

          $sql = database::performQuery("SELECT km_category.name FROM km_category,ext_potenial
                                               WHERE km_category.id = ext_potenial.km_category_id
                                               AND user_id=$id");


            $content = '
        
        <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Entreprize</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                           
                                                                          ';


                                $x = 1;
                                while($data=$sql->fetch_assoc()){


                                    $content .='<tr>
                                        <td>'.$x.'</td>
                                        <td>'.$data['name'].'</td>
                                        </tr>';
                                              $x++;
                                }



                                                                           
                      $content .='                                                        </tbody>
                                                                        </table>
                                                                    </div>
        ';




        }
        else{

            $entt = user::getListofEnterprizes();

            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Set Area Potential Entreprizes</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                           
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"> Select Multiple Entreprizes</label>
                                                    
                                                    <select class="form-control custom-select select2" multiple="multiple" name="entreprize_id[]"  style="height: 36px;width: 100%;">
                                                     
                                                      '.$entt.'
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                     
                                         
                                           
                                           
                                     
                                         
                                        
                                      
                                            
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="user_id" value="'.$_SESSION['user']['id'].'"/>
                                            <input type="hidden" name="action" value="processPotentialEnt"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Potential Entreprizes</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
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

    public static function popular(){

        $res = subcounty::getSubCounty($_SESSION['user']['location_id']);




        $id = $_SESSION['user']['id'];
        $sql = database::performQuery("SELECT * FROM ext_popular WHERE user_id=$id");
        if($sql->num_rows > 0){

            $sql = database::performQuery("SELECT km_category.name FROM km_category,ext_popular
                                               WHERE km_category.id = ext_popular.km_category_id
                                               AND user_id=$id");


            $content = '
        
        <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                    <th> No. </th>
                                                                                    <th> Entreprize</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                           
                                                                          ';


            $x = 1;
            while($data=$sql->fetch_assoc()){


                $content .='<tr>
                                        <td>'.$x.'</td>
                                        <td>'.$data['name'].'</td>
                                        </tr>';
                $x++;
            }




            $content .='                                                        </tbody>
                                                                        </table>
                                                                    </div>
        ';




        }
        else{

            $entt = user::getListofEnterprizes();

            $content ='<div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Set Area Popular Entreprizes</h4>
                            </div>
                            <form action="" method="POST" >
                              
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row p-t-20">
                                           
                                            
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"> Select Multiple Entreprizes </label>
                                                    
                                                    <select class="form-control custom-select select2" multiple="multiple"  name="entreprize_id[]" style="height: 36px;width: 100%;">
                                                       '.$entt.'
                                                       
                                                    </select>
                                                    
                                                     </div>
                                            </div>
                                            
                                              
                                             
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        
                                        <!--/row-->                            
                                        
                                    </div>
                                    <hr>
                                    <div class="form-actions">
                                        <div class="card-body">
                                            <input type="hidden" name="user_id" value="'.$_SESSION['user']['id'].'"/>
                                            <input type="hidden" name="action" value="processPopularEnt"/>
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Add Popular Entreprizes</button>
                                            <button type="reset" class="btn btn-dark">Cancel</button>
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


    public static function areaoutputs(){






        $id = 0;
        if(isset($_REQUEST['user_id']))
            $id = $_REQUEST['user_id'];
        else
            $id = $_SESSION['user']['id'];

        $sql = database::performQuery("SELECT * FROM   `ext_quarterly_output` WHERE user_id=$id ORDER BY year DESC,quater DESC");
        $content ='';
        $contentz = '';
        if($sql->num_rows > 0){
            $x = 1;
            while($data=$sql->fetch_assoc()) {

                $contentz .= '
        
                      
                        
                         <tr>
                           <td> '.$x .' </td>
                           <td> '.$data['year'] .' </td>
                            <td><a href=""> Q'.$data['quater'].' </a></td>
                                <td><ul>
                                <li>'.$data['key_outputs'].'</li>
                                </ul> </td>
                                <td> <ul>
                                <li>'.$data['key_indicators'].'</li>
                                </ul> </td>
                                
                            </tr>
                                                                           
                        ';

                $x++;
            }
        }
        else
            $contentz = '<tr><td>1.</td><td>None.</td><td>None.</td><td>None.</td><td>None.</td></tr>';



        $content .='  <div class="table-scrollable table-scrollable-borderless">
                                                                        <table class="table table-hover table-stripped table-condensed table-light">
                                                                            <thead>
                                                                                <tr class="uppercase">
                                                                                   <th> No. </th>
                                                                                   <th> Year </th>
                                                                                    <th>Quater </th>
                                                                                    <th>Key OutPuts </th>
                                                                                    <th>Key Indicators</th>
                                                                                   
                                                                                     </tr>
                                                                            </thead>
                                                                            <tbody style="font-size:12px">
                                                                            ';
        $content .= $contentz;

        $content .='   </tbody>
                                                                        </table>
                                                                    </div>';


        return $content;


    }



    //Get Random 20 Districts with their school count for the footer menu.
    public static function home(){

        $content = '<h3>Welcome, '.$_SESSION['user']['first_name'].'  '.$_SESSION['user']['last_name'].' (<small>'.user::getUserCategory($_SESSION['user']['user_category_id']).'</small>)</h3>';

        $content .='<!-- Row -->
                <div class="row">
                    <div class="col-12">
                        
                        <p class="text-muted m-t-0">Search by Module</p>
                        <!-- Row -->
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/diary.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">E-Diary</h4>
                                        <p class="card-text">Manage daily Activities, View evaluation reports and much more.</p>
                                        ';
        if(dashboard::checkIfAdminAccount()){
        $content .=' <a href="#" class="btn btn-success">Enter Here</a>';
        } else {
        $content .=' <a href="'.ROOT.'/?action=viewaDailyActivities&user_id='.$_SESSION['user']['id'].'" class="btn btn-success">Enter Here</a>';
        }
        $content .='    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                             <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/court.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">E-GRM</h4>
                                        <p class="card-text">Manage grievances, View grievance reports and much more.</p>
                                        <a href="'.ROOT.'/?action=viewaGRMGrievance" class="btn btn-success">Enter Here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                            
                            <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/profiling.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">Profiling</h4>
                                        <p class="card-text">Manage profiles for farmers, farmer groups and much more.</p>
                                        <a href="'.ROOT.'/?action=viewFarmers" class="btn btn-success">Enter Here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                            <!-- column -->
                            <div class="col-lg-3 col-md-6 img-responsive">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/weather.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">Weather Information</h4>
                                        <p class="card-text">View weather information for different locations in Uganda </p>
                                        <a href="'.ROOT.'/?action=getWeatherAdvisory" class="btn btn-success">Enter Here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                        </div>
                        
                        <div class="row">
                           
                            <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/advisory.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">E-Advisory</h4>
                                        <p class="card-text">Manage advisory, View advisory reports and much more.</p>
                                        <a href="'.ROOT.'/?action=viewQuestions" class="btn btn-success">Enter Here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                            <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/kmu.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">Knowledge Management </h4>
                                        <p class="card-text">Manage knowledge units, approve units and much more.</p>
                                        <a href="'.ROOT.'/?action=manageKMU" class="btn btn-success">Enter Here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                            
                            <!-- column -->
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/outbreak.svg" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">Outbreaks and Crises</h4>
                                        <p class="card-text">Manage Outbreaks and Crises, follow up crises and much more.</p>
                                        <a href="'.ROOT.'/?action=getOutbreaksCrises" class="btn btn-success">Enter here</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                            <!-- column -->
                            <div class="col-lg-3 col-md-6 img-responsive">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" src="'.ROOT.'/images/modules/user.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">User Management</h4>
                                        <p class="card-text">Manage system users, district and subcounty users.</p>
                                           ';
        if(dashboard::checkIfAdminAccount()){
            $content .=' <a href="'.ROOT.'/?action=manageUsers" class="btn btn-success">Enter Here</a>';
        } else {
            $content .=' <a href="'.ROOT.'/?action=viewProfile" class="btn btn-success">Enter Here</a>';
        }
        $content .='   
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- column -->
                        </div>
                        
                        <!-- Row -->
                    </div>
                        
                </div>        
                        
                        
                        ';




        switch($_SESSION['user']['user_category_id'])
        {


            case 7:
            case 8:
            case 9:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
                $content .='   
    
                <!-- ============================================================== -->
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="far fa-calendar-check font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Activities Assigned</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.user::countAllUserActtivities().'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-female font-20  text-muted"></i>
                                            <p class="font-16 m-b-5">Women Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.user::countAllWomen().'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-male font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Men Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.user::countAllMen().'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-people-carry font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Total Beneficiaries </p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right"> '.user::countAllMenWomen().' </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> ';
                if($_SESSION['user']['user_category_id'] != 11)
                {
                $content .='<div><h3>My Latest Activities</h3></div>';
                $content .= self::dailyActivities(10);
                $content .= '<h3>My Evaluation Report</h3>';
                $content .= self::viewaEvaluationReportSimple();
                }
                break;



            case 1:
            case 2:
            case 3:
            case 4:
            case 10:
            case 11:
            case 12:
                $content .='   
    <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fa fa-users font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">My Officers</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.user::countAllMyOfficers().'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-female font-20  text-muted"></i>
                                            <p class="font-16 m-b-5">Women Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllWomenDistrict()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-male font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Men Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllMenDistrict()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-people-carry font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Total Beneficiaries</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllMenWomenDistrict()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                    <div class="row">
                        <div class="col-md-12">
                         <h4>Activities & Beneficiariees By Month </h4>
                        '.user::beneficiariesByMonth().'
                        </div>
                        
                       
                 </div> 
                 ';
            if($_SESSION['user']['user_category_id'] != 11 AND $_SESSION['user']['user_category_id'] !=1 )
            {
                $content .='<div><h3>My Latest Activities</h3></div>';
                $content .= self::dailyActivities(10);
                $content .= '<h3>My Evaluation Report</h3>';
                $content .= self::viewaEvaluationReportSimple();
            }
            break;

                break;
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


                $content .=' <div class="row"><div class="col-md-6"><h4>Activities by Location</h4>
                                                <div id="map"></div></div>
                                                <div class="col-md-6">
                                                <br />
                                                <h4>Total Beneficiaries Reached</h4>
                                                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fa fa-users font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">My Officers</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.user::countAllMyOfficersNational().'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-female font-20  text-muted"></i>
                                            <p class="font-16 m-b-5">Women Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllWomenNational()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    </div>
                    <br />
                    <br />
                     <div class="card-group">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-male font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Men Reached</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllMenNational()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <i class="fas fa-people-carry font-20 text-muted"></i>
                                            <p class="font-16 m-b-5">Total Beneficiaries</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h1 class="font-light text-right">'.number_format(user::countAllMenWomenNational()).'</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                
                                                  </div>
                                                </div>
                                                
                                                 <div class="row">
                        <div class="col-md-12">
                         <h4>Activities & Beneficiariees By Month </h4>
                        '.user::beneficiariesByMonth().'
                        </div>
                                                
                                                  ';
                break;

            default:
                $content .= '';



                break;


        }



      return $content;
    
    }

    public static function NoActivityYet(){

        $content = '<h3>No activities have been added for you yet. Meet your supervisor to set this up  or add and unplaned activity by clicking the button below. </h3>';
        $content .='<br /><br /><a href="'.ROOT.'/?action=addUnplannedActivity"><button class="btn  btn-info">Add Unplanned Actvity</button></a>';



      return $content;

    }


    public static function homeExtra(){
        $content = '
      
    
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
               
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Latest Activities</h4>
                            </div>
                            <div class="comment-widgets scrollable" style="height:430px;">
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2">
                                        <img src="'.ROOT.'/includes/theme/assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">James Anderson</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-rounded label-primary">Pending</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-check"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <img src="'.ROOT.'/includes/theme/assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle">
                                    </div>
                                    <div class="comment-text active w-100">
                                        <h6 class="font-medium">Michael Jorden</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer ">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-success label-rounded">Approved</span>
                                            <span class="action-icons active">
                                                <a href="javascript:void(0)">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="icon-close"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-heart text-danger"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <img src="'.ROOT.'/includes/theme/assets/images/users/5.jpg" alt="user" width="50" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">Johnathan Doeting</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-rounded label-danger">Rejected</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-check"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2">
                                        <img src="'.ROOT.'/includes/theme/assets/images/users/2.jpg" alt="user" width="50" class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">Steve Jobs</h6>
                                        <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">April 14, 2016</span>
                                            <span class="label label-rounded label-primary">Pending</span>
                                            <span class="action-icons">
                                                <a href="javascript:void(0)">
                                                    <i class="ti-pencil-alt"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-check"></i>
                                                </a>
                                                <a href="javascript:void(0)">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center p-b-15">
                                    <div>
                                        <h4 class="card-title m-b-0">Latest Feedback</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="dl">
                                            <select class="custom-select border-0 text-muted">
                                                <option value="0" selected="">August 2018</option>
                                                <option value="1">May 2018</option>
                                                <option value="2">March 2018</option>
                                                <option value="3">June 2018</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="todo-widget scrollable" style="height:422px;">
                                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label todo-label" for="customCheck">
                                                    <span class="todo-desc">Simply dummy text of the printing and typesetting</span> <span class="badge badge-pill badge-success float-right">Project</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label todo-label" for="customCheck1">
                                                    <span class="todo-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</span><span class="badge badge-pill badge-danger float-right">Project</span>
                                                </label>
                                            </div>
                                            
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label todo-label" for="customCheck2">
                                                    <span class="todo-desc">Ipsum is simply dummy text of the printing</span> <span class="badge badge-pill badge-info float-right">Project</span>
                                                </label>
                                            </div>
                                            
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                <label class="custom-control-label todo-label" for="customCheck3">
                                                    <span class="todo-desc">Simply dummy text of the printing and typesetting</span> <span class="badge badge-pill badge-info float-right">Project</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                <label class="custom-control-label todo-label" for="customCheck4">
                                                    <span class="todo-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.</span> <span class="badge badge-pill badge-purple float-right">Project</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                <label class="custom-control-label todo-label" for="customCheck5">
                                                    <span class="todo-desc">Ipsum is simply dummy text of the printing</span> <span class="badge badge-pill badge-success float-right">Project</span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item todo-item" data-role="task">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                <label class="custom-control-label todo-label" for="customCheck6">
                                                    <span class="todo-desc">Simply dummy text of the printing and typesetting</span> <span class="badge badge-pill badge-primary float-right">Project</span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
    
    
    
	   ';

        return $content;
    }

    public static function crops(){

        $content = '
      
       
	    <div class="row" data-auto-height="true">
      
      
                                      <div class="row">
                                           
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/maize.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Maize</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=12">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/rice.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Rice</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=13">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/cassava.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Cassava</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=21">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/coffee.png">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Coffee</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=64">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/beans.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Beans</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=44">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                           
                                            
                                            
                                           
    
                                        </div>
      
      
       </div>
       <!-- End Slider -->
      
       <div class="row">
      
         &nbsp;&nbsp;
      
       </div>
      
       
      
      
      
                                                <div>
                                                    
                                                </div>
                                                <!-- END GENERAL PORTLET-->
                                                <div>
                                               
                                                </div>
                                                <!-- BEGIN WELLS PORTLET-->
                                            
                                            </div>
         &nbsp;&nbsp;
      
       
      
     
    
    
	   ';

        return $content;

    }
    public static function livestock(){

        $content = '
      
       
	    <div class="row" data-auto-height="true">
      
      
                                      <div class="row">
                                           
                                           
                                            
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/cattle.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Cattle</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=78">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                           <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/chicken.jpg">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Chicken</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=87">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                           
                                             
    
    
                                        </div>
      
      
       </div>
       <!-- End Slider -->
      
       <div class="row">
      
         &nbsp;&nbsp;
      
       </div>
      
       
      
      
      
                                                <div>
                                                    <!-- BEGIN GENERAL PORTLET-->
                                                   
                                                </div>
                                                <!-- END GENERAL PORTLET-->
                                                <div>
                                               
                                                </div>
                                                <!-- BEGIN WELLS PORTLET-->
                                            
                                            </div>
         &nbsp;&nbsp;
      
        ';

        return $content;

    }
    public static function fish(){

        $content = '
      
       
	    <div class="row" data-auto-height="true">
      
      
                                      <div class="row">
                                           
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="portlet light portlet-fit ">
    
                                                    <div class="portlet-body">
                                                        <div class="mt-element-overlay">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mt-overlay-6">
                                                                        <img src="'.ROOT.'/images/tilapia.png">
                                                                        <div class="mt-overlay">
                                                                            <h2 style="font-size:14px">Tilapia</h2>
                                                                            <a class="mt-info" href="' . ROOT . '/?action=q&category=78">Browse all content.</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                          
                                           
                                             
    
    
                                        </div>
      
      
       </div>
       <!-- End Slider -->
      
       <div class="row">
      
         &nbsp;&nbsp;
      
       </div>
      
       
      
      
      
                                                <div>
                                                    
                                                </div>
                                                <!-- END GENERAL PORTLET-->
                                                <div>
                                               
                                                </div>
                                                <!-- BEGIN WELLS PORTLET-->
                                            
                                            </div>
         &nbsp;&nbsp;
      
    
    
	   ';

        return $content;

    }

    public static function getKMUVideo($id){

    $sql = database::performQuery("SELECT url FROM kmu_video WHERE kmu_id=$id");
    $sql_res = $sql->fetch_assoc();

    return $sql_res['url'];

    }

    public static function getLatestKMU(){

        $sql = database::performQuery("SELECT * FROM kmu ORDER BY id ASC LIMIT 3 ");
        $content = '';
        while($data=$sql->fetch_assoc()){


            $url = self::getKMUVideo($data['id']);


            $content .='<div class="col-md-4">
                                                            <div class="tile-container">
                                                                <div class="tile-thumbnail">
                                                                    <a href="javascript:;">
                                                                        <iframe id="ytplayer" type="text/html" width="640" height="360"
                                                                       src="'.str_replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/',$url).'?autoplay0=1&origin=http://aais.site"
                                                                       frameborder="0"></iframe>
                                                                    </a>
                                                                </div>
                                                                <div class="tile-title">
                                                                    <strong>
                                                                        <a href="javascript:;">'.substr($data['title'],0,45).'</a>
                                                                    </strong>
                                                                    
                                                                    <div class="tile-desc" style="margin-top: -15px">
                                                                        <p>Produced By:
                                                                            <a href="javascript:;">'.$data['produced_by'].'</a> <br />
                                                                            <span class="font-grey-salt">'.makeAgo(time(),$data['created'],1).' ago.</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
        }


        return $content;
    }
    
    
    
    public static function erro_404(){
    
        echo'
    
            <html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    
    <head>
        <meta charset="utf-8" />
        <title>Metronic | 404 Page Option 3</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="'.ROOT.'/includes/theme/zara/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="'.ROOT.'/includes/theme/zara/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="'.ROOT.'/includes/theme/zara/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="'.ROOT.'/includes/theme/zara/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="'.ROOT.'/includes/theme/zara/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="'.ROOT.'/includes/theme/zara/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="'.ROOT.'/includes/theme/zara/assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
    
    <body class=" page-404-3">
        <div class="page-inner">
            <img src="'.ROOT.'/includes/theme/zara/assets/pages/media/bg/4.jpg" class="img-responsive" alt=""> </div>
        <div class="container error-404">
            <h1>Error 404</h1>
            <h2>Houston, we have a problem.</h2>
            <p> Actually, the page you are looking for does not exist. </p>
            <p>
                <a href="'.ROOT.'" class="btn yellow-gold"> <i class="fa fa-home"></i> Return home </a>
                <br> </p>
        </div>
        <!--[if lt IE 9]>
<script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/respond.min.js"></script>
<script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="'.ROOT.'/includes/theme/zara/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="'.ROOT.'/includes/theme/zara/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>
    
</html>
    
            ';
    }



    
    

    public static function doListSearch(){
        $search = $_REQUEST;

        $region = '';
        if(isset($_REQUEST['region']))
            $region = $_REQUEST['region'];
        $subregion = '';
        if(isset($_REQUEST['subregion']))
            $subregion = $_REQUEST['subregion'];
        $district = '';
        if(isset($_REQUEST['district']))
            $district = $_REQUEST['district'];
        $subcounty = '';
        if(isset($_REQUEST['subcounty']))
            $subcounty = $_REQUEST['subcounty'];
        $parish = '';
        if(isset($_REQUEST['parish']))
            $parish = $_REQUEST['parish'];
        $name = '';
        if(isset($_REQUEST['name']))
            $name = $_REQUEST['name'];
        $category = '';
        if(isset($_REQUEST['category']))
            $category = $_REQUEST['category'];

        if(isset($_REQUEST['letter']))
            $letter = $_REQUEST['letter'];

        $search = new schoolList($region,$subregion,$district,$subcounty,$parish,$name,
            $category,$letter,
            $results_view='list',$results_order='nameASC');
       return  $search->doSearchAll();

    }



    public static function deleteDailyActivities(){

        $id = $_REQUEST['id'];

        $sql = database::performQuery("DELETE FROM ext_area_daily_activity WHERE id = $id");


        redirect_to(ROOT.'/?action=viewEvaluaton');

    }


    public static function getAnyActivityImage($id){
        $sql = database::performQuery("SELECT * FROM ext_area_daily_activity_image WHERE activity_id=$id ORDER BY RAND() LIMIT 1");
        if($sql->num_rows > 0){
            while($data=$sql->fetch_assoc()){
               return "<img src='".ROOT."/$data[url]' style='width:150px;border-radius: 5%'/>";
            }
        }
        else
        {
            return "";
        }
    }
    public static function countActivityImages($id){

        $sql = database::performQuery("SELECT * FROM ext_area_daily_activity_image WHERE activity_id=$id ");
        return $sql->num_rows;
    }



    public static function IrriTrackPrivacy(){
        $content = "

<h2>DATA PROTECTION AND PRIVACY NOTICE</h2>

<p>This Privacy Notice applies to the Ministry of Agriculture Aniamal Industry and Fisheries(MAAIF) IrriTrack and IrriTrack test apps accessed through the Google Play store and online via http://microirrigation.agriculture.go.ug/ and related services.

<h4>Data Controller</h4>

<p>The Personal Data Protection and Privacy Act, 2013 describes a data controller as a person who alone, jointly with other persons or in common with other persons or as a statutory duty determines the purposes for and the manner in which personal data is processed or is to be processed.

<p>The Ministry of Agriculture Aniamal Industry and Fisheries(MAAIF) is the data controller of personal data collected and processed through its website (www.nita.go.ug).

<h4>Types of personal data that we collect and process</h4>

<p>We collect your personal data if you chose to communicate with us through the ‘contact us’ web form. Here are the types of personal data we gather:

<p>Name
<p>E-mail address
<p>Address
<p>Phone Number
<p>Sexual orientation
<p>Photos
<p>Files and docs
<p>Diagnostics
<p>Device or other IDs

<p>We do not collect personal data through automated means. More information can be obtained from our Cookie Use Notice.

<h4>The purpose for the personal data we collect and process</h4>

<p>To communicate with you when you write to us through the ‘contact us’ web form. This is to enable our in-house service desk team to follow up on any clarification, inquiry or complaint raised by a user. The Legal basis relied upon to collect and process this personal data is ‘legitimate interest’ as defined in Regulation 10(2)(b).

 

<h3>Disclosure</h3>

<p>We do not provide personal data to any third party.

 

<h4>Protection of Personal Data</h4>

<p>Personal data is secured with the state of the art data security controls. This website is securely hosted in the Government National Data Center with the appropriate technical and organizational security controls. In addition, we have a skilled support team that maintains the operational security (technical and organizational) controls for this website.

<h4>Your Rights</h4>

<p>The Personal Data Protection and Privacy Act (2019) provides for data subject rights. If you would like more information as per your rights or to submit a request in line with the provided data subject rights, contact us via dpo@nita.go.ug  

 

<h4>Data Retention</h4>

<p>Personal data provided by users through the ‘contact us’ web form will be retained for a period of six months. Personal data will therefore be deleted six months after the request, inquiry or complaint has been resolved.

<h4>Contacts & Revisions</h4>

<p>The data protection officer can be contacted at dpo@nita.go.ug. A complaint can also be filed with our office using the address below:

<h4>Attention: Data Protection Officer</h4>

Ministry of Agriculture Aniamal Industry and Fisheries(MAAIF)<br/>
P.O Box 102, Entebbe Plot 16-18,<br/>
Lugard Avenue, Entebbe Uganda.<br/>
Email: info@agriculture.go.ug<br/>

<p>This Privacy Notice may be updated at any time to reflect changes in this service and will be published here. You should check this website frequently to see any recent changes.

<br/>Version 2.0 – October 2021";

        $scripts = '
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>

            <script type="text/javascript">       
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


                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js"></script>
                <script type="text/javascript" src="' . ROOT . '/includes/theme/maps/js/mapsvg.min.js"></script>
                ' . js::prepJs().'

                '.map::plotOutbreaksHeatMap();
$styles = '
                    <link href="'.ROOT.'/includes/theme/maps/css/mapsvg.css" rel="stylesheet">
                    <style>
                        .table td, .table th {
                            font-size: 14px;
                        }
                    </style>';

return [
'content' => $content,
'styles' => $styles,
'scripts' => $scripts
];

    }
    
}
