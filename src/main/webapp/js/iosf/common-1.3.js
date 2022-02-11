/**
 * init
 */
$(function () {
	// 디버깅 활성
	gbDebug = true;
	try {
		doDragSort();
		fnCalendar('.calendar');
		fnTime('.time');
		doNumber();
	} catch (e) {
	}

	// 로컬이 아니면 https 처리
	if (!isLocal && window.location.protocol == 'http:') {
		//location.href = location.href.replace('http:', 'https:');
	}
});

$(document).ready(function () {
	var content_size = $('.subcontent-right').width();

	$('img').each(function (v) {
		if (typeof $(this).attr('onerror') === 'undefined') {
			//$(this).attr('onerror', 'this.src=\'' + img_src + '/iosf/component' + theme + '/back/' + language + '/thumbnail_no_image.jpg\'');
		}
	});

	// 에디터에서 작성한 이미지가 출력되는 너비보다 큰 경우 100%로 맞춘다 (반응형)
	$('.editor-content img').each(function (n) {
		var width = $(this).attr('width');
		if (typeof width === 'undefined' || width != '') {
			$(this).attr('style', 'width:' + (parseInt(width, 10) < content_size ? width : '100%'));
			$(this).removeAttr('width');
		}
	});
	// 이미지맵 좌표 반응형으로 변환 (이미지에 width가 있으면 오류 style에서 너비 지정해야함)
	// $('img[usemap]').rwdImageMaps();
});

var gbDebug = false;

log = function (v) {
	if (gbDebug) {
		try {
			console.log(v);
		} catch (err) {
			gbDebug = false;
		}
	}
};

isMobile = function () {
	var tmpUser = navigator.userAgent;

	if (tmpUser.indexOf("iPhone") > 0 || tmpUser.indexOf("iPod") > 0 || tmpUser.indexOf("Android ") > 0) {
		return true;
	} else {
		return false;
	}
};

/**
 * 삭제 처리 (리스트, 상세 화면, 수정 화면 전용)
 * 
 * doDelete('삭제하시겠습니까?', 'form_list', false, false)
 * 
 * msg : 생략 가능
 * isCheck : 체크박스 선택건만 처리 (리스트 전용)
 * isFrame : iframe 에서 처리
 */
doDelete = function (msg, form_id, isCheck, isFrame) {
	if (isCheck) {
		if ($("#" + form_id).length <= 0) {
			alert('Form \'' + form_id + '\' 를 찾을 수 없습니다.\n\nForm name 을 ID로 지정하세요.');
			return;
		}

		if (!bCheckAll($("#" + form_id))) {
			return;
		}
	}

	if (fnNVL(msg, '') != '') {
		if (!confirm(msg)) {
			return;
		}
	}

	var deleteForm;
	if (!isCheck && fnNVL(form_id, '') == '') { // view 페이지에서 호출할 경우에 주로 사용
		deleteForm = $('<form id="form_delete" method="post"><input type="hidden" name="_method" value="delete"/></form>');
		deleteForm.appendTo('body');
	} else { // list 페이지에서 호출할 경우에 주로 사용
		// 다른 폼에서 작동하게 하는경우 onsubmit 속성을 변경한다.
		// doPostSubmit, doPreSubmit 함수가 이미 정의가 되어있는경우 로직이 모든 함수에서 동작하지 않도록 분기하여 처리한다.
		// ex) if (f._method.value == 'delete') { ... }
		deleteForm = $('#' + form_id);
		deleteForm.attr('onsubmit', 'return doSubmit(this, \'delete\')');
	}
	if (isFrame) {
		deleteForm.attr('target', 'iframehidden');
	}

	deleteForm.submit();
};

/**
 * 수정 처리 (리스트 전용)
 * 
 * doUpdate('수정하시겠습니까?', 'form_list', false, false)
 * 
 * msg : 생략 가능
 * isCheck : 체크박스 선택여부
 * isFrame : iframe 에서 처리
 */
