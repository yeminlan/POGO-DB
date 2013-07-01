<?php

include 'login.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if(isset($_POST["ids"])) {

  if($_POST["ids"][0] === "all") {
    header("Location: downloads/all.tar.bz2");

  }

  $query = "SELECT id, file1v2, file2v1, genome_name1, genome_name2 FROM data WHERE ";

  $i = 0;
  for($i = 0; $i < count($_POST["ids"]); $i++) {
    $query .= "id=" . $_POST["ids"][$i] . " OR ";
  }

  $query = substr($query, 0, -3);
  $query = $query . ";";

  if($result = mysqli_query($con, $query)) {
    $data=array();

    $prefix = "/data/pogo_db/blast_results/";
    $csv_file = tempnam("/tmp", "pogo");

    $command = "tar -cf - --transform='s,.*tmp/pogo.*,/files.csv,;s,.*/,blast_files/,' " ;

    $csv_handle = fopen($csv_file, 'w');
    fwrite($csv_handle, "Genome 1, Genome 2, Download Id, filename1v2, filename2v1\n");


    while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
      $command .= $prefix . $row[1] . " " . $prefix . $row[2] . " "; 
      fwrite($csv_handle, $row[3] . ", " . $row[4] . ", " . $row[0] . ", " . preg_replace(",.*/,", "",  $row[1]) . ", " . preg_replace(",.*/,", "", $row[2]) . "\n");
      $data[] = $row;
    }

    fclose($csv_handle);

    $command .= " " . $csv_file;

    if($tar_handle = popen($command, 'r')) {

    header("Content-Type: application/x-tar");
    header("Content-disposition: attachment; filename=blast_files.tar");


    $bufsize = 4096;
    $buffer = '';
    while( !feof($tar_handle) ) {
      $buffer = fread($tar_handle, $bufsize);
      echo $buffer;
    }

    pclose($tar_handle);
    unlink($csv_file);
    } else {
      echo "something went wrong";
    }
  } else {
    echo "one of your requested ID's does not exist";
    print_r($_POST["ids"]);
  }
}
?>

