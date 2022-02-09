<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>고려대학교 안암학사</title>
</head>
<body style="line-height: 1; margin:0;">
<div style="width:720px;padding:10px;">	
	<div style="border: 1px solid #a91539;border-radius: 6px;padding: 50px 30px 40px 30px;">
		<div style="overflow:hidden; padding:20px 30px 20px 30px; background:#4a4a4a; border-top:1px solid #000; border-bottom: 1px solid #000;">
			<span style="float:left;width:59px;height:54px;background: url(${protocol}://${domain}/images/iosf/mail/icon-emailbanner.png) no-repeat;">&nbsp;</span>
			<span style="float:left;margin-top:8px; margin-left:15px; color:#dcdcdc; font:normal 15px 'Malgun Gothic';">
				Hello. 고려대학교 안암학사에서 입사 신청이 완료되었음을 알려드립니다.
			</span>
		</div>
		
        <div style="margin-top:20px; padding-left:25px; height:20px; font-size: 17px; line-height: 17px; color: #85504e; font-family: 'Malgun Gothic'; background: url(${protocol}://${domain}/images/iosf/back/bul/bul_05.jpg) no-repeat 0 2px ;">입사 신청 정보</div>        
        <table style="width: 100%; margin-top: 10px; border-spacing: 0; border-collapse: separate; border-top: 1px solid #a59175; border-bottom: 2px solid #3a3a3a; ">
			<colgroup>
				<col width="93px">
				<col width="">
			</colgroup>
			<tbody>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">모집명</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">${title}</td>
				</tr>
				<#if anno_start_dt?has_content>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">발표기간</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">${anno_start_dt} ~ ${anno_end_dt}</td>
				</tr>
				</#if>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">납부기간</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">
						<#if pay_start_dt?has_content>
							${pay_start_dt} ~ ${pay_end_dt}
						<#else>
							수시
						</#if>
					</td>
            	</tr>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">입사기간</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">${year} 학년도 ${term} (${start_dt} 부터)</td>
            	</tr>
            </tbody>
        </table>
        
        <div style="margin-top:20px; padding-left:25px; height:20px; font-size: 17px; line-height: 17px; color: #85504e; font-family: 'Malgun Gothic'; background: url(${protocol}://${domain}/images/iosf/back/bul/bul_05.jpg) no-repeat 0 2px ;">신청자 정보</div>        
        <table style="width: 100%; margin-top: 10px; border-spacing: 0; border-collapse: separate; border-top: 1px solid #a59175; border-bottom: 2px solid #3a3a3a; ">
			<colgroup>
				<col width="93px">
				<col width="243px">
				<col width="93px">
				<col width="">
			</colgroup>
			<tbody>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">성명</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">${user_nm} (${std_id})</td>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">소속</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; padding: 7px 10px 6px 10px; text-align: left;">${dept_nm}</td>
				</tr>
				<tr>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">연락처</td>
					<td align="left" style="color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;padding: 7px 10px 6px 10px; text-align: left;">${phone}</td>
					<td style="font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb; background: #f7f7f7; color: #988281; text-align: left; padding: 5px 5px 5px 10px; border-left: 0; vertical-align: middle;">이메일</td>
					<td style=" padding: 7px 10px 6px 10px;  color: #535353; vertical-align: middle; border-left: 1px solid #dedede; font: normal 13px/18px 'Malgun Gothic'; border-bottom: 1px solid #cbcbcb;text-align: left;">${email}</td>
				</tr>
            </tbody>
        </table>
        <div style="overflow: hidden; padding: 11px; margin-top: 30px; margin-bottom: 30px; background: #897861;">
			<span style="float:left; width:16px; height:16px; background: url(${protocol}://${domain}/images/iosf/mail/icon-emailnotice.png) no-repeat;">&nbsp;</span>
			<span style="float:left; color: #dcdcdc; margin-left: 5px; font: normal 13px/13px 'Malgun Gothic';">자세한 사항은 <a href="${protocol}://${domain}" target="_blank" style="color: #dcdcdc;">고려대학교 안암학사 웹사이트에서 확인하시기 바랍니다.</span>
		</div>
		<div style="text-align: center; color: #7d7d7d; padding-top: 30px; border-top: 1px solid #d8d8d8; font: normal 13px 'Malgun Gothic';">
			02841 서울특별시 성북구 안암로 145 고려대학교<br/>
			<span>COPYRIGHTS (C)2021 KOREA UNIVERSITY. ALL RIGHTS RESERVED.</span>			
		</div>
	</div>
</div>
</body>
</html>
