<?php
//A little config file for ease of use.

//lower left
$limitLong1 = 3.747404;
$limitLat1 = 51.211508;
//upper right
$limitLong2 = 3.876187;
$limitLat2 = 51.348199;

//add in where you need the limiter. Don't forget the spaces!
$limiter = "AND latitude BETWEEN $limitLat1 AND $limitLat2 AND longitude BETWEEN $limitLong1 AND $limitLong2";
