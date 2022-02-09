<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../../sys/setCodes.jspf"%>
<script type="text/javascript" src="${js_src}/iosf/webeditor/tinymce/js/tinymce/tinymce.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="${js_src}/iosf/webeditor/tinymce.js" charset="UTF-8"></script>
<c:set var="isQna" value="${cmd.layout_cd == 'qna' }"/>
<c:set var="isRep" value="${cmd.board_seq == '3' }"/>

<link rel="stylesheet" href="${css_src}/iosf/front/board_write.css" />

    <section class="board_write">
        <div>
            <section>
                <form:form modelAttribute="cmd" name="boardCommand" enctype="multipart/form-data" action="${url }?${iosf:params('') }" onsubmit="return doSubmit(this, 'post');">
                    <table class="table_write1">
                        <!-- <caption>신청자정보</caption> -->
                        <colgroup>
                            <col width="15%">
                            <col width="35%">
                            <col width="15%">
                            <col width="35%">
                        </colgroup>
                        <tbody>
							<tr>
								<th>작성자명</th>
								<td>
									<input type="text" name="q_user_nm" id="q_user_nm" value="${empty cmd.q_user_nm ? user.user_nm : cmd.q_user_nm}" class="fullwidth _req" title="문의자이름을 입력하세요" readonly="readonly" />
								</td>
								<th>소속</th>
								<td>
									<input type="text" name="q_dept_nm" id="q_dept_nm" value="${empty cmd.q_dept_nm ? user.dept_nm : cmd.q_dept_nm}" class="fullwidth _req" title="소속명을 입력하세요" readonly="readonly" />
								</td>
							</tr>
							<tr>
								<th>분류</th>
								<td colspan="3">
									<form:select path="category_cd" title="분류를 선택하세요" cssClass="_req">
										<option value="">:: 분류 ::</option>
										<c:forEach var="row" items="${iosf:codes('board_category_cd') }" varStatus="i">
							            	<c:if test="${fn:contains(mcmd.category_cds, row.key)  }">
					                   			<option value="${row.key}" ${cmd.category_cd == row.key ? 'selected="selected"' : '' }">${row.value }</option>
					                   		</c:if>
							            </c:forEach>
									</form:select>
								</td>
							</tr>
							<c:if test="${isRep }">
							<tr>
								<th>부재시수리여부</th>
								<td>
									<select name="q_data1" class="_req" title="부재시수리여부를 선택하세요.">
										<option value="">:: 부재시수리여부 ::</option>
										<iosf:option object="${codes.board_busy }" select="${cmd.q_data1 }"/>
									</select>
								</td>
								<th>호실</th>
								<td>
									<select name="q_data2">
										<c:forEach var="row" items="${roomCmd.list }" varStatus="i">
											<c:set var="room_nm" value="${iosf:code('bd_cd', row.bd_cd) } ${row.room_nm }"/>
											<option value="${room_nm }" ${room_nm == cmd.q_data2 ? 'selected="selected"' : '' }>${room_nm }</option>
										</c:forEach>
									</select>
								</td>
							</tr>
							</c:if>
                            <tr>
                                <th>제목</th>
                                <td colspan="3">
                                    <form:input path="title" cssClass="fullwidth _req" title="제목을 입력하세요" htmlEscape="false" />
                                </td>
                            </tr>
                            <tr>
                                <th>내용</th>
                                <td colspan="3">
                                    <form:textarea cssClass="tinymce _req" path="content" cols="1" rows="1" title="내용을 입력하세요" />
                                </td>
                            </tr>

							<c:import url="/front/attach/embed/write" charEncoding="UTF-8">
								<c:param name="attach_key" value="attach_idx" />
								<c:param name="attach_idx" value="${cmd.attach_idx}" />
								<c:param name="colspan" value="3" />
								<c:param name="refer" value="${url}" />
							</c:import>
                        </tbody>
                    </table>
    
                    <div class="btn">
                        <button type="submit" class="save">저장</button>
                        <button type="button" class="cancel" onclick="location.href='${url_back }?${iosf:params('')}';">취소</button>
                    </div>

                </form:form>    
            </section>

        </div>
    </section> 
