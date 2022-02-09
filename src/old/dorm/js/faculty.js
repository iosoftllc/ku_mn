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

function printApplication(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/application_f.php?no=" + no;
		popup = window.open(URL, '_application','resizable=no,scrollbars=yes,status=no,width=700,height=500');
	}
}

function printInvoice(no) {
	//var today = getToday();
	//if (today < "2006-06-08") alert("Your billing statement for summer session will be available on June 8, 2006.");
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/invoice_f.php?no=" + no;
		popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=750');
	}
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
	return true;
}

function checkFacultyInfo(Form) {
	var arr_dt = Form.arr_dt.value;
	var det_dt = Form.det_dt.value;
	var term_dt = "", temp_dt = Form.arr_dt.value.split("-");
	var d = new Date(); 
	if (temp_dt[1] == "12") {
		d.setFullYear(parseInt(temp_dt[0]) + 1); 
		d.setMonth("0"); 
	} else {
		d.setFullYear(temp_dt[0]); 
		d.setMonth(temp_dt[1]); 
	}
	d.setDate(temp_dt[2]);
	term_dt += d.getFullYear() + "-";
	if (d.getMonth() < 9) term_dt += "0" + (d.getMonth() + 1);
	else term_dt += d.getMonth() + 1;
	if (d.getDate() < 10) term_dt += "-0" + d.getDate();
	else term_dt += "-" + d.getDate();
	if (!Form.title[0].checked && !Form.title[1].checked && !Form.title[2].checked) {
		alert("Please select a title.");
		Form.title[0].focus();
		return false;
	}
	//if (!Form.fname.value || !Form.lname.value) {
	if (!Form.fname.value && !Form.lname.value && !Form.mname.value) {
		alert("Please input your name.");
		Form.lname.focus();
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
	/*
	if (Form.term.value == "L") {
		if (!Form.employ.value) {
			alert("Please input Korea Uni. Employee No.(고대교직원번호)");
			Form.employ.focus();
			return false;
		}
	}
	*/
	if (!Form.purpose.value) {
		alert("Please input Purpose of Stay.");
		Form.purpose.focus();
		return false;
	}
	if (!Form.kdepart.value) {
		alert("Please input Deptartment at Korea University.");
		Form.kdepart.focus();
		return false;
	}
	if (!Form.kpos.value) {
		alert("Please input Position at Korea University.");
		Form.kpos.focus();
		return false;
	}
	if (Form.term.value == "L") {
		if (!Form.hdepart.value) {
			alert("Please input Organization Held at Home Country.");
			Form.hdepart.focus();
			return false;
		}
		if (!Form.hpos.value) {
			alert("Please input Position Held at Home Country.");
			Form.hpos.focus();
			return false;
		}
	}
	if (!Form.nation.value) {
		alert("Please select your nationality.");
		Form.nation.focus();
		return false;
	}
	if (Form.term.value == "L") {
		if (!Form.dob_yy.value || !Form.dob_mm.value || !Form.dob_dd.value) {
			alert("Please select your date of birth.");
			Form.dob_yy.focus();
			return false;
		}
		if (!Form.country.value) {
			alert("Please input your country.");
			Form.country.focus();
			return false;
		}
	}
	if (!checkEmail(Form.email)) return false;
	/*
	if (!Form.phone.value) {
		alert("Please input your Telephone number.");
		Form.phone.focus();
		return false;
	}
	*/
	if (!(arr_dt.length == 10 && det_dt.length == 10)) {
		alert("Please select Staying Period.");
		return false;
	}
	if (arr_dt >= det_dt) {
		alert("Staying Period is not correct.");
		return false;
	}
	if (Form.term.value == "S") {
		if (det_dt >= term_dt) {
			alert("Staying Period must be under 1 month.");
			return false;
		}
	} else if (Form.term.value == "L") {
		if (det_dt < term_dt) {
			alert("Staying Period must be over 1 month.");
			return false;
		}
	}
	if (!Form.pay[0].checked && !Form.pay[1].checked) {
		alert("Please select a Method of Payment.");
		Form.pay[0].focus();
		return false;
	}
	if (!Form.rate.value) {
		alert("Please select a type of room.");
		Form.rate.focus();
		return false;
	}
	if (!Form.no_room.value) {
		alert("Please input a number of rooms.");
		Form.no_room.focus();
		return false;
	} else if (!checkNumber(Form.no_room.value)) {
		alert("A number of rooms only allows a numeric letter.");
		Form.no_room.focus();
		return false;
	}
	if (!Form.rfname.value || !Form.rlname.value) {
		alert("Please input reference name.");
		Form.rlname.focus();
		return false;
	}
	if (!Form.rdepart.value) {
		alert("Please input Reference's Organization Held.");
		Form.rdepart.focus();
		return false;
	}
	if (!Form.rpos.value) {
		alert("Please input Reference's Position Held.");
		Form.rpos.focus();
		return false;
	}
	if (!checkEmail(Form.remail)) return false;
	if (!Form.rphone.value) {
		alert("Please input Reference's Telephone number.");
		Form.rphone.focus();
		return false;
	}
	if (!Form.agree_flag.checked) {
		alert("In order to apply, you should agree to comply with the University Residence regulations.");
		Form.agree_flag.focus();
		return false;
	}
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