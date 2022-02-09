
touchHandler = function (event) {
    var touches = event.changedTouches, first = touches[0], type = "";
 
    switch(event.type)
    {
        case "touchstart":
            type = "mousedown";
            break;
 
        case "touchmove":
            type="mousemove";        
            event.preventDefault();
            break;        
 
        case "touchend":
            type="mouseup";
            break;
 
        default:
            return;
    }
 
    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent(type, true, true, window, 1, first.screenX, first.screenY, first.clientX, first.clientY, false, false, false, false, 0/*left*/, null);
    first.target.dispatchEvent(simulatedEvent);
};

doDragSort = function () {
	$('.dragsort').each(function (){
		if ($(this).prop('tagName') == 'UL') {
			$(this)[0].addEventListener("touchstart", touchHandler, false);
			$(this)[0].addEventListener("touchmove", touchHandler, false);
		    $(this)[0].addEventListener("touchend", touchHandler, false);
		    $(this)[0].addEventListener("touchcancel", touchHandler, false);    
			$(this).sortable().disableSelection();
			$(this).find('ul').each(function(){
				$(this)[0].addEventListener("touchstart", touchHandler, false);
				$(this)[0].addEventListener("touchmove", touchHandler, false);
			    $(this)[0].addEventListener("touchend", touchHandler, false);
			    $(this)[0].addEventListener("touchcancel", touchHandler, false);  
				$(this).sortable({
					helper: function() {
						  var helper = $(this).clone(); // Untested - I create my helper using other means...
						  // jquery.ui.sortable will override width of class unless we set the style explicitly.
						  helper.css({'width': $(this).width(), 'height': $(this).height()});
						  return helper;
						}
				}).disableSelection();
			});
		} else {
			$(this).find('tbody').each(function(){
				$(this)[0].addEventListener("touchstart", touchHandler, false);
				$(this)[0].addEventListener("touchmove", touchHandler, false);
			    $(this)[0].addEventListener("touchend", touchHandler, false);
			    $(this)[0].addEventListener("touchcancel", touchHandler, false);  
			}).sortable({
				items: '> tr',
			    placeholder:'must-have-class',
			    start: function (event, ui) {
			        // Build a placeholder cell that spans all the cells in the row
			        var cellCount = 0;
			        $('td, th', ui.helper).each(function () {
			            // For each TD or TH try and get it's colspan attribute, and add that or 1 to the total
			            var colspan = 1;
			            var colspanAttr = $(this).attr('colspan');
			            if (colspanAttr > 1) {
			                colspan = colspanAttr;
			            }
			            log('	width : ' + $(this).closest('table').find('thead').find('th:eq(' + cellCount + ')').width());
			            $(this).css('width', $(this).closest('table').find('thead').find('th:eq(' + cellCount + ')').width());
			            cellCount += colspan;
			        });

			        // Add the placeholder UI - note that this is the item's content, so TD rather than TR
			        ui.placeholder.html('<td colspan="' + cellCount + '">&nbsp;</td>');
			    }
			}).disableSelection();
		}
	});
};