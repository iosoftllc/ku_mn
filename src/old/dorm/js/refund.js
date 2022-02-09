var total_attach = 1024 * 1024 * 1;

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
			objParser.load("https://reslife.korea.ac.kr:5008/v1/src/apply/re_select.php?type=deposit&kind=" + kind);
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
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/list_app.php";
	Form.submit();
}

function checkRefundInfo(Form) {
	if (Form.student.value == "") {
		alert("Please input KU Student ID No.");
		Form.student.focus();
		return false;
	}
	if (Form.kind.value == "L") {
		if (Form.student.value.length != 8) {
			alert("Korean Language & Culture Center Student ID number must be 8 digits.");
			Form.student.focus();
			return false;
		}
	} else {
		if (Form.student.value.length != 10) {
			alert("Korea University Student ID number must be 10 digits.");
			Form.student.focus();
			return false;
		}
	}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("Please input your name.");
		Form.lname.focus();
		return false;
	}
	if (Form.dob_yy.value == "" || Form.dob_mm.value == "" || Form.dob_dd.value == "") {
		alert("Please select your date of birth.");
		Form.dob_yy.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.vacate_flag[1].checked && (Form.vacate_yy.value == "" || Form.vacate_mm.value == "" || Form.vacate_dd.value == "")) {
		alert("Please select your date of vacating residence unit.");
		Form.vacate_yy.focus();
		return false;
	}
	if (!Form.dorm[0].checked && !Form.dorm[1].checked) {
		alert("Please select Last place you lived in.");
		Form.dorm[0].focus();
		return false;
	}
	if (Form.room.value == "") {
		alert("Please input your Room No.");
		Form.room.focus();
		return false;
	}
	if (Form.old_period.value == "") {
		alert("Please select the last session you lived in residence hall.");
		Form.old_period.focus();
		return false;
	}
	if (!Form.refund_flag[0].checked && !Form.refund_flag[1].checked) {
		alert("Are you requesting a Refund or Change of Semester?");
		Form.refund_flag[0].focus();
		return false;
	}
	if (Form.refund_flag[1].checked && Form.new_period.value == "") {
		alert("Please select the semester you would like to change to.");
		Form.new_period.focus();
		return false;
	}
	if (Form.refund_flag[0].checked && !Form.method_type[0].checked && !Form.method_type[1].checked) {
	//if (Form.refund_flag[0].checked && !Form.method_type[0].checked && !Form.method_type[1].checked && !Form.method_type[2].checked) {
		alert("Please choose method of refund.");
		Form.method_type[0].focus();
		return false;
	}
	if (Form.method_type[0].checked) {
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
		if (Form.reason.value == "") {
			alert("Please input Reason for request refund.");
			Form.reason.focus();
			return false;
		}
		if (Form.photo.value != "" && !checkPhoto(Form.photo)) return false;
	/*
	} else if (Form.method_type[1].checked) {
		if (Form.method_info4.value == "") {
			alert("Please input name of recipient.");
			Form.method_info4.focus();
			return false;
		}
		if (Form.method_info5.value == "") {
			alert("Please input address.");
			Form.method_info5.focus();
			return false;
		}
	*/
	} else if (Form.method_type[1].checked) {
		if (Form.method_info7.value == "") {
			alert("Please input Bank Name.");
			Form.method_info7.focus();
			return false;
		}
		if (Form.method_info8.value == "") {
			alert("Please input Bank Code.");
			Form.method_info8.focus();
			return false;
		}
		if (Form.addr3.value == "") {
			alert("Please input Bank Address.");
			Form.addr3.focus();
			return false;
		}
		if (Form.method_info9.value == "") {
			alert("Please input Beneficiary¡¯s Account NO.");
			Form.method_info9.focus();
			return false;
		}
		if (Form.method_info10.value == "") {
			alert("Please input Name.");
			Form.method_info10.focus();
			return false;
		}
		if (Form.method_info11.value == "") {
			alert("Please input Passport NO.");
			Form.method_info11.focus();
			return false;
		}
		if (Form.addr4.value == "") {
			alert("Please input Home Address.");
			Form.addr4.focus();
			return false;
		}
		if (Form.method_info12.value == "") {
			alert("Please input Telephone NO.");
			Form.method_info12.focus();
			return false;
		}
		if (Form.country1.value == "") {
			alert("Please select Nationality.");
			Form.country1.focus();
			return false;
		}
		var flag = confirm("If the bank code is incorrect, transferred money could be held on an international intermediary bank. Please check it again.");
		if (flag) {
			Form.method_info1.value = Form.method_info7.value;
			Form.method_info2.value = Form.method_info8.value;
			Form.method_info3.value = Form.method_info9.value;
			Form.method_info4.value = Form.method_info10.value;
			Form.method_info5.value = Form.method_info11.value;
			Form.method_info6.value = Form.method_info12.value;
			Form.addr1.value = Form.addr3.value;
			Form.addr2.value = Form.addr4.value;
			Form.country.value = Form.country1.value;
		} else return false;
	}
	return true;
}

