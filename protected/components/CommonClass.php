<?php

class CommonClass extends CComponent {

    public static function getDateFormat($date, $format = '') {
        $formated_date = new DateTime($date);
        return $formated_date->format('l, F jS, Y');
    }
    
    public static function getKey(){
        return sha1(date('Y-m-d h:m:s').''.Yii::app()->params->publicKey);
    }

}
