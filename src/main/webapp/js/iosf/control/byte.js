/**
 * 초기화
 */
doByte = function(){
	$('._byte').each(function(i) {
		var _this = $(this);
		$(this).find('textarea').keydown(function(e) {
			fnByte($(this), e, _this.find('._byteCount'), _this.find('._byteLimit'));
		}).keyup(function(e) {
			fnByte($(this), e, _this.find('._byteCount'), _this.find('._byteLimit'));
		}).blur(function(e) {
			fnByte($(this), e, _this.find('._byteCount'), _this.find('._byteLimit'));
		});
    });
};

/** 
 * string String::cut(int len)
 * 글자를 앞에서부터 원하는 바이트만큼 잘라 리턴합니다.
 * 한글의 경우 2바이트로 계산하며, 글자 중간에서 잘리지 않습니다.
 */
 String.prototype.cut = function(len) {
         var str = this;
         var l = 0;
         for (var i=0; i<str.length; i++) {
                 l += (str.charCodeAt(i) > 128) ? 2 : 1;
                 if (l > len) return str.substring(0,i);
         }
         return str;
 };

 /** 
 * bool String::bytes(void)
 * 해당스트링의 바이트단위 길이를 리턴합니다. (기존의 length 속성은 2바이트 문자를 한글자로 간주합니다)
 */
 String.prototype.bytes = function() {
         var str = this;
         var l = 0;
         for (var i=0; i<str.length; i++) l += (str.charCodeAt(i) > 128) ? 2 : 1;
         return l;
 };

/**
 * 키보드 리스너
 * 
 * @param obj
 * @param e
 * @param cnt
 * @param limit
 */
fnByte = function (obj, e, cnt, limit) {
	
	if (e.which == '197' && $.browser.opera) {
		obj.trigger('onkeyup');
	}

	// 바이트 허용수치 이상시 허용키
	if (parseInt(obj.val().bytes(), 10) >= parseInt(limit.text(), 10)
			&& !(e.which
			&& e.which == 8 // Backspace
			|| e.which == 9 // Tab
			|| e.which == 0 
			|| e.which == 35 // Home
			|| e.which == 36 // End
			|| e.which == 37 // Left
			|| e.which == 38 // Top
			|| e.which == 39 // Right
			|| e.which == 40 // Down
			|| e.which == 46 // Del
			|| (e.ctrlKey && e.which == 65) // Ctrl + A
			|| (e.ctrlKey && e.which == 67) // Ctrl + C
			|| (e.ctrlKey && e.which == 88) // Ctrl + X
		)) {
		
		// 글자가 초과된 경우 삭제함
		if (parseInt(obj.val().bytes(), 10) > parseInt(limit.text(), 10)) {
			obj.val(obj.val().cut(parseInt(limit.text(), 10)));
		}

		e.preventDefault();
	}
	
	// 현재 바이트수 표기
	cnt.text(obj.val().bytes());
};