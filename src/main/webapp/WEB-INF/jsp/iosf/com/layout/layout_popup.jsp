<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../sys/taglibs.jspf"%>
<%@ include file="../sys/setCodes.jspf"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<%@include file="../sys/metalibs.jspf" %>
<%@include file="../sys/csslibs.jspf" %>
<link rel="stylesheet" type="text/css" href="${css_src}/iosf/component/theme1/back/korean/pop.css" />
<%@include file="../sys/jslibs.jspf" %>
</head>
<body>

<c:set var="popup_title" value="조회"/>
<c:choose>
	<c:when test="${fn:contains(url, '/back/patent/find/inventor/') }">
		<c:set var="popup_title" value="발명자조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/refno/') }">
		<c:set var="popup_title" value="REF-NO조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/project/') }">
		<c:set var="popup_title" value="연구과제조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/contract/') }">
		<c:set var="popup_title" value="계약번호조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/account/') }">
		<c:set var="popup_title" value="입금조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/etax/') }">
		<c:set var="popup_title" value="세금계산서조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/country/') }">
		<c:set var="popup_title" value="국가조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/company/') }">
		<c:set var="popup_title" value="기업조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/techcode/') }">
		<c:set var="popup_title" value="기술분류코드추가"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/papercode/') }">
		<c:set var="popup_title" value="관련서류조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/jobman/') }">
		<c:set var="popup_title" value="담당자조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/edoc/dept/') }">
		<c:set var="popup_title" value="부서조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/find/inventor/earner/') }">
		<c:set var="popup_title" value="소득자조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/applymgt/common/extpatent/') }">
		<c:set var="popup_title" value="해외출원현황"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/applymgt/common/inventor/') }">
		<c:set var="popup_title" value="발명자정보"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/applymgt/common/attach/') }">
		<c:set var="popup_title" value="관련파일목록"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/applymgt/common/diagram/') }">
		<c:set var="popup_title" value="패밀리구조도"/>
	</c:when>
	<c:when test="${fn:contains(url, '/master/') }">
		<c:set var="popup_title" value="마스터정보조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/reject/') }">
		<c:set var="popup_title" value="수정요청"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/share/cost/input/') }">
		<c:set var="popup_title" value="비용입력"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/systemmgt/log/mail/body/') }">
		<c:set var="popup_title" value="메일상세내용"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/trans/contract/cost/') }">
		<c:set var="popup_title" value="비용내역조회"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/system/group/menu/') }">
		<c:set var="popup_title" value="메뉴관리"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/system/group/users/') }">
		<c:set var="popup_title" value="사용자관리"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/patent/costmgt/annual/valuation/') }">
		<c:set var="popup_title" value="등록유지검토"/>
	</c:when>
	<c:when test="${fn:contains(url, '/front/board/popup/') }">
		<c:set var="popup_title" value="긴급공지"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/share/cost/mapping/project/') }">
		<c:set var="popup_title" value="지적재산경비 사용내역"/>
	</c:when>
	<c:when test="${fn:contains(url, '/back/share/cost/mapping/cost/') }">
		<c:set var="popup_title" value="연구과제별 지적재산경비  사용내역"/>
	</c:when>
	<c:when test="${fn:contains(url, '/share/edoc/') }">
		<c:set var="popup_title" value="전자결재"/>
	</c:when>
	<c:when test="${fn:contains(url, '/users/out') }">
		<c:set var="popup_title" value="외부발명자 입력"/>
	</c:when>
	<c:when test="${fn:contains(url, '/excel') }">
		<c:set var="popup_title" value="엑셀 업로드"/>
	</c:when>
</c:choose>

<div class="pop1">
	<div class="top">
		<span class="top-title">${popup_title }</span>		
		<span class="btn-close">
			<a href="javascript:window.close();">&nbsp;</a>
		</span>
	</div>	
	<div class="center">
		<tiles:insertAttribute name="content" />
	</div>	
</div>

<%@ include file="layout_include.jsp" %>

</body>
</html>