doUpdate = function (msg, form_id, isCheck, isFrame) {
	if ($("#" + form_id).length <= 0) {
		alert('Form \'' + form_id + '\' 를 찾을 수 없습니다.\n\nForm name 을 ID로 지정하세요.');
		return;
	}

	if (isCheck) {
		if (!bCheckAll($("#" + form_id))) {
			return;
		}
	}

	if (fnNVL(msg, '') != '') {
		if (!confirm(msg)) {
			return;
		}
	}
	
	var updateForm = $('#' + form_id);
	if (!isCheck) { // list 페이지에서 체크와 상관없이 전부 저장
		updateForm.attr('onsubmit', 'return doSubmit(this, \'post\')');
		updateForm.append('<input type="hidden" name="_method" value="put"/>');
	} else { // list 페이지에서 체크 한 것만 저장
		// 다른 폼에서 작동하게 하는경우 onsubmit 속성을 변경한다.
		// doPostSubmit, doPreSubmit 함수가 이미 정의가 되어있는경우 로직이 모든 함수에서 동작하지 않도록 분기하여 처리한다.
		// ex) if (f._method.value == 'update') { ... }
		updateForm.attr('onsubmit', 'return doSubmit(this, \'patch\')');
	}
	if (isFrame) {
		updateForm.attr('target', 'iframehidden');
	}

	updateForm.submit();
};

/**
 * 각종 처리 전용
 * 
 * doProc('form', '/back/code/proc', true, true);
 * 
 * msg : 생략 가능
 * isCheck : 체크박스 선택건만 처리 (리스트 전용)
 * isFrame : iframe 에서 처리
 * 
 * _proc 함수를 JSP 안에 삽입하여 처리한다
 */
doProc = function (msg, form_id, action, isCheck, isFrame) {
	if (isCheck) {
		if ($("#" + form_id).length <= 0) {
			alert('Form \'' + form_id + '\' 를 찾을 수 없습니다.\n\nForm name 을 ID로 지정하세요.');
			return;
		}

		if (!bCheckAll($("#" + form_id))) {
			return;
		}
	}

	if (fnNVL(msg, '') != '') {
		if (!confirm(msg)) {
			return;
		}
	}

	try {
		log('커스터마이징 처리 함수 : _proc()');
		if (!_proc(f))
			return;
	} catch (e) {
		log(e);
		if (e.message.indexOf('_proc') < 0) {
			return;
		}
	}

	if ($("#" + form_id).length <= 0) {
		if (isFrame) {
			$('#iframehidden').attr('src', action);
		} else {
			location.href = action;
		}
	} else {
		$("#" + form_id).attr('action', action);
		if (isFrame) {
			$("#" + form_id).attr('target', 'iframehidden');
		}
		$("#" + form_id).submit();
	}
};

/*
 * 폼 전송
 * 
 * <form onsubmit="return doSubmit(this, 'post');"
 * 
 * method : get(검색), post(등록), put/patch(수정 - 동일하게 동작한다)
 * 
 * 아래 함수를 JSP 페이지에 삽입하면 Form 전송하기 직전의 전/후 처리 가능
 * 저장하시겠습니까? confirm 창 처리는 후처리를 이용할 것
 * 
 * - 전처리 함수
 * doPreSubmit = function (f) {
 * 	log('doPreSubmit');
 * 	return true;
 * };
 * - 후처리 함수
 * doPostSubmit = function (f) {
 * 	log('doPostSubmit');
 * 	return true;
 * };
 * 
 * 한페이지에 여러 폼이 구성되어있는경우 f.name 으로 구분
 */
doSubmit = function (f, method) {
	log('doSubmit on ' + method);

	if (method == 'patch' || method == 'put' || method == 'delete') {
		$(f).find('input[name=_method]').remove();
		$(f).append('<input type="hidden" name="_method" value="' + method + '"/>');
		f.method = 'post';
	} else {
		f.method = method;
	}

	try {
		log('전처리 호출 : doPreSubmit()');
		if (!doPreSubmit(f))
			return false;
	} catch (e) {
		log(e);
		if (e.message.indexOf('doPreSubmit') < 0) {
			return false;
		}
	}

	if ($(f).find('.tinymce').length > 0) {
		tinymce.triggerSave();
	}

	log('유효성 검사 : doValidation()');
	if (!doValidation(f)) {
		return false;
	}

	try {
		log('후처리 호출 : doPostSubmit()');
		if (!doPostSubmit(f))
			return false;
	} catch (e) {
		log(e);
		if (e.message.indexOf('doPostSubmit') < 0) {
			return false;
		}
	}

	return true;
};

/**
 * 팝업 호출
 * 
 * fnPopup('/back/popup/code/', '', 'width=400px, height=350px, scrollbars=no, resizable=yes');
 */
