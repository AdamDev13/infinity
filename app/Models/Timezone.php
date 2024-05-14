<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


/* 
**
https://www.php.net/manual/en/function.timezone-identifiers-list.php
$zones = timezone_identifiers_list();
foreach ($zones as $zone) {
    $zone = explode('/', $zone); // 0 => Continent, 1 => City
    // Only use "friendly" continent names
    if ($zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific') {       
        if (isset($zone[1]) != '') {
            $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]); // Creates array(DateTimeZone => 'Friendly name')
        }
    }
}
$continents ='Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific'];
**
*/


class Timezone extends Model
{



    /**
     * Location
     * @return array of all timezones in USA with DST zones differentiated
     */
    public static function Location($location = null) {
        if(method_exists($this, $location)) {
            return $this->{$location}();
          }
    }


    /**
     * USA
     * @return array of all timezones in USA with DST zones differentiated
     */
    public static function USA() {
        return array_flip(json_decode(Storage::disk('local')->get('data/timezones_usa.json'), true));
    }
    

    /**
     * Africa
     * @return array of all timezones in Africa
     */
    public static function Africa() {
        return self::getByZone('Africa');
    }
    

    /**
     * America
     * @return array of all timezones in America
     */
    public static function America() {
        return self::getByZone('America');
    }
    

    /**
     * Antarctica
     * @return array of all timezones in Antarctica
     */
    public static function Antarctica() {
        return self::getByZone('Antarctica');
    }
    

    /**
     * Arctic
     * @return array of all timezones in Arctic
     */
    public static function Arctic() {
        return self::getByZone('Arctic');
    }
    

    /**
     * Asia
     * @return array of all timezones in America
     */
    public static function Asia() {
        return self::getByZone('Asia');
    }
    

    /**
     * Atlantic
     * @return array of all timezones in Atlantic
     */
    public static function Atlantic() {
        return self::getByZone('Atlantic');
    }
    

    /**
     * Australia
     * @return array of all timezones in Australia
     */
    public static function Australia() {
        return self::getByZone('Australia');
    }
    

    /**
     * Europe
     * @return array of all timezones in Europe
     */
    public static function Europe() {
        return self::getByZone('Europe');
    }
    

    /**
     * Indian
     * @return array of all timezones in Indian
     */
    public static function Indian() {
        return self::getByZone('Indian');
    }
    

    /**
     * Pacific
     * @return array of all timezones in Pacific
     */
    public static function Pacific() {
        return self::getByZone('Pacific');
    }


    /**
     * Get Timezones by continent
     * @param continent is the name of the continent
     */
    private static function getByZone($continent) {
        $zones = timezone_identifiers_list();
        foreach ($zones as $zone)
        {
            // 0 => Continent, 1 => City
            $zone = explode('/', $zone);
            if ($zone[0] == $continent) {
                if (isset($zone[1]) != '') {
                    $locations[$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]);
                }
            }
        }
        return $locations;
    }


}