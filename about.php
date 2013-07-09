<html>
<head>
  <title>POGO - About..</title>
  <link rel="stylesheet" type="text/css" href="default.css">
</head>

<div id=container>
<?php include 'header.php'; ?>
<div class=main> 
<h1> About POGO </h1>

<ol>
<li> <a href="#introduction">Introduction</a></li>
<li> <a href="#currentvision">Current Vision</a></li>
<li> <a href="#genomepairwisemetrics">Genome Pairwise Metrics</a></li>
<li> <a href="#comparisonbetweentwo">Example: Comparison Between Two Species</a></li>
<li> <a href="#comparisonwithinasinglespecies">Example: Comparison Within A Single Species</a></li> 
<li> <a href="#allvsall">Example: All vs All</a></li>
</ol>

<a name="introduction"></a>
<h2> Introduction</h2>
<p>
A major aim of metagenomic studies is to identify and compare the phylogenetic
composition of different samples. This task is usually accomplished by the use of marker genes that are
globally conserved across prokaryotes, such as the 16S rRNA gene. Therefore, the
choice of markers can greatly affect the results of studies, as different marker
genes evolve at different rates and may represent better or worse the
phylogenetic relationships of different prokaryotic lineages.
</p>

<p>
Database of Pairwise-comparisons Of Genomes and universal Orthologous genes
(POGO-DB) provides a tool for users to probe questions regarding how different
aspects of genome variation relate to each other, and to choose marker genes
that will better fit the aims of specific studies in a more informed way.
</p>
<p>
Based on computationally intensive whole-genome BLASTs, POGO-DB provides several
metrics on pairwise genome:
</p>
<ul>
  <li>Average Amino Acid Identity of all bi-directional best blast hits that
      covered at least 70% of the sequence and had 30% sequence identity.</li>
  <li>Genomic Fluidity that estimates the similarity in gene content between two
 genomes.</li>
  <li>Number of orthologs shared between two genomes (as defined by two criteria).
  <li>Pairwise identity of the most similar 16S rRNA genes.</li>
  <li>Pairwise identity of 73 additional globally-conserved marker genes (which
      were determined by us to exist in at least 90% of all the genomes). </li>
</ul>

The POGO-DB interface allows you to:

<ul>
  <li>Query and download the pairwise metrics between selected prokaryote genomes,
      species and genera.</li>
  <li>Visualize and download the result metrics against each other in a 2-D plot for
      exploratory analysis of how different genomes and universal gene markers relate to each
      other within a taxonomic group.</li>
  <li>Download pairwise genome BLAST files that were computed. </li>
</ul>

<a name="currentvision"></a>
<h2>Current Version</h2>
<p>
The current release of POGO-DB is based on genomes of 2,013 bacteria strains
from the NCBI database (in July, 2012). Genes annotated as “16S rRNA gene” were
extracted from each strain.  There were a total of 1,897 genomes with 16S rRNA
genes of legitimate length (1000bp to 1800bp nucleotides). We conducted
bi-directional BLAST (blastp) between all annotated CDS for each pair of genomes
whose maximum 16S rRNA percent identity are above 80% according to
Needleman-Wunsch alignment. To view the maximum 16S rRNA identity between all
pairs of genomes, please download <a
href="/download/POGODB_16S_rRNA_identity.csv.bz2">POGODB_16S_rRNA_identity.csv.bz2</a>
</p>
<p>
In strain Escherichia coli K12 W3110 (uid161931), we acquired 79 genes that are
annotated as single copy genes universal to all genomes in the COG database.
Using these gene sequences as reference, we conduct BLAST search (tblastn +
tblastx) to identify these marker genes in each of the 1,897 genomes. We
maintain 73 marker genes in our analysis that are present in over 90% of the
genomes, and altogether there are 1204 strains that contain all 73 marker genes
in their genomes.
</p>


<a name="genomepairwisemetrics"></a>
<h2>Genome Pairwise Metrics</h2>
<p>
<b>Orthologs (criterion1):</b> 
For each bi-directional BLAST search between two genomes, orthologs (criterion1)
are determined as the best reciprocal hits that covered at least 70% of the
sequence and had 30% sequence identity according to BLAST alignment. This is the
same criterion used by <a href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC1236649/">Konstantinidis
and Tiedje</a>
</p>