fnPopup = function (url, nm, opt) {
	var win = window.open(url, nm, opt);
	win.focus();
};

/**
 * 엑셀 등록 화면
 */
fnExcel = function (id) {
	window.open('/excel/write?table_id=' + id, '', 'width=1000px, height=600px, scrollbars=yes, resizable=yes');
};

fnGetCookie = function (nm) {
	var search = nm + "=";
	if (document.cookie.length > 0) { // 쿠키가 설정되어 있다면
		offset = document.cookie.indexOf(search);
		if (offset != -1) { // 쿠키가 존재하면
			offset += search.length;
			// set index of beginning of value
			end = document.cookie.indexOf(";", offset);
			// 쿠키 값의 마지막 위치 인덱스 번호 설정
			if (end == -1)
				end = document.cookie.length;
			return unescape(document.cookie.substring(offset, end));
		}
	}
	return "";
};

fnSetCookie = function (name, value, expires) {
	var todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expires);
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString();
};

Date.prototype.format = function (f) {
	if (!this.valueOf())
		return " ";

	var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
	var d = this;

	return f.replace(/(yyyy|yy|MM|dd|E|hh|mm|ss|ms|a\/p)/gi, function ($1) {
		switch ($1) {
			case "yyyy":
				return d.getFullYear();
			case "yy":
				return (d.getFullYear() % 1000).zf(2);
			case "MM":
				return (d.getMonth() + 1).zf(2);
			case "dd":
				return d.getDate().zf(2);
			case "E":
				return weekName[d.getDay()];
			case "HH":
				return d.getHours().zf(2);
			case "hh":
				return ((h = d.getHours() % 12) ? h : 12).zf(2);
			case "mm":
				return d.getMinutes().zf(2);
			case "ss":
				return d.getSeconds().zf(2);
			case "ms":
				return d.getMilliseconds().zf(3);
			case "a/p":
				return d.getHours() < 12 ? "오전" : "오후";
			default:
				return $1;
		}
	});
};

String.prototype.string = function (len) {
	var s = '', i = 0;
	while (i++ < len) {
		s += this;
	}
	return s;
};
String.prototype.zf = function (len) {
	return "0".string(len - this.length) + this;
};
Number.prototype.zf = function (len) {
	return this.toString().zf(len);
};

// SNS 내보내기
sendSns = function (sns, url, txt) {
	var o;
	var _url = encodeURIComponent(url);
	var _txt = encodeURIComponent(txt);
	var _br = encodeURIComponent('\r\n');

	switch (sns) {
		case 'facebook':
			o = {
				method: 'popup',
				url: 'http://www.facebook.com/sharer/sharer.php?u=' + _url
			};
			break;

		case 'twitter':
			o = {
				method: 'popup',
				url: 'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
			};
			break;

		case 'me2day':
			o = {
				method: 'popup',
				url: 'http://me2day.net/posts/new?new_post[body]=' + _txt + _br + _url + '&new_post[tags]=epiloum'
			};
			break;

		case 'kakaotalk':
			o = {
				method: 'web2app',
				param: 'sendurl?msg=' + _txt + '&url=' + _url + '&type=link&apiver=2.0.1&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent('Epiloum 개발노트'),
				a_store: 'itms-apps://itunes.apple.com/app/id362057947?mt=8',
				g_store: 'market://details?id=com.kakao.talk',
				a_proto: 'kakaolink://',
				g_proto: 'scheme=kakaolink;package=com.kakao.talk'
			};
			break;

		case 'kakaostory':
			o = {
				method: 'web2app',
				param: 'posting?post=' + _txt + _br + _url + '&apiver=1.0&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent('Epiloum 개발노트'),
				a_store: 'itms-apps://itunes.apple.com/app/id486244601?mt=8',
				g_store: 'market://details?id=com.kakao.story',
				a_proto: 'storylink://',
				g_proto: 'scheme=kakaolink;package=com.kakao.story'
			};
			break;

		case 'band':
			o = {
				method: 'web2app',
				param: 'create/post?text=' + _txt + _br + _url,
				a_store: 'itms-apps://itunes.apple.com/app/id542613198?mt=8',
				g_store: 'market://details?id=com.nhn.android.band',
				a_proto: 'bandapp://',
				g_proto: 'scheme=bandapp;package=com.nhn.android.band'
			};
			break;

		default:
			alert('지원하지 않는 SNS입니다.');
			return false;
	}

	switch (o.method) {
		case 'popup':
			window.open(o.url);
			break;

		case 'web2app':
			if (navigator.userAgent.match(/android/i)) {
				// Android
				setTimeout(function () {
					location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'
				}, 100);
			} else if (navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i)) {
				// Apple
				setTimeout(function () {
					location.href = o.a_store;
				}, 200);
				setTimeout(function () {
					location.href = o.a_proto + o.param
				}, 100);
			} else {
				alert('이 기능은 모바일에서만 사용할 수 있습니다.');
			}
			break;
	}
}

