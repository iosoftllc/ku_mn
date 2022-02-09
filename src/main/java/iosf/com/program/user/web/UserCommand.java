package iosf.com.program.user.web;

import java.sql.Date;
import java.util.List;

import iosf.com.generic.web.GenericCommand;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class UserCommand extends GenericCommand {

	private static final long serialVersionUID = 1L;

	private String user_group_cd;
	private String std_id;
	private String dept_cd;
	private String dept_nm;
	private String std_ids;
	private String dept_cds;
	private String dept_nms;
	private String pos_nm;
	private String tel;
	private String cp;
	private String cp_1;
	private String cp_2;
	private String cp_3;
	private String college;
	private String college_nm;
	private String grade;
	private String position_nm;
	private String major_nm;
	private Long[] user_seqs;
	private String mobile;
	private String phone;
	private String memo;
	private String sep_cd;
	private String session_key;
	private String status_nm;
	private String credit;
	private String agree_yn;
	private String penalty_yn;
	private String h_dept_cd;
	private Date session_limit;
	private List<String> search_types;
	private byte[] blob_picture;
	private String type;
	private boolean isStu;
	private boolean isStaff;
	private String group_id;
	private String group_ids;
	private String search_penalty;
	private String auth_cd;
}