<p>
<b>Average amino acid percent identity (AAI):</b> Smith-Waterman alignment is performed for all orthologs
(as defined by criterion1) between two genomes to acquire the average amino acid
percent identity. The average AAI serves as a metric for the general genomic
similarity. Only genome pairs with at least 200 orthologs (criterion1) are
computed for the average AAI, therefore, 2,556 out of 717,861 pairs of genomes
we analyzed do not have this metric. 
</p>

<p>
<b>Orthologs (criterion2):</b> 
For each bi-directional BLAST search between two genomes, orthologs (criterion2)
are determined as the best reciprocal hits that covered at least 50% of the
sequence and had 10% sequence identity according to BLAST alignment.
</p>

<p>
<b>Genomic fluidity:</b>
<a href="http://www.biomedcentral.com/1471-2164/12/32">Genomic fluidity </a>
measures the percentage of genes shared by two genomes.  It is calculated as
the ratio of the number of unique genes in two genomes over the total number of
genes in them: Genomic Fluidity(i,j)=(Unique_i+Unique_j)/(Total_i+Total_j ). To
be strict in determining if a gene is unique to a genome, we applied a loosened
criterion (as defined by criterion2) for defining orthologs between two genomes.
Only genome pairs with at least 200 orthologs (criterion2) are computed for the
genomic fluidity, therefore, 1,882 out of 717,861 pairs of genomes we analyzed
do not have this metric.  
</p>

<p>
<b>16S rRNA percent identity:</b>
All 16S rRNA genes are aligned pairwisely using Needleman-Wunsch algorithm.
Since the 16S rRNA gene has multiple copies in about 80% of the genomes, we use
the maximum 16S rRNA similarity between genomes to represent their 16S rRNA
percent identity.  Other marker genes: In addition to the widely used 16S rRNA
gene, we identified 73 single copy genes that are universal to prokaryotes. Each
marker gene is present in more than 90% of the genomes. Similar to the 16S rRNA
gene, all nucleotide sequences are aligned pairwisely using Needleman-Wunsch
algorithm and the percent identity are provided for each marker gene. The names
and symbols of the marker genes are:
</p>

<table> 
<thead>
  <th>Gene Symbol</th>
  <th>COG ID</th>
  <th>Description</th>
</thead>
<tbody>
<tr>
  <td>ArgS</td>
  <td>COG0018</td>
  <td>Arginyl-tRNA synthetase</td>
</tr>
<tr>
  <td>CdsA</td>
  <td>COG0575</td>
  <td>CDP-diglyceride synthetase</td>
<tr>
  <td>CoaE</td>
  <td>COG0237</td>
  <td>Dephospho-CoA kinase</td>
</tr>
<tr>
  <td>CpsG</td>
  <td>COG1109</td>
  <td>Phosphomannomutase</td>
</tr>
<tr>
  <td>DnaN</td>
  <td>COG0592</td>
  <td>DNA polymerase sliding clamp subunit (PCNA homolog)</td>
</tr>
<tr>
  <td>Efp</td>
  <td>COG0231</td>
  <td>Translation elongation factor P/translation initiation factor eIF-5A</td>
</tr>
<tr>
  <td>Exo</td>
  <td>COG0258</td>
  <td>5-3 exonuclease (including N-terminal domain of PolI)</td>
</tr>
<tr>
  <td>Ffh</td>
  <td>COG0541</td>
  <td>Signal recognition particle GTPase</td>
</tr>
<tr>
  <td>FtsY</td>
  <td>COG0552</td>
  <td>Signal recognition particle GTPase</td>
</tr>

<tr>
  <td>FusA</td>
  <td>COG0480</td>
  <td>Translation elongation and release factors (GTPases)</td>
</tr>
<tr>
  <td>GlnS</td>
  <td>COG0008</td>
  <td>Glutamyl- and glutaminyl-tRNA synthetases</td>
</tr>
<tr>
  <td>GlyA</td>
  <td>COG0112</td>
  <td>Glycine hydroxymethyltransferase</td>
</tr>
<tr>
  <td>GroL</td>
  <td>COG0459</td>
  <td>Chaperonin GroEL (HSP60 family)</td>
