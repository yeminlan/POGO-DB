<?php
include 'login.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$data_columns = array( "id","genome_id1","genome_id2","number_of_genes1","number_of_genes2","file1v2","file2v1orthologs_criterion1","orthologs_criterion2","Average_Amino_Acid_Identity","Genomic_Fluidity","16S_rRNA","ArgS","CdsA","CoaE","CpsG","DnaN","Efp","Exo","Ffh","FtsY","FusA","GlnS","GlyA","GroL","HisS","IleS","InfA","InfB","KsgA","LeuS","Map","MetG","NrdA","NusG","PepP","PheS","PheT","ProS","PyrG","RecA","RplA","RplB","RplC","RplD","RplE","RplF","RplJ","RplK","RplM","RplN","RplP","RplR","RplV","RplX","RpoA","RpoB","RpoC","RpsB","RpsC","RpsD","RpsE","RpsG","RpsH","RpsI","RpsJ","RpsK","RpsL","RpsM","RpsN","RpsO","RpsQ","RpsS","SecY","Sers","ThrS","Tmk","TopA","TrpS","TruB","TrxA","TrxB","TufB","TyrS","ValS","genome1_name","genome1_Phylum","genome1_class","genome1_order","genome1_family","genome1_genus","genome1_species","genome1_superkingdom","genome2_name","genome2_phylum","genome2_class","genome2_order","genome2_family","genome2_genus","genome2_species","genome2_superkingdom");
//$taxonomy_columns = array( "id","Genome","Phylum","Class","Order","Family","Genus","Species","Superkingdom" );
function err($error_string) {
  echo $error_string;
  exit;
}

// do some basic checks.
if(!isset($_GET["type"])) {
  err("missing type");
}
else {
  if($_GET["type"] === "taxonomy") {
    $type = $_GET["type"];
    $columns = $taxonomy_columns;
  }
  elseif($_GET["type"] === "data") {
    $columns = $data_columns;
    $type = "data_and_taxonomy";
  }
  else {
    err("unknown type");
  }
}

if(isset($_GET["where"])) {
  $where = $_GET["where"];
  $where = preg_replace(",like\\('(.*)'\\),", "LIKE('%$1%')", $where);
}
else {
  $where = "";
}


if(isset($_GET["limit"])) {
  $limit = "LIMIT " . intval($_GET["limit"]);
} else {
  $limit = "";
}

// parse selection and error check
if(!isset($_GET["select"])) {
  $select = "*";
} 
else {
  // create an array
  $select_array = explode(",", $_GET["select"]);

  // if empty error out
  if(count($select_array) == 0) {
    err("No columnss specified");
  }

  // ok iterate through our array to ensure these columns actually exist.
  foreach($select_array as $val) {
    if(!in_array($val, $columns)) {
      err("No column named: " . $val);
    }
  }
  $select = $_GET["select"];
}

// parse array type and error check
if(!isset($_GET["array"])) {
  $array_type = MYSQL_NUM;
} else { 
  if(strtoupper($_GET["array"]) === "ASSOC") {
    $array_type  = MYSQL_ASSOC;
  }
  else if(strtoupper($_GET["array"]) === "NUM") {
    $array_type  = MYSQL_NUM;
  }
  else {
    err("unknown array type: " . $_GET["array"]);
  }
}


if(isset($_GET["output"])) {
  if(strtoupper($_GET["output"]) === "CSV") {
    $output = "CSV";
  }
  else if(strtoupper($_GET["output"]) === "JSON") {
    $output = "JSON";
  }
  else {
    err("unknown output type: " . $_GET["output"]);
  }
} else {
  $output = "JSON";
}

$query = "SELECT " . $select . " FROM " . $type . " WHERE " . $where . " " . $limit . ";";
//echo $query . "<br>";

$data = array();

if($result = mysqli_query($con, $query)) {
  if($output === 'CSV') {
    while($row = mysqli_fetch_array($result, $array_type)) {
      for($j = 0; $j < count($row) - 1; $j++) {
        echo $row[$j];
        echo ",";
      }
      echo $row[count($row) - 1];
      echo "\n";
    }
  }

  else if($output === 'JSON') {
    echo "[";
    for($i = 0; $i < mysqli_num_rows($result) - 1; $i++) {
     $row = mysqli_fetch_array($result, $array_type);
     echo json_encode($row);
     echo ",";
    }
    $row = mysqli_fetch_array($result, $array_type);
    echo json_encode($row);
    echo "]";
  }
}

?>
