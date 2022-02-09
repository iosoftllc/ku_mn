var _gEditImageMap;
tinymce.PluginManager.add('edit-imagemap', function (editor) {
	  editor.ui.registry.addMenuItem('imagemap', {
		icon : 'edit-image',
		text : 'ImageMap...',
		onAction : function() {
			imageMapTool(tinymce.activeEditor.settings.id, '');
		}
	});

	editor.ui.registry.addContextMenu('imagemap', {
		update : function(element) {
			_gEditImageMap = $(element).closest('p.imagemap').html();
			return (!element.src || typeof _gEditImageMap === 'undefined' || _gEditImageMap == '') ? '' : 'imagemap';
		}
	});
});
$().ready(function() {
	tinymce.init({
		selector: 'textarea.tinymce',
		// customize button
		setup : function(tinyMCE) {
			tinyMCE.ui.registry.addButton('images', {
				tooltip : language == 'ko' ? '이미지 업로드 '  :  'Upload Image',
				text : '<img src="'+ js_src + '/iosf/webeditor/icon_uploadimage.png" />',
				onAction : function(){
					tinyMCE.windowManager.open(tinymceUploadImage);
				}
			});
			tinyMCE.ui.registry.addButton('file', {
				tooltip : language == 'ko' ? '파일 업로드 '  :  'Upload File',
				text : '<img src="'+ js_src + '/iosf/webeditor/icon_uploadfile.png" />',
				onAction : function() {
					tinyMCE.windowManager.open(tinymceUploadFile);
				}
			});
			tinyMCE.ui.registry.addButton('pdffile', {
				tooltip : language == 'ko' ? 'PDF 업로드 '  :  'Upload PDF',
				text : '<img src="'+ js_src + '/iosf/webeditor/icon_uploadpdf.png" />',
				onAction : function() {
					tinyMCE.windowManager.open(tinymceUploadPDF);
				}
			});
			tinyMCE.ui.registry.addButton('imagemap', {
				tooltip : language == 'ko' ? '이미지 맵 '  :  'Image Map',
				icon : 'edit-image',
				onAction : function() {
					tinyMCE.windowManager.open(tinymceImageMap);
				}
			});
		},  
	
		// General options
		language : 'ko_KR',
	    remove_linebreaks : false,
	    apply_source_formatting : false,
	    force_p_newlines : false,
	    force_br_newlines : true,
	    convert_urls : false,
	    width: '100%',
	    height: '400px',
		//theme : "modern",

		//toolbar_items_size: 'small',*/
		/* plugins: ['print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave',
			'save directionality advcode visualblocks visualchars fullscreen image link media mediaembed',
			'template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist',
			'lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable',
			'help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable',
			// added
			'code'
		], */
		/*
 		plugins: ['print preview powerpaste(X) casechange(X) importcss tinydrive(X) searchreplace autolink autosave',
			'save directionality advcode(X) visualblocks visualchars fullscreen image link media mediaembed(X)',
			'template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist(X)',
			'lists checklist(X) wordcount tinymcespellchecker(X) a11ychecker(X) imagetools textpattern noneditable',
			'help formatpainter(X) permanentpen(X) pageembed(X) charmap tinycomments(X) mentions(X) quickbars(X) linkchecker(X) emoticons advtable(X)'
			// added
			'code'
		], */
		plugins: ['print preview importcss searchreplace autolink autosave',
			'save directionality visualblocks visualchars fullscreen image link media',
			'template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime',
			'lists wordcount imagetools textpattern noneditable',
			'help charmap emoticons',
			// added
			'code',
			// Customize plugin
			'edit-imagemap'
		],
  
		//toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment | code',
  
		toolbar1: 'undo redo | table | styleselect fontselect fontsizeselect formatselect',
		toolbar2: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak',
		toolbar3: 'file pdffile images image media link imagemap anchor codesample | ltr rtl | charmap emoticons | fullscreen preview print code',

		quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote images quicktable',
		
		// contextmenu: "link unlink image images file media pdffile inserttable | cell column row  deletetable",
		contextmenu: "link unlink image imagemap media inserttable | cell column row  deletetable",
		
		// menubar: 'file edit view insert format tools table tc help',
  		menubar: false,
		toolbar_mode: 'sliding',
		// Example content CSS (should be your site CSS)
		content_css: css_src + "/iosf/front/main.css",
		
        style_formats: [
			{title: '일반', items: [
				{title: '굵게', inline: 'b'},
				{title: '빨간 글자', inline: 'span', styles: {color: '#ff0000'}},
				{title: '빨간색 제목', block: 'h1', styles: {color: '#ff0000'}}
			]
			},
			{title: '버튼', items: [
				{title: '버튼 스타일 #1 (green)', inline: 'button', classes: 'btn3 btn-green'},
				{title: '버튼 스타일 #2 (white)', inline: 'button', classes: 'btn3 btn-white'},
 				{title: '버튼 스타일 #3 (brown)', inline: 'button', classes: 'btn3 btn-brown'},
 				{title: '버튼 스타일 #4 (gray)', inline: 'button', classes: 'btn3 btn-grey'},
 				{title: '버튼 스타일 #5 (orange)', inline: 'button', classes: 'btn3 btn-orange'},
 				{title: '버튼 스타일 #6 (red)', inline: 'button', classes: 'btn3 btn-red'}
			]
			},
			{title: '표', items: [
				{title: '표 스타일 #1', selector: 'table', classes: 'tbl-editor-grid'},
				{title: '헤더 스타일#1', selector: 'td', classes: 'head'},
				{title: '헤더 스타일#2', selector: 'td', classes: 'highlightedtd'}
			]
			}
		],
		style_formats_merge: true,

		// Theme options
		font_formats: "맑은고딕='Malgun Gothic';굴림=Gulim;굴림체=GulimChe;궁서=Gungsuh;궁서체=GungsuhChe;돋움=Dotum;돋움체=DotumChe;바탕=Batang;바탕체=BatangChe;Arial=Arial;Comic Sans MS='Comic Sans MS';Courier New='Courier New';Tahoma=Tahoma;Times New Roman='Times New Roman';Verdana=Verdana"
	});
});


