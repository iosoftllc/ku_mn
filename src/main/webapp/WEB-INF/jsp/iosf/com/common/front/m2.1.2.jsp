<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/slick.css" />
<link rel="stylesheet" href="${css_src }/iosf/front/contents.css" />
<script type="text/javascript" src="${js_src }/iosf/front/controller.js"></script>

                        <div class="m2-1-1">
                            <div class="section4">
                                <span class="title">모바일 신분증<span>발급 증명서 선택 안내</span></span>
                                <ul class="list">
                                    <li>·모바일 신분증 증명서 선택 화면에서 본인 신분에 맞게 증명서를 선택 합니다.</li>
                                    <li>·1인 1신분증만 발급가능 합니다.</li>
                                </ul>
                                <div class="tbl-box">
                                    <table class="tbl">
                                        <colgroup>
                                            <col width="18%" />
                                            <col />
                                            <col width="18%" />
                                            <col width="30%" />
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th>신분증명</th>
                                                <th>발급대상자</th>
                                                <th>용도</th>
                                                <th>문의처</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>대학 신분증</td>
                                                <td>스마트카드 발급이 가능한<br/>학부생,대학원생,강사,교원,직원</td>
                                                <td>건물출입 및<br/>도서관 이용</td>
                                                <td class="empty">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>국제동하계대학증</td>
                                                <td>현재 수강중인 국제동하계대학 학생</td>
                                                <td>도서관 이용</td>
                                                <td>02-3290-1156</td>
                                            </tr>
                                            <tr>
                                                <td>교환/방문학생증</td>
                                                <td>교환학생 및 방문학생</td>
                                                <td>건물 출입 및<br/>도서관 이용</td>
                                                <td>02-3290-5177, 5178</td>
                                            </tr>
                                            <tr>
                                                <td>국제어학원학생증</td>
                                                <td>현재 수강중인 외국어센터<br/>고려대-맥쿼리대 통번역<br/>석사과정 수강생</td>
                                                <td>건물 출입 및<br/>도서관 이용 </td>
                                                <td>02-3290-2448</td>
                                            </tr>
                                            <tr>
                                                <td>평생교육원증</td>
                                                <td>현재 수강중인 평생교육원생</td>
                                                <td>평생교육원<br/>모바일 신분증 및<br/>도서관 이용 </td>
                                                <td>02-3290-1465</td>
                                            </tr>
                                            <tr>
                                                <td>도서관 이용증</td>
                                                <td>
                                                	1. 본교 졸업/수료/퇴직자 중 도서관 기간제 이용자로 등록한 자
                                                	<br/>- 연회비 이용자,  장기근속퇴직직원 등
                                                	<br/>2. 의료원 소속 이용자
                                                	<br/>- 의학도서관 별도 등록 필요
                                                </td>
                                                <td>도서관 자료<br/>/시설 이용</td>
                                                <td>02-3290-1491~2<br/>(의학 02-2286-1254)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="section3 bg">
                                <span class="title userid">모바일 신분증<span>발급절차</span></span>
                                <div class="m2_slider3_title" id="m2_slider3_title">
                                    <div class="slider3-title-item">
                                        <span class="num">01</span>
                                        <span class="text">initial 메인 화면 카드 swipe</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">02</span>
                                        <span class="text">학생증/신분증  “+” 선택</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">03</span>
                                        <span class="text">발급하기에서 대학 신분증 선택</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">04</span>
                                        <span class="text">기관 선택에서 고려대학교 선택</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">05</span>
                                        <span class="text">학번 / 교직원 번호 입력 후<br/>개인 정보 동의 및 제출</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">06</span>
                                        <span class="text">발급 내용 확인 후 저장하기</span>
                                    </div>
                                    <div class="slider3-title-item">
                                        <span class="num">07</span>
                                        <span class="text">발급 완료</span>
                                    </div>
                                </div>
                                <div class="slider3-box">
                                    <div class="m2_slider3" id="m2_slider3">
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_01.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_02.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_03.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_04.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_05.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_06.png" alt="" /></div>
                                        <div class="m2_slider3_item"><img src="${img_src}/iosf/front/screen3_07.png" alt="" /></div>                    
                                    </div>
                                </div>
                            </div>
                        </div>
