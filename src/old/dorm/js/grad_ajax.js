/**************************************************************************************************************************
Copyright (c) Seung Hwan KIM <shkim@intia.co.nz> 2010.09.23
Authors:     Seung Hwan KIM
Description: Ajax 구현 자바스트립트
**************************************************************************************************************************/

var xmlHttp;

function createXMLHttpRequest() {
	if (window.ActiveXObject) xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) xmlHttp = new XMLHttpRequest();
}

function addTableHSpace(tableObj) {
	var row = document.createElement("tr");
	var cell = document.createElement("td");
	cell.setAttribute("height", "20");
	row.appendChild(cell);
	tableObj.appendChild(row);
}

function addTableDotLine(tableObj) {
	var row = document.createElement("tr");
	var cell = document.createElement("td");
	cell.setAttribute("height", "1");
	cell.setAttribute("background", img_url + "/board/board_hdot.jpg");
	row.appendChild(cell);
	tableObj.appendChild(row);
}

function addTableRow(tableObj, text) {
	var row = document.createElement("tr");
	var cell = createCellWithText(text);
	row.appendChild(cell);
	tableObj.appendChild(row);
}

function createCellWithText(text) {
	var cell = document.createElement("td");
	cell.innerHTML = text;
	return cell;
}

function clearObject(name) {
	var obj = document.getElementById(name);
	while (obj.childNodes.length > 0) {
		obj.removeChild(obj.childNodes[0]);
	}
}

function setSearchValue() {
	document.getElementById("ajax_page").value = "";
	document.getElementById("ajax_sort").value = "1";
	document.getElementById("ajax_type").value = "1";
	document.getElementById("ajax_text").value = "";
}

function updateSearchStat(tableObj) {
	var page = "", total_page = "", all_count = "";
	var search = xmlHttp.responseXML.getElementsByTagName("search");
	if (search[0].getElementsByTagName("page")[0].childNodes.length > 0) page = search[0].getElementsByTagName("page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("total_page")[0].childNodes.length > 0) total_page = search[0].getElementsByTagName("total_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("all_count")[0].childNodes.length > 0) all_count = search[0].getElementsByTagName("all_count")[0].childNodes[0].nodeValue;
	htmlTag = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
	htmlTag += "	<tr>\n";
	htmlTag += "		<td nowrap>" + setCommaFormat1(page) + "/" + setCommaFormat1(total_page) + "" + msg_item_page + ", " + msg_item_total + " " + setCommaFormat1(all_count) + "</td>\n";
	htmlTag += "	</tr>\n";
	htmlTag += "</table>\n";
	addTableRow(tableObj, htmlTag);
}

