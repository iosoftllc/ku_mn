var total_attach = 1024 * 1024 * 1;

function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function gotoPage(Form, page) {
	if (page) {
		Form.page.value = page;
		Form.action = "../../src/faculty/room_list.php";
		Form.submit();
	}
}

function viewList(Form) {
	Form.s_type.value = "";
	Form.s_text.value = "";
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function viewFaculty(Form, no) {
	if (no) {
		Form.no.value = no;
		Form.action = "../../src/faculty/room_view.php";
		Form.submit();
	}
}

function checkSearchFaculty(Form) {
	var sdate, edate;
	Form.s_dorm.value = getSelectedValue(Form.list_dorm);
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!(Form.s_dorm.value || (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("검색기간이나 검색어를 입력해 주십시오.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("검색기간이 올바르지 않습니다.");
		return false;
	}
	return true;
}

function searchFaculty(Form) {
	if (checkSearchFaculty(Form)) {
		Form.action = "../../src/faculty/room_list.php";
		Form.submit();
	}
}

function postFaculty(Form, mode) {
	Form.mode.value = mode;
	Form.action = "../../src/faculty/room_post.php";
	Form.submit();
}

function checkFacultyInfo(Form) {
	var arr_dt, det_dt;
	if (!Form.fname.value || !Form.lname.value) {
		alert("이름을 입력하세요.");
		Form.lname.focus();
		return false;
	}
	if (Form.email.value && !checkEmail(Form.email)) return false;
	var arr_dt = Form.arr_dt.value;
	var det_dt = Form.det_dt.value;
	if (!(arr_dt.length == 10 && det_dt.length == 10)) {
		alert("거주기간을 선택해 주십시오.");
		return false;
	}
	if (arr_dt > det_dt) {
		alert("거주기간이 올바르지 않습니다.");
		return false;
	}
	if (!Form.rate.value) {
		alert("입실형태를 선택해 주십시오.");
		Form.rate.focus();
		return false;
	}
	if (!Form.no_room.value) {
		alert("방개수를 입력하세요.");
		Form.no_room.focus();
		return false;
	} else if (!checkNumber(Form.no_room.value)) {
		alert("방개수는 숫자만 입력가능합니다.");
		Form.no_room.focus();
		return false;
	}
	return true;
}

function submitFaculty(Form) {
	if (checkFacultyInfo(Form)) Form.submit();
}

function deleteFaculty(Form, no) {
	if (!no) no = getSelectedValue(Form.list_no);
	if (!no) alert("선택하신 온라인지원이 없습니다.");
	else {
		var flag = confirm("선택하신 온라인지원을 삭제 하시겠습니까?");
		if (flag) {
			Form.mode.value = "del";
			Form.no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function approveFaculty(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("결재를 승인 하시겠습니까?");
		else if (flag == "N") answer = confirm("결재를 취소 하시겠습니까?");
		if (answer) {
			if (flag == "Y") Form.mode.value = "approval_y";
			else if (flag == "N") Form.mode.value = "approval_n";
			Form.method = "post";
			Form.action = "../../src/faculty/room_action1.php";
			Form.submit();
		}
	}
}

function setDiscount(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("장기거주 할인을 하시겠습니까?");
		else if (flag == "N") answer = confirm("장기거주 미할인을 하시겠습니까?");
		if (answer) {
			Form.mode.value = "discount";
			Form.discount.value = flag;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function updateFee(Form) {
	if (Form.no.value) {
		Form.mode.value = "fee";
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function setRoom(Form, mode) {
	var flag;
	if (mode == "rm_new") {
		if (!Form.room_new.value) {
			alert("호실을 선택해 주세요.");
			Form.room_new.focus();
			return;
		}
		flag = confirm("호실을 추가 하시겠습니까?");
	} else if (mode == "rm_del") {
		if (!Form.room_del.value) {
			alert("호실을 선택해 주세요.");
			Form.room_del.focus();
			return;
		}
		flag = confirm("호실을 삭제 하시겠습니까?");
	}
	if (flag) {
		Form.mode.value = mode;
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function downloadExcel(Form) {
	if (!Form.purpose.value) {
		alert("사용목적을 입력하세요.");
		Form.purpose.focus();
		return;
	} else {
		Form.action = "../../src/faculty/room_excel.php";
		Form.submit();
	}
}

function downloadExcel1(Form) {
	Form.action = "../../src/faculty/room_excel1.php";
	Form.submit();
}

function checkPaymentInfo(Form) {
	if (!Form.pay_yy.value) {
		alert("년도를 선택하세요.");
		Form.pay_yy.focus();
		return false;
	}
	if (!Form.pay_mm.value) {
		alert("월을 선택하세요.");
		Form.pay_mm.focus();
		return false;
	}
	if (!Form.pay_dd.value) {
		alert("일을 선택하세요.");
		Form.pay_dd.focus();
		return false;
	}
	if (!Form.pay_type.value) {
		alert("종류을 선택하세요.");
		Form.pay_type.focus();
		return false;
	}
	if (!Form.detail.value) {
		alert("내용를 입력하세요.");
		Form.detail.focus();
		return false;
	}
	if (!Form.price.value) {
		alert("금액을 입력하세요.");
		Form.price.focus();
		return false;
	} else if (!checkNumber(Form.price.value)) {
		alert("금액은 숫자만 입력가능합니다.");
		Form.price.focus();
		return false;
	}
	return true;
}

function submitPayment(Form) {
	if (checkPaymentInfo(Form)) {
		Form.mode.value = "pay_new";
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function deletePayment(Form) {
	var no = getSelectedValue(Form.list_no);
	if (!no) alert("선택하신 입금내역이 없습니다.");
	else {
		var flag = confirm("선택하신 입금내역을 삭제 하시겠습니까?");
		if (flag) {
			Form.mode.value = "pay_del";
			Form.pay_no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function updatePayment(Form) {
	var no = getOneValue(Form.update_no);
	if (no == "" || no == "over") alert("선택하신 입금내역이 없습니다.");
	else if (checkPaymentInfo(Form)) {
		var flag = confirm("선택하신 입금내역을 수정 하시겠습니까?");
		if (flag) {
			Form.mode.value = "pay_edit";
			Form.pay_no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function showUpdateInfo(Form, radio, yy, mm, dd, detail, price) {
	if (radio.checked) {
		setSelected(Form.pay_yy, yy);
		setSelected(Form.pay_mm, mm);
		setSelected(Form.pay_dd, dd);
		setSelected(Form.detail, detail);
		Form.price.value = Math.abs(parseInt(price));
		if (parseInt(price) < 0) setSelected(Form.pay_type, "-");
		else setSelected(Form.pay_type, "+");
	}
}

function printReceipt(Form, no) {
	if (no) {
		var receipt_no = getSelectedValue(Form.list_receipt);
		if (!receipt_no) alert("선택하신 입금내역이 없습니다.");
		else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/receipt_f.php?no=" + no + "&receipt_no=" + receipt_no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=1150,height=800');
		}
	}
}

function printInvoice(Form, no) {
	if (no) {
		var invoice_no = getSelectedValue(Form.list_invoice);
		if (!invoice_no) alert("선택하신 입금내역이 없습니다.");
		else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_f.php?no=" + no + "&invoice_no=" + invoice_no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
	/*
	if (no) {
		if (Form.invoice_dt.value == "") {
			alert("인보이스 월을 선택해 주세요.");
			Form.invoice_dt.focus();
		} else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_f.php?no=" + no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
	*/
}

function viewRoomMail(Form, rate, room) {
	if (!rate) alert("아직 룸타입이 설정되어 있지 않습니다.");
	else if (!room) alert("아직 룸배정이 되어 있지 않습니다.");
	else if (rate && room) {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/room_mail_f.php?no=" + Form.no.value;
			popup = window.open(URL, '_roommail','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		}
	}
}

function copyRoomRate(Form) {
	if (Form.no.value) {
		if (!Form.rate.value) {
			alert("입실형태를 선택해 주십시오.");
			Form.rate.focus();
			return;
		}
		var flag = confirm("선택하신 입실형태로 객실예약을 복사하시겠습니까?");
		if (flag) {
			Form.mode.value = "copy";
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function gotoMonth(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/faculty/room_calendar.php";
		Form.submit();
	}
}

function checkAttachmentInfo(Form) {
	if (!checkAttachment(Form.attach)) return false;
	return true
}

function submitAttachment(Form) {
	if (checkAttachmentInfo(Form)) {
		Form.mode.value = "att_new";
		Form.submit();
	}
}

function deleteAttachment(Form) {
	var no = getSelectedValue(Form.list_att);
	if (!no) alert("선택하신 파일이 없습니다.");
	else {
		var flag = confirm("선택하신 파일을 삭제 하시겠습니까?");
		if (flag) {
			Form.mode.value = "att_del";
			Form.att_no.value = no;
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}