/**
 * 클립보드 복사
 */
doCopy = function (id) {
	id.focus();
	id.select();
	document.execCommand('copy');
	alert("텍스트가 복사되었습니다.");
};

/**
 * 숫자앞에 0 붙이기
 * 
 * @param n
 * @param width
 * @param z
 * @returns
 */
fnPad = function (n, width, z) {
	z = z || '0';
	n = n + '';
	return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
};

/**
 * 파일 확장자 체크
 * 
 * @param obj
 * @param type
 * @returns
 */
fnFileType = function (obj, type) {
	switch (type) {
		case 'image':
			return obj.match(/\.(gif|jpg|jpeg|png)$/i);
		case 'doc':
			return obj.match(/\.(doc|docx|hwp|txt|ppt|pptx|pdf)$/i);
		case 'vod':
			return obj.match(/\.(mp4|mp3|mov|asf|asx|wma|wmv|avi|mpeg|mpg|mkv|rm)$/i);
		default:
			return obj.match(/\.(gif|jpg|jpeg|png|doc|docx|hwp|txt|ppt|pptx|pdf|mp4|mp3|mov|asf|asx|wma|wmv|avi|mpeg|mpg|mkv|rm)$/i);
	}
	return false;
};

/**
 * 파일 확장자 가져오기
 * 
 * @param obj
 * @returns
 */
fnFileExt = function (obj) {
	if (obj.match(/\.(gif|jpg|jpeg)$/i)) {
		return 'jpg';
	}
	if (obj.match(/\.(png)$/i)) {
		return 'png';
	}
	if (obj.match(/\.(ppt|pptx)$/i)) {
		return 'ppt';
	}
	if (obj.match(/\.(xls|xlsx)$/i)) {
		return 'xls';
	}
	if (obj.match(/\.(pdf)$/i)) {
		return 'pdf';
	}
	if (obj.match(/\.(doc|docx)$/i)) {
		return 'doc';
	}
	if (obj.match(/\.(hwp)$/i)) {
		return 'hwp';
	}
	if (obj.match(/\.(zip)$/i)) {
		return 'zip';
	}

	return 'etc';
};

/**
 * 도메인 패턴 검증
 * 
 * @param str
 * @returns {Boolean}
 */
function doValidDoamin(str) {

	var pattern = new RegExp('^(https?:\\/\\/)?' + // 프로토콜
		'((([a-z\d](([a-z\d-]*[a-z\d])|([ㄱ-힣]))*)\.)+[a-z]{2,}|' + // 도메인명 <-이부분만
		// 수정됨
		'((\\d{1,3}\\.){3}\\d{1,3}))' + // 아이피
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // 포트번호
		'(\\?[;&a-z\\d%_.~+=-]*)?' + // 쿼리스트링
		'(\\#[-a-z\\d_]*)?$', 'i'); // 해쉬테그들

	if (!pattern.test(str)) {
		return false;
	} else {
		return true;
	}

}

/**
 * v가 Null 이면 d를 반환한다
 * 
 * @param v
 * @param d
 * @returns
 */
fnNVL = function (v, d) {
	return (v == null || v == '') ? d : v;
};

/**
 * 날짜 일수 더하기
 * 
 * @param _yyyymmdd
 * @param _dd
 * @returns {String}
 */
