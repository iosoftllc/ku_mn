//document.write("<style>");
//document.write("td {font-size:12px; font-family:����; text-decoration:none; }");
//document.write("A:link,A:active,A:visited{text-decoration:none;font-size:12PX;color:#333333;}");
//document.write("A:hover {text-decoration:none; color:ff9900}");
//document.write("font { font-size: 9pt; }");
//document.write(".cnj_close {color:#FAF261; background-color:#0000AA; border-width:1; border-color:#00CCFF; border-style:solid;cursor:hand;font-weight:bold;height:13pt;text-align:center;}");
//document.write(".cnj_close2 {color:#00CCFF; background-color:#0000AA; border-width:1; border-color:#00CCFF; border-style:solid;cursor:hand;font-weight:bold;height:13pt;text-align:center;}");
//document.write(".cnj_input {background-color:rgb(240,240,240);border-width:1pt; height:16pt;cursor:hand;}");
//document.write(".cnj_input2 {color:#5184CD; background-color:#0000AA; border-width:1; border-color:#5184CD; border-style:solid;cursor:hand}");
//document.write(".cnj_input3 {color:#00CCFF; background-color:#0000AA; border-width:1; border-color:#00CCFF; border-style:solid;cursor:hand;height:15pt;}");
//document.write(".cnj_input4 {color:#FAF261; background-color:#0000AA; border-width:1; border-color:#00CCFF; border-style:solid;cursor:hand;height:15pt;}");
//document.write(".cnj_td {border-width:1;border-style:solid;border-color:#a0a0a0;}");
//document.write("</style>");
var fixedX = -1; 				// ���̾� X�� ��ġ (-1 : ��ư�� �ٷ� �Ʒ��� ǥ��)
var fixedY = -1; 				// ���̾� Y�� ��ġ (-1 : ��ư�� �ٷ� �Ʒ��� ǥ��)
var startAt = 0; 				// �Ͽ��� ǥ�� �κ� (0 : �Ͽ�ȭ..., 1 : ������...������)
var showWeekNumber = 0;	// ��(week)���� ���� (0 : ����, 1 : ����)
var showToday = 1; 			// ���� ���� ǥ�� ���� (0 : ����, 1 : ����)
var imgDir = "./"; 			// �̹��� ���丮 (./ : ���� ���丮)
var language = 1;				// ���� (0 : �ѱ�, 1 : ����)
var crossobj, crossMonthObj, crossYearObj, monthSelected, yearSelected, dateSelected, omonthSelected, oyearSelected, odateSelected, monthConstructed, yearConstructed, intervalID1, intervalID2, timeoutID1, timeoutID2, ctlToPlaceValue, ctlNow, dateFormat, nStartingYear;
var bPageLoaded = false;
var ie = document.all;
var dom = document.getElementById;
var bShow = false;
var ns4 = document.layers;
var today = new	Date();						// ���� ���� ����
var dateNow = today.getDate();		// ���� ��ǻ���� ��(day)�� ����  
var monthNow = today.getMonth();	// ���� ��ǻ���� ��(month)�� ����
var yearNow = today.getYear();		// ���� ��ǻ���� ��(year)�� ����
var imgsrc = new Array("drop1.gif","drop2.gif","left1.gif","left2.gif","right1.gif","right2.gif");
var img	= new Array();

if (yearNow < 1900) yearNow += 1900;

if (language == 1) {
	var	monthName =	new	Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
	var	monthName2 = new Array("JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC")
	if (startAt == 0) dayName = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	else dayName = new Array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
} else {
	var	monthName =	new	Array("1��", "2��", "3��", "4��", "5��", "6��", "7��", "8��", "9��", "10��", "11��", "12��");
	var	monthName2 =	new	Array("1��", "2��", "3��", "4��", "5��", "6��", "7��", "8��", "9��", "10��", "11��", "12��");
	if (startAt == 0) dayName = new Array	("��", "��", "ȭ", "��", "��", "��", "��");
	else dayName = new Array	("��", "ȭ", "��", "��", "��", "��", "��");
}

