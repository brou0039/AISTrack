<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 15-12-2015
 * Time: 19:31
 */
require_once 'db.php';
require_once 'vendor/autoload.php';

use Location\Polygon;
use Location\Coordinate;

function getKades($con)
{
    $sql = 'SELECT K.id AS kid, K.naam AS knaam , P.id AS pid , P.longitude AS plongitude, P.latitude AS platitude
        FROM kadepunt P , kade K WHERE K.id = P.Kade_id ORDER BY K.id ASC , P.id ASC';
    $kade = null;
    $kades = array();

    if ($result = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $kid = $row['kid'];
            if (!isset($kades[$kid])) {
                $kades[$row['kid']] = array();
            }
            $latitude = $row['platitude'];
            $longitude = $row['plongitude'];
            array_push($kades[$kid], array('latitude' => $latitude,
                                          'longitude' => $longitude));
        }
        mysqli_free_result($result);
        mysqli_close($con);
        return $kades;
    }
    return null;
}

function createPolygons($kades)
{
    $polygons = array();
    foreach($kades as $id => $kade) {
        $polygon = new Polygon();
        foreach($kade as $point) {
            $latitude = $point['latitude'];
            $longitude = $point['longitude'];
            $polygon->addPoint(new Coordinate($latitude, $longitude));
        }
        $polygons[$id] = $polygon;
    }
    return $polygons;
}

function checkShipIsOnKade($polygons, $ship)
{
    $polygonId = null;
    foreach($polygons as $id => $polygon) {
        //var_dump($polygon);
        if ($polygon->contains(new Coordinate($ship['latitude'], $ship['longitude']))) {
            $polygonId = $id;
            return $polygonId;
        }
    }
    return $polygonId;
}

