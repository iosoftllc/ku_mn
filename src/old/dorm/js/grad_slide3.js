var htmlstr3 = "", flag3 = false, imgflag3 = true, mouse3 = 1, speed3 = 2, temp3 = 0, amount3 = 119;
var ctnt3 = new Array();
var tflag3, pCount3 = 0, vtime3 = 3000;
var photo3 = new Array();
var img3 = new Array();
var desc3 = new Array();

function startText3() {
	for (i = 0; i < ctnt3.length; i++) {
		insertText3(i);
	}
}

function insertText3(i) {
	htmlstr3 = "<div id='scroll3_area" + i + "' style='top:12px;left:" + (width3 * i - 0) + "px;width:" + width3 + "px;position:absolute;'>\n";
	htmlstr3 += ctnt3[i]+'\n'+'</div>\n';
	document.write(htmlstr3);
}

function scroll3(param) {
	if (flag3) {
		for (i = 0; i < ctnt3.length; i++) {
			temp3++;
			tmp = document.getElementById('scroll3_area' + i).style;
			if (param == 'left') tmp.left = parseInt(tmp.left) + speed3;
			else if (param == 'right') tmp.left = parseInt(tmp.left) - speed3;
			if (parseInt(tmp.left) > 1) {
				if (i == 0) tmp3 = document.getElementById('scroll3_area1').style;
				else if (i == 1) tmp3 = document.getElementById('scroll3_area0').style;
				if (parseInt(tmp3.left) > 0) tmp3.left = width3 * (-1);
			}
			if (parseInt(tmp.left) <= width3 * (-1)) tmp.left = width3 * (ctnt3.length - 1);
			if (temp3 >= amount3) {
				flag3 = false;
				temp3 = 0;
			}
		}
		window.setTimeout("scroll3('"+param+"')", 1);
	}
}

function scroll3_left() {
	if (!flag3) {
		flag3 = true;
		scroll3('left');
	}
}

function scroll3_right() {
	if (!flag3) {
		flag3 = true;
		scroll3('right');
	}
}

function preload3() {
	for (i = 0; i < photo3.length; i++) {
		img3[i] = new Image();
		img3[i].src = photo3[i];
	}
}

function changeImage3(num) {
	var ns = (navigator.appName == "Netscape");
	var ie = (navigator.appName == "Microsoft Internet Explorer");
	if (ns) {
		document.getElementById("photo3Image").src = img3[num].src;
		document.getElementById("photo3Desc").innerHTML = desc3[num];
	} else if (ie) {
		//document.getElementById("photo3Image").filters.blendTrans.apply(); 
		//document.getElementById("photo3Image").filters.blendTrans.duration = 0.5;
		document.getElementById("photo3Image").src = img3[num].src;
		//document.getElementById("photo3Image").filters.blendTrans.play();   
		document.getElementById("photo3Desc").innerHTML = desc3[num];
	}
}

function viewSlide3() {
	pCount3++;
	if (pCount3 >= totalCount3) pCount3 = 0;
	changeImage3(pCount3);
	tflag3 = setTimeout("viewSlide3()", vtime3)
}

function stopSlide3() {
	clearTimeout(tflag3);
}

function viewNext3() {
	stopSlide3();
	if (pCount3 < 0) pCount3 = -1;
	if (pCount3 == totalCount3 - 1) pCount3 = -1;
	if (pCount3 < totalCount3 - 1) {
		pCount3++;
		changeImage3(pCount3);
	}
}

function viewPrevious3() {
	stopSlide3();
	if (pCount3 >= totalCount3) pCount3 = totalCount3;
	if (pCount3 <= 0) pCount3 = totalCount3;
	if (pCount3 > 0) {
		pCount3--;
		changeImage3(pCount3);
	}
}

function viewPhoto3(no) {
	stopSlide3();
	if (no) pCount3 = no;
	else pCount3 = 0;
	if (pCount3 >= totalCount3) pCount3 = totalCount3;
	if (pCount3 > 0) {
		pCount3--;
		changeImage3(pCount3);
	}
}