/* example dialog that inserts the name of a Pet into the editor content */
var _gApi;
var _gEditor;
var tinymceUploadImage = {
	title : 'Upload Image',
	body : {
		type : 'panel',
		items : [{
			type: 'htmlpanel',
			html : '<div><form id="uploadimageForm" action="' + context + '/util/webeditor/uploadimage" onsubmit="return doValidation(this);" target="iframehidden" method="post" enctype="multipart/form-data"><input type="file" name="files" value="" class="_req" title="이미지를 첨부하세요."/></form></div>'
		}]
	},
	buttons : [ {
		type : 'cancel',
		name : 'closeButton',
		text : 'Cancel'
	}, {
		type : 'submit',
		name : 'submitButton',
		text : 'Upload',
		primary : true
	} ],
	onSubmit : function(api) {
		if ($('#iframehidden').length > 0) {
			_gEditor = tinymce;
			_gApi = api;
			$('#uploadimageForm').submit();
		} else {
			alert('not found iframehidden');
		}
	}
};
var tinymceUploadFile = {
		title : 'Upload File',
		body : {
			type : 'panel',
			items : [{
				type: 'htmlpanel',
				html : '<div><form id="uploadfileForm" action="' + context + '/util/webeditor/uploadfile" onsubmit="return doValidation(this);" target="iframehidden" method="post" enctype="multipart/form-data"><input type="file" name="files" value="" class="_req" title="파일을 첨부하세요."/></form></div>'
			}]
		},
		buttons : [ {
			type : 'cancel',
			name : 'closeButton',
			text : 'Cancel'
		}, {
			type : 'submit',
			name : 'submitButton',
			text : 'Upload',
			primary : true
		} ],
		onSubmit : function(api) {
			if ($('#iframehidden').length > 0) {
				_gEditor = tinymce;
				_gApi = api;
				$('#uploadfileForm').submit();
			} else {
				alert('not found iframehidden');
			}
		}
};
var tinymceUploadPDF= {
		title : 'Upload PDF',
		body : {
			type : 'panel',
			items : [{
				type: 'htmlpanel',
				html : '<div><form id="uploadpdfForm" action="' + context + '/util/webeditor/uploadpdf" onsubmit="return doValidation(this);" target="iframehidden" method="post" enctype="multipart/form-data"><input type="file" name="files" value="" class="_req" title="PDF를 첨부하세요."/></form></div>'
			}]
		},
		buttons : [ {
			type : 'cancel',
			name : 'closeButton',
			text : 'Cancel'
		}, {
			type : 'submit',
			name : 'submitButton',
			text : 'Upload',
			primary : true
		} ],
		onSubmit : function(api) {
			if ($('#iframehidden').length > 0) {
				_gEditor = tinymce;
				_gApi = api;
				$('#uploadpdfForm').submit();
			} else {
				alert('not found iframehidden');
			}
		}
};
var tinymceImageMap = {
		title : 'Image Map',
		body : {
			type : 'panel',
			items : [{
				type: 'htmlpanel',
				html : '<div><form id="imagemapForm" action="' + context + '/util/webeditor/imagemap" onsubmit="return doValidation(this);" target="iframehidden" method="post" enctype="multipart/form-data"><input type="file" name="files" value="" class="_req" title="이미지를 첨부하세요." /></form></div>'
			}]
		},
		buttons : [ {
			type : 'cancel',
			name : 'closeButton',
			text : 'Cancel'
		}, {
			type : 'submit',
			name : 'submitButton',
			text : 'Upload',
			primary : true
		} ],
		onSubmit : function(api) {
			if ($('#iframehidden').length > 0) {
				_gEditor = tinymce;
				_gApi = api;
				$('#imagemapForm').submit();
			} else {
				alert('not found iframehidden');
			}
		}
	};

_callback_editor = function(v, data) {
	if (v == 'uploadimage') {
		_gEditor.activeEditor.execCommand('mceInsertContent', false, '<img src="' + context + '/front/attach/preview/' + data + '" width="100%" alt=""/>');
		_gApi.close();
	}
	if (v == 'uploadfile') {
		_gEditor.activeEditor.execCommand('mceInsertContent', false, '<a href="' + context + '/front/attach/download/'  + data + '" target="_blank">다운로드</a>');
		_gApi.close();
	}
	if (v == 'uploadpdf') {
		_gEditor.activeEditor.execCommand('mceInsertContent', false, '<iframe src="' + context + '/front/attach/preview/' + data + '" width="100%" height="700"></iframe>');
		_gApi.close();
	}
	if (v == 'imagemap') {
		imageMapTool(_gEditor.activeEditor.settings.id, data);
		_gApi.close();
	}
	
	_gEditor = null;
	_gApi = null;
}

imageMapTool = function(id, idx) {
	var win = window.open(context + '/util/webeditor/imagemap?webeditor_id=' + id + '&attach_idx=' + idx, 'win_imagemap', 'width=1024, height=768, status=no, menubar=no, resize=yes, scrollbars=yes');
	if (window.focus) {
		win.focus();
	}
};