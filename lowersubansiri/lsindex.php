<?php
require_once('../config/postdb.php');
$dist_name=$_POST["dist_ls"];
$query = "select lower_subansiri_circle_boundary.cir_name,lower_subansiri_circle_boundary.gid,ST_Extent(lower_subansiri_circle_boundary.the_geom) ext
FROM lower_subansiri_circle_boundary where lower_subansiri_circle_boundary.dist_name = '$dist_name'
group by lower_subansiri_circle_boundary.gid ,lower_subansiri_circle_boundary.cir_name order by lower_subansiri_circle_boundary.cir_name;";

// $query = "select dist,dist,ST_Extent(dist.geom) ext 
// from dist where gid in(15,20,24) group by gid order by dist;";

// $query = "select dist,gid,ST_Extent(arunachal_boundary.geom) ext 
// from arunachal_boundary where gid in(15,20,24) group by gid order by dist;";
$result = pg_query($db, $query);
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
?>

<html>

<head>
  <title>N R I M A P</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/ol.css" type="text/css">
  <link rel="stylesheet" href="../css/default.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">


  <style>
    .ol-popup {
      position: fixed;
      background-color: white;
      -webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
      filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
      padding: 15px;
      margin-left : 270px;
      border-radius: 10px;
      border: 1px solid #cccccc;
      top: 70px;
      left: -50px;
      max-height : 280px;
      min-width: 280px;
      max-width : 200px;
	    overflow-y: scroll;
    }

    /* .ol-popup:after,
    .ol-popup:before {
      top: 100%;
      border: solid transparent;
      content: " ";
      height: 0;
      width: 0;
      position: absolute;
      pointer-events: none;
    } */

    .ol-popup:after {
      border-top-color: white;
      border-width: 10px;
      left: 48px;
      margin-left: -10px;
    }
