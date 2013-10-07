<!DOCTYPE html>
<html>
<head>
<title>POGO API</title>
<link rel="stylesheet" type="text/css" href="default.css">
<link rel="stylesheet" type="text/css" href="doc.css">
</head>
<?php include 'noscript.php'; ?>
<div id=container>
<?php include 'header.php'; ?>
<div class=main> 
<h1>API Documentation</h1>
<p>
This page contains documentation and examples for our API. This API can
be used to query the Pogo database directly.
</p>

<div class=toc>
<ol>
  <li><a href="#introduction">Introduction</a></li>
  <li><a href="#organization">Organization</a></li>
  <li><a href="#query_basics">Query basics</a></li>
  <li><a href="#methods">Methods</a></li>
    <ol type="a">
      <li><a href="#type">Type</a></li>
      <li><a href="#select">Select</a></li>
      <li><a href="#where">Where</a></li>
      <li><a href="#limit">Limit</a></li>
      <li><a href="#output">Output</a></li>
    	 <li><a href="#array">Array</a></li>
    </ol>
  <li><a href="#properties">Properties</a></li>
    <ol type="a">
      <li><a href="#taxonomy">Taxonomy</a></li>
      <li><a href="#data">Comparison Data</a></li>
      <li><a href="#download">Blast Files</a></li>
    </ol>
  <li><a href="#examples">Examples</a></li>
</ol>
</div>

<h2 id="introduction" style="border:0">Introduction</h2>
<p>
A key feature of POGO is the ability for users to be able to mass query
our database. Our web interface has a certain use-case, and we recognize that
users may have different needs than our website provides. They might have a
different workflow, need to feed our data through a pipeline, or download
large sets of data.
</p>
<p>
In order to remedy this, we provide users not only with the ability to <a
href="download.php">download</a> our entire database, but also with the ability
to directly query the database for information they are interested in.
</p>


<h2 id="organization">Organization</h2>
<p>
POGO's database is internally represented by two tables. The data table
contains comparison data between two genomes, and the taxonomy table
containing taxonomic information about the genomes.
</p>

<p>
Our database's API returns JSON formatted arrays or CSV files, and uses REST's
"GET" mechanism to work. POGO's database API is loosely based around SQL select
statements, since we use MySQL as our database backend.
</p>


<h2 id="query_basics">Query Basics</h2>
Users can query the website using this url:

<code>
http://pogo.ece.drexel.edu/query.php
</code>

<p>
Queries are done by specifying certain GET variables in the URL. An example of
this can be seen below, where we query the taxonomy table for all rows with the
columns species, genome, and family.
</p>

<code>
http://pogo.ece.drexel.edu/query.php?type=taxonomy&select=species,genome,family&limit=10
</code>

<p>To get more specific results we need to tell the database to return only rows
that fit what we are interested in. As you saw above, we can tell the database what
columns we are interested in, but we now need to tell it what columns we are
interested in</p>

<p>
  The 'methods' section below explains how we can do just that.
</p>

<h1 id="methods">Methods</h1>
  There are three main methods that our API accepts. Type, Select, and Where.
  There are also other arguments including and Array, and Limit and Output.
  
  <h2 id="type">Type</h2>
  <p>
    The Type argument tells the API which table you are querying, and is
    always required when using the API. There are only two options,
    "data" and "taxonomy".
  </p>
  
  <p> The taxonomy table contains information about the different
  genomes that were compared.
  </p>

  <p>Taxonomy Example:
    <code>
      http://pogo.ece.drexel.edu/query.php?type=taxonomy&limit=10
    </code>
  </p>

  <p> The data table contains data from the comparisons.
  </p>

  <p>Data Example:
    <code>
      http://pogo.ece.drexel.edu/query.php?type=data&limit=10
    </code>
  <p>

