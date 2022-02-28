<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>
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
    <div id="center">
        
        <div class="visual-slide">
            <div class="slider-nav">
                <div class="wrap">
                    <div class="paging-nav"></div>
                    <div class="navi">
                        <a href="#" class="play">&nbsp;</a>
                        <a href="#" class="slide-prev">&nbsp;</a>
                        <a href="#" class="slide-next">&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="slider">
                <div class="slide-item slide1">
                    <div class="wrap">
                        <div class="slide-inner">
	                        <span class="catchphrase">고려대학교 스마트 카드</span>
	                        <p class="text">건물 출입, 도서관 출입, 기숙사 이용에서 금융 및 교통카드 기능까지 모두 스마트 카드 하나에!</p>
	                        <div class="buttons">
	                            <a href="${configs.CONTEXT }/front/common/m1.1.1">이용 안내</a>
	                            <a href="${configs.CONTEXT }/front/common/m1.2.1">신청 안내</a>
	                            <a href="${configs.CONTEXT }/front/card">발급 내역 조회</a>
	                        </div>
	                    </div>
	                </div>
                </div>
                <div class="slide-item slide2">
                    <div class="wrap">
                        <div class="slide-inner">
	                       <span class="catchphrase">고려대학교 모바일 신분증</span>
	                       <p class="text">온/오프라인에서 신뢰하여 사용할 수 있는 블록체인 네트워크 기반 MOBILE ID !</p>
	                       <div class="buttons">
	                           <a href="${configs.CONTEXT }/front/common/m2.1.1">가입/발급 절차</a>
	                           <a href="${configs.CONTEXT }/front/common/m2.2">이용 안내</a>
	                           <a href="${configs.CONTEXT }/front/mobile">발급 내역 조회</a>
	                       </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="center-top">
            <div class="quicklinks">
                <span class="label">QUICK LINKS</span>
                <a href="${configs.CONTEXT }/front/common/m1.2.1" class="link">
                    <span class="icon">&nbsp;</span>
                    <span class="text">스마트 카드 신청 <span>안내</span></span>
                </a>
                <a href="${configs.CONTEXT }/front/common/m2.1.1" class="link">
                    <span class="icon icon2">&nbsp;</span>
                    <span class="text">initial(이니셜) 가입 <span>절차</span></span>
                </a>
                <a href="${configs.CONTEXT }/front/common/m2.1.2" class="link">
                    <span class="icon icon3">&nbsp;</span>
                    <span class="text">모바일 신분증 <span>발급 절차</span></span>
                </a>
                <a href="${configs.CONTEXT }/front/faq" class="link">
                    <span class="icon icon4">&nbsp;</span>
                    <span class="text">자주묻는 질문</span>
                </a>
                <a href="${configs.CONTEXT }/front/ask?ask_type=01" class="link">
                    <span class="icon icon5">&nbsp;</span>
                    <span class="text">모바일 발급오류 <span>신고</span></span>
                </a>
                <a href="${configs.CONTEXT }/front/ask?ask_type=99" class="link">
                    <span class="icon icon6">&nbsp;</span>
                    <span class="text">건물 출입오류 <span>신고</span></span>
                </a>
            </div>
            <div class="wrap">
                <h2 class="section-title">공지사항</h2>
                <div class="notice-list">
                    <div class="notice-navi">
                        <a href="#prev" class="notice-prev">&nbsp;</a>
                        <a href="#next" class="notice-next">&nbsp;</a>
                        <a href="${configs.CONTEXT }/front/notice" class="notice-more">&nbsp;</a>
                    </div>
                    <ul class="list" id="notice-list">
                    	<c:forEach var="row" items="${notice.list }" varStatus="i">
                    		<c:set var="isNew"><iosf:icon-new datetime="${row.reg_dt }" period="7"/></c:set>
	                        <li class="list-item ${empty isNew ? '' : 'new' }">
	                            <a href="${configs.CONTEXT }/front/notice/${row.seq}">
	                                <span class="title">${row.title }</span>
	                                <span class="date"><iosf:date format="${configs.FORMAT_DATEE }" value="${row.reg_dt }"/></span>
	                                <span class="button">READ MORE</span>
	                            </a>
	                        </li>
                    	</c:forEach>
                    </ul>
                </div>
            </div>
        </div>
        <div class="center-bottom">
            <div class="wrap">
                <h2 class="section-title">앱 다운로드 및 설치 방법</h2>
                <p class="bottom-note">앱스토어에서 ‘initial’ 또는 ‘이니셜’로 검색 후 다운로드 및 설치</p>
                <div class="bottom-buttons">
                    <a href="https://play.google.com/store/apps/details?id=com.sktelecom.myinitial" class="google" target="_blank">GET IT ON</a>
                    <a href="https://apps.apple.com/kr/app/initial-%EC%9D%B4%EB%8B%88%EC%85%9C/id1500820663" class="appstore" target="_blank">Download on the</a>
                    <a href="https://initial.id" class="initial" target="_blank">&nbsp;</a>
                </div>
            </div>
        </div>
    </div>
    <!-- //center -->
    
	<tiles:insertAttribute name="footer" />
</body>
</html>