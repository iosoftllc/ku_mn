package iosf.com.program.extend.mobile.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class MobileCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private String idno;
	private String idnos;
	private String issuedate;
	private String issuedegree;
	private String cardtypename;
	private String cardconname;
}
