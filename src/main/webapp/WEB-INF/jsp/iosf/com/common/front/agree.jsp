<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/agree.css" />
<script type="text/javascript">
_cancel = function() {
	if (confirm('동의하지 않으시면 원활한 서비스를 이용하실 수 없습니다.\n\n그래도 취소하시겠습니까?')) {
		return;
	}
	
	location.href = '${configs.CONTEXT}/front/main';
}
</script>

    <section class="agree">
        <div>
            <!-- share를 추가하면 팝업이 뜬 상태 -->
            <div class="public-popup share">
                <article>
					<form:form modelAttribute="cmd" name="userCommand" enctype="multipart/form-data" action="${configs.CONTEXT }/front/user/agree" onsubmit="return doSubmit(this, 'post');" target="iframehidden">
	                    <dl>
	                        <!-- 타이틀 -->
	                        <dt>
	                            <p>개인정보동의안내 <button type="button" onclick="_cancel();"></button></p>
	                        </dt>

	                        <!-- 개인정보 수집 -->
	                        <dd class="terms">
	                            <div>
	                                <p>개인정보수집 및 이용동의</p>
	                                <div class="box">
	                                    <b>1.개인정보의 수집 및 이용목적</b>
	                                    <small>안암학사는 정보주체의 이용동의 동의일로부터 예약 서비스를 제공하는 기간 동안에 한하여 예약 서비스를 이용하기 위한 
	                                        최소한의 개인정보를 보유 및 이용하게 됩니다.</small>
	                                    <b>2. 수집하려는 개인정보의 항목</b>  
	                                    <small><span>가.</span> 필수항목: 학번, 이름, 소속/과정, 학년, 성별, 생년월일, 국적, 이메일, 연락처, 주소(국내/외), 모교, 
	                                        비상연락자 이름, 관계, 연락처, 주소(국내/외)</small>
	                                    <small><span>나.</span> 선택항목: 가족 이름, 관계, 생년월일</small>
	                                    <small>※ 서비스 이용과정에서 접속 기록이 자동으로 생성되어 수집될 수 있습니다.</small>
	                                    <b>3. 개인정보의 보유 및 이용기간</b>
	                                    <small>안암학사는 예약 서비스 이용시 이용동의를 통해 수집된 개인정보를 해당 정보주체가 학교를 졸업/퇴사 후 1년이 
	                                        경과하면 삭제합니다.</small>
	                                    <b>4. 동의를 거부할 권리가 있다는 사실 및 동의 거부에 대한 불이익 내용</b>
	                                    <small>정보주체는 개인정보의 수집 및 이용목적에 대한 동의를 거부할 수 있으며 동의 거부 시 안암학사 문의 및 
	                                        답변 서비스를 이용하실 수 없습니다.</small>
	                                    <b>5. 개인정보 보호책임자</b>
	                                    <small><span>가.</span>안암학사(http://dorm.korea.ac.kr/)]는 개인정보처리에 관한 업무를 총괄해서 책임
	                                        지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등 을 위하여 아
	                                        래와 같이 개인정보 보호책임자를 지정하고 있습니다.
	                                        <br>① 개인정보 보호책임자 : ㅇㅇㅇ
	                                        <br>② 개인정보 보호담당자 : ㅇㅇㅇ(행정실 / 02-3290-0000 / ㅇㅇㅇ@korea.ac.kr)</small>
	                                    <small><span>나.</span>정보주체께서는 안암학사의 서비스를 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 
	                                        관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다. 안암학사는 정보주체의 문의에 대해 지체 없이 답변 및 
	                                        처리해 드릴 것입니다.</small>
	                                </div>
	                                <input type="checkbox" name="agree_yn" id="agree_yn" value="Y" class="_req" title="개인정보수집 및 이용에 동의에 체크해주세요."><label for="agree_yn">개인정보수집 및 이용에 동의합니다.</label>
	                            </div>
	                        </dd>
	
	                        <!-- 버튼 -->
	                        <dd class="btn">
	                            <button class="agreement right" type="submit">확인</button>
	                            <button class="cancel left" type="button" onclick="_cancel();">취소</button>
	                        </dd>
	                    </dl>
                    </form:form>
                </article>
            </div>
            
        </div>
    </section>