function hideElement(elmID, overDiv) {
	if (ie) {
		for (i = 0; i < document.all.tags(elmID).length; i++) {
			obj = document.all.tags(elmID)[i];
			if (!obj || !obj.offsetParent) continue;
			objLeft = obj.offsetLeft;
			objTop = obj.offsetTop;
			objParent = obj.offsetParent;
			while (objParent.tagName.toUpperCase() != "BODY") {
				objLeft += objParent.offsetLeft;
				objTop += objParent.offsetTop;
				objParent = objParent.offsetParent;
			}
			objHeight = obj.offsetHeight;
			objWidth = obj.offsetWidth;
			if((overDiv.offsetLeft + overDiv.offsetWidth) <= objLeft);
			else if((overDiv.offsetTop + overDiv.offsetHeight) <= objTop);
			else if(overDiv.offsetTop >= (objTop + objHeight));
			else if(overDiv.offsetLeft >= (objLeft + objWidth));
			else obj.style.visibility = "hidden";
		}
	}
}

function showElement(elmID) {
	if (ie) {
		for (i = 0; i < document.all.tags(elmID).length; i++) {
			obj = document.all.tags(elmID)[i];
			if (!obj || !obj.offsetParent) continue;
			obj.style.visibility = "";
		}
	}
}

function HolidayRec(d, m, y, desc) {
	this.d = d;
	this.m = m;
	this.y = y;
	this.desc = desc;
}

var HolidaysCounter = 0;
var Holidays = new Array();

function addHoliday(d, m, y, desc) {
	Holidays[HolidaysCounter++] = new HolidayRec ( d, m, y, desc );
}

if (dom) {
	for (i = 0; i < imgsrc.length; i++) {
		img[i] = new Image;
		img[i].src = imgDir + imgsrc[i];
	}
	document.write ("<div onclick='bShow=true' id='calendar' style='z-index:+999;position:absolute;visibility:hidden;'>");
	document.write ("<table width="+((showWeekNumber==1)?280:250)+" class='cnj_td' bgcolor='#ffffff'>");
	document.write ("<tr bgcolor='#0000aa'>");
	document.write ("<td>");
	document.write ("<table width='"+((showWeekNumber==1)?278:248)+"'>");
	document.write ("<tr>");
	document.write ("<td style='padding:2px;'>");
	document.write ("<font color='#ffffff'><B><span id='caption'></span></B></font></td>");
	document.write ("<td align=right>");
	document.write ("<input type='button' value='X' class='cnj_close' title='�ݱ�' onclick='hideCalendar()' onfocus='this.blur()' onMouseover=\"this.className='cnj_close2'\" onMouseout=\"this.className='cnj_close'\"></td>");
	document.write ("</tr>");
	document.write ("</table>");
	document.write ("</td>");
	document.write ("</tr>");
	document.write ("<tr><td style='padding:5px' bgcolor=#ffffff><span id='content'></span></td></tr>");
	if (showToday == 1) document.write ("<tr bgcolor=#f0f0f0><td style='padding:5px' align=center><span id='lblToday'></span></td></tr>");
	document.write ("</table>");
	document.write ("</div>");
	document.write ("<div id='selectMonth' style='z-index:+999;position:absolute;visibility:hidden;'></div>");
	document.write ("<div id='selectYear' style='z-index:+999;position:absolute;visibility:hidden;'></div>");
}

var styleAnchor = "text-decoration:none;color:black;";
var styleLightBorder = "border-style:solid;border-width:1px;border-color:#a0a0a0;";

function swapImage(srcImg, destImg) {
	if (ie) document.getElementById(srcImg).setAttribute("src", imgDir + destImg);
}

