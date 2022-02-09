package iosf.com.generic.web;

import java.util.HashMap;
import java.util.Map;

import org.apache.commons.beanutils.BeanUtils;
import org.apache.commons.lang3.StringUtils;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;
import org.supercsv.io.CsvMapWriter;
import org.supercsv.prefs.CsvPreference;

import egovframework.rte.ptl.mvc.tags.ui.pagination.PaginationInfo;
import iosf.com.generic.service.GenericService;
import iosf.com.support.util.Functions;

/**
 * Generic Controller for AJAX
 * 
 * @author Park sung hyun
 * 
 * @param <S>
 * @param <C>
 */
public class GenericGridController<S extends GenericService<C>, C extends GenericCommand> extends GenericController<S, C> {
	@Override
	public ModelAndView list(C cmd, @PathVariable Map<String, String> vars) throws Exception {
		// TODO Auto-generated method stub
		cmd.setLoad_yn("N");
		return super.list(cmd, vars);
	}

	@RequestMapping("/grid")
	@ResponseBody
	public GenericCommand ajaxlist(@ModelAttribute C cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setPage_count_use_yn("Y");
		cmd.setPage_use_yn("Y");

		/** pageing setting */
		if (Integer.parseInt(StringUtils.defaultIfEmpty(cmd.getPage(), "0")) <= 0) {
			cmd.setCurrent_page_no(1);
		} else {
			cmd.setCurrent_page_no(Integer.parseInt(cmd.getPage()));
		}
		if (Integer.parseInt(StringUtils.defaultIfEmpty(Functions.getReq().getParameter("rows"), "0")) <= 0) {
			cmd.setRecord_count_per_page(super.getPropertyService().getInt("pageUnit"));
		} else {
			cmd.setRecord_count_per_page(Integer.parseInt(Functions.getReq().getParameter("rows")));
		}
		if (cmd.getPage_size() <= 0) {
			cmd.setPage_size(super.getPropertyService().getInt("pageSize"));
		}

		PaginationInfo paginationInfo = new PaginationInfo();
		paginationInfo.setCurrentPageNo(cmd.getCurrent_page_no());
		paginationInfo.setRecordCountPerPage(cmd.getRecord_count_per_page());
		paginationInfo.setPageSize(cmd.getPage_size());

		cmd.setFirst_index(paginationInfo.getFirstRecordIndex());
		cmd.setLast_index(paginationInfo.getLastRecordIndex());
		cmd.setRecord_count_per_page(paginationInfo.getRecordCountPerPage());

		getService().getList(cmd);

		paginationInfo.setTotalRecordCount(cmd.getTotal_record_count());

		GenericCommand _cmd = new GenericCommand();
		_cmd.setPage(cmd.getPage());
		_cmd.setTotal(((paginationInfo.getTotalRecordCount() % paginationInfo.getRecordCountPerPage() == 0 ? paginationInfo.getTotalRecordCount() : paginationInfo.getTotalRecordCount() + paginationInfo.getRecordCountPerPage()) / paginationInfo.getRecordCountPerPage()));
		_cmd.setRecords("" + cmd.getTotal_record_count());
		_cmd.setRows(cmd.getList());
		return _cmd;
	}

	@SuppressWarnings("unchecked")
	@RequestMapping("/grid/export")
	public void export(@ModelAttribute C cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setPage_count_use_yn("N");
		cmd.setPage_use_yn("N");
		getService().getList(cmd);

		String filename = StringUtils.defaultIfEmpty(Functions.getReq().getParameter("title"), "ExportData") + "_" + Functions.getTimeStamp() + ".csv";

		Functions.getRes().setContentType("text/csv; charset=MS949");
		String headerKey = "Content-Disposition";
		String headerValue = String.format("attachment; filename=\"%s\"", filename);
		Functions.getRes().setHeader(headerKey, headerValue);

		CsvMapWriter csvWriter = new CsvMapWriter(Functions.getRes().getWriter(), CsvPreference.STANDARD_PREFERENCE);

		String[] header = cmd.getHeader_names().split(",");
		String[] column = cmd.getColumn_keys().split(",");

		csvWriter.writeHeader(header);

		for (int i = 0; i < cmd.getList().size(); i++) {
			C _cmd = (C) cmd.getList().get(i);
			Map<String, String> map = new HashMap<String, String>();
			for (int j = 0; j < column.length; j++) {
				String key = column[j];
				String key_value = BeanUtils.getProperty(_cmd, key);
				map.put(key, StringUtils.defaultIfEmpty(key_value, ""));
			}
			csvWriter.write(map, column);
		}

		csvWriter.close();
	}
}
