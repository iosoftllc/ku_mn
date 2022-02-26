package iosf.com.program.extend.entrance.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class EntranceCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private String em_name;
	private String fl_name;
	private String date_start;
	private String rm_id;
	private String bl_id;
	private String date_end;
	private String fl_id;
	private String rm_name;
	private String bl_name;
	private String flag;
	private String message;
}