function init() {
	if (!ns4) {
		crossobj = (dom) ? document.getElementById("calendar").style : ie ? document.all.calendar : document.calendar;
		hideCalendar();
		crossMonthObj = (dom) ? document.getElementById("selectMonth").style : ie ? document.all.selectMonth : document.selectMonth;
		crossYearObj = (dom) ? document.getElementById("selectYear").style : ie ? document.all.selectYear : document.selectYear;
		monthConstructed = false;
		yearConstructed = false;
		if (showToday == 1) {
			document.getElementById("lblToday").innerHTML =	"" +
			"Today : <a onmousemove='window.status=\"���� ��¥�� ǥ���ϱ�\"' onmouseout='window.status=\"\"' title='���� ��¥�� ǥ���ϱ�' " +
			"style='" + styleAnchor + "' href='javascript:monthSelected=monthNow;yearSelected=yearNow;constructCalendar();' onFocus='this.blur()'>" +
			"" + yearNow + " "+
			//"" + dayName[(today.getDay() - startAt == -1) ? 6 : (today.getDay() - startAt)] + "" +
			"" + monthName[monthNow].substring(0, 3) + " " +
			"" + dateNow + " " +
			"</a>";
		}
		sHTML1="<input type='button' value='��' class='cnj_input2' onClick='javascript:decMonth()' onfocus='this.blur()' title='���� ��(��)�� �̵�' ";
		sHTML1+="onMouseover=\"this.className='cnj_input3';window.status='���� ��(��)�� �̵�'\" onMouseout=\"this.className='cnj_input2';window.status=''\"> </span> ";
		sHTML1+="<input type='button' value='��'  class='cnj_input2' onClick='javascript:incMonth()' onfocus='this.blur()' title='���� ��(��)�� �̵�' ";
		sHTML1+="onMouseover=\"this.className='cnj_input3';window.status='���� ��(��)�� �̵�'\"  onMouseout=\"this.className='cnj_input2';window.status=''\"> </span> ";
		sHTML1+="<span id='spanMonth'  class='cnj_input4' onclick='popUpMonth()' title='�� ����' ";
		sHTML1+="onMouseover=\"this.className='cnj_input3';window.status='�� ����'\" onMouseout=\"this.className='cnj_input4';window.status=''\"></span> ";
		sHTML1+="<span id='spanYear'  class='cnj_input4' onclick='popUpYear()' title='�⵵ ����' ";
		sHTML1+="onMouseover=\"this.className='cnj_input3';window.status='�⵵ ����'\" onMouseout=\"this.className='cnj_input4';window.status=''\"></span> ";
		document.getElementById("caption").innerHTML = sHTML1;
		bPageLoaded = true;
	}
}

function hideCalendar()	{
	crossobj.visibility = "hidden";
	if (crossMonthObj != null) crossMonthObj.visibility = "hidden";
	if (crossYearObj != null) crossYearObj.visibility = "hidden";
	showElement('SELECT');
	showElement('APPLET');
}

function padZero(num) {
	return (num < 10) ? "0" + num : num;
}

function constructDate(d,m,y) {
	sTmp = dateFormat
	sTmp = sTmp.replace("dd", "<e>");
	sTmp = sTmp.replace("d", "<d>");
	sTmp = sTmp.replace("<e>", padZero(d));
	sTmp = sTmp.replace("<d>", d);
	sTmp = sTmp.replace("mmmm", "<p>");
	sTmp = sTmp.replace("mmm", "<o>");
	sTmp = sTmp.replace("mm", "<n>");
	sTmp = sTmp.replace("m", "<m>");
	sTmp = sTmp.replace("<m>", m + 1);
	sTmp = sTmp.replace("<n>", padZero(m + 1));
	sTmp = sTmp.replace("<o>", monthName[m]);
	sTmp = sTmp.replace("<p>", monthName2[m]);
	sTmp = sTmp.replace("yyyy", y);
	return sTmp.replace("yy", padZero(y % 100));
}

function closeCalendar() {
	var sTmp;
	hideCalendar();
	ctlToPlaceValue.value =	constructDate(dateSelected, monthSelected, yearSelected);
}

function StartDecMonth() {
	intervalID1 = setInterval("decMonth()", 80);
}

