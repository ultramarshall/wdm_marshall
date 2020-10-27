//menampilkan conten secara bergiliran setiap n interval
$(document).ready(function(){
	var n=1;	
	timer=setInterval(function() {blinker();}, 5000)
	function blinker(){
		n++;
		prev=n-1;
		$("#cc"+prev).fadeOut(function(){$("#cc"+n).css('display','block')});
			if (n>42){
			n=1;	
			}
	}
});