/* 
    .ol-popup:before {
      border-top-color: #cccccc;
      border-width: 11px;
      left: 48px;
      margin-left: -11px;
    } */

    .ol-popup-closer {
      text-decoration: none;
      position: absolute;
      top: 2px;
      right: 8px;
    }

    .ol-popup-closer:after {
      content: "close";
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
      /* .sidenav {
        padding-top: 15px;
      } */
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #CBD6AE; margin-bottom: 5px;">
    <!-- <a class="navbar-brand" href="index_p.php">Meghalaya  <span class="sr-only">(current)</span></a> -->

    <div>
      <a href="javascript:history.back()">
        <img width="50" src="../Icons/Map_Console_Logo.png" alt="Card image">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav" style="float:left; padding-left: 10px">
        <li class="nav-item">
          <p style="font-size:20px;padding-top: 15px;">Natural Resources Inventory for Micro Level Agricultural Planning</p>
        </li>
      </ul>




      <ul class="navbar-nav mr-auto home-icon">
      <li class="nav-item">

       <!-- <div class="search-container">
         <form> 
        <input class="search expandright" id="searchright" type="search" name="q" placeholder="Lat-Long" value="27 40 8.18 95 52 16.86">
        <label class="button searchbutton" for="searchright"><span class="mglass">&#9906;</span></label>
        </form> 
      </div> -->

      </li>
      
        <li class="nav-item active">
          <a class="nav-link" href="javascript:history.back()"><i class="fa fa-home" style="font-size:39px; color: #3C457C;margin-right: 8px;"></i></a>
        </li>
        <li class="nav-item">
        <img width="50" src="../img/apsac.png" alt="Card image">
        </li>
        
      </ul>
      

    </div>
  </nav>

  <div class="sidenav">
    <div style="padding: 2px">
      <div class="gradient-border">
        <p style="margin-top: 1rem;"><strong><h3 style="color:#3C457C">N R I M A P</h3></strong></p>
      </div>
      <div class="header-background">
        <div id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link text-center" type="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
            <strong><?php echo $dist_name ?></strong>
              <!-- <span class="if-collapsed toggle-icon">⌄</span>
              <span class="if-not-collapsed toggle-icon">⌃</span> -->
            </button>
          </h2>
        </div>
        <div style="margin-top: -12px;" class="header-background">
          <!-- <p style="text-align: center;">SLRIS REPORT</p> -->
          <div style="padding: 2px">
            <select name="district" id="district1" class="custom-select mr-sm-2" class="inlineFormCustomSelect" onChange="getGrid1(this.value),getVillage(this.value),getWatershed(this.value),getZoomto(this.value);">
              <option>Select Cricle</option>
              <?php
              while ($row = pg_fetch_row($result)) {
              ?>
                <option value="<?php echo $row[1] ?>,<?php echo $row[2]; ?>"><?php echo $row[0]; ?></option>
              <?php
              }
              ?>
            </select>     

            <div id="tab" class="dropdown_tabs">
                <div class="nav btn-group btn-group-sm" role="group" aria-label="Basic outlined example" data-toggle="buttons">
                
                  <a class="nav-link active btn btn-outline-primary" data-toggle="tab" href="#flamingo" role="tab" aria-controls="pills-flamingo" aria-selected="true">GridNo</a>
                  <a class="nav-link btn btn-outline-primary" data-toggle="tab" href="#cuckoo" role="tab" aria-controls="pills-cuckoo" aria-selected="false">Village</a>
               
                  <a class="nav-link btn btn-outline-primary" data-toggle="tab" href="#ostrich" role="tab" aria-controls="pills-ostrich" aria-selected="false">WaterShed</a>

                  </div>
           
              <div class="tab-content">
                <div class="tab-pane show active" id="flamingo" role="tabpanel" aria-labelledby="flamingo-tab">
                <select name="grid_id" class="custom-select mr-sm-2" class="inlineFormCustomSelect" id="grid1" onChange="getZoomto(this.value),buttonEnable1();">
                      <option>Select Grid No</option>
                    </select>
                </div>
                <div class="tab-pane" id="cuckoo" role="tabpanel" aria-labelledby="profile-tab">
                <select name="village" id="village_id" class="custom-select mr-sm-2" class="inlineFormCustomSelect" onChange="getZoomto(this.value);">
                    <option>Select Village Location</option>
                  </select>
                </div>
                <div class="tab-pane fade" id="ostrich" role="tabpanel" aria-labelledby="ostrich-tab">
                <select name="watershed" class="custom-select mr-sm-2" class="inlineFormCustomSelect" id="watershed_id" onChange="getZoomto(this.value);">
                    <option>Select Watershed</option>

                  </select>
                </div>
            </div> 
        </div>
           
     <!-- <button type="submit" id="rbtn1" class="btn btn-primary" disabled>Generate Report</button> -->
          </div>
        </div>
   </div>
      <div class="accordion" id="accordionSideNav">
        <div class="header-background">
          <div id="headingOne">
          <div class="gradient-border">
            <h2 class="mb-0">
              <button class="btn btn-link collapsed border-bottom" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Layer Control
                <span class="if-collapsed toggle-icon"><img width="13" src="../Icons/expand-arrow.png" /></span>
                <span class="if-not-collapsed toggle-icon"><img width="13" src="../Icons/collapse-arrow.png" /></span>
              </button>
            </h2>
            </div>
          </div>

          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSideNav">
            <div>
              <div class="layer-control" id="profile">
                <!-- <p style="text-align: center;">Layer Control</p> -->
                <div></div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <!-- logo on side bar -->
      <div class="sidebarlogo">
     
      <!-- <img src="img/apsac.png" alt="Card image"> -->
        </div>
        
    </div>
    
    <button onclick="show_hide_legend()" type="button" id="legend_btn" class="btn btn-success btn-sm">☰ Show Legend</button>
    <!-- <div class="legend_upper"> -->
    
   
    
    <!-- </div> -->
    
    <marquee behavior="scroll" direction="left" style="position:fixed;bottom:0;left:4px;	bottom: 38px;background-color:#EEEEEE;color:black;font-size:15;width:185px;">Click on Map for info and Legend</marquee>

    <div class="side-footer">
    
      <a>
        About&nbsp;|
      </a>
      <a href="feedback.php">
        Feedback&nbsp;|
      </a>
      <a href="contact.php">
        Contact Us
      </a>
    </div>
    <div id="sidebar" class="sidebar collapsed" style="display: none;">


      <!-- Tab panes -->
      <div class="sidebar-content">

        <!-- <div class="sidebar-pane" id="profile">
          <h1 class="sidebar-header"> Layer Control
            <span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
          </h1>
          <div></div>

        </div> -->

        <div class="sidebar-pane" id="messages">
          <h1 class="sidebar-header">Search<span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
          <div class="container">
            <select name="district" id="district" class="custom-select mr-sm-2" class="inlineFormCustomSelect" onChange="getBlock(this.value),getZoomto(this.value);">
              <option>Select District</option>
              <?php
              // while ($row = pg_fetch_row($result)) {
              ?>
              <option value="<?php echo $row[1] ?>,<?php echo $row[2]; ?>"><?php echo $row[0]; ?></option>
              <?php
              // }
              ?>
            </select>
            <select name="block" class="custom-select mr-sm-2" class="inlineFormCustomSelect" id="block" onChange="getGrid(this.value),getZoomto(this.value);">
              <option>Select Block</option>

            </select>
            <select name="grid" class="custom-select mr-sm-2" class="inlineFormCustomSelect" id="grid" onChange="getZoomto(this.value),getReportData(this.value),buttonEnable();">
              <option>Select Grid</option>
            </select>
            <button type="button" id="rbtn" class="btn btn-primary" disabled data-toggle="modal" data-target="#getReportModal">Quick Report</button>
          </div>
        </div>

        

      </div>
    </div>
  </div>

  <div id="mySidebarRight" class="sidebarright">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <div class="report_buttons">
          <div class="group_buttons btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
            <button type="button" id="lulc" class="tip btn tip btn-outline-primary">LULC</button>
            <button type="button" id="hgeom" class="tip btn btn-outline-primary">HGEOM</button>
            <button type="button" id ="slope_id" class="tip btn btn-outline-primary">SLOPE</button>
            <button type="button" id="so" class="tip btn btn-outline-primary">SOIL</button>
            
          </div>
        </div>
          <div id="sidebarcontent"></div>
          <div class="getreport">
          <button id="apgetreport" type="button" class="btn btn-outline-primary" style="background-color:  #3C457C;color:white" onclick="getAPReport()">Generate Report</button>
          </div>  
      </div>
      
        
      

            <!-- <div class="dropdown_tabs nav btn-group btn-group-sm" style="position:fixed;padding-left:8px;margin-top: 0px;background-color:#EEEEEE;border-left: 4px solid #CBD6AE;border-right: 4px solid #CBD6AE;" role="group" aria-label="Basic outlined example" data-toggle="buttons">
                
                <a class="nav-link active btn btn-outline-primary" id="lulc" data-toggle="tab" role="tab" aria-controls="pills-flamingo" aria-selected="true">LULC</a>
                
                <a class="nav-link btn btn-outline-primary" id="hgeom" data-toggle="tab" role="tab" aria-controls="pills-cuckoo" aria-selected="false">HGEOM</a>
             
                <a class="nav-link btn btn-outline-primary" id ="slope_id" data-toggle="tab" role="tab" aria-controls="pills-ostrich" aria-selected="false">SLOPE</a>
                <a class="nav-link btn btn-outline-primary" id ="slope_id" data-toggle="tab" role="tab" aria-controls="pills-ostrich" aria-selected="false">SOIL</a>
                <button id="report" type="button" class="nav-link btn-outline-info" style="margin-top:5px;margin-left:80px" onclick="getAPReport()">Report</button> 
            </div> -->
       
      <!-- <div class="dropdown_tabs" style="position:fixed;padding-left:8px;margin-top: 0px;background-color:#EEEEEE;border-left: 4px solid #CBD6AE;border-right: 4px solid #CBD6AE;">
                <ul class="nav nav-pills">
                <li class="nav-item ">
                  <a class="nav-link active"  style="font-size:11px;text-align: center;width: 59px" data-toggle="pill" id="lulc" role="tab" aria-controls="pills-flamingo" aria-selected="true">LULC</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="font-size:11px;text-align: center;width: 58px" data-toggle="pill" id="hgeom" role="tab" aria-controls="pills-cuckoo" aria-selected="false">HGEOM</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="font-size:11px;text-align: center;width: 58px" data-toggle="pill" id ="slope_id" role="tab" aria-controls="pills-ostrich" aria-selected="false">SLOPE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="font-size:11px;text-align: center;width: 58px" data-toggle="pill" id="so" role="tab" aria-controls="pills-ostrich" aria-selected="false">SOIL</a>
                </li>
              </ul>
               <button id="report" type="button" class="nav-link btn-outline-info" style="margin-top:5px;margin-left:80px" onclick="getAPReport()">Report</button> 
      </div>        -->
  </div>


      
  <div class="main" id="main">
  <div id="legend"></div>
    <div id="map" class="sidebar-map"></div>
    <div id="mouse-position">
      </div>
    <div class="footer-tag">
      <p class="footer-text">Designed and Developed by Remote Sensing Instruments LLP (RSI LLP) for Department of Agriculture and Farmers Welfare, Government of Arunachal Pradesh, Copyrights © 2024</p>
    </div>
  </div>


  <script src="../js/ol.js"></script>
  <script src="../js/geopoint.js"></script>

  <link rel="stylesheet" href="../css/ol3-sidebar.css" />
  <script src="//turbo87.github.io/sidebar-v2/js/ol3-sidebar.js"></script>

  <script src="../js/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.css" />
  <script src="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.js"></script>
  <script src="../js/labes_soil_info.js"></script>
  <script src="js/lsmain.js"></script>


  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>

  <script>


  function getCircle(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "getCircle.php",
        data: 'dist=' + a,
        success: function(data) {
          $("#circle").html(data);
        }
      });
    }


    function getBlock(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "getBlock.php",
        data: 'block_id=' + a,
        success: function(data) {
          $("#block").html(data);
        }
      });
    }

    function getGrid(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "getGrid.php",
        data: 'circle_id=' + a,
        success: function(data) {
          $("#grid").html(data);
        }
      });
    }

    function getBlock1(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "getBlock.php",
        data: 'block_id=' + a,
        success: function(data) {
          $("#block1").html(data);
        }
      });
    }

    function getGrid1(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "lsgetGrid.php",
        data: 'circle_id=' + a,
        success: function(data) {
          $("#grid1").html(data);
        }
      });
    }


    function getVillage(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "lsgetVillage.php",
        data: 'circle_id=' + a,
        success: function(data) {
          $("#village_id").html(data);
        }
      });
    }
    function getWatershed(val) {
      var array = val.split(','),
        a = array[0];
      $.ajax({
        type: "POST",
        url: "lsgetWatershed.php",
        data: 'circle_id=' + a,
        success: function(data) {
          $("#watershed_id").html(data);
        }
      });
    }
  </script>

  <script>
    // function getReportData(val) {
    //   var array = val.split(','),
    //     a = array[0];
    //   var dataTable = $('#example').DataTable();
    //   dataTable.destroy();
    //   dataTable = $('#example').DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "destory": true,
    //     "visible": true,
    //     "scrollY": 300,
    //     "scrollX": true,
    //     "ajax": {
    //       "url": "reportData.php",
    //       "data": {
    //         "grid_id": a
    //       },
    //       "type": "post"
    //     }
    //   });
    // };
  </script>
  <script>
    function buttonEnable() {
      document.getElementById("rbtn").disabled = false;
    }

    function buttonEnable1() {
      document.getElementById("rbtn1").disabled = false;
    }
  </script>
</body>

</html>