<!DOCTYPE html>
<html>
<head>
  <title>POGO F.A.Q.</title>
  <link rel="stylesheet" type="text/css" href="default.css">
</head>

<?php include 'noscript.php'; ?>
<div id=container>
<?php include 'header.php'; ?>
<div class=main> 
<h1>F.A.Q.</h1>

<ol>
<li> <a href="#1">Can I add the same genome to both group A and group B? </a> </li>
<li> <a href="#2"> Why does the result missing some of the genome pairs I queried?  </a></li>
<li> <a href="#3"> Why are some metrics missing for a few pairs of genomes?  </a></li>
<li> <a href="#4"> What does the option Calculate Average Ranking” do? </a> </li>
<li> <a href="#5"> Why do you provide two criteria for determining orthologs?</a> </li> 
<li> <a href="#6"> Why does the database only cover genome pairs whose 16S rRNA identity is above 80%? </a> </li>
<li> <a href="#7"> Why does the database provide branch selection only up to the genus level?</a> </li>
<li> <a href="#8"> Can I download the entire database?</a></li>
<li> <a href="#9"> Can I download all the raw BLAST results?</a></li>
<li> <a href="#10">Can I download the sequences of all orthologs between each pair of genomes?</a></li>
</ol>

<a name="1"></a>
<h3>Can I add the same genome to both group A and group B? </h3>
<p>
Yes. Users may sometimes add a genome to group A twice or group B twice, for
example, one may add genome “Escherichia_coli_042_uid161985” to group A, and
then add the entire species “Escherichia coli” to group A. In such cases, we
will only keep a unique list of the genomes in a group. POGO-DB also allows
users to add a genome to both group A and group B, however, the comparison
between exactly the same genome will not show up (since all metrics will be 100%
similar when comparing a genome to itself). If users want to compare genomes
pairwisely within a group of genomes, say a species or genus, they can either
add the same genomes to both group A and B for comparison, or add them only to
group A and select “Compare A to itself” before submitting the query.
</p>

<a name="2"></a>
<h3>Why does the result missing some ofthe genome pairs I queried?</h3>
<p>
The POGO-DB contains BLAST result of pairs of genomes whose 16S rRNA identity is above 80%, therefore some pairs of genomes
may not be returned if the pair does not meet this criterion. The reason that we
apply such a limitation is because the BLAST between genomes is a very time
consuming computation. The 717,861 bi-directional genome-wise BLAST took 150+k
CPU hours. Besides, the major aim of the database is to provide information on
marker gene selections for finer taxonomic levels, while many known marker genes
(primarily the 16S rRNA gene) already provide satisfactory distinction at higher
taxonomic levels.  There are two other reasons that the result page may not
provide all combination of pairs of genomes selected. For one, we are not
showing the result for comparing a genome to itself because all metrics will be
100% similar. The second reason may be that users did not check the option
“Compare A to itself” or “Compare B to itself”, and therefore will only see the
default comparison between genomes in group A vs. genomes in group B.  
</p>

<a name="3"></a>
<h3>Why are some metrics missing for a few pairs of genomes?  </h3>
<p>
The POGO-DB only computes
the average AAI if two genomes have at least 200 orthologs (as defined by
criterion 1). Similarly, genomic fluidity is only computed for genomes with at
least 200 orthologs (as defined by criterion2). The limitation prevents us from
quantifying the overall genomic similarity based on only a few genes.  The
database also provides the identity of 73 marker genes, which are identified via
BLAST search for each genome. Although each marker gene is found to be present
in over 90% of the genomes, there are still some genomes that do not contain the
gene. Therefore, pairs of these genomes will not have the identity of some
marker genes. 
</p>

