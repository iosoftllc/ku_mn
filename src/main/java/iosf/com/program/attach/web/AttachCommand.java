package iosf.com.program.attach.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class AttachCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private Long attach_seq;
	private String file_nm;
	private String file_path;
	private long file_size;
	private String file_type;
	private String file_ext;
	private String caption;
	private int ord_no;
}
