<?php

class userMgmt
{

    public static function getDistrictHeadsAndDistrictSectorHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (4,5)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getDistrictHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (4)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getDistrictSectorHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (5)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getZonalHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (3)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getNationalAdministrativeHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (1)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getNationalManagerUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (2)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }



    public static function getAllNationalUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (1,2)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (6)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyExtensionStaffUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (7,8,9,10)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyCropExtensionStaffUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (7)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyVetExtensionStaffUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (8)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyFishExtensionStaffUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (9)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getSubcountyEntomologyExtensionStaffUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (10)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    public static function getParishHeadsUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (11)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }

    public static function getGRMUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (13)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }

    public static function getFarmersUserIDs(){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (12)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }
        return implode(',',$content);
    }


    //Switch Preps
    public static function prepSwitchForAllNationalLevelManagers(){
        $ids = explode(',',self::getAllNationalUserIDs());
        $content = [];
        foreach($ids as $id){
            $content[] = "case $id : \n";
        }
        return implode('',$content);
    }



    //Check if extension officer account
    public static function checkSubcountyExtensionStaffUserIDs($user_category_id){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (7,8,9,10)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }


        if(in_array($user_category_id,$content))
            return true;
        else
            return false;

    }


    public static function checkDistrictExtensionStaffUserIDs($user_category_id){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (4,5)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }


        if(in_array($user_category_id,$content))
            return true;
        else
            return false;

    }



    public static function checkZonalExtensionStaffUserIDs($user_category_id){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (3)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }


        if(in_array($user_category_id,$content))
            return true;
        else
            return false;

    }
    public static function checkNationalStaffUserIDs($user_category_id){

        $sql = database::performQuery("SELECT id FROM `user_category` WHERE user_group_id IN (1,2)");
        $content = [];
        while($data = $sql->fetch_assoc()){
            $content[] = $data['id'];
        }


        if(in_array($user_category_id,$content))
            return true;
        else
            return false;

    }


}