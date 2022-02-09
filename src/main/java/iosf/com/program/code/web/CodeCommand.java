package iosf.com.program.code.web;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

/**
 * 
 */
@Getter
@Setter
public class CodeCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private Long[] cd_seqs;
	private String[] cd_ids;
	private String[] cd_nms;
	private String[] memos;
	private String[] use_yns;
	private String[] lock_yns;
	private Long cd_seq;
	private String cd_nm;
	private Long up_cd_seq;
	private String memo;
	private int ord_no;
	private String lock_yn;

}