<h2 id="select">Select</h2>
  <p>
  The Select argument allows you to choose which columns you are interested in.
  To know what columns are available please refer to the Properties section of
  this document.
  </p>
  
  <p>
  If no results are returned, then all rows in the selected table are returned
  </p>

  <p>
  This example returns the columns genus, species, ord, and superkingdom
  from the taxonomy table:
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&select=genus,species,ord,superkingdom&limit=10
  </code>
  </p>

  <p>
  This example returns the columns id from data
  from the data table:
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&select=id&limit=10
  </code>
  </p>

  <h2 id="where">Where</h2>
  <p>
  The Where argument allows you to filter the rows based upon a statement.
  These operators and statements should be familiar to anyone with rudimentary
  knowledge of logic or programming.
  </p>

  <p>
		At the bottom of this document are examples for different where statements
	</p>

  <p>
  The operators we support are listed below
  </p>
  <table class="doc_table" style="display:inline-block">
  <thead>
		<tr>
  		<th>Equality Operator</th>
			<th>Explanation</th>
		</tr>
  </thead>
	<tbody>
  <tr>
    <td>=</td>
    <td>equal</td>
  </tr>
  <tr> 
    <td>&lt;</td>
    <td>less than</td>
  </tr>
  <tr>
    <td>&gt;</td>
    <td>greater than</td>
  </tr>
  <tr>
    <td>!</td>
    <td>not. this operator proceeds others, like !=</td>
  </tr>
  <tr>
    <td>and</td>
    <td>AND operator instead of &&</td>
  </tr>
  <tr>
    <td>or</td>
    <td>OR operator</td>
  </tr>
  <tr>
    <td>xor</td>
    <td>Exclusive OR operator</td>
  </tr>
	</tbody>
  </table>

  <p>We also support other statements that allow users to do string comparisons.
  <table class="doc_table" style="display:inline-block">
  <thead>
		<tr>
  		<th>String Comparison</th>
			<th>Explanation</th>
			<th>Usage</th>
		</tr>
  </thead>
	<tbody>
  	<tr>
    	<td>like(string)</td>
    	<td>wrapper for MySQL LIKE</td>
    	<td>genus like('Chlamy')</td>
  	</tr>
	</tbody>
  </table>


<h3>Examples</h3>

  <p>
  Select all columns from rows where the genus is Bacillus
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&where=genus='Bacillus'
  </code>
  </p>

  <p>
  Select all taxonomy where the genus contains 'Actino'
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&where=genus like('Actino')
  </code>
  </p>

  <p>
  Select all data where the Genomic_Fluidity is over 90%
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=Genomic_Fluidity&gt;.90
  </code>
  </p>

  <p>
  Select all data where the Genomic_Fluidity is over 90% or less than 20%
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=Genomic_Fluidity&gt;.90 OR Genomic_Fluidity&lt;.20
  </code>
  </p>
  
  <h3>Warning: Order of Operations</h3>
  <p>
  Consider that the following statement could have multiple meanings: Select all
  taxonomy where the Genomic_Fluidity is over 90% or less than 20% and Average
  Amino Acid Identity is over 90%.</p>

  <p>
  Using parentheses we can control the order of evaluation in a statement. This
  is the same as with math, inside to outside. It also follows the same style
  as most programming languages.
  </p>
  
  <p>
  Here we have a statement where we select where Genomic_Fluidity is either over 90%, or is less than 20% and has an AAAI over 90%.
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=(Genomic_Fluidity &gt; .90) or (Genomic_Fluidity &lt; .20 AND Average_Amino_Acid_Identity &gt; .90 )
  </code>
  </p>

  <h2 id="limit">Limit</h2>
  <p> The Limit argument allows the user to specify how many results you want to return at maximum</p>

  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&limit=1000
  </code>

  <h2 id="output">Output</h2>
  <p>The Output argument allows you to specify if you want CSV or JSON output. By default a JSON array will be returned.
  </p>

  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&limit=1000&output=csv
  </code>

  <h2 id="array">Array</h2>
  <p>The Array argument allows you to specify if you want either a JSON
  Associative Array, or a Indexed Array, if you are using JSON as your output
  type. For more information read this <a
  href="http://w3schools.com/php/php_arrays.asp">link</a>.</p>

  <p>
  This argument is optional, and the POGO database will return numerical arrays
  by default.
  </p>
  <table class="doc_table" style="display:inline-block";>
    <thead>
			<tr>
      	<th>Option</th>
      	<th>Explanation</th>
			</tr>
    </thead>
    <tbody>
      <tr>
        <td>ASSOC</td>
        <td>Associative Array</td>
      </tr>
      <tr>
        <td>NUM</td>
        <td>Numerical Array</td>
      </tr>
    </tbody>
  </table>

  <p>This is an example of returning an associative array in the data table</p>
	<code>
		http://pogo.ece.drexel.edu/query.php?type=data&output=JSON&array=ASSOC&limit=10
	</code>

<h1 id="properties">Properties</h1>
<p>
This section details the columns available in our data and taxonomy tables. Each
column can be used in where statements, and in the select arguments.
</p>

<h2 id="taxonomy">Taxonomy Table</h2>

<p>
Our taxonomy table is collected from NCBI with some small changes.
</p>

