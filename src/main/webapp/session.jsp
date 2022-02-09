<%@page import="iosf.com.program.api.univ.korea.util.KoreaUnivAPIUtil"%>
<%@page import="iosf.com.program.log.util.LogUtil"%>
<%@page import="iosf.com.program.log.web.LogCommand"%>
<%@page import="org.json.simple.JSONArray"%>
<%@page import="org.json.simple.JSONObject"%>
<%@page import="iosf.com.program.extend.event.submit.service.EventSubmitService"%>
<%@page import="iosf.com.support.util.ApplicationHelper"%>
<%@page import="iosf.com.program.extend.event.submit.web.EventSubmitCommand"%>
<%@page import="org.apache.commons.beanutils.PropertyUtils"%>
<%@page import="java.util.Map.Entry"%>
<%@page import="java.util.HashMap"%>
<%@page import="java.util.Map"%>
<%@page import="org.apache.commons.beanutils.BeanUtils"%>
<%@page import="java.util.Enumeration"%>
<%@page import="iosf.com.program.user.web.UserCommand"%>
<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="/WEB-INF/jsp/iosf/com/sys/taglibs.jspf"%>
<%@ include file="/WEB-INF/jsp/iosf/com/sys/setCodes.jspf"%>
<%
	UserCommand cmd = (UserCommand) request.getAttribute("user");
	if (cmd == null) {
		response.sendRedirect("/front/user/login");
	}

	if (null != request.getParameter("mode")) {
		BeanUtils.populate(cmd, request.getParameterMap());
		request.getSession().setAttribute(Constants.SESSION_USERINFO, cmd);

		// 학번인 경우 수험번호 신청서 업데이트 처리
		int i = 0;
		for (String group_id : cmd.getGroup_ids().split(":")) {
			if (group_id.contains("L") || group_id.contains("H")) {
				String std_id = cmd.getStd_ids().split(":")[i];
				String log_result = Constants.LOG_RESULT_OK;
				String log_desc = "";

				EventSubmitCommand eventSubmitCmd = new EventSubmitCommand();
				eventSubmitCmd.setUser_id(cmd.getUser_id());
				eventSubmitCmd.setStd_id(std_id);

				EventSubmitService eventSubmitService = (EventSubmitService) ApplicationHelper.getService("eventSubmitService", request.getServletContext());
				JSONArray list = KoreaUnivAPIUtil.getData("reslifeexamno", eventSubmitCmd.getStd_id());
				for (int j = 0; j < list.size(); j++) {
					JSONObject data = (JSONObject) list.get(j);

					eventSubmitCmd.setExam_no(data.get("reslifeexamno_2").toString());
					eventSubmitCmd.setBirth_dt(data.get("reslifeexamno_3").toString());

					try {
						eventSubmitService.updateUserId(eventSubmitCmd);
						log_desc = data.get("reslifeexamno_2").toString() + " -> " + std_id + " 업데이트 성공";
					} catch (Exception e) {
						// TODO Auto-generated catch block
						log_result = Constants.LOG_RESULT_FAIL;
						log_desc = data.get("reslifeexamno_2").toString() + " -> " + std_id + " 업데이트 실패";
						e.printStackTrace();
					} finally {
						// Log DB
						LogUtil logUtil = (LogUtil) ApplicationHelper.getService("logUtil", request.getServletContext());
						LogCommand logCmd = new LogCommand();
						logCmd.setSep_cd("KUAPI-UPD");
						logCmd.setDescription(log_desc);
						logCmd.setResult_cd(log_result);
						logUtil.insert(logCmd);
					}
				}
			}
			i++;
		}
	}
%>
<c:if test="${!isStaff || !isUser }">
	<c:redirect url="/"/>
