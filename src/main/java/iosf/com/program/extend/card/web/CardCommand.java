package iosf.com.program.extend.card.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class CardCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private String idno;
	private String idnos;
	private String issuedate;
	private String issuedegree;
	private String iccardflag;
	private String icname;
	private String issuereasoncode;
	private String issuereasonname;
	private String issueplace;
	private String issueplacename;
	private String remark;
}
