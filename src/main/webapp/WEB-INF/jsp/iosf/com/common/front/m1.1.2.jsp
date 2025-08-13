<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/contents.css" />

                        <div class="m2-1-1">
                            <div class="section4" style="background-image: none;">
                                <span class="title">학생증/신분증 발급대상</span></span>
                                <div class="tbl-box">
                                    <table class="tbl">
                                        <colgroup>
                                            <col width="25%" />
                                            <col />
                                            <col width="25%" />
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th>구분</th>
                                                <th>학적</th>
                                                <th>발급가능 (도서관이용)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td rowspan="4">학부생</td>
                                                <td>재학/휴학</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수강유예</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료/미수강유예</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">졸업/입학취소</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td rowspan="4">대학원생</td>
                                                <td>재학/휴학</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료연구(휴학)</td>
                                                <td>O</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">수료/영구수료/졸업</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                                <td style="border-left: 1px solid #191919;">특례진입생</td>
                                                <td>O</td>
                                            </tr>
                                        </tbody>
                                    </table>
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