</c:if>
<html>
<head>
<script type="text/javascript" src="${js_src}/jquery-1.12.4.min.js"  charset="UTF-8"></script>
<script type="text/javascript">
/*
 dept_cd	AA08002
 user_id	eswing
 dept_cds	AA08002:
 dept_nm	전산개발부
 group_ids	EC:
 std_id		eswing
 user_nm	STM
 std_ids	eswing:
 sep_cd	 	I
 dept_nms	전산개발부
*/
var data_case = {};
$(function(){
	var data = {
		'user_id' :	''
		, 'user_nm' :	''
		, 'std_id' :	''
		, 'std_ids' :	''
		, 'dept_cd' : 	''
		, 'dept_cds' :	''
		, 'dept_nm' :	''
		, 'dept_nms' :	''
		, 'group_ids' :	''
		, 'sep_cd' : 	'I'
	};
	// case 1
	// 학부재학 RL1
	// 학점교류학부재학 IL1
	// 교환학부재학 CL1
	// 대학원재학 RH1 (법전원)
	// 학점교류대학원학 IH1
	// 교환대학원재학 CH1
	// 교원재직 P1
	
	// 학부재학 RH1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'junelee0617', 'user_nm' : '이준석'
			, 'std_id' : '2021170912'
			, 'group_id' : 'RL1'
			, 'dept_cd' : 'AB01126'
			, 'dept_nm' : '전기전자공학부'
			, 'std_ids' : '2021170912:'
			, 'group_ids' : 'RL1:'
			, 'dept_cds' : 'AB01126:'
			, 'dept_nms' : '전기전자공학부:'
	};
	data_case['정규학부A'] = data;
	// 학부재학 RH1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'eunie', 'user_nm' : '이정은'
			, 'std_id' : '2021140088'
			, 'group_id' : 'RL1'
			, 'dept_cd' : 'AN00354'
			, 'dept_nm' : '생병과학부'
			, 'std_ids' : '2021140088:'
			, 'group_ids' : 'RL1:'
			, 'dept_cds' : 'AN00354:'
			, 'dept_nms' : '생병과학부:'
	};
	data_case['정규학부B'] = data;
	// 학점교류학부재학 IL1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'riritp', 'user_nm' : '문혜원'
			, 'std_id' : '2021KU0259'
			, 'group_id' : 'IL1'
			, 'dept_cd' : ''
			, 'dept_nm' : ''
			, 'std_ids' : '2021KU0259:'
			, 'group_ids' : 'IL1:'
			, 'dept_cds' : ':'
			, 'dept_nms' : ':'
	};
	data_case['학점교류학부'] = data;
	// 교환학부재학 CL1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'cindylu', 'user_nm' : 'Cindy Lu'
			, 'std_id' : '2021961552'
			, 'group_id' : 'CL1'
			, 'dept_cd' : ''
			, 'dept_nm' : '' 
			, 'std_ids' : '2021961552:'
			, 'group_ids' : 'CL1:'
			, 'dept_cds' : ':'
			, 'dept_nms' : ':' 
	};
	data_case['교환학부'] = data;
	// 대학원재학 RH1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'lawyerhong', 'user_nm' : '홍지형'
			, 'std_id' : '2021592203'
			, 'group_id' : 'RH1'
			, 'dept_cd' : 'AN00806'
			, 'dept_nm' : 'LAW SCHOOL'
			, 'std_ids' : '2021592203:'
			, 'group_ids' : 'RH1:'
			, 'dept_cds' : 'AN00806:'
			, 'dept_nms' : 'LAW SCHOOL:'
	};
	data_case['정규대학원'] = data;
	// 학점교류대학원재학 IH1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'feliza5520', 'user_nm' : 'WANG RONGRONG'
			, 'std_id' : '2021KG0092'
			, 'group_id' : 'IH1'
			, 'dept_cd' : ''
			, 'dept_nm' : ''
			, 'std_ids' : '2021KG0092:'
			, 'group_ids' : 'IH1:'
			, 'dept_cds' : ':'
			, 'dept_nms' : ':'
	};
	data_case['학점교류대학원'] = data;
	// 교환대학원재학 CH1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'simondenys', 'user_nm' : 'DE NYS SIMON OLIVER D'
			, 'std_id' : '2021961159'
			, 'group_id' : 'CH1'
			, 'dept_cd' : ''
			, 'dept_nm' : ''
			, 'std_ids' : '2021961159:'
			, 'group_ids' : 'CH1:'
			, 'dept_cds' : ':'
			, 'dept_nms' : ':'
	};
	data_case['교환대학원'] = data;
	// 교원재직 P1
	var data = {
			'sep_cd' : 'I', 'user_id' : 'soo0747', 'user_nm' : '천현숙'
			, 'std_id' : '170717'
			, 'group_id' : 'P1'
			, 'dept_cd' : 'AB01142'
			, 'dept_nm' : '건축학과'
			, 'std_ids' : '170717:'
			, 'group_ids' : 'P1:'
			, 'dept_cds' : 'AB01142:'
			, 'dept_nms' : '건축학과:'
	};
	data_case['교원'] = data;
	
	// case 2
	// 대학원재학 + 교원재직
	var data = {
			'sep_cd' : 'I', 'user_id' : 'anjelus', 'user_nm' : '서원준'
			, 'std_id' : '112431'
			, 'group_id' : 'P1'
			, 'dept_cd' : 'AB01150'
			, 'dept_nm' : '의학과'
			, 'std_ids' : '2020010925:112431'
			, 'group_ids' : 'RH1:P1'
			, 'dept_cds' : 'AB02517:AB01150'
			, 'dept_nms' : '의학과:의학과'
	};
	data_case['대학원+교원'] = data;
	// 교원재직 + 교원재직
	var data = {
			'sep_cd' : 'I', 'user_id' : 'yungcp', 'user_nm' : '박영철'
			, 'std_id' : '110234'
			, 'group_id' : 'P1'
			, 'dept_cd' : 'AB01094'
			, 'dept_nm' : '경제학과'
			, 'std_ids' : '110234:144027'
			, 'group_ids' : 'P1:P1'
			, 'dept_cds' : 'AB01094:AB01227'
			, 'dept_nms' : '경제학과:국제학부'
	};
	data_case['교원+교원'] = data;

	// case 3
	// 학부졸업 + 대학원재학
	var data = {
			'sep_cd' : 'I', 'user_id' : 'dhfydrkr', 'user_nm' : '주훈철'
			, 'std_id' : '2021591032'
			, 'group_id' : 'RH1'
			, 'dept_cd' : 'AN00806'
			, 'dept_nm' : 'LAW SCHOOL'
			, 'std_ids' : '2021591032:2017120161'
			, 'group_ids' : 'RH1:GL'
			, 'dept_cds' : 'AN00806:AB01014'
			, 'dept_nms' : 'LAW SCHOOL:경영학과'
	};
	data_case['학부졸+대학원'] = data;
	// 대학원졸업 + 교원재직
	var data = {
			'sep_cd' : 'I', 'user_id' : 'starsen', 'user_nm' : '한선미'
			, 'std_id' : '170967'
			, 'group_id' : 'P1'
			, 'dept_cd' : 'AB02677'
			, 'dept_nm' : '교육대학원'
			, 'std_ids' : '170967:2014425129'
			, 'group_ids' : 'P1:GH'
			, 'dept_cds' : 'AB02677:AB02712'
			, 'dept_nms' : '교육대학원:평생교육전공'
	};
	data_case['대학원졸+교원'] = data;
	
	for (var row in data_case) {
		$('#buttons').append('&nbsp;<button onclick="_setUser(\'' + row + '\')">' + row +'</button>');
	}
});

_setUser = function(key) {
	for (var row in data_case[key]) {
		$('#' + row).val(data_case[key][row]);
	}
}
</script>
</head>
<body>
<a href="/">HOME</a>
<div id="buttons">
</div>
<form action="?mode=change" method="post">
<table>
<%

Map<String, Object> map = new HashMap<String, Object>();
map = PropertyUtils.describe(cmd);
for (Entry<String, Object> el : ((Map<String, Object>) map).entrySet()) {
	System.out.println(el.getKey());
	if (!(map.get(el.getKey()) instanceof String)) {
		continue;
	}
%>
<tr>
	<th>
		<%=el.getKey() %>
	</th>
	<td>
		<input type="text" name="<%=el.getKey() %>" id="<%=el.getKey() %>" value="<%=map.get(el.getKey())%>"/>
	</td>
</tr>
<%
}
%>
</table>
<div>
	<button type="submit">Change!!</button>
	<button type="reset">Reset!!</button>
</div>
</form>
</body>
</html>