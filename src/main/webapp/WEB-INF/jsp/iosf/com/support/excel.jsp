<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../sys/taglibs.jspf"%>
<%@ include file="../sys/setCodes.jspf"%>

<div class="comp-table-write">
	<div class="table-block">
		<form:form commandName="Form_write" enctype="multipart/form-data" onsubmit="return doSubmit(this);">
			<table class="tbl tbl-write">
				<tbody>
					<tr>
						<th>설명</th>
						<td>
		         			<c:choose>
		         				<c:when test="${fn:contains(param.loc, '/student/list')}">
		         					수험생 등록 (학번 선택용)
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/user/list')}">
		         					학생 등록 (학생 관리용)
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/course/list')}">
		         					교과목 등록 (교과목 이수관리용)
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/subject/list')}">
		         					교과목 등록 (교과목관리용)
		         				</c:when>
			         			<c:otherwise>
			         				없음
			         			</c:otherwise>
		         			</c:choose>
						</td>
					</tr>
		         	<tr>
		         		<th>엑셀양식</th>
		         		<td>
		         			<c:choose>
		         				<c:when test="${fn:contains(param.loc, '/student/list')}">
		         					<button type="button" class="lbtn btn03" onclick="location.href='${codes.context}/student/sample.do';">다운로드</a>
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/user/list')}">
		         					<button type="button" class="lbtn btn03" onclick="location.href='${codes.context}/user/sample.do';">다운로드</a>
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/course/list')}">
		         					<button type="button" class="lbtn btn03" onclick="location.href='${codes.context}/course/sample.do';">다운로드</a>
		         				</c:when>
		         				<c:when test="${fn:contains(param.loc, '/subject/list')}">
		         					<button type="button" class="lbtn btn03" onclick="location.href='${codes.context}/subject/sample.do';">다운로드</a>
		         				</c:when>
			         			<c:otherwise>
			         				없음
			         			</c:otherwise>
		         			</c:choose>
		         		</td>
		         	</tr>
		         	<tr>
		         		<th>파일선택</th>
		         		<td>
		         			<input type="file" name="excel_files" class="_req" title="엑셀파일을 선택하세요"/>
		         		</td>
		         	</tr>
		         </tbody>
		    </table>
			<div class="table_btns tbl_center">
				<button type="submit" title="저장" class="btn-save">저장</button>
			</div>
		</form:form>
	</div>
</div>