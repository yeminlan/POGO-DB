<html>

<head>
  <title> PID - Results </title>

  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="default.css">
  <link rel="stylesheet" type="text/css" href="results.css">
  <link rel="stylesheet" type="text/css" href="lib/jqplot/jquery.jqplot.min.css">
  <link rel="stylesheet" type="text/css" href="lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js">

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.js"></script>
  <script type="text/javascript" src="lib/FixedColumns.min.js"></script>
  <script type="text/javascript" src="lib/jqplot/jquery.jqplot.min.js"></script>
  <script type="text/javascript" src="lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
  <script type="text/javascript" src="lib/jqplot/plugins/jqplot.cursor.min.js"></script>
  <script type="text/javascript" src="media/js/TableTools.min.js"></script>
  <script type="text/javascript" src="results.js"></script>
</head>


<body>
<div id=container>
<?php

  include 'header.php';
  include 'login.php';
  ini_set('display_errors', 'On');
  error_reporting(E_ALL);

  if(!isset($_POST["a"]) || !isset($_POST["b"])) {
    header("Location: index.php");
  }

  $a_array = explode(",", $_POST["a"]);
  $b_array = explode(",", $_POST["b"]);
  $select = "t1.Genome as `Genome 1`, t2.Genome as `Genome 2`, ";
  $select .= "d.id, d.file1v2, d.file2v1, ";
  $select .= "Average_Amino_Acid_Identity as `Average AAI`, ";
  $select .= "d.16S_rRNA_gene_identify as `16S rRNA`, ";
  $select .= "d.Genomic_Fluidity as `Fluidity`, ";
  $select .= "d.orthologs_criterion1 as `Orthologs (Criterion 1)`, ";
  $select .= "d.orthologs_criterion2 as `Orthologs (Criterion 2)`,";
  $select .= "ArgS, CdsA, CoaE, CpsG, DnaN, Efp, Exo, Ffh, FtsY, FusA, GlnS, GlyA, GroL, HisS, IleS, InfA, InfB, KsgA, LeuS, Map, MetG, NrdA, NusG, PepP, PheS, PheT, ProS, PyrG, RecA, RplA, RplB, RplC, RplD, RplE, RplF, RplJ, RplK, RplM, RplN, RplP, RplR, RplV, RplX, RpoA, RpoB, RpoC, RpsB, RpsC, RpsD, RpsE, RpsG, RpsH, RpsI, RpsJ, RpsK, RpsL, RpsM, RpsN, RpsO, RpsQ, RpsS,SecY, Sers, ThrS, Tmk, TopA, TrpS, TruB, TrxA, TrxB, TufB, TyrS, ValS, ";
  $query = "SELECT " . $select . "'avb' as vs FROM taxonomy t1, taxonomy t2, data d WHERE";

  // a vs. b

  $data=array();
  for($i = 0; $i < count($a_array); $i++) {
    for($j = 0; $j < count($b_array); $j++) {
      $query = $query . "(t1.id=" . $a_array[$i] . " AND d.genome_id1=" . $a_array[$i] . " AND t2.id=" . $b_array[$j] . " AND d.genome_id2=" . $b_array[$j] . ") OR ";
      $query = $query . "(t1.id=" . $b_array[$j] . " AND d.genome_id1=" . $b_array[$j] . " AND t2.id=" . $a_array[$i] . " AND d.genome_id2=" . $a_array[$i] . ") OR ";
    }
  }

  
  $query = substr($query, 0, -3);
  $query = $query . ";";

  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $data[] = $row;
  }

  if($_POST["ava"] == true) 
    echo "ava is true";
  if($_POST["bvb"] == true) 
    echo "bvb is true";
  // a vs. a 
  if($_POST["ava"] == true) {
    $query = "SELECT " . $select . "'ava' as vs FROM taxonomy t1, taxonomy t2, data d WHERE";
    for($i = 0; $i < count($a_array); $i++) {
      for($j = 0; $j < count($a_array); $j++) {
        $query = $query . "(t1.id=" . $a_array[$i] . " AND d.genome_id1=" . $a_array[$i] . " AND t2.id=" . $a_array[$j] . " AND d.genome_id2=" . $a_array[$j] . ") OR ";
        $query = $query . "(t1.id=" . $a_array[$j] . " AND d.genome_id1=" . $a_array[$j] . " AND t2.id=" . $a_array[$i] . " AND d.genome_id2=" . $a_array[$i] . ") OR ";
      }
    }
    $query = substr($query, 0, -3);
    $query = $query . ";";
  }

  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $data[] = $row;
  }

  // a vs. b
  if($_POST["bvb"] == true) {
    $query = "SELECT " . $select . "'ava' as vs FROM taxonomy t1, taxonomy t2, data d WHERE";
    for($i = 0; $i < count($b_array); $i++) {
      for($j = 0; $j < count($b_array); $j++) {
        $query = $query . "(t1.id=" . $b_array[$i] . " AND d.genome_id1=" . $b_array[$i] . " AND t2.id=" . $b_array[$j] . " AND d.genome_id2=" . $b_array[$j] . ") OR ";
        $query = $query . "(t1.id=" . $b_array[$j] . " AND d.genome_id1=" . $b_array[$j] . " AND t2.id=" . $b_array[$i] . " AND d.genome_id2=" . $b_array[$i] . ") OR ";
      }
    }
    $query = substr($query, 0, -3);
    $query = $query . ";";
  }

  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $data[] = $row;
  }

  $dataColumns = array();
  while($row = mysqli_fetch_field($result)) {
    $dataColumns[] = $row->name;
  }

?>

<div class="main">
<script>
var data = <?php echo json_encode($data); ?>;
var dataColumns = <?php echo json_encode($dataColumns); ?>;
</script>

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
  </div>
<?php include 'footer.php';?>
</body>

</html>
