<!DOCTYPE html>
<html>
<head>
  <title>POGO Downloads</title>
  <link rel="stylesheet" type="text/css" href="default.css">
</head>
<div id=container>
<?php include 'header.php'; ?>
<div class=main> 
<h1>Downloads</h1>
<p>
We provide users with all of our data, so that they can do their own experiements, or download the data in bulk.
</p>

<table class="doc_table">
<thead>
<th>Size</th>
<th>File</th>
<th>Description</th>
<tr>
  <td>
    70Mb
  </td>
  <td>
    <div class="download">
      <a href="http://pogo.ece.drexel.edu/download/POGODB_all_genome_pairs_identities.csv.bz2">
        <img src="images/icons/text.png">
        all_genome_pairs_identities.csv.bz2
      </a>
    </div>
  </td>
  <td>
    All comparison data for genome comparison whose 16S rRNA gene identity is above 80%.
  </td>
</tr>
<tr class="alt">
  <td>
    256Kb
  </td>
  <td>
    <div class="download">
      <a href="http://pogo.ece.drexel.edu/download/POGODB_all_genome_pairs_figures.tar">
        <img src="images/icons/image2.png">
        all_genome_pairs_figures.tar
      </a>
    </div>
  </td>
  <td>
    A tarball of the All vs. All graphs available on the about page.
  </td>
</tr>
<tr>
  <td>
    5.4Mb
  </td>
  <td>
    <div class="download">
      <a href="http://pogo.ece.drexel.edu/download/POGODB_16S_rRNA_identity.csv.bz2">
        <img src="images/icons/text.png">
        16S_rRNA_identity.csv.bz2
      </a>
    </div>
  </td>
  <td>
   The maximum 16S rRNA identity between all pairs, even those below 80%.
  </td>
</tr>
<tr class="alt">
  <td>
    688Gb
  </td>
  <td>
    <div class="download">
      <a href="http://pogo.ece.drexel.edu/download/All.tar">
        <img src="images/icons/compressed.png">
        All.tar
      </a>
    </div>
  </td>
  <td>
    WARNING: This file is extremely large. This is a tarball of all blast files in our database. 
  </td>
</tr>
<tr> 
  <td>
    39Kb 
  </td>
  <td>
    <div class="download">
      <a href="http://pogo.ece.drexel.edu/download/POGODB_taxonomy.csv.bz2">
        <img src="images/icons/text.png">
        taxonomy.csv.bz2
      </a>
    </div>
  </td>
  <td>
    This file contains all of the taxonomic data we have, which was originally collected from NCBI with some corrections.
  </td>
</tr>
<tr> 
  <td>
    44Mb 
  </td>
  <td>
    <div class="download"
      <a href="http://pogo.ece.drexel.edu/download/POGODB_all_geneIDs.csv.bz2">
        <img src="images/icons/text.png">
        all_geneIDs.csv.bz2
      </a>
    </div>
  </td>
  <td>
    This file links the gene IDs in each genome to their accession number and location in NCBI, where the sequences can be downloaded.
  </td>
</tr>
</table>

</p>
If you do not see a download you are looking for on this webpage, please <a href="contact.php">contact us</a>.
</p>

</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>
