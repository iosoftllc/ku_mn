var total_attach = 1024 * 1024 * 1;

function sortList(val) {
	var dir = "ASC";
	if (document.StudentForm.sort2.value == "ASC") dir = "DESC";
	document.StudentForm.sort1.value = val;
	document.StudentForm.sort2.value = dir;
	document.StudentForm.action = "../../src/graduate/stu_list.php";
	document.StudentForm.submit();
}

function gotoList() {
	document.StudentForm.action = "../../src/graduate/stu_list.php";
	document.StudentForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.StudentForm.page.value = page;
		document.StudentForm.action = "../../src/graduate/stu_list.php";
		document.StudentForm.submit();
	}
}

function viewList() {
	document.StudentForm.s_type.value = "";
	document.StudentForm.s_text.value = "";
	document.StudentForm.action = "../../src/graduate/stu_list.php";
	document.StudentForm.submit();
}

function viewStudent(no) {
	if (no != "") {
		document.StudentForm.no.value = no;
		document.StudentForm.action = "../../src/graduate/stu_view.php";
		document.StudentForm.submit();
	}
}

function checkSearchStudent(Form) {
	var sdate, edate;
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!((Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("검색기간이나 검색어를 입력해 주십시오.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("검색기간이 올바르지 않습니다.");
		return false;
	}
	return true;
}

function searchStudent(Form) {
	if (checkSearchStudent(Form)) {
		document.StudentForm.action = "../../src/graduate/stu_list.php";
		document.StudentForm.submit();
	}
}

function postStudent(mode) {
	document.StudentForm.mode.value = mode;
	document.StudentForm.action = "../../src/graduate/stu_post.php";
	document.StudentForm.submit();
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
	if (Form.id.value == "") {
		alert("학번을 입력하세요.");
		Form.id.focus();
		return false;
	}
	if (Form.id.value.length != 10) {
		alert("학번은 반드시 10자리이여야 합니다.");
		Form.id.focus();
		return false;
	}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("이름을 입력하세요.");
		Form.fname.focus();
		return false;
	}
	if (Form.nation.value == "South Korea (Republic Of Korea)" && Form.province.value == "") {
		alert("시/도를 입력하세요.");
		Form.province.focus();
		return false;
	}
	if (Form.photo.value && !checkPhoto(Form.photo)) return false;
	calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.photo.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.pht_del.checked) {
		var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
		if (!flag) return false;
	}
	if (Form.mode.value == "new" && !checkPassword(Form.pw, Form.confirm_pw)) return false;
	return true;
}

function submitStudent(Form) {
	if (checkStudentInfo(Form)) Form.submit();
}

function submitPassword(Form) {
	if (checkPassword(Form.pw, Form.confirm_pw)) Form.submit();
}

function deleteStudent(no) {
	if (no == "") no = getSelectedValue(document.StudentForm.list_no);
	if (no == "") alert("선택하신 학생이 없습니다.");
	else {
		var flag = confirm("선택하신 학생을 삭제 하시겠습니까?");
		if (flag) {
			document.StudentForm.mode.value = "del";
			document.StudentForm.no.value = no;
			document.StudentForm.method = "post";
			document.StudentForm.action = "../../src/graduate/stu_action.php";
			document.StudentForm.submit();
		}
	}
}

function downloadExcel() {
	if (!document.StudentForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.StudentForm.purpose.focus();
		return;
	} else {
		document.StudentForm.action = "../../src/graduate/stu_excel.php";
		document.StudentForm.submit();
	}
}

function showPhotoList() {
	if (!document.StudentForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.StudentForm.purpose.focus();
		return;
	} else {
		PHOTO_LIST = window.open('', 'PHOTO_LIST','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		PHOTO_LIST.focus();
		document.StudentForm.target = "PHOTO_LIST";
		document.StudentForm.action = "../../src/popup/grad_stu_photo.php";
		document.StudentForm.submit();
	}
}

function checkDuplicateEmail(Form) {
	if (Form.email.value && !checkEmail(Form.email)) return;
	if (popup != null && !popup.closed) popup.close();
	var URL = "../../src/popup/grad_check_email.php?email=" + Form.email.value;
	popup = window.open(URL, '_check','resizable=no,scrollbars=no,status=no,width=600,height=150');
}