function updateSearchPage(tableObj, kind) {
	var sort = "", s_type = "", s_text = "", page = "", pre_page = "", next_page = "", first_page = "", last_page = "", total_page = "", all_count = "";
	var search = xmlHttp.responseXML.getElementsByTagName("search");
	if (search[0].getElementsByTagName("sort")[0].childNodes.length > 0) sort = search[0].getElementsByTagName("sort")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("s_type")[0].childNodes.length > 0) s_type = search[0].getElementsByTagName("s_type")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("s_text")[0].childNodes.length > 0) s_text = search[0].getElementsByTagName("s_text")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("page")[0].childNodes.length > 0) page = search[0].getElementsByTagName("page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("pre_page")[0].childNodes.length > 0) pre_page = search[0].getElementsByTagName("pre_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("next_page")[0].childNodes.length > 0) next_page = search[0].getElementsByTagName("next_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("first_page")[0].childNodes.length > 0) first_page = search[0].getElementsByTagName("first_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("last_page")[0].childNodes.length > 0) last_page = search[0].getElementsByTagName("last_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("total_page")[0].childNodes.length > 0) total_page = search[0].getElementsByTagName("total_page")[0].childNodes[0].nodeValue;
	if (search[0].getElementsByTagName("all_count")[0].childNodes.length > 0) all_count = search[0].getElementsByTagName("all_count")[0].childNodes[0].nodeValue;
	htmlTag = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
	htmlTag += "	<tr>\n";
	htmlTag += "		<td>\n";
	if (first_page.trim() == "") htmlTag += "			<img src=\"" + img_url + "/board/page_first.jpg\" align=\"absmiddle\">\n";
	else htmlTag += "			<a href=\"javascript:document.getElementById('ajax_page').value='" + first_page + "';refresh" + kind + "();\"><img src=\"" + img_url + "/board/page_first.jpg\" align=\"absmiddle\"></a>\n";
	if (pre_page.trim() == "") htmlTag += "			<img src=\"" + img_url + "/board/page_pre.jpg\" align=\"absmiddle\">\n";
	else htmlTag += "			<a href=\"javascript:document.getElementById('ajax_page').value='" + pre_page + "';refresh" + kind + "();\"><img src=\"" + img_url + "/board/page_pre.jpg\" align=\"absmiddle\"></a>\n";
	if (parseInt(page) != 0) {
		for (var i = parseInt(next_page) - 10; i <= parseInt(next_page) - 1; i++) {
			if (i == parseInt(page)) htmlTag += "			&nbsp;<b>" + i + "</b>&nbsp;\n";
			else htmlTag += "			&nbsp;<a href=\"javascript:document.getElementById('ajax_page').value='" + i + "';refresh" + kind + "();\">" + i +"</a>&nbsp;\n";
			if (i == parseInt(total_page)) break;
		}
	}
	if (parseInt(next_page) > parseInt(total_page)) next_page = "";
	if (next_page.trim() == "") htmlTag += "			<img src=\"" + img_url + "/board/page_next.jpg\" align=\"absmiddle\">\n";
	else htmlTag += "			<a href=\"javascript:document.getElementById('ajax_page').value='" + next_page + "';refresh" + kind + "();\"><img src=\"" + img_url + "/board/page_next.jpg\" align=\"absmiddle\"></a>\n";
	if (last_page.trim() == "") htmlTag += "			<img src=\"" + img_url + "/board/page_last.jpg\" align=\"absmiddle\">\n";
	else htmlTag += "			<a href=\"javascript:document.getElementById('ajax_page').value='" + last_page + "';refresh" + kind + "();\"><img src=\"" + img_url + "/board/page_last.jpg\" align=\"absmiddle\"></a>\n";
	htmlTag += "		</td>\n";
	htmlTag += "	</tr>\n";
	htmlTag += "</table>\n";
	addTableRow(tableObj, htmlTag);
}

function refreshRoomList(code, gender) {
	var urlValue = "https://reslife.korea.ac.kr:5008/v1/src/graduate/select.php?type=rate&code=" + code + "&gender=" + gender;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleRoomList;
	xmlHttp.open("GET", urlValue, false);
	xmlHttp.send(null);
}

function handleRoomList() {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) updateRoomList();
}

function updateRoomList() {
	var optionObj, room = xmlHttp.responseXML.getElementsByTagName("district");
	optionObj = null;
	clearObject("rate1");
	optionObj = document.createElement("option");
	optionObj.setAttribute("value", "");
	optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
	document.getElementById("rate1").appendChild(optionObj);
	for (var i = 0; i < room.length; i++) {
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", room[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
		//optionObj.setAttribute("selected", "selected");
		optionObj.appendChild(document.createTextNode(room[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " : " + room[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
		document.getElementById("rate1").appendChild(optionObj);
	}
	/* 여기 주석 없애서 원래대로 복귀해야 함. 바로 위 selected 옵션 없애야 함. */
	optionObj = null;
	clearObject("rate2");
	optionObj = document.createElement("option");
	optionObj.setAttribute("value", "");
	optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
	document.getElementById("rate2").appendChild(optionObj);
	for (var i = 0; i < room.length; i++) {
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", room[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
		optionObj.appendChild(document.createTextNode(room[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " : " + room[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
		document.getElementById("rate2").appendChild(optionObj);
	}
	clearObject("rate3");
	optionObj = document.createElement("option");
	optionObj.setAttribute("value", "");
	optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
	document.getElementById("rate3").appendChild(optionObj);
	for (var i = 0; i < room.length; i++) {
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", room[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
		optionObj.appendChild(document.createTextNode(room[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " : " + room[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
		document.getElementById("rate3").appendChild(optionObj);
	}
}

function checkStudentNumber(year, term, no) {
	var urlValue = "https://openapi.korea.ac.kr/api/dorm?ex_no=" + no + "&term=" + term + "&year=" + year;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleRoomList;
	xmlHttp.open("POST", urlValue, false);
	xmlHttp.send(null);
}

function handleStudentNumber() {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) updateStudentNumber();
}

function updateStudentNumber() {
	alert(xmlHttp.responseText);
}