function checkRefundInfo1(Form) {
	/*
	var vacate_dt = Form.vacate_yy.value + "-" + Form.vacate_mm.value + "-" + Form.vacate_dd.value;
	if (Form.vacate_flag[1].checked && (Form.vacate_yy.value == "" || Form.vacate_mm.value == "" || Form.vacate_dd.value == "")) {
		alert("Please select your date of vacating residence unit.");
		Form.vacate_yy.focus();
		return false;
	}
	if (Form.vacate_flag[1].checked && vacate_dt < getToday()) {
		alert("Your vacated date is wrong");
		Form.vacate_yy.focus();
		return false;
	}
	if (!Form.refund_flag[0].checked && !Form.refund_flag[1].checked) {
		alert("Are you requesting a Refund or Change of Semester?");
		Form.refund_flag[0].focus();
		return false;
	}
	if (Form.refund_flag[1].checked && Form.cf_no.value == "") {
		alert("Please select an application number you would like to change to.");
		Form.cf_no.focus();
		return false;
	}
	if (Form.refund_flag[0].checked && !Form.method_type[0].checked && !Form.method_type[1].checked) {
	//if (Form.refund_flag[0].checked && !Form.method_type[0].checked && !Form.method_type[1].checked && !Form.method_type[2].checked) {
		alert("Please choose method of refund.");
		Form.method_type[0].focus();
		return false;
	}
	if (Form.method_type[0].checked) {
	*/
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
		if (Form.reason.value == "") {
			alert("Please input Reason for request refund.");
			Form.reason.focus();
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
	/*
	} else if (Form.method_type[1].checked) {
		if (Form.method_info4.value == "") {
			alert("Please input name of recipient.");
			Form.method_info4.focus();
			return false;
		}
		if (Form.method_info6.value == "") {
			alert("Please input name of mail recipient.");
			Form.method_info6.focus();
			return false;
		}
		if (Form.method_info5.value == "") {
			alert("Please input your address line 1.");
			Form.method_info5.focus();
			return false;
		}
		if (Form.city.value == "") {
			alert("Please input your city/town.");
			Form.city.focus();
			return false;
		}
		if (Form.country.value == "") {
			alert("Please select your country.");
			Form.country.focus();
			return false;
		}
	} else if (Form.method_type[1].checked) {
		if (Form.method_info7.value == "") {
			alert("Please input Bank Name.");
			Form.method_info7.focus();
			return false;
		}
		if (Form.method_info8.value == "") {
			alert("Please input Bank Code.");
			Form.method_info8.focus();
			return false;
		}
		if (Form.addr3.value == "") {
			alert("Please input Bank Address.");
			Form.addr3.focus();
			return false;
		}
		if (Form.method_info9.value == "") {
			alert("Please input Beneficiary¡¯s Account NO.");
			Form.method_info9.focus();
			return false;
		}
		if (Form.method_info10.value == "") {
			alert("Please input Name.");
			Form.method_info10.focus();
			return false;
		}
		if (Form.method_info11.value == "") {
			alert("Please input Passport NO.");
			Form.method_info11.focus();
			return false;
		}
		if (Form.addr4.value == "") {
			alert("Please input Home Address.");
			Form.addr4.focus();
			return false;
		}
		if (Form.method_info12.value == "") {
			alert("Please input Telephone NO.");
			Form.method_info12.focus();
			return false;
		}
		if (Form.country1.value == "") {
			alert("Please select Nationality.");
			Form.country1.focus();
			return false;
		}
		var flag = confirm("If the bank code is incorrect, transferred money could be held on an international intermediary bank. Please check it again.");
		if (flag) {
			Form.method_info1.value = Form.method_info7.value;
			Form.method_info2.value = Form.method_info8.value;
			Form.method_info3.value = Form.method_info9.value;
			Form.method_info4.value = Form.method_info10.value;
			Form.method_info5.value = Form.method_info11.value;
			Form.method_info6.value = Form.method_info12.value;
			Form.addr1.value = Form.addr3.value;
			Form.addr2.value = Form.addr4.value;
			Form.country.value = Form.country1.value;
		} else return false;
	}
	*/
	return true;
}