<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<%@include file="../../sys/metalibs.jspf" %>
<link rel="stylesheet" href="${css_src }/iosf/reset.css" />
<link rel="stylesheet" href="${css_src }/iosf/component/theme1/front/korean/common.css" />
<link rel="stylesheet" type="text/css" href="${js_src}/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
<%@include file="../../sys/jslibs.jspf" %>
<script type="text/javascript" src="${js_src }/iosf/component/theme1/front/korean/controller.js"></script>
<script type="text/javascript" src="${js_src }/iosf/front/controller.js"></script>
</head>
<body>

<c:set var="popup_title" value="조회"/>
<c:choose>
	<c:when test="${fn:contains(url, '/find/emp/list') }">
		<c:set var="popup_title" value="교직원찾기"/>
	</c:when>
</c:choose>

<tiles:insertAttribute name="content" />

<%@ include file="../layout_include.jsp" %>

</body>
</html>