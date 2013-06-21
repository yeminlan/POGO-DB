var plot;

$(window).resize(function() {
    plot.replot( { resetAxes: true } );
});

$(document).ready(function(){

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
    }

    dataTable = $('#data').dataTable(settings);
    
    // Hide our id, and files, add fixed columns
    dataTable.fnSetColumnVis(2, false);
    dataTable.fnSetColumnVis(3, false);
    dataTable.fnSetColumnVis(4, false);
    dataTable.fnSetColumnVis(dataTable.fnGetData(0).length - 1, false);
    
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
    yselect.selectedIndex = 1;

    // draw graph
    updateGraph();
});

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
      if(data[i][vselement] === 'ava')
        xy_arr_ava.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val])]);
      if(data[i][vselement] === 'avb')
        xy_arr_avb.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val])]);
      if(data[i][vselement] === 'bvb')
        xy_arr_bvb.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val])]);
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
    sizeAdjust: 7.5
    },
    cursor: {
      show: false
    }
  }
  );
}

