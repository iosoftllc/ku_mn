function gotoPage(page) {
	if (page != "") {
		document.BoardForm.page.value = page;
		document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/list.php";
		document.BoardForm.submit();
	}
}

function gotoList() {
	document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/list.php";
	document.BoardForm.submit();
}

function viewBoard(no) {
	if (no != "") {
		document.BoardForm.no.value = no;
		document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/view.php";
		document.BoardForm.submit();
	}
}

function postBoard(mode) {
	document.BoardForm.mode.value = mode;
	document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/post.php";
	document.BoardForm.submit();
}

function checkBoardInfo(Form) {
	if (!checkName(Form.name)) return false;
	if (!checkPassword(Form.pw, Form.pw)) return false;
	if (Form.email.value != "" && !checkEmail(Form.email)) return false;
	if (Form.subject.value == "") {
		alert("Please input subject.");
		Form.subject.focus();
		return false;
	}
	if (Form.photo != null) {
		if (Form.photo.value != "" && !checkPhoto(Form.photo)) return false;
	}
	if (Form.content.value == "") {
		alert("Please input content.");
		Form.content.focus();
		return false;
	}
	return true;
}

function checkCommentInfo(Form) {
	if (!checkName(Form.cmt_name)) return false;
	if (!checkPassword(Form.cmt_pw, Form.cmt_pw)) return false;
	if (Form.comment.value == "") {
		alert("Please input content.");
		Form.comment.focus();
		return false;
	}
	Form.mode.value = "cmt_new";
	return true;
}

function deleteBoard(no) {
	if (no != "") {
		var flag = confirm("All the correspondant comments will be deleted together.\n\nWould you like to delete a board?");
		if (flag) {
			document.BoardForm.mode.value = "del";
			document.BoardForm.no.value = no;
			document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/passwd.php";
			document.BoardForm.submit();
		}
	}
}

function deleteComment(no) {
	if (no != "") {
		var flag = confirm("Would you like to delete a comment?");
		if (flag) {
			document.BoardForm.mode.value = "cmt_del";
			document.BoardForm.cmt_no.value = no;
			document.BoardForm.action = "https://reslife.korea.ac.kr:5008/v1/src/board/passwd.php";
			document.BoardForm.submit();
		}
	}
}