<table class="doc_table"> 
  <thead>
    <th>Column Name</th>
    <th>Description</th>
    <th>Type</th>
  </thead>
  <tbody>
  <tr>
  <td>id</td>
  <td>This is a unique identifier for the genome. genome_id1 and genome_id2 in
  the data table correspond to these values.</td>
  <td>integer</td>
  </tr>
  <tr>
  <td>genome</td>
  <td>The name of the genome, which also is also a unique identifier.
  </td>
  <td>string</td>
  </tr>
  <tr>
  <td>phylum</td>
  <td>Phylum of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>class</td>
  <td>Class of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>ord</td>
  <td>Order of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>family</td>
  <td>Family of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genus</td>
  <td>Genus of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>species</td>
  <td>Species of genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>superkingdom</td>
  <td>Superkingdom of genome.</td>
  <td>string</td>
  </tr>
  
  </tbody>
</table>

<h2 id="data">Comparison Data</h2>
<p>
The comparison table contains all the information you see on the regular
webpage, like orthologs, 16S_rRNA, and other marker genes.
</p>
<table class="doc_table"> 
  <thead>
    <th>Column Name</th>
    <th>Description</th>
    <th>Type</th>
  </thead>
  <tbody>
  <tr>
  <td>id</td>
  <td>This is a unique identifier for the genome comparison.</td>
  <td>integer</td>
  </tr>
  <tr>
  <td>genome_id1, genome_id2</td>
  <td>An id of one of the two genomes in the comparison.
  </td>
  <td>string</td>
  </tr>
  <tr>
  <td>number_of_genes1, number_of_genes2</td>
  <td>Number of genes from respective genome in comparison.</td>
  <td>integer</td>
  </tr>
  <tr>
  <td>orthologs_criterion1, orthologs_criterion2</td>
  <td>See the about page for more about ortholog criterions.</td>
  <td>integer</td>
  </tr>
  <tr>
  <td>Average_Amino_Acid_Identity</td>
  <td>The Average Amino Acid Identity. See the about page for more.</td>
  <td>float</td>
  </tr>
  <tr>
  <td>Genomic_Fluidity</td>
  <td>See about page for more about Genomic Fluidity</td>
  <td>float</td>
  </tr>
  <tr>
  <td>16S_rRNA</td>
  <td>16S_rRNA identity</td>
  <td>float</td>
  </tr>
  <tr>
  <td>ArgS, CdsA, CoaE, etc.</td>
  <td>other (besides 16S rRNA) marker gene identities</td>
  <td>float</td>
  </tr>
  <tr>
  <td>genome1_name, genome2_name</td>
  <td>the name of the genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genome1_phylum, genome2_phylum</td>
  <td>the phylum of the genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genome1_class, genome2_class</td>
  <td>the class of the genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genome1_genus, genome2_genus</td>
  <td>the genus of the genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genome1_species, genome2_species</td>
  <td>the species of the genome.</td>
  <td>string</td>
  </tr>
  <tr>
  <td>genome1_superkingdom, genome2_superkingdom</td>
  <td>the superkingdom of the genome.</td>
  <td>string</td>
  </tr>
  </tbody>
</table>

<h2 id="download">Blast files</h2>
  <p>
    In order to get a tarball of blast files from our database, you need to
    query our download url. This is done in the same method as the regular
    query.
  </p>

  <p>
  The ids variable corresponds to the "id" column in the comparison table.   <p>
  </p>
  This example requests a tarball containing blast files from comparisons with
  the id's 2354, 19201, and 623719.
  </p>
  <code>
    http://pogo.ece.drexel.edu/download.php?ids=2354,19201,623719
  </code>

<h1 id="examples">Examples</h1>

<h2>Taxonomy Comparisons</h2>

Comparing genus's and other taxonomy is slightly more complicated because there
are two different genomes in each comparison, but we aren't ever sure if which
one is categorized as genome1 or genome2. Therefore you need to have slightly
more complex statements to properly select based upon taxonomy.

here's a pseudo-code where statement on how to correctly ask for all A vs B:
 <code><pre>
 if (genome1_genus is A and genome2_genus is B)
 OR
 if (genome1_genus is B and genome2_genus is A)

 >>> Then show me the results
</pre></code>

<h3>One Genus vs Another</h3>
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=(genome1_genus='Bacillus' and genome2_genus='Chlamydia') or (genome1_genus='Chlamydia' and genome2_genus='Bacillus')
  </code>


<h3>One Genus vs Itself</h3>
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=genome1_genus='Bacillus' and genome2_genus='Bacillus'
  </code>

<h3>One Species vs All Others</h3>
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=genome1_species='Haemophilus influenzae' or genome2_species='Haemophilus influenzae'
  </code>
<h3>One Species vs Itself</h3>
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=genome1_species='Haemophilus influenzae' and genome2_species='Haemophilus influenzae'
  </code>
</div>
<?php include 'footer.php'; ?>
</div>

</body>
</html>
