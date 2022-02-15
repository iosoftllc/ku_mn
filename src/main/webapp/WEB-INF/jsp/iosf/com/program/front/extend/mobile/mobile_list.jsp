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
            </article>

            <article>
                <table>
                    <colgroup>
                        <col width="3%">
                        <col width="">
                        <col width="">
                        <col width="10%">
                        <col width="">
                    </colgroup>
                    <thead>
						<tr>
				        	<th>번호</th>
				            <th>분류</th>
				            <th>발급일자</th>
				            <th>차수</th>
				            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
						<c:forEach var="row" items="${cmd.list}" varStatus="i">
                            <tr>
	                            <td><b>${cmd.total_record_count - ((cmd.current_page_no - 1) * cmd.record_count_per_page) - i.index}</b></td>
	                            <td>${row.cardtypename}</td>
	                            <td><iosf:date format="${configs.FORMAT_DATEE}" value="${row.issuedate }" /></td>
	                            <td>${row.issuedegree}</td>
	                            <td>${row.cardconname}</td>
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
          
        </div>
    </section>