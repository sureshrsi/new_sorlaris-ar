<?php

require_once('../config/postdb.php');
if(!empty($_POST["circle_id"])) {

$query="select namsai_watershed_union.mini_whed, ST_Extent(namsai_watershed_union.geom) ext
from public.namsai_watershed_union 
where circle_id='" . $_POST["circle_id"] . "'
group by namsai_watershed_union.mini_whed order by namsai_watershed_union.mini_whed";

// $query ="SELECT soil_grid.id,ST_Extent(soil_grid.the_geom) ext
// FROM Block INNER JOIN soil_grid ON ST_Intersects(Block.geom, soil_grid.the_geom) where Block.gid = '" . $_POST["grid_id"] . "' and soil_grid.texture is not null group by soil_grid.id order by soil_grid.id";
$result = pg_query($db,$query);

?>
	<option value="">Select Watershed</option>
<?php
	while ($row = pg_fetch_row($result)) {
?>
	<option value="<?php echo $row[0]; ?>,<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
	
<?php
	}
}
?>