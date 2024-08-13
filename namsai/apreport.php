<?php
require_once('../config/postapdb.php');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

// this line
// if (isset($_POST["soil_code"]) && !empty($_POST["soil_code"])) {
// 	$soil_code = $_POST["soil_code"];
//     $soil_class = $_POST["soil_class"];
//     $soil_description = $_POST["soil_description"];
//     $s1 = $_POST["s1"];
//     $s2 = $_POST["s2"];
//     $s3 = $_POST["s3"];
//     $act_pla_la = $_POST["act_pla_la"];   
//     $coordinate = $_POST["coordinate"];   
// }

$action_pla='';

$soil_code = $_POST["soil_code"];
// $soil_class = $_POST["soil_class"];
// $soil_description = $_POST["soil_description"];
$s1 = $_POST["s1"];
$s2 = $_POST["s2"];
$s3 = $_POST["s3"];
$action_pla = $_POST["action_pla"];  
 
$dist_name = $_POST["dist_name"];   
$circle_name = $_POST["circle_name"]; 
$grid_no = $_POST["grid_no"]; 
// $mini_wshed = $_POST["mini_wshed"];

//$graticule = $_POST["coordinate"];  

if (isset($_POST["id"]) && !empty($_POST["id"])) {
	$id = $_POST["id"]; 
}

$query = "SELECT ST_Extent(soil.the_geom) coordinates FROM public.soil where soil.id ='$id';";
$current_row = pg_query($db,$query);
$current_counts =0;
while ($row_coordinates = pg_fetch_assoc($current_row)) {
	$current_counts = $row_coordinates['coordinates']; 
 }

$pointquery = "SELECT ST_ASTEXT(st_centroid(the_geom)) point_coordinates FROM public.soil where soil.id ='$id';";
$current_row = pg_query($db,$pointquery);
$points_count =0;
while ($row_point = pg_fetch_assoc($current_row)) {
	$points_count = $row_point['point_coordinates'];  
 }

 $report_query = "select   
 soil_code,
 s_depth,
 texture,
 physiography,
 drainage,
 soil_erosion,
 parent_material ,
 landuse,
 slope_per,
 ph_1_2_5,
 ec_dsm_1,
 oc_perc,
 ca_meq_100g,
 mg_meq_100g,
 na_meq_100g,
 k_meq_100g,
 cec_me_100g,
 bs_perc,
 avl_n_kg_h,
 avl_p_kg_h,
 avl_k_kg_h,
 avl_s_ppm,
 avl_fe_ppm,
 avl_mn_ppm ,
 avl_cu_ppm ,
 avl_zn_ppm ,
 avl_b_ppm,
 avl_mo_ppm 
 from public.soil_report where soil_code='$soil_code';";

$table_result = pg_query($db, $report_query); 

$s_depth=0;

while ($row = pg_fetch_assoc($table_result)) {
	$soil_code = $row['soil_code'];
	$s_depth = $row['s_depth']; 
	$texture = $row['texture']; 
	$physiography = $row['physiography']; 
	$drainage = $row['drainage']; 
	$soil_erosion = $row['soil_erosion']; 
	$parent_material = $row['parent_material'];  
	$landuse = $row['landuse']; 
	$slope_per = $row['slope_per'];
	$ph_1_2_5 = $row['ph_1_2_5']; 
	$ec_dsm_1 = $row['ec_dsm_1']; 
	$oc_perc = $row['oc_perc']; 
	$ca_meq_100g = $row['ca_meq_100g']; 
	$mg_meq_100g = $row['mg_meq_100g']; 
	$na_meq_100g = $row['na_meq_100g'];  
	$k_meq_100g = $row['k_meq_100g']; 
	$cec_me_100g = $row['cec_me_100g'];
	$bs_perc = $row['bs_perc']; 
	$avl_n_kg_h = $row['avl_n_kg_h']; 
	$avl_p_kg_h = $row['avl_p_kg_h']; 
	$avl_k_kg_h = $row['avl_k_kg_h']; 
	$avl_s_ppm = $row['avl_s_ppm']; 
	$avl_fe_ppm = $row['avl_fe_ppm'];  
	$avl_mn_ppm = $row['avl_mn_ppm'];
	$avl_cu_ppm = $row['avl_cu_ppm'];
	$avl_zn_ppm = $row['avl_zn_ppm']; 
	$avl_b_ppm = $row['avl_b_ppm']; 
	$avl_mo_ppm = $row['avl_mo_ppm']; 
}

