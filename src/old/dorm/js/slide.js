var htmlstr = "", flag = false, imgflag = true, mouse = 1, speed = 2, wait = 500, temp = 0, amount = 119;
var ctnt = new Array(), count = 1;
var tflag, pCount = 0, vtime = 3000;
var photo = new Array();
var img = new Array();
var desc = new Array();

function startText() {
	for (i = 0; i < ctnt.length; i++) {
		insertText(i);
	}
}

function insertText(i) {
	htmlstr = "<div id='scroll_area" + i + "' style='top:12px;left:" + (width * i - 0) + "px;width:" + width + "px;position:absolute;'>\n";
	htmlstr += ctnt[i]+'\n'+'</div>\n';
	document.write(htmlstr);
}

function scroll(param) {
	if (flag) {
		for (i = 0; i < ctnt.length; i++) {
			temp++;
			tmp = document.getElementById('scroll_area' + i).style;
			if (param == 'left') tmp.left = parseInt(tmp.left) + speed;
			else if (param == 'right') tmp.left = parseInt(tmp.left) - speed;
			if (parseInt(tmp.left) > 1) {
				if (i == 0) tmp2 = document.getElementById('scroll_area1').style;
				else if (i == 1) tmp2 = document.getElementById('scroll_area0').style;
				if (parseInt(tmp2.left) > 0) tmp2.left = width * (-1);
			}
			if (parseInt(tmp.left) <= width * (-1)) tmp.left = width * (ctnt.length - 1);
			if (temp >= amount) {
				flag = false;
				temp = 0;
			}
		}
		window.setTimeout("scroll('"+param+"')", 1);
	}
}

function scroll_left() {
	if (!flag) {
		flag = true;
		scroll('left');
	}
}

function scroll_right() {
	if (!flag) {
		flag = true;
		scroll('right');
	}
}

function preload() {
	for (i = 0; i < photo.length; i++) {
		img[i] = new Image();
		img[i].src = photo[i];
	}
}

function changeImage(num) {
	var ns = (navigator.appName == "Netscape");
	var ie = (navigator.appName == "Microsoft Internet Explorer");
	if (ns) {
		document.getElementById("photoImage").src = img[num].src;
		document.getElementById("photoDesc").innerHTML = desc[num];
	} else if (ie) {
		document.getElementById("photoImage").filters.blendTrans.apply(); 
		document.getElementById("photoImage").filters.blendTrans.duration = 0.5;
		document.getElementById("photoImage").src = img[num].src;
		document.getElementById("photoImage").filters.blendTrans.play();   
		document.getElementById("photoDesc").innerHTML = desc[num];
	}
}

function viewSlide() {
	pCount++;
	if (pCount >= totalCount) pCount = 0;
	changeImage(pCount);
	tflag = setTimeout("viewSlide()", vtime)
}

function stopSlide() {
	clearTimeout(tflag);
}

function viewNext() {
	stopSlide();
	if (pCount < 0) pCount = -1;
	if (pCount == totalCount - 1) pCount = -1;
	if (pCount < totalCount - 1) {
		pCount++;
		changeImage(pCount);
	}
}

function viewPrevious() {
	stopSlide();
	if (pCount >= totalCount) pCount = totalCount;
	if (pCount <= 0) pCount = totalCount;
	if (pCount > 0) {
		pCount--;
		changeImage(pCount);
	}
}

function viewPhoto(no) {
	stopSlide();
	if (no) pCount = no;
	else pCount = 0;
	if (pCount >= totalCount) pCount = totalCount;
	if (pCount > 0) {
		pCount--;
		changeImage(pCount);
	}
}