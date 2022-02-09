var sns_url, sns_title;
$(function() {
	sns_title = document.title + ' ' + $('.right-content h1:eq(0)').text();
	sns_url = $('#copy_url').val();
})
function shareKakao(id) {
	// 사용할 앱의 JavaScript 키 설정
	Kakao.init('91814a06543192a19ff387a8973656c0');

	// 카카오링크 버튼 생성
	Kakao.Link.createDefaultButton({
		container : '#' + id, // 카카오공유버튼ID
		objectType : 'feed',
		content : {
			title : sns_title, // 보여질 제목
			description : sns_title, // 보여질 설명
			imageUrl : location.host + '/images/iosf/kakao_positive.png', // 콘텐츠 URL
			link : {
				mobileWebUrl : sns_url,
				webUrl : sns_url
			}
		}
	});
}

function shareFacebook() {
	$('#sns_form').html('<form name="sns_form" action="http://www.facebook.com/sharer/sharer.php" target="_blank" method="get"></form>');
	$('#sns_form form').append('<input type="hidden" name="u" value="' + encodeURI(sns_url) + '"/>');
	$('#sns_form form').submit();
}

function shareTwitter() {
	$('#sns_form').html('<form name="sns_form" action="https://twitter.com/intent/tweet" target="_blank" method="get"></form>')
	$('#sns_form form').append('<input type="hidden" name="text" value="' + sns_title + '"/>'); // 전달할 텍스트
	$('#sns_form form').append('<input type="hidden" name="url" value="' + encodeURI(sns_url) + '"/>'); // 전달할 URL
	$('#sns_form form').submit();
}

function shareNaverBlog() {
	$('#sns_form').html('<form name="sns_form" action="https://share.naver.com/web/shareView.nhn" target="_blank" method="get"></form>')
	$('#sns_form form').append('<input type="hidden" name="title" value="' + sns_title + '"/>'); // 전달할 텍스트
	$('#sns_form form').append('<input type="hidden" name="url" value="' + encodeURI(sns_url) + '"/>'); // 전달할 URL
	$('#sns_form form').submit();
}