function StartIncMonth() {
	intervalID1 = setInterval("incMonth()", 80);
}

function incMonth() {
	monthSelected++;
	if (monthSelected > 11) {
		monthSelected = 0;
		yearSelected++;
	}
	constructCalendar();
}

function decMonth() {
	monthSelected--;
	if (monthSelected < 0) {
		monthSelected = 11;
		yearSelected--;
	}
	constructCalendar();
}

function constructMonth() {
	popDownYear();
	if (!monthConstructed) {
		sHTML =	"";
		for (i = 0; i < 12; i++) {
			sName =	monthName[i];
			if (i == monthSelected) sName =	"<B>" +	sName +	"</B>"; // ���� ��
			sHTML += "<tr><td id='m" + i + "' onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='this.style.backgroundColor=\"\"' style='cursor:pointer' onClick='monthConstructed=false;monthSelected=" + i + ";constructCalendar();popDownMonth();event.cancelBubble=true'> " + sName + " </td></tr>";
		}
		////// �� ǥ ũ�� //////////
		document.getElementById("selectMonth").innerHTML = "<table width=50	style='font-family:����; font-size:11px; border-width:1; border-style:solid; border-color:#a0a0a0;' bgcolor='#FFFFDD' cellspacing=0 onmouseover='clearTimeout(timeoutID1)'	onmouseout='clearTimeout(timeoutID1);timeoutID1=setTimeout(\"popDownMonth()\",100);event.cancelBubble=true'>" +	sHTML +	"</table>";
		monthConstructed = true;
	}
}

function popUpMonth() {
	constructMonth();
	crossMonthObj.visibility = (dom||ie) ? "visible"	: "show";
	crossMonthObj.left = parseInt(crossobj.left) + 50;
	crossMonthObj.top = parseInt(crossobj.top) + 26;
	hideElement('SELECT', document.getElementById("selectMonth"));
	hideElement('APPLET', document.getElementById("selectMonth"));			
}

function popDownMonth()	{
	crossMonthObj.visibility = "hidden";
}

function incYear() {
	for (i = 0; i < 7; i++) {
		newYear	= (i + nStartingYear) + 1;
		if (newYear == yearSelected) txtYear = " <B>"+ newYear +"</B> "; 
		else txtYear = " " + newYear + " "; 
		document.getElementById("y" + i).innerHTML = txtYear;
	}
	nStartingYear++;
	bShow = true;
}

function decYear() {
	for (i = 0; i < 7; i++) {
		newYear	= (i + nStartingYear) - 1;
		if (newYear == yearSelected) txtYear = " <B>"+ newYear +"</B> "; 
		else txtYear = " " + newYear + " "; 
		document.getElementById("y"+i).innerHTML = txtYear;
	}
	nStartingYear--;
	bShow = true;
}

function selectYear(nYear) {
	yearSelected = parseInt(nYear+nStartingYear);
	yearConstructed = false;
	constructCalendar();
	popDownYear();
}

