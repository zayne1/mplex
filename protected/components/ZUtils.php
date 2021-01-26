<?php

class ZUtils extends CApplicationComponent
{
	public function init() {
        parent::init();
    }

    /**
    * Return URL-Friendly string slug
    * REF:  http://forum.codecall.net/topic/59486-php-create-seo-friendly-url-titles-slugs/
    *
    * @param string $string
    * @return string
    */
    public static function slugify($string) {

        //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = strtolower($string);
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
//        $string = date("Y-m-d", $this->published->sec) . "-" . $string;

       
        return $string;
    }

    public static function getFileExtension($str_filename)
    {
    	return substr($str_filename , ( strpos($str_filename, '.') - strlen($str_filename) ));
    }
}