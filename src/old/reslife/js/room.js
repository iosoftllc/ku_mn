function sortList(val) {
	var dir = "ASC";
	if (document.RoomForm.sort2.value == "ASC") dir = "DESC";
	document.RoomForm.sort1.value = val;
	document.RoomForm.sort2.value = dir;
	document.RoomForm.action = "../../src/apply/room_list.php";
	document.RoomForm.submit();
}

function gotoList() {
	document.RoomForm.action = "../../src/apply/room_list.php";
	document.RoomForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.RoomForm.page.value = page;
		document.RoomForm.action = "../../src/apply/room_list.php";
		document.RoomForm.submit();
	}
}

function viewList() {
	document.RoomForm.s_type.value = "";
	document.RoomForm.s_text.value = "";
	document.RoomForm.action = "../../src/apply/room_list.php";
	document.RoomForm.submit();
}

function searchRoom(Form) {
	document.RoomForm.action = "../../src/apply/room_list.php";
	document.RoomForm.submit();
}

function postRoom(code) {
	if (code != "") {
		document.RoomForm.code.value = code;
		document.RoomForm.action = "../../src/apply/room_post.php";
		document.RoomForm.submit();
	}
}

function checkRoomInfo(Form) {
	if (Form.phone.value == "") {
		alert("전화번호를 입력하세요.");
		Form.phone.focus();
		return false;
	}
	if (Form.ip.value == "") {
		alert("IP주소를 입력하세요.");
		Form.ip.focus();
		return false;
	}
	return true;
}

function submitRoom(Form) {
	if (checkRoomInfo(Form)) Form.submit();
}

function downloadExcel() {
	document.RoomForm.action = "../../src/apply/room_excel.php";
	document.RoomForm.submit();
}