function constructYear() {
	popDownMonth();
	sHTML =	"";
	if (!yearConstructed) { // �⵵ ���� �⵵ ��ũ
		sHTML ="<tr><td align='center' style='cursor:pointer'";
		sHTML += "	onmouseover='this.style.backgroundColor=\"#FFCC99\"'";
		sHTML += "	onmouseout='clearInterval(intervalID1);this.style.backgroundColor=\"\"'";
		sHTML += "	onmousedown='clearInterval(intervalID1);intervalID1=setInterval(\"decYear()\",30)'";
		sHTML += "	onmouseup='clearInterval(intervalID1)'>";
		sHTML += "	��</td></tr>";
		j = 0;
		nStartingYear =	yearSelected - 3;
		for (i = (yearSelected - 3); i<= (yearSelected + 3); i++) {
			sName =	i;
			if (i == yearSelected) sName = "<b>" + sName + "</b>"; // ���� �⵵
			sHTML += "<tr><td height='15' id='y" + j + "' onmouseover='this.style.backgroundColor=\"#FFCC99\"' onmouseout='this.style.backgroundColor=\"\"'";
			sHTML += " style='cursor:pointer' onClick='selectYear("+j+");event.cancelBubble=true'> " + sName + "��";
			sHTML += "</td></tr>";
			j ++;
		}
		// �⵵ ���� �⵵ ��ũ
		sHTML += "<tr><td align='center' onmouseover='this.style.backgroundColor=\"#FFCC99\"' style='cursor:pointer'";
		sHTML += " onmouseout='clearInterval(intervalID2);this.style.backgroundColor=\"\"'";
		sHTML += " onmousedown='clearInterval(intervalID2);intervalID2=setInterval(\"incYear()\",30)'";
		sHTML += " onmouseup='clearInterval(intervalID2)'>";
		sHTML += " ��</td></tr>";;

		// �⵵ ǥ ũ��
		document.getElementById("selectYear").innerHTML	= "" +
		"<table width='55' style='font-family:����; font-size:11px; border-width:1; border-style:solid; border-color:#a0a0a0;' bgcolor='#FFFFDD'" +
		" onmouseover='clearTimeout(timeoutID2)'" +
		" onmouseout='clearTimeout(timeoutID2);timeoutID2=setTimeout(\"popDownYear()\",100)' cellspacing=0>" +
		"" + sHTML + "" +
		"</table>";
		yearConstructed	= true;
	}
}

function popDownYear() {
	clearInterval(intervalID1);
	clearTimeout(timeoutID1);
	clearInterval(intervalID2);
	clearTimeout(timeoutID2);
	crossYearObj.visibility= "hidden";
}

function popUpYear() {
	var leftOffset;
	constructYear();
	crossYearObj.visibility	= (dom || ie) ? "visible" : "show";
	leftOffset = parseInt(crossobj.left) + document.getElementById("spanYear").offsetLeft;
	if (ie) leftOffset += 6;
	crossYearObj.left = leftOffset;
	crossYearObj.top = parseInt(crossobj.top) + 26;
}

function WeekNbr(n) {
	year = n.getFullYear();
	month = n.getMonth() + 1;
	if (startAt == 0) day = n.getDate() + 1;
	else day = n.getDate();
	a = Math.floor((14 - month) / 12);
	y = year + 4800 - a;
	m = month + 12 * a - 3;
	b = Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400);
	J = day + Math.floor((153 * m + 2) / 5) + 365 * y + b - 32045;
	d4 = (((J + 31741 - (J % 7)) % 146097) % 36524) % 1461;
	L = Math.floor(d4 / 1460);
	d1 = ((d4 - L) % 365) + L;
	week = Math.floor(d1 / 7) + 1;
	return week;
} 

