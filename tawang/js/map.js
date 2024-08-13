// var container = document.getElementById('popup');
// var content = document.getElementById('popup-content');
// var closer = document.getElementById('popup-closer');

var base_url = "https://solaris-ar.com:8085/geoserver"
var current_grid_id = 0;
var grid_id = 0;
var map;
var view;




var overlay = new ol.Overlay({
  // element: container,
  autoPan: true,
  autoPanAnimation: {
    duration: 250
  }
});


/**
      * Add a click handler to hide the popup.
      * @return {boolean} Don't follow the href.
      */
// closer.onclick = function() {
//   overlay.setPosition(undefined);
//   closer.blur();
//   return false;
// };

var basemap = '';
var lulc = '';
var slope = '';
var hgeom = '';
var soil = '';
var lineament = '';
var capability = '';
var irrigability = '';
var degradation = '';
var cropsuitability = '';
var action_plan = '';
var wshed = '';
var circle_layer = '';
var dist_layer = '';
var grid_layer = '';
var tawang_drainage_l = '';
var tawang_drainage_p = '';

// var namsai_settlement_point = ''; 
// var namsai_grid_10k = ''; 
// var Admini_Line = ''; 
// var namsai_contour = ''; 
// var namsai_road = ''; 
// var namsai_drainl = ''; 
// var namsai_settlement_poly = ''; 
// var namsai_drainp = ''; 
// var Namsai_NRIMAP = ''; 
// var namsai_circle = '';



//var base_source ='';
//var grid_source = '';
//var grid_soil = ''; 
//var action_plan_source = '';
//var action_water_plan_source = '';
//var capability_source = '';
//var irregability_source = '';
//var irregability_source = '';
//var lulc_source ='';
//var slope_source ='';

var view = new ol.View({
  center: ol.proj.transform([91.94, 27.65], 'EPSG:4326', 'EPSG:3857'),
  zoom: 10.5,
  // minZoom: 10.5,
  maxZoom: 18,
});

var scaleLineControl = new ol.control.ScaleLine({
  units: "metric",
  bar: true,
  steps: 2,
  text: true,
  minWidth: 140,
  //target :  document.getElementsByClassName('ol-scale-text')
});

var mousePositionControl = new ol.control.MousePosition({
  projection: 'EPSG:4326',
  className: 'custom-mouse-position',
  target: document.getElementById('mouse-position'),
  coordinateFormat: ol.coordinate.toStringHDMS,
  undefinedHTML: '&nbsp;'
});

var mousePositionControl1 = new ol.control.MousePosition({
  coordinateFormat: ol.coordinate.createStringXY(4),
  projection: 'EPSG:32645',
  className: 'custom-mouse-position',
  target: document.getElementById('mouse-position1'),
  undefinedHTML: '&nbsp;'

});

var marker = new ol.layer.Vector({

})


