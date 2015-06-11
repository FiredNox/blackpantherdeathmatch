var rejtek = {
	map: {},
	reorder: {}
};

$(function(){
	rejtek.prepare();
	$("#rejtek_new").click(function(){ rejtek.map.open(); });
	$("#rejtek_save").click(function(){ rejtek.save(); });
	
	(rejtek.dialog = $("#rejtek_dialog")).dialog({
		width: $(window).width()*0.95,
		height: $(window).height()*0.95,
		modal: false,
		position: "center",
		draggable: false,
		resizable: false,
		autoOpen: false,
		buttons: [
		  {
			  text: "Kész",
			  click: function() { rejtek.map.add(); }
		  },
		  {
			  text: "Mégse",
			  click: function() { rejtek.map.cancel(); }
		  }
		]
	});
	
	rejtek.map.select = $("img", rejtek.dialog).imgAreaSelect({
		instance: true,
		parent: rejtek.dialog,
		fadeSpeed: 500
	});
});

rejtek.map.open = function()
{
	rejtek.dialog.dialog("open");
};

rejtek.save = function()
{
	var r = arguments.length == 1 ? arguments[0] : false;
	
	if(!r)
	{
		var areas = [], inputs, area, id;
		
		id = 0;
		
		rejtek.reorder.name();
		
		while((d = $("#rejtek_" + ++id)).length == 1)
		{
			inputs = $("input[type=text]", d);
			
			if(inputs.length != 4)
				continue;
			
			area = [];
			inputs.each(function(){
				area.push( $(this).val() );
			});
			
			if(!isFinite(area[0]) || !isFinite(area[1]) || !isFinite(area[2]) || !isFinite(area[3]))
				continue;
			
			areas.push({
				MinX: area[0],
				MinY: area[1],
				MaxX: area[2],
				MaxY: area[3]
			});
		}
		
		sendAjax({
			page: "admin_rejtekhely",
			data: {
				areas: areas
			},
			func: function(msg) { rejtek.save(msg); },
			efunc: function(xhr, textstatus, errorthrown) { $("#ajax").html(xhr.responseText); }
		});
		
		$("#terkep").css("display", "none");
		$("#ajax").html("folyamatban...");
	}
	else
	{
		$("#terkep").css("display", "block");
		$("#terkep").attr("src", "img/terkep_rejtekhelyek.jpg?" + (new Date()).getTime());
		$("#ajax").html(r.msg);
	}
};

rejtek.map.add = function()
{
	var selection = rejtek.map.select.getSelection();
	if(selection.width == 1 || selection.width < 1)
		return alert("Nincs kijelölve semmi");
	
	var id = 1;
	while($("#rejtek_" + id).length == 1)
		id++;
	
	var minx = selection.x1 - 3000;
	var maxx = selection.x2 - 3000;
	var miny = 3000 - selection.y2;
	var maxy = 3000 - selection.y1;

	//$("#rejtek_" + (id-1)).after(
	$("#rejtek_helyek").append(
		"<div id='rejtek_" + id + "'>" +
			"<b>" + rejtek.pad(rejtek.newid++) + "</b> -" +
			" MinX: <input type='text' size='10' value='" + minx + "'/>" +
			" MinY: <input type='text' size='10' value='" + miny + "'/>" +
			" MaxX: <input type='text' size='10' value='" + maxx + "'/>" +
			" MaxY: <input type='text' size='10' value='" + maxy + "'/>" +
			" <a href='javascript: void(0)'>Törlés</a>" +
		"</div>"
	);
	
	rejtek.map.cancel();
	rejtek.prepare();
};

rejtek.map.cancel = function()
{
	rejtek.map.select.cancelSelection();
	rejtek.dialog.dialog("close");
};

rejtek.prepare = function()
{
	var id = 1;
	var d, l = 0;
	
	while((d = $("#rejtek_" + id)).length == 1)
	{
		d.find("a").unbind('click').click(function(){
			var e = $(this).parent();
			
			rejtek.reorder.id( e.attr("id").split("_")[1] );
			
			e.remove();
		});
		
		l = d;
		
		id++;
	}
	
	rejtek.newid = $("b", l).html()*1 + 1;
};

rejtek.reorder.id = function(from)
{
	var d;
	while((d = $("#rejtek_" + ++from)).length == 1)
	{
		d.attr("id", "rejtek_" + (from-1));
	}
};

rejtek.reorder.name = function()
{
	var id = 0, d;
	while((d = $("#rejtek_" + ++id)).length == 1)
	{
		$("b", d).first().html( rejtek.pad(id) );
	}
	
	rejtek.newid = id;
};

rejtek.pad = function(n)
{
	return ('  ' + n).slice(-2).replace(' ', '&nbsp;');
};