package iosf.com.support.taglib;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import egovframework.rte.ptl.mvc.tags.ui.pagination.PaginationInfo;
import iosf.com.support.util.Functions;

public class PagingTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Paging");
		JspWriter out = getJspContext().getOut();
		String html = "";

		// Paging
		PaginationInfo cmd = new PaginationInfo();
		cmd = (PaginationInfo) Functions.getReq().getAttribute("paginationInfo");

		int total_page = ((cmd.getTotalRecordCount() % cmd.getRecordCountPerPage() == 0 ? cmd.getTotalRecordCount() : cmd.getTotalRecordCount() + cmd.getRecordCountPerPage()) / cmd.getRecordCountPerPage());
		int current_page = cmd.getCurrentPageNo();
		int page_start = 0;
		int page_end = 0;

		if (total_page - (current_page - 1) > 10) {
			page_start = current_page;
			page_end = current_page + 9;
			if (current_page > 1) {
				page_start = current_page - 1;
				page_end = current_page + 8;
			} else if (current_page > 2) {
				page_start = current_page - 2;
				page_end = current_page + 7;
			}
		} else {
			page_start = 1;
			page_end = total_page;
			if (current_page > 10) {
				page_start = total_page - 9;

				if (total_page - (current_page - 1) > 9) {
					page_start--;
					page_end--;
				}
			}
		}

		String uri = (String) Functions.getReq().getAttribute("javax.servlet.forward.request_uri");
		if (uri == null) {
			uri = Functions.getReq().getRequestURI();
		}

		String prev = Integer.toString(current_page != 1 ? current_page - 1 : 1);
		String next = Integer.toString(total_page != current_page ? current_page + 1 : total_page);
		String last = Integer.toString(total_page);

		Map<String, Object> map = new HashMap<String, Object>();
		map.put("url", uri);
		map.put("param", Functions.getQueryString("current_page_no"));
		map.put("first_title", "1 " + Functions.getMessage("페이지"));
		map.put("prev", prev);
		map.put("prev_title", prev + " " + Functions.getMessage("페이지"));
		map.put("next", next);
		map.put("next_title", next + " " + Functions.getMessage("페이지"));
		map.put("last", last);
		map.put("last_title", last + " " + Functions.getMessage("페이지"));
		map.put("page_title", Functions.getMessage("페이지"));
		map.put("page_start", page_start < 1 ? 1 : page_start);
		map.put("page_end", page_end < page_start ? page_start : page_end);
		map.put("current_page", current_page);

		try {
			html = Functions.getComponents("paging" + (uri.contains("/front/") ? "_front" : "_back"), map);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		out.print(html);

		super.doTag();
	}
}