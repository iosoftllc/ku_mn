<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_list.css" />

    <section class="board_list">
        <div>
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
                    </colgroup>
                    <thead>
						<tr>
				        	<th>번호</th>
				            <th>제목</th>
				            <th>작성일</th>
				            <th>조회</th>
                        </tr>
                    </thead>
                    <tbody>
						<c:forEach var="row" items="${cmd.list}" varStatus="i">
                            <tr>
	                            <td><b>${cmd.total_record_count - ((cmd.current_page_no - 1) * cmd.record_count_per_page) - i.index}</b></td>
                				<c:set var="isNew"><iosf:icon-new datetime="${row.reg_dt }" period="7"/></c:set>
	                            <td class="title ${empty isNew ? '' : 'new' }"><a href="${url}/${row.seq }?${iosf:params('')}">${row.title }<span></span></a></td>
	                            <td class="date"><iosf:date format="${configs.FORMAT_DATEE}" value="${row.reg_dt }" /></td>
	                            <td class="viewcount">${row.viewcnt}</td>
	                        </tr>
						</c:forEach>
						<c:if test="${empty cmd.list}">
	                        <tr class="empty">
	                            <td colspan="4"><p>데이터가 존재하지 않습니다.</p></td>
	                        </tr>
						</c:if>
                    </tbody>
                </table>
            </article>
          
          	<iosf:paging/>
          
        </div>
    </section>