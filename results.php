<?php
include 'login.php';
include 'functions.php';
include 'time.php';

ini_set('display_errors', 'On');
ini_set('memory_limit', '512M');
error_reporting(E_ALL);

$i = 0;
$data=array();
$data_columns = array();
?>
<!DOCTYPE html>
<div id="load">
<?php
// if A and B aren't set, go back to our homepage, someone didn't query us correctly
if(!isset($_POST["a"]) && !isset($_POST["b"])) {
  header("Location: index.php");
}

if(isset($_POST["a"])) {
  $a_array = explode(",", $_POST["a"]);
}

if(isset($_POST["b"])) {
  $b_array = explode(",", $_POST["b"]);
}

$timea = microtime(true);
if( $_POST["ava"] === 'true') {
  ?>
  <div id="ava_load" style="display:inline"></div><div id="rows" style="display:inline"> AvA rows processed.<br></div>
  <?php
  $result = query_db($con, $a_array, $a_array, "ava", $data );  
}

if( $_POST["avb"] === 'true') {
  ?>
  <div id="avb_load" style="display:inline"></div><div id="rows" style="display:inline"> AvB rows processed.<br></div>
  <?php
  $result = query_db($con, $a_array, $b_array, "avb", $data);  
}


if( $_POST["bvb"] === 'true') {
  ?>
  <div id="bvb_load" style="display:inline"></div><div id="rows" style="display:inline"> BvB rows processed.<br></div>
  <?php
  $result = query_db($con, $b_array, $b_array, "bvb", $data);  
}

?>

<?php
// Get our data columns
  while($row = mysqli_fetch_field($result)) {
    $data_columns[] = $row->name;
  }
  $timeb = microtime(true);
  $time = $timeb - $timea;
  echo "<div id=time>time_elapsed:" . $time . "\n</div></div>";
?>

<?php

if(count($data) == 0) { ?>
  <head>
    <title>POGO - No Results </title>
    <link rel="stylesheet" type="text/css" href="default.css">
  </head>

  <body>
    <div id=container>
      <?php include 'header.php'; ?>
    <div class=main>
      <center>
        <h1>No Results</h1>
        <p>
          The POGO database did not find any matches to your query.
          <a href=><sup>?</sup></a>
        </p>
      </center>
      </div>
 
<?php }
else { ?>

  <html>

  <head>
  <title>POGO - <?php echo count($data); ?> Results </title>


    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="lib/jqplot/jquery.jqplot.min.css">
    <link rel="stylesheet" type="text/css" href="media/css/TableTools.css">

    <link rel="stylesheet" type="text/css" href="default.css">
    <link rel="stylesheet" type="text/css" href="results.css">

    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="media/js/TableTools.min.js"></script>
    <script type="text/javascript" src="media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" src="lib/FixedColumns.min.js"></script>

    <script type="text/javascript" src="lib/jqplot/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
    <script type="text/javascript" src="lib/jqplot/plugins/jqplot.cursor.min.js"></script>

    <script type="text/javascript" src="results.js"></script>

    <script>
      var data = <?php echo json_encode($data); ?>;
      var dataColumns = <?php echo json_encode($data_columns); ?>;
      var marker_gene = false;
    </script>
  </head>

  <body>

  <div id=container>
  <?php include 'header.php'; ?>

  <div class="main">
  <center><h1>Results</h1></center>
  <center><div id="chart"></div></center>

  <center>
  <div id="buttons">
    <p>
      X Axis: 
      <select onChange="updateGraph()" id="x"></select>
      Y Axis:
      <select onChange="updateGraph()" id="y"></select>
    </p>
    <p>
      <button onCLick="toImage()" type="button">Download Graph</button> 
      <button onClick="zoomOut()" type="button">Reset Zoom</button> 
    </p>
  </div>
  </center>

  <table class="display" id="data">
  <thead><tr>
    <script>
      for(col in dataColumns){
        document.write("<th>" + dataColumns[col] + "</th>");
      }
    </script>
  </tr></thead></table>
  <p>
  <!-- <button type="button" class='buttons' onClick="selectAll">Select all</button> --!>
  <form id="submitform">
  <button type="button" class='buttons' onClick="submitIds()">Download Selected</button> 
  </form>
  </p>

 
<?php

if(isset($_POST["avgrank"]) && $_POST["avgrank"] === 'true') {

  $headers = array();
  $avg_data = array();

  array_push($headers, "Marker Gene");
  if($_POST["ava"] === 'true') {
    array_push($headers, "A vs. A");
  }
  if( $_POST["avb"] === 'true') {
    array_push($headers, "A vs. B");
  }
  if( $_POST["bvb"] === 'true') {
    array_push($headers, "B vs. B");
  }

  
  for($i = 0; $i < count($data); $i++) {
    $temp = array();
    
    array_push($temp, $data[$i][4]);
    for($j = 8; $j < count($data[0]); $j++) {
      array_push($temp, $data[$i][$j]);
    }
    array_push($avg_data, $temp);
  }

  $marker_cols = array();

  array_push($marker_cols, $data_columns[4]);
  for($j = 8; $j < count($data_columns) - 1; $j++) {
      array_push($marker_cols, $data_columns[$j]);
    }
    array_push($avg_data, $marker_cols);
?>

  <script>
    var headers = <?php echo json_encode($headers); ?>;
    var marker_cols = <?php echo json_encode($marker_cols); ?>;
    var avg_data = <?php echo json_encode($avg_data); ?>;
    var marker_gene = true;
  </script>

  <p style="padding: 1em"></p>
  <center>
    <h2> Average Rankings of Marker Genes </h2>
  </center>
  <table class="display" id="avg_table">
  </table><br>
  <center><div id="avggenetext"></center>
  <?php
}

} ?> 

  <?php include 'footer.php';?>
  </div>
</body>
</html>
