<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../sys/taglibs.jspf"%>
<%@ include file="../../../sys/setCodes.jspf"%>
<!doctype html>
<html>
<head>
<title>Image Map Tool</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<link rel="stylesheet" href="${js_src }/iosf/imagemap/easy-mapper.css">
<%@ include file="../../../sys/jslibs.jspf"%>
<script type="text/javascript" src="${js_src }/iosf/imagemap/easy-mapper-1.2.0.js"></script>
<script type="text/javascript">
$(window).load(function() {
	<c:if test="${empty param.attach_idx}">
		var _img = $(opener._gEditImageMap);
		var _map = $(opener._gEditImageMap).next();
		$('#workspace-img').attr('src', _img.attr('src'));	
		
		// 이미지 로드 후 초기화
		resetMapElView();
		$('#workspace-img').on('load', rulerInit);
		
		_map.find('area').each(function(n) {
			var _l = parseInt($(this).attr('coords').trim().split(',')[0], 10);
			var _t = parseInt($(this).attr('coords').trim().split(',')[1], 10);
			var _r = parseInt($(this).attr('coords').trim().split(',')[2], 10);
			var _b = parseInt($(this).attr('coords').trim().split(',')[3], 10);

			$('#grid-x1').attr('style', 'top: ' + _t + 'px');
			$('#grid-y1').attr('style', 'left: ' + _l + 'px');
			$('#grid-x2').attr('style', 'top: ' + _b + 'px');
			$('#grid-y2').attr('style', 'left: ' + _r + 'px');

			var _div = '';
			_div += '<div class="grid-box _active" id="grid-box-' + n + '">';
			_div += '<span class="grid-box-cnt">' + (n + 1) + '</span>';
			_div += '<span class="grid-box-close">&times;</span>';
			_div += '<span class="grid-box-link">링크 추가</span>';
			_div += '</div>';
			
			$('#workspace-img-wrap').append(_div);

			mapEl.push([[_l, _t], [_r, _b], $(this).attr('href'), $(this).attr('target')]);
			
			// 영역 그리기
			addMapElView(n);
			recalcElMap();
			cnt = n + 1;
			$('.grid-box._active').removeClass('_active');
		});
	</c:if>
});
_ok = function() {
	opener.tinymce.get('${param.webeditor_id}').execCommand('mceInsertContent', false, '<p class="imagemap">' + $('#pop-codegen-im .pop-content p').text() + '</p>');
	window.close();
}
</script>
</head>
<body>

<!-- 딤 스크린 -->
<div id="dim"></div>

<div class="pop" id="pop-code">
	<p class="pop-title">CODE GENERATED</p>
	<div class="pop-btn">
		<div class="pop-btn-copy" id="pop-btn-copy-a">SHOW MARKUP AS <em>&lt;A&gt; TAG</em> FORM</div>
		<div class="pop-btn-copy" id="pop-btn-copy-im">SHOW MARKUP AS <em>IMAGE MAP</em> FORM</div>
		<div class="pop-btn-cancel _full">CLOSE</div>
	</div>
</div>

<div class="pop" id="pop-codegen-a">
	<p class="pop-title">&lt;A&gt; TAG FORM</p>
	<div class="pop-content">
		<p></p>
	</div>
	<div class="pop-btn-cancel _back">BACK</div>
	<div class="pop-btn-cancel">CLOSE</div>
</div>

<div class="pop" id="pop-codegen-im">
	<p class="pop-title">IMAGE MAP FORM</p>
	<div class="pop-content">
		<p></p>
	</div>
	<div class="pop-btn-cancel _back">BACK</div>
	<div class="pop-btn-cancel">CLOSE</div>
</div>

<div class="pop" id="pop-info">
	<p class="pop-title">APP INFORMATION</p>
	<div class="pop-content">
		<p>
			<em class="pop-content-alert">&#9888; This app works on IE10+ only.</em>
			<strong>Easy Image Mapper (v1.2.0)</strong><br>
			Author: Inpyo Jeon<br>
			Contact: inpyoj@gmail.com<br>
			Website: <a class="_hover-ul" href="https://github.com/1npy0/easy-mapper" target="_blank">GitHub Repository</a>
		</p>
	</div>
	<div class="pop-btn-cancel _full">CLOSE</div>
</div>

<div class="pop" id="pop-addlink">
	<p class="pop-title">링크 방식 선택</p>
	<div class="pop-content">
		<input type="text" id="pop-addlink-input">
		<label><input type="radio" name="pop-addlink-target" value="_blank" checked="checked">새창열기 (target:_blank)</label>
		<label><input type="radio" name="pop-addlink-target" value="_self">현재창열기 (target:_self)</label>
	</div>
	<div class="pop-btn">
		<div class="pop-btn-confirm">링크 추가</div>
		<div class="pop-btn-cancel">취소</div>
	</div>
</div>

<!-- 헤더 -->
<div id="gnb">
	<a id="gnb-title" href="" onclick="if (!confirm('다시 작성하시겠습니까?')) return false;">&#8635; 다시작성</a>
	
	<!-- 드롭다운 메뉴 -->
	<ul id="gnb-menu">
		<li id="gnb-menu-measure">
			<span>영역 지정 방식 &#9662;</span>
			<ul class="gnb-menu-sub _toggle">
				<li id="gnb-menu-drag" class="_active">드래그<em>&nbsp;&#10003;</em></li>
				<li id="gnb-menu-click">클릭<em>&nbsp;&#10003;</em></li>
			</ul>
		</li> 
		<li id="gnb-menu-unit">
			<span>단위 변경 &#9662;</span>
			<ul class="gnb-menu-sub _toggle">
				<li id="gnb-menu-pixel" class="_active">Pixel<em>&nbsp;&#10003;</em></li>
				<li id="gnb-menu-percent">%<em>&nbsp;&#10003;</em></li>
			</ul>
		</li>
		<li id="gnb-menu-generate">
			<span>작성 완료</span>
		</li>
		<li id="gnb-menu-info">
			<span>?</span>
		</li>
	</ul>
</div>

<!-- 작업공간 -->
<div id="workspace">
	<!-- 눈금자 -->
	<div id="workspace-ruler">
		<div id="workspace-ruler-x">
			<div id="workspace-ruler-x-2"></div>
			<div id="workspace-ruler-x-1"></div>
		</div>
		<div id="workspace-ruler-y">
			<div id="workspace-ruler-y-2"></div>
			<div id="workspace-ruler-y-1"></div>
		</div>
	</div>
	
	<!-- 이미지 -->
	<div id="workspace-img-wrap">
		<img id="workspace-img" src="${configs.CONTEXT }/front/attach/preview/${param.attach_idx}">
		
		<!-- 그리드 -->
		<div id="grid-x1" class="grid-1"></div>
		<div id="grid-y1" class="grid-1"></div>
		<div id="grid-x2" class="grid-2"></div>
		<div id="grid-y2" class="grid-2"></div>
		<span id="grid-coords"></span>
	</div>
	
</div>
</body>
</html>