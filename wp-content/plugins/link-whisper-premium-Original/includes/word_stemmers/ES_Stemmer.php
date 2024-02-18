<?php
/**
 * Utility wrapper for interfacing Link Whisper's existing word stemming code with
 * the Wamania php-stemmer project.
 * 
 * https://github.com/wamania/php-stemmer
 * 
 **/

use Wamania\Snowball\Spanish;

class Wpil_Stemmer {

    static $stemmer = null;
    
    public static function Stem($word){
        if(is_null(self::$stemmer)){
            self::$stemmer = new Spanish();
        }

        // if the current word is not in UTF-8 (or contains a letter the stemmer can't deal with...)
        if(!Wamania\Snowball\Utf8::check($word)){

            // try processing the text
            $converted_word = self::codes_to_chars($word);

            // if we were able to process the text into a useable form
            if(Wamania\Snowball\Utf8::check($converted_word)){
                // stem and return the word
                $stemmed_word = self::$stemmer->stem($converted_word);
                return $stemmed_word;

            }else{
                // if we weren't able to process the word, return the original
                return $word;
            }
        }

        $stemmed_word = self::$stemmer->stem($word);

        return $stemmed_word;

    }
    
    public static function codes_to_chars($string){
        
        // create a fallback conversion table in case html_entity_decode runs into trouble
        $conversion_table = array(
            "&#2013266112;" =>"�",
            "&#2013266113;" =>"�", // in testing, was converted to &#2013265923;
            "&#2013266114;" =>"�",
            "&#2013266115;" =>"�",
            "&#2013266116;" =>"�",
            "&#2013266117;" =>"�",
            "&#2013266118;" =>"�",
            "&#2013266119;" =>"�",
            "&#2013266120;" =>"�",
            "&#2013266121;" =>"�",
            "&#2013266122;" =>"�", // in testing, was converted to &#2013266138;
            "&#2013266123;" =>"�",
            "&#2013266140;" =>"�",
            "&#2013266141;" =>"�", // in testing, was converted to &#2013265923;
            "&#2013266142;" =>"�",
            "&#2013266143;" =>"�", // in testing, was converted to &#2013265923;
            "&#2013266129;" =>"�",
            "&#2013266130;" =>"�",
            "&#2013266131;" =>"�",
            "&#2013266132;" =>"�",
            "&#2013266133;" =>"�",
            "&#2013266134;" =>"�",
            "&#2013266136;" =>"�",
            "&#2013266137;" =>"�",
            "&#2013266138;" =>"�",
            "&#2013266139;" =>"�",
            "&#2013266140;" =>"�",
            "&#2013265923;" =>"�", // in testing, was converted to &#2013265923;
            "\u00df" =>"�",        // in testing, gets encoded as "&#2013265923;&#2013266175;" 
            "&#2013266144;" =>"�", // in testing, was converted to &#2013265923;
            "&#2013266145;" =>"�",
            "&#2013266146;" =>"�",
            "&#2013266147;" =>"�",
            "&#2013266148;" =>"�",
            "&#2013266149;" =>"�",
            "&#2013266150;" =>"�",
            "&#2013266151;" =>"�",
            "&#2013266152;" =>"�",
            "&#2013266153;" =>"�",
            "&#2013266154;" =>"�",
            "&#2013266155;" =>"�",
            "&#2013266156;" =>"�",
            "&#2013266157;" =>"�", // in testing, was converted to &#2013265923;
            "&#2013266158;" =>"�",
            "&#2013266159;" =>"�",
            "&#2013266160;" =>"�",
            "&#2013266161;" =>"�",
            "&#2013266162;" =>"�",
            "&#2013266163;" =>"�",
            "&#2013266164;" =>"�",
            "&#2013266165;" =>"�",
            "&#2013266166;" =>"�",
            "&#2013266168;" =>"�",
            "&#2013266169;" =>"�",
            "&#2013266170;" =>"�",
            "&#2013266171;" =>"�",
            "&#2013266172;" =>"�",
            "&#2013266173;" =>"�",
            "&#2013266175;" =>"�",
            "\u2019" =>"�"
        );

        // convert the string into html entities, then decode the entities.
        $string = str_replace(array_keys($conversion_table), array_values($conversion_table), html_entity_decode(mb_convert_encoding($string, "HTML-ENTITIES")));
        
        return $string;
    }
}
