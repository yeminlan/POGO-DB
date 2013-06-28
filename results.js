var plot;

$(window).resize(function() {
    plot.replot( { resetAxes: true } );
});

$(document).ready(function(){
    
    cols = [];
    for(var i = 5; i < dataColumns.length; i++){
    cols.push(i);
    }

    settings = {
    "bPaginate":true,
    "aaData": data,
    "bFilter":false,
    "bSort": true,
    "bAutoWidth": false,
    "sScrollX": "100%",
    "sScrollY": "100%", 
    "bScrollCollapse": true,
    "sDom": 'T<"clear">lfrtip',
    "oTableTools": {
      "sSwfPath": "media/swf/copy_cvs_xls.swf",
      "aButtons": [
        {
          "sExtends": "copy",
          "mColumns": cols
        },
        {
          "sExtends": "csv",
          "mColumns": cols}]
      }
    }

    dataTable = $('#data').dataTable(settings);

    marker_break: if(marker_gene) {
      var table = document.getElementById("avg_table");
      avg = calculate_averages();

      if(avg[2] == 1)  {
        table.parentNode.removeChild(table);
        var genediv = document.getElementById("avggenetext");
        genediv.appendChild(document.createTextNode("Sorry, all of your marker gene's were null!"));
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
        "sDom": 'T<"clear">lfrtip',
        "oTableTools": {
          "sSwfPath": "media/swf/copy_cvs_xls.swf",
          "aButtons": [ "copy", "csv" ]
          }
       }
      );
    }

    // Hide our id, and files, add fixed columns
    dataTable.fnSetColumnVis(2, false);
    dataTable.fnSetColumnVis(3, false);
    dataTable.fnSetColumnVis(4, false);
    
    new FixedColumns( dataTable, {"iLeftColumns": 2} );

    yselect = document.getElementById("y");
    xselect = document.getElementById("x");
    
    // populate our dropdown box
    for(var i = 5; i < dataColumns.length - 1; i++){
        var o1 = document.createElement("option");
        var o2 = document.createElement("option");
        o1.text = dataColumns[i];
        o2.text = dataColumns[i];
        o1.value = i;
        o2.value = i;
        xselect.add(o1, null);
        yselect.add(o2, null);
    }
    
    // have the x and y be different indexes by default
    xselect.selectedIndex = 1;

    // draw graph
    updateGraph();
    // var a = $('#chart').jqplotToImageStr();
    // console.log(a);
});

function calculate_averages() {
  var ranking = [];
  var comparison = [];
  var i = 0;
  var j = 0;

  no_comparisons = avg_data[0].length;
  null_arr = [];

  //check for nulls
  for(j = 0; j < avg_data.length; j++) {
    for(i = 0; i < no_comparisons; i++) {
      if(avg_data[j][i] === null) {
        null_arr.push(j);
        break;
      } 
    }
  }

  for(i = (null_arr.length - 1) ; i > -1; i--) {
    avg_data.splice(null_arr[i], 1);
  }

  if(avg_data.length == 1) {
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
  
  for(j = 0; j < ranking.length; j++) {
    if(comparison[j] === "ava") {
      ava_arr.push(ranking[j]);  
      continue;
    }
    if(comparison[j] === "avb") {
      avb_arr.push(ranking[j]);  
      continue;
    }
    if(comparison[j] === "bvb") {
      bvb_arr.push(ranking[j]);  
    }
  }
  
  var ava_avg = [];
  var avb_avg = [];
  var bvb_avg = [];
  var totals_arr = [];
  var columns_arr = [];
  var avgs_arr = [];

  columns_arr.push("Marker Gene");

  if(ava_arr.length > 0) {
    
    for(j = 0; j <ava_arr[0].length; j++) {
      var total = 0;
      for(i = 0; i < ava_arr.length; i++)
        total = total + ava_arr[i][j];
        
      totals_arr[j] = total;
      ava_avg.push((total / ava_arr.length).toFixed(2));
    }
    avgs_arr.push(ava_avg);
    columns_arr.push("A vs. A (" + ava_arr.length + ")");
  }

  if(avb_arr.length > 0) {
    // each marker gene
    for(j = 0; j <avb_arr[0].length; j++) {
      var total = 0;
      // each genome pair
      for(i = 0; i < avb_arr.length; i++)
        total = total + avb_arr[i][j];
      
      avb_avg.push((total / avb_arr.length).toFixed(2));
    }
    avgs_arr.push(avb_avg);
    columns_arr.push("A vs. B (" + avb_arr.length + ")");
  }

  if(bvb_arr.length > 0) {
    for(j = 0; j <bvb_arr[0].length; j++) {
      var total = 0;
      for(i = 0; i < bvb_arr.length; i++)
        total = total + bvb_arr[i][j];
      
      bvb_avg.push((total / bvb_arr.length).toFixed(2));
    }
    avgs_arr.push(bvb_avg);
    columns_arr.push("B vs. B (" + bvb_arr.length + ")");
  }
   

  var ret = [];

  for(i = 0; i < avg_data[0].length - 1; i++) {
    var temp = [];
    temp.push(marker_cols[i]);
    for(j = 0; j < avgs_arr.length; j++) {
      temp.push(avgs_arr[j][i]); 
    }
    ret.push(temp);
  }

  return [ret, columns_arr, 0];
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
        xy_arr_ava.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val]), data[i][0] + "<br>" + data[i][1] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
      if(data[i][vselement] === 'avb') { 
        xy_arr_avb.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val]), data[i][0] + "<br>" + data[i][1] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
      if(data[i][vselement] === 'bvb') { 
        xy_arr_bvb.push([parseFloat(data[i][x_val]),
                         parseFloat(data[i][y_val]), 
                         data[i][0] + "<br>" + data[i][1] + "<br>(" + data[i][x_val] + ", " + data[i][y_val] + ")"]);
      }
    }  
  }

  // Populate our legend lables and array of arrays

  label_arr = []; 
  array_of_arrays = [];
  label_show = true;

  if(xy_arr_ava.length > 0) {
    label_arr.push("A vs. A");
    array_of_arrays.push(xy_arr_ava);
  }

  if(xy_arr_avb.length > 0)  {
    label_arr.push("A vs. B");
    array_of_arrays.push(xy_arr_avb);
  }

  if(xy_arr_bvb.length > 0)  {
    label_arr.push("B vs. B");
    array_of_arrays.push(xy_arr_bvb);
  }

  $('#chart').empty();
  plot = $.jqplot('chart', array_of_arrays, 
  { 
    seriesColors: ["#A60400", "9999FF", "#000"],
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
    tooltipContentEditor : function(str, seriesIndex, pointIndex, jqplot) { console.log(seriesIndex + " " + pointIndex); return plot.series[seriesIndex]._plotData[pointIndex][2]; }
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
  plot.jqplotSaveImage();
}
