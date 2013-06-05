$(document).ready(function(){

    settings = { "bPaginate":true,
                 "bScrollCollapse": true,
                 "bFilter":false,
                 "oLanguage": {
                   "sEmptyTable": "No Genomes Selected"
                 }
               }
    boxa = $('#BoxA').dataTable(settings);
    boxb = $('#BoxB').dataTable(settings);

    $("#BoxB tbody tr").click( function( e ) {
      if ( $(this).hasClass('row_selected') ) {
        $(this).removeClass('row_selected');
      }
      else {
        boxb.$('tr.row_selected').removeClass('row_selected');
        $(this).addClass('row_selected');
      }
    });


});

function getSelected(table) {
    return table.$('tr.row_selected');
}

function add(type, box){
  var Selected=document.getElementById(type);

  var Species=document.getElementById("Species");
  var Genus=document.getElementById("Genus");
  var Genome=document.getElementById("Genome");

  var selected_val = Selected.options[Selected.selectedIndex].value;
  var AddToId= "Box" + box;

  if(type === 'Genome') {
    if(selected_val === "All") {
      selected_val = Species.options[Species.selectedIndex].value;
      type = "Species";
    } 
    else {
      for (element in taxonomy) { 
        if(taxonomy[element][type] === selected_val) {
          if(!checkDuplicateTable(document.getElementById("BoxA"), taxonomy[element]['Genome']) &&
              !checkDuplicateTable(document.getElementById("BoxB"), taxonomy[element]['Genome'])) {
            addValueToSelectTable(AddToId, taxonomy[element]);
          }
        } 
      }
    }
  }
  if(type === 'Species') { 
    if(selected_val === "All") {
      selected_val = Genus.options[Genus.selectedIndex].value;
      type = "Genus";
    } 
    else {
      for (element in taxonomy) { 
        if(taxonomy[element][type] === selected_val) {
          if(!checkDuplicateTable(document.getElementById("BoxA"), taxonomy[element]['Genome']) &&
              !checkDuplicateTable(document.getElementById("BoxB"), taxonomy[element]['Genome'])) {
            addValueToSelectTable(AddToId, taxonomy[element]);
          }
        } 
      }
    } 
  }
  if(type === 'Genus') { 
    if(selected_val === "All") {
      for (element in taxonomy) { 
        if(!checkDuplicateTable(document.getElementById("BoxA"), taxonomy[element]['Genome']) &&
            !checkDuplicateTable(document.getElementById("BoxB"), taxonomy[element]['Genome'])) {
          addValueToSelectTable(AddToId, taxonomy[element]);
        }
      }
    }
    else {
      for (element in taxonomy) { 
        if(taxonomy[element][type] === selected_val) {
          if(!checkDuplicateTable(document.getElementById("BoxA"), taxonomy[element]['Genome']) &&
              !checkDuplicateTable(document.getElementById("BoxB"), taxonomy[element]['Genome'])) {
            addValueToSelectTable(AddToId, taxonomy[element]);
          }
        } 
      }
    } 
  }
}


function clearTable(box) {
  var i = 0;
  table = $(box).dataTable(); 
  num_rows = table.fnSettings().fnRecordsTotal();
  console.log("num_rows");

  for(i = 0; i < num_rows; i++) {
    table.fnDeleteRow(0);
  }

}


function addValueToSelectTable(select, item) {
  select = "#" + select;
  index = $(select).dataTable().fnAddData( [item['Genus'], item['Species'], item['Genome']] );
  input = $(select).dataTable().fnGetNodes()[index];
  $(input).click( function( e ) {
      if ( $(this).hasClass('row_selected') ) {
        $(this).removeClass('row_selected');
      }
      else {
        boxb.$('tr.row_selected').removeClass('row_selected');
        $(this).addClass('row_selected');
      }
    })
}


function checkDuplicateTable(select, string) { 

  var i;
  table = $(select).dataTable();
  num_rows = table.fnSettings().fnRecordsTotal();
  for(i = 0; i < num_rows; i++) {
    if(table.fnGetData(i)[2] === string) { 
      return true;
    }
  }

  return false;
}

function addValueToSelectBox(select, string) {

  var option = document.createElement("option");
  option.text = string;
  select.add(option, null);
}


// return true if it already exists, false if it does not.
function checkDuplicate(select, string) { 
  var i;

  for(i = 0; i < select.length; i++) {
    if(select[i].text === string) { 
      return true;
    }
  }

  return false;
}


function submit() {

  atable = $('#BoxA').dataTable();
  btable = $('#BoxB').dataTable();
  a_num_rows = atable.fnSettings().fnRecordsTotal();
  b_num_rows = btable.fnSettings().fnRecordsTotal();
  
  a_string =  
}
function populate() { 

  var Genomes = document.getElementById('Genome');
  var Genus = document.getElementById('Genus');
  var Species = document.getElementById('Species');

  addValueToSelectBox(Species, "All");
  addValueToSelectBox(Genus, "All");
  addValueToSelectBox(Genomes, "All");

  for(i in species) 
    addValueToSelectBox(Species, species[i]);

  for(i in genus) 
    addValueToSelectBox(Genus, genus[i]);

  for(i in genome) 
    addValueToSelectBox(Genomes, genome[i]);

  Genomes.selectedIndex = 0;
  Genus.selectedIndex = 0;
  Species.selectedIndex = 0;
}


function rm(box) {
  var i = 0;

  table = $(box).dataTable();
  var anSelected = getSelected( table );

  if ( anSelected.length !== 0 ) {
    for(i = 0; i < anSelected.length; i++) {
      table.fnDeleteRow(anSelected[i]);
    }
  }
}


function selected(type) {
  var Selected=document.getElementById(type);

  if(Selected.selectedIndex == -1) 
    return;

  var Genomes=document.getElementById('Genome');
  var Genus=document.getElementById('Genus');
  var Species = document.getElementById('Species');

  if(type === 'Genus') { 
    var selected_val = Selected.options[Selected.selectedIndex].text;

    Species.options.length = 0;

    addValueToSelectBox(Species, "All");
    Species.selectedIndex = 0;

    if(selected_val === "All" ) {
      for(element in species) {
        addValueToSelectBox(Species, species[element]);
      } 
    }
    else { 
      for (element in taxonomy) { 
        if(taxonomy[element]['Genus'] === selected_val) {
          if(!checkDuplicate(Species, taxonomy[element]['Species'])) {
            addValueToSelectBox(Species, taxonomy[element]['Species']);
          }
        } 
      }
    }
    type = 'Species';
  }

  if(Species.selectedIndex != -1)
    species_val = Species.options[Species.selectedIndex].text;
  if(Genus.selectedIndex != -1)
    genus_val = Genus.options[Genus.selectedIndex].text;

  Genomes.options.length = 0;
  addValueToSelectBox(Genomes, "All");

  if(species_val === "All") { 
    if(genus_val === "All") { 
      for (element in taxonomy) { 
        addValueToSelectBox(Genomes, taxonomy[element]['Genome']);
      }
    }
    else {
      for (element in taxonomy) { 
        if(taxonomy[element]['Genus'] === genus_val) {
          addValueToSelectBox(Genomes, taxonomy[element]['Genome']);
        } 
      }
    }
  }
  else {
    for (element in taxonomy) { 
      if(taxonomy[element]['Species'] === species_val) {
        addValueToSelectBox(Genomes, taxonomy[element]['Genome']);
      } 
    }
  }
}
