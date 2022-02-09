/**
 * 초기화
 */
doNumber = function(){
	$('input:text').each(function(i) {
		if ($(this).hasClass('_number')) {
			$(this).keydown(function(e) {
				fnNumber($(this), e, 'number');
			}).keyup(function(e) {
				fnNumber($(this), e, 'number');
			}).blur(function(e) {
				fnNumber($(this), e, 'number');
			}).css('imeMode', 'disabled');
		}
		if ($(this).hasClass('_money')) {
			$(this).keydown(function(e) {
				fnNumber($(this), e, 'money');
			}).keyup(function(e) {
				fnNumber($(this), e, 'money');
			}).blur(function(e) {
				fnNumber($(this), e, 'money');
			}).css('imeMode', 'disabled');
		}
    });
};

/**
 * 키보드 입력 필터
 * 
 * @param obj
 * @param e
 * @param type
 */
fnNumber = function (obj, e, type) {
	if (e.which == '229' || e.which == '197' && $.browser.opera) {
		setInterval(function() {
			obj.trigger('keyup');
		}, 100);
	}

	// 허용키
	if (!(e.which
			&& (e.which > 47 && e.which < 58)
			|| e.which == 8 // Backspace
			|| e.which == 9 // Tab
			|| e.which == 0 
			|| e.which == 13 // Enter
			//|| e.which == 188 // , 
			|| e.which == 110 // . 
			|| e.which == 190 // . 
			|| e.which == 109 // -
			|| e.which == 189 // -
			|| e.which == 35 // Home
			|| e.which == 36 // End
			|| e.which == 37 // Left
			|| e.which == 38 // Top
			|| e.which == 39 // Right
			|| e.which == 40 // Down
			|| e.which == 46 // Del
			|| (e.ctrlKey && e.which == 67) // Ctrl + C
			//|| (e.ctrlKey && e.which == 86) // Ctrl + V
			|| (e.which >= 96 && e.which <= 105) // Keypad
		)) {
		e.preventDefault();
	}
	
	if (type == 'money') {
		var value = obj.val().match(/^[+-]?\d*(\.?\d*)$/g);

		if (value != null) {
			obj.val(fnComma(obj.val().split(',').join('')));
		} else {
			obj.val('');
		}
	} else {
		var value = obj.val().match(/[^0-9-.]/g);
		if (value != null) {
			obj.val(obj.val().replace(/[^0-9-.]/g, ''));
		}
	}
};

/**
 * 화폐단위 콤마 찍기
 * 
 * @param n
 * @returns
 */
fnComma = function(n) {
	var reg = /(\d+)(\d{3})/; // 숫자만 걸러내는 정규식
	n += ''; // 숫자를 문자열로 변환
	
	while (reg.test(n)) {
		n = n.replace(reg, '$1' + ',' + '$2');
	}
	return n;
};

/**
 * v가 숫자가 아니면 d를반환한다 (,를 제외하고 체크)
 * 
 * @param v
 * @param d
 * @returns
 */
fnNaN = function(v, d) {
	return isNaN(v == '' ? 'X' : v.replace('/,/g', '')) ? d : v.replace('/,/g', '');
};