<a name="4"></a>
<h3>What does the option "Calculate Average Ranking" do?</h3>
<p>
In addition to the several metrics we provide for each genome pair, we also allow users to compare
the evolution rate of marker genes relatively to each other. The average rank is
such a metric we applied for this purpose. You can find our explanation of this
metric <a href="about.php#averageranking">here</a>. Briefly, we rank the marker genes
(including the 16S rRNA gene) by their identities between each pair of genomes,
and then take the average rank of each gene across all pairs of genomes. The
ranking of marker genes will only be computed for pairs of genomes where all
marker genes are identified in both genomes.  
</p>

<a name="5"></a>
<h3>Why do you provide two criteria for determining orthologs?</h3>
We used criterion1 (70+% read length covered with 30+% identity at the amino
acid level) to define orthologs used for computing the average AAI between two
genomes. This is the same criterion used by <a
href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC1236649/"> Konstantinidis and
Tiedje</a>. However, the genomic fluidity is a metric for quantifying genes
unique to a genome rather than the orthologs shared by both genomes. Therefore,
in order to be stricter about calling a gene unique to a genome, we applied a
second and loosened criterion for defining orthologs. Hence the computation of
genomic fluidity is more reliable than using the same criterion as the
computation of average AAI.  

<a name="6"></a>
<h3>Why does the database only cover genome pairs whose 16S rRNA identity is above 80%?</h3>
<p>
The reason that we apply such a limitation is because the BLAST between genomes
is a very time consuming computation. The 717,861 bi-directional genome-wise
BLAST took 150+k CPU hours.  Besides, the major aim of the database is to
provide information on marker gene selections for finer taxonomic levels, while
many known marker genes (primarily the 16S rRNA gene) already provide
satisfactory distinction at higher taxonomic levels.  To view which pairs of
genomes are included in the database and which are not, please download the 16S
rRNA percent identity table of all genomes pairwisely here <a href="/download/POGODB_16S_rRNA_identity.csv.bz2">POGODB_16S_rRNA_identity.csv.bz2</a>
</p>


<a name="7"></a>
<h3>Why does the database provide branch selection only up to the genus level?</h3>
<p>
The search time will increase exponentially to the number of genomes queried.
Therefore, we encourage users to add genomes by species or genera to the query.
For people who are interested in the comparison between more or all of the
genome pairs, we encourage them to acquire all the information in the database
 or view some of the all genomes vs. all genomes
results on our <a href="about.php#allvsall">about page</a>.
</p>

<a name="8"></a>
<h3>Can I download the entire database?</h3>
<p>
Yes. In addition to the download link we provided every time for the selected
genomes in one query, users can acquire the entire database including both the
identity information (<a href="/download/POGODB_all_genome_pairs_identities.csv.bz2">POGODB_all_genome_pairs_identities.csv.bz2</a>),
and the all of the BLAST output files (<a href="download/All.tar">All.tar</a>). We encourage users to do so when they are
interested in a large amount of genome pairwise comparisons.  
</p>

<a name="9"></a>
<h3>Can I download all the raw BLAST results?</h3>
<p>
Yes. In addition to the download link we provided for the queried genome pairs,
we also allow users to download the raw BLAST output files for all pairs of
genomes we provided. This is in fact one of the major reasons we built this
database: to save people from the massive computation time of BLAST-ing genomes
against genomes. It should be noted that we have BLAST results for a total of
717,861 pairs of genomes, bi-directionally.  Therefore, the final output takes
approximately 680G’s storage (bz2 compressed) and will take a long time to
download. 
</p>

<p>
<a href="download/all.tar">All.tar (~665GB)</a>
</p>

<a name="10"></a>
<h3>Can I download the sequences of all orthologs between each pair of genomes?</h3>
<p>
Yes. In addition to the whole genome BLAST files we provided for download (for
user selected comparisons or all comparisons), users will get a list of gene ID
indexing upon download. This indexing file could be used to map each gene ID in
the BLAST files to the accession number plus gene location in the NCBI
database. Users can therefore download the sequences for their downstream
analyses.
</p>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>