function constructCalendar() {
	var aNumDays = Array (31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	var dateMessage;
	var startDate =	new Date(yearSelected, monthSelected, 1);
	var endDate;
	if (monthSelected == 1) {
		endDate	= new Date(yearSelected, monthSelected + 1, 1);
		endDate	= new Date(endDate - (24 * 60 * 60 * 1000));
		numDaysInMonth = endDate.getDate();
	} else numDaysInMonth = aNumDays[monthSelected];
	datePointer = 0;
	dayPointer = startDate.getDay() - startAt;
	if (dayPointer < 0) dayPointer = 6;
	sHTML =	"<table	 border=0 style='font-family:verdana;font-size:10px;'><tr>";
	if (showWeekNumber == 1) {
		sHTML += "<td width=27 align='right'><b> ��</b></td>"
		sHTML += "<td width=1 rowspan=7 bgcolor='#d0d0d0' style='padding:0px'><img src='"+imgDir+"divider.gif' width=1></td>";
	}
	for (i = 0; i < 7; i++) { // ����
		sHTML += "<td width='27' align='right'><B>" + dayName[i] + "</B></td>";
	}
	sHTML +="</tr><tr>";
	if (showWeekNumber == 1) sHTML += "<td align=right>" + WeekNbr(startDate) + " </td>";
	for (var i = 1; i <= dayPointer; i++) { // �� ��¥
		sHTML += "<td> </td>";
	}
	for (datePointer = 1; datePointer <= numDaysInMonth; datePointer++) {
		dayPointer++;
		sHTML += "<td align=right>";
		sStyle = styleAnchor;
		if ((datePointer == odateSelected) && (monthSelected == omonthSelected) && (yearSelected == oyearSelected)) sStyle += styleLightBorder;
		sHint = "";
		for (k = 0; k < HolidaysCounter; k++) {
			if ((parseInt(Holidays[k].d) == datePointer) && (parseInt(Holidays[k].m) == (monthSelected + 1))) {
				if ((parseInt(Holidays[k].y) == 0) || ((parseInt(Holidays[k].y) == yearSelected) && (parseInt(Holidays[k].y) != 0))) {
					sStyle += "background-color:#FFDDDD;";
					sHint += sHint == "" ? Holidays[k].desc : "\n" + Holidays[k].desc;
				}
			}
		}
		var regexp= /\"/g;
		sHint=sHint.replace(regexp, "&quot;");
		// ��¥ ���ý� ==> ���콺�� ��¥ ���� ������
		dateMessage = "title=' ��¥ ���� : " + yearSelected + "�� " + monthName[monthSelected] + " " + datePointer + "��" + "' onmousemove='window.status=\" ��¥ ���� : "+ yearSelected + "�� " +	monthName[monthSelected] + " " + datePointer + "��" + "\"' onmouseout='window.status=\"\"'";
		if ((datePointer == dateNow) && (monthSelected == monthNow) && (yearSelected == yearNow)) sHTML += "<b><a " + dateMessage + " title=\"" + sHint + "\" style='" + sStyle + "' href='javascript:dateSelected=" + datePointer + ";closeCalendar();'><font color=#ff0000> " + datePointer + "</font> </a></b>"; // ���� ���� ��¥
		else if (dayPointer % 7 == (startAt * -1) + 1) sHTML += "<a " + dateMessage + " title=\"" + sHint + "\" style='" + sStyle + "' href='javascript:dateSelected=" + datePointer + ";closeCalendar();'> <font color=red>" + datePointer + "</font> </a>";// �Ͽ��� �϶�
		else sHTML += "<a " + dateMessage + " title=\"" + sHint + "\" style='" + sStyle + "' href='javascript:dateSelected=" + datePointer + ";closeCalendar();'> " + datePointer + " </a>";
		sHTML += "";
		if ((dayPointer+startAt) % 7 == startAt) { 
			sHTML += "</tr><tr>";
			if ((showWeekNumber == 1) && (datePointer < numDaysInMonth)) sHTML += "<td align=right>" + (WeekNbr(new Date(yearSelected, monthSelected, datePointer + 1))) + " </td>";
		}
	}
	document.getElementById("content").innerHTML = sHTML;  
	document.getElementById("spanMonth").innerHTML = " " +	monthName[monthSelected] + " <input type='button'  id='changeMonth'value='��'  class='cnj_input2' onfocus='this.blur()' onMouseover=\"this.className='cnj_input3'\" onMouseout=\"this.className='cnj_input2'\">"; // ����Ʈ �� ����
	document.getElementById("spanYear").innerHTML =	" " + yearSelected	+ "�� <input type='button'  id='changeYear'' value='��'  class='cnj_input2' onfocus='this.blur()' onMouseover=\"this.className='cnj_input3'\" onMouseout=\"this.className='cnj_input2'\">"; // ����Ʈ �⵵ ����
}

function popUpCalendar(ctl, ctl2, format) {
	var leftpos = -100;
	var toppos = 0;
	if (bPageLoaded) {
		if (crossobj.visibility == "hidden") {
			ctlToPlaceValue	= ctl2;
			dateFormat = format;
			formatChar = " ";
			aFormat	= dateFormat.split(formatChar);
			if (aFormat.length < 3) {
				formatChar = "/";
				aFormat	= dateFormat.split(formatChar);
				if (aFormat.length < 3) {
					formatChar = ".";
					aFormat	= dateFormat.split(formatChar);
					if (aFormat.length < 3) {
						formatChar = "-";
						aFormat	= dateFormat.split(formatChar);
						if (aFormat.length < 3) formatChar = "";
					}
				}
			}
			tokensChanged =	"0";
			if (formatChar != "") {
				aData =	ctl2.value.split(formatChar);
				for (i = 0; i < 3; i++) {
					if ((aFormat[i] == "d") || (aFormat[i] == "dd")) {
						dateSelected = parseInt(aData[i], 10);
						tokensChanged++;
					} else if ((aFormat[i] == "m") || (aFormat[i] == "mm")) {
						monthSelected =	parseInt(aData[i], 10) - 1;
						tokensChanged++;
					} else if (aFormat[i] == "yyyy") {
						yearSelected = parseInt(aData[i], 10);
						tokensChanged++;
					} else if (aFormat[i] == "mmm") {
						for (j = 0; j < 12; j++) {
							if (aData[i] == monthName[j]) {
								monthSelected = j;
								tokensChanged++;
							}
						}
					} else if (aFormat[i] == "mmmm") {
						for (j = 0; j < 12; j++) {
							if (aData[i] == monthName2[j]) {
								monthSelected = j;
								tokensChanged++;
							}
						}
					}
				}
			}
			if ((tokensChanged != 3) || isNaN(dateSelected) || isNaN(monthSelected) || isNaN(yearSelected)) {
				dateSelected = dateNow;
				monthSelected =	monthNow;
				yearSelected = yearNow;
			}
			odateSelected = dateSelected;
			omonthSelected = monthSelected;
			oyearSelected = yearSelected;
			aTag = ctl;
			do {
				aTag = aTag.offsetParent;
				leftpos	+= aTag.offsetLeft;
				toppos += aTag.offsetTop;
			} while (aTag.tagName != "BODY");
			crossobj.left =	fixedX == -1 ? ctl.offsetLeft	+ leftpos :	fixedX;
			crossobj.top = fixedY == -1 ? ctl.offsetTop +	toppos + ctl.offsetHeight +	2 :	fixedY;
			constructCalendar(1, monthSelected, yearSelected);
			crossobj.visibility = (dom || ie) ? "visible" : "show";
			hideElement('SELECT', document.getElementById("calendar"));
			hideElement('APPLET', document.getElementById("calendar"));			
			bShow = true;
		} else {
			hideCalendar();
			if (ctlNow != ctl) popUpCalendar(ctl, ctl2, format);
		}
		ctlNow = ctl;
	}
}

document.onkeypress = function hidecal1() { 
	if (event.keyCode == 27) hideCalendar();
}

document.onclick = function hidecal2() { 		
	if (!bShow) hideCalendar();
	bShow = false;
}

if(ie) init();
else window.onload = init;
var layerQueue = new Array();
var layerIndex = -1;

function hideElement(elmID, overDiv) {
	if (ie) {
		for (i = 0; i < document.getElementsByTagName(elmID).length; i++) {
			obj = document.getElementsByTagName(elmID)[i];
			if (!obj || !obj.offsetParent) continue;
			objLeft = obj.offsetLeft;
			objTop = obj.offsetTop;
			objParent = obj.offsetParent;
			while (objParent.tagName.toUpperCase() != "BODY") {
				objLeft += objParent.offsetLeft;
				objTop += objParent.offsetTop;
				objParent = objParent.offsetParent;
			}
			objHeight = obj.offsetHeight;
			objWidth = obj.offsetWidth;
			if ((overDiv.offsetLeft + overDiv.offsetWidth) <= objLeft);
			else if ((overDiv.offsetTop + overDiv.offsetHeight) <= objTop);
			else if (overDiv.offsetTop >= (objTop + objHeight));
			else if (overDiv.offsetLeft >= (objLeft + objWidth));
			else obj.style.visibility = "hidden";
		}
	}
}

function showElement(elmID) {
	if (ie) {
		for (i = 0; i < document.getElementsByTagName(elmID).length; i++) {
			obj = document.getElementsByTagName( elmID )[i];
			if (!obj || !obj.offsetParent) continue;
			obj.style.visibility = "";
		}
	}
}

function lw_createLayer(layerName, top_pos, left_pos, width, height, bgcolor, bordercolor, z_index) {
	document.write("<div onClick='event.cancelBubble=true' id='"+layerName+"' style='z-index:" + z_index + ";position:absolute;top:"+top_pos+";left:"+left_pos+";visibility:hidden;'><table bgcolor='"+bgcolor+"' style='border-width:1px;border-style:solid;border-color:" + bordercolor + "' cellpadding=2 cellspacing=0 width=0><tr><td valign=top width='"+width+"' height='"+height+"'><span id='"+layerName+"_content'></span></td></tr></table></div>");
}

function lw_getObj(objName) {
	return (dom) ? document.getElementById(objName).style : ie ? eval("document.all." + objName) : eval("document."+objName);
}

function lw_showLayer(layerName) {
	found = false;
	for (i = 0; i <= layerIndex; i++) {
		if (layerQueue[i]==layerName) found=true;
	}
	if ((lw_getObj(layerName).visibility != "visible") && (lw_getObj(layerName).visibility != "show")) {
		lw_getObj(layerName).visibility = (dom || ie) ? "visible" : "show";
		layerQueue[++layerIndex] = layerName;
		hideElement('SELECT', document.getElementById(layerName));
		hideElement('APPLET', document.getElementById(layerName));
	}
}

function lw_hideLayer() {
	showElement('SELECT', document.getElementById(layerQueue[layerIndex]));
	showElement('APPLET', document.getElementById(layerQueue[layerIndex]));
	lw_getObj(layerQueue[layerIndex--]).visibility = "hidden";
}

function lw_hideLayerName(layerName) {
	var i;
	var tmpQueue=new Array();
	var newIndex=-1;
	showElement('SELECT', document.getElementById(layerName));
	showElement('APPLET', document.getElementById(layerName));
	lw_getObj(layerName).visibility = "hidden";
	for (i = 0; i <= layerIndex; i++) {
		if ((layerQueue[i] != "") && (layerQueue[i] != layerName)) {
			tmpQueue [++newIndex] = layerQueue[i];			
			hideElement('SELECT', document.getElementById(layerQueue[i]));
			hideElement('APPLET', document.getElementById(layerQueue[i]));
		}
	}
	layerQueue = tmpQueue;
	layerIndex = newIndex;
}

function lw_closeAllLayers() {
	while (layerIndex >= 0) {
		lw_hideLayer();
	}
}

function lw_closeLastLayer() {
	if (layerIndex >= 0) {
		while ((lw_getObj(layerQueue[layerIndex]).visibility != "visible") && (layerIndex > 0)) {
			layerIndex--;
		}
		lw_hideLayer();
	}
}

function lw_escLayer(e) {
	if (navigator.appName == "Netscape") {
		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
		if ((keyCode == 27) || (keyCode == 1)) lw_closeLastLayer();
	} else if ((event.keyCode == 0) || (event.keyCode == 27)) lw_closeLastLayer();		
}

var lw_leftpos = 0;
var lw_toppos = 0;
var lw_width = 0;
var lw_height = 0;

function lw_calcpos(obj) {
	lw_leftpos = 0;
	lw_toppos = 0;
	lw_width = obj.offsetWidth;
	lw_height = obj.offsetHeight;
	var aTag = obj;
	do {
		lw_leftpos += aTag.offsetLeft;
		lw_toppos += aTag.offsetTop;
		aTag = aTag.offsetParent;
	} while(aTag.tagName != "BODY");
}

document.onkeypress = lw_escLayer;
document.onclick = lw_closeAllLayers;
