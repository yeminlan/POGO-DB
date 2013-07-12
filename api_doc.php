<!DOCTYPE html>
<html>
<head>
<title>POGO Downloads</title>
<link rel="stylesheet" type="text/css" href="default.css">
<link rel="stylesheet" type="text/css" href="doc.css">
</head>
<div id=container>
<?php include 'header.php'; ?>
<div class=main> 
<h1>API Documentation</h1>
<p>
This page contains documentation and examples for our API. This API can
be used to query the database directly</p>

<div class=toc>
<ol>
  <a href="#introduction"><li>Introduction</li></a>
  <a href="#organization"><li>Organization</li></a>
  <a href="#query_basics"><li>Query basics</li></a>
  <a href="#methods"><li>Methods</li></a>
    <ol type="a">
      <a href="#type"><li>Type</li>
      <a href="#select"><li>Select</li>
      <a href="#where"><li>Where</li>
      <a href="#array"><li>Array</li>
    </ol>
  <a href="#properties"><li>Properties</li></a>
    <ol type="a">
      <a href="#taxonomy"><li>Taxonomy</li></a>
      <a href="#data"><li>Comparison Data</li></a>
      <a href="#download"><li>Blast Files</li></a>
    </ol>

</ol>
</div>

<a name="introduction"></a>
<h2 style="border:0">Introduction</h2>
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


<a name="organization"></a>
<h2>Organization</h2>
<p>
POGO's database is internally represented by two tables. The data table
contains comparison data between two genomes, and the taxonomy table
containing taxonomic information about the genomes.
</p>

<p>
Our database's API returns JSON formatted arrays, and uses REST's "GET"
mechanism to work. POGO's database API is loosely based around SQL select
statements, since we use MySQL as our database backend.
</p>


<a name="query_basics"></a>
<h2>Query Basics</h2>
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
http://pogo.ece.drexel.edu/query.php?type=taxonomy&select=species,genome,family
</code>

<p>To get more specific results we need to tell the database to return only rows
that fit what we are interested. As you saw above, we can tell the database what
columns we are interested in, but we now need to tell it what columns we are
interested in</p>

<p>
  The 'methods' section below explains how we can do just that.
</p>

<a name="methods"></a>
<h1>Methods</h1>
  There are four basic methods that our API accepts. Type, Select, Where and
  Array.
  
  <a name="type"></a>
  <h2>Type</h2>
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
      http://pogo.ece.drexel.edu/query?type=taxonomy
    </code>
  </p>

  <p> The data table contains data from the comparisons.
  </p>

  <p>Data Example:
    <code>
      http://pogo.ece.drexel.edu/query.php?type=data
    </code>
  <p>

  <a name="select"></a>
  <h2>Select</h2>
  <p>
  The Select argument allows you to choose which columns you are interested in.
  To know what columns are available please refer to the Properties section of
  this document.
  </p>
  
  <p>
  If no results are returned, then all rows in the selected table are returned
  </p>

  <p>
  This example returns the columns genus, species, order, and superkingdom
  from the taxonomy table:
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&select=genus,species,order,superkingdom
  </code>
  </p>

  <p>
  This example returns the columns id from data
  from the data table:
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&select=id
  </code>
  </p>

  <a name="where"></a>
  <h2>Where</h2>
  <p>
  The Where argument allows you to filter the rows based upon a statement.
  These operators and statements should be familiar to anyone with rudimentary
  knowledge of logic or programming.
  </p>

  <p>
  Because operators like the equal sign cannot be used in GET statements, we use 
  alternative operators which are listed below:
  </p>
  <table class="doc_table" style="display:inline-block">
  <thead>
  <th>Equality Operator</th><th>Explanation</th>
  </thead>
  <tr>
    <td>eq</td>
    <td>equal</td>
  </tr>
  <tr> 
    <td>lt</td>
    <td>less than</td>
  </tr>
  <tr>
    <td>gt</td>
    <td>greater than</td>
  </tr>
  <tr>
    <td>!</td>
    <td>not. this operator proceeds others, like !eq</td>
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
  </table>

  <p>We also support other statements that allow users to do string comparisons.
  <table class="doc_table" style="display:inline-block">
  <thead>
  <th>String Comparison</th><th>explanation</th><th>Usage</th>
  </thead>
  <tr>
    <td>like(string)</td>
    <td>wrapper for MySQL LIKE</td>
    <td>genus eq like('Chlamy')</td>
  </tr>
  </table>

  <h3>Examples</h3>

  <p>
  Select all columns from rows where the genus is Bacillus
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&where=genus eq 'Bacillus'
  </code>
  </p>

  <p>
  Select all columns from rows where the genus contains 'Actino'
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&where=genus eq like('Actino')
  </code>
  </p>

  <p>
  Select all taxonomy where the genus contains 'Actino'
  <code>
    http://pogo.ece.drexel.edu/query.php?type=taxonomy&where=genus eq like('Actino')
  </code>
  </p>

  <p>
  Select all taxonomy where the Genomic_Fluidity is over 90%
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=Genomic_Fluidity gt .90)
  </code>
  </p>

  <p>
  Select all taxonomy where the Genomic_Fluidity is over 90% or less than 20%
  <code>
    http://pogo.ece.drexel.edu/query.php?type=data&where=Genomic_Fluidity gt .90 OR Genomic_Fluidity lt .20)
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
    http://pogo.ece.drexel.edu/query.php?type=data&where=(Genomic_Fluidity gt .90) or (Genomic_Fluidity lt .20 AND and Average_Amino_Acid_Identity gt .90 )
  </code>
  </p>


  <a name="arrayA"></a>
  <h2>Array</h2>
  <p>The Array argument allows you to specify if you want either a JSON
  Associative Array, or a Indexed Array. For more information read this <a
  href="http://w3schools.com/php/php_arrays.asp">link</a>.</p>

  <p>
  This argument is optional, and the POGO database will return numerical arrays
  by default.
  </p>
  <table class="doc_table" style="display:inline-block";>
    <thead>
      <th>Option</th>
      <th>Explanation</th>
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
      http://pogo.ece.drexel.edu/query.php?type=data&array=ASSOC&
    </code>
  </p>

<a name="properties"></a>
<h1>Properties</h1>
<p>
This section details the columns available in our data and taxonomy tables. Each
column can be used in where statements, and in the select arguments.
</p>

<a name="taxonomy"></a>
<h2>Taxonomy Table</h2>

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
  <td>order</td>
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

<a name="data"></a>
<h2>Comparison Data</h2>
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
  <td>numuber_of_genes1, number_of_genes2</td>
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
  <td>See abougt page for more about Genomic Fluidity</td>
  <td>float</td>
  </tr>
  <tr>
  <td>16S_rRNA</td>
  <td>16S_rRNA identity</td>
  <td>float</td>
  </tr>
  <tr>
  <td>ArgS, CdsA, CoaE, etc.</td>
  <td>marker genes</td>
  <td>float</td>
  </tr>
  </tbody>
</table>

<a name="download"></a>
<h2>Blast files</h2>
  <p>
    In order to get a tarball of blast files from our database, you need to
    query our download url. This is done in the same method as the regular
    query.
  </p>

  <p>
  This example requests a tarball containing blast files from comparisons with
  the id's 2354, 19201, and 623719.
  </p>
  <code>
    http://pogo.ece.drexel.edu/download.php?ids=2354,19201,623719
  </code>
  

</div>
<php include 'footer.php'; ?>
</div>

</body>
</html>