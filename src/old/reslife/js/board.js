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
		alert("제목을 입력해 주십시오.");
		Form.subject.focus();
		return false;
	}
	if (Form.top[1].checked) {
		if (Form.top_yn.value != "Y") {
			alert("공지글 개수가 설정을 초과 하였습니다.");
			return false;
		}
	}
	if (Form.photo != null) {
		if (Form.photo.value != "" && !checkPhoto(Form.photo)) return false;
		calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
		if (Form.total_photo.value >= total_attach) {
			alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
			Form.photo.focus();
			return false;
		}
		if (Form.mode.value == "edit" && Form.att_del.checked) {
			var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
			if (!flag) return false;
		}
	}
	if (Form.content.value == "") {
		alert("내용을 입력해 주십시오.");
		Form.content.focus();
		return false;
	}
	return true;
}

function checkCommentInfo(Form) {
	if (!checkName(Form.cmt_name)) return false;
	if (Form.comment.value == "") {
		alert("내용을 입력해 주십시오.");
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
	if (no == "") alert("선택하신 게시물이 없습니다.");
	else {
		var flag = confirm("해당하는 댓글도 모두 삭제됩니다.\n\n선택하신 게시물을 삭제 하시겠습니까?");
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
	var flag = confirm("선택하신 댓글을 삭제 하시겠습니까?");
	if (flag) {
		document.BoardForm.mode.value = "cmt_del";
		document.BoardForm.cmt_no.value = no;
		document.BoardForm.method = "post";
		document.BoardForm.action = "../../src/board/action.php";
		document.BoardForm.submit();
	}
}