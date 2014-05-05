<?php

class CommonClass extends CComponent {

    public static function getDateFormat($date, $format = '') {
        $formated_date = new DateTime($date);
        return $formated_date->format('l, F jS, Y');
    }

    public static function getKey() {
        return sha1(date('Y-m-d h:m:s') . '' . Yii::app()->params->publicKey);
    }

    public static function getSlug($string) {
        $new_string = preg_replace("/[^a-zA-Z0-9-\@\$ \s]/", "", strtolower(strip_tags($string)));
        $rep_string = str_replace(" ", "-", trim($new_string));
        $rep_string = preg_replace('/-+/', '-', $rep_string);
        $ret_string = preg_replace('/\'/', '', $rep_string);
        return $ret_string . '-' . date('ymdhms');
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
            case "image":
                return array(
                    'thumbs' => array(
                        "function" => "optimizedResize",
                        "width" => "300",
                        "height" => "500",
                        "path" => "uploads/temp/thumbs/",
                    ),
                );
                break;
        }
    }
    
    public static function getPriceFormat($member_id){
        $currency = MemberSetting::model()->findByAttributes(array('member_id' => $member_id));
        if(!empty($currency)){
            $symbol = array('R', '$', 'P', 'E');
            return $symbol[$currency->currency];
        }
    }

}
