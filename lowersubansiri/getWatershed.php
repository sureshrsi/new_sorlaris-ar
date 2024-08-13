<?php

require_once('../config/postdb.php');
if(!empty($_POST["circle_id"])) {

$query="SELECT lower_subansiri_watershed_32646.sb_wtrshd,ST_Extent(lower_subansiri_watershed_32646.the_geom) 
from public.lower_subansiri_circle_boundary_32646
INNER JOIN public.lower_subansiri_watershed_32646 ON ST_Intersects(lower_subansiri_circle_boundary_32646.the_geom,lower_subansiri_watershed_32646.the_geom)
WHERE lower_subansiri_circle_boundary_32646.gid = '" . $_POST["circle_id"] . "'
group by lower_subansiri_watershed_32646.sb_wtrshd
order by lower_subansiri_watershed_32646.sb_wtrshd;";

// $query ="SELECT soil_grid.id,ST_Extent(soil_grid.the_geom) ext
// FROM Block INNER JOIN soil_grid ON ST_Intersects(Block.geom, soil_grid.the_geom) where Block.gid = '" . $_POST["grid_id"] . "' and soil_grid.texture is not null group by soil_grid.id order by soil_grid.id";
$result = pg_query($db,$query);

?>
	<option value="">Select WaterShed</option>
<?php
	while ($row = pg_fetch_row($result)) {
?>
	<option value="<?php echo $row[0]; ?>,<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
	
<?php
	}
}
?>