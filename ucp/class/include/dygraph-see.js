var nap = Array("Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat", "Vasárnap");
var honap = Array("Jan", "Feb", "Már", "Ápr", "Máj", "Jún", "Júl", "Aug", "Szep", "Okt", "Nov", "Dec");
var rmax; var qmax; var melyik = "o"; var g;
var UID;

function yFormat(v)
{
	var szoveg = " ";
	if(melyik == "o")
	{
		if(v < 60) szoveg += v + "mp";
		else if(v < 3600)
		{
			var mp = v % 60; var perc = Math.floor( v / 60 );

			szoveg += perc + "p";
			if(mp) szoveg += " és " + mp + "mp";
		}
		else
		{
			var mp = v % 60; var perc = Math.floor( (v % 3600) / 60); var ora = Math.floor( v / 3600 );
			szoveg += ora + "ó";
			if(perc)
			{
				if(mp) szoveg += ", " + perc + " és " + mp + "mp";
				else szoveg += " és " + perc + "p";
			}
			else if(mp)
				szoveg += " és " + mp + "mp";
		}
	}
	else if(melyik == "a")
		szoveg += v + "db";

	return szoveg;
}
function xFormat(v)
{
	var d = new Date(v);
	var e = d.getFullYear();
	var h = d.getMonth() + 1;
	var n = d.getDate();

	if(h < 10) h = "0" + h;
	if(n < 10) n = "0" + n;
	
	szoveg = e +"-"+ h +"-"+ n;

	return szoveg;
}
function yAxisFormat(x)
{
	return x + "mp";
}
function xAxisFormat(x)
{
	var d = new Date(x);
	return honap[ d.getMonth() ] + ". " + d.getDate();
}
function FelKerekit(mit, mennyivel)
{
	//return ((mit % mennyivel) > 0 ? (mit - (mit % mennyivel) + mennyivel) : mit);
	return (mit - (mit % mennyivel) + mennyivel);
}

function Valt(mire)
{
	melyik = mire;
	rmax = 0;

	if(melyik == "o")
		g.updateOptions({file: "data/activity/"+UID+mire+"m.csv", labels: ["Dátum", "Online idő", "Adminszolgálat"]});
	else if(melyik == "a")
		g.updateOptions({file: "data/activity/"+UID+mire+"m.csv", labels: ["Dátum", "Report", "PM"]});
}

function GetMax()
{
	var max = 0;
	
	for(x = 0; x < 31; x++)
	{
		t = g.getValue(x, 1); if(t > max) max = t;
		t = g.getValue(x, 2); if(t > max) max = t;
	}

	return max;
}

function Tikker(min, max, pixels, opts, dygraph, vals)
{
	//if(!min && !max) return 1;

	if(!rmax && min < 99999)
	{
		if(melyik == "o") rmax = FelKerekit(Math.round(GetMax()), 3600);
		else if(melyik == "a") rmax = FelKerekit(Math.round(GetMax()), 100);
		g.updateOptions({ valueRange: [0, rmax] });
		return 1;
	}
	if(min > 99999 && rmax && !qmax) { qmax = 1; return 1; }

	var t = [];
	
	if(max < 99999)
	{
		if(melyik == "o")
		{
			var db = 10;
			for(x = 1; x <= db; x++)
			{
				i = (rmax / db * x);

				var p, o, n;

				if(i < 3600) s = Math.round(i / 60) + "p";
				else if(i < 86400)
				{
					o = Math.floor(i / 3600);
					p = Math.floor(i % 3600 / 60);
					s = o + "ó";
					if(p) s += " " + p + "p";
				}
				else s = Math.round(i / 86400) + "n";

				t.push({label: s, v: i});
			}
		}
		else if(melyik == "a")
		{
			var db = 10;
			for(x = 1; x <= db; x++)
			{
				i = (rmax / db * x);

				s = i + "db";

				t.push({label: s, v: i});
			}
		}
	}
	else
	{
		var db = 31;
		for(x = 0; x < db; x++)
		{
			if(x % 3 != 0) continue;

			i = min + (86400 * x * 1000);

			d = new Date(i);
			s = honap[ d.getMonth() ] + " " + d.getDate();

			t.push({label: s, v: i});
		}
	}

	return t;
}

function seeDygraphChange(uid)
{
	UID = uid;
	Valt("o");
}

function seeDygraphInit(uid)
{
	UID = uid;
	rmax = 0;
	g = new Dygraph(
	document.getElementById("grafikon"),
	"data/activity/"+uid+"om.csv",
	{
		labels: ["Dátum", "Online idő", "Adminszolgálat"],
		xlabel: "Dátum",
		ylabel: "Aktivitás",
		drawXGrid: true,
		drawYGrid: true,
		labelsSeparateLines: true,
		axisLineColor: "white",
		axisLabelColor: "white",
		colors: ["#33CC33", "#33CCCC"],
		labelsDivStyles: {
			'fontWeight': 'bold',
			'backgroundColor': 'transparent'
		},
		strokeWidth: 2.0,
		fillGraph: true,
		ticker: Tikker,
		width: 680,
		//axisTickSize: 0,
		yAxisLabelWidth: 50, // a bal jeloszlop szélessége
		axisLabelFontSize: 11,

		xValueFormatter: xFormat,
		xAxisLabelFormatter: xAxisFormat,
		yValueFormatter: yFormat,
		yAxisLabelFormatter: yAxisFormat,
		legend: 'always',
	}
	);
}