fnAddDay = function (_yyyymmdd, _dd) {
	var yyyy = _yyyymmdd.substr(0, 4);
	var mm = eval(_yyyymmdd.substr(4, 2) + "- 1");
	var dd = _yyyymmdd.substr(6, 2);
	var __yyyymmdd = new Date(yyyy, mm, eval(dd + '+' + _dd));
	yyyy = __yyyymmdd.getFullYear();
	mm = (__yyyymmdd.getMonth() + 1) < 10 ? "0" + (__yyyymmdd.getMonth() + 1) : (__yyyymmdd.getMonth() + 1);
	dd = __yyyymmdd.getDate() < 10 ? "0" + __yyyymmdd.getDate() : __yyyymmdd.getDate();
	return "" + yyyy + "-" + mm + "-" + dd;
};

/**
 * 날짜 월수 더하기
 * 
 * @param _yyyymmdd
 * @param _mm
 * @returns {String}
 */
fnAddMonth = function (_yyyymmdd, _mm) {
	if (_mm == "")
		return;
	var yyyy = _yyyymmdd.substr(0, 4);
	var mm = eval(_yyyymmdd.substr(4, 2) + "- 1") + 1;
	var dd = _yyyymmdd.substr(6, 2);
	var last_day, add_month;

	add_month = new Date(yyyy, eval(mm + '+' + _mm), 1);
	last_day = new Date(yyyy, eval(mm), 0).getDate();

	if (last_day == dd) {
		dd = new Date(add_month.getYear(), add_month.getMonth(), 0).getDate();
	}

	var __yyyymmdd = new Date(add_month.getFullYear(), add_month.getMonth() - 1, eval(dd));
	yyyy = __yyyymmdd.getFullYear();
	mm = (__yyyymmdd.getMonth() + 1) < 10 ? "0" + (__yyyymmdd.getMonth() + 1) : (__yyyymmdd.getMonth() + 1);
	dd = __yyyymmdd.getDate() < 10 ? "0" + __yyyymmdd.getDate() : __yyyymmdd.getDate();
	return "" + yyyy + "-" + mm + "-" + dd;
};

/**
 * 태그 제거 함수
 */
fnRemoveTag = function (v) {
	return v.replace(/(<([^>]+)>)/gi, "");
};

var originalSerializeArray = $.fn.serializeArray;
$.fn.extend({
	serializeArray: function () {
		return this.map(function () {
			return this.elements ? jQuery.makeArray(this.elements) : this;
		})
			.filter(function () {
				return this.name && !this.disabled &&
					(this.checked || /select|textarea/i.test(this.nodeName) ||
						/color|date|datetime|email|hidden|month|number|password|range|search|tel|text|time|url|week/i.test(this.type));
			})
			.map(function (i, elem) {
				var val = jQuery(this).val();

				return val == null || this.title == this.value ?
					null :
					jQuery.isArray(val) ?
						jQuery.map(val, function (val, i) {
							return { name: elem.name, value: val };
						}) :
						{ name: elem.name, value: val };
			}).get();
	}
});

fnCounter = function(clazz) {
	function numberCounter(target_frame, target_number) {
		this.count = 0;
		this.diff = 0;
		this.target_count = parseInt(target_number);
		this.target_frame = target_frame;
		this.timer = null;
		this.counter();
	}
	;
	numberCounter.prototype.counter = function() {
		var self = this;
		this.diff = this.target_count - this.count;

		if (this.diff > 0) {
			self.count += Math.ceil(this.diff / 15);
		}

		this.target_frame.innerHTML = this.count.toString().replace(
				/\B(?=(\d{3})+(?!\d))/g, ',');

		if (this.count < this.target_count) {
			this.timer = setTimeout(function() {
				self.counter();
			}, 15);
		} else {
			clearTimeout(this.timer);
		}
	};

	$(clazz).each(function(n) {
		new numberCounter(this, $(this).text());
	})
}

/**
 * 숨기거나 보이게하는 객체 하위 오브젝트의 disabled / enable 제어
 * 
 */
doShow = function(target, isShow) {
	isShow ? $(target).show() : $(target).hide();
	$(target).find('select,input,textarea,button,option').prop('disabled', !isShow);
	$(target).prop('disabled', !isShow);
	// hide안에 hide 클래스가 있다면 그 안쪽 오브젝트들은 disabled 유지 
	$(target).find('.hide').find('select,input,textarea,button,option').prop('disabled', true);
	// 달력도 disabled
	if ($(target).find('.calendar').datepicker('option', 'disabled') != !isShow) {
		$(target).find('.calendar').datepicker('option', 'disabled', !isShow);
	}
};