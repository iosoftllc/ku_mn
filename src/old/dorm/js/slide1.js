var htmlstr1 = "", flag1 = false, imgflag1 = true, mouse1 = 1, speed1 = 2, temp1 = 0, amount1 = 119;
var ctnt1 = new Array();
var tflag1, pCount1 = 0, vtime1 = 3000;
var photo1 = new Array();
var img1 = new Array();
var desc1 = new Array();

function startText1() {
	for (i = 0; i < ctnt1.length; i++) {
		insertText1(i);
	}
}

function insertText1(i) {
	htmlstr1 = "<div id='scroll1_area" + i + "' style='top:12px;left:" + (width1 * i - 0) + "px;width:" + width1 + "px;position:absolute;'>\n";
	htmlstr1 += ctnt1[i]+'\n'+'</div>\n';
	document.write(htmlstr1);
}

function scroll1(param) {
	if (flag1) {
		for (i = 0; i < ctnt1.length; i++) {
			temp1++;
			tmp = document.getElementById('scroll1_area' + i).style;
			if (param == 'left') tmp.left = parseInt(tmp.left) + speed1;
			else if (param == 'right') tmp.left = parseInt(tmp.left) - speed1;
			if (parseInt(tmp.left) > 1) {
				if (i == 0) tmp2 = document.getElementById('scroll1_area1').style;
				else if (i == 1) tmp2 = document.getElementById('scroll1_area0').style;
				if (parseInt(tmp2.left) > 0) tmp2.left = width1 * (-1);
			}
			if (parseInt(tmp.left) <= width1 * (-1)) tmp.left = width1 * (ctnt1.length - 1);
			if (temp1 >= amount1) {
				flag1 = false;
				temp1 = 0;
			}
		}
		window.setTimeout("scroll1('"+param+"')", 1);
	}
}

function scroll1_left() {
	if (!flag1) {
		flag1 = true;
		scroll1('left');
	}
}

function scroll1_right() {
	if (!flag1) {
		flag1 = true;
		scroll1('right');
	}
}

function preload1() {
	for (i = 0; i < photo1.length; i++) {
		img1[i] = new Image();
		img1[i].src = photo1[i];
	}
}

function changeImage1(num) {
	var ns = (navigator.appName == "Netscape");
	var ie = (navigator.appName == "Microsoft Internet Explorer");
	if (ns) {
		document.getElementById("photo1Image").src = img1[num].src;
		document.getElementById("photo1Desc").innerHTML = desc1[num];
	} else if (ie) {
		//document.getElementById("photo1Image").filters.blendTrans.apply(); 
		//document.getElementById("photo1Image").filters.blendTrans.duration = 0.5;
		document.getElementById("photo1Image").src = img1[num].src;
		//document.getElementById("photo1Image").filters.blendTrans.play();   
		document.getElementById("photo1Desc").innerHTML = desc1[num];
	}
}

function viewSlide1() {
	pCount1++;
	if (pCount1 >= totalCount1) pCount1 = 0;
	changeImage1(pCount1);
	tflag1 = setTimeout("viewSlide1()", vtime1)
}

function stopSlide1() {
	clearTimeout(tflag1);
}

function viewNext1() {
	stopSlide1();
	if (pCount1 < 0) pCount1 = -1;
	if (pCount1 == totalCount1 - 1) pCount1 = -1;
	if (pCount1 < totalCount1 - 1) {
		pCount1++;
		changeImage1(pCount1);
	}
}

function viewPrevious1() {
	stopSlide1();
	if (pCount1 >= totalCount1) pCount1 = totalCount1;
	if (pCount1 <= 0) pCount1 = totalCount1;
	if (pCount1 > 0) {
		pCount1--;
		changeImage1(pCount1);
	}
}

function viewPhoto1(no) {
	stopSlide1();
	if (no) pCount1 = no;
	else pCount1 = 0;
	if (pCount1 >= totalCount1) pCount1 = totalCount1;
	if (pCount1 > 0) {
		pCount1--;
		changeImage1(pCount1);
	}
}