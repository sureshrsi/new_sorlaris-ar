<?php
require_once('../config/postdb.php');
// $dist_name=$_POST["dist_ls"];
$dist_name = 'Lower Subansiri';
$query = "select lower_subansiri_circle_boundary.cir_name,lower_subansiri_circle_boundary.gid,ST_Extent(lower_subansiri_circle_boundary.the_geom) ext
FROM lower_subansiri_circle_boundary where lower_subansiri_circle_boundary.dist_name = '$dist_name'
group by lower_subansiri_circle_boundary.gid ,lower_subansiri_circle_boundary.cir_name order by lower_subansiri_circle_boundary.cir_name;";

// $query = "select dist,gid,ST_Extent(dist.geom) ext from dist where gid in(15,20,24) group by gid order by dist";

$result1 = pg_query($db, $query);
$result2 = pg_query($db, $query);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

?>

<!doctype html>
<html lang="en">
<!-- <allow-navigation href="http://solaris-ar/" />
<allow-intent href="*.hostname.com/*" />
<allow-navigation href="https://*/*" />
<allow-navigation href="http://*/*" />
<allow-access href="https://*/*" />
<allow-access href="http://*/*" /> -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/ol3-sidebar.css" />
    <link rel="stylesheet" href="../css/ol-ext.min.css" />
    <link rel="stylesheet" href="../css/testing.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../css/ol.css" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" integrity="sha512-d0olNN35C6VLiulAobxYHZiXJmq+vl+BGIgAxQtD5+kqudro/xNMvv2yIHAciGHpExsIbKX3iLg+0B6d0k4+ZA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <title>S O L A R I S - A R </title>

</head>