?>





<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/default.css" type="text/css"> -->

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>

    <style>
		@media print {

table {
	max-height: 100%;
	overflow: hidden;
	page-break-after: avoid;
}

body {
	margin: 0%;
	padding: 0%;
}

header,
footer,
aside,
nav,
form,
iframe,
.menu,
.hero,
.adslot {
	display: none !important;
}

.print-button {
	display: none !important;
}

/* table tr,
table th,
table td {
	padding: 0.50rem !important;
} */
th, td {
    font-size: 10px;
  }
}

html,
body,
#map {
height: 100%;
font: 10pt "Helvetica Neue", Arial, Helvetica, sans-serif;
overflow-x: hidden;
}

table {
table-layout: fixed;
}

table tr,
table th,
table td {
overflow: hidden;
border: 1px solid lightgray;
/* padding: 0.50rem !important; */
}

.bottomright {
position: absolute;
bottom: 20px;
right: 35px;

}

.border {
border: 1px solid lightgray;
}

.border-right {
border-right: 1px solid lightgray;
}

.print-button {
display: flex;
justify-content: center;
align-items: center;
}

@media only screen and (max-width: 600px) {
.content-display {
	display: none;
}
}

.reportlogo{
	height : 150px;
	width : 180px;
	padding-left : 25px;
	padding-top : 20px;
	margin-bottom : 10px
}

 @media screen and (max-height: 700px) {
	#selected-map {height : 100px; }
	#selected-map {width: 100px; }
}
/*
@media screen and (max-width: 700px) {
  body {overflow-y: scroll; }
  body {overflow-x: hidden; }
} */

th, td {
    font-size: 11px;
  }
	</style>


  </head>
  <body>

  <div class="row border" style="margin: 0% 10px;margin-top: 1%; padding: 0% 10px;">
		<div class="col-md-12 col-ms-12 col-xs-12">
			<div class="row">
				<div class="col-2 border-right content-display" style="text-align: center">
					<img width="80" class="mx-auto" src="../img/Map_Console_Logo.png" alt="Card image">
				</div>
				<div class="text-center col-8 border-right content-display">
					<h6 style="padding-top: 20px; font-size: small;"><b>Natural Resources Inventory for Micro Level Agricultural Planning</b></h6>
                    <h8>Arunachal Pradesh Space Application Centre</h8><br>
					<h8>Government of Arunachal Pradesh</h8>
					<!-- <h6><b>Grid No :<span> Cluster- </span></b> </h6> -->
				</div>
				<div class="col-2 content-display" style="text-align: center;padding-top:4px;padding-bottom:4px;">
					<img width="75" height="75" class="mx-auto" src="../img/arplogo.jpg" alt="">
				</div>
				
			</div>
			<!-- </div> -->
			<!-- <div class="col-md-10 col-ms-12 col-xs-12" style="padding-left: 10px;"> -->

		</div>
		<!-- <div class="col-ms-12 col-xs-12 button-display">
			<button type="button" class="btn btn-success bottomright" onclick="print1()">Print</button>
		</div> -->
	</div>

