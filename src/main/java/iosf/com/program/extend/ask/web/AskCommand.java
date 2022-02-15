package iosf.com.program.extend.ask.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class AskCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private Long seq;
	private String idno;
	private String idnos;
	private String ask_type;
	private String title;
	private String contents;
	private String phone;
	private String email;
	private String answer_id;
	private String answer_contents;
	private String answer_date;
	private String stat;
	private String inip;
	private String search_ask_type;

}
