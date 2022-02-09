function gotoPage(page) {
	if (page != "") {
		document.BoardForm.page.value = page;
		document.BoardForm.action = "../../src/board/list.php";
		document.BoardForm.submit();
	}
}

function gotoList() {
	document.BoardForm.action = "../../src/board/list.php";
	document.BoardForm.submit();
}

function viewBoard(no) {
	if (no != "") {
		document.BoardForm.no.value = no;
		document.BoardForm.action = "../../src/board/view.php";
		document.BoardForm.submit();
	}
}

function searchBoard () {
	if (checkSearchInfo(document.BoardForm.s_text, document.BoardForm.page)) {
		document.BoardForm.action = "../../src/board/list.php";
		document.BoardForm.submit();
	}
}

function postBoard(mode) {
	document.BoardForm.mode.value = mode;
	document.BoardForm.action = "../../src/board/post.php";
	document.BoardForm.submit();
}

function checkBoardInfo(Form) {
	if (!checkName(Form.name)) return false;
	if (Form.email.value != "" && !checkEmail(Form.email)) return false;
	if (Form.subject.value == "") {
		alert("������ �Է��� �ֽʽÿ�.");
		Form.subject.focus();
		return false;
	}
	if (Form.top[1].checked) {
		if (Form.top_yn.value != "Y") {
			alert("������ ������ ������ �ʰ� �Ͽ����ϴ�.");
			return false;
		}
	}
	if (Form.photo != null) {
		if (Form.photo.value != "" && !checkPhoto(Form.photo)) return false;
		calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
		if (Form.total_photo.value >= total_attach) {
			alert("÷���� �� �ִ� �뷮�� �ִ� " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)���� �����մϴ�.");
			Form.photo.focus();
			return false;
		}
		if (Form.mode.value == "edit" && Form.att_del.checked) {
			var flag = confirm("�����Ͻ� ÷�λ����� ���� �Ͻðڽ��ϱ�?");
			if (!flag) return false;
		}
	}
	if (Form.content.value == "") {
		alert("������ �Է��� �ֽʽÿ�.");
		Form.content.focus();
		return false;
	}
	return true;
}

function checkCommentInfo(Form) {
	if (!checkName(Form.cmt_name)) return false;
	if (Form.comment.value == "") {
		alert("������ �Է��� �ֽʽÿ�.");
		Form.comment.focus();
		return false;
	}
	return true;
}

function saveBoard(Form) {
	if (checkBoardInfo(Form)) Form.submit();
}

function saveComment(Form) {
	if (checkCommentInfo(Form)) {
		Form.mode.value = "cmt_new";
		Form.method = "post";
		Form.action = "../../src/board/action.php";
		Form.submit();
	}
}

function deleteBoard(no) {
	if (no == "") no = getSelectedValue(document.BoardForm.list_no);
	if (no == "") alert("�����Ͻ� �Խù��� �����ϴ�.");
	else {
		var flag = confirm("�ش��ϴ� ��۵� ��� �����˴ϴ�.\n\n�����Ͻ� �Խù��� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			document.BoardForm.mode.value = "del";
			document.BoardForm.no.value = no;
			document.BoardForm.method = "post";
			document.BoardForm.action = "../../src/board/action.php";
			document.BoardForm.submit();
		}
	}
}

function deleteComment(no) {
	var flag = confirm("�����Ͻ� ����� ���� �Ͻðڽ��ϱ�?");
	if (flag) {
		document.BoardForm.mode.value = "cmt_del";
		document.BoardForm.cmt_no.value = no;
		document.BoardForm.method = "post";
		document.BoardForm.action = "../../src/board/action.php";
		document.BoardForm.submit();
	}
}