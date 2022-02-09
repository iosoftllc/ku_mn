$(function() {
	// hide 클래스 모두 숨김
	$('.hide').hide();
	// input text 면 모두 placeholder 추가함
	$('form input[type=text],input[type=password],textarea').each(function(n) {
		if (typeof $(this).attr('placeholder') === 'undefined' && $(this).attr('title') != '') {
			$(this).attr('placeholder', $(this).attr('title'))
		}
	});
});

/**
 * 사생찾기 in 모집
 */
_doFindEventSubmit = function() {
	fnPopup(context + '/back/event/submit/find', 'find', 'width=800px, height=600px, scrollbars=no, resizable=yes');
};

/**
 * 사생찾기 in 서비스
 */
_doFindEventReq = function() {
	fnPopup(context + '/back/event/req/find', 'find', 'width=800px, height=600px, scrollbars=no, resizable=yes');
};

_doReport = function(params) {
	fnPopup(context + '/back/report/doc/' + $('#report_cd').val() + '?' + params, 'report', 'width=1000px, height=800px, scrollbars=yes, resizable=yes');
}

_doAPI = function(sep, param, _callback) {
	var url = system_src + '/api' + sep;
	
    $.ajax({
		url: url,
		type: 'POST',
		data: param,
		success: function(data){
			if (data.length <= 0) {
				log('데이터를 찾을 수 없습니다.');
				if (url.indexOf('/back') >= 0) {
					alert('데이터를 찾을 수 없습니다.\n\n다만 직접입력하여 신청서를 계속 작성하실 수 있지만 신청 가능한 대상인지 확인하세요.')
				}
			} else {
				for (var key in data[0]) {
					if (data[0][key] == null) {
						data[0][key] = '';
					}
				}
			}
			_callback(data);
		}, error: function(jqXHR, textStatus, errorThrown){
			log(errorThrown);
		}
	});
}

//찾기 팝업 리턴값
var FIND_POPUP_OK = 0; // OK (popup close)
var FIND_POPUP_ONLY_ONE = 1; // 한개만 선택 가능
var FIND_POPUP_NEED_REMOVE = 2; // 기존 데이터 삭제