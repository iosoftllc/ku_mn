<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/contents.css" />

                        <div class="m2-1-1">
                            <div class="section4" style="background-image: none;">
                                <span class="title">건물 출입신청 대상</span></span>
                                <div class="tbl-box">
                                    <table class="tbl" style="width: 100%;">
                                        <colgroup>
                                            <col width="25%" />
                                            <col />
                                            <col width="13%" />
                                            <col width="13%" />
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th>구분</th>
                                                <th>학적</th>
                                                <th>예약신청</th>
                                                <th>출입신청</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td rowspan="4">학부생</td>
                                                <td>재학/휴학</td>
                                                <td colspan="2">O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수강유예</td>
                                                <td colspan="2">O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료/미수강유예</td>
                                                <td colspan="2">X</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">졸업/입학취소</td>
                                                <td colspan="2">X</td>
                                            </tr>
                                            <tr>
                                                <td rowspan="5">대학원생</td>
                                                <td>재학</td>
                                                <td colspan="2">O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">휴학</td>
                                                <td>X</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료연구(휴학)</td>
                                                <td colspan="2">O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료/영구수료/졸업</td>
                                                <td colspan="2">X</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">특례진입생</td>
                                                <td colspan="2">O</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br/>
                                    <br/>
                                    <span style="color: #810020;">· 대학원 수료생 중 연구실 출입이 필요한 경우, 학과 행정실에 요청하셔서 별도의 출입카드(세콤)를 수령하시기 바랍니다.</span>
                                </div>
                            </div>
                         </div>

                        <div class="m2-2">
                            <div class="section">
                                <span class="section-title bulb">졸업생 도서관 이용 안내</span>
                                <ul class="prec-list">
                                    <li>· 2023년 8월 이후 졸업한 학부 및 대학원 졸업생은 졸업 후 3년간 도서관 이용이 가능합니다.</li>
                                    <li>· 학생증을 분실한 경우, 모바일 또는 실물 도서관 이용증을 발급받아 이용하실 수 있습니다.</li>
                                    <li>· 자세한 사항은 도서관으로 문의해주시기 바랍니다.(02-3290-1492)</li>
                                </ul>
                            </div>
                        </div>