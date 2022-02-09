<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../../sys/setCodes.jspf"%>
<c:set var="isQna" value="${mcmd.layout_cd == 'qna' && cmd.notice_yn == 'N'}"/>
<c:set var="isRepairBoard" value="${mcmd.board_seq == 3}"/>

<link rel="stylesheet" href="${css_src}/iosf/front/board_view.css" />
					
    <section class="board_view">
        <div>
            <article>
                <div class="status">
                	<c:if test="${!empty cmd.category_cd}">
                    	<small class="on"><iosf:code upcd="board_category_cd" cd="${cmd.category_cd }"/></small>
                    </c:if>
					<c:if test="${isQna}">
						<c:if test="${empty cmd.a_reg_dt}">
                    		<b class="color1 on">답변대기</b>
                    	</c:if>
						<c:if test="${!empty cmd.a_reg_dt}">
	                    	<b class="color2 on">답변완료</b>
                    	</c:if>
                    </c:if>
                </div>
                <div class="title ${empty isNew ? '' : 'new' }"><a>${cmd.title }<span></span></a></div>

                <dl class="info view">
                	<c:if test="${isQna}">
                    	<dt class="name"><p>${cmd.reg_nm }</p></dt>
                    </c:if>
                    <dt class="date"><p><iosf:date format="${configs.FORMAT_DATEE}" value="${cmd.reg_dt }" /></p></dt>
                    <dt class="viewcount"><b>조회:&nbsp;</b><p>${cmd.hit_cnt }</p></dt>
                </dl>

            </article>

            <article class="document">
            	<c:if test="${isRepairBoard}">
	                <dl>
	                    <dt>부재시 수리 여부</dt>
	                    <dt><iosf:code upcd="board_busy" cd="${cmd.q_data1 }"/></dt>
	                    <dt>호실</dt>
	                    <dt>${cmd.q_data2 }</dt>
	                </dl>
                </c:if>
                <div>
                    ${cmd.content }
                </div>
            </article>
		
			<c:import url="/front/attach/embed" charEncoding="UTF-8">
				<c:param name="attach_idx" value="${cmd.attach_idx}" />
				<c:param name="url" value="${url}" />
			</c:import>
        
			<c:if test="${isQna && !empty cmd.a_reg_dt }">
	            <article class="reply">
	                <dl class="info">
	                    <dt><small>답변자</small></dt>
	                    <dt class="name"><p>안암학사</p></dt>
	                    <dt class="date"><p><iosf:date format="${configs.FORMAT_DATEE}" value="${cmd.a_reg_dt }" /></p></dt>
	                </dl>
	            </article>
	
	            <article class="document">
	                <div>
	                    ${cmd.reply_content }
	                </div>
	            </article>
            
				<c:import url="/front/attach/embed" charEncoding="UTF-8">
					<c:param name="attach_idx" value="${cmd.attach_idx_sub1}" />
					<c:param name="url" value="${url}" />
				</c:import>
			</c:if>
			
            <div class="btn">
                <dl>
                    <dt class="left"><button type="button" onclick="location.href = '${url_up }?${iosf:params('')}';">목록</button></dt>
                    <c:if test="${isQna && isAdmin }">
                    	<dt class="right"><button class="edit" type="button" onclick="window.open('${configs.CONTEXT }/back/board/post/${cmd.board_post_seq }/write?${iosf:params('')}', '', '')" id="btn_update">답변</button></dt>
                    </c:if>
                    <c:if test="${isQna && user.user_id == cmd.reg_id }">
                    	<dt class="right"><button class="edit" type="button" onclick="location.href = '${url }/write?${iosf:params('')}';" id="btn_update" ${empty cmd.a_reg_dt ? '' : 'disabled="disabled"' }>수정</button></dt>
	                    <dt class=""><button class="delete" type="button" onclick="doDelete('삭제하시겠습니까?', null, false, false);" clazz="${isInsert ? 'hide' : '' }" ${empty cmd.a_reg_dt ? '' : 'disabled="disabled"' } id="btn_delete">삭제</button></dt>
                    </c:if>
                </dl>
            </div>

        </div>
    </section> 
