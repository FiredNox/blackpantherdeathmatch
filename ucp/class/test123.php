<?

require_once("include/main.php");
Fejlec();
if(!$jatekos["Belepve"] || !CheckAdmin())
if($jatekos["Admin"] >= 1337 || IsScripter())
	{
    $today = date("Y-m-d H:i:s");
	$y = 
	echo "<br><br>";
	echo "<center><font size='3' color='white'>A premium idő hosszát ide ird:</font></center>";
	}
?>
<html>
<head>
</head>
<body>

<form name="calculator" method="post" action="">
	<script language="JavaScript">
	var o_cal = new tcal ({
		'formname': 'calculator',
		'controlname': 'start'
	});
	
	// individual template parameters can be modified via the calendar variable
	o_cal.a_tpl.yearscroll = true;
	o_cal.a_tpl.weekstart = 1;
	
	</script>
		<td align="center"><font face="arial,helvetica,sans-serif"><b>Befejező dátum (év 
		/ hónap / nap):</b><br />
		<input type="text" name="end" size="10" style="font-weight: bold; font-size:14pt">

		
<script language="JavaScript">
	var o_cal0 = new tcal ({
		'formname': 'calculator',
		'controlname': 'end'
	});
	
	// individual template parameters can be modified via the calendar variable
	o_cal0.a_tpl.yearscroll = true;
	o_cal0.a_tpl.weekstart = 1;
	
</script>

<input type="button" value="Mai nap" onClick="endToday(this.form)" name="endtoday"> </font></td>
</tr>
</table>&nbsp;<p><font face="arial,helvetica,sans-serif">
		<input type="button" value="A két időpont között eltelt idő" onClick="diffDate(this.form)"
		name="difference">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="reset" value="Töröl" name="clear" style="background-color: #FF9999"></font></p>
<p>&nbsp;</p>
<p><font face="arial,helvetica,sans-serif">
		<input type="button" value="Dátumérték hozzáadása / kivonása a kezdő dátumhoz" onClick="addDate(this.form)" name="add"></font></p>
<p>&nbsp;</p>
<p><br />
</p>
<table width="67%" border="0" id="table2">
	<tr>
		<td width="5%" align="right" bgcolor="#FFFF00">
		<p align="center">
		<input type="text" name="years" size="4" style="text-align: center; background-color:#FFFF00; font-size:14pt; font-weight:bold"> 
		</td>
		<td width="8%" align="center" bgcolor="#FFFF00">
		<p align="left">&nbsp;<b><font face="arial,helvetica,sans-serif">év</font></b></td>
		<td width="11%" align="center" bgcolor="#FF9933">
		<input type="text" name="months" size="8" style="text-align: center; background-color:#FF9933; font-size:14pt; font-weight:bold"></td>
		<td width="11%" align="center" bgcolor="#FF9933">
		<p align="left"><b>
		<font face="arial,helvetica,sans-serif">hónap</font></b></td>
		<td width="10%" align="center" bgcolor="#FF9999">
		<input type="text" name="weeks" size="8" style="text-align: center; background-color:#FF9999; font-size:14pt; font-weight:bold"></td>
		<td width="6%" align="center" bgcolor="#FF9999">
		<p align="left"><b>
		<font face="arial,helvetica,sans-serif">hét</font></b></td>
		<td width="17%" align="center" bgcolor="#FFCCFF">
		<input type="text" name="days" size="8" style="text-align: center; background-color:#FFCCFF; font-size:14pt; font-weight:bold"></td>
		<td width="10%" align="center" bgcolor="#FFCCFF">
		<p align="left"><b>
		<font face="arial,helvetica,sans-serif">nap</font></b></td>
	</tr>
	</table>
<p><b><font size="3">Év / hónap / nap formátumban kifejezve:</font></b></p>
<table width="22%" border="0" id="table3">
	<tr>
		<td width="33%" align="right" bgcolor="#CCFFCC"><font face="arial,helvetica,sans-serif">Év:</font> 
		</td>
		<td width="42%" align="left" bgcolor="#CCFFCC">
		<p align="center">
		<input type="text" name="years1" size="6" style="font-size: 14pt; font-weight: bold; text-align: center"> </td>
	</tr>
	<tr>
		<td align="right" bgcolor="#CCFFCC"><font face="arial,helvetica,sans-serif">Hónap:</font> 
		</td>
		<td align="left" bgcolor="#CCFFCC">
		<p align="center">
		<input type="text" name="months1" size="6" style="font-size: 14pt; font-weight: bold; text-align: center"> </td>
	</tr>
	<tr>
		<td align="right" height="27" bgcolor="#CCFFCC"><font face="arial,helvetica,sans-serif">Nap:</font> 
		</td>
		<td align="left" height="27" bgcolor="#CCFFCC">
		<p align="center">
		<input type="text" name="days1" size="6" style="font-size: 14pt; font-weight: bold; text-align: center"> </td>
	</tr>
