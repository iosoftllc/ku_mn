<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../../sys/setCodes.jspf"%>
<c:set var="isQna" value="${mcmd.layout_cd == 'qna' }"/>
<c:set var="isFAQ" value="${mcmd.layout_cd == 'faq' }"/>

<link rel="stylesheet" href="${css_src}/iosf/front/board_list${isFAQ ? '_faq' : ''}.css" />
<script type="text/javascript" src="${js_src }/iosf/front/contents/board_list.js"></script>
<script type="text/javascript">
$(function() {
	<c:if test="${!empty param.board_post_seq }">
		$('#ans${param.board_post_seq}').click();
	</c:if>
})
</script>
    <section class="board_list${isFAQ ? '_faq' : ''}">
        <div>
        	<c:if test="${cmd.board_seq == 7 }">
	            <article class="meal_company">
	                <div><b>급식 운영사 안내</b></div>
	                <dl><dt title="업체 로고"><img src="${configs.CONTEXT }/front/attach/preview/${foodCmd.attach_idx }" width="194"/></dt>
	                    <dd>
	                        <div><p>운영사명</p><small>${foodCmd.dept_nm }</small></div>
	                        <c:if test="${!empty foodCmd.phone }">
		                        <div><p>급식문의전화</p><small>${foodCmd.phone }</small></div>
	                        </c:if>
	                        <c:if test="${!empty foodCmd.email }">
		                        <div><p>급식문의메일</p><small>${foodCmd.email }</small></div>
	                        </c:if>
	                    </dd>
	                </dl>
	            </article>
            </c:if>
            
           	<c:if test="${!empty mcmd.category_cds}">
	            <article class="tab">
	                <dl>
	                	<dt><a href="${url }" class="${empty param.search_category_cd ? 'on' : '' }">전체</a></dt>
			            <c:forEach var="row" items="${iosf:codes('board_category_cd') }" varStatus="i">
			            	<c:if test="${fn:contains(mcmd.category_cds, row.key)  }">
	                   			<dt><a href="${url }?search_category_cd=${row.key}" class="${param.search_category_cd == row.key ? 'on' : '' }">${row.value }</a></dt>
	                   		</c:if>
			            </c:forEach>
	                </dl>
	            </article>
			</c:if>
			
            <article class="counter">
                <div>
                    <P>TOTAL</P>
                    <p><fmt:formatNumber pattern="###,###" value="${cmd.total_record_count}" /><span>&nbsp;건</span></p>
                </div>
                <form:form commandName="form_search" method="get" action="${url }?${iosf:params('search_field;search_keyword')}">
					<select name="search_field">
						<option value="TITLE" ${param.search_field == 'TITLE' ? 'selected="selected"' : '' }>제목</option>
						<option value="CONTENT" ${param.search_field == 'CONTENT' ? 'selected="selected"' : '' }>내용</option>
					</select>
                    <input type="text" name="search_keyword" class="placeholder" placeholder="검색어를 입력하세요." title="검색어를 입력하세요." value="${param.search_keyword }" />
                    <button type="submit">검색</button>
                </form:form>
            </article>

			<c:if test="${!isFAQ }">
	            <article>
	                <table>
	                    <colgroup>
	                        <col width="8%">
	                        <c:if test="${!empty mcmd.category_cds}">
	                        	<col width="12%">
	                        </c:if>
	                        <c:if test="${isQna }">
	                        	<col width="12%">
	                        </c:if>
	                        <col width="">
	                        <col width="12%">
	                        <col width="10%">
	                    </colgroup>
	                    <thead>
							<tr>
					        	<th>번호</th>
					        	<c:if test="${!empty mcmd.category_cds}">
									<th>분류</th>
								</c:if>
		                        <c:if test="${isQna }">
									<th>상태</th>
								</c:if>
					            <th>제목</th>
					            <th>작성일</th>
					            <th>조회</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<c:forEach var="row" items="${cmd.list_notice}" varStatus="i">
	                        <tr class="notice">
	                            <td><b>NOTICE</b></td>
	                            <c:if test="${!empty mcmd.category_cds}">
	                            	<td ${isQna ? 'colspan="2"' : ''}><p><iosf:code upcd="board_category_cd" cd="${row.category_cd }"/></p></td>
	                            </c:if>
	                			<c:set var="isNew"><iosf:icon-new datetime="${row.reg_dt }" period="7"/></c:set>
	                            <td class="title ${empty isNew ? '' : 'new' }"><a href="${url}/${row.board_post_seq }?${iosf:params('')}">${row.title }<span></span></a></td>
	                            <td class="date"><iosf:date format="${configs.FORMAT_DATEE}" value="${row.reg_dt }" /></td>
	                            <td class="viewcount">${row.hit_cnt}</td>
	                        </tr>
							</c:forEach>
							<c:forEach var="row" items="${cmd.list}" varStatus="i">
		                        <tr>
		                            <td><b>${cmd.total_record_count - ((cmd.current_page_no - 1) * cmd.record_count_per_page) - i.index}</b></td>
		                            <c:if test="${!empty mcmd.category_cds}">
		                            	<td><p><iosf:code upcd="board_category_cd" cd="${row.category_cd }"/></p></td>
		                            </c:if>
		                        	<c:if test="${isQna }">
		                            	<td><small ${!empty row.a_reg_dt ? 'class="clear"' : ''}>답변${!empty row.a_reg_dt ? '완료' : '대기'}</small></td>
	                				</c:if>
	                				<c:set var="isNew"><iosf:icon-new datetime="${row.reg_dt }" period="7"/></c:set>
		                            <td class="title ${empty isNew ? '' : 'new' }"><a href="${url}/${row.board_post_seq }?${iosf:params('')}">${row.title }<span></span></a></td>
		                            <td class="date"><iosf:date format="${configs.FORMAT_DATEE}" value="${row.reg_dt }" /></td>
		                            <td class="viewcount">${row.hit_cnt}</td>
		                        </tr>
							</c:forEach>
							<c:if test="${empty cmd.list}">
		                        <tr class="empty">
		                            <td colspan="${8 - (isQna ? 1 : 0) - (!empty mcmd.category_cds ? 1 : 0)}"><p>데이터가 존재하지 않습니다.</p></td>
		                        </tr>
							</c:if>
	                    </tbody>
	                </table>
	            </article>
	        </c:if>
	        <c:if test="${isFAQ }">
	            <article class="faq_list">
					<c:forEach var="row" items="${cmd.list}" varStatus="i">
		                <dl>
		                    <dt>
		                        <div>
		                            <span>질문</span>
		                            <small><iosf:code upcd="board_category_cd" cd="${row.category_cd }"/></small>
		                            <p>${row.title }</p>
		                        </div>
		                        <button type="button" id="ans${row.board_post_seq }"></button>
		                    </dt>
		                    <dd>
		                        <div>
		                            <span>답변</span>
		                            <p>${row.content }</p>
		                            <button type="button">닫기</button>
		
		                        </div>
		                    </dd>
		                </dl>
					</c:forEach>
	            </article>
	        </c:if>
          
          	<iosf:paging/>
          
            <c:if test="${isQna}">
	            <article class="btn">
	                <dl>
	                    <dd class="right"><button class="edit" type="button" onclick="location.href = '${url }/write?${iosf:params('')}';" id="btn_insert">글쓰기</button></dd>
	                    <!-- "right" "left" "center" 로 버튼 정렬 가능(1개일 경우) -->
	                </dl>
	            </article>
	        </c:if>
        </div>
    </section>