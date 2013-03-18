<h1 id="title">Graphing</h1>
<meta charset="utf-8">
<style>

.income_graph {
  font: 10px sans-serif;
}

.arc path {
  stroke: #fff;
}

</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src='/njtransit/resources/js/d3.v3.min.js'></script>
<script>

//var url = 'http://api.census.gov/data/2010/'.$sources[0].

var vars = 'B19001_001E,B19001_002E,B19001_003E,B19001_004E,B19001_005E,B19001_006E,B19001_007E,B19001_008E,B19001_009E,B19001_010E,B19001_011E,B19001_012E,B19001_013E,B19001_014E,B19001_015E,B19001_016E,B19001_017E';
var source = 'acs5';
//var tracts = ["1400000US34021003705","1400000US34021003706","1400000US34021003704","1400000US34021003800","1400000US34021003904","1400000US34021003903","1400000US34021003703","1400000US34021003500","1400000US34021003602","1400000US34021003601","1400000US34021001300","1400000US34021001200","1400000US34021001102","1400000US34021001401","1400000US34021003400","1400000US34021001800","1400000US34021003100","1400000US34021003201","1400000US34021003302","1400000US34021003301","1400000US34021004204","1400000US34021004502","1400000US34021004000","1400000US34021004201","1400000US34023008601","1400000US34023008606","1400000US34023008602","1400000US34023008605","1400000US34023008604","1400000US34021004307","1400000US34021004301","1400000US34021003202","1400000US34021002903","1400000US34021002902","1400000US34021002100","1400000US34021002200","1400000US34021002800","1400000US34021001700","1400000US34021002000","1400000US34021001900","1400000US34021000900","1400000US34021001101","1400000US34021001500","1400000US34021001402","1400000US34021001600","1400000US34021001000","1400000US34021000800","1400000US34021000500","1400000US34021000700","1400000US34021000200","1400000US34021000100","1400000US34021002500","1400000US34021000300","1400000US34021000400","1400000US34021000600","1400000US34021002601","1400000US34021002602","1400000US34021003004","1400000US34021003003","1400000US34021003002","1400000US34021003009","1400000US34021003008","1400000US34021003006","1400000US34021003007","1400000US34021004310","1400000US34021003001","1400000US34021004309","1400000US34025811900","1400000US34025812502","1400000US34021002904","1400000US34021004306","1400000US34021002701","1400000US34021002702","1400000US34005701502","1400000US34005701700","1400000US34005704200","1400000US34005701401","1400000US34005701302","1400000US34005701301","1400000US34005701303","1400000US34025812000","1400000US34029717300","1400000US34005981802","1400000US34005701402","1400000US34005704302","1400000US34021004501"];



function get_data(state,county,tract,vars,source)
{
var key = '?key=564db01afc848ec153fa77408ed72cad68191211'
var base = 'http://api.census.gov/data/2010/'+source
var query = '&get='+vars+'&for=tract:'+tract+'&in=county:'+county+'+state:'+state;
var url = base+key+query;


var jqxhr = $.ajax(url)
    .done(function(data) { process_data(data)  })
    .fail(function() { console.log("error") })
    .always(function() { console.log("complete") });

}

function process_data(input)
{
	var output = [];
	for(i = 1; i<17; i++)
	{
		output.push({income: input[0][i], count: input[1][i]});
	}
    draw_donut(output);
}



</script>
<h2>Income Distrobution</h2>
<div class="income_graph"></div>
<h2>Transportation to Work</h2>
<div class="transport_graph"></div>