function sort(cat,dir,usid){
	if(window.XMLHttpRequest){
		ao=new XMLHttpRequest();
	}
	else{
		ao=new ActiveXObject('Microsoft.XMLHTTP');
	}
	ao.onreadystatechange=function(){
		if(ao.readyState==4 && ao.status==200){
			document.getElementById('mailtable').innerHTML=ao.responseText;
		}
	}
	var dir_sort=  (dir=="f") ? "ASC":"DESC";
	ao.open('GET',"ajax.php?sort="+cat+"&dir="+dir_sort+"&usid="+usid, true);
	ao.send(null);
	return false;
}

function show_mes(mesid){
	if(window.XMLHttpRequest){
		a=new XMLHttpRequest();
	}
	else{
		a=new ActiveXObject('Microsoft.XMLHTTP');
	}
	a.onreadystatechange=function(){
		if(a.readyState==4 && a.status==200){
			document.getElementById('view_mess').innerHTML=a.responseText;
		}
	}
	a.open('GET',"ajax.php?show="+mesid, true);
	a.send(null);
	return false;
}