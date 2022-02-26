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
                        <col width="5%">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
						<tr>
				        	<th>번호</th>
				            <th>건물명</th>
				            <th>실번호</th>
				            <th>시작일</th>
				            <th>종료일</th>
                        </tr>
                    </thead>
                    <tbody>
						<c:forEach var="row" items="${cmd.list}" varStatus="i">
                            <tr>
	                            <td><b>${cmd.total_record_count - i.index}</b></td>
	                            <td>${row.bl_name}</td>
	                            <td>${row.rm_id} (${row.rm_name})</td>
	                            <td>${row.date_start}</td>
	                            <td>${row.date_end}</td>
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
          
        </div>
    </section>