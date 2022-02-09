function checkViewInfo(Form) {
	if (Form.view_no.value == "") {
		alert("Please input your application number.");
		Form.view_no.focus();
		return false;
	}
	if (Form.view_event.value == "") {
		alert("Please input a name of event.");
		Form.view_event.focus();
		return false;
	}
	return true;
}

function printApplication(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/application_h.php?no=" + no;
		popup = window.open(URL, '_application','resizable=no,scrollbars=yes,status=no,width=700,height=500');
	}
}

function printInvoice(no) {
	//var today = getToday();
	//if (today < "2006-06-08") alert("Your billing statement for summer session will be available on June 8, 2006.");
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/invoice_h.php?no=" + no;
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
		if (Form.apply_hname.value == "" || Form.apply_lname.value == "") {
			alert("Please input your name.");
			Form.apply_fname.focus();
			return false;
		}
	}
	*/
	return true;
}

function checkFacilityInfo(Form) {
	if (Form.event.value == "") {
		alert("Please input a name of evnet.");
		Form.event.focus();
		return false;
	}
	if (Form.applicant.value == "") {
		alert("Please input an orgenization/individual.");
		Form.applicant.focus();
		return false;
	}
	if (!Form.resident[0].checked && !Form.resident[1].checked) {
		alert("Please select a resident.");
		Form.resident[0].focus();
		return false;
	}
	if (Form.department.value == "") {
		alert("Please input a department at Korea University.");
		Form.department.focus();
		return false;
	}
	if (Form.position.value == "") {
		alert("Please input a position at Korea University.");
		Form.position.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.phone.value == "") {
		alert("Please input a telephone number.");
		Form.phone.focus();
		return false;
	}
	if (Form.event_dt.value == "") {
		alert("Please select a date of evnet.");
		Form.event_dt.focus();
		return false;
	}
	if (Form.event_h1.value == "" || Form.event_m1.value == "" || Form.event_h2.value == "" || Form.event_m2.value == "") {
		alert("Please select hours of event.");
		Form.event_h1.focus();
		return false;
	}
	/*
	if (Form.event_h1.value > Form.event_h2.value) {
		alert("Hours of evnet is not correnct.");
		Form.event_h1.focus();
		return false;
	}
	if (Form.event_h1.value == Form.event_h2.value && Form.event_m1.value >= Form.event_m2.value) {
		alert("Hours of evnet is not correnct.");
		Form.event_h1.focus();
		return false;
	}
	*/
	if (Form.attendee.value == "") {
		alert("Please input an estimated number of attendees.");
		Form.attendee.focus();
		return false;
	} else if (!checkNumber(Form.attendee.value)) {
		alert("An estimated number of attendees only allows a numeric letter.");
		Form.attendee.focus();
		return false;
	}
	if (!Form.breakfast[0].checked && !Form.breakfast[1].checked) {
		alert("Please select a Conference Breakfast Package.");
		Form.breakfast[0].focus();
		return false;
	}
	//if (!Form.request1.checked && !Form.request2.checked && !Form.request3.checked && !Form.request4.checked && !Form.request5.checked) {
	if (!Form.request1.checked && !Form.request2.checked && !Form.request3.checked) {
		alert("Please select at least one room requested.");
		return false;
	}
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