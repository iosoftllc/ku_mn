<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_view.css" />
					
    <section class="board_view">
        <div>
            <article>
                <div class="status">
                    <b class="color${cmd.stat == '2' ? '2' : '1' } on"><iosf:code upcd="MobileCardAskStat" cd="${cmd.stat }"/></b>
                </div>
                <div class="title ${empty isNew ? '' : 'new' }"><a>[<iosf:code upcd="MobileCardAskType" cd="${cmd.ask_type }"/>] ${cmd.title }<span></span></a></div>

                <dl class="info view">
                    <dt class="date"><p><iosf:date format="${configs.FORMAT_DATEE}" value="${cmd.reg_dt }" /></p></dt>
                </dl>
            </article>

            <article class="document">
                <div>
                    ${fn:replace(cmd.contents, lf, '<br/>') }
                </div>
            </article>
			
			<c:if test="${!empty cmd.answer_date && cmd.stat == '2' }">
	            <article class="reply">
	                <dl class="info">
	                    <dt><small>답변</small></dt>
	                    <dt class="date"><p><iosf:date format="${configs.FORMAT_DATEE}" value="${cmd.answer_date }" /></p></dt>
	                </dl>
	            </article>
	            
	            <article class="document">
	                <div>
	                    ${fn:replace(cmd.answer_contents, lf, '<br/>') }
	                </div>
	            </article>
			</c:if>
            
            <div class="btn">
                <dl>
                    <dt class="left"><button type="button" onclick="location.href = '${url_up }?${iosf:params('')}';">목록</button></dt>
                   	<dt class="right"><button class="edit ${cmd.stat == '0' ? '' : 'hide' }" type="button" onclick="location.href = '${url }/write?${iosf:params('')}';" id="btn_update">수정</button></dt>
                    <dt class=""><button class="delete" type="button" onclick="doDelete('삭제하시겠습니까?', null, false, false);" class="${cmd.stat == '0' ? '' : 'hide' }" id="btn_delete">삭제</button></dt>
                </dl>
            </div>

        </div>
    </section> 
