<?php

/**
 * Created by PhpStorm.
 * User: Herbert Musoke
 * Date: 20/06/2018
 * Time: 20:54
 */
class dmpList
{
    //Init class variables
    public $region;
    public $subregion;
    public $district;
    public $subcounty;
    public $parish;
    public $name;
    public $category;
    public $results_view;
    public $results_order;
    public $letter;
    public $total;

    /**
     * Constructor populate variables
     */
    public function __construct($region, $subregion, $district, $subcounty, $parish, $name,
                                $category,  $letter,
                                $results_view = 'list', $results_order = 'nameASC')
    {
        $this->region = database::prepData($region);
        $this->subregion = database::prepData($subregion);
        $this->district = database::prepData($district);
        $this->subcounty = database::prepData($subcounty);
        $this->parish = database::prepData($parish);
        $this->name = database::prepData($name);
        $this->category = database::prepData($category);
        $this->letter = database::prepData($letter);
        $this->results_view = database::prepData($results_view);
        $this->results_order = database::prepData($results_order);
    }


    //Searching using all parameters
    public function doSearchAll()
    {

        $sql = "
        SELECT dmp.name as school_name,dmp_category.name as cat,dmp_category.id as cat_id,phone,dmp.id as id,district.name as district
        FROM
        dmp,region,district,county,subcounty,dmp_category,parish";

        $sql .= ' WHERE
            region.id = district.region_id
        AND district.id = county.district_id
        AND county.id = subcounty.county_id
        AND subcounty.id = parish.subcounty_id
        AND parish.id = dmp.parish_id
        AND dmp_category.id = dmp.dmp_category_id
        ' .
            $this->prepRegion() .
            $this->prepSubRegion() .
            $this->prepDistrict() .
            $this->prepSubcounty() .
            $this->prepParish() .
            $this->prepName() .
            $this->prepCategory() .
            $this->prepLetter() . ' GROUP BY dmp.id ' .
            $this->prepOrderBy();
        //Get results
        $tot = database::performQuery($sql);
        $this->total = $tot->num_rows;

        $sql .=$this->prepLimit();

//        echo $sql;
        $sql = database::performQuery($sql);
        return $this->resultByList($sql);
    }

    //Prepare Letter for search
    public function prepLetter()
    {
        if (isset($_REQUEST['letter']))
            return ' AND dmp.name LIKE \'' . $_REQUEST['letter'].'%\'';
        else
            return '';
    }

    //Prepare region for search
    public function prepRegion()
    {
        if (isset($_REQUEST['region']))
            return ' AND region.id=' . $_REQUEST['region'];
        else
            return '';
    }


    //Prepare Subregion for search
    public function prepSubRegion()
    {
        if (isset($_REQUEST['subregion']))
            return ' AND sub_region_id=' . $_REQUEST['subregion'];
        else
            return '';
    }


    //Prepare district for search
    public function prepDistrict()
    {
        if (isset($_REQUEST['district']))
            return ' AND district.id=' . $_REQUEST['district'];
        else
            return '';
    }


    //Prepare Subcounty for search
    public function prepSubcounty()
    {
        if (isset($_REQUEST['subcounty']))
            return ' AND subcounty.id=' . $_REQUEST['subcounty'];
        else
            return '';
    }

    //Prepare Parish for search
    public function prepParish()
    {
        if (isset($_REQUEST['parish']))
            return ' AND parish.id=' . $_REQUEST['parish'];
        else
            return '';
    }


    //Prepare name for search
    public function prepName()
    {
        if (isset($_REQUEST['name']))
            return 'AND dmp.name LIKE \'%' . $_REQUEST['name'] . '%\'';
        else
            return '';
    }


    //Prepare Category for search
    public function prepCategory()
    {
//      echo "<br />My category is :".$_REQUEST['category'];
//        echo "<br />My category is :".$_GET['category'];

        if (isset($_REQUEST['category']))
            return ' 
            AND dmp_category.id=' . $_REQUEST['category'];
        else
            return '';
    }


    public function prepOrderBy()
    {
        switch ($this->results_order) {
            case 'nameASC':
                return ' ORDER BY dmp.name ASC';
                break;
            case 'nameDESC':
                return ' ORDER BY dmp.name ASC';
                break;
            case 'catASC':
                return 'ORDER BY dmp_category.id ASC';
                 break;
            default:
                return ' ORDER BY dmp.name ASC';
                break;
        }


    }



    //View Result by List
    public function resultByList($result)
    {

        $content = '
                <div class="table-scrollable table-scrollable-borderless">
        <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
                <tr class="uppercase" style="font-weight:700">
                    <th> No.  </th>
                    <th> Name</th>
                    <th> District  </th>
                    <th> Type </th>
                    <th> Phone </th>
                    <th> Details </th>                  
                </tr>
            </thead>
            <tbody>';
        $x = 1;
        while ($data = $result->fetch_assoc()) {


            $content .= '<tr>
                         <td>' . $x . '</td>
                         <td>' . ucwords(strtolower($data['school_name'])) . '</td>
                         <td>'.ucwords(strtolower($data['district'])) .'</td>
                         <td>' . ucwords(strtolower($data['cat'])) . '</td>
                         <td>' . $data['phone'] . '</td>
                         <td>
                              <a href="' . ROOT . '/view-dmp/'.$data['id'].'/'.makeSeo($data['school_name'],100).'" class="btn btn-xs green-jungle"><i class="fa fa-eye"></i> </a>                                 
                            
                         </td>
                     </tr>';
            $x++;
        }
        //Show login button

        //Display if schools ar emore than 50 or session is not live
        if($this->total > 50 || !($_SESSION['live']))
        $content .= '<tr><td colspan="5">' . $this->prepSessionLimitMsg() . '</td></tr>';

        $content .= '</tbody>
      </table></div>';
        return $content;
    }


