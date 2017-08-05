
function checkall(checkbox) {
  var n;
  checkboxes = document.getElementsByClassName('checkdel');
if(checkboxes.length > 33){
  	n = 33;
  }else{
  	n = checkboxes.length;
  }
  for(var i=0;i<n;i++) {
    checkboxes[i].checked = checkbox.checked;
  }
}



function singlecheck($id){
	document.getElementById("box["+$id+"]").checked = true;
}


function clicked($url){
	newwindow=window.open($url,'name','height=500,width=700');
		if (window.focus) {newwindow.focus()}
	return false;
}