</table>
</form>
<p align="center">
<script language="javascript">
<!--
function startToday(form)
{
        var now = new Date();

        year = now.getYear();
        if (year<1000)
                year += 1900;
        month = now.getMonth()+1;
        day = now.getDate();

        form.start.value = year+"/"+month+"/"+day;
}

function endToday(form)
{
    var now = new Date();

        year = now.getYear();
        if (year<1000)
                year += 1900;
        month = now.getMonth()+1;
        day = now.getDate();

        form.end.value = year+"/"+month+"/"+day;
}

function checkNumber(str)
{
        // check we only have digits and minus characters
        for (var i=0;i<str.length;i++) {
                var c = str.substring(i, i+1)
                if ((c<"0" || c>"9") && c!="-") {
                        return false;
                }
        }

        if (str.length==0)
                return false;

        return true;
}

function checkDate(str)
{
        months = new Array(31,29,31,30,31,30,31,31,30,31,30,31);

        // check we only have digits and backslash characters
        for (var i=0;i<str.length;i++) {
                var c = str.substring(i, i+1)
                if ((c<"0" || c>"9") && c!="/") {
                        alert("A "+str+" dátum érvénytelen!");
                        return false;
                }
        }

        // make sure we only have three components
        temp = str.split("/");
        if (temp.length!=3) {
                alert("A "+str+" dátum érvénytelen!");
                return false;
        }

        var y = parseInt(temp[0]);
        var m = parseInt(temp[1]);
        var d = parseInt(temp[2]);

        // check the day and month values are valid
        if ((m<1) || (d<1) || (m>12) || (d>months[m-1])) {
                alert("A "+str+" dátum érvénytelen!");
                return false;
        }

        if ((y%4!=0) || ((y%100==0) && (y%400!=0))) {
                if ((m==2) && (d>28)) {
                        alert("A "+str+" dátum érvénytelen!");
                        return false;
                }
        }

        // check date is in range of modified Julian day number

        if ((y<1858) || (y>2132)) {
                alert("A "+str+" dátum kívül esik a megengedetten! ")
                return false;
        }

        if ((y==1858) && ((m<11) || ((m==11) && (d<16)))) {
                alert("A "+str+" dátum kívül esik a megengedetten!")
                return false;
        }

        if ((y==2132) && ((m>8) || ((m==8) && (d>29)))) {
                alert("A "+str+" dátum kívül esik a megengedetten!")
                return false;
        }

        return true;
}

function selectPeriod(form)
{
        form.years.value = "";
        form.months.value = "";
        form.weeks.value = "";
        form.days.value = "";

        switch (form.select.selectedIndex) {
                case 1:
                        form.weeks.value = "6";
                        form.days.value = "1";
                        break;
                default:
                        break;
        }
}


// calculate the modified Julian day number from Gregorian date
function julianDay(year,month,day)
{
        var extra = 100.0*year+month-190002.5;
        var julian = 367.0*year;
        julian -= Math.floor(7.0*(year+Math.floor((month+9.0)/12.0))/4.0);
        julian += Math.floor(275.0*month/9.0);
        julian += day;
        julian -= 678985.5;
        julian -= 0.5*extra/Math.abs(extra);

        return julian;
}

// convert the modified Julian day number to Gregorian date
function calanderDay(julian)
{
        var jd0 = julian+2400000.5;
        var z = Math.floor(jd0);
        var f = jd0-z;
        var a = 0.0;
        var alp = 0.0;
        if (z<2299161) {
                a = z;
        } else {
                alp = Math.floor((z-1867216.25)/36524.25);
                a = z+1.0+alp-Math.floor(alp/4.0);
        }

        var b = a+1524;
        var c = Math.floor((b-122.1)/365.25);
        var d = Math.floor(365.25*c);
        var e = Math.floor((b-d)/30.6001);

        var day = Math.floor(b-d-Math.floor(30.6001*e)+f);

        var month = 0;
        if (e<13.5) {
                month = e-1;
        } else {
                month = e-13;
        }

        var year = 0;
        if (month>2.5) {
                year = c-4716;
        } else {
                year = c-4715;
        }

        temp = new Array(3);
        temp[0] = day;
        temp[1] = month;
        temp[2] = year;

        return temp;
}





