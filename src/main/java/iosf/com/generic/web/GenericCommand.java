package iosf.com.generic.web;

import java.io.Serializable;
import java.util.List;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class GenericCommand implements Serializable {

	private static final long serialVersionUID = 1L;

	private Long seq;
	private Long[] seqs;
	private String cd_id;
	private Long user_seq;
	private String user_type;
	private String user_id;
	private String user_nm;
	private String user_sep;
	private String user_ip;
	private String pwd;
	private String email;
	private String attach_idx;
	private String attach_idx_main;
	private String attach_idx_sub1;
	private String attach_idx_sub2;
	private String attach_idx_sub3;
	private String attach_idx_sub4;
	private String attach_idx_sub5;
	private String use_yn;
	private String del_yn;
	private String reg_dt;
	private String reg_id;
	private String reg_nm;
	private String mod_dt;
	private String mod_id;
	private String mod_nm;
	private Long[] ids;
	private Long[] id_checks;
	private String header_names;
	private String column_keys;
	private String token_key;

	private String language;
	private String lang;
	private String search_use_yn;
	private String search_field;
	private String search_keyword;
	private String search_keyword_detail;
	private String search_start_dt;
	private String search_end_dt;
	private String thumb_yn;
	private String thumb_size;

	private int ordr;
	private int current_page_no;
	private int record_count_per_page;
	private int first_index;
	private int last_index;
	private int total_record_count;
	private int page_size;
	private String page_use_yn;
	private String page_count_use_yn;
	private String find_query_use_yn;
	private String load_yn;
	private String order_by;
	private int news;
	private List<?> list;
	private List<?> sub_list;

	private String test_yn;
	private String json_data;

	private String seq_no;
	private String records;
	private int total;
	private String page;
	private String sidx;
	private String sord;
	private String code;
	private String name;
	private List<?> rows;
}