<div class="row" style="margin-top: 1%; padding: 0% 10px;">
<div class="container">
    <div class="row">
        <div class="col-5">
            <div style="height:100px;width: 280px;margin:10px 0px; border: 1px solid lightgray;" id="selected-map" class="sidebar-map"></div>
		</div>
        <div class="col-5">
		<div style="width: 350px;margin:10px 0px;">
				
                    <table class="table" style="height:100px;width: 280px;margin:10px 0px; border: 1px solid lightgray;">
                    <thead>
                        <tr>
                            <th style="width: 80px;height: 50px;padding:21px;" scope="row">District</th>
							<th style="width: 80px;height: 50px;padding:21px;" scope="row">Circle</th>  
							<th style="width: 80px;height: 50px;padding:21px;" scope="row">Grid</th>
							<th style="width: 130px;height: 50px;padding:21px;" scope="row">Graticule</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody id="test">
                        <tr>
							<td><?php echo $dist_name ?></td>
                            <td><?php echo $circle_name ?></td>
							<td><?php echo $grid_no ?></td>
                            <td width="150px" id="latlong"></td>
                            
                        </tr>

                    </tbody>
                    </table>
                </div>
           
        </div>
    </div>
</div>
<div class="soilinfo">
        <div class="row">
            <div cal-8>
            <h5>Soil Information</h5>
            <hr class="hr" style="margin: 0.3rem 0;" />
			<table class="soil_table table table-bordered border-primary">
				<thead>
					<tr>
						<th scope="row">Soil Code</th>
						<td><?php echo $soil_code ?></td>
						<th scope="row">Exchangeable Sodium (meq/100 g)</th>
						<td><?php echo $na_meq_100g ?></td>
						
					</tr>
				</thead>
				<tbody id="test">
					<tr>
						<th scope="row">Land Use / Land Cover</th>
						<td><?php echo $landuse; ?></td>
						<th scope="row">Exchangeable Potassium (meq/100 g)</th>
						<td><?php echo $k_meq_100g ?></td>
						
					</tr>
					<tr>
					<th scope="row">Physiography</th>
						<td><?php echo $physiography?></td>
						<th scope="row">CEC (meq/100 g)</th>
						<td><?php echo $cec_me_100g ?></td>
						
					</tr>
					<tr>
					<th scope="row">Parent Material</th>
						<td><?php echo $parent_material ?></td>
						<th scope="row">Base Saturation (%)</th>
						<td><?php echo $bs_perc ?></td>
						
					</tr>
					<tr>
					<th scope="row">Slope (%)</th>
						<td><?php echo $slope_per ?></td>
						<th scope="row">Available Nitrogen (kg/ha)</th>
						<td><?php echo $avl_n_kg_h ?></td>
						
					</tr>
					<tr>
					<th scope="row">Drainage Class</th>
						<td><?php echo $drainage ?></td>						
						<th scope="row">Available Phosphorus (kg/ha)</th>
						<td><?php echo $avl_p_kg_h ?></td>
						
					</tr>
					<tr>
					<th scope="row">Soil Erosion Status</th>
						<td><?php echo $soil_erosion ?></td>						
						<th scope="row">Available Potassium (kg/ha)</th>
						<td><?php echo $avl_k_kg_h ?></td>
						
					</tr>
					<tr>
					<th scope="row">Soil Depth</th>
						<td><?php echo $s_depth ?></td>
						<th scope="row">Available Sulphur (ppm)</th>
						<td><?php echo $avl_s_ppm ?></td>
						
					</tr>
					<tr>
					<th scope="row">Soil Texture</th>
						<td><?php echo $texture ?></td>
						<th scope="row">Available Iron (ppm)</th>
						<td><?php echo $avl_fe_ppm ?></td>
						
					</tr>
					<tr>
					<th scope="row">pH (1:2.5)</th>
						<td><?php echo $ph_1_2_5 ?></td>
						<th scope="row">Available Manganese (ppm)</th>
						<td><?php echo $avl_mn_ppm ?></td>
						
					</tr>
					<tr>
					<th scope="row">EC (dsm-1)</th>
						<td><?php echo $ec_dsm_1 ?></td>
						<th scope="row">Available Copper (ppm)</th>
						<td><?php echo $avl_cu_ppm ?></td>
						
					</tr>
					<tr>
						<th scope="row">Organic Carbon (%)</th>
						<td><?php echo $oc_perc ?></td>
						<th scope="row">Available Zinc (ppm)</th>
						<td><?php echo $avl_zn_ppm ?></td>
						
					</tr>
					<tr>
						<th scope="row">Exchangeable Calcuim (meq/100 g)</th>
						<td><?php echo $ca_meq_100g ?></td>
						<th scope="row">Available Boron (ppm)</th>
						<td><?php echo $avl_b_ppm ?></td>
						
					</tr>
					<tr>
						<th scope="row">Exchangeable Magesium (meq/100 g)</th>
						<td><?php echo $mg_meq_100g ?></td>
						<th scope="row">Available Molybdenum (ppm)</th>
						<td><?php echo $avl_mo_ppm ?></td>
						
					</tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="soilinfo">
        <div class="row">
        <div cal-8>
            <h5>Crop Suitability</h5>
            <hr class="hr" style="margin: 0.3rem 0;" />
            <table class="soil_table table table-bordered border-primary">
				<thead>
					<tr>
						<th scope="row">Highly Suitable Crops (S1)</th>
						<td><?php echo $s1 ?></td>
						
					</tr>
				</thead>
				<tbody id="test">
					<tr>
						<th scope="row">Moderately Suitable Crops  (S2)</th>
						<td><?php echo $s2 ?></td>
						
					</tr>
					<tr>
						<th scope="row">Marginally Suitable Crops  (S3)</th>
						<td><?php echo $s3 ?></td>
						
					</tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <div class="soilinfo">
        <div class="row">
        <div cal-8>
            <h5>Action Plan</h5>
            <hr class="hr" style="margin: 0.3rem 0;" />
            <table class="soil_table table table-bordered border-primary">
				<thead>
					<tr>
						<th scope="row">Action Plan for Soil and Land Resources Development</th>
						<td><?php echo $action_pla ?></td>
						
					</tr>
				</thead>
            </table>
        </div>
        </div>
    </div>
	<p style="text-align: center;font-size:10px">Powered by</p>
	<p style="text-align: center;">Arunachal Pradesh Space Application Centre & Remote Sensing Instruments LLP</p>
    <div class="print-button">
		<button style="margin-right:5px;background-color:  #3C457C;color:white" type="button" class="print-buttons btn btn-success" onclick="print1()">Print</button>
		<button style="background-color:  #3C457C;color:white" type="button" onclick="location.href='namsai_main.php'" class="print-buttons btn btn-success">Back</button>
	</div>


     


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.min.js"></script> 
    <script>
			function print1() {
				window.print();
			}
		</script>

      
    <script>



            var container = document.getElementById('popup');
			var content = document.getElementById('popup-content');
			var closer = document.getElementById('popup-closer');
			var base_url = "https://solaris-ar.com:8085/geoserver"
			var map;
			var view;


			var overlay = new ol.Overlay({
				element: container,
				autoPan: true,
				autoPanAnimation: {
					duration: 250
				}
			});



			var wfs_url_1 = "/geoserver/wfs?service=wfs&version=1.0.0&request=getfeature&typename=topp:states&CQL_FILTER=STATE_NAME LIKE 'I%25'";


			var soil=new ol.layer.Tile(
                      {	title: "Soil Information",
                      name : 'soil_1_new',
                        baseLayer: false,
                        source: soil = new ol.source.TileWMS({
                          url: base_url + '/wms',
                          crossOrigin: null,
                          params: {'LAYERS': 'APWS:soil_1_new', 'TILED': true},
                          serverType: 'geoserver',
                          // Countries have transparency, so do not fade tiles:
                          transition: 0
                      }),
                        visible: true
                      }) ;

			var base =  new ol.layer.Tile(
                              {	title: "Base",
                              name : 'BaseLayer',
                                baseLayer: false,
                                source: basemap = new ol.source.TileWMS({
                                  url: base_url + '/wms',
                                  params: {'LAYERS': 'APWS:BaseLayer', 'TILED': true},
                                // format : new ol.format.GeoJSON,
                                  serverType: 'geoserver',
                                  // Countries have transparency, so do not fade tiles:
                                  transition: 0
                              }),
                             //   visible: true
                              }) ;


			view = new ol.View({
				center: ol.proj.transform([93.73,27.45], 'EPSG:4326', 'EPSG:3857'),
				zoom: 30,

			});

			var scaleLineControl = new ol.control.ScaleLine();
            map = new ol.Map({

				interactions: ol.interaction.defaults({
          		doubleClickZoom: false,
          		dragAndDrop: false,
          		dragPan: false,
				keyboardPan: false,
				keyboardZoom: false,
				mouseWheelZoom: false,
				pointer: false,
				select: false
				}),
				controls: ol.control.defaults({
				attribution: false,
				zoom: false,
				}),

				target: 'selected-map',
				layers: [

					// new ol.layer.Tile({
					// 	title: "OSM",
					// 	baseLayer: true,
					// 	source: new ol.source.OSM(),
					// 	visible: true
					// }),
					soil,
					base,
					// new ol.layer.Tile({
					// 	title: "BaseMap",
					// 	baseLayer: false,
					// 	source: new ol.source.TileWMS({
					// 		url: base_url + '/wms',
					// 		params: {
					// 			'LAYERS': 'APWS:BaseLayer',
					// 			'TILED': true
					// 		},
					// 		serverType: 'geoserver',
					// 		// Countries have transparency, so do not fade tiles:
					// 		transition: 0
					// 	}),
					// 	visible: true
					// })

				],
				overlays: [overlay],
				view: view,
				// controls: ol.control.defaults().extend([
				// 	scaleLineControl
				// ]),
			});



