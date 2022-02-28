package iosf.com.program.extend.entrance.service.impl;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.springframework.stereotype.Service;

import egovframework.rte.fdl.cmmn.exception.EgovBizException;
import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.entrance.service.EntranceService;
import iosf.com.program.extend.entrance.web.EntranceCommand;
import iosf.com.support.util.Functions;

@Service("entranceService")
public class EntranceServiceImpl extends GenericServiceImpl<EntranceMapper, EntranceCommand> implements EntranceService {
	@Override
	public EntranceCommand getList(EntranceCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		String num = "63"; // 해당 페이지 API 키 생성용 지정값
		int num_i = Integer.parseInt(num);
		java.util.Date ToDay = new java.util.Date();
		SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMddHH");
		String date = sdf.format(ToDay);
		int ymd_i = Integer.parseInt(date.substring(0, 8));
		int date_i = ymd_i * num_i;
		String key = Integer.toHexString(date_i) + date.substring(8, 10);

		String url_key = "http://fm01.iptime.org:8080/quad/api_skg.jsp";

		String response = Functions.httpURLConnection(url_key + "?n=" + num, null, "GET");
		if (response == null) {
			return new EntranceCommand();
		}

		String api_key = response.substring(response.length() - 10);
		String url_res = "http://cafm.korea.ac.kr/archibus/api_2eca7a3d21.jsp";

		response = Functions.httpURLConnection(url_res + "?key=" + key + "&id_no=" + getUser().getStd_id(), null, "GET");
		if (response == null) {
			return new EntranceCommand();
		}

		JSONParser parser = new JSONParser();
		JSONObject obj = (JSONObject) parser.parse(response);
		if (obj == null) {
			return new EntranceCommand();
		}
		String flag = (String) obj.get("flag");
		if (flag == null || "0101".equals(flag)) {
			throw new EgovBizException("Failure receive reservation data");
		} else if (!"0000".equals(flag)) {
			return new EntranceCommand();
		}

		JSONArray arr = (JSONArray) obj.get("result");
		if (arr == null) {
			return new EntranceCommand();
		}

		List<EntranceCommand> list = new ArrayList<EntranceCommand>();
		for (Object row : arr) {
			if (row == null) {
				return new EntranceCommand();
			}

			JSONObject _row = (JSONObject) row;
			EntranceCommand _cmd = new EntranceCommand();
			_cmd.setEm_name((String) _row.get("em_name"));
			_cmd.setFl_name((String) _row.get("fl_name"));
			_cmd.setDate_start((String) _row.get("date_start"));
			_cmd.setRm_id((String) _row.get("rm_id"));
			_cmd.setBl_id((String) _row.get("bl_id"));
			_cmd.setDate_end((String) _row.get("date_end"));
			_cmd.setFl_id((String) _row.get("fl_id"));
			_cmd.setRm_name((String) _row.get("rm_name"));
			_cmd.setBl_name((String) _row.get("bl_name"));

			list.add(_cmd);
		}

		cmd.setTotal_record_count(list.size());
		cmd.setList(list);
		return cmd;
	}
}