</tr>
<tr>
  <td>HisS</td>
  <td>COG0124</td>
  <td>Histidyl-tRNA synthetase</td>
</tr>
<tr>
  <td>IleS</td>
  <td>COG0060</td>
  <td>Isoleucyl-tRNA synthetase</td>
</tr>
<tr>
  <td>InfA</td>
  <td>COG0361</td>
  <td>Translation initiation factor IF-1</td>
</tr>
<tr>
  <td>InfB</td>
  <td>COG0532</td>
  <td>Translation initiation factor 2 (GTPase)</td>
</tr>
<tr>
  <td>KsgA</td>
  <td>COG0030</td>
  <td>Dimethyladenosine transferase (rRNA methylation)</td>
</tr>
<tr>
  <td>LeuS</td>
  <td>COG0495</td>
  <td>Leucyl-tRNA synthetase</td>
</tr>
<tr>
  <td>Map</td>
  <td>COG0024</td>
  <td>Methionine aminopeptidase</td>
</tr>
<tr>
  <td>MetG</td>
  <td>COG0143</td>
  <td>Methionyl-tRNA synthetase</td>
</tr>
<tr>
  <td>NrdA</td>
  <td>COG0209</td>
  <td>Ribonucleotide reductase alpha subunit</td>
</tr>
<tr>
  <td>NusG</td>
  <td>COG0250</td>
  <td>Transcription antiterminator</td>
</tr>
<tr>
  <td>PepP</td>
  <td>COG0006</td>
  <td>Xaa-Pro aminopeptidase</td>
</tr>
<tr>
  <td>PheS</td>
  <td>COG0016</td>
  <td>Phenylalanyl-tRNA synthetase alpha subunit</td>
</tr>
<tr>
  <td>PheT</td>
  <td>COG0072</td>
  <td>Phenylalanyl-tRNA synthetase beta subunit</td>
</tr>
<tr>
  <td>ProS</td>
  <td>COG0442</td>
  <td>Prolyl-tRNA synthetase</td>
</tr>
<tr>
  <td>PyrG</td>
  <td>COG0504</td>
  <td>CTP synthase (UTP-ammonia lyase)</td>
</tr>
<tr>
  <td>RecA</td>
  <td>COG0468</td>
  <td>RecA/RadA recombinase</td>
</tr>
<tr>
  <td>RplA</td>
  <td>COG0081</td>
  <td>Ribosomal protein L1</td>
</tr>
<tr>
  <td>RplB</td>
  <td>COG0090</td>
  <td>Ribosomal protein L2</td>
</tr>
<tr>
  <td>RplC</td>
  <td>COG0087</td>
  <td>Ribosomal protein L3</td>
</tr>
<tr>
  <td>RplD</td>
  <td>COG0088</td>
  <td>Ribosomal protein L4</td>
</tr>
<tr><td>RplE</td>
<td>COG0094</td>
<td>
  Ribosomal protein L5</td>
  </tr>
  <tr><td>RplF</td>
<td>COG0097</td>
<td>
  Ribosomal protein L6</td>
  </tr>
  <tr><td>RplJ</td>
<td>COG0244</td>
<td>
  Ribosomal protein L10</td>
  </tr>
  <tr><td>RplK</td>
<td>COG0080</td>
<td>
  Ribosomal protein L11</td>
  </tr>
  <tr><td>RplM</td>
<td>COG0102</td>
<td>Ribosomal protein L13</td>
</tr>
<tr><td>RplN</td>
<td>COG0093</td>
<td>Ribosomal protein L14</td>
</tr>
<tr><td>RplP</td>
<td>COG0197</td>
<td>Ribosomal protein L16/L10E</td>
</tr>
<tr><td>RplR</td>
<td>COG0256</td>
<td>Ribosomal protein L18</td>
</tr>
<tr><td>RplV</td>
<td>COG0091</td>
<td>Ribosomal protein L22</td>
</tr>
<tr><td>RplX</td>
<td>COG0198</td>
<td>Ribosomal protein L24</td>
</tr>
<tr><td>RpoA</td>
<td>COG0202</td>
<td>DNA-directed RNA polymerase alpha subunit/40 kD subunit</td>
</tr>
<tr><td>RpoB</td>
<td>COG0085</td>
<td>DNA-directed RNA polymerase beta subunit/140 kD subunit</td>
</tr>
<tr><td>RpoC</td>
<td>COG0086</td>
<td>DNA-directed RNA polymerase beta subunit/160 kD subunit</td>
</tr
  >
  <tr><td>RpsB</td>
  <td>COG0052</td>
