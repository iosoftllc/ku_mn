<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_view.css" />
					
    <section class="board_view">
        <div>
            <article>
                <div class="title ${empty isNew ? '' : 'new' }"><a>${cmd.title }<span></span></a></div>

                <dl class="info view">
                    <dt class="date"><p><iosf:date format="${configs.FORMAT_DATEE}" value="${cmd.reg_dt }" /></p></dt>
                    <dt class="viewcount"><b>조회:&nbsp;</b><p>${cmd.viewcnt }</p></dt>
                </dl>
            </article>

            <article class="document">
                <div>
                    ${cmd.html == '0' ? fn:replace(cmd.contents, lf, '<br/>') : cmd.contents }
                </div>
            </article>
			
            <div class="btn">
                <dl>
                    <dt class="left"><button type="button" onclick="location.href = '${url_up }?${iosf:params('')}';">목록</button></dt>
                </dl>
            </div>

        </div>
    </section> 
