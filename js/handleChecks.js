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

function getPositions(ev, id) {
if (ev == null) { ev = window.event }
   var _mouseX = ev.clientX;
   var _mouseY = ev.clientY;

  var elem1 = document.getElementById('pile_list' + id);
  var elem2 = document.getElementById('list_item' + id);

  if (!elem1.style.display) {
    elem1.style.top = _mouseY + 'px';
    elem1.style.left = _mouseX + 'px';
    elem1.style.display = 'block';

    elem2.setAttribute('class', 'list_item active');
  }
  else {
    elem1.removeAttribute('style');

    elem2.setAttribute('class', 'list_item');
    elem2.removeAttribute('style');
  }

 var el = document.getElementsByTagName('body')[0];
  if (el.addEventListener) {
          el.addEventListener("click", hide, false);
      } else {
          el.attachEvent('onclick', hide);
      }  
}

function hide() {
  var elem1 = document.getElementsByClassName('pile_list');
  var elem2 = document.getElementsByClassName('list_item active');

  elem1 = [].slice.call(elem1, 0);
  for (var i = 0; i < elem1.length; ++i)
    elem1[i].removeAttribute('style');

  elem2 = [].slice.call(elem2, 0);
  for (var i = 0; i < elem2.length; ++i)
  elem2[i].setAttribute('class', 'list_item');
}