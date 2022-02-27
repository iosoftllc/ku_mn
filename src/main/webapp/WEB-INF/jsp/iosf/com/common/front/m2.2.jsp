<%@ page language="java" contentType="text/html;charset=UTF-8" %>
<%@ include file="../../sys/taglibs.jspf"%>
<%@ include file="../../sys/setCodes.jspf"%>

<link rel="stylesheet" href="${css_src }/iosf/front/slick.css" />
<link rel="stylesheet" href="${css_src }/iosf/front/contents.css" />
<script type="text/javascript" src="${js_src }/iosf/front/controller.js"></script>

                        <div class="m2-2">
                            <div class="section">
                                <span class="section-title">모바일 신분증 이용처</span>
                                <div class="guide-boxes">
                                    <div class="guide-box">
                                        <p class="guide-text">서울 안암 캠퍼스내 건물 주 출입구 및 호실에서<br/>
스마트폰의 NFC / BLE 를 이용한 출입 인증이 가능합니다</p>
                                         <div class="bottom">
                                            <span class="icon"><img src="${img_src}/iosf/front/icon/icon_guide.png" alt="" /></span>
                                            <span class="text-right">
                                                <span class="txt1">카드 / NFC / BLE 리더기</span>
                                                <span class="txt2">모바일 학생증 NFC, BLE<br/>학생증 IC 카드</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="guide-box">
                                        <p class="guide-text">서울 안암 캠퍼스내 도서관에서<br/>스마트폰의 NFC / BLE 를 이용한 도서관 이용<br/>
                                            (출입게이트, 좌석배정,<유인대출, 스마트대출 등)<br/>인증이 가능합니다</p>
                                        <div class="bottom">
                                            <span class="icon"><img src="${img_src}/iosf/front/icon/icon_guide.png" alt="" /></span>
                                            <span class="text-right">
                                                <span class="txt1">카드 / NFC / BLE 리더기</span>
                                                <span class="txt2">모바일 학생증 NFC, BLE<br/>학생증 IC 카드</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section">
                                <span class="section-title bulb">이용방법 및 유의사항</span>
                                <ul class="prec-list">
                                    <li>· 변경 및 initial 앱 삭제 후 재설치 시 initial(이니셜) 가입에서 발급까지 다시 진행하셔야 이용이 가능합니다</li>
                                    <li>· NFC지원이 되는 안드로이드 7 이상 사용자는 NFC를 이용하여 출입 인증이 가능합니다</li>
                                    <li>· BLE 지원이 되는 IOS 10 이상 아이폰 사용자는 BLE를 이용하여 출입 인증이 가능합니다</li>
                                    <li>· IOS 14.0 이상 아이폰 사용자는 위젯을 이용하여 편리하게 출입 인증이 가능합니다</li>
                                    <li>· 모바일 신분증 사진변경은 One-Stop 서비스에 사진을 가지고 가서 변경 요청을 하면 됩니다</li>
                                </ul>
                                <span class="arrow">&nbsp;</span>
                                <div class="prec-section">
                                    <span class="prec-title"><strong>NFC 이용</strong> (NFC 지원 안드로이드 7 이상 사용자) </span>
                                    <ul class="list">
                                        <li>1. <strong class="red">NFC 기본 모드 활성화</strong></li>
                                        <li>2. <strong class="red">이니셜 실행없이 화면이</strong> 켜진 상태에서 NFC 리더기에 핸드폰의 뒷면(안테나부분)을 Tag</li>
                                    </ul>
                                    <div class="bottom">
                                        <div class="photos">
                                            <span class="photo"><img src="${img_src}/iosf/front/photo.png" alt="" /></span>
                                            <span class="photo"><img src="${img_src}/iosf/front/photo.png" alt="" /></span>
                                        </div>
                                        <p class="note">사용시 인증이 안 되는 경우 <span class="red"><strong>백그라운드 데이터 제한</strong> 설정 해제</span></p>
                                    </div>
                                </div>
                                <div class="prec-section type2">
                                    <span class="prec-title"><strong>BLE 이용</strong> (IOS 10 이상 아이폰 사용자)</span>
                                    <ul class="list">
                                        <li>1. <strong class="red">Bluetooth 허용권한 활성화</strong></li>
                                        <li>2. 이니셜 앱 > 이니셜 출입카드 기능에 접근 후 태그</li>
                                    </ul>
                                    <div class="img">
                                        <img src="${img_src}/iosf/front/img_01.png" alt="" />
                                        <img src="${img_src}/iosf/front/img_012.png" alt="" />
                                    </div>
                                </div>
                                <div class="prec-section type3">
                                    <div class="prec-slider" id="prec_slider">
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_01.png" alt="" /></div>
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_02.png" alt="" /></div>
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_03.png" alt="" /></div>
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_04.png" alt="" /></div>
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_05.png" alt="" /></div>
                                        <div class="prec-slider-item"><img src="${img_src}/iosf/front/screen4_06.png" alt="" /></div>
                                    </div>
                                    <div class="prec-detail">
                                        <span class="prec-title"><strong>위젯 이용</strong>(아이폰 IOS 14.0 이상 사용자)</span>
                                        <ul class="list nom">
                                            <li>1. 이니셜 앱 > 설정 메뉴에서 위젯 설정<span class="br red">(아이폰은 위젯을 이용하여 이니셜 앱 출입하기 화면으로 바로 이동이 가능)</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
