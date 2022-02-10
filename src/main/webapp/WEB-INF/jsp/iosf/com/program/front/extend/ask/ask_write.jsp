<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_write.css" />

    <section class="board_write">
        <div>
            <section>
                <form:form modelAttribute="cmd" name="askCommand" enctype="multipart/form-data" action="${url }?${iosf:params('') }" onsubmit="return doSubmit(this, 'post');">
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
                                <th>제목</th>
                                <td colspan="3">
                                    <form:input path="title" cssClass="fullwidth _req" title="제목을 입력하세요" htmlEscape="false" />
                                </td>
                            </tr>
							<tr>
								<th>연락처</th>
								<td>
									<form:input path="phone" cssClass="fullwidth" title="연락처를 입력하세요" htmlEscape="false" />
								</td>
								<th>이메일</th>
								<td>
									<form:input path="email" cssClass="fullwidth _email" title="이메일을 입력하세요" htmlEscape="false" />
								</td>
							</tr>
                            <tr>
                                <th>내용</th>
                                <td colspan="3">
                                    <form:textarea cssStyle="width:100%; height: 300px; padding:10px;" cssClass="fullwidth _req" path="contents" cols="1" rows="1" title="내용을 입력하세요" />
                                </td>
                            </tr>
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