$(window).on('load', function() {
	
	
	
	var coordinates = "<?php echo $current_counts ?>";
	var point_coordinate = "<?php echo $points_count ?>";
	
	
//    alert('coordinatesrrrrrrrrrrrrrrrr '+point_coordinate);
  var array = coordinates.split(','),a = array[0],b = array[1]; 
//   var point_array = point_coordinate.split(','),c1 = point_array[0],c2 = point_array[1];
  
  //alert(a);
 // alert(b);

  var lat= a.replace("BOX(", "");
  var latlog= point_coordinate.replace("POINT(", "");
  console.log(latlog);
  var point_latlong= latlog.replace(")", "");
  console.log(point_latlong);
  var point_latlong = point_latlong.split(" ");
  
  var p1 =parseFloat(point_latlong[0]);
  var p2 =parseFloat(point_latlong[1]);
  console.log(p1,p2)

  var res = lat.split(" ");
  var a1 =parseFloat(res[0]);
  var a2 =parseFloat(res[1]);
  var lng= b.replace(")", "");
  var res1 = lng.split(" ");
  var a3 =parseFloat(res1[0]);
  var a4 =parseFloat(res1[1]);



 var dms=ol.coordinate.toStringHDMS( [a1,a2,a3,a4], 5 )
  
  document.getElementById("latlong").innerHTML = dms;
  console.log(a1,a2,a3,a4);

  var markers = new ol.layer.Vector({
      source: new ol.source.Vector(),
      style: new ol.style.Style({
        image: new ol.style.Icon({
          anchor: [0.5, 1],
          src: '../img/marker.png',
		//   width: 25,
		//   height : 25,
		//   scale: 0.5,
        })
      })
    });
    map.addLayer(markers);
  
  var marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([p1,p2])));
  markers.getSource().addFeature(marker);
  map.getView().fit(ol.proj.transformExtent([a1,a2,a3,a4], 'EPSG:4326', map.getView().getProjection()));
  map.getView().setZoom(15);  
});
 </script>


</body>
</html>