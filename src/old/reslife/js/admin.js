function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "../../src/mail/list.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "../../src/mail/list.php";
	Form.submit();
}

function gotoPage(Form, page) {
	if (page) {
		Form.page.value = page;
		Form.action = "../../src/mail/list.php";
		Form.submit();
	}
}

function viewList(Form) {
	Form.page.value = "";
	Form.action = "../../src/mail/list.php";
	Form.submit();
}

function viewAdmin(Form, id) {
	if (id) {
		Form.id.value = id;
		Form.action = "../../src/mail/view.php";
		Form.submit();
	}
}

function searchAdmin(Form) {
	if (checkSearchInfo(Form.s_text, Form.page)) {
		Form.action = "../../src/mail/list.php";
		Form.submit();
	}
}

function postAdmin(Form, mode) {
	Form.mode.value = mode;
	Form.action = "../../src/mail/post.php";
	Form.submit();
}

function checkAdminInfo(Form) {
	if (Form.grade.value == "") {
		alert("관리자 등급을 선택하세요.");
		Form.grade.focus();
		return false;
	}
	if (Form.id != null && !checkID(Form.id)) return false;
	if (Form.pw != null && Form.confirm_pw != null && !checkPassword(Form.pw, Form.confirm_pw)) return false;
	if (!checkName(Form.name)) return false;
	if (Form.department.value == "") {
		alert("부서명을 입력하세요.");
		Form.department.focus();
		return false;
	}
	if (Form.email.value && !checkEmail(Form.email)) return false;
	return true;
}

function submitAdmin(Form) {
	if (checkAdminInfo(Form)) Form.submit();
}

function submitPassword(Form) {
	if (checkPassword(Form.pw, Form.confirm_pw)) Form.submit();
}

function deleteAdmin(Form, id) {
	if (!id) id = getSelectedValue(Form.list_no);
	if (!id) alert("선택하신 관리자가 없습니다.");
	else {
		var flag = confirm("선택하신 관리자를 삭제 하시겠습니까?");
		if (flag) {
			Form.mode.value = "del";
			Form.id.value = id;
			Form.method = "post";
			Form.action = "../../src/mail/action.php";
			Form.submit();
		}
	}
}

function checkDuplicateID(Form) {
	if (Form.mode.value == "new") {
		if (Form.id.value && !checkID(Form.id)) return;
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../src/popup/check_id.php?id=" + Form.id.value;
		popup = window.open(URL, '_checkid','resizable=no,scrollbars=no,status=no,width=450,height=150');
	}
}