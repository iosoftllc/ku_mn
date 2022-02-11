<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>
<link rel="stylesheet" type="text/css" href="${css_src}/iosf/front/login.css" />

<script type="text/javascript">
$(function(){
	if(${param.login_error == 'Y'}) {
		alert('로그인 정보를 찾을 수 없습니다.');
	}
});
</script>

                    <form name="Form_login" action="https://auth.korea.ac.kr/directLoginNew${fn:contains(pageContext.request.serverName, 'local') ? 'Test_' : ''}.jsp" method="post" onSubmit="return doSubmit(this, 'post');">
                    	<input type="hidden" name="returnURL" value="${fn:contains(pageContext.request.serverName, 'local') ? 'local.korea.ac.kr:8080' : fn:contains(pageContext.request.serverName, 'test') ? 'local.korea.ac.kr' : 'card.korea.ac.kr'}${configs.CONTEXT }/user/login" />
                        <div class="login-comp">
                            <div class="inner">
                                <p class="note-top">본 홈페이지의 모든 서비스를 이용하시기 위해서는 로그인이 필요합니다.</p>
                                <div class="input-form">
                                    <span class="usernm"><input type="text" id="id" name="id" class="_req" placeholder="포털 아이디" title="포털 아이디를 입력하세요."/></span>
                                    <span class="pwd"><input type="password" id="password" name="pw" class="_req" placeholder="포털 비밀번호" title="포털 비밀번호를 입력하세요."/></span>
                                    <button type="submit">로그인</button>
                                </div>
                                <div class="login-bottom">
                                    <div class="notice-box">
                                        <div class="notice-top"><span>포털 아이디/비밀번호 분실 시</span></div>
                                        <ul class="notice-bottom">
                                            <li>
                                                <span class="status"><span>온라인</span></span>
                                                <span class="text">KUPID 접속 후 아이디/비밀번호 찾기 이용</span>
                                            </li>
                                            <li>
                                                <span class="status orange"><span>학생</span></span>
                                                <span class="text">문의전화: 02-3290-1141~5, 4090~2</span>
                                            </li>
                                            <li>
                                                <span class="status brown"><span>교직원</span></span>
                                                <span class="text">문의전화: 02-3290-4777</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
