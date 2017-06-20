var obj="";
var As=document.getElementById('nav').getElementsByTagName('a');

for(i=0;i<As.length;i++){
	if(window.location.href.indexOf(As[i].href)>=0){
		obj=As[i];
		obj.id='nav_current';
	}
}


