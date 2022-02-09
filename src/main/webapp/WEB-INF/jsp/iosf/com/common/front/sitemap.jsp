<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/sitemap.css" />

    <section class="sitemap">
        <div>
            <article>
                <div class="title">
                    <p>안암학사소개</p>
                </div>
                <dl>
                    <dt><a href="#sitemap">기관소개</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 33 : 32 }">인사말</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/organ?search_sep_cd=01">역대 사감장</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/history">연혁</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 30 : 28 }">운영규정</a></dd>
                </dl>
                <dl>
                    <dt><a href="#sitemap">조직/주요시설</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/organ">조직구성</a></dd>
                    <dd><a href="#">주요시설</a></dd>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 39 : 38 }">찾아오시는 길</a></dt>
                </dl>
            </article>

            <article>
                <div class="title">
                    <p>건물/시설/생활</p>
                </div>
                <dl>
                 	<dt><a href="#sitemap">건물안내</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 1 : 0 }">건물현황</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 7 : 2 }">학생동</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 8 : 3 }">프런티어관</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 9 : 4 }">CJ인터내셔널하우스</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 10 : 5 }">안암인터내셔널하우스</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 11 : 6 }">안암글로벌하우스</a></dd>
                </dl>
                <dl>
	                <dt><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 41 : 40 }">생활수칙</a></dt>
                </dl>
                <dl>
                 	<dt><a href="#sitemap">생활안내</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 35 : 34 }">네트워크/인터넷 이용안내</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 37 : 36 }">화재/지진 대피안내</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 37 : 36 }">내선전화 이용안내</a></dd>
                </dl>
            </article>

            <article>
                <div class="title">
                    <p>입사 및 퇴사</p>
                </div>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 16 : 12 }">입사안내 및 절차</a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 24 : 20 }">환불 및 퇴사절차</a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/event">입사 및 서비스신청</a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/event/submit">신청현황조회</a></dt>
                </dl>
            </article>

            <article>
                <div class="title">
                    <p>알림마당</p>
                </div>
                <dl>
                    <dt class="${menu_cd == 'm4.1' ? 'on' : '' }"><a href="${configs.CONTEXT }/front/content/${language == 'ko' ? 45 : 44 }">안암학사 일정</a></dt>
                </dl>
                <dl>
                    <dt class="${menu_cd == 'm4.2' ? 'on' : '' }"><a href="${configs.CONTEXT }/front/board/${language == 'ko' ? 1 : 5 }/post">공지사항</a></dt>
                </dl>
                <dl>
                 	<dt><a href="#sitemap">시설관리</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/board/2/post">시설공지</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/board/3/post">수리요청</a></dd>
                </dl>
                <dl>
                 	<dt><a href="#sitemap">문의사항</a></dt>
                    <dd><a href="${configs.CONTEXT }/front/board/6/post">FAQ</a></dd>
                    <dd><a href="${configs.CONTEXT }/front/board/4/post">Q&A</a></dd>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/board/7/post">급식안내</a></dt>
                </dl>
            </article>

            <article>
                <div class="title">
                    <p>인덱스 페이지</p>
                </div>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/user/login"><iosf:msg key="common.menu.login"/></a></dtass=>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/content/${language == 'en' ? 31 : 29 }"><iosf:msg key="common.menu.privacy"/></a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/common/nonemail"><iosf:msg key="common.menu.email"/></a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/common/sitemap"><iosf:msg key="common.menu.sitemap"/></a></dt>
                </dl>
                <dl>
                    <dt><a href="${configs.CONTEXT }/front/search"><iosf:msg key="common.menu.search"/></a></dt>
                </dl>
            </article>
        </div>
    
    </section>
