<?php

class CommonClass extends CComponent {

    public static function getDateFormat($date, $format = '') {
        $formated_date = new DateTime($date);
        return $formated_date->format('l, F jS, Y');
    }
    
    public static function getKey(){
        return sha1(date('Y-m-d h:m:s').''.Yii::app()->params->publicKey);
    }
    
    public static function getImageResizeDetails($case) {
        switch ($case) {
            // keep all the final image details here
            case "logo":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "300",
                        "height" => "500",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
            case "banner":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "300",
                        "height" => "500",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
            case "products":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "300",
                        "height" => "500",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
            case "slider":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "300",
                        "height" => "500",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
            case "profile":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "188",
                        "height" => "188",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
        }
    }

}
