<!-- returns the distance between two zip codes from SQL database of lat/lon points-->
<?php
$zip_a = $_GET['zip_a'];
$zip_b = $_GET['zip_b'];

include "dbconnection.php";

$zip_a = mysql_real_escape_string($zip_a);
$zip_b = mysql_real_escape_string($zip_b);

if($zip_a == "0" || $zip_b == "0") {
    echo "Invalid zipcodes";
} else {

$results_city_a = mysql_fetch_assoc(mysql_query("SELECT latitude,longitude FROM zipcodes WHERE zipcode='$zip_a' LIMIT 1"));
$lat1 = $results_city_a['latitude'];
$lon1 = $results_city_a['longitude'];


$results_city_b = mysql_fetch_array(mysql_query("SELECT latitude,longitude FROM zipcodes WHERE zipcode='$zip_b' LIMIT 1"));
$lat2 = $results_city_b['latitude'];
$lon2 = $results_city_b['longitude'];

calcDist($lat1, $lon1, $lat2, $lon2);
mysql_close();
}

function calcDist($lat_A, $long_A, $lat_B, $long_B) {
  $distance = sin(deg2rad($lat_A))
                * sin(deg2rad($lat_B))
                + cos(deg2rad($lat_A))
                * cos(deg2rad($lat_B))
                * cos(deg2rad($long_A - $long_B));

  $distance = round((rad2deg(acos($distance))) * 69.09,0);

  echo $distance;
}
?>