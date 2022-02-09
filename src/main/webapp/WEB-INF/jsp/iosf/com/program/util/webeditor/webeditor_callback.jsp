<%@ page language="java" contentType="text/html;charset=UTF-8"%>
<%@ include file="../../../sys/taglibs.jspf"%>
<%@ include file="../../../sys/setCodes.jspf"%>
<!doctype html>
<html>
<head>
<title>Easy Image Mapper</title>
<meta charset="utf-8">
<%@include file="../../../sys/jslibs.jspf" %>
</head>
<body>
<script type="text/javascript">
var v = '', data;
<c:if test="${fn:contains(url, '/uploadfile')}">
v = 'uploadfile';
data = '${cmd.attach_idx}';
</c:if>
<c:if test="${fn:contains(url, '/uploadpdf')}">
v = 'uploadpdf';
data = '${cmd.attach_idx}';
</c:if>
<c:if test="${fn:contains(url, '/uploadimage')}">
v = 'uploadimage';
data = '${cmd.attach_idx}';
</c:if>
<c:if test="${fn:contains(url, '/imagemap')}">
v = 'imagemap';
data = '${cmd.attach_idx}';
</c:if>
parent._callback_editor(v, data);
</script>
</body>
</html>