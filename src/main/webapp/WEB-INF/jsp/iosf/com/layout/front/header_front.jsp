<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

    <!-- header -->
    <div id="header">
        <div class="wrap">
            <h1 class="logo"><a href="/">&nbsp;</a></h1>
            <a href="#" id="mobile-menu-btn">&nbsp;</a>
            <div class="menu-holder">
                <div class="mobile-top">
                    <span class="top-title">홈페이지 <span>메뉴</span></span>
                    <a href="#menu" class="mobile-menu-close">&nbsp;</a>
                </div>
                <div class="menu-login">
                    <div class="login-box">
                        <c:if test="${empty user }">
	                        <div class="login-before">
	                            <span class="login-txt">본 홈페이지의 모든 서비스를 이용하시기 위해서는 로그인이 필요합니다.</span>
	                            <a href="${configs.CONTEXT}/front/user/login" class="login-button">로그인</a>
	                        </div>
                        </c:if>
                        <c:if test="${!empty user }">
	                        <!-- login after-->
	                        <div class="info-box">
	                            <span class="thumb"><img src="${img_src}/iosf/front/thumbnail_userinfo_origin.png" width="22px" alt="" /></span>
	                            <a href="#menu" class="name">${user.user_id } <span>님</span></a>
	                            <div class="info-pop">
	                                <span class="txt1">${user.user_nm }</span>
	                                <span class="txt2">${user.user_nm }(${user.user_id }) <span>님</span></span>
	                                <p>${user.dept_nm }</p>
	                                <span class="status">${user.pos_nm }</span>
	                                <div class="bottom">
	                                    <button class="btnlogout" onclick="location.href='${configs.CONTEXT}/user/logout';">로그아웃</button>
	                                    <button class="btnclose">&nbsp;</button>
	                                </div>
	                            </div>
	                        </div>
                        </c:if>
                    </div>
                    <ul id="main-menu">
                        <li>
                            <a href="#menu">스마트 카드</a>
                            <ul>
                                <li>
                                    <a href="#menu">이용 안내</a>
                                    <ul>
                                        <li><a href="javascript:alert('준비중입니다.');">학생증/신분증 소개</a></li>
                                        <li><a href="javascript:alert('준비중입니다.');">국제학생증 소개</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#menu">신청 안내</a>
                                    <ul>
                                        <li><a href="javascript:alert('준비중입니다.');">신입생 예약신청 안내</a></li>
                                        <li><a href="javascript:alert('준비중입니다.');">비대면 금융신청 안내</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:alert('준비중입니다.');">발급 내역 조회</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#menu">모바일 신분증</a>
                            <ul>
                                <li>
                                    <a href="#menu">가입 및 발급 절차</a>
                                    <ul>
                                        <li><a href="javascript:alert('준비중입니다.');">initial(이니셜) 가입절차</a></li>
                                        <li><a href="javascript:alert('준비중입니다.');">모바일 신분증 발급절차</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:alert('준비중입니다.');">이용 안내</a></li>
                                <li><a href="javascript:alert('준비중입니다.');">발급 내역 조회</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#menu">건물 출입 권한</a>
                            <ul>
                                <li><a href="javascript:alert('준비중입니다.');">건물 출입 이용 안내</a></li>
                                <li><a href="javascript:alert('준비중입니다.');">출입 권한 조회</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#menu">커뮤니티</a>
                            <ul>
                                <li><a href="${configs.CONTEXT }/front/notice">공지사항</a></li>
                                <li><a href="${configs.CONTEXT }/front/faq">자주묻는 질문</a></li>
                            </ul>
                        </li>
                         <li>
                            <a href="#menu">민원 안내</a>
                            <ul>
                                <li><a href="${configs.CONTEXT }/front/ask?ask_type=01">모바일 발급오류 신고</a></li>
                                <li><a href="${configs.CONTEXT }/front/ask?ask_type=99">건물 출입오류 신고</a></li>
                            </ul>
                        </li>
                        <li class="mobile-only">
                            <a href="#menu">인덱스 페이지</a>
                            <ul>
                            	<c:if test="${empty user }">
	                                <li><a href="${configs.CONTEXT }/front/user/login">로그인</a></li>
                            	</c:if>
                            	<c:if test="${!empty user }">
	                                <li><a href="${configs.CONTEXT }/user/login">로그아웃</a></li>
                            	</c:if>
                                <li><a href="javascript:alert('준비중입니다.');">개인정보처리방침</a></li>
                                <li><a href="javascript:alert('준비중입니다.');">이메일무단수집거부</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-mask">&nbsp;</div>
    </div>
    <!-- //header -->