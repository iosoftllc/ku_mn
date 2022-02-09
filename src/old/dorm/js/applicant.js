function generateSelectList(objParser, type) {
	var i = 0, strHTML = "", collDistricts = objParser.selectNodes( "//district" );
	switch (type) {
		case "rate1":
		case "rate2":
		case "rate3":
		case "rate4":
		case "rate5":
		case "rate6":
		case "rate7":
		case "rate8":
			strHTML += "<select id=\"" + type + "\" name=\"" + type + "\" style=\"color:#9B9EA3;\">\n";
			strHTML += "<option value=\"\">::::::: Choose Type of Room and Rates :::::::</option>\n";
			break;
	}
	for (i = 0; i < collDistricts.length; i++ ) {
		strHTML += "<option value=\"" + collDistricts.item(i).selectSingleNode("code").text + "\">";
		strHTML += collDistricts.item(i).selectSingleNode("dorm").text + " - " + collDistricts.item(i).selectSingleNode("name").text + " - " + collDistricts.item(i).selectSingleNode("price").text;
		strHTML += "</option>\n";
	}
	strHTML += "</select>\n";
	return strHTML;
}

function changeSelect(element) {
	var objParser = new ActiveXObject("Microsoft.XMLDOM");
	var type = element.name;
	var code = element.value;
	objParser.async = false;
	switch (type) {
		case "period":
			objParser.load("https://reslife.korea.ac.kr:5008/v1/src/apply/select.php?type=rate&code=" + code);
			for (i = 0; i < 7; i++ ) {
				document.getElementById("Level" + (i + 2)).innerHTML = generateSelectList(objParser, "rate" + (i + 1));
			}
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
	if (element.name != "rate") changeSelect(element)
}

function checkViewInfo(Form) {
	if (Form.view_no.value == "") {
		alert("Please input your application number.");
		Form.view_no.focus();
		return false;
	}
	if (Form.view_fname.value == "" || Form.view_lname.value == "") {
		alert("Please input your name.");
		Form.view_fname.focus();
		return false;
	}
	return true;
}

function checkApplyInfo(Form) {
	var today = getToday();
	/*
	if (today < "2006-05-22") {
		alert("Application period for Summer and Fall 2006 is May 22 through May 25.");
		return false;
	}
	if (today < "2006-07-10" || today > "2006-07-13") {
		alert("Late application period for overseas students on exchange programs is July 10 through July 13, 2006.");
		return false;
	}
	if (Form.current.value == "Y") {
		if (Form.student_no.value == "") {
			alert("Please input your Korea University Student ID Number.");
			Form.student_no.focus();
			return false;
		}
		if (Form.student_no.value.substr(0, 6) != "200695") {
			alert("Only exchange students can apply.");
			Form.student_no.focus();
			return false;
		}
		if (Form.apply_fname.value == "" || Form.apply_lname.value == "") {
			alert("Please input your name.");
			Form.apply_fname.focus();
			return false;
		}
	}
	*/
	if (Form.apply_no.value == "") {
		alert("Please input your application number.");
		Form.apply_no.focus();
		return false;
	}
	if (Form.apply_fname.value == "" || Form.apply_lname.value == "") {
		alert("Please input your name.");
		Form.apply_fname.focus();
		return false;
	}
	return true;
}

function checkApplicantInfo(Form) {
	if (Form.student.value == "") {
		alert("Please input Korea University Student ID number.");
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
	//if (Form.student.value.substr(0, 6) != "200695") {
		//alert("Only exchange students can apply.");
		//Form.student.focus();
		//return false;
	//}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("Please input your name.");
		Form.fname.focus();
		return false;
	}
	if (Form.nation.value.toLowerCase().match("korea") || Form.nation.value.match("rok") || Form.nation.value.match("한국")) {
		if (Form.name_kr.value == "") {
			alert("Please input your korean name.");
			Form.name_kr.focus();
			Form.name_kr.select();
			return false;
		}
	}
	if (Form.dob_yy.value == "" || Form.dob_mm.value == "" || Form.dob_dd.value == "") {
		alert("Please select your date of birth.");
		Form.dob_yy.focus();
		return false;
	}
	if (Form.nation.value == "") {
		alert("Please input your nationality.");
		Form.nation.focus();
		return false;
	}
	if (Form.home_uni.value == "") {
		alert("Please input your home university.");
		Form.home_uni.focus();
		return false;
	}
	if (Form.major.value == "") {
		alert("Please input your major.");
		Form.major.focus();
		return false;
	}
	if (Form.kind.value != "L") {
		if (!Form.sclass[0].checked && !Form.sclass[1].checked && !Form.sclass[2].checked && !Form.sclass[3].checked && !Form.sclass[4].checked) {
			alert("Please select class standing.");
			Form.sclass[0].focus();
			return false;
		}
	}
	if (Form.home_addr.value == "") {
		alert("Please input your home country mailing address.");
		Form.home_addr.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (!checkPhoto(Form.photo)) return false;
	if (Form.period && Form.rate) {
		if (!getOneValue(Form.period)) {
			alert("Please choose one of sessions applying.");
			return false;
		}
		if (!getOneValue(Form.rate)) {
			alert("Please choose one of types of room and rates.");
			return false;
		}
		//if (!checkRoomRateInfo(Form)) return false;
	}
	if (Form.case_nm.value == "") {
		alert("Please input a name of emergency contact.");
		Form.case_nm.focus();
		return false;
	}
	if (Form.case_rel.value == "") {
		alert("Please input a relationsip of emergency contact to you.");
		Form.case_rel.focus();
		return false;
	}
	if (Form.case_ph.value == "") {
		alert("Please input a phone number of emergency contact.");
		Form.case_ph.focus();
		return false;
	}
	if (Form.case_addr.value == "") {
		alert("Please input an address of emergency contact.");
		Form.case_addr.focus();
		return false;
	}
	if (Form.period.value == "") {
		alert("Please select session applying.");
		Form.period.focus();
		return false;
	}
	if (Form.rate1.value == "") {
		alert("Please select room type.");
		Form.rate1.focus();
		return false;
	}
	/*
	if (Form.gender[1].checked) {
		if (Form.rate1.value == "3BSS" || Form.rate1.value == "3BSD") {
			alert("Single in Quint & Double in Quint are not available for male students.\n\nPlease choose other room type.");
			Form.rate1.focus();
			return false;
		}
	}
	if (Form.nation.value.toLowerCase().match("korea") || Form.nation.value.match("rok") || Form.nation.value.match("한국")) {
		if (!(Form.student.value.length == 10 && (Form.student.value.substr(4, 2) == "95" || Form.student.value.substr(4, 2) == "96"))) {
			if (Form.rate1.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate1.focus();
				return false;
			}
			if (Form.rate2.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate2.focus();
				return false;
			}
			if (Form.rate3.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate3.focus();
				return false;
			}
			if (Form.rate4.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate4.focus();
				return false;
			}
			if (Form.rate5.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate5.focus();
				return false;
			}
			if (Form.rate6.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate6.focus();
				return false;
			}
			if (Form.rate7.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate7.focus();
				return false;
			}
			if (Form.rate8.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate8.focus();
				return false;
			}
		}
	}
	*/
	if (!Form.agree_flag.checked) {
		alert("In order to apply, you should agree to comply with the University Residence regulations.");
		Form.agree_flag.focus();
		return false;
	}
	//return false;
	return true;
}

function checkContractInfo(Form) {
	if (!Form.agree_flag.checked) {
		alert("In order to apply, you should agree to comply with the University Residence regulations.");
		Form.agree_flag.focus();
		return false;
	}
	return true;
}

function checkRoomRateInfo(Form) {
	if (Form.rate) {
		if (Form.period[0].checked) {
			var flag = false;
			for (i = 0; i < 7; i++) {
				if (Form.rate[i].checked) {
					flag = true;
					break;
				}
			}
			if (flag) {
				alert("The selected room and rate is only for Summer B Session.\n\nPlease choose again.");
				for (i = 0; i < 7; i++) {
					Form.rate[i].checked = false;
				}
				return false;
			}
			if (Form.rate[8].checked) {
				alert("The selected room and rate is only for Summer B Session.\n\nPlease choose again.");
				Form.rate[8].checked = false;
				return false;
			}
		} else if (Form.period[1].checked) {
			if (Form.rate[7].checked) {
				alert("The selected room and rate is only for Summer A Session.\n\nPlease choose again.");
				Form.rate[7].checked = false;
				return false;
			}
		}
	}
	return true;
}