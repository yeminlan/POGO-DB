<?php

function query_db($con, $arr1, $arr2, $comp, &$data) {

  $select = "d.id as ` `, t1.Genome as `Genome 1`, t2.Genome as `Genome 2`, ";
  $select .= "d.file1v2, d.file2v1, ";
  $select .= "Average_Amino_Acid_Identity as `Average AAI`, ";
  $select .= "d.16S_rRNA_gene_identify as `16S rRNA`, ";
  $select .= "d.Genomic_Fluidity as `Genomic Fluidity`, ";
  $select .= "d.orthologs_criterion1 as `Orthologs (1)`, ";
  $select .= "d.orthologs_criterion2 as `Orthologs (2)`,";
  $select .= "ArgS, CdsA, CoaE, CpsG, DnaN, Efp, Exo, Ffh, FtsY, FusA, GlnS, GlyA, GroL, HisS, IleS, InfA, InfB, KsgA, LeuS, Map, MetG, NrdA, NusG, PepP, PheS, PheT, ProS, PyrG, RecA, RplA, RplB, RplC, RplD, RplE, RplF, RplJ, RplK, RplM, RplN, RplP, RplR, RplV, RplX, RpoA, RpoB, RpoC, RpsB, RpsC, RpsD, RpsE, RpsG, RpsH, RpsI, RpsJ, RpsK, RpsL, RpsM, RpsN, RpsO, RpsQ, RpsS,SecY, Sers, ThrS, Tmk, TopA, TrpS, TruB, TrxA, TrxB, TufB, TyrS, ValS, ";
  $query = "SELECT " . $select . " '" . $comp . "' as `Group Comparison` FROM taxonomy t1, taxonomy t2, data d WHERE";


  for($i = 0; $i < count($arr1); $i++) {
    for($j = 0; $j < count($arr2); $j++) {
      $query = $query . "(t1.id=" . $arr1[$i] . " AND d.genome_id1=" . $arr1[$i] . " AND t2.id=" . $arr2[$j] . " AND d.genome_id2=" . $arr2[$j] . ") OR ";
      $query = $query . "(t1.id=" . $arr2[$j] . " AND d.genome_id1=" . $arr2[$j] . " AND t2.id=" . $arr1[$i] . " AND d.genome_id2=" . $arr1[$i] . ") OR ";
    }
  }

  $query = substr($query, 0, -3);
  $query = $query . ";";

  if( $result = mysqli_query($con, $query)) {
    while($row = mysqli_fetch_array($result, MYSQL_NUM)) {
      $data[] = $row;
    }
  }
  else {
    echo "something went wrong, " . $comp ." query failed<BR>";
  }

  return $result;
};

?>
