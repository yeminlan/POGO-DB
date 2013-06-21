<?php

include 'login.php';
include 'functions.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$data=array();
$dataColumns = array();

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

if( $_POST["ava"] === 'true') {
  $result = query_db($con, $a_array, $a_array, "ava", $data);  
}

if( $_POST["avb"] === 'true') {
  $result = query_db($con, $a_array, $b_array, "avb", $data);  
}


if( $_POST["bvb"] === 'true') {
  $result = query_db($con, $b_array, $b_array, "bvb", $data);  
}

// Get our data columns
  while($row = mysqli_fetch_field($result)) {
    $dataColumns[] = $row->name;
  }
?>

<?php

if(count($data) == 0) { ?>
  <head>
    <title> POGO - No Results </title>
    <link rel="stylesheet" type="text/css" href="default.css">
  </head>

  <body>
    <div id=container>
      <?php include 'header.php'; ?>
    <div class=main>
      <center>
        <h1> No Results</h1>
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
  <title> POGO - <?php echo count($data); ?> Results </title>

    <link rel="stylesheet" type="text/css" href="default.css">
    <link rel="stylesheet" type="text/css" href="results.css">

    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="lib/jqplot/jquery.jqplot.min.css">
    <link rel="stylesheet" type="text/css" href="lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.js"></script>
    <script type="text/javascript" src="lib/FixedColumns.min.js"></script>
    <script type="text/javascript" src="lib/jqplot/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
    <script type="text/javascript" src="lib/jqplot/plugins/jqplot.cursor.min.js"></script>
    <script type="text/javascript" src="results.js"></script>

    <script>
      var data = <?php echo json_encode($data); ?>;
      var dataColumns = <?php echo json_encode($dataColumns); ?>;
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
  </div>
  </center>

  <table class="display" id="data"><thead><tr>
    <script>
      for(col in dataColumns){
        document.write("<th>" + dataColumns[col] + "</th>");
      }
    </script>
  </tr></thead></table>
<?php } ?> 

  <?php include 'footer.php';?>
  </div>
</body>
</html>
