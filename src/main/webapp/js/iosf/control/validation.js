/**
 * 유효성검사 도입부
 */
doValidation = function(f){
	var ret = true;
	
	if (f.tagName == 'FORM') {
		$(f).find('input,textarea,select').each(function(i) {
			if (!fnValidation($(this), false)) {
				ret = false;
				return false;
			}
		});
	} else {
		for (var i = 0 ; i < f.length ; i ++) {
			if (!fnValidation($('#' + f[i]), true)) {
				ret = false;
				return false;
			}
		}
	}
	
	return ret;
};

/**
 * 유효성검사 로직
 * 
 * @param o : 오브젝트
 * @param req : 강제 필수체크 여부 (폼이 아닌 개별적인 유효성 검사는 필수로 적용함)
 * @returns {Boolean}
 */
fnValidation = function(o, req) {
	log(o);
	if (
			(
					(
							$.trim(o.val()) == '' // 내용이 없는경우
							|| $.trim(o.val()) == o.attr('title') // 내용이 안내멘트와 똑같은 경우
							|| (o.attr('type') == 'checkbox' && !o[0].checked) // 체크박스인경우 체크 안되어있을경우
							|| (o.attr('type') == 'radio' && !isArrCheck(o)) // 라디오박스인경우 체크 안되어있을경우
					)
					&&
					(
							req
							||
							(
									o.hasClass('_req')
									&& o.attr('disabled') != 'disabled'
							)
					)
			)
			||
			(
					$.trim(o.val()) != '' // 내용이 있는경우
					&&
					(
							(
									(
											o.hasClass('_email')
											&& o.attr('disabled') != 'disabled'
									)
									&& !validEmail(o)
							) // 메일 주소 체크
							||
							/** .. 조건 추가 **/
							(
									o.hasClass('_req')
									&& o.attr('disabled') != 'disabled'
									&& parseInt(o.attr('size'), 10) > $.trim(o.val()).length
							) // 길이 체크 (조건 가장 마지막에 둘것)
					)
			)
	) {
		alert(o.attr('title'));
		o.focus();
		return false;
	}
	
	return true;
};

/**
 * 이메일 유효성 검사
 * 
 * @param o
 * @returns {Boolean}
 */
validEmail = function (o){
	if (o.val().match(/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/) == null) {
		return false;
	}
	return true;
};

isArrCheck = function(o) {
	var obj = o.closest('form').find('[name=' + o.attr('name') + ']');
	var ret = false;
	obj.each(function(n) {
		if (this.checked) {
			ret = true;
		}
	});
	
	return ret;
}