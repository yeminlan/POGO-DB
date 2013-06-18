
$(document).ready(function(){

    settings = {
    "bPaginate":true,
    "aaData": data,
    "bFilter":false,
    "bSort": true,
    "bAutoWidth": false,
    "sScrollX": "100%",
    "sScrollY": "100%", 
    "bScrollCollapse": true
    }

    dataTable = $('#data').dataTable(settings);
    
    // Hide our id, and files, add fixed columns
    dataTable.fnSetColumnVis(2, false);
    dataTable.fnSetColumnVis(3, false);
    dataTable.fnSetColumnVis(4, false);
    
    new FixedColumns( dataTable, {"iLeftColumns": 2} );

    yselect = document.getElementById("y");
    xselect = document.getElementById("x");
    
    // populate our dropdown box
    for(var i = 5; i < dataColumns.length; i++){
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

  if(x.selectedIndex == -1) 
    return;
  if(y.selectedIndex == -1) 
    return;
    
  var x_val = x.options[x.selectedIndex].value;
  var y_val = y.options[y.selectedIndex].value;
  var arr = [];
  for(i in data) { 
    if(data[i][x_val] !== null && data[i][y_val] !== null) {
      arr.push([parseFloat(data[i][x_val]), parseFloat(data[i][y_val])]);
      console.log(i + " " + data[i][x_val] + " " + parseFloat(data[i][y_val]));
    }  
  }
  $('#chart').empty();
  plot = $.jqplot('chart', [arr], 
  { 
    title: x.options[x.selectedIndex].text + " vs. " + y.options[y.selectedIndex].text,
    series:[{
      showLine:false,
      markerOptions: { size: 5, style:"circle"} 
    }],
    axes: {
      xaxis: {
        label: x.options[x.selectedIndex].text
        },
      yaxis: {
        label: y.options[y.selectedIndex].text 
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

