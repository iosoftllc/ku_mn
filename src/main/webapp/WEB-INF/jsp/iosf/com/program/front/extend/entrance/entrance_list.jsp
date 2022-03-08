<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_list.css" />

    <section class="board_list">
        <div class="component-area">
            <div class="infobox">
                <div class="inner">
                    <div class="text">
                        <div><span>-</span><p>출입 신청 중 [승인]된 내역만 조회 됩니다.</p></div>
                        <div><span>-</span><p>모바일신분증은 발급 후 출입 단말기에 적용되기까지 10분~30분 정도 소요 됩니다.</p></div>
                        <div><span>-</span><p>승인된 곳 에 출입이 안될 시 학교포탈 KUPID > 정보생활 > 공간및예약관리(서울) > 출입신청 > 출입신청현황 에서 [재전송] 처리를 하시기 바랍니다.</p></div>
                        <div><span>-</span><p>건물 내 호실은 최대 등록 인원 제한이 있어 추가 신분증 등록이 안 될 수도 있습니다. card@korea.ac.kr로 메일 주시거나 민원안내를 통해 문의 주시기 바랍니다.</p></div>
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