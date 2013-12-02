var ids = new Array();

function handle_checks(id) {
  index = ids.indexOf(id);

  if (index != -1) {
    ids.splice(index, 1);
    document.getElementById('list_item' + id).removeAttribute('style');
  }
  else {
    ids.push(id);
    document.getElementById('list_item' + id).style.background = '#FFF';
  }

  if (ids.length == 0) {
    document.getElementById('tools').style.visibility = 'hidden';

    document.getElementById('new_pile').removeAttribute('class');
    document.getElementById('new_pile').setAttribute('class', 'new_pile');
  }
  else
    document.getElementById('tools').style.visibility = 'visible';
}

function handle_trash() {
  var ids_sf = ids.join('t');

  document.location = '/home/trash/' + ids_sf;
}

function handle_action() {
  var ids_sf = ids.join('t');
  var dyn_act = '/home/pileup/' + ids_sf;

  document.pile_form.action = dyn_act;
}


function showTagInput() {
  document.getElementById('new_pile').removeAttribute('class');
  document.getElementById('new_pile').setAttribute('class', 'tag');
  document.getElementById('tag_input').focus();
}