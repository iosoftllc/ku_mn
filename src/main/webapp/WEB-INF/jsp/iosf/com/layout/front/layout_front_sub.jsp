<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>
<c:choose>
	<c:when test="${fn:contains(url, '/common') }">
		<c:set var="menu_cd" value="${page }" />
		<c:choose>
			<c:when test="${page == 'nonemail' }">
				<c:set var="menu_cd" value="m0.3" />
			</c:when>
			<c:when test="${page == 'sitemap' }">
				<c:set var="menu_cd" value="m0.4" />
			</c:when>
		</c:choose>
	</c:when>
	<c:when test="${fn:contains(url, '/card') }">
		<c:set var="menu_cd" value="m1.3" />
	</c:when>
	<c:when test="${fn:contains(url, '/mobile') }">
		<c:set var="menu_cd" value="m2.3" />
	</c:when>
	<c:when test="${fn:contains(url, '/notice') }">
		<c:set var="menu_cd" value="m4.1" />
	</c:when>
	<c:when test="${fn:contains(url, '/faq') }">
		<c:set var="menu_cd" value="m4.2" />
	</c:when>
	<c:when test="${fn:contains(url, '/ask') && param.ask_type == '01' }">
		<c:set var="menu_cd" value="m5.1" />
	</c:when>
	<c:when test="${fn:contains(url, '/ask') && param.ask_type == '99' }">
		<c:set var="menu_cd" value="m5.2" />
	</c:when>
	<c:when test="${fn:contains(url, '/login') }">
		<c:set var="menu_cd" value="m0.1" />
	</c:when>
</c:choose>
<c:set var="depth1_nm" value="" />
<c:set var="depth2_nm" value="" />
<c:set var="depth3_nm" value="" />
<c:choose>
	<c:when test="${fn:contains(menu_cd, 'm1') }">
		<c:set var="depth1_nm" value="스마트 카드" />
		<c:choose>
			<c:when test="${fn:contains(menu_cd, 'm1.1.1') }">
				<c:set var="depth2_nm" value="학생증/신분증 소개" />
			</c:when>
			<c:when test="${fn:contains(menu_cd, 'm1.3') }">
				<c:set var="depth2_nm" value="발급 내역 조회" />
			</c:when>
		</c:choose>
	</c:when>
	<c:when test="${fn:contains(menu_cd, 'm2') }">
		<c:set var="depth1_nm" value="모바일 신분증" />
		<c:choose>
			<c:when test="${fn:contains(menu_cd, 'm2.1.1') }">
				<c:set var="depth2_nm" value="initial(이니셜) 가입절차" />
			</c:when>
			<c:when test="${fn:contains(menu_cd, 'm2.3') }">
				<c:set var="depth2_nm" value="발급 내역 조회" />
			</c:when>
		</c:choose>
	</c:when>
	<c:when test="${fn:contains(menu_cd, 'm3') }">
		<c:set var="depth1_nm" value="건물 출입 권한" />
	</c:when>
	<c:when test="${fn:contains(menu_cd, 'm4') }">
		<c:set var="depth1_nm" value="커뮤니티" />
		<c:choose>
			<c:when test="${fn:contains(menu_cd, 'm4.1') }">
				<c:set var="depth2_nm" value="공지사항" />
			</c:when>
			<c:when test="${fn:contains(menu_cd, 'm4.2') }">
				<c:set var="depth2_nm" value="자주묻는 질문" />
			</c:when>
		</c:choose>
	</c:when>
	<c:when test="${fn:contains(menu_cd, 'm5') }">
		<c:set var="depth1_nm" value="민원 안내" />
		<c:choose>
			<c:when test="${fn:contains(menu_cd, 'm5.1') }">
				<c:set var="depth2_nm" value="모바일 발급오류 신고" />
			</c:when>
			<c:when test="${fn:contains(menu_cd, 'm5.2') }">
				<c:set var="depth2_nm" value="건물 출입오류 신고" />
			</c:when>
		</c:choose>
	</c:when>
	<c:when test="${fn:contains(menu_cd, 'm0') }">
		<c:set var="depth1_nm" value="인덱스 페이지" />
		<c:choose>
			<c:when test="${fn:contains(menu_cd, 'm0.1') }">
				<c:set var="depth2_nm" value="로그인" />
			</c:when>
		</c:choose>
	</c:when>
</c:choose>
<!DOCTYPE html>
<html lang="${language }">
<head>
	<%@include file="../../sys/metalibs.jspf" %>
	<%@include file="../../sys/csslibs.jspf" %>
	<%@include file="../../sys/jslibs.jspf" %>
</head>

