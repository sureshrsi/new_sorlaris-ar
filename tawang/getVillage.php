<?php

require_once('../config/postdb.php');
if(!empty($_POST["circle_id"])) {

$query="SELECT tawang_habitation.hab_name,ST_Extent(tawang_habitation.the_geom) 
from public.tawang_circle_boundary_32646
INNER JOIN public.tawang_habitation ON ST_Intersects(tawang_circle_boundary_32646.the_geom,tawang_habitation.the_geom)
WHERE tawang_circle_boundary_32646.gid = '" . $_POST["circle_id"] . "'
group by tawang_habitation.hab_name
order by tawang_habitation.hab_name;";

// $query ="SELECT soil_grid.id,ST_Extent(soil_grid.the_geom) ext
// FROM Block INNER JOIN soil_grid ON ST_Intersects(Block.geom, soil_grid.the_geom) where Block.gid = '" . $_POST["grid_id"] . "' and soil_grid.texture is not null group by soil_grid.id order by soil_grid.id";
$result = pg_query($db,$query);

?>
	<option value="">Select Village</option>
<?php
	while ($row = pg_fetch_row($result)) {
?>
	<option value="<?php echo $row[0]; ?>,<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
	
<?php
	}
}
?>