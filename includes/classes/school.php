<?php

class school
{
    //Get Random 20 Districts with their school count for the footer menu.
    public static function getRandomSchools(){
        
       $sql = database::performQuery("
           SELECT district.name,district.id,COUNT(*) as schools 
            FROM district,kmu_affects_district
            WHERE district.id=kmu_affects_district.district_id               
            GROUP BY district.name
            ORDER BY RAND()
            LIMIT 5
           ");
      // $x=1;
       $content = '';
       while ($data = $sql->fetch_assoc()) {
           $content .='<li><a href="'.ROOT.'/view-details/district/'.strtolower($data['name']).'">'.ucwords(strtolower($data['name'])).' Advisory Services ('.$data['schools'].')</a></li>';
          // if($x==10)
          // {
          // $content .='</ul>				
          //                      </div>
          //                      <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
          //                          <h2>&nbsp;</h2>
		  //							<ul>';    
          //     
          // }
          // $x++;
       }
       return $content;
        
    }
	
	
	
    //Get Random 10 Districts with their school count for specific region
    public static function getRandomSchoolsRegion($region){
    
        $sql = database::performQuery("
            SELECT district.name,district.id,district.map_id,COUNT(*) as schools
            FROM district,kmu_affects_district
            WHERE district.id=kmu_affects_district.district_id
            AND region_id = $region
            GROUP BY district.name
            ORDER BY RAND()
            LIMIT 7
            ");
        $x=1;
        $content = '';
    
        while ($data = $sql->fetch_assoc()) {
    
            //Color Button Icons
            $color = "";
            switch($region)
            {
                case 1: $color = '#9A12B3'; break;
                case 2: $color = '#F3C200'; break;
                case 3: $color = '#26C281'; break;
                case 4: $color = '#3598DC'; break;
                default: break;
                	
            }
    
             
            $content .='<li> <i class="icon-check" style="color:'.$color.'"></i> <a href="'.ROOT.'/view-details/district/'.strtolower($data['name']).'">'.ucwords(strtolower($data['name'])).' Advisory Services ('.$data['schools'].')</a></li>';
             
        }
        return $content;
    
    }


    public static function getSchoolDetails(){
        $id = $_REQUEST['id'];
        $sql = database::performQuery("SELECT * FROM school WHERE id=$id");
        $ret = $sql->fetch_assoc();
        return $ret;
    }

    public static function getSchoolLocation(){}
    public static function getSchoolOwnership(){}
    public static function getSchoolGender(){}
    public static function getSchoolBoarding(){}
    public static function getSchoolCategory(){}
    public static function getSchoolFoundingBody(){}

    public static function prepView(){
       $school =  self::getSchoolDetails();
       $category =   category::getCategoryDetails($_REQUEST['id']);
       $parish = subcounty::viewParishInfo($school['parish_id']);
        $content = "$school[name] is a school in Uganda. <br />
        This school is located in $parish[name] Parish, $parish[subcounty] Subcounty, $parish[district] District of Uganda.



<br />
<br />
Contact information<br />
$school[name]<br />
Postal: $school[postal_address]<br />
Physical: $school[physical_address]<br />
$parish[subcounty], $parish[district] <br />
Phone: $school[phone]<br />";

        return $content;


    }


    public static function makeAll(){
        $sql = database::performQuery("SELECT * FROM school");
        while($data = $sql->fetch_assoc()){

            echo 'http://nilepost.co.ug/schools/view/'.$data['id'].'/'.makeSeo($data['name']).'<br />';
        }




     // return 'Hi!';
    }

}

?>