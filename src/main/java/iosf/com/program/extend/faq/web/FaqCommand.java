package iosf.com.program.extend.faq.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class FaqCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private Long seq;
	private String faq_type;
	private String title;
	private String contents;
	private String inip;
	private String search_faq_type;
}
