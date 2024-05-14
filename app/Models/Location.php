<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Location extends Model
{


    /**
     * getStates
     * @return array of all counties
     */
    public static function getStates() {
        return json_decode(Storage::disk('local')->get('data/locations/states50.json'), true);
    }

    /**
     * getCounties
     * @return array of all counties by state
     */
    public static function getCounties($state = null) {
        return json_decode(Storage::disk('local')->get('data/locations/' . $state . '.json'), true);
    }


    /**
     * Get all Albers counties
     * @return array of all counties
     */
    private static function getAlbersCounties() {
        return json_decode(Storage::disk('local')->get('data/locations/us-albers-counties.json'), true);
    }


    /**
     * getStates
     * @return array of all states and territories
     */
    public static function getStatesWithTerritories() {
        return json_decode(Storage::disk('local')->get('data/locations/all-states.json'), true);
    }


    /**
     * createCounties
     * @return array of all counties
     */
    public static function createCounties() {
        $counties = self::getAlbersCounties();
        $geometries = $counties["objects"]["collection"]["geometries"];
        foreach($geometries as $gid => $geometry) {
            $allLocations[$geometry["properties"]["iso_3166_2"]][$geometry["properties"]["name"]] = $geometry["properties"]["name"];
        }
        ksort($allLocations);
        foreach($allLocations as $state_id => $allLocation) {
            echo $state_id;
            sort($allLocation);
            $data[$state_id] = $allLocation;
        }
        Storage::disk('local')->put('data/locations/allstates.json', json_encode($data));
    }


    /**
     * createCountiesByState
     * @return array of all counties
     */
    public static function createCountiesByState() {
        $counties = self::getAlbersCounties();
        $geometries = $counties["objects"]["collection"]["geometries"];
        foreach($geometries as $gid => $geometry) {
            $allLocations[$geometry["properties"]["iso_3166_2"]][$geometry["properties"]["name"]] = $geometry["properties"]["name"];
            $allStateIds[$geometry["properties"]["iso_3166_2"]] = $geometry["properties"]["iso_3166_2"];
        }
        foreach($allStateIds as $allStateId) {
            $sorted = $allLocations["ID"];
            ksort($sorted);
            print_r($sorted); exit;
            Storage::disk('local')->put('data/locations/' . $allStateId . '.json', json_encode($sorted));
        }
    }


}
