<!DOCTYPE html>
<html>
<head>

<?php

include 'login.php';
include 'search.php';
error_reporting(E_ALL);

$query = "SELECT Genus, Species, Genome, id FROM taxonomy;";
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
<link rel="stylesheet" type="text/css" href="index.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="index.js"></script>

<script type="text/javascript">
  populate();
</script>

<title>POGO - Home</title>

</head>

<body>
<div id=container>

<?php include 'header.php'; ?>
<div class=main>
<h1>P.O.G.O. db
</h1>
<p>
Database of Pairwise-comparisons Of Genomes and universal Orthologous genes 
</p>
<p>
Select two sets of genomes to compare: 
</p>
<div class="centered"><center>
<h3>Genomes Available</h3>

<script type="text/javascript">
  var taxonomy = <?php echo json_encode($taxonomy); ?>;
  var genus = <?php echo json_encode($genus); ?>;
  var species = <?php echo json_encode($species); ?>;
  var genome = <?php echo json_encode($genome); ?>;

</script>

<table style="top-margin:10%;"> 
<tr>

<td>
  Genus:<br />
  <select onChange="selected('Genus')" id='Genus' size=20></select>
    <p>
      <button onClick="add('Genus', 'A')" id='GenusAddA'>Add Genus to A</button>
      <br />
      <button onClick="add('Genus', 'B')" id='GenusAddBr'> Add Genus to B</button>
    </p>
</td>

<td>
  Species:<br />
  <select onChange="selected('Species')" id='Species' size=20></select>
    <p>
      <button onClick="add('Species', 'A')" id='SpeciesAddA'>Add Species to A</button>
      <br />
      <button onClick="add('Species', 'B')" id='SpeciesAddBr'> Add Species to B</button>
    </p>
</td>

<td>Genome:<br />
  <select id='Genome' size=20></select>
    <p>
      <button onClick="add('Genome', 'A')" id='GenomeAddA'>Add Genome to A</button>
      <br />
      <button onClick="add('Genome', 'B')" id='GenomeAddBr'> Add Genome to B</button>
    </p>
</td>

</tr>
</table>

<h3>Selected Items</h3>

<h4>A Items</h4>
  <table class="display" id="BoxA"><thead><tr><th>Genus</th><th>Species</th><th>Genome</th></tr></thead><tbody></tbody></table><br>
    <button id="removeA" onClick="rm('#BoxA')">Remove Selected Item from A</button>
    <button id="removeAllA" onClick="clearTable('#BoxA')">Remove All from A</button>

<h4>B Items</h4>
  <table class="display" id="BoxB"><thead><tr><th>Genus</th><th>Species</th><th>Genome</th></tr></thead><tbody></tbody></table><br>
    <button id="removeB" onClick="rm('#BoxB')">Remove Selected Item from B</button>
    <button id="removeAllB" onClick="clearTable('#BoxB')">Remove All from B</button>

<p>
  <input type="checkbox" id="AvA">Compare A to itself.
  <input type="checkbox" checked=checked id="AvB">Compare A to B.
  <input type="checkbox" id="BvB">Compare B to itself.
  <input type="checkbox" id="AverageRanking">Calculate Average Ranking <sup><a href="">?</a> </sup>
</p>

<p>
  <button id="clearAll" onClick="clearTable('#BoxA');clearTable('#BoxB')">Reset Comparison</button>
  <button id="submit" onClick="submit()">Submit Query</button>
</p>

<form name="form" method="post" id="form" action=results.php></form>
</center>
</div>
</div>
<?php include 'footer.php';?>
</div>
</body>
</html>
