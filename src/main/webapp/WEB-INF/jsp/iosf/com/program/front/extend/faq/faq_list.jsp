<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="../../../../sys/taglibs.jspf"%>
<%@ include file="../../../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src}/iosf/front/board_faq.css" />
<script type="text/javascript" src="${js_src }/iosf/front/contents/board_faq.js"></script>

    <section class="board_faq">
        <div>
            <article class="tab">
                <dl>
                    <dt><a href="${url }" class="${empty param.search_faq_type ? 'on' : '' }">전체</a></dt>
                	<c:forEach var="row" items="${codes.MobileCardFaqType }" varStatus="i">
	                    <dt><a href="${url }?search_faq_type=${row.key}" class="${row.key == param.search_faq_type ? 'on' : '' }">${row.value }</a></dt>
                	</c:forEach>
                </dl>
            </article>
            
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
                    <button type="submit">검색</button>
                </form:form>
            </article>
            
            <article class="faq_list">
				<c:forEach var="row" items="${cmd.list}" varStatus="i">
	                <dl>
	                    <dt>
	                        <div>
	                            <span>질문</span>
	                            <small><iosf:code upcd="MobileCardFaqType" cd="${row.faq_type }"/> </small>
	                            <p>${row.title }</p>
	                        </div>
	                        <button type="button"></button>
	                    </dt>
	                    <dd>
	                        <div>
	                            <span>답변</span>
	                            <p>
	                            	${fn:replace(row.contents, lf, '<br/>') }
	                            </p>
	                            <button type="button">닫기</button>
	
	                        </div>
	                    </dd>
	                </dl>
				</c:forEach>
				<c:if test="${empty cmd.list}">
                    <p>데이터가 존재하지 않습니다.</p>
				</c:if>
            </article>
          
          	<iosf:paging/>
          
        </div>
    </section>