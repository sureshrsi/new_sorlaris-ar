<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
require_once('./config/postdb.php');
if(!empty($_POST["dist"])) {

$query="SELECT sno,dist,head_quarters,geographical_area,population1,circles,blocks,revenue_villages FROM public.mainpageinfo where dist = '" . $_POST["dist"] . "';";

// $query ="SELECT soil_grid.id,ST_Extent(soil_grid.the_geom) ext
// FROM Block INNER JOIN soil_grid ON ST_Intersects(Block.geom, soil_grid.the_geom) where Block.gid = '" . $_POST["grid_id"] . "' and soil_grid.texture is not null group by soil_grid.id order by soil_grid.id";
$result = pg_query($db,$query);

while ($row = pg_fetch_array($result)) {
    $dist = strtoupper($row["dist"]) ;
    $head_quarters = $row["head_quarters"] ;
    $geographical_area = $row["geographical_area"] ;
    $population1 = $row["population1"] ;

    $circles = $row["circles"] ;
    $blocks = $row["blocks"] ;
    $revenue_villages = $row["revenue_villages"] ;
    }
    // Store it in a array 
$result1 = array("$dist", "$head_quarters","$geographical_area","$population1","$circles","$blocks","$revenue_villages");
// Send in JSON encoded form 
$myJSON = json_encode($result1); 
echo $myJSON;
}
?>
