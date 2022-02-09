package iosf.com.generic.web;

import java.util.Map;

import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.support.util.Functions;

/**
 * Generic Common Page Controller
 * 
 * @author Park sung hyun
 * 
 */
public class GenericCommonController {
	@RequestMapping(value = { "/front/common/{page:.+}", "/back/common/{page:.+}", "/back/common/popup/{page:.+}", "/front/common/popup/{page:.+}" })
	protected String common(@PathVariable Map<String, String> vars) throws Exception {
		Functions.getReq().setAttribute("page", vars.get("page"));
		return Functions.getReq().getServletPath();
	}
}
