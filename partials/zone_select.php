<script>

$('.zone_top').on('click',function(){
  if(!$(this).hasClass('selected_zone')){
    $('.selected_zone .zone_nav').html('');
    $('.selected_zone .zone_content').html('');
    $('.selected_zone')
          .css('border','0px')
          .removeClass('selected_zone');
      $(this)
          .css('border','2px solid '+$(this).data('color'))
          .addClass('selected_zone');
      setSelector($(this).data('color'),$(this).data('id'));
      loadZone($(this).data('id'));
  }
});

function loadZone(zone){

  var fts = map.getLayersByName(zone)[0].selectedFeatures;
  var bounds = fts[0].geometry.getBounds().clone();
  for(var i=1;i<fts.length;i++){
    bounds.extend(fts[i].geometry.getBounds());
  }
  map.zoomToExtent(bounds,false);

  //load zone info and navigation
  $('#zone'+zone+' .zone_nav').append('<div id="demo_nav_'+zone+'" data-zone="'+zone+'" class="nav_button selected">Census Tracts</div>');
  $('#zone'+zone+' .zone_nav').append('<div id="gtfs_nav_'+zone+'" data-zone="'+zone+'" class="nav_button">GTFS</div><br><br>');
  $('#zone'+zone+' .zone_content').html(zoneInfoPane(fts));

  $('#gtfs_nav_'+zone).on('click',function(zone){
    if(!$(this).hasClass('selected')){
        //console.log('#zone'+$(this).data('zone')+' .zone_content');
        $('#demo_nav_'+$(this).data('zone')).removeClass('selected');
        $(this).addClass('selected');
       // $('#zone'+$(this).data('zone')+' .zone_content').html("GTFS INFO")
       $('#zone'+$(this).data('zone')+' .zone_content').html('<center><img src=resources/images/loading.gif><center>');
       loadGTFS($(this).data('zone'),$(this).attr('id'))
    }
  });

  $('#demo_nav_'+zone).on('click',function(){
    if(!$(this).hasClass('selected')){
        $('#gtfs_nav_'+$(this).data('zone')).removeClass('selected');
        $(this).addClass('selected');
        $('#zone'+$(this).data('zone')+' .zone_content').html(zoneInfoPane(map.getLayersByName($(this).data('zone'))[0].selectedFeatures))
    }
  });


}

function zoneInfoPane(fts)
{
  var output = '';
  var total_population = 0;
  var total_area = 0;
  for(var i=1;i<fts.length;i++){
    total_population += fts[i].data.P0010001*1;
    total_area += fts[i].data.CENSUSAREA*1.0;
  }
  output+="Census Tracks Selected: "+i+"</br>";
  output+="Total Population of Area: "+addCommas(total_population)+"</br>"
  output+="Total Area: "+addCommas(total_area.toFixed(2))+" mi<sup>2</sup></br>"
  return output;
}

