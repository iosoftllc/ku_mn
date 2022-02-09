<%@ page contentType="text/html; charset=UTF-8"%>
<%@ include file="../sys/taglibs.jspf"%>
<%@ include file="../sys/setCodes.jspf"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Callback!!</title>
</head>
<body>
	
	<c:set var="value" value="${empty value ? param.value : value }"/>
	
	<center>
		<c:choose>
			<%-- 부모창 새로고침 전용 --%>
			<c:when test="${fn:contains(value, 'parent.refresh') || fn:contains(param.value, 'parent.refresh')}">
				<script type="text/javascript">
					parent.location.reload();
				</script>
			</c:when>
			<%-- 유효성 검사 전용 --%>
			<%-- server-side 유효성검사는 잘못된 DB 저장을 방지 하기 위한 용도로만 사용. 사용자를 위한 처리는 client-side에서 완벽하게 처리할것. --%>
			<c:when test="${fn:contains(value, '/validator') || fn:contains(param.value, '/validator')}">
				<script type="text/javascript">
					alert('<iosf:msg key="common.validator.required"/>')
					history.back();
				</script>
			</c:when>
			<%-- iframe 으로 삭제 처리 전용 --%>
			<c:when test="${fn:contains(value, '/delete')}">
				<script type="text/javascript">
					alert('<iosf:msg key="success.common.delete"/>');
					<%-- 부모창 새로고침 하지않을 대상 : 첨부파일관련 --%>
					<c:if test="${!fn:contains(url, '/attach')}">
						parent.location.reload();
					</c:if>
				</script>
			</c:when>
			<%-- iframe 으로 저장 처리 전용 --%>
			<c:when test="${fn:contains(value, '/save') || fn:contains(param.value, '/save')}">
				<script type="text/javascript">
					alert('<iosf:msg key="success.common.save"/>');
					parent.location.reload();
				</script>
			</c:when>
			<%-- 메일 발송 전용 --%>
			<c:when test="${fn:contains(url, '/mail')}">
				<script type="text/javascript">
					alert('<iosf:msg key="${value}"/>');
					history.back();
				</script>
			</c:when>
			<%-- 코드관리 중복체크 후 --%>
			<c:when test="${fn:contains(url, '/code/check')}">
				<script type="text/javascript">
					<c:if test="${value}">
						parent._callback('Y');
					</c:if>
					<c:if test="${!value}">
						parent._callback('N');
					</c:if>
				</script>
			</c:when>
			<%-- 회원가입 중복체크 --%>
			<c:when test="${fn:contains(url, '/user/check')}">
				<script type="text/javascript">
					<c:if test="${value}">
						parent._callback('Y');
					</c:if>
					<c:if test="${!value}">
						parent._callback('N');
					</c:if>
				</script>
			</c:when>
			<%-- --%>
			<c:when test="${fn:contains(url, '/resetPwd')}">
				<script type="text/javascript">
					<c:if test="${!value}">
						alert('임시 비밀번호를 발송할 수 없습니다.');
						history.back();
					</c:if>
					<c:if test="${value}">
						alert('임시 비밀번호가 이메일로 발송되었습니다.\n\n확인하여 로그인 하신 후 비밀번호를 변경하여 주시기 바랍니다.');
						location.href = '${configs.CONTEXT}/front/user';
					</c:if>
				</script>
			</c:when>
			<c:when test="${fn:contains(url, '/room/check') || fn:contains(url, '/item/check')}">
				<script type="text/javascript">
					<c:if test="${value}">
						parent._callback('Y');
					</c:if>
					<c:if test="${!value}">
						parent._callback('N');
					</c:if>
				</script>
			</c:when>
			<c:when test="${fn:contains(value, '/content/history/updateList')}">
				<script type="text/javascript">
					alert('저장되었습니다');
				</script>
			</c:when>
			<c:when test="${fn:contains(value, '/content/history/write')}">
				<script type="text/javascript">
					alert('저장되었습니다');
					top.opener.location.reload();
					top.close();
				</script>
			</c:when>
			<c:when test="${fn:contains(value, '/content/history/copy')}">
				<script type="text/javascript">
					alert('복사되었습니다');
					parent.location.reload();
				</script>
			</c:when>
			<c:when test="${fn:contains(value, '/content/history/delete')}">
				<script type="text/javascript">
					alert('삭제되었습니다');
					parent.location.reload();
				</script>
			</c:when>
			<c:when test="${fn:contains(value, 'void')}">
				OK
			</c:when>
			<c:otherwise>
				Callback!!
			</c:otherwise>
		</c:choose>
	</center>
</body>
</html>