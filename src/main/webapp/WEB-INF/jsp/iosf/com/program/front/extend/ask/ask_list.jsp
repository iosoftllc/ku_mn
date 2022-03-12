<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_list.css" />

    <section class="board_list">
        <div class="component-area">
            <div class="infobox">
                <div class="inner">
                    <div class="text">
                        <h2>모바일 발급오류 신고</h2>
                        <div><span>-</span><p>모바일신분증은 본인 명의 휴대폰에서만 가능하며 본인 명의 휴대폰의 이름,생년월일 그리고 입력한 학번/교직원번호 등과 학교 학적정보가 일치해야 발급이 가능합니다.</p></div>
                        <div><span>-</span><p>신고시 휴대폰 기종, 발급 오류 문구 및 상황 등을 정확히 기재해 주시기 바랍니다.</p></div>
                        <div><span>-</span><p>자주묻는질문 의 모바일신분증안내를 먼저 확인하시고 본인 상황과 맞는 내용이 없는 경우 문의해 주시기 바랍니다.</p></div>
                        <br/>
                        <h2>건물 출입오류 신고</h2>
                        <div><span>-</span><p>모바일신분증은 발급 후 15분이 경과한 후에 건물 출입이 가능합니다. 그리고 공간예약신청을 하여 승인된 건물 및 호실만 이용이 가능합니다.</p></div>
                        <div><span>-</span><p>신고시 건물 및 호실명 그리고 모바일신분증 태그시 나오는 음성메시지 등 상황을 정확히 기재해 주시기 바랍니다.</p></div>
                        <div><span>-</span><p>자주묻는질문 의 건물출입안내를 먼저 확인하시고 본인 상황과 맞는 내용이 없는 경우 문의해 주시기 바랍니다.</p></div>
                    </div>
                    <div class="bottom">
                        <a href="${configs.CONTEXT }/front/faq" class="btnhome">자주 묻는 질문 바로가기</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <article class="counter">
                <div>
                    <P>TOTAL</P>
                    <p><fmt:formatNumber pattern="###,###" value="${cmd.total_record_count}" /><span>&nbsp;건</span></p>
                </div>
                <form:form commandName="form_search" method="get" action="${url }">
					<select name="search_ask_type">
						<iosf:option object="${codes.MobileCardAskType }" select="${cmd.search_ask_type }"/>
					</select>
					<select name="search_field">
						<option value="TITLE" ${param.search_field == 'TITLE' ? 'selected="selected"' : '' }>제목</option>
						<option value="CONTENT" ${param.search_field == 'CONTENT' ? 'selected="selected"' : '' }>내용</option>
					</select>
                    <input type="text" name="search_keyword" class="placeholder" placeholder="검색어를 입력하세요." title="검색어를 입력하세요." value="${param.search_keyword }" />
                    <button type="submit"></button>
                </form:form>
            </article>

            <article>
                <table>
                    <colgroup>
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
						<tr>
				        	<th>번호</th>
                            <th>구분</th>
                            <th>상태</th>
				            <th>제목</th>
				            <th>작성일</th>
                        </tr>
                    </thead>
                    <tbody>
						<c:forEach var="row" items="${cmd.list}" varStatus="i">
                            <tr>
	                            <td><b>${cmd.total_record_count - ((cmd.current_page_no - 1) * cmd.record_count_per_page) - i.index}</b></td>
                            	<td><p><iosf:code upcd="MobileCardAskType" cd="${row.ask_type }"/></p></td>
                            	<td><small class="${row.stat == 2 ? 'clear' : '' }"><iosf:code upcd="MobileCardAskStat" cd="${row.stat }"/></small></td>
                				<c:set var="isNew"><iosf:icon-new datetime="${row.reg_dt }" period="7"/></c:set>
	                            <td class="title ${empty isNew ? '' : 'new' }"><a href="${url}/${row.seq }?${iosf:params('')}">${row.title }<span></span></a></td>
	                            <td class="date"><iosf:date format="${configs.FORMAT_DATEE}" value="${row.reg_dt }" /></td>
	                        </tr>
						</c:forEach>
						<c:if test="${empty cmd.list}">
	                        <tr class="empty">
	                            <td colspan="5"><p>데이터가 존재하지 않습니다.</p></td>
	                        </tr>
						</c:if>
                    </tbody>
                </table>
            </article>
          
          	<iosf:paging/>
          	
            <article class="btn">
                <dl>
                    <dd class="right"><button class="edit" type="button" onclick="location.href = '${url }/write?${iosf:params('')}';" id="btn_insert">문의하기</button></dd>
                    <!-- "right" "left" "center" 로 버튼 정렬 가능(1개일 경우) -->
                </dl>
            </article>
          
        </div>
    </section>