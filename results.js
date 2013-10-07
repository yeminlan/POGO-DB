var plot;
var Ids = [];
var dataTable;

$(window).resize(function() {
    plot.replot( { resetAxes: true } );
});


$('input[type=checkbox]').live('change', function () {

    if($.inArray(this.id, Ids) == -1) {
      Ids.push(this.id); 
    }
    else {
      var idx = Ids.indexOf(this.id);
      Ids.splice(idx,1);
    }                           

});

$(document).ready(function(){

    // create our columns array
    cols = [];
    for(var i = 1; i < dataColumns.length; i++){
    cols.push(i);
    }

    settings = {
    "aaData": data,
    "sScrollX": "100%",
    "sScrollY": "100%", 
    "bSort": true,
    "bAutoWidth": false,
    "bScrollCollapse": true,
    "sDom": 'T<"clear">lfrtip',
    "sPaginationType": "full_numbers",
    "oTableTools": {
      "sSwfPath": "media/swf/copy_cvs_xls.swf",
      "aButtons": [
        {
          "sExtends": "copy",
          "sButtonText": "Copy to Clipboard",
          "mColumns": cols
        },
        {
          "sExtends": "csv",
          "sButtonText": "Download CSV",
          "mColumns": cols}]
      },
    "aoColumnDefs": [ 
    {
      "fnRender": function ( oObj ) {
        return '<input type=\"checkbox\" id="'+ oObj.aData[0] +'" name="sel"> ';
      },
      "sWidth": "10px", 
      "bSortable" : false,
      "aTargets": [ 0 ]
    }],
    "fnDrawCallback": function( oSettings) {
      apply_comparison_class(); }
      
    }

    dataTable = $('#data').dataTable(settings);

    marker_break: if(marker_gene) {
      var table = document.getElementById("avg_table");
      avg = calculate_averages();

      if(avg[2] == 1)  {
        table.parentNode.removeChild(table);
        var genediv = document.getElementById("avggenetext");
        genediv.appendChild(document.createTextNode("Sorry Average ranking data is not available because all genome pairs queried are missing some marker genes."));
        break  marker_break;
      }

      var head = table.createTHead();
      var headrow = head.appendChild(document.createElement('tr'));
      for(col in avg[1]){
        var el = headrow.appendChild(document.createElement('th'));
        el.appendChild(document.createTextNode(avg[1][col]));
      }

      marker_table = $('#avg_table').dataTable(
        {
        "bPaginate": false,
        "bFilter": false,
        "aaData": avg[0],
        "bSort": true,
        "bInfo": false,
        "bDeferRender": true,
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
          "sSwfPath": "media/swf/copy_cvs_xls.swf",
          "aButtons": [ "copy", "csv" ]
          }
       }
      );
    }

    // new FixedColumns( dataTable, {"iLeftColumns": 3, });
    yselect = document.getElementById("y");
    xselect = document.getElementById("x");
    
    // populate our dropdown box
    
    for(var i = 3; i < dataColumns.length - 1; i++){
        var option = document.createElement("option");
        if(dataColumns[i] === "Average AAI" || 
           dataColumns[i] === "Orthologs (Criterion 1)" ||
           dataColumns[i] === "Orthologs (Criterion 2)" ||
           dataColumns[i] === "Genomic Fluidity")
        {
          option.text = dataColumns[i];
        }
        else {  
          option.text = dataColumns[i] + " Identity";
        }

        option.value = i;
        xselect.add(option, null);
        yselect.add(option.cloneNode(true), null);
    }
    
    // have the x and y be different indexes by default
    xselect.selectedIndex = 1;

    // draw graph
    updateGraph();
    
});

function apply_comparison_class() {
  rows = $("#data").dataTable().fnGetNodes();
  for(var i = 0; i < rows.length; i++) {
    var col = rows[i].childNodes[rows[0].childNodes.length - 1];
    $(col.parentNode).addClass("row_" + col.innerHTML);
  }
}

function submitIds() {
  var i = 0;
  
  if(Ids.length != 0) {
    form = document.getElementById("submitform");
    form.setAttribute("method", "post");
    form.setAttribute("action", "download.php");

    var id_string = Ids[0];
    for(i = 1; i < Ids.length; i++) {
      id_string += "," + Ids[i];
    }
    input = document.createElement("input");
    input.value = id_string;
    input.name="ids";
    input.type = 'hidden';

    form.appendChild(input);
    form.submit();
  }
  else {
    alert("Please select one or more comparions to download");
    return false;
  }
}

function selectCB(val) {
  checkboxes = $('input', dataTable.fnGetNodes());

  for(var i = 0; i < checkboxes.length; i++) { 
    if(checkboxes[i].checked != val) {
      if($.inArray(checkboxes[i].id, Ids) == -1) {
        Ids.push(checkboxes[i].id); 
      }
      else {
        var idx = Ids.indexOf(checkboxes[i].id);
        Ids.splice(idx,1);
      }                           
    }
  }

  $('input', dataTable.fnGetNodes()).attr('checked',val);
}


