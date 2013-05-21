<html>
<head>
<link rel="stylesheet" type="text/css" href="default.css">
<title>PID</title>
</head>

<body>
<div class="header">
<form action="index.php" method="get" style="margin-bottom:0em;">
Search For: <input type="text" name="search">
In: <select name="taxonomy">
<option selected value="All">All</option>
<option value="Genome">Genome</option>
<option value="Phylum">Phylum</option>
<option value="Class">Class</option>
<option value="Order">Order</option>
<option value="Family">Family</option>
<option value="Genus">Genus</option>
<option value="Species">Species</option>
</select>
<input type="submit">
</form>
</div>
<div class='results'>

<?php

include 'login.php';
ini_set('display_errors', 'On');


if(isset($_GET["id1"]) && isset($_GET["id2"])) {

  $query = "SELECT * FROM data WHERE genome_id1='" . $_GET["id1"] . "' AND genome_id2='" . $_GET["id2"] . "';";
  echo "<h3>Comparing " . $_GET["id1"] . " with " . $_GET["id2"] . "</h3>";

  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_array($result);
  $row_names = mysqli_fetch_fields($result);

  for($i = 0; $i < mysqli_field_count($con); $i++) {
    echo $row_names[$i]->name . ": ". $row[$i] . "<br>";
  }
}

else if(isset($_GET["id"])) {
  $query = "SELECT genome_id1, genome_id2 FROM data WHERE genome_id1='" . $_GET["id"] . "';";
  $result = mysqli_query($con, $query);

  echo "<h3>Select a genome to compare with " . $_GET["id"] . "</h3>";

  while($row = mysqli_fetch_array($result)) {
    echo "<a href='index.php?id1=" . $row['genome_id1'] . "&id2=" . $row['genome_id2'] . "'>" . $row['genome_id2'] . "</a><br>";
  }
}

else if(isset($_GET["search"])) {
  $query = "SELECT * FROM taxonomy WHERE `" . $_GET["taxonomy"] . "` LIKE '%" . $_GET["search"] . "%';";

  if($_GET["taxonomy"] === "All") {
  $query = "SELECT * FROM taxonomy WHERE ";
  $query = $query . "`Genome` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Phylum` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Class` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Order` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Family` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Genus` LIKE '%" . $_GET["search"] . "%' ";
  $query = $query . "OR `Species` LIKE '%" . $_GET["search"] . "%';";
  }

  echo "<h3>Searching " . $_GET["taxonomy"] . " for " . $_GET["search"] . "</h3>";

  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)) {
    echo "<a href='index.php?id=" . $row['Genome'] . "'>" . $row['Genome'] . "</a><br>";
  }
}

else {
  echo "<h2>Welcome to PID</h2>";
  $query = "SELECT * FROM taxonomy;";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_array($result)) {
    echo "<a href='index.php?id=" . $row['Genome'] . "'>" . $row['Genome'] . "</a><br>";
  }
}

mysqli_close($con);


echo "</div><div class='footer'>";
if(isset($result)) {
  printf("Query returned %d results<br>", mysqli_num_rows($result));
} else {
  echo "<br>";
}
echo "</div>";

?>
</body>
</html>