function loadGTFS(id,zone)
{
  console.log('load gtfs'+id+' '+zone)
  
    if(typeof gtfs != 'undefined'){
      map.removeLayer(gtfs.destroy());
   }

    urls = ["data/gtfs/newark_route.json","data/gtfs/patterson_route.json","data/gtfs/atlantic_city.json","data/gtfs/philly_route.json"];
    url = urls[id];

    gtfs = new OpenLayers.Layer.Vector('GTFS', { 
        eventListeners:{
        'featureselected':function(evt){
            var feature = evt.feature;
            //console.log(feature.attributes.id+" "+feature.attributes.route+" "+feature.attributes.num_trips )
            //document.getElementById("data").innerHTML = "<div >Tract:" + feature.attributes.NAME+" "+feature.attributes.LSAD +" <br>Geo ID: " + feature.attributes.GEO_ID+" <br>Pop: " + addCommas(feature.attributes.P0010001)+"</div>";
        },
        'featureunselected':function(evt){
            var feature = evt.feature; 
         }   
        },
    strategies: [new OpenLayers.Strategy.Fixed()],                
    protocol: new OpenLayers.Protocol.HTTP({
    url: url,
    format: new OpenLayers.Format.GeoJSON(),
    renderers: ["Canvas", "SVG", "VML"]
    })
    });
    map.addLayer(gtfs);
    gtfs.events.register("loadend", gtfs, function (e) {
          quant = getLayerAttribute(gtfs,'num_trips');
          gtfs.styleMap =  getBusRouteStyle("route",quant);
          map.raiseLayer(gtfs,map.layers.length)
          gtfs.redraw();
          //map.zoomToExtent(gtfs.getDataExtent());
          
          $.ajax({
          type: "POST",
          url: "data/get/getZone.php",
          async: false,
          data: {  geo_type: 'routes', current_zone:currentZone }
          })
          .done(function( msg ) {
            data= JSON.parse(msg);
          
            for(i=0;i<gtfs.features.length;i++){
              if($.inArray(gtfs.features[i].attributes.route,data) > 0){
                  gtfs.features[i].attributes.include = 1;
                  
                }
            }
            listRoutes(id);
            gtfs.redraw();
        });
        for(i=0;i<data.length;i++)
        {
          console.log(data[i]);
        }  

    });
    gtfs_select = new OpenLayers.Control.SelectFeature([gtfs], {
                          selectStyle: OpenLayers.Util.extend({fill: true, stroke: true},
                          OpenLayers.Feature.Vector.style["select"]),
                          clickout: false, toggle: false,
                          multiple: false, hover: true
              });

    map.addControl(gtfs_select);
    gtfs_select.onBeforeSelect = function(feature) {
        this.selectStyle.strokeColor ="#0f0";
        this.selectStyle.strokeWidth = 8;
    };
    gtfs_select.activate();
  
}


function ZoomToFullState(){
  $('.selected_zone .zone_nav').html('');
  $('.selected_zone .zone_content').html('');
  $('.selected_zone')
        .css('border','0px')
        .removeClass('selected_zone');
  var bbox = new OpenLayers.Bounds(-8411257.7538454, 4711437.6979671, -8225840.1138238,5065205.2814741);
  map.zoomToExtent(bbox);
}  

function setSelector(color,id)
{
  console.log(map.controls);
  currentlayer = map.getLayersByName(id)[0];
  currentlayer.styleMap = getMultiStyle(color)
  selector = new OpenLayers.Control.SelectFeature([currentlayer],{
              clickout: false, toggle: false,
              multiple: true, hover:false,
              toggleKey: "ctrlKey", // ctrl key removes from selection
              multipleKey: "shiftKey" // shift key adds to selection
  });
  map.addControl(selector);
  selector.activate();
  activelayer=currentlayer;
  currentZone = id;
}
</script>

<style>
.zone{
  overflow: auto; 
}
.zone_top:hover{
    background-color: #efefef;
}

.route_listing{
  /*float:left;
  padding:7px;*/
  border:1px solid;
}

.color_select{
  float:left;
  padding:7px;
  border:1px solid;
  margin-right: 3px
}
</style>

<h1 id="title">Zone Select</h1>

<button id="uplevel" onclick='ZoomToFullState()' class='x-btn'>Zoom To Full State</button>

<div id="zone0" class="zone_top" data-id='0' data-color='#00f' style="padding:15px;">
    <h3 id="title"><div class='color_select' style="background-color:#00f"></div>
    Large Urban Area - Newark
    </h3>
    <div class = 'zone_nav'></div>
    <div class = 'zone_content'></div> 
</div>
<div id="zone1" class="zone_top" data-id='1' data-color='#0f0' style="padding:15px;">
    <h3 id="title"> 
      <div class='color_select' style="background-color:#0f0"></div>
      Small Urban Area – Paterson
    </h3> 
    <div class = 'zone_nav'></div>
    <div class = 'zone_content'></div>    
</div>
<div id="zone2" class="zone_top" data-id='2' data-color='#f00'style="padding:15px;">

    <h3 id="title">
      <div class='color_select' style="background-color:#f00"></div>
      South Jersey Urban Center – Atlantic City
    </h3>
    <div class = 'zone_nav'></div>
    <div class = 'zone_content'></div>  
</div>
<div id="zone3" class="zone_top" data-id='3' data-color='#f0f' style="padding:15px;"s>
    <h3 id="title"> 
      <div class='color_select' style="background-color:#f0f"></div>
      Intercity NJ Market – Philadelphia
    </h3>
    <div class = 'zone_nav'></div>
    <div class = 'zone_content'></div>     
</div>