avg_data = [];
function calculate_averages() {
  var ranking = [];
  var comparison = [];
  var i = 0;
  var j = 0;


  // create our average data array
  for(i = 0; i < data.length; i++) {
    avg_data[i] = [];
    avg_data[i].push(data[i][4]);
    for(j = 8; j < data[0].length; j++) {
      avg_data[i].push(data[i][j]);
    }
  }

  no_comparisons = avg_data[0].length;

  //check for nulls and remove them
  null_arr = [];

  for(j = 0; j < avg_data.length; j++) {
    for(i = 0; i < no_comparisons; i++) {
      if(avg_data[j][i] === null) {
        null_arr.push(j);
        break;
      } 
    }
  }

  for(i = (null_arr.length - 1); i > -1; i--) {
    avg_data.splice(null_arr[i], 1);
  }

  // if we only have one row (which would be our marker gene list, then exit with a failure)
  if(avg_data.length == 0) {
    return [null, null, 1];
  }

  //for each array turn it into a ranking
  for(j = 0; j < avg_data.length; j++) {
      comparison.push(avg_data[j].slice(-1)[0]);
      var sorted = avg_data[j].slice(0, avg_data[j].length - 1).sort(function(a,b){return b-a})
      var ranks = avg_data[j].slice(0, avg_data[j].length - 1).map(function(v){ return sorted.indexOf(v)+1 });
      ranking.push(ranks);
  }

  // average our three different 
  var ava_arr = [];
  var avb_arr = [];
  var bvb_arr = [];
  var all_arr = [];
  
  // populate our arrays with different comparisons
  for(j = 0; j < ranking.length; j++) {

    if(comparison[j] === "ava") {
      ava_arr.push(ranking[j]);  
    }
    else if(comparison[j] === "avb") {
      avb_arr.push(ranking[j]);  
    }
    else if(comparison[j] === "bvb") {
      bvb_arr.push(ranking[j]);  
    }
  }
  
  // an array of our average arrays
  var avgs_arr = [];
  // our columns
  var columns_arr = [];

  columns_arr.push("Marker Gene");

  // average and return our average from our differnt comparison arrays
  if(ava_arr.length > 0) {
    avgs_arr.push(averageRankings(ava_arr));
    columns_arr.push("A vs. A (" + ava_arr.length + " Genome Pairs)");
  }

  if(avb_arr.length > 0) {
    avgs_arr.push(averageRankings(avb_arr));
    columns_arr.push("A vs. B (" + avb_arr.length + " Genome Pairs)");
  }

  if(bvb_arr.length > 0) {
    avgs_arr.push(averageRankings(bvb_arr));
    columns_arr.push("B vs. B (" + bvb_arr.length + " Genome Pairs)");
  }
   
  // average all
  if(avgs_arr.length > 1) {
    avgs_arr.push(averageRankings(ranking));
    columns_arr.push("All (" + ranking.length + " Genome Pairs)");
  }

  // Create our output array, it's a bit like a transpose
  var ret = [];
  for(i = 0; i < avg_data[0].length - 1; i++) {
    var temp = [];
    temp.push(marker_cols[i]);
    for(j = 0; j < avgs_arr.length; j++) {
      temp.push(avgs_arr[j][i]); 
    }
    ret.push(temp);
  }

  return [ret, columns_arr, 0]
}


function averageRankings(array) {
  var i = 0;
  var j = 0;
  array_avg = [];

  for(j = 0; j < array[0].length; j++) {
    var total = 0;
    for(i = 0; i < array.length; i++)
      total = total + array[i][j];

  array_avg.push((total / array.length).toFixed(2));
  }
  return array_avg;
}
  
    
function updateGraph() {

  x = document.getElementById("x");
  y = document.getElementById("y");

  var x_val = x.options[x.selectedIndex].value;
  var y_val = y.options[y.selectedIndex].value;

  var xy_arr_avb = [];
  var xy_arr_ava = [];
  var xy_arr_bvb = [];

  vselement = data[0].length - 1;
  for(i in data) { 
    if(data[i][x_val] !== null && data[i][y_val] !== null) {
      if(data[i][vselement] === 'ava') { 
        xy_arr_ava.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val]), data[i][1] + "<br>" + data[i][2] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
      if(data[i][vselement] === 'avb') { 
        xy_arr_avb.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val]), data[i][1] + "<br>" + data[i][2] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
      if(data[i][vselement] === 'bvb') { 
        xy_arr_bvb.push([parseFloat(data[i][x_val]),
                         parseFloat(data[i][y_val]), 
                         data[i][1] + "<br>" + data[i][2] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
    }  
  }

  // Populate our legend lables and array of arrays

  label_arr = []; 
  array_of_arrays = [];
  label_show = true;
  color_arr= [];

  if(xy_arr_ava.length > 0) {
    label_arr.push("A vs. A");
    array_of_arrays.push(xy_arr_ava);
    color_arr.push("#A60400");
  }

  if(xy_arr_avb.length > 0)  {
    label_arr.push("A vs. B");
    array_of_arrays.push(xy_arr_avb);
    color_arr.push("#99F");
  }

  if(xy_arr_bvb.length > 0)  {
    label_arr.push("B vs. B");
    array_of_arrays.push(xy_arr_bvb);
    color_arr.push("#000");
  }

  $('#chart').empty();
  plot = $.jqplot('chart', array_of_arrays, 
  { 
    seriesColors: color_arr, 
    title: x.options[x.selectedIndex].text + " vs. " + y.options[y.selectedIndex].text,
    legend: {
      show:label_show,
      labels: label_arr
    },
    series:[
    {
      showLine:false,
      markerOptions: { size: 5 } 
      },

      {
      showLine:false,
      markerOptions: { size: 5 } 
      },
      { 
      showLine:false,
      markerOptions: { size: 5 }
      }

    ],
    axes: {
      xaxis: {
        label: x.options[x.selectedIndex].text,
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        },
      yaxis: {
        label: y.options[y.selectedIndex].text, 
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
        }
    },
    highlighter: {
    show: true,
    sizeAdjust: 7.5,
    tooltipContentEditor : function(str, seriesIndex, pointIndex, jqplot) { return plot.series[seriesIndex]._plotData[pointIndex][2]; }
    },
    cursor: {
      show: true,
      zoom: true
    }
  }
  );
}

function zoomOut() { 
  plot.resetZoom();
}

function toImage() { 
  var image = $("#chart").jqplotToImageStr({});

  window.open(image, '_blank');
}