<body id="body-pd">
    <header class="header" id="header">

        <div class="header_toggle parent">
            <div class="child ">
                <i class='bx bx-menu' id="header-toggle" hidden></i>
            </div>
            <div class="child ">
                <h6 class="pro-title" style="margin-left:20px;margin-top:1rem;color: #3C457C;font-weight: 600;">SOIL AND LAND RESOURCES INFORMATION SYSTEM<br>ARUNACHAL PRADESH
                </h6>
            </div>
        </div>
        <!-- <p>SOIL AND RESOURCES INFORMATION SYSTEM <br>ARUNACHAL PRADESH</p> -->

        <div class="header_img">

            <div class="search">
                <i class="fa fa-search" aria-hidden="true" style="cursor: pointer;"></i>
                <input type="search" class="search-input" placeholder="Lat/Long (DD MM SS)" id="search" onclick="convertDMSToDecimcal()">   
                <!-- <input type="file" id="file-input" accept=".kml" class="form-control-xs">     -->
                <!-- <button id="popupButton" ></button>     -->
                <button id="popupButton" type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal11"></button>    
                <!-- onclick="openToggle()" -->
                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal11">Contact Us</a>                        -->
            </div>

            
            <!-- <input type="file" id="file-input" accept=".kml" class="form-control-xs">            -->
            <a href="http://solaris-ar.com/index.html">
                <i class="fa fa-home" style="font-size:39px; color: #3C457C;padding-right: 12px;"></i></a>
            <img class="apsacimg" src="../img/apsac.png" alt="" style="height:58px;width:60px">
            <img class="apseal" src="../img/Arunachal_Pradesh_Seal.png" alt="" style="width :85px">
            <!-- <a href="./index_p.php">
            <i class="fa fa-home" style="font-size:39px; color: #3C457C;margin: 12px 14px 0px 17px;"></i></a>
            <img src="../img/apsac.png" alt="" width="60px" height="60px" style="margin :0px 9px 0px 0px">
            <img src="../img/Arunachal_Pradesh_Seal.png" alt="" style="margin :6px -15px 0px 0px; width :75px ;height:47px"> -->
        </div>
    </header>

    <div class="mobile-scale-on" id="mobile-scale-on-id">
    <a href="javascript:void(0)" class="btn-close closebtn" id="close-selection" style="height: 4px; width:4px;background-image: url('../img/close_14440874_new.png');" onclick="openMobileSidebar()">
        </a>
            <div class="selection-boxs">
                 <h6 style="margin :5px 0px 5px 0px;font-size: 13px;font-weight: 600;text-align: center;letter-spacing: 4px;padding:7px 0px 0px 0px"><?php echo strtoupper($dist_name) ?><br> DISTRICT</h6>

                    <hr style="margin : 0px 5px 8px 43px;height : 2px;width: 158px;">
                    <select class="form-select form-select-sm mb-2" aria-label=".form-select-sm example" style="width: 238px;padding: 0px 0px 0px 5px;margin:0px 0px 0px 6px;" id="circle" onChange="getGrid1(this.value),getVillage(this.value),getWatershed(this.value),getZoomto(this.value);">
                            <option>Select Cricle</option>
                                <?php
                                while ($row = pg_fetch_row($result2)) {
                                ?>
                                <option value="<?php echo $row[1] ?>,<?php echo $row[2]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                    <div class="row" id="content_btn_mobile">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="padding: 0px;width:238px;margin:0px 0px 0px 19px;">
                                    <input type="radio" class="btn-check btn-select1-mobile" name="btnradio423" id="btnradio123" autocomplete="off" checked style="border-color: #3C457C;width:190px;padding: 0px 0px 0px 14px;">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio123" autofocus>GridNo</label>

                                    <input type="radio" class="btn-check btn-select1-mobile" name="btnradio423" id="btnradio223" autocomplete="off">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio223">Village</label>

                                    <input type="radio" class="btn-check btn-select1-mobile" name="btnradio423" id="btnradio323" autocomplete="off">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio323">Watershed</label>
                                </div>
                    </div>
                    <div class="row content_row_mobile">
                                <div class="content-mobile-selection">
                                    <select name="grid_id_mobile" id="grid_id_mobile" class="form-select form-select-sm mb-3" style="width: 238px;padding: 0px 0px 0px 5px;margin:7px 0px 0px 4px;" aria-label=".form-select-sm example" onChange="getZoomto(this.value),buttonEnable1();">
                                        <!-- <select name="grid_id" class="custom-select mr-sm-2" class="inlineFormCustomSelect"
                                        id="grid1"> -->
                                        <option>Select Grid No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row content_row_mobile">
                                <div class="content-mobile-selection">
                                    <select name="villageMobile" id="village_id_mobile" class="form-select form-select-sm mb-3" style="width: 238px;padding: 0px 0px 0px 5px;margin:7px 0px 0px 4px;" aria-label=".form-select-sm example" onChange="getZoomto(this.value);">
                                        <option>Select Village Location</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row content_row_mobile">
                                <div class="content-mobile-selection">
                                    <select name="watershedMobile" id="watershed_id_mobile" class="form-select form-select-sm mb-3" style="width: 238px;padding: 0px 0px 0px 5px;margin:7px 0px 0px 4px;" aria-label=".form-select-sm example" onChange="getZoomto(this.value);">
                                        <option>Select Watershed</option>
                                    </select>
                                </div>
                            </div>




            </div>  
            
            
            <div class="selection-boxs">
                        <h6 style="text-align: center;justify-content: center;margin: 6px 0px 6px 0px;font-size: 12px;padding: 9px 0px 0px 0px;">LAYER CONTROL</h6>
                        <hr style="margin : 0px 5px 8px 46px;height : 2px;width: 158px;">
                        <div class="row" id="profile1">
                            <div></div>
                        </div>

            </div>

            <div class="selection-boxs">
                <h6 style="text-align: center;justify-content: center; margin: 6px 0px 6px 0px;font-size: 12px;padding: 6px 0px 6px 0px;">☰ LEGEND</h6>
                <hr style="margin : 0px 5px 8px 48px;height : 2px;width: 158px;">
                <div id="legend1">
                        <div class="row" style="text-align: center;justify-items: center;padding: 35px;color:#787878;font-size: 11px;">
                            <h6 style="font-size: 12px;">CLICK ON MAP<br> TO VIEW LEGEND</h6>
                        </div>
                    </div>
            </div>
           
    </div>

    <div class="mobile-report" id="mobile_report_id" style="padding:5px">
        <a href="javascript:void(0)" class="btn-close closebtn" style="height: 2px; width:2px" onclick="closeMobileReport()">
            </a>
        <div  id="latlongs_mobile" style="font-size:10px;background-color: #EEEEEE;border-radius: 10px;height: 45px;margin-bottom: 2px;">
        </div>
        <div  id="report_btn_mobile" style="color: white;background-color: #EEEEEE;border-radius: 10px;">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group" style="width:100%;background-color: #EEEEEE;width: 98%;margin: 4px">
                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="lulc1_mobile" autocomplete="off" style="border-color: #3C457C;" onclick="getLulcMobile()">
                <label class="btn btn-outline-primary lablesize" for="lulc1_mobile">LULC</label>

                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="hgeom1_mobile" autocomplete="off" onclick="getHgeom()">
                <label class="btn btn-outline-primary lablesize" for="hgeom1_mobile">HGEOM</label>

                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="slope_id1_mobile" autocomplete="off" onclick="getSlope()">
                <label class="btn btn-outline-primary lablesize" for="slope_id1_mobile">SLOPE</label>
                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="so1_mobile" autocomplete="off" onclick="getSoil()">
                <label class="btn btn-outline-primary lablesize" for="so1_mobile">SOIL</label>

                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="cs_id1_mobile" autocomplete="off" onclick="getCropSuitabilityMobile()">
                <label class="btn btn-outline-primary lablesize" for="cs_id1_mobile">CROPS</label>
                <input type="radio" class="btn-check btn-select211" name="btnradio321" id="action1_mobile" autocomplete="off" onclick="getActionPlan()">
                <label class="btn btn-outline-primary lablesize" for="action1_mobile">APLAN</label>
            </div>
            <div id="sidebarcontent_mobile" style="color:black;font-size:10px;padding: 4px 0px 4px 7px;">
            </div>
        </div>
    </div>


    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div style="width: 205px;"> <a style="text-decoration: none;" href="http://solaris-ar.com/index.html" class="nav_logo"> <img src="../img/SOLARISLogov.png" alt="" height="45px" width="180x" style="margin: 0px 0px 5px 14px;">
                    <!-- <h5><span class="nav_logo-name" style="margin-left: 17px;letter-spacing: 1.5px;"></span></h5> -->
                </a>
                <hr style="margin : 0px 4px 0px 9px;height : 1px;background-color: white;">
                <div class="nav_list">
                    <!-- container for cricle selection -->
                    <div class="container" id="cricle_container" style="text-align: center;justify-content: center;">
                        <div class="row">
                            <h6 style="margin :12px 0px 5px 0px;font-size: 12px;font-weight: 600;text-align: center;letter-spacing: 2px;"><?php echo strtoupper($dist_name) ?><br> DISTRICT</h6>
                            
                            <!-- <hr style="margin : 0px 5px 8px 9px;height : 2px;width: 158px;"> -->
                            <select class="form-select form-select-sm mb-2" aria-label=".form-select-sm example" style="width: 190px;padding: 0px 0px 0px 5px;margin:0px 0px 0px -5px;" id="circle" onChange="getGrid1(this.value),getVillage(this.value),getWatershed(this.value),getZoomto(this.value);">
                            <option>Select Cricle</option>
                                <?php
                                while ($row = pg_fetch_row($result1)) {
                                ?>
                                <option value="<?php echo $row[1] ?>,<?php echo $row[2]; ?>"><?php echo $row[0]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="row" id="content_btn" >
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="padding: 0px;">
                                    <input type="radio" class="btn-check btn-select1" name="btnradio4" id="btnradio1" autocomplete="off" checked style="border-color: #3C457C;width:190px;padding: 0px 0px 0px 14px;">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio1" autofocus>GridNo</label>

                                    <input type="radio" class="btn-check btn-select1" name="btnradio4" id="btnradio2" autocomplete="off">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio2">Village</label>

                                    <input type="radio" class="btn-check btn-select1" name="btnradio4" id="btnradio3" autocomplete="off">
                                    <label class="btn btn1 btn-outline-primary lablesize" for="btnradio3">Watershed</label>
                                </div>
                            </div>
                            <div class="row content_row">
                                <div class="content">
                                    <select name="grid_id" id="grid1" class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" onChange="getZoomto(this.value)">
                                        <!-- <select name="grid_id" class="custom-select mr-sm-2" class="inlineFormCustomSelect"
                                        id="grid1"> -->
                                        <option>Select Grid No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row content_row">
                                <div class="content">
                                    <select name="village" id="village_id" class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" onChange="getZoomto(this.value);">
                                        <option>Select Village Location</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row content_row">
                                <div class="content">
                                    <select name="watershed" id="watershed_id" class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" onChange="getZoomto(this.value);">
                                        <option>Select Watershed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- this for layer controller -->

                    <div class="container" id="layer-control">
                        <div class="row">
                        <h6 style="text-align: center;justify-content: center;margin: 6px 0px 6px 0px;font-size: 12px;">LAYER CONTROL</h6>
                            <hr style="margin : 0px 5px 8px 9px;height : 2px;width: 158px;">
                        </div>
                        <div class="row" id="profile">
                            <div></div>
                        </div>
                    </div>

                    <!-- <div class="container" id="legendBtn">
                        <div class="row">
                        <button onclick="show_hide_legend()" type="button" id="legend_btn" class="btn btn-success btn-sm">☰
                        Show Legend</button>
                        </div>
                    </div> -->

                    <div class="container" id="legendtitle">
                        <div class="row">

                            <button onclick="show_hide_legend()" type="button" id="legend_btn" class="btn btn-sm" style="background-color: transparent;color:black">
                                <h6 style="text-align: center;justify-content: center; margin: 6px 0px 6px 0px;font-size: 12px;">☰ LEGEND</h6>
                            </button>
                            <hr style="margin : 0px 5px 8px 9px;height : 2px;width: 158px;">
                        </div>
                    </div>

                    <div class="container" id="legend">
                        <div class="row" style="text-align: center;justify-items: center;padding: 35px;color:#787878;font-size: 11px;">
                            <h6 style="font-size: 12px;">CLICK ON MAP<br> TO VIEW LEGEND</h6>
                        </div>
                    </div>



                    <div class="container" id="info_scroll" style="position: relative;">
                        <!-- <div class="row"> -->
                        <marquee behavior="scroll" direction="left" style="position:fixed;background-color:#EEEEEE;color:black;font-size:13px;width:178px;">
                            Click on Map for info and Legend</marquee>
                        <!-- </div> -->
                    </div>



                    <div class="sidebar1" id="sidebar1">
                        <div class="sidebar-content">
                            <!-- <div class="row" id="profile">
                            <div></div>
                        </div> -->
                        </div>
                    </div>
                    <!-- <div class="container cropsuitablity" style="height: 50px;">
                    <a href="test.php">
                    Crop Suitability
                </a>
                    </div> -->

                    <!-- 
                    <div id="layer-switcher" class="ol-control ol-unselectable ol-control-layer-switcher">
                    <input type="checkbox" id="layer-switcher-checkbox" checked>
                    <label for="layer-switcher-checkbox" data-text-on="ON" data-text-off="OFF"></label>
                    </div> -->


                    <!-- <a href="#" class="nav_link active"><i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Dashboard</span> </a> 
                    <a href="#" class="nav_link"><i class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> </a> 
                    <a href="#" class="nav_link"><i class='bx bx-message-square-detail nav_icon'></i><span class="nav_name">Messages</span> </a> 
                    <a href="#" class="nav_link"><i class='bx bx-bookmark nav_icon'></i><span class="nav_name">Bookmark</span> </a> 
                    <a href="#" class="nav_link"><i class='bx bx-folder nav_icon'></i> <span class="nav_name">Files</span> </a>
                    <a href="#" class="nav_link"><i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Stats</span> </a>  -->
                </div>
            </div>
            <!-- <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> -->
            </a>
            <div class="side-footer">
                <!-- Button trigger modal -->

             <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">About&nbsp;|</a>
             <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1">Feedback&nbsp;|</a>
             <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">Contact Us</a>
             


                <!-- <a href="about.php">
                    About&nbsp;|
                </a> -->
                <!-- <a href="feedback.php">
                    Feedback&nbsp;|
                </a>
                <a href="contact.php">
                    Contact Us
                </a> -->
            </div>
        </nav>
    </div>

    <div id="mySidebarRight" class="container sidebarright">
        <a href="javascript:void(0)" class="btn-close closebtn" style="height: 2px; width:2px" onclick="closeNav()">
        </a>
        <div class="container latloggrid" id="latlongs">
        </div>


        <!-- <div id="accordion">
            <meta charset="utf-8">
            <h6 class="accordion-toggle"><span>Resource Maps</span></h6>
            <div class="accordion-content default">
                <div class="container rightbuttons">



                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width:225px">
                        <input type="radio" class="btn-check btn-select2" name="btnradio" id="lulc" autocomplete="off" checked style="border-color: #3C457C;">
                        <label class="btn btn-outline-primary lablesize" for="lulc">LULC</label>

                        <input type="radio" class="btn-check btn-select2" name="btnradio" id="hgeom" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="hgeom">HGEOM</label>

                        <input type="radio" class="btn-check btn-select2" name="btnradio" id="slope_id" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="slope_id">SLOPE</label>
                        <input type="radio" class="btn-check btn-select2" name="btnradio" id="so" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="so">SOIL</label>
                    </div>
                    <div id="sidebarcontent"></div>
                </div>
            </div>
            <h6 class="accordion-toggle">Derivative Maps</h6>
            <div class="accordion-content" style="display: none;">
                <div class="container rightbuttons">



                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width:225px">
                        <input type="radio" class="btn-check btn-select2" name="btnradio1" id="ld" autocomplete="off" checked style="border-color: #3C457C;">
                        <label class="btn btn-outline-primary lablesize" for="ld">Degradation</label>

                        <input type="radio" class="btn-check btn-select2" name="btnradio1" id="lc" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="lc">Capability</label>

                        <input type="radio" class="btn-check btn-select2" name="btnradio1" id="li" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="li">Irrigability</label>
                    </div>
                    <div id="sidebarcontent_derivative"></div>
                </div>
            </div>
            <h6 class="accordion-toggle">Recommendations</h6>
            <div class="accordion-content" style="display: none;">
                <div class="container rightbuttons">



                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width:225px">
                        <input type="radio" class="btn-check btn-select2" name="btnradio2" id="cs" autocomplete="off" checked style="border-color: #3C457C;">
                        <label class="btn btn-outline-primary lablesize" for="cs">Crop Suitability</label>

                        <input type="radio" class="btn-check btn-select2" name="btnradio2" id="ap" autocomplete="off">
                        <label class="btn btn-outline-primary lablesize" for="ap">Action Plan</label>
                    </div>
                    <div id="sidebarcontent_recommendation"></div>
                </div>
            </div>
        </div> -->

        <div class="accordion">
            <div class="accordion-item active">
                <div class="accordion-header">
                    <span class="icon">-</span>Resource Information
                </div>
                <div class="accordion-content">
                    <div class="container rightbuttons">



                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width:225px">
                            <input type="radio" class="btn-check btn-select2" name="btnradio" id="lulc" autocomplete="off" checked style="border-color: #3C457C;" onclick="getLulc()">
                            <label class="btn btn-outline-primary lablesize" for="lulc">LULC</label>

                            <input type="radio" class="btn-check btn-select2" name="btnradio" id="hgeom" autocomplete="off" onclick="getHgeom()">
                            <label class="btn btn-outline-primary lablesize" for="hgeom">HGEOM</label>

                            <input type="radio" class="btn-check btn-select2" name="btnradio" id="slope_id" autocomplete="off" onclick="getSlope()">
                            <label class="btn btn-outline-primary lablesize" for="slope_id">SLOPE</label>
                            <input type="radio" class="btn-check btn-select2" name="btnradio" id="so" autocomplete="off" onclick="getSoil()">
                            <label class="btn btn-outline-primary lablesize" for="so">SOIL</label>
                        </div>
                        <div id="sidebarcontent"></div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header">
                    <span class="icon">+</span>Recommendations
                </div>
                <div class="accordion-content">
                    <div class="container rightbuttons">



                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width:225px">
                            <input type="radio" class="btn-check btn-select2" name="btnradio2" id="cs" autocomplete="off" checked style="border-color: #3C457C;" onclick="getCropSuitability()">
                            <label class="btn btn-outline-primary lablesize" for="cs">Crop Suitability</label>

                            <input type="radio" class="btn-check btn-select2" name="btnradio2" id="ap" autocomplete="off" onclick="getActionPlan()">
                            <label class="btn btn-outline-primary lablesize" for="ap">Action Plan</label>
                        </div>
                        <div id="sidebarcontent_recommendation"></div>
                    </div>
                </div>
            </div>
        </div>






        <div class="container getreport">
            <div class="row" style="align-items: center;justify-content: center;">
                <button id="apgetreport" type="button" class="btn btn-outline-primary" style="background-color:  #79AE52;color:white;padding: 0px;border-radius: 20px;" onclick="getAPReport()">Generate Report</button>
            </div>
        </div>
    </div>
    <!--Container Main start-->
    <!-- <div class="container height-100 bg-light"> -->

    <!-- </div> class="height-100 bg-light"> -->

    <!-- <h1>Hello, world!</h1> -->

    <div class="modal bd-example-modal-md fade" id="exampleModal11" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel" style="margin-left: 188px;">Upload KML</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size: 12px;word-wrap: break-word;">
      <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="kmldrop" style="text-align: center;align-items: center;">
                        <img src="./img/CF.png" alt="" style="width: 40px;height:34px;"/><br>
                        <!-- <input type="file" id="file-input" accept=".kml" class="form-control-sm"> -->
                        <label class="label">
                            <input id="file-input" type="file" required/>
                            <span>Choose File</span>
                        </label>
                        <p style="font-size: 10px;font-weight: 400;padding: 0px;margin: -2px 0px 0px 0px;">Supported Formats</p>
                        <p style="font-size: 10px;font-weight: 400;padding: 0px;margin: 0px 0px 5px 0px;">.kml, .kmz, GeoJSON</p>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        
      </div>
    </div>
  </div>
</div>


<!-- Modal for about-->
<div class="modal bd-example-modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="margin-left: 348px;" id="exampleModalLabel">About</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size: 12px;word-wrap: break-word;">
             <div class="paragraph" style="word-wrap: break-word;">
              Integrated Land and Soil Resources Information System (ILSRIS) is a user-friendly web and mobile application which is developed under
              Natural Resources Inventory for Micro Level Agricultural Planning (NRIMAP) to provide highly intuitive and effective recommendation 
              system which has accurate information and reports for multiple players across the Agriculture Ecosystem.
                            </div>
              <br style="content: '';margin: 2em; display: block; font-size: 30%;" />
              <div class="paragraph" style="word-wrap: break-word;">
              Natural Resources Inventory for Micro Level Agricultural Planning (under Comprehensive Agriculture Management Program NRIMAP) is a pilot
               project implemented in three districts namely Namsai, Lower Subansiri and Tawang selected from three elevation regions of Arunachal Pradesh State.
                ILSRIS is designed, developed and implemented by Remote Sensing Instruments LLP (RSI LLP), Hyderabad for Arunachal Pradesh Space Applications
                 Centre, Department of Science and Technology, Govt. of Arunachal Pradesh.
                            </div>
              <br style="content: '';margin: 2em; display: block; font-size: 30%;" />
              <div class="paragraph" style="word-wrap: break-word;">
              ILSRIS is developed using State-of-the-art Geospatial Technologies involving Remote Sensing, GIS, Photogrammetry and other GIS Technologies.
               It is implemented using high-resolution satellite data from national and international satellite data providers.
                            </div>
              <br style="content: '';margin: 2em; display: block; font-size: 30%;" />
              <div class="paragraph" style="word-wrap: break-word;">
              ILSRIS also offers a broad spectrum of maps and information like Base Map, Thematic Maps like Agriculture and Other Land Use Land Cover,
               Hydro-geomorphology, Slope, Soil and Soil Derivative Maps, Action Plan for Land and Water Resources Development and Crop Suitability
               Maps on 1:10,000 scale. A Comprehensive and easy to access soil health report, crop suitability and action plan for land and water resources
                 development is available for each land parcel and can be downloaded on both web and mobile applications.
                            </div>
              <br style="content: '';margin: 2em; display: block; font-size: 30%;" />
              <div class="paragraph" style="word-wrap: break-word;">
              This Highly effective ILSRIS is useful for multiple players across agriculture ecosystem and is a strong recommendation system for farmers
               which will in turn increase their economic growth by suggesting them to cultivate suitable crops with utilizing available nutrients and natural resources.
                            </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        
      </div>
    </div>
  </div>
</div>

<!-- model for feedback -->
<div class="modal bd-example-modal-lg fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1" style="margin-left: 348px;">Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="display: flex;justify-content: center; align-items: center;font-size: 12px;">
      <form class="form-container" action="send.php" style="width: 400px;justify-content: center;align-items: center;text-align: center;">
          <div class="form-row">
            <div class="form-group col-md-12" style="margin-top: 10px;">
              <label for="inputfirstName">First Name</label>
              <input type="text" class="form-control" id="inputfirstName" placeholder="First Name" name="firstname">
            </div>
            <div class="form-group col-md-12" style="margin-top: 10px;">
              <label for="inputlastName">Last Name</label>
              <input type="text" class="form-control" id="inputlastName" placeholder="Last Name" name="lastname">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12" style="margin-top: 10px;">
              <label for="inputEmail">Email</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email">
            </div>
            <div class="form-group col-md-12" style="margin-top: 10px;">
              <label for="inputorganization">Organization</label>
              <input type="text" class="form-control" id="inputorganization" placeholder="Organization" name="org">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12" style="margin-top: 10px;">
              <label for="inputEmail">Comments</label>
              <textarea style="height: 140px" class="form-control" name="comment" placeholder="Comment"></textarea>
            </div>
          </div>
          <div class="form-row" style="display: flex; justify-content: center; height: 35px; margin-bottom: 10px;">
            <button class="btn btn-sm btn-primary" style="border-radius: 15px;background-color:#4B578C;font-size: 12px;height: 28px;margin-top:18px">Submit</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        
      </div>
    </div>
  </div>
</div>

<!-- model for contact -->
<div class="modal bd-example-modal-lg fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="text-align: center;margin-left: 348px;" id="exampleModalLabel2">Contact Us</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size: 12px;">
      <div class="col-12">
                        <!-- <h4 style="text-align: center; margin-top: 1%;">Contact</h4> -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" >
                                <img style="margin-top: 18px;height: 70px;width:70px;" class="card-img logo img-fluid mx-auto d-block" src="../img/arplogo.jpg" alt="Card image">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                            <h5 class="card-title">Arunachal Pradesh Space Application Centre</h5>
                                <h6 style="padding: 0px;margin:0px">Dept. of Science & Technology</h6>
                                <h6 style="padding: 0px;margin:0px">Government of Arunachal Pradesh</h6>
                               
                                <p style="padding: 0px;margin:0px">Address - Civil Secretariat, ITANAGAR - 791111 , Arunachal Pradesh</p>
                                <p style="padding: 0px;margin:0px">website: <a style="padding: 0px;margin:0px" href="https://www.srsac.arunachal.gov.in" target="_blank" style="color:#4B578C">www.srsac.arunachal.gov.in</a></p>
                                <!-- <p>Phone Number:----------</p> -->
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <img class="card-img logo img-fluid mx-auto d-block" style="height: 50px;width: 267px;" src="../img/RSILLP.jpg" alt="Card image">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                                <!-- <h5>Remote Sensing Instruments LLP (RSI LLP)</h5> -->
                                <h6 style="font-size: 11px;">Plot #7 Type-I IE Kukatpally, Hyderabad, 500072 TS India</h6>
                                <p style="padding: 0px;margin:0px"><a href="https://www.rsigeotech.com" target="_blank" style="color:#4B578C">www.rsigeotech.com</a>| info@rsigeotech.com 
                                    </p>
                                <p>+91 40 4017 5518 | +91 40 2307 8566</p>
                            </div>
                        </div>
                    </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        
      </div>
    </div>
  </div>
</div>

    <div id="maps">
    <div id="map" id="main"></div>
    </div>
    <div id="mouse-position"></div>

    <!-- </div> -->
    <!--Container Main end-->
    <footer class="" style="margin: 0px;padding: 0px;height: 0px;">
        <!-- <ul class="justify-content-center border-bottom">
          <li class=""><a href="#" class="nav-link px-2 text-muted">Home</a></li>
          <li class=""><a href="#" class="nav-link px-2 text-muted">Features</a></li>
          <li class=""><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
        </ul> -->
        <p class="text-center text-muted" style="margin-top: 9px;color: black;font-size:12px;padding-bottom: 7px;">Designed and Developed by Remote Sensing
            Instruments LLP <a href="https://rsigeotech.com/" style="color: #3C457C;text-decoration: none;" target="_blank">(RSI LLP)</a> for Arunachal Pradesh Space Application Centre <a href="https://www.srsac.arunachal.gov.in/" style="color: #3C457C;text-decoration: none;" target="_blank">(APSAC)</a>, Government of Arunachal Pradesh,
            Copyrights © 2024</p>
    </footer>

    <script src="./js/testing.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous"></script>

    <script src="../js/ol.js"></script>

    <script src="//turbo87.github.io/sidebar-v2/js/ol3-sidebar.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.css" /> -->
    <script src="https://cdn.rawgit.com/Viglino/ol-ext/master/dist/ol-ext.min.js"></script>

    <script src="./js/map.js"></script>
    <!-- <script src="./js/map1.js"></script> -->
    <script src="./js/labes_soil_info.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="../js/geopoint.js"></script>
    <script src="./js/weather.js"></script>

    <script>
        const btnlist = document.querySelectorAll('.btn-select1');
        const allcontent = document.querySelectorAll('.content');

        btnlist.forEach((bt, index) => {
            allcontent[0].classList.add('active');
            bt.addEventListener('click', () => {
                // btnlist.forEach(bt => {bt.classList.remove('active')});
                // bt.classList.add('active');
                allcontent.forEach(content => {
                    content.classList.remove('active')
                });
                allcontent[index].classList.add('active');
            })
        })
    </script>


    <script>
        function getCircle(val) {
            var array = val.split(','),
                a = array[0];
            $.ajax({
                type: "POST",
                url: "getCircle.php",
                data: 'district=' + a,
                success: function(data) {
                    $("#circle").html(data);
                }
            });
        }

        function getGrid1(val) {
            var array = val.split(','),
                a = array[0];
            $.ajax({
                type: "POST",
                url: "getGrid.php",
                data: 'circle_id=' + a,
                success: function(data) {
                    $("#grid1").html(data);
                    $("#grid_id_mobile").html(data);
                }
            });
        }


        function getVillage(val) {
            var array = val.split(','),
                a = array[0];
            $.ajax({
                type: "POST",
                url: "getVillage.php",
                data: 'circle_id=' + a,
                success: function(data) {
                    $("#village_id").html(data);
                    $("#village_id_mobile").html(data);
                }
            });
        }

        function getWatershed(val) {
            var array = val.split(','),
                a = array[0];
            $.ajax({
                type: "POST",
                url: "getWatershed.php",
                data: 'circle_id=' + a,
                success: function(data) {
                    $("#watershed_id").html(data);
                    $("#watershed_id_mobile").html(data);
                }
            });
        }
    </script>
    <!-- accordion search script -->
    <script>
        // $(document).ready(function($) {
        //     $('.accordion-toggle').click(function() {
        //         //Close all
        //         $(".accordion-content").each(function() {
        //             $(this).slideUp('fast');
        //         })
        //         $(this).next().slideToggle('fast');
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function() {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(function(item) {
                const header = item.querySelector('.accordion-header');
                    header.addEventListener('click', function() {
                    // Toggle active class to expand/collapse accordion item
                    item.classList.toggle('active');
                    // Toggle the icon based on the active state
                    const icon = header.querySelector('.icon');
                    icon.textContent = item.classList.contains('active') ? '-' : '+';

                    // Close other accordion items
                    accordionItems.forEach(function(otherItem) {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            otherItem.classList.remove('active');
                            otherItem.querySelector('.accordion-header .icon').textContent = '+';
                        }
                    });
                });
            });
        });
    </script>
    <!-- accordion search script -->
    <script>
        var subMenu = document.getElementById('subMenu');

        function openToggle(){
            subMenu.classList.toggle('open-menu');
        }
    </script>

<script>
function openMobileSidebar() {
            var x = document.getElementById("mobile-scale-on-id");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            }
        // function resize(){
        //     if(window.matchMedia("(min-width: 480px)")){
                
        //         closeMobileSidebar()
        //     }
        //     else{
        //         openMobileSidebar();
        //     }
        // }
        // resize();
    </script>
    <script>
         // mobile content selection
         const btnlistMobile = document.querySelectorAll('.btn-select1-mobile');
        const allcontentMobile = document.querySelectorAll('.content-mobile-selection');

        btnlistMobile.forEach((btmobile, index) => {
            allcontentMobile[0].classList.add('active');
            btmobile.addEventListener('click', () => {
                // btnlist.forEach(bt => {bt.classList.remove('active')});
                // bt.classList.add('active');
                allcontentMobile.forEach(contentMobile => {
                    contentMobile.classList.remove('active')
                });
                allcontentMobile[index].classList.add('active');
            })
        })

    </script>
    
</body>

</html>