function addDate(form)
{
        str = form.start.value;
        if (checkDate(str)==false)
                return;
        temp = str.split("/");
        var sy = parseInt(temp[0]);
        var sm = parseInt(temp[1]);
        var sd = parseInt(temp[2]);

        ey = sy;
        em = sm;
        ed = sd;

        // need to check years,months,weeks and days are numbers

        if (checkNumber(form.years.value)==true) {
                var ay = parseInt(form.years.value);
        } else {
                var ay = 0;
        }
        if (checkNumber(form.months.value)==true) {
                var am = parseInt(form.months.value);
        } else {
                var am = 0;
        }
        if (checkNumber(form.weeks.value)==true) {
                var aw = parseInt(form.weeks.value);
        } else {
                var aw = 0;
        }
        if (checkNumber(form.days.value)==true) {
                var ad = parseInt(form.days.value);
        } else {
                var ad = 0;
        }

        ey += ay;

        // add the months
        if (am>12) {
                em += am%12;
                ey += Math.floor(am/12);
        } else {
                em += am;
        }
        if (em>12) {
                ey++;
                em -= 12;
        }

        // use julian day numbers to add weeks and days
        ej = julianDay(ey,em,ed);
        ej += (aw*7)+ad;

        end = calanderDay(ej);

        form.end.value = end[2]+"/"+end[1]+"/"+end[0];
}


function diffDate(form)
{
        str = form.start.value;
        if (checkDate(str)==false)
                return;
        temp = str.split("/");
        var sy = parseInt(temp[0]);
        var sm = parseInt(temp[1]);
        var sd = parseInt(temp[2]);

        str = form.end.value;
        if (checkDate(str)==false)
                return;
        temp = str.split("/");
        var ey = parseInt(temp[0]);
        var em = parseInt(temp[1]);
        var ed = parseInt(temp[2]);
		
		dend = str.split("/");
        var dy = parseInt(dend[0]);
        var dm = parseInt(dend[1]);
        var dd = parseInt(dend[2]);


        sj = julianDay(sy,sm,sd);
        ej = julianDay(ey,em,ed);
		dj = julianDay(dy,dm,dd);

        if (ej<sj) {
                alert("A befejező dátum későbbi legyen a kezdő dátumnál!");
                return;
        }

        
        form.days.value = ej-sj;
        form.weeks.value = Math.floor((ej-sj)/7);

        md = ((ey*12)+em)-((sy*12)+sm);
        if (ed<sd)
                md--;
        form.months.value = md;

        yd = ey-sy;
        if ((em<sm) || ((em=sm) && (ed<sd)))
                yd--;
        form.years.value = yd;

        form.years1.value = yd
        form.months1.value = md-yd*12
		str = form.start.value;
        if (checkDate(str)==false)
                return;
        temp = str.split("/");
        var sy = parseInt(temp[0]);
        var sm = parseInt(temp[1]);
        var sd = parseInt(temp[2]);

        ey = sy;
        em = sm;
        ed = sd;

        // need to check years,months,weeks and days are numbers

        if (checkNumber(form.years1.value)==true) {
                var ay = parseInt(form.years1.value);
        } else {
                var ay = 0;
        }
        if (checkNumber(form.months1.value)==true) {
                var am = parseInt(form.months1.value);
        } else {
                var am = 0;
        }



        ey += ay;

        // add the months
        if (am>12) {
                em += am%12;
                ey += Math.floor(am/12);
        } else {
                em += am;
        }
        if (em>12) {
                ey++;
                em -= 12;
        }

        // use julian day numbers to add weeks and days
        dj = julianDay(ey,em,ed);
 

        end = calanderDay(dj);

        form.end.value = dend[0]+"/"+dend[1]+"/"+dend[2];
        form.days1.value = ej-dj

}
-->
</script>

		
		
		
</body>
</html>


<? Lablec(); ?>