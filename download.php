<?php

function lookup_genome($genome) {
}

include 'login.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if(isset($_POST["ids"])) {
  $ids = explode(",", $_POST["ids"]);
} 
else if(isset($_GET["ids"])) {
  $ids = explode(",", $_GET["ids"]);
} 
else {
  echo "No ID's  requested";
  exit();
}

$query = "SELECT d.id, d.file1v2, d.file2v1, t1.Genome, t2.Genome FROM data d, taxonomy t1, taxonomy t2 WHERE (d.genome_id1=t1.id and d.genome_id2=t2.id) AND (";

$i = 0;
for($i = 0; $i < count($ids); $i++) {
  $query .= "d.id=" . $ids[$i] . " OR ";
}

$query = substr($query, 0, -3);
$query = $query . ");";

if($result = mysqli_query($con, $query)) {
  $data=array();

  $prefix = "/data/pogo_db/blast_results/";
  $ids_file = "data/geneIDs.txt";

  $blast_files_file = tempnam("/tmp", "pogo-csv");
  $gene_ids_file = tempnam("/tmp", "pogo-blast");

  $tar_command = "tar -cf - --transform='s,.*tmp/pogo-blast.*,/gene_ids.csv,;s,.*tmp/pogo-csv.*,/files.csv,;s,.*/,blast_files/,' " ;
  $grep_command = "egrep '";

  $blast_files_handle = fopen($blast_files_file, 'w');
  $gene_ids_handle = fopen($gene_ids_file, 'w');

  fwrite($blast_files_handle, "Genome 1, Genome 2, Download Id, filename1v2, filename2v1\n");
  fwrite($gene_ids_handle, shell_exec("sed -n 1p " . $ids_file));
  $genome_list = array();
  

  while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
    $tar_command .= $prefix . $row[1] . " " . $prefix . $row[2] . " "; 
    fwrite($blast_files_handle, $row[3] . ", " . $row[4] . ", " . $row[0] . ", " . preg_replace(",.*/,", "",  $row[1]) . ", " . preg_replace(",.*/,", "", $row[2]) . "\n");
    $data[] = $row;
      if(!in_array($row[3], $genome_list))
        array_push($genome_list, $row[3]);
      if(!in_array($row[4], $genome_list))
        array_push($genome_list, $row[4]);
  }
  
  for($i = 0; $i < count($genome_list) - 1; $i++) {
    $grep_command = $grep_command . $genome_list[$i] . "|";
  }
  $grep_command = $grep_command . $genome_list[count($genome_list) -1] . "' ";

  fwrite($gene_ids_handle, shell_exec($grep_command . $ids_file));


  fclose($blast_files_handle);
  fclose($gene_ids_handle);
  
  $tar_command .= " " . $blast_files_file . " " . $gene_ids_file;

  if($tar_handle = popen($tar_command, 'r')) {
    header("Content-Type: application/x-tar");
    header("Content-disposition: attachment; filename=blast_files.tar");

    $bufsize = 4096;
    $buffer = '';
    while( !feof($tar_handle) ) {
      $buffer = fread($tar_handle, $bufsize);
      echo $buffer;
    }

    pclose($tar_handle);
  }
  else {
    echo $tar_command . "<br>";
    echo "something went wrong";
  }
  unlink($blast_files_file);
  unlink($gene_ids_file);
} 
else {
  echo $query . "<br>";
  echo "one of your requested ID's does not exist";
  print_r($ids);
}

?>