<body>

	<tiles:insertAttribute name="header" />	

    <!-- center -->
    <div id="container">
        <div class="sub-visual">
            <div class="wrap">
                <h2 class="htitle">${depth1_nm }</h2>
                <span class="subtext">KU SMART CARD & MOBILE-ID</span>
            </div>
        </div>
        <div class="center-box">
            <div class="wrap">
                <!-- group 1-->
                <div class="left-panel">
                    <div class="left-top">
                        <span>${depth1_nm }</span>
                    </div>
                    <ul class="left-menu">
						<c:choose>
							<c:when test="${fn:contains(menu_cd, 'm1') }">
		                        <li class="withsub">
		                            <a href="#">이용 안내</a>
		                            <ul>
		                                <li><a href="javascript:alert('준비중입니다');">학생증/신분증 소개</a></li>
		                                <!-- <li><a href="javascript:alert('준비중입니다');">국제학생증 소개</a></li> -->
		                            </ul>
		                        </li>
		                        <li class="withsub">
		                            <a href="#">신청 안내</a>
		                            <ul>
		                                <li><a href="javascript:alert('준비중입니다');">신입생 예약신청 안내</a></li>
		                                <li><a href="javascript:alert('준비중입니다');">비대면 금융신청 안내</a></li>
		                            </ul>
		                        </li>
		                        <li><a href="${configs.CONTEXT }/front/card">발급 내역 조회</a></li>
							</c:when>
							<c:when test="${fn:contains(menu_cd, 'm2') }">
		                        <li class="withsub">
		                            <a href="#">가입 및 발급 절차</a>
		                            <ul>
		                                <li><a href="javascript:alert('준비중입니다');">initial(이니셜) 가입절차</a></li>
		                                <li><a href="javascript:alert('준비중입니다');">모바일 신분증 발급절차</a></li>
		                            </ul>
		                        </li>
		                        <li><a href="javascript:alert('준비중입니다');">이용 안내</a></li>
		                        <li><a href="${configs.CONTEXT }/front/mobile">발급 내역 조회</a></li>
							</c:when>
							<c:when test="${fn:contains(menu_cd, 'm3') }">
		                        <li><a href="javascript:alert('준비중입니다');">건물 출입 이용 안내</a></li>
		                        <li><a href="javascript:alert('준비중입니다');">출입 권한 조회</a></li>
							</c:when>
							<c:when test="${fn:contains(menu_cd, 'm4') }">
		                        <li class="${fn:contains(menu_cd, 'm4.1') ? 'on' : '' }"><a href="${configs.CONTEXT }/front/notice">공지사항</a></li>
		                        <li class="${fn:contains(menu_cd, 'm4.2') ? 'on' : '' }"><a href="${configs.CONTEXT }/front/faq">자주묻는 질문</a></li>
							</c:when>
							<c:when test="${fn:contains(menu_cd, 'm5') }">
		                        <li class="${fn:contains(menu_cd, 'm5.1') ? 'on' : '' }"><a href="${configs.CONTEXT }/front/ask?ask_type=01">모바일 발급오류 신고</a></li>
		                        <li class="${fn:contains(menu_cd, 'm5.2') ? 'on' : '' }"><a href="${configs.CONTEXT }/front/ask?ask_type=99">건물 출입오류 신고</a></li>
							</c:when>
							<c:when test="${fn:contains(menu_cd, 'm0') }">
		                        <li class="${fn:contains(menu_cd, 'm0.1') ? 'on' : '' }"><a href="${configs.CONTEXT }/front/login">로그인</a></li>
		                        <li class="${fn:contains(menu_cd, 'm0.3') ? 'on' : '' }"><a href="javascript:alert('준비중입니다');">개인정보처리방침</a></li>
		                        <li class="${fn:contains(menu_cd, 'm0.4') ? 'on' : '' }"><a href="javascript:alert('준비중입니다');">이메일무단수집거부</a></li>
							</c:when>
						</c:choose>
                    </ul>
                </div>
                <div class="right-panel">
                    <div class="right-panel-top">
                        <h3 class="page-title">${empty depth3_nm ? depth2_nm : depth3_nm }</h3>
                        <ul class="navi">
                            <li class="home"><a href="/">&nbsp;</a></li>
                            <li>${depth1_nm }</li>
                            <li>${depth2_nm }</li>
                            <li class="${empty depth3_nm ? 'hide' : '' }">${depth3_nm }</li>
                        </ul>
                    </div>
                    <div class="component-area">

                        <tiles:insertAttribute name="content" />

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //center -->

	<tiles:insertAttribute name="footer" />
</body>
</html>