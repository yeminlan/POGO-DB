<html>
<head>

<?php

include 'login.php';
include 'search.php';
error_reporting(E_ALL);

$query = "SELECT Genus, Species, Genome, idGenome FROM taxonomy;";
$result = mysqli_query($con, $query);
$taxonomy=array();

while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $taxonomy[] = $row;
}

$query = "SELECT distinct Genus FROM taxonomy;";
$result = mysqli_query($con, $query);
$genus=array();

while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $genus[] = $row['Genus'];
}

$query = "SELECT distinct Species FROM taxonomy;";
$result = mysqli_query($con, $query);
$species=array();

while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $species[] = $row['Species'];
}

$query = "SELECT distinct Genome FROM taxonomy;";
$result = mysqli_query($con, $query);
$genome=array();

while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
  $genome[] = $row['Genome'];
}
?>

<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="default.css">

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="//datatables.net/download/build/jquery.dataTables.nightly.js"></script>
<script type="text/javascript" src="pid.js"></script>

<title>PID</title>

</head>

<body>

<?php include 'header.php'; ?>
<center>
<h2>Available Genomes</h2>
<table style="left-margin:10%;right-margin:10%;"> 
<tr>
<script type="text/javascript" charset="utf8">
  var taxonomy = <?php echo json_encode($taxonomy); ?>;
  var genus = <?php echo json_encode($genus); ?>;
  var species = <?php echo json_encode($species); ?>;
  var genome = <?php echo json_encode($genome); ?>;

</script>

<td>
  Genus:<br>
  <select onChange="selected('Genus')" id='Genus' size=20></select>
  <center>
    <p>
      <button onClick="add('Genus', 'A')" id='GenusAddA'>Add Genus to A</button>
      <button onClick="add('Genus', 'B')" id='GenusAddBr'> Add Genus to B</button>
    </p>
  </center>
</td>

<td>
  Species:<br>
  <select onChange="selected('Species')" id='Species' size=20></select>
  <center>
    <p>
      <button onClick="add('Species', 'A')" id='SpeciesAddA'>Add Species to A</button>
      <button onClick="add('Species', 'B')" id='SpeciesAddBr'> Add Species to B</button>
    </p>
 </center>
</td>

<td>Genome:<br>
  <select id='Genome' size=20></select>
  <center>
    <p>
      <button onClick="add('Genome', 'A')"id='GenomeAddA'>Add Genome to A</button>
      <button onClick="add('Genome', 'B')" id='GenomeAddBr'> Add Genome to B</button>
    </p>
  </center>
</td>

<script type="text/javascript">
  populate();
</script>
</td>
</table>

<p>
<h3>Selected Items</h3>
</p>

<h4>A Items</h4>
<table class="display" id="BoxA"><thead><tr><th>Genus</th><th>Species</th><th>Genome</th></tr></thead></td></tr><tbody></tbody></table><br>
<button "removeA" onClick="rm('#BoxA')">Remove Selected Item from A</button>
<button "removeAllA" onClick="clearTable('#BoxA')">Remove All from A</button>

<h4>B Items</h4>
<table class="display" id="BoxB"><thead><tr><th>Genus</th><th>Species</th><th>Genome</th></tr></thead></td></tr><tbody></tbody></table><br>
<p>
<button id="removeB" onClick="rm('#BoxB')">Remove Selected Item from B</button>
<button "removeAllB" onClick="clearTable('#BoxB')">Remove All from B</button>
<div class="buttonGroup">
<button id="clearAll" onClick="clearTable('#BoxA');clearTable('#BoxB')">Reset Comparison</button>
<button id="submit" onClick="submit()">Submit Query</button>
</div>
</center>
</body>
</html>
