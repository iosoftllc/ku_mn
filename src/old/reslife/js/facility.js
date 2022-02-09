function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function gotoPage(Form, page) {
	if (page) {
		Form.page.value = page;
		Form.action = "../../src/faculty/fac_list.php";
		Form.submit();
	}
}

function viewList(Form) {
	Form.s_type.value = "";
	Form.s_text.value = "";
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function viewFacility(Form, no) {
	if (no) {
		Form.no.value = no;
		Form.action = "../../src/faculty/fac_view.php";
		Form.submit();
	}
}

function checkSearchFacility(Form) {
	var sdate, edate;
	Form.s_room.value = getSelectedValue(Form.list_room);
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!(Form.s_room.value || (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("검색기간이나 검색어를 입력해 주십시오.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("검색기간이 올바르지 않습니다.");
		return false;
	}
	return true;
}

function searchFacility(Form) {
	if (checkSearchFacility(Form)) {
		Form.action = "../../src/faculty/fac_list.php";
		Form.submit();
	}
}

function postFacility(Form, mode) {
	Form.mode.value = mode;
	Form.action = "../../src/faculty/fac_post.php";
	Form.submit();
}

function checkFacilityInfo(Form) {
	if (Form.event.value == "") {
		alert("이벤트명을 입력하세요.");
		Form.event.focus();
		return false;
	}
	if (Form.applicant.value == "") {
		alert("신청자를 입력하세요.");
		Form.applicant.focus();
		return false;
	}
	if (Form.department.value == "") {
		alert("고대부서를 입력하세요.");
		Form.department.focus();
		return false;
	}
	if (Form.position.value == "") {
		alert("고대직책을 입력하세요.");
		Form.position.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.phone.value == "") {
		alert("전화번호를 입력하세요.");
		Form.phone.focus();
		return false;
	}
	if (Form.event_dt.value == "") {
		alert("이벤트일을 선택해 주십시오.");
		Form.event_dt.focus();
		return false;
	}
	if (Form.event_h1.value == "" || Form.event_m1.value == "" || Form.event_h2.value == "" || Form.event_m2.value == "") {
		alert("이벤트시간을 선택해 주십시오.");
		Form.event_h1.focus();
		return false;
	}
	/*
	if (Form.event_h1.value > Form.event_h2.value) {
		alert("이벤트시간이 올바르지 않습니다.");
		Form.event_h1.focus();
		return false;
	}
	if (Form.event_h1.value == Form.event_h2.value && Form.event_m1.value >= Form.event_m2.value) {
		alert("이벤트시간이 올바르지 않습니다.");
		Form.event_h1.focus();
		return false;
	}
	*/
	if (Form.attendee.value == "") {
		alert("참석자수를 입력하세요.");
		Form.attendee.focus();
		return false;
	} else if (!checkNumber(Form.attendee.value)) {
		alert("참석자수는 숫자만 입력가능합니다.");
		Form.attendee.focus();
		return false;
	}
	if (!Form.request1.checked && !Form.request2.checked && !Form.request3.checked && !Form.request4.checked && !Form.request5.checked) {
		alert("최소한 한개 이상의 시설을 선택하세요.");
		return false;
	}
	return true;
}

function submitFacility(Form) {
	if (checkFacilityInfo(Form)) Form.submit();
}

function deleteFacility(Form, no) {
	if (!no) no = getSelectedValue(Form.list_no);
	if (!no) alert("선택하신 시설예약이 없습니다.");
	else {
		var flag = confirm("선택하신 시설예약을 삭제 하시겠습니까?");
		if (flag) {
			Form.mode.value = "del";
			Form.no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action.php";
			Form.submit();
		}
	}
}

function approveFacility(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("결재를 승인 하시겠습니까?");
		else if (flag == "N") answer = confirm("결재를 취소 하시겠습니까?");
		if (answer) {
			if (flag == "Y") Form.mode.value = "approval_y";
			else if (flag == "N") Form.mode.value = "approval_n";
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action1.php";
			Form.submit();
		}
	}
}

function updateFee(Form) {
	if (Form.no.value) {
		Form.mode.value = "fee";
		Form.method = "post";
		Form.action = "../../src/faculty/fac_action.php";
		Form.submit();
	}
}

function downloadExcel(Form) {
	if (!Form.purpose.value) {
		alert("사용목적을 입력하세요.");
		Form.purpose.focus();
		return;
	} else {
		Form.action = "../../src/faculty/fac_excel.php";
		Form.submit();
	}
}

function printReceipt(Form, state) {
	if (state != "PR") alert("예약상태가 Paid가 아닙니다.");
	else {
		if (Form.no.value) {
			//var item = getSelectedValue(Form.item);
			//if (!item) alert("선택하신 항목이 없습니다.");
			//else {
				if (popup != null && !popup.closed) popup.close();
				var URL = "../../src/popup/receipt_h.php?no=" + Form.no.value + "&item=";// + item;
				popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=1150,height=800');
			//}
		}
	}
}

function printInvoice(Form, state) {
	if (state != "CF") alert("예약상태가 Confirmed가 아닙니다.");
	else {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_h.php?no=" + Form.no.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
}

function viewRoomMail(Form, state) {
	//if (state != "AS") alert("예약상태가 Assigned가 아닙니다.");
	//else {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/room_mail_h.php?no=" + Form.no.value;
			popup = window.open(URL, '_roommail','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		}
	//}
}

function copyFacility(Form) {
	if (Form.no.value) {
		var flag = confirm("시설예약을 복사하시겠습니까?");
		if (flag) {
			Form.mode.value = "copy";
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action.php";
			Form.submit();
		}
	}
}

function gotoMonth(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/faculty/fac_calendar.php";
		Form.submit();
	}
}