<td>Ribosomal protein S2</td>
</tr>
<tr><td>RpsC</td>
<td>COG0092</td>
<td>Ribosomal protein S3</td>
</tr>
<tr><td>RpsD</td>
<td>COG0522</td>
<td>Ribosomal protein S4 and related proteins</td>
</tr>
<tr><td>RpsE</td>
<td>COG0098</td>
<td>Ribosomal protein S5</td>
</tr>
<tr><td>RpsG</td>
<td>COG0049</td>
<td>Ribosomal protein S7</td>
</tr>
<tr><td>RpsH</td>
<td>COG0096</td>
<td>Ribosomal protein S8</td>
</tr>
<tr><td>RpsI</td>
<td>COG0103</td>
<td>Ribosomal protein S9</td>
</tr>
<tr><td>RpsJ</td>
<td>COG0051</td>
<td>Ribosomal protein S10</td>
</tr>
<tr><td>RpsK</td>
<td>COG0100</td>
<td>Ribosomal protein S11</td>
</tr>
<tr><td>RpsL</td>
<td>COG0048</td>
<td>Ribosomal protein S12</td>
</tr>
<tr><td>RpsM</td>
<td>COG0099</td>
<td>Ribosomal protein S13</td>
</tr>
<tr><td>RpsN</td>
<td>COG0199</td>
<td>Ribosomal protein S14</td>
</tr>
<tr><td>RpsO</td>
<td>COG0184</td>
<td>Ribosomal protein S15P/S13E</td>
</tr
  >
  <tr><td>RpsQ</td>
  <td>COG0186</td>
<td>Ribosomal protein S17</td>
</tr>
<tr>
  <td>RpsS</td>
  <td>COG0185</td>
  <td>Ribosomal protein S19</td>
</tr>
<tr>
  <td>SecY</td>
  <td>COG0201</td>
  <td>Preprotein translocase subunit SecY</td>
</tr>
<tr>
  <td>SerS</td>
  <td>COG0172</td>
  <td>Seryl-tRNA synthetase</td>
</tr>
<tr>
  <td>ThrS</td>
  <td>COG0441</td>
  <td>Threonyl-tRNA synthetase</td>
</tr>
<tr>
  <td>Tmk</td>
  <td>COG0125</td>
  <td>Thymidylate kinase</td>
</tr>
<tr>
  <td>TopA</td>
  <td>COG0550</td>
  <td>Topoisomerase IA</td>
</tr>
<tr>
  <td>TrpS</td>
  <td>COG0180</td>
  <td>Tryptophanyl-tRNA synthetase</td>
</tr>
<tr>
  <td>TruB</td>
  <td>COG0130</td>
  <td>Pseudouridine synthase</td>
</tr>
<tr>
  <td>TrxA</td>
  <td>COG0526</td>
  <td>Thiol-disulfide isomerase and thioredoxins</td>
</tr>
<tr>
  <td>TrxB</td>
  <td>COG0492</td>
  <td>Thioredoxin reductase</td>
</tr>
<tr>
  <td>TufB</td>
  <td>COG0050</td>
  <td>GTPases - translation elongation factors</td>
</tr>
<tr>
  <td>TyrS</td>
  <td>COG0162</td>
  <td>Tyrosyl-tRNA synthetase</td>
</tr>
<tr>
  <td>ValS</td>
  <td>COG0525</td>
  <td>Valyl-tRNA synthetase</td>
</tr>
</tbody>
</table>
<p>
<a name="averageranking">
<b>Average ranking of marker genes:</b>
We allow users to compare marker genes across genome pairs. For pairs with both
genomes containing all 73 marker genes and the 16S rRNA gene, we rank the genes
by their identities from 1 to 74. The rank represents the evolution rate of each
gene relatively to each other between two genomes. We then take the average rank
of each marker gene across all genome pairs. This is done for genome pairs in "A
vs. A", "B vs. B" and "A vs. B" separately. 
</p>

