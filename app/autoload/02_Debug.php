<?php 



class SHDebug {


    public static function print ($data,$ReturnOutput=false){
        if(!$ReturnOutput){
            echo "<pre>" . print_r($data,true) . "</pre>";
            return true;
        }
        return "<pre>" . print_r($data,true) . "</pre>";
    }



}