<html>

<head>
<title> PID - Results </title>
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="default.css">
<link rel="stylesheet" type="text/css" href="lib/jqplot/jquery.jqplot.min.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.js"></script>
<script type="text/javascript" src="lib/FixedColumns.min.js"></script>
<script type="text/javascript" src="lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="lib/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="results.js"></script>
</head>


<body>
<div class="main">
<?php

  include 'header.php';
  include 'login.php';
  error_reporting(E_ALL);

  $a_array = explode(",", $_GET["a"]);
  $b_array = explode(",", $_GET["b"]);
  $select = "t1.Genome as `Genome 1`, ";
  $select .= "t2.Genome as `Genome 2`, ";
  $select .= "d.id, d.file1v2, d.file2v1, ";
  $select .= "Average_Amino_Acid_Identity as `Average AAI`, ";
  $select .= "d.16S_rRNA_gene_identify as `16S rRNA`, ";
  $select .= "d.Genomic_Fluidity as `Fluidity`, ";
  $select .= "d.orthologs_criterion1 as `# of Orthologs (Criterion 1)`, ";
  $select .= "d.orthologs_criterion2 as `# of Orthologs (Criterion 2)`,";
  $select .= "ArgS, CdsA, CoaE, CpsG, DnaN, Efp, Exo, Ffh, FtsY, FusA, GlnS, GlyA, GroL,";
  $select .= "HisS, IleS, InfA, InfB, KsgA, LeuS, Map, MetG, NrdA, NusG, PepP, PheS,";
  $select .= "PheT, ProS, PyrG, RecA, RplA, RplB, RplC, RplD, RplE, RplF, RplJ, RplK,";
  $select .= "RplM, RplN, RplP, RplR, RplV, RplX, RpoA, RpoB, RpoC, RpsB, RpsC, RpsD,";
  $select .= "RpsE, RpsG, RpsH, RpsI, RpsJ, RpsK, RpsL, RpsM, RpsN, RpsO, RpsQ, RpsS,";
  $select .=" SecY, Sers, ThrS, Tmk, TopA, TrpS, TruB, TrxA, TrxB, TufB, TyrS, ValS ";
  $query = "SELECT " . $select . " FROM taxonomy t1, taxonomy t2, data d WHERE";

  for($i = 0; $i < count($a_array); $i++) {
    for($j = 0; $j < count($b_array); $j++) {
      $query = $query . "(t1.id=" . $a_array[$i] . " AND d.genome_id1=" . $a_array[$i] . " AND t2.id=" . $b_array[$j] . " AND d.genome_id2=" . $b_array[$j] . ") OR ";
      $query = $query . "(t1.id=" . $b_array[$j] . " AND d.genome_id1=" . $b_array[$j] . " AND t2.id=" . $a_array[$i] . " AND d.genome_id2=" . $a_array[$i] . ") OR ";
    }
  }
  $query = substr($query, 0, -3);
  $query = $query . ";";

  $result = mysqli_query($con, $query);
  $data = array();
  while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $data[] = $row;
  }
  $dataColumns = array();
  while($row = mysqli_fetch_field($result)) {
    $dataColumns[] = $row->name;
  }

?>

<script>
var data = <?php echo json_encode($data); ?>;
var dataColumns = <?php echo json_encode($dataColumns); ?>;
</script>

  <div id="chart"></div>
  <p>
    <select onChange="updateGraph()" id="x"></select>
    <select onChange="updateGraph()" id="y"></select>
  </p>
  
  <table class="display" id="data"><thead><tr>
    <script>
      for(col in dataColumns){
        document.write("<th>" + dataColumns[col] + "</th>");
      }
    </script>
  </tr></thead></table>
</body>
<?php include 'footer.php';?>

</html>