<a name="comparisonbetweentwo"></a>
<h2>Example: Comparison Between Two Species</h2>
<p>
Users can select any number of genomes into both group A and group B, they can
also add an entire species or genus at a time. For example, users can select
species “Streptococcus equi” to add species to group A, and then select
“Streptococcus pneumoniae” to add to group B. 
</p>

<p>
By default, the database provides comparison between each genome in group A vs.
each genome in group B, however, the users are free to choose whether they also
want the comparisons within group A and within group B. 
</p>

<img src="images/example_comparison_between_two_species_1.png">
<p>
The result page presents a table, and each row of it represents a pair of
genomes queried, as long as the two genomes have 80+% 16S rRNA gene identity.
For each pair of genomes, several metrics are provided, including the average
amino acid identity of the genomes, genomic fluidity, number of orthologs (as
defined by two criteria), the 16S rRNA gene identity and the identity of other
marker genes
</p>

<img src="images/example_comparison_between_two_species_2.png">

<p>
In addition, a 2-D graph will be provided for the users, to plot any two metrics
of the user’s choice (default graph is 16S rRNA identity vs. the average AAI).
By choosing different metrics on the axis, users can visualize which marker gene
better groups/separates the two selected groups of genomes. 
</p>

<img src="images/example_comparison_between_two_species_5.png">
<br>
<img src="images/ss5.png">


<p>
In this case, for example, gene InfA provides tighter clustering of the genome
groups, indicating that it is very conserved within in each species. Therefore,
this gene is a good marker for differentiating the two species but cannot be
used for differentiating the genomes within each species. 
</p>

<img src="images/example_comparison_between_two_species_4.png">

<p>
If the "Average Ranking" option is checked, an additional table will be provided
showing the average rank of each marker gene across the queried pairs of
genomes. Some of the pairs may not be included in this computation because the
genomes do not have all 74 marker genes. Therefore, the number of pairs actually
incorporated into the computation will be shown in the heading of the table.  
</p>


<a name="comparisonwithinasinglespecies"></a>
<h2>Example: Comparison Within A Single Species</h2>
<p>
In addition to the comparison between two groups of genomes, we allow users to
visualize the pairwise comparison of genomes in only one species, genus or a
combination of genera selected by them. This can be done by adding the genomes
of interest into only one group, for example, adding species “Bacillus cereus”
to group A, and choose to compare A to itself. 
</p>

<img src="images/example_comparison_within_a_single_species_1.png">

<p>
In this example, we can see that the average amino acid identity ranges from
92-100%, and the 16S rRNA genes from the species are forming two groups.
Noticeably, more similar 16S rRNA genes do not necessarily indicate higher
average AAI, which is the similarity metric of two genomes over all their
orthologs. Therefore, the 16S rRNA gene is not a good marker for this species
</p>

<img src="images/example_comparison_within_a_single_species_2.png">

<p>
To the contrary, several other marker genes such as the RpoB gene provide a
continuous and more correlated variation between the genomes, and hence can be a
potentially better marker gene for this species. 
</p>

<img src="images/example_comparison_within_a_single_species_3.png">

<a name="allvsall"></a>
<h2>Example: All vs. All</h2>
<p>
The search time increases exponentially to the number of genomes queried.
Therefore, should the users be interested in the comparison between most of the
genomes, we provide the result table ready to download <a
href="/download/POGODB_all_genome_pairs_identities.csv.bz2">POGODB_all_genome_pairs_identities.csv.bz2</a>,
which contains the results for all pairs of genomes whose 16S rRNA gene identity
are above 80%. To view the maximum 16S rRNA identity between all pairs of
genomes, please download <a
href="/download/POGODB_16S_rRNA_identity.csv.bz2">POGODB_16S_rRNA_identity.csv.bz2</a>.
The 2-D graphs of several metrics are also pre-draw, which are available below
and also for <a
href="/download/POGODB_all_genome_pairs_figures.zip">/download/POGODB_all_genome_pairs_figures.zip</a>.
</p>

<img src="images/example_all_vs_all_1.png"><br>
<img src="images/example_all_vs_all_2.png"><br>
<img src="images/example_all_vs_all_3.png"><br>
<img src="">
</div>
<?php include 'footer.php'; ?>

</div>
</body>
</html>
