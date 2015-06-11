$(document).ready(function(){
	Init();
});

var all = -1, curr = -1, ido = -1, statDiv, currDiv, szDiv, fut = false;

function Init() {
	$("#inaktiv_start").click(function() {
		if(fut) return;
		
		fut = true;
		Start();
	});
	
	statDiv = $("#inaktiv_statusz");
}

function Start() {
	ido = $("#inaktiv_ido").val();
	
	sendAjax({
		data: {
			all: all,
			curr: curr,
			ido: ido
		},
		page: "scripter_inaktiv",
		func: function(msg) {Response(msg);}
	});
}

function Response(msg) {
	if(!isExists(msg.stat, msg.curr, msg.all)) return;

	var stat = msg.stat;
	
	curr = msg.curr;
	
	if(stat == 0) {
		all = msg.all;
		
		statDiv.html(all + " / <span id='inaktiv_curr'>" + curr + "</span> (<span id='inaktiv_sz'>" + Math.round((curr / all ) * 100) + "</span>%)");
		
		currDiv = $("#inaktiv_curr");
		szDiv = $("#inaktiv_sz");
	} else if(stat == 1) {
		currDiv.html(curr);
		szDiv.html( Math.round((curr / all) * 100) );
	} else if(stat == 2) {
		statDiv.html("Befejezve! <a href='admin_inaktiv" + Ext + "'>Megtekintés</a>");
		
		fut = false;
	}
	
	if(stat != 2)
		setTimeout(function(){Start();}, 500);
}