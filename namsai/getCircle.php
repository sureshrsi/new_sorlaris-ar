<?php
require_once('config/postdb.php');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
if(!empty($_POST["dist"])) {

$query ="SELECT namsaicircle.circle_id, namsaicircle.cir_name,ST_Extent(namsaicircle.geom) ext
         FROM namsaicircle where namsaicircle.dist_name = '" . $_POST["dist"] . "' group by namsaicircle.circle_id ,namsaicircle.cir_name order by namsaicircle.cir_name";

// $query ="SELECT Block.gid, Block.block,ST_Extent(block.geom) ext
// FROM District INNER JOIN Block ON ST_Intersects(District.geom, Block.geom) where District.gid = '" . $_POST["block_id"] . "' and Block.gid in(1,9,11,15) group by Block.gid ,Block.block";
$result = pg_query($db,$query);
?>
	<option value="">Select Circle</option>
<?php
	while ($row = pg_fetch_row($result)) {
?>
	<option value="<?php echo $row[0] ?>,<?php echo $row[2]; ?>"><?php echo $row[1]; ?></option>
	
<?php
	}
}
?>