    public function prepLimit()
    {
        if (!$_SESSION['live'])
           // return ' LIMIT 20 ';
            return ' ';
        else if($_SESSION['live'] && $_SESSION['live'])
           // return ' LIMIT 100';
            return ' ';
    }

    public function prepSessionLimitMsg()
    {
//        if (!$_SESSION['live']) {
//            return '
//            <div class="alert alert-warning">
//              <strong>Warning!</strong> Create an account or Login to view more schools.<a href="' . ROOT . '/my-account-login"> <button calss="btn btn-circle btn-default">Login Here</button> </a></div>
//            ';
//        }
//        else if ($_SESSION['live'])
//        {
//            return '<div class="alert alert-success">
//              <strong><h2>Notice: </h2></strong> <p>We\'re limiting this list to only 50 records to avoid theft of data from school guide.
//              To view the full list of schools , do one of the following activities;- <br />
//              <ol>
//               <li>Donate to the school guide foundation, </li>
//               <li>Subscribe to one of our packages on schoolguide.ug</li>
//               <li>Drop us an mail on info@schoolguide.ug requesting the data. </li>
//               </ol></div>
//            ';
//        }

        return '';
    }

    public static function prepTitle()
    {
        $title = '';

        if (isset($_REQUEST['category']))
            $title .= self::getCategory();
        if (isset($_REQUEST['district']))
            $title .= self::getDistrict();
        if (isset($_REQUEST['region']))
            $title .= self::getRegion();
        if (isset($_REQUEST['subregion']))
            $title .= self::getSubRegion();
       if (isset($_REQUEST['subcounty']))
            $title .= self::getSubCounty();
        if (isset($_REQUEST['parish']))
            $title .= self::getParish();
        if(isset($_REQUEST['letter']))
            $title .= self::getLetter();

       // return $title;
        $title = str_replace("Direct Market Players Direct Market Players","Direct Market Players",$title);

        return $title;
    }

    public static function getCategory()
    {
        $sql = database::performQuery("SELECT name FROM dmp_category WHERE id=".$_REQUEST['category']);
        return ' '.ucwords(strtolower($sql->fetch_assoc()['name'])).' | Direct Market Players ';
    }

    public static function getLetter()
    {
        return 'Direct Market Players Starting With Letter '.ucwords(strtolower($_REQUEST['letter']));
    }


    public static function getDistrict()
    {
        $sql = database::performQuery("SELECT name FROM district WHERE id=".$_REQUEST['district']);
        return 'Direct Market Players in '.ucwords(strtolower($sql->fetch_assoc()['name'])).' District ';
    }

    public static function getRegion()
    {
        $sql = database::performQuery("SELECT name FROM region WHERE id=".$_REQUEST['region']);
        return 'Direct Market Players in '.ucwords(strtolower($sql->fetch_assoc()['name'])).'  Region of Uganda ';
    }

    public static function getSubRegion()
    {
        $sql = database::performQuery("SELECT name FROM sub_region WHERE id=".$_REQUEST['subregion']);
        return 'Direct Market Players in '.ucwords(strtolower($sql->fetch_assoc()['name'])).'  Sub-Region of Uganda ';
    }

    public static function getSubCounty()

    {
        $subcounty_info = subcounty::subcountyDescription($_REQUEST['subcounty']);

        $name = ucwords(strtolower($subcounty_info['name']))." Sub County, ".ucwords(strtolower($subcounty_info['district']))." District ";


       // $sql = database::performQuery("SELECT name FROM subcounty WHERE id=".$_REQUEST['subcounty']);
        return 'Direct Market Players in '. $name ;
    }

    public static function getParish()
    {
        $sql= database::performQuery("
        
        SELECT 
 district.name as district,subcounty.name as subcounty,
 parish.id as id,parish.name as name
            FROM district,school,county,subcounty,parish
            WHERE district.id=county.district_id
            AND county.id= subcounty.county_id
            AND subcounty.id = parish.subcounty_id
            AND parish.id = school.parish_id
            AND parish.id = $_REQUEST[parish]
           
        ");
        $ret = $sql->fetch_assoc();
       // $sql = database::performQuery("SELECT name FROM parish WHERE id=".$_REQUEST['parish']);
        return 'Direct Market Players in '.ucwords(strtolower($ret['name'])).' Parish,   '.ucwords(strtolower($ret['subcounty'])).' Subcounty,  '.ucwords(strtolower($ret['district'])).'  District ';
    }




}