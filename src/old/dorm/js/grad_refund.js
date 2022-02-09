var total_attach = 1024 * 1024 * 1;

function gotoList(Form) {
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/graduate/list_app.php";
	Form.submit();
}

function generateSelectList(objParser, type) {
	var i = 0, temp_flag, strHTML = "", collDistricts = objParser.selectNodes( "//district" );
	strHTML += "<select id=\"" + type + "\" name=\"" + type + "\" style=\"color:#9B9EA3;\">\n";
	if (type == "old_period") strHTML += "<option value=\"\">Select the last session you lived in residence hall.</option>\n";
	else strHTML += "<option value=\"\">Select which semester you would like to change to.</option>\n";
	for (i = 0; i < collDistricts.length; i++ ) {
		if (type == "old_period") temp_flag = collDistricts.item(i).selectSingleNode("old").text;
		else temp_flag = collDistricts.item(i).selectSingleNode("new").text;
		if (temp_flag == "Y") {
			strHTML += "<option value=\"" + collDistricts.item(i).selectSingleNode("code").text + "\">";
			strHTML += collDistricts.item(i).selectSingleNode("name").text + ": " + collDistricts.item(i).selectSingleNode("sdate").text + " - " + collDistricts.item(i).selectSingleNode("edate").text;
			strHTML += "</option>\n";
		}
	}
	strHTML += "</select>\n";
	return strHTML;
}

function changeSelect(element) {
	var objParser = new ActiveXObject("Microsoft.XMLDOM");
	var type = element.name;
	var kind = element.value;
	objParser.async = false;
	switch (type) {
		case "kind":
			objParser.load("https://reslife.korea.ac.kr:5008/v1/src/graduate/re_select.php?type=deposit&kind=" + kind);
			document.getElementById("Level1").innerHTML = generateSelectList(objParser, "old_period");
			document.getElementById("Level2").innerHTML = generateSelectList(objParser, "new_period");
			break;
	}
}

function setSelectList(element, val) {
	var i, lenlist = element.length;
	for (i = 0; i < lenlist; i++) {
		if (element.options[i].value == val) {
			element.options[i].selected = true;									
			break;
		}
	}
	changeSelect(element)
}

function gotoList(Form) {
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/graduate/list_app.php";
	Form.submit();
}

function checkRefundInfo(Form) {
	if (Form.method_info1.value == "") {
		alert("Please input name of bank.");
		Form.method_info1.focus();
		return false;
	}
	if (Form.method_info2.value == "") {
		alert("Please input bank account number.");
		Form.method_info2.focus();
		return false;
	}
	if (Form.method_info3.value == "") {
		alert("Please input name of beneficiary.");
		Form.method_info3.focus();
		return false;
	}
	if (Form.photo.value == "") {
		alert("Please upload the picture of your bank book copy or the backside of student ID, where the requested account number is written on.");
		Form.photo.focus();
		return false;
	} else {
		if (!(Form.photo.value.toLowerCase().match("\.jpg") || Form.photo.value.toLowerCase().match("\.gif"))) {
			alert("Only JPG and GIF format is allowed.\nPlease try again later.");
			Form.photo.focus();
			return false;
		}
	}
	return true;
}