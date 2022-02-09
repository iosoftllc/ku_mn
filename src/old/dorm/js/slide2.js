var htmlstr2 = "", flag2 = false, imgflag2 = true, mouse2 = 1, speed2 = 2, temp2 = 0, amount2 = 119;
var ctnt2 = new Array();
var tflag2, pCount2 = 0, vtime2 = 3000;
var photo2 = new Array();
var img2 = new Array();
var desc2 = new Array();

function startText2() {
	for (i = 0; i < ctnt2.length; i++) {
		insertText2(i);
	}
}

function insertText2(i) {
	htmlstr2 = "<div id='scroll2_area" + i + "' style='top:12px;left:" + (width2 * i - 0) + "px;width:" + width2 + "px;position:absolute;'>\n";
	htmlstr2 += ctnt2[i]+'\n'+'</div>\n';
	document.write(htmlstr2);
}

function scroll2(param) {
	if (flag2) {
		for (i = 0; i < ctnt2.length; i++) {
			temp2++;
			tmp = document.getElementById('scroll2_area' + i).style;
			if (param == 'left') tmp.left = parseInt(tmp.left) + speed2;
			else if (param == 'right') tmp.left = parseInt(tmp.left) - speed2;
			if (parseInt(tmp.left) > 1) {
				if (i == 0) tmp2 = document.getElementById('scroll2_area1').style;
				else if (i == 1) tmp2 = document.getElementById('scroll2_area0').style;
				if (parseInt(tmp2.left) > 0) tmp2.left = width2 * (-1);
			}
			if (parseInt(tmp.left) <= width2 * (-1)) tmp.left = width2 * (ctnt2.length - 1);
			if (temp2 >= amount2) {
				flag2 = false;
				temp2 = 0;
			}
		}
		window.setTimeout("scroll2('"+param+"')", 1);
	}
}

function scroll2_left() {
	if (!flag2) {
		flag2 = true;
		scroll2('left');
	}
}

function scroll2_right() {
	if (!flag2) {
		flag2 = true;
		scroll2('right');
	}
}

function preload2() {
	for (i = 0; i < photo2.length; i++) {
		img2[i] = new Image();
		img2[i].src = photo2[i];
	}
}

function changeImage2(num) {
	var ns = (navigator.appName == "Netscape");
	var ie = (navigator.appName == "Microsoft Internet Explorer");
	if (ns) {
		document.getElementById("photo2Image").src = img2[num].src;
		document.getElementById("photo2Desc").innerHTML = desc2[num];
	} else if (ie) {
		//document.getElementById("photo2Image").filters.blendTrans.apply(); 
		//document.getElementById("photo2Image").filters.blendTrans.duration = 0.5;
		document.getElementById("photo2Image").src = img2[num].src;
		//document.getElementById("photo2Image").filters.blendTrans.play();   
		document.getElementById("photo2Desc").innerHTML = desc2[num];
	}
}

function viewSlide2() {
	pCount2++;
	if (pCount2 >= totalCount2) pCount2 = 0;
	changeImage2(pCount2);
	tflag2 = setTimeout("viewSlide2()", vtime2)
}

function stopSlide2() {
	clearTimeout(tflag2);
}

function viewNext2() {
	stopSlide2();
	if (pCount2 < 0) pCount2 = -1;
	if (pCount2 == totalCount2 - 1) pCount2 = -1;
	if (pCount2 < totalCount2 - 1) {
		pCount2++;
		changeImage2(pCount2);
	}
}

function viewPrevious2() {
	stopSlide2();
	if (pCount2 >= totalCount2) pCount2 = totalCount2;
	if (pCount2 <= 0) pCount2 = totalCount2;
	if (pCount2 > 0) {
		pCount2--;
		changeImage2(pCount2);
	}
}

function viewPhoto2(no) {
	stopSlide2();
	if (no) pCount2 = no;
	else pCount2 = 0;
	if (pCount2 >= totalCount2) pCount2 = totalCount2;
	if (pCount2 > 0) {
		pCount2--;
		changeImage2(pCount2);
	}
}