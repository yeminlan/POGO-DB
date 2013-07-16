<?php
include 'login.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$data_columns = array( "ID","GENOME_ID1","GENOME_ID2","NUMBER_OF_GENES1","NUMBER_OF_GENES2","FILE1V2","FILE2V1ORTHOLOGS_CRITERION1","ORTHOLOGS_CRITERION2","AVERAGE_AMINO_ACID_IDENTITY","GENOMIC_FLUIDITY","16S_RRNA","ARGS","CDSA","COAE","CPSG","DNAN","EFP","EXO","FFH","FTSY","FUSA","GLNS","GLYA","GROL","HISS","ILES","INFA","INFB","KSGA","LEUS","MAP","METG","NRDA","NUSG","PEPP","PHES","PHET","PROS","PYRG","RECA","RPLA","RPLB","RPLC","RPLD","RPLE","RPLF","RPLJ","RPLK","RPLM","RPLN","RPLP","RPLR","RPLV","RPLX","RPOA","RPOB","RPOC","RPSB","RPSC","RPSD","RPSE","RPSG","RPSH","RPSI","RPSJ","RPSK","RPSL","RPSM","RPSN","RPSO","RPSQ","RPSS","SECY","SERS","THRS","TMK","TOPA","TRPS","TRUB","TRXA","TRXB","TUFB","TYRS","VALS","GENOME1_NAME","GENOME1_PHYLUM","GENOME1_CLASS","GENOME1_ORDER","GENOME1_FAMILY","GENOME1_GENUS","GENOME1_SPECIES","GENOME1_SUPERKINGDOM","GENOME2_NAME","GENOME2_PHYLUM","GENOME2_CLASS","GENOME2_ORDER","GENOME2_FAMILY","GENOME2_GENUS","GENOME2_SPECIES","GENOME2_SUPERKINGDOM");
$taxonomy_columns = array( "ID","GENOME","PHYLUM","CLASS","ORDER","FAMILY","GENUS","SPECIES","SUPERKINGDOM" );
function err($error_string) {
  echo $error_string;
  exit;
}

// do some basic checks.
if(isset($_GET["type"])) {
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
else {
  err("missing type");
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
if(isset($_GET["select"])) {
  // if empty error out
  if($_GET["select"] === "") {
    $select = "*";
  } else {
    // create an array
    $select_array = explode(",", $_GET["select"]);

    // iterate through our array to ensure these columns actually exist.
    foreach($select_array as $val) {
      if(!in_array(strtoupper($val), $columns)) {
        err("No column named: " . $val);
      }
    }
    
    // if all columns are valid, then set our select to equal $_GET["select"] 
    $select = $_GET["select"];
  }
}
else {
  $select = "*";
} 

// parse array type and error check
if(isset($_GET["array"])) {
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
else { 
  $array_type = MYSQL_NUM;
} 

if(isset($_GET["output"])) {
  if(strtoupper($_GET["output"]) === "CSV") {
    $output = "CSV";
  }
  else if(strtoupper($_GET["output"]) === "JSON") {
    $output = "JSON";
  }
  else {
    err("Unknown output type: " . $_GET["output"]);
  }
} else {
  $output = "JSON";
}


// Construct our query
$query = "SELECT " . $select . " FROM " . $type . " WHERE " . $where . " " . $limit . ";";

if(isset($_GET["debug"]) && $_GET["debug"]=== "true") {
  echo $query . "<br>";
}

$data = array();

if($result = mysqli_query($con, $query)) {
  if(mysqli_num_rows($result) == 0) {
    err("No Results");
  }

  if($output === 'CSV') {
    // output header
    for($i = 0; $i < mysqli_num_fields($result) - 1; $i++) {
    echo mysqli_fetch_field($result)->name . ",";
    }
    echo mysqli_fetch_field($result)->name . "\n";

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
} else {
  err("There was an error in your query: " . mysqli_error($con));
}

?>