var map = new ol.Map({
  target: 'map',
  layers: [

    new ol.layer.Tile(
      {
        title: "OSM",
        name: "osm",
        baseLayer: false,
        source: new ol.source.OSM(),
        // visible: true
      }),

    new ol.layer.Tile(
      {
        title: "Arunachal Pradesh",
        name: 'arunachal_pradesh',
        baseLayer: false,
        source: dist_layer = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:dist', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: true,
        displayInLayerSwitcher: false
      }),

      new ol.layer.Tile(
        {
          title: "Contour",
          name: 'tawang_contour_updated',
          baseLayer: false,
          source: grid_layer = new ol.source.TileWMS({
            url: base_url + '/wms',
            params: { 'LAYERS': 'APWS:tawang_contour_updated', 'TILED': true },
            // format : new ol.format.GeoJSON,
            serverType: 'geoserver',
            // Countries have transparency, so do not fade tiles:
            transition: 0
          }),
          visible: false,
          // displayInLayerSwitcher:false
        }),


    new ol.layer.Tile(
      {
        title: "Action Plan",
        name: '	tawang_actionplan_test',
        baseLayer: false,
        source: action_plan = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_actionplan_test', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),


    new ol.layer.Tile(
      {
        title: "Crop Suitability",
        name: 'tawang_crop_suitability_01022024',
        baseLayer: false,
        source: cropsuitability = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_crop_suitability_01022024', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),

    new ol.layer.Tile(
      {
        title: "Land Capability",
        name: 'tawang_capability_01022024',
        baseLayer: false,
        source: capability = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_capability_01022024', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),
    new ol.layer.Tile(
      {
        title: "Land Irrigability",
        name: 'tawang_irrigability_01022024',
        baseLayer: false,
        source: irrigability = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_irrigability_01022024', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
          visible: false
      }),

    new ol.layer.Tile(
      {
        title: "Land Degradation",
        name: 'tawang_land_degradation_01022024',
        baseLayer: false,
        source: degradation = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_land_degradation_01022024', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),

    new ol.layer.Tile(
      {
        title: "Soil Information",
        name: 'tawang_soil_01022024',
        baseLayer: false,
        source: soil = new ol.source.TileWMS({
          url: base_url + '/wms',
          crossOrigin: null,
          params: { 'LAYERS': 'APWS:tawang_soil_01022024', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),
    new ol.layer.Tile(
      {
        title: "HGEOM",
        name: 'tawang_hgeom',
        baseLayer: false,
        source: hgeom = new ol.source.TileWMS({
          url: base_url + '/wms',
          crossOrigin: null,
          params: { 'LAYERS': 'APWS:tawang_hgeom_updated', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),
    new ol.layer.Tile(
      {
        title: "Lineament",
        name: 'tawang_lineament',
        baseLayer: false,
        source: lineament = new ol.source.TileWMS({
          url: base_url + '/wms',
          crossOrigin: null,
          params: { 'LAYERS': 'APWS:tawang_lineament', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),
    new ol.layer.Tile(
      {
        title: "Slope",
        name: 'tawang_slope',
        baseLayer: false,
        source: slope = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_slope', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),

    new ol.layer.Tile(
      {
        title: "LULC",
        name: 'tawang_lulc_01022024',
        baseLayer: false,
        source: lulc = new ol.source.TileWMS({
          url: base_url + '/wms',
          crossOrigin: null,
          params: { 'LAYERS': 'APWS:tawang_lulc_01022024', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: true
      }),
    new ol.layer.Tile(
      {
        title: "Watershed",
        name: 'tawang_watershed',
        baseLayer: false,
        source: wshed = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_watershed', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: false
      }),
     
        new ol.layer.Tile(
          {
            title: "Drainage Poly",
            name: 'tawang_drainp',
            baseLayer: false,
            source: tawang_drainage_p = new ol.source.TileWMS({
              url: base_url + '/wms',
              params: { 'LAYERS': 'APWS:tawang_drainp', 'TILED': true },
              serverType: 'geoserver',
              // Countries have transparency, so do not fade tiles:
              transition: 0
            }),
            visible: true
          }),
        new ol.layer.Tile(
          {
            title: "Drainage Line",
            name: 'tawang_drainl',
            baseLayer: false,
            source: tawang_drainage_l = new ol.source.TileWMS({
              url: base_url + '/wms',
              params: { 'LAYERS': 'APWS:tawang_drainl', 'TILED': true },
              serverType: 'geoserver',
              // Countries have transparency, so do not fade tiles:
              transition: 0
            }),
            visible: true
          }),
    new ol.layer.Tile(
      {
        title: "Base Map",
        name: 'Tawang_BaseLayer',
        baseLayer: false,
        source: base_source = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:Tawang_BaseLayer', 'TILED': true },
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: true
      }),

    new ol.layer.Tile(
      {
        title: "Circle",
        name: 'tawang_circle_boundary',
        baseLayer: false,
        source: circle_layer = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_circle_boundary', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: true,
        // displayInLayerSwitcher:false
      }),
    new ol.layer.Tile(
      {
        title: "Grid",
        name: 'tawang_10k_01022024',
        baseLayer: false,
        source: grid_layer = new ol.source.TileWMS({
          url: base_url + '/wms',
          params: { 'LAYERS': 'APWS:tawang_10k_01022024', 'TILED': true },
          // format : new ol.format.GeoJSON,
          serverType: 'geoserver',
          // Countries have transparency, so do not fade tiles:
          transition: 0
        }),
        visible: true,
        // displayInLayerSwitcher:false
      }),
  ],
  overlays: [overlay],
  view: view,
  controls: ol.control.defaults().extend([
    scaleLineControl
  ]),
});

var sidebar = new ol.control.Sidebar({ element: 'sidebar1', position: 'left' });


map.addControl(sidebar);
map.addControl(mousePositionControl);
map.addControl(mousePositionControl1);


// ------------------------------------------------------------------------------
// for getting the locate button
var source1 = new ol.source.Vector();
const layer1 = new ol.layer.Vector({
  source: source1,
  title: "locations",
  name: 'locations',
  baseLayer: false,
  displayInLayerSwitcher: false,
});
map.addLayer(layer1);


navigator.geolocation.watchPosition(
  function (pos) {
    const coords = [pos.coords.longitude, pos.coords.latitude];
    const accuracy = new ol.geom.Polygon(coords, pos.coords.accuracy);
    source1.clear(true);
    source1.addFeatures([
      new ol.Feature(
        accuracy.transform('EPSG:4326', map.getView().getProjection())
      ),
      new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat(coords))),
    ]);
  },
  function (error) {
    alert(`ERROR: ${error.message}`);
  },
  {
    enableHighAccuracy: true,
  }
)


const locate = document.createElement('div');
locate.className = 'ol-control ol-unselectable locate';
locate.innerHTML = '<button title="Locate me"><img src ="../img/iconizer-location-crosshairs-solid.svg" alt="My Happy SVG"/></button>';
locate.addEventListener('click', function () {
  if (source1 != null) {
    map.getView().fit(source1.getExtent(), {
      maxZoom: 18,
      duration: 500,
    });
  }
});
map.addControl(
  new ol.control.Control({
    element: locate,
  })
);







// --------------------------------------------------------------------------------

var iconFeature, vectorSource, vectorLayer;
var iconStyle = new ol.style.Style({
  image: new ol.style.Icon({
    anchor: [0.5, 1],
    // anchorXUnits: "fraction",
    // anchorYUnits: "pixels",
    src: '../img/marker.png',
  })
});

// Add a layer switcher outside the map
var switcher = new ol.control.LayerSwitcher(
  {
    target: $("#profile > div").get(0)
  });

  var switcher1 = new ol.control.LayerSwitcher(
    {
      target: $("#profile1 > div").get(0)
    });

map.addControl(switcher);
map.addControl(switcher1);
var coordinate;
map.on('singleclick', function (evt) {

  openNav();
  openMobileReport();
  $("#latlongs").empty();
  $("#latlongs_mobile").empty();
  
  //  closeNav();
  $("#report_button").hide();
  $("#popup-content").empty();
  $("#sidebarcontent").empty();
  $("#sidebarcontent_mobile").empty();
  coordinate = evt.coordinate;
  //overlay.setPosition(coordinate);
  var viewResolution = /** @type {number} */ (view.getResolution());
  var url = soil.getGetFeatureInfoUrl(
    evt.coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });


  var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
  var lon = lonlat[0];
  var lat = lonlat[1];
  console.log('asdfasdfasdf', lon, lat);
  map.removeLayer(vectorLayer);

  iconFeature = new ol.Feature({
    geometry: new ol.geom.Point(new ol.proj.fromLonLat([lon, lat]))
  });

  iconFeature.setStyle(iconStyle);

  vectorSource = new ol.source.Vector({
    features: [iconFeature],
  });

  vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    title: "marker_pin",
    name: 'marker_pin',
    baseLayer: false,
    displayInLayerSwitcher: false,
  });

  map.addLayer(vectorLayer);

  //console.log('url '+url)
  if (url) {
    // use to get map info on clicking on map
    $.ajax({
      url: url,
      type: "GET",
      success: function (data, status, jqXHR) {
        $("#popup-content").empty();
        $("#report_button").hide();

        if (data.features.length == 1) {

          for (index = 0; index < data.features.length; index++) {

            for (var k in data.features[index].properties) {
              if (data.features[index].properties.hasOwnProperty(k)) {
                //$("#popup-content").append("<div>" + k + " : " + data.features[index].properties[k] +"</div><br>");
                if (k == 'id') {
                  console.log("id -->" + data.features[index].properties[k]);
                  id = data.features[index].properties[k];
                  //soil_code = data.features[index].properties[k];
                }

              }
            }
          }

          //getAttributes(evt,slope_source);
          // collect data from other layers 
          all_layers = map.getLayers();
          all_layers.forEach(layer => {

            //console.log("complete layer  ",layer);
            if (layer.getVisible() && layer.N.baseLayer == false) {
              // console.log(layer.getVisible());
              // console.log("layer source  ",layer.getSource());
              // console.log(layer.getProperties().title);

              // getAttributes(evt, layer.getSource(), layer.getProperties().title  );
            }

          });
          gettingDataFromUrl();
          $("#sidebarcontent").empty();
          $("#sidebarcontent_mobile").empty();
          getVisibleLayerslist();
         
          //sleep(1000);

          //findIntersection();
          //getslope();
          //getLandCapability();
          //getActionPlanLand();
          //getDistrict();



        }
        else { $("#report_button").hide(); }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }  // grid  attribute popup 
});

function getAttributes(evt, layer_source, layer_title) {
  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  url1 = layer_source.getGetFeatureInfoUrl(
    evt.coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });
  $("#sidebarcontent").empty();
  $("#sidebarcontent_derivative").empty();
  $("#sidebarcontent_recommendation").empty();
  //  console.log(url1);
  if (url1) {
    // use to get map info on clicking on map
    $.ajax({
      // use to get popup info from the all layer on the map
      url: url1,
      type: "GET",
      success: function (data1, status, jqXHR) {
        // console.log(data1);
        if (data1.features.length == 1) {
          // $("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          if (layer_title == 'lulc') {
            $("#sidebarcontent").append("<div>" + "<h6 style='line-height:2px'>Land Use Land Cover </h6>" + "</div><br>");
          }
          for (index = 0; index < data1.features.length; index++) {

            for (var k in data1.features[index].properties) {
              if (data1.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                // console.log(k , data1.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(popup_labels).forEach(([key, value]) => {

                  if (key == k) {
                    //console.log(key +" -> "+ value);
                    $("#sidebarcontent").append("<div>" + "<strong>" + value + "</strong>" + " : " + data1.features[index].properties[k] + "</div><br>");
                  }

                });

                // Object.entries(labels).forEach(([key, value]) => 
                // {

                //   if (key == k )
                //   {
                //     //console.log(key +" -> "+ value);
                //     $("#sidebarcontent").append("<tr><td>" + value + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                //    }

                // });


              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }

}
// -------------------------------------------------------------------------------------

var soil_code = '';
var soil_class = '';
var soil_description = '';
var s1 = 0;
var s2 = 0;
var s3 = 0;
var action_pla = '';
var dist_name = null;
var circle_name = null;
var id = 0;
var mini_wshed = null;
var grid_no = '';


// report
// $('#map').click(function(evt){
//do something
function gettingDataFromUrl() {


  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var soil_url = soil.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  var crop_suitability_url = cropsuitability.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });
  console.log('----------------', crop_suitability_url)
  var action_plan_url = action_plan.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });


  var circle_url = circle_layer.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });
  var grid_url = grid_layer.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });
  var watershed_url = wshed.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });


  //console.log('crop url',url_crop_suitability);

  if (crop_suitability_url) {
    $.ajax({
      // use to get popup info from the crop suitability layer on the map
      url: crop_suitability_url,
      type: "GET",
      success: function (crop_data, status, jqXHR) {
        if (crop_data.features.length == 1) {

          for (index = 0; index < crop_data.features.length; index++) {
            // console.log('s1', crop_data.features[index].properties['s1'],'s2', crop_data.features[index].properties['s2'],
            //'s3 :', crop_data.features[index].properties['s3'])
            for (var k in crop_data.features[index].properties) {
              if (crop_data.features[index].properties.hasOwnProperty(k)) {

                //soil_data_report = {
                s1 = crop_data.features[index].properties['s1'];
                s2 = crop_data.features[index].properties['s2'];
                s3 = crop_data.features[index].properties['s3'];


                // act_pla_la : data1.features[index].properties['act_pla_la'],
                //  coordinate :coordinate
                //}


              }
            }

            //getReportCropSuitability(reportData1);
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }



  if (soil_url) {
    $.ajax({
      // use to get popup info from the soil layer on the map
      url: soil_url,
      type: "GET",
      success: function (soil_data, status, jqXHR) {
        if (soil_data.features.length == 1) {

          for (index = 0; index < soil_data.features.length; index++) {

            for (var k in soil_data.features[index].properties) {
              if (soil_data.features[index].properties.hasOwnProperty(k)) {
                //console.log("data" +soil_data.features[index].properties['soil_code'])

                //soil_data_report = {
                soil_code = soil_data.features[index].properties['soil_code'];
                soil_class = soil_data.features[index].properties['classifica'];
                soil_description = soil_data.features[index].properties['descriptio'];
                // coordinate =coordinate;
                // id=soil_data.features[index].properties['id'];

                // s1___highl : data1.features[index].properties['s1___highl'],
                // s2___moder : data1.features[index].properties['s2___moder'],
                // s3___margi : data1.features[index].properties['s3___margi'],

                // act_pla_la : data1.features[index].properties['act_pla_la'],
                // coordinate :coordinate
                //}


              }
            }
            // getAPReport(reportData);
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }

  if (action_plan_url) {
    $.ajax({
      // use to get popup info from the action plan layer on the map
      url: action_plan_url,
      type: "GET",
      success: function (action_data, status, jqXHR) {
        if (action_data.features.length == 1) {

          for (index = 0; index < action_data.features.length; index++) {

            for (var k in action_data.features[index].properties) {
              if (action_data.features[index].properties.hasOwnProperty(k)) {
                //console.log("data" +soil_data.features[index].properties['soil_code'])

                //soil_data_report = {
                action_pla = action_data.features[index].properties['action_pla'];
                console.log('action plan', action_pla);

                // s1___highl : data1.features[index].properties['s1___highl'],
                // s2___moder : data1.features[index].properties['s2___moder'],
                // s3___margi : data1.features[index].properties['s3___margi'],

                // act_pla_la : data1.features[index].properties['act_pla_la'],
                // coordinate :coordinate
                //}


              }
            }
            // getAPReport(reportData);
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }
  if (circle_url) {
    $.ajax({
      // use to get popup info from the circle data layer on the map
      url: circle_url,
      type: "GET",
      success: function (circle_data, status, jqXHR) {
        if (circle_data.features.length == 1) {

          for (index = 0; index < circle_data.features.length; index++) {
            // console.log('s1', crop_data.features[index].properties['s1'],'s2', crop_data.features[index].properties['s2'],
            //'s3 :', crop_data.features[index].properties['s3'])
            for (var k in circle_data.features[index].properties) {
              if (circle_data.features[index].properties.hasOwnProperty(k)) {
                dist_name = circle_data.features[index].properties['dist_name'];
                circle_name = circle_data.features[index].properties['cir_name'];
              }
            }

            //getReportCropSuitability(reportData1);
          }
          $("#latlongs").append("<h6 style='font-size:13px'>" + "<strong style='padding-right: 21px;'>" + "Circle" + "</strong>" + " : " + circle_name + "</h6>");
          $("#latlongs").append("<h6 style='font-size:13px;padding-bottom: 10px;'>" + "<strong style = 'padding-right: 13px;'>" + "District" + "</strong>" + " : " + dist_name + "</h6>");
         
          $("#latlongs_mobile").append("<div class='abc' style='font-size:10px;'>" + "<strong>" + "Circle" + "</strong>" + " : " + circle_name + "</div><br>");
          $("#latlongs_mobile").append("<div class='abc1' style='font-size:10px;'>" + "<strong>" + "District" + "</strong>" + " : " + dist_name + "</div>");
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }

  if (grid_url) {
    $.ajax({
      url: grid_url,
      type: "GET",
      success: function (grid_data, status, jqXHR) {
        if (grid_data.features.length == 1) {

          for (index = 0; index < grid_data.features.length; index++) {
            // console.log('s1', crop_data.features[index].properties['s1'],'s2', crop_data.features[index].properties['s2'],
            //'s3 :', crop_data.features[index].properties['s3'])
            for (var k in grid_data.features[index].properties) {
              if (grid_data.features[index].properties.hasOwnProperty(k)) {
                grid_no = grid_data.features[index].properties['grid_no'];
              }
            }

            //getReportCropSuitability(reportData1);
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }

  if (watershed_url) {
    $.ajax({
      url: watershed_url,
      type: "GET",
      success: function (wshed_data, status, jqXHR) {
        if (wshed_data.features.length == 1) {

          for (index = 0; index < wshed_data.features.length; index++) {
            // console.log('s1', crop_data.features[index].properties['s1'],'s2', crop_data.features[index].properties['s2'],
            //'s3 :', crop_data.features[index].properties['s3'])
            for (var k in wshed_data.features[index].properties) {
              if (wshed_data.features[index].properties.hasOwnProperty(k)) {
                mini_wshed = wshed_data.features[index].properties['mini_whed'];
              }
            }

            //getReportCropSuitability(reportData1);
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }

  //});
  rightBarvalues();
}

// lat long and district and circle_name display
function rightBarvalues() {
  latlongdms = document.getElementById('mouse-position').innerHTML;

// Define a regular expression pattern to match numeric values
const pattern = /(\d+° \d+′ \d+″) (\w+) (\d+° \d+′ \d+″) (\w+)/;

// Extract latitude and longitude using the pattern
const [, latValue, latDirection, lonValue, lonDirection] = latlongdms.match(pattern);

// Displaying the results
console.log("Latitude:", latValue, latDirection);
console.log("Longitude:", lonValue, lonDirection);


  $("#latlongs").append("<h6 style='font-size:13px;;padding-top:10px'>" + "<strong>" + "Lat/Long" + "</strong>" + " : " +  latValue + latDirection + "</h6>");
  $("#latlongs").append("<h6 style='font-size:13px;padding-left:69px'>" + lonValue + lonDirection + "</h6>");  

  $("#latlongs_mobile").append("<div class='def' style='font-size:10px;'>" + "<strong>" + "Latitude" + "</strong>" + " : " +  latValue + latDirection + "</div><br>");
  $("#latlongs_mobile").append("<div class='def1' style='font-size:10px;'>" + "<strong>" + "Longitude" + "</strong>" + " : " +  lonValue + lonDirection + "</div>");
  // $("#latlongs_mobile").append("<div class='def'><h6 style='font-size:10px;padding:0px 0px 0px 56px'>" + lonValue + lonDirection + "</h6></div>");  
}





function getAPReport() {

  data = {
    soil_code: soil_code,
    soil_class: soil_class,
    soil_description: soil_description,
    s1: s1,
    s2: s2,
    s3: s3,
    action_pla: action_pla,
    //coordinate :coordinate,
    id: id,
    dist_name: dist_name,
    circle_name: circle_name,
    grid_no: grid_no,
    mini_wshed: mini_wshed,
  }
  postAPData("../tawang/twreport.php", data, "POST")
}

function postAPData(path, params, method = 'post') {
  // The rest of this code assumes you are not using a library.
  // It can be made less wordy if you use one.
  const form = document.createElement('form');
  form.method = method;
  form.action = path;
  form.target = "_blank";

  for (const key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];
      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}



// ---------------------------------------------------------------------------------------------------------------------


// $('#lulc').click(function () {
  function getLulc(){
  $("#sidebarcontent").empty();
  $("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var lulc_url = lulc.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (lulc_url) {
    $.ajax({
      url: lulc_url,
      type: "GET",
      success: function (lulc_data, status, jqXHR) {
        if (lulc_data.features.length == 1) {
          $("#sidebarcontent").append("<div>" + "<h6 style='paddding:0px;margin:0px'>Land Use Land Cover </h6>" + "</div><br>");
          //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          for (index = 0; index < lulc_data.features.length; index++) {

            for (var k in lulc_data.features[index].properties) {
              if (lulc_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(lulc_lables).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent").append("<div>" + "<strong>" + value + "</strong>" + " : "+ " <br>" + lulc_data.features[index].properties[k] + "</div>");
                    $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : "+ " <br>" + lulc_data.features[index].properties[k] + "</div>");
                  }

                });
              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }



// });
  }




    function getLulcMobile(){
      $("#sidebarcontent").empty();
      $("#sidebarcontent_mobile").empty();
      //do something
    
      // console.log("layer source att   ", layer_source);
      // var coordinate = evt.coordinate;
      var viewResolution = /** @type {number} */ (view.getResolution());
      var lulc_url = lulc.getGetFeatureInfoUrl(
        coordinate, viewResolution, 'EPSG:3857',
        { 'INFO_FORMAT': 'application/json' });
    
      if (lulc_url) {
        $.ajax({
          url: lulc_url,
          type: "GET",
          success: function (lulc_data, status, jqXHR) {
            if (lulc_data.features.length == 1) {
              $("#sidebarcontent").append("<div>" + "<h6 style='paddding:0px;margin:0px'>Land Use Land Cover </h6>" + "</div><br>");
              //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
              for (index = 0; index < lulc_data.features.length; index++) {
    
                for (var k in lulc_data.features[index].properties) {
                  if (lulc_data.features[index].properties.hasOwnProperty(k)) {
    
                    // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");
    
                    //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                    // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                    //console.log(k , geom_data.features[index].properties[k]);
    
                    //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));
    
                    Object.entries(lulc_lables).forEach(([key, value]) => {
                      if (key == k) {
                        $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : "+ " <br>" + lulc_data.features[index].properties[k] + "</div>");
                      }
    
                    });
                  }
                }
              }
            }
            else { }
          },
          error: function (jqXHR, status, err) {
            alert("Local error callback.");
          },
          complete: function (jqXHR, status) {
            //alert("Local completion callback.");
          }
        })
      }
    
      }


// $('#hgeom').click(function (evt) {
function getHgeom(){  
$("#sidebarcontent").empty();
  $("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var hgeom_url = hgeom.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (hgeom_url) {
    $.ajax({
      url: hgeom_url,
      type: "GET",
      success: function (geom_data, status, jqXHR) {
        if (geom_data.features.length == 1) {
          $("#sidebarcontent").append("<div>" + "<h6 style='paddding:0px;margin:0px'>Hydrogeomorphology </h6>" + "</div><br>");
          //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          for (index = 0; index < geom_data.features.length; index++) {

            for (var k in geom_data.features[index].properties) {
              if (geom_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(hgeom_lables).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + geom_data.features[index].properties[k] + "</div>");
                    $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + geom_data.features[index].properties[k] + "</div>");
                  }

                });
              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }



// });
}




function getSoil(){
  $("#sidebarcontent").empty();
  $("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var soil_url_pop = soil.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (soil_url_pop) {
    $.ajax({
      url: soil_url_pop,
      type: "GET",
      success: function (soil_pop_data, status, jqXHR) {
        if (soil_pop_data.features.length == 1) {
          $("#sidebarcontent").append("<div>" + "<h6 style='paddding:0px;margin:0px'>Soil Info </h6>" + "</div><br>");
          //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          for (index = 0; index < soil_pop_data.features.length; index++) {

            for (var k in soil_pop_data.features[index].properties) {
              if (soil_pop_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(soil_lables).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + soil_pop_data.features[index].properties[k] + "</div>");
                    $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + soil_pop_data.features[index].properties[k] + "</div>");
                  }

                });

              }
            }
          }
          // $("#sidebarcontent").append("<button id='apgetreport' type='button' class='btn btn-outline-primary' style='background-color:  #3C457C;color:white;position:fixed' onclick='getAPReport()'>Generate Report</button>") 
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }



// });
}

function getSlope(){
// $('#slope_id','#slope_id1_mobile').click(function (evt) {
  $("#sidebarcontent").empty();
  $("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var slope_url_pop = slope.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (slope_url_pop) {
    $.ajax({
      url: slope_url_pop,
      type: "GET",
      success: function (slope_pop_data, status, jqXHR) {
        if (slope_pop_data.features.length == 1) {
          $("#sidebarcontent").append("<div>" + "<h6 style='paddding:0px;margin:0px'>Slope Info </h6>" + "</div><br>");
          for (index = 0; index < slope_pop_data.features.length; index++) {

            for (var k in slope_pop_data.features[index].properties) {
              if (slope_pop_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(slope_lables).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + slope_pop_data.features[index].properties[k] + "</div>");
                    $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : " +" <br>" + slope_pop_data.features[index].properties[k] + "</div>");
                  }

                });
              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }



// });

}
// $('#ld').click(function () {
//   $("#sidebarcontent_derivative").empty();
//   //do something

//   // console.log("layer source att   ", layer_source);
//   // var coordinate = evt.coordinate;
//   var viewResolution = /** @type {number} */ (view.getResolution());
//   var ld_url = degradation.getGetFeatureInfoUrl(
//     coordinate, viewResolution, 'EPSG:3857',
//     { 'INFO_FORMAT': 'application/json' });

//   if (ld_url) {
//     $.ajax({
//       url: ld_url,
//       type: "GET",
//       success: function (ld_data, status, jqXHR) {
//         if (ld_data.features.length == 1) {
//           //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
//           for (index = 0; index < ld_data.features.length; index++) {

//             for (var k in ld_data.features[index].properties) {
//               if (ld_data.features[index].properties.hasOwnProperty(k)) {

//                 // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

//                 //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
//                 // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
//                 //console.log(k , geom_data.features[index].properties[k]);

//                 //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

//                 Object.entries(ld_labels).forEach(([key, value]) => {
//                   if (key == k) {

//                     $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + ld_data.features[index].properties[k] + "</div><br>");

//                   }

//                 });
//               }
//             }
//           }
//         }
//         else { }
//       },
//       error: function (jqXHR, status, err) {
//         alert("Local error callback.");
//       },
//       complete: function (jqXHR, status) {
//         //alert("Local completion callback.");
//       }
//     })
//   }
// });

// $('#lc').click(function () {
//   $("#sidebarcontent_derivative").empty();
//   //do something

//   // console.log("layer source att   ", layer_source);
//   // var coordinate = evt.coordinate;
//   var viewResolution = /** @type {number} */ (view.getResolution());
//   var lc_url = capability.getGetFeatureInfoUrl(
//     coordinate, viewResolution, 'EPSG:3857',
//     { 'INFO_FORMAT': 'application/json' });

//   if (lc_url) {
//     $.ajax({
//       url: lc_url,
//       type: "GET",
//       success: function (lc_data, status, jqXHR) {
//         if (lc_data.features.length == 1) {
//           //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
//           for (index = 0; index < lc_data.features.length; index++) {

//             for (var k in lc_data.features[index].properties) {
//               if (lc_data.features[index].properties.hasOwnProperty(k)) {

//                 // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

//                 //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
//                 // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
//                 //console.log(k , geom_data.features[index].properties[k]);

//                 //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

//                 Object.entries(lc_labels).forEach(([key, value]) => {
//                   if (key == k) {
//                     d3 = '(III) : These lands have severe limitations that restrict the choice of plants or that require special conservation practices or both';
//                     d2 = '(II) : These lands have moderate limitation that restrict the choice of plants or that require moderate conservation practices';
//                     d4 = '(IV) : These lands have very severe limitations that restirct the choice of plants or require very carefull management practices or both';
//                     d6 = '(VI) :These lands have severe limitations that make them generally unsuitable for cultivation and that restrict their use mainly to pasture, forestland or wildlife habitat';
//                     s= '(s) :Soil limitations'
//                     es = '(es) : Erosion & Soil limitations';
//                     ces = '(ces) : Climatic, erosion and Soil limitations';

//                     if (lc_data.features[index].properties[k] == 'IIIes'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d3+"<br>"+ es + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'IIes'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d2+"<br>"+ es + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'IIIsw'){
//                     $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d3+"<br>"+ sw + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'IVs'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d4 +"<br>"+ s + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'IVes'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d4 +"<br>"+ es + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'IVces'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d4 +"<br>"+ ces + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'VIs'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d6 +"<br>"+ s + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'Vis'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d6 +"<br>"+ s + "</div><br>");
//                     }
//                     else if (lc_data.features[index].properties[k] == 'VIes'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] +"<br>"+ d6 +"<br>"+ es + "</div><br>");
//                     }
//                     else {
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " +lc_data.features[index].properties[k] + "</div><br>");
//                     }
//                   }

//                 });
//               }
//             }
//           }
//         }
//         else { }
//       },
//       error: function (jqXHR, status, err) {
//         alert("Local error callback.");
//       },
//       complete: function (jqXHR, status) {
//         //alert("Local completion callback.");
//       }
//     })
//   }
// });


// $('#li').click(function () {
//   $("#sidebarcontent_derivative").empty();
//   //do something

//   // console.log("layer source att   ", layer_source);
//   // var coordinate = evt.coordinate;
//   var viewResolution = /** @type {number} */ (view.getResolution());
//   var li_url = irrigability.getGetFeatureInfoUrl(
//     coordinate, viewResolution, 'EPSG:3857',
//     { 'INFO_FORMAT': 'application/json' });

//   if (li_url) {
//     $.ajax({
//       url: li_url,
//       type: "GET",
//       success: function (li_data, status, jqXHR) {
//         if (li_data.features.length == 1) {
//           //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
//           for (index = 0; index < li_data.features.length; index++) {

//             for (var k in li_data.features[index].properties) {
//               if (li_data.features[index].properties.hasOwnProperty(k)) {

//                 // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

//                 //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
//                 // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
//                 //console.log(k , geom_data.features[index].properties[k]);

//                 //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

//                 Object.entries(li_labels).forEach(([key, value]) => {
//                   if (key == k) {
                    
//                     twodata = '(2) : These lands have moderate limitations for sustained use under irrigation';
//                     threedata ='(3) : These lands have severe limitations for sustained use under irrigation';
//                     fourdata = '(4) : These are the marginal lands for sustained use under irrigation because of very severe limitations';
//                     sixdata ='(6) : These lands are not suitable for sustained use under irrigation';
//                     sdata =	'(s) : Soil limitations';
//                     dsdata =	'(ds) : Drainage & Soils  limitations';
//                     tsdata =	'(ts) : Topography and Soil limitations';
                    
//                     if (li_data.features[index].properties[k] == '2s'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ twodata +"<br>"+ sdata + "</div><br>");
//                     }else if (li_data.features[index].properties[k] == '3ds'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ threedata +"<br>"+ dsdata + "</div><br>");
//                     }
//                     else if (li_data.features[index].properties[k] == '3ts'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ threedata +"<br>"+ tsdata + "</div><br>");
//                     }
//                     else if (li_data.features[index].properties[k] == '4ds'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ fourdata +"<br>"+ dsdata + "</div><br>");
//                     }
//                     else if (li_data.features[index].properties[k] == '4ts'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ fourdata +"<br>"+ tsdata + "</div><br>");
//                     }
//                     else if (li_data.features[index].properties[k] == '6s'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ sixdata +"<br>"+ sdata + "</div><br>");
//                     }
//                     else if (li_data.features[index].properties[k] == '6ts'){
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] +"<br>"+ sixdata +"<br>"+ tsdata + "</div><br>");
//                     }
//                     else{
//                       $("#sidebarcontent_derivative").append("<div>" + "<strong>" + value + "</strong>" + " : " + li_data.features[index].properties[k] + "</div><br>");
//                     }
//                   }

//                 });
//               }
//             }
//           }
//         }
//         else { }
//       },
//       error: function (jqXHR, status, err) {
//         alert("Local error callback.");
//       },
//       complete: function (jqXHR, status) {
//         //alert("Local completion callback.");
//       }
//     })
//   }
// });


// $('#cs').click(function () {
  function getCropSuitability(){
  $("#sidebarcontent_recommendation").empty();
  $("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var cropsuitability_url = cropsuitability.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (cropsuitability_url) {
    $.ajax({
      url: cropsuitability_url,
      type: "GET",
      success: function (cs_data, status, jqXHR) {
        if (cs_data.features.length == 1) {
          //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          for (index = 0; index < cs_data.features.length; index++) {

            for (var k in cs_data.features[index].properties) {
              if (cs_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(cs_labels).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent_recommendation").append("<div>" + "<strong>" + value + "</strong>" + " : "+" <br>" + cs_data.features[index].properties[k] + "</div>");
                    
                  }

                });
              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }
// });
  }

  function getCropSuitabilityMobile(){
    $("#sidebarcontent_recommendation").empty();
    $("#sidebarcontent_mobile").empty();
    //do something
  
    // console.log("layer source att   ", layer_source);
    // var coordinate = evt.coordinate;
    var viewResolution = /** @type {number} */ (view.getResolution());
    var cropsuitability_url = cropsuitability.getGetFeatureInfoUrl(
      coordinate, viewResolution, 'EPSG:3857',
      { 'INFO_FORMAT': 'application/json' });
  
    if (cropsuitability_url) {
      $.ajax({
        url: cropsuitability_url,
        type: "GET",
        success: function (cs_data, status, jqXHR) {
          if (cs_data.features.length == 1) {
            //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
            for (index = 0; index < cs_data.features.length; index++) {
  
              for (var k in cs_data.features[index].properties) {
                if (cs_data.features[index].properties.hasOwnProperty(k)) {
  
                  // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");
  
                  //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                  // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                  //console.log(k , geom_data.features[index].properties[k]);
  
                  //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));
  
                  Object.entries(cs_labels).forEach(([key, value]) => {
                    if (key == k) {
  
                     
                      $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : "+" <br>" + cs_data.features[index].properties[k] + "</div>");
                      
                    }
  
                  });
                }
              }
            }
          }
          else { }
        },
        error: function (jqXHR, status, err) {
          alert("Local error callback.");
        },
        complete: function (jqXHR, status) {
          //alert("Local completion callback.");
        }
      })
    }
  // });
    }

// $('#ap').click(function () {
function getActionPlan(){  
$("#sidebarcontent_recommendation").empty();
$("#sidebarcontent_mobile").empty();
  //do something

  // console.log("layer source att   ", layer_source);
  // var coordinate = evt.coordinate;
  var viewResolution = /** @type {number} */ (view.getResolution());
  var action_plan_url = action_plan.getGetFeatureInfoUrl(
    coordinate, viewResolution, 'EPSG:3857',
    { 'INFO_FORMAT': 'application/json' });

  if (action_plan_url) {
    $.ajax({
      url: action_plan_url,
      type: "GET",
      success: function (ap_data, status, jqXHR) {
        if (ap_data.features.length == 1) {
          //$("#popup-content").append("<div> <b> " + layer_title +" </b></div><br>");
          for (index = 0; index < ap_data.features.length; index++) {

            for (var k in ap_data.features[index].properties) {
              if (ap_data.features[index].properties.hasOwnProperty(k)) {

                // $("#sidebarcontent").append("<div>" + k + " : " + data1.features[index].properties[k] +"</div><br>");

                //$("#sidebarcontent").append("<tr><td>" + k + "</td><td>" + ':&nbsp;&nbsp;' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr>");
                // $("#sidebarcontent").append("<table class='table table-responsive-sm'><tr><td>" + k + "</td><td>" + ':' + "</td> <td>" + data1.features[index].properties[k] + "</td></tr></table>");
                //console.log(k , geom_data.features[index].properties[k]);

                //Object.keys(labels).forEach(e => console.log(`key=${e}  value=${labels[e]}`));

                Object.entries(ap_labels).forEach(([key, value]) => {
                  if (key == k) {

                    $("#sidebarcontent_recommendation").append("<div>" + "<strong>" + value + "</strong>" + " : "+" <br>" + ap_data.features[index].properties[k] + "</div>");
                    $("#sidebarcontent_mobile").append("<div>" + "<strong>" + value + "</strong>" + " : "+" <br>" + ap_data.features[index].properties[k] + "</div>");

                  }

                });
              }
            }
          }
        }
        else { }
      },
      error: function (jqXHR, status, err) {
        alert("Local error callback.");
      },
      complete: function (jqXHR, status) {
        //alert("Local completion callback.");
      }
    })
  }
// });
}


// need to verify ...
function scaleCombo(scale_to) {
  //console.log(sel.value);

  var units = map.getView().getProjection().getUnits();
  console.log(units);
  var dpi = 25.4 / 0.28;
  var mpu = ol.proj.Units.METERS_PER_UNIT[units];
  var scale = scale_to;
  var resolution = scale / mpu / 39.37 / dpi;

  console.log(resolution);
  view.setResolution(resolution);

}


//  scaleCombo(500);


//-----------------
function getZoomto(val) {



  //alert(val);
  var array = val.split(','), a = array[0], b = array[1], c = array[2];
  //alert(a);
  //alert(b);
  //alert(c);

  var lat = b.replace("BOX(", "");
  //alert(lat);
  var res = lat.split(" ");
  var a1 = parseFloat(res[0]);
  var a2 = parseFloat(res[1]);
  var lng = c.replace(")", "");
  var res1 = lng.split(" ");
  var a3 = parseFloat(res1[0]);
  var a4 = parseFloat(res1[1]);


  //console.log(a1,a2,a3,a4);

  map.getView().fit(ol.proj.transformExtent([a1, a2, a3, a4], 'EPSG:4326', map.getView().getProjection()));
}

function convertDMSToDecimcal() {
  userdms = document.getElementById("search").value
  var arraydms = userdms.split(' ');
  var lt111 = parseFloat(arraydms[0]);
  var ltn111 =parseFloat(arraydms[1]);
  if (arraydms.length==2){
    // Your point in WGS84 (EPSG:4326)
      console.log(typeof lt111)
      console.log(ltn111)
      map.getView().fit(ol.proj.transformExtent([ltn111, lt111, ltn111, lt111], 'EPSG:4326', map.getView().getProjection()));
      map.getView().setZoom(15);
      map.removeLayer(vectorLayer);

    iconFeature = new ol.Feature({
      geometry: new ol.geom.Point(ol.proj.fromLonLat([ltn111, lt111]))
    });

    iconFeature.setStyle(iconStyle);

    vectorSource = new ol.source.Vector({
      features: [iconFeature],
    });

    vectorLayer = new ol.layer.Vector({
      source: vectorSource,
      title: "marker_pin",
      name: 'marker_pin',
      baseLayer: false,
      displayInLayerSwitcher: false,
    });

    map.addLayer(vectorLayer);

      // Transform the point to the map's projection
      // var transformedPoint = ol.proj.transform(wgs84Point, 'EPSG:4326', map.getView().getProjection());

      // Set the center of the view to the transformed point
      // map.getView().setCenter(transformedPoint);
      // Optionally, you can set a zoom level
      // map.getView().setZoom(25); // Adjust the zoom level as needed
          // map.getView().fit(ol.proj.transformExtent([ltn, lt, ltn, lt], 'EPSG:4326', map.getView().getProjection()));
          // map.getView().setZoom(11.5);
  }
 else if (!userdms || arraydms.length !== 6) {
    map.getView().fit(ol.proj.transformExtent([91.85822687951485, 27.63533668107243, 91.85822687951485, 27.63533668107243], 'EPSG:4326', map.getView().getProjection()));
    map.getView().setZoom(11.5);
  }
  else {

    console.log(arraydms.length);
    var d1 = parseFloat(arraydms[0]) + '°';
    var d2 = parseFloat(arraydms[1]) + "'";
    var d3 = parseFloat(arraydms[2]) + '"';
    var d4 = parseFloat(arraydms[3]) + '°';
    var d5 = parseFloat(arraydms[4]) + "'";
    var d6 = parseFloat(arraydms[5]) + '"';
    var log1 = d1 + ' ' + d2 + ' ' + d3;
    var lat1 = d4 + ' ' + d5 + ' ' + d6;
    console.log(log1 + lat1);

    // var lon = "24° 43' 30.16\"";
    //    var lat = "58° 44' 43.97\"";

    // console.log(lon)
    // console.log(lat)
    //   var point = new GeoPoint(lon, lat);

    var point = new GeoPoint(log1, lat1);
    var logdec = point.getLonDec();
    var latdec = point.getLatDec();
    // console.log("fffffffffffffff"+logdec+latdec);

    console.log(point.getLonDec()); // 24.725044444444443
    console.log(point.getLatDec()); // 58.74554722222222

    map.getView().fit(ol.proj.transformExtent([latdec, logdec, latdec, logdec], 'EPSG:4326', map.getView().getProjection()));
    map.getView().setZoom(15);

    map.removeLayer(vectorLayer);

    iconFeature = new ol.Feature({
      geometry: new ol.geom.Point(ol.proj.fromLonLat([latdec, logdec]))
    });

    iconFeature.setStyle(iconStyle);

    vectorSource = new ol.source.Vector({
      features: [iconFeature],
    });

    vectorLayer = new ol.layer.Vector({
      source: vectorSource,
      title: "marker_pin",
      name: 'marker_pin',
      baseLayer: false,
      displayInLayerSwitcher: false,
    });

    map.addLayer(vectorLayer);
  }

}



// $('#searchright').click(function(){
// alert(document.getElementById("searchright").value);
// userdms = document.getElementById("searchright").value
// convertDMSToDecimcal(userdms);
// var res = lat.split(" ");
// var a1 =parseFloat(res[0]);
// var a2 =parseFloat(res[1]);



//console.log(a1,a2,a3,a4);

// map.getView().fit(ol.proj.transformExtent([a1,a2,a1,a2], 'EPSG:4326', map.getView().getProjection()));
// map.getView().setZoom(15);
// })



function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds) {
      break;
    }
  }
}
//-------------

function submitPoll() {
  document.getElementById("report_button").disabled = true;
  setTimeout(function () {
    document.getElementById("report_button").disabled = false;
  }, 500000);
}

// function openNav() {
// document.getElementById("mySidenav").style.width = "350px";
// var moreinfo = document.getElementById("moreinfo");
// }

// function closeNav() {
//   document.getElementById("mySidenav").style.width = "0";
// }

// right side bar
function openNav() {
  if(window.matchMedia("(max-height: 700px)")){
    document.getElementById("mySidebarRight").style.bottom = "5px";
    document.getElementById("mySidebarRight").style.width = "240px";
    document.getElementById("mySidebarRight").style.visibility = "visible";
  }
  document.getElementById("mySidebarRight").style.width = "240px";
  document.getElementById("mySidebarRight").style.visibility = "visible";
  // document.getElementById("mySidebarRight").style.height = "350px";
  // document.getElementById("main").style.marginRight = "270px";
}

function closeNav() {
  document.getElementById("mySidebarRight").style.width = "0px";
  document.getElementById("mySidebarRight").style.visibility = "hidden";
  // document.getElementById("sidebarcontent").style.width = "0px";
  // document.getElementById("main").style.marginRight= "0";
  document.getElementById("mySidebarRight").style.zIndex = "none"
}


//legend
function legend(tlayer) {

  $('#legend').empty();
  $('#legend1').empty();
  var no_layers = map.getLayers().get('length');
  //  console.log(no_layers[0].options.layers);
  //  console.log(map.getLayers().get('length'));


  // var head = document.createElement("h8");

  // var txt = document.createTextNode("Legend");

  // head.appendChild(txt);
  // var element = document.getElementById("legend");
  // element.appendChild(head);


  // map.getLayers().getArray().slice().forEach(layer => {

  //   console.log('layernames '+layer.get('name'));
  //   console.log('layernames '+layer.getSource().getparams('LAYERS'));

  //     // var head = document.createElement("p");

  //     // var txt = document.createTextNode(layer.get('title'));
  //     // alert(txt);
  //     // head.appendChild(txt);
  //     // var element = document.getElementById("legend");
  //     // element.appendChild(head);
  //     var img = new Image();
  //     img.src = "http://localhost:8085/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=" + layer.get('title');
  //     var src = document.getElementById("legend");
  //     src.appendChild(img);  src.appendChild(img);

  if (tlayer == 'tawang_10k_01022024') {
    const nolegend = 'no legend';
  }
  else if (tlayer == 'tawang_circle_boundary') {
    const nolegend = 'no legend';
  }
  else if (tlayer == 'Tawang_BaseLayer') {
    const nolegend = 'no legend';
  }
  else if (tlayer == 'locations') {
    const nolegend = 'no legend';
  }
  else {

    var img = document.createElement("img");
    var src = document.getElementById("legend");
    img.src = "https://solaris-ar.com:8085/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=" + tlayer;
    src.appendChild(img);


    var img1 = document.createElement("img");
    var src1 = document.getElementById("legend1");
    img1.src = "https://solaris-ar.com:8085/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=" + tlayer;
    src1.appendChild(img1);

    //  });
  }


}

// legend();

function getVisibleLayerslist() {

  all_layers = map.getLayers();
  const layerArray = []
  all_layers.forEach(layer => {

    var layervisability = layer.getVisible();

    if ((layervisability == true) && (layer.getProperties().name == 'tawang_lulc_01022024' ||
      layer.getProperties().name == 'tawang_slope' ||
      layer.getProperties().name == 'tawang_lineament' ||
      layer.getProperties().name == 'tawang_hgeom' ||
      layer.getProperties().name == 'tawang_soil_01022024' ||
      layer.getProperties().name == 'tawang_land_degradation_01022024' ||
      layer.getProperties().name == 'tawang_irrigability_01022024' ||
      layer.getProperties().name == 'tawang_capability_01022024' ||
      layer.getProperties().name == 'tawang_crop_suitability_01022024' ||
      layer.getProperties().name == 'tawang_actionplan_test')) {

      layerArray.push(layer.getProperties().name)

      console.log(layer.getVisible());
      // console.log("layer source  ",layer.getSource());
      console.log(layer.getProperties().name);
    }
  });
  console.log('list of layers', layerArray);
  console.log('length of layers', layerArray.length);
  let toplayer = layerArray[layerArray.length - 1];
  console.log(toplayer);
  legend(toplayer);

  if (toplayer == 'tawang_lulc_01022024') {
    $('#lulc').focus();
    document.getElementById("lulc").click();
  }
  else if (toplayer == 'tawang_hgeom') {
    $('#hgeom').focus();
    document.getElementById("hgeom").click();
  }
  else if (toplayer == 'tawang_slope') {
    $('#slope_id').focus();
    document.getElementById("slope_id").click();
  }
  else if (toplayer == 'tawang_soil_01022024') {
    $('#so').focus();
    document.getElementById("so").click();
  }
  else {
    $('#lulc').focus();
    document.getElementById("lulc").click();
  }
}

$( "#lulc" ).on( "click", function() {
  $('#cs').focus();
  document.getElementById("cs").click();
  // getCropSuitability();
  // $( "#cs" ).trigger( "click" );
} );


function show_hide_legend() {

  var x = window.matchMedia("(max-height: 1024px)")

  if (document.getElementById("legend").style.visibility == "hidden") {
    document.getElementById("legend_btn").innerHTML = "☰ LEGEND";
    document.getElementById('info_scroll').style.marginTop = '10';
    // document.getElementById("legend_btn").setAttribute("class", "btn btn-info btn-sm");
    document.getElementById("legend").style.visibility = "visible";
    document.getElementById("legend").style.width = "200px";
    // document.getElementById('legend').style.position = 'relative';
    document.getElementById('legend').style.height = '137px';

    document.getElementById('info_scroll').style.marginTop = '137px';



    //   if (x.matches) { // If media query matches
    //     document.getElementById("legend").style.left = "20%";
    //   } else {
    //     document.getElementById("legend").style.left = "0%";
    //   }


    // map.updateSize();

  } else {
    // document.getElementById("legend_btn").setAttribute("class", "btn btn-sm");
    document.getElementById("legend_btn").innerHTML = "☰ LEGEND";
    document.getElementById("legend_btn").style.marginLeft = '50px';
    document.getElementById("legend_btn").style.marginTop = '6px';
    document.getElementById("legend_btn").style.marginBottom = '5px';
    document.getElementById("legend_btn").style.fontSize = '12px';
    document.getElementById("legend").style.width = "0%";
    document.getElementById("legend").style.visibility = "hidden";
    document.getElementById('legend').style.height = '0%';
    document.getElementById('info_scroll').style.marginTop = '10px';

    // map.updateSize();
  }
};

// let tips = Array.from(document.getElementsByClassName('tip'))

// tips.forEach(function (mov) {
//   mov.addEventListener("click", handleClick);
// });

// function handleClick(event) {
//   tips.forEach(function (val) {
//     if (val == event.target) {
//       val.classList.add("active-tip");
//     } else {
//       val.classList.remove("active-tip");
//     }
//   });
// }


// start uploading kml file

const fileInput = document.getElementById('file-input');
fileInput.addEventListener('change', handleFile);

function handleFile(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const kmlData = e.target.result;
            displayKmlOnMap(kmlData);
        };

        reader.readAsText(file);
    }
      //  $('#exampleModal11').modal().hide();
      $("#exampleModal11 .btn-close").click()
}

function displayKmlOnMap(kmlData) {
  const vectorSource = new ol.source.Vector({
    format: new ol.format.KML(),
    url: 'data:text/xml;charset=utf-8,' + encodeURIComponent(kmlData),
});

const kmlLayer = new ol.layer.Vector({
    source: vectorSource,
    title: "kml",
    name: 'kml',
    baseLayer: false,
    displayInLayerSwitcher: false,
});

map.addLayer(kmlLayer);

// Wait for the vector layer to load before fitting the view
vectorSource.once('change', function () {
    if (vectorSource.getState() === 'ready') {
        map.getView().fit(vectorSource.getExtent(), map.getSize());
    }
});
}
// function mapload(){
// $('#maps').empty();  
// $('#maps').load('testing2.php #map');
// }

// document.addEventListener('contextmenu', event => event.preventDefault());

 function openMobileReport() {
 var x = document.getElementById("mobile_report_id");
    if (x.style.opacity === "0") {
        x.style.opacity = "1";
    } else {
        x.style.opacity = "1";
    }
    }

  function closeMobileReport(){
    var x = document.getElementById("mobile_report_id");
    if (x.style.opacity === "1") {
      x.style.opacity = "0";
  } 
  // else {
  //     x.style.opacity = "1";
  // }
  }

  
  // $('.ol-zoom.ol-unselectable.ol-control').click(function () {
  //   alert('asdfasf')
  // });


  const mobile_openclose_selection = document.createElement('div');
  mobile_openclose_selection.className = 'ol-control ol-unselectable mobile_openclose_selection';
  mobile_openclose_selection.innerHTML = '<button title="mobile selection me"><img src ="../img/layers_2050981_new.png" alt="My Happy mobile"/></button>';
  mobile_openclose_selection.addEventListener('click', function () {
    openMobileSidebar();
  });
  map.addControl(
    new ol.control.Control({
      element: mobile_openclose_selection,
    })
  );