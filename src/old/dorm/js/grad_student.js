var total_attach = 1024 * 1024 * 1;

function gotoList(Form) {
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/graduate/list_app.php";
	Form.submit();
}

function checkStudentNumber(Form) {
	if (Form.id_year.value == "") {
		alert("Please select a year for Korea University Student number.");
		Form.id_year.focus();
		return;
	}
	if (Form.id_term.value == "") {
		alert("Please select a term for Korea University Student number.");
		Form.id_term.focus();
		return;
	}
	if (Form.id.value == "") {
		alert("Please input Korea University Student number.");
		Form.id.focus();
		return;
	}
	var url = "https://reslife.korea.ac.kr:5008/v1/src/apply/action_check.php?year=" + Form.id_year.value + "&term=" + Form.id_term.value + "&id=" + Form.id.value;
	window.open(url, "Check Student No.", "width=1,height=1,menubar=no,status=no,toolbar=no");
}

function setProvinceSelect(Form) {
	if (Form.nation.value == "South Korea (Republic Of Korea)") {
		Form.province.disabled = false;
		Form.province.focus();
	} else {
		Form.province.disabled = true;
		Form.province.value = "";
	}
}

function checkStudentInfo(Form) {
	if (Form.mode.value == "new" && !checkPassword(Form.new_pw, Form.confirm_pw)) return false;
	/*
	if (Form.id_year.value == "") {
		alert("Please select a year for Korea University Student number.");
		Form.id_year.focus();
		return false;
	}
	if (Form.id_term.value == "") {
		alert("Please select a term for Korea University Student number.");
		Form.id_term.focus();
		return false;
	}
	*/
	if (Form.id.value == "") {
		alert("Please input Korea University Student number.");
		Form.id.focus();
		return false;
	}
	if (Form.lname.value == "") {
		alert("Please input a Family Name/Surname.");
		Form.lname.focus();
		return false;
	}
	if (Form.fname.value == "") {
		alert("Please input a Given Name(s).");
		Form.fname.focus();
		return false;
	}
	if (Form.dob_yy.value == "" || Form.dob_mm.value == "" || Form.dob_dd.value == "") {
		alert("Please select your date of birth.");
		Form.dob_yy.focus();
		return false;
	}
	if (!Form.gender[0].checked && !Form.gender[1].checked) {
		alert("Please select your sex.");
		Form.gender[0].focus();
		return false;
	}
	if (Form.nation.value == "") {
		alert("Please select your nationality.");
		Form.nation.focus();
		return false;
	}
	if (Form.nation.value == "South Korea (Republic Of Korea)" && Form.province.value == "") {
		alert("시/도를 입력하세요.");
		Form.province.focus();
		return false;
	}
	if (Form.mode.value == "new" && !checkPhoto(Form.photo)) return false;
	if (Form.photo.value != "" && !checkPhoto(Form.photo)) return false;
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
	if (!Form.sclass[0].checked && !Form.sclass[1].checked && !Form.sclass[2].checked) {
		alert("Please select Undergraduate or Graduate.");
		Form.sclass[0].focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.home_addr.value == "") {
		alert("Please input your home address line 1.");
		Form.home_addr.focus();
		return false;
	}
	if (Form.home_city.value == "") {
		alert("Please input your home city/town.");
		Form.home_city.focus();
		return false;
	}
	if (Form.home_country.value == "") {
		alert("Please select your home country.");
		Form.home_country.focus();
		return false;
	}
	if (Form.phone.value == "") {
		alert("Please input your Home Phone Number.");
		Form.phone.focus();
		return false;
	}
	if (Form.case_addr.value == "") {
		alert("Please select a country.");
		Form.case_addr.focus();
		return false;
	}
	if (Form.case_ph.value == "") {
		alert("Please input a Phone Number with Country and Area codes.");
		Form.case_ph.focus();
		return false;
	}
	if (Form.case_nm.value == "") {
		alert("Please input a Contact Person’s Name.");
		Form.case_nm.focus();
		return false;
	}
	if (Form.case_rel.value == "") {
		alert("Please input a Relationship to You.");
		Form.case_rel.focus();
		return false;
	}
	if (!Form.agree_info[0].checked || !Form.agree_id[0].checked) {
		alert("You cannot issue an account if you do not agree with personal information use.");
		return false;
	}
	return true;
}

function checkViewInfo(Form) {
	if (Form.email.value == "") {
		alert("Please input your email address.");
		Form.email.focus();
		return false;
	}
	if (Form.pw.value == "") {
		alert("Please input a password.");
		Form.pw.focus();
		return false;
	}
	return true;
}

function checkDuplicateEmail(Form) {
	if (Form.email.value && !checkEmail(Form.email)) return;
	if (popup != null && !popup.closed) popup.close();
	var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/grad_check_email.php?email=" + Form.email.value;
	popup = window.open(URL, '_check','resizable=no,scrollbars=no,status=no,width=600,height=150');
}

function checkPasswordInfo(Form) {
	if (Form.cur_pw.value == "") {
		alert("Please input a current password.");
		Form.cur_pw.focus();
		Form.cur_pw.select();
		return false;
	}
	if (Form.cur_pw.value == Form.new_pw.value) {
		alert("A new password cannot be same as a current password.");
		Form.cur_pw.focus();
		Form.cur_pw.select();
		return false;
	}
	if (!checkPassword(Form.new_pw, Form.confirm_pw)) return false;
	return true;
}