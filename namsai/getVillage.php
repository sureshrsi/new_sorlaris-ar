<?php

require_once('../config/postdb.php');
if(!empty($_POST["circle_id"])) {

$query="select namsai_settlement_point_update_final.name,ST_Extent(namsai_settlement_point_update_final.geom) ext 
from public.namsai_settlement_point_update_final
where cir_id='" . $_POST["circle_id"] . "'
group by namsai_settlement_point_update_final.name order by namsai_settlement_point_update_final.name";

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