// Which HTML element is the target of the event
function mouseTarget(e) {
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;
	return targ;
}
 
// Mouse position relative to the document
// From http://www.quirksmode.org/js/events_properties.html
function mousePositionDocument(e) {
	var posx = 0;
	var posy = 0;
	if (!e) {
		var e = window.event;
	}
	if (e.pageX || e.pageY) {
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY) {
		posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	}
	return {
		x : posx,
		y : posy
	};
}

// Find out where an element is on the page
// From http://www.quirksmode.org/js/findpos.html
function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return {
		left : curleft,
		top : curtop
	};
}
 
// Mouse position relative to the element
// not working on IE7 and below
function mousePositionElement(e) {
	var mousePosDoc = mousePositionDocument(e);
	var target = mouseTarget(e);
	var targetPos = findPos(target);
	var posx = mousePosDoc.x - targetPos.left;
	var posy = mousePosDoc.y - targetPos.top;
	return {
		x : posx,
		y : posy
	};
}

function getOffset(el) {
  const rect = el.getBoundingClientRect();
  return {
    x: rect.left + window.scrollX,
    y: rect.top + window.scrollY
  };
}

function getelementcenter(task_element_path){
	var response = [];
	var new_task_point = jQuery(task_element_path);
    var new_task_point_offset = new_task_point.offset();
    // console.log('offset');
    // console.log(new_task_point_offset);
    
    var task_element_width = jQuery(task_element_path).width();
    var task_element_height = jQuery(task_element_path).height();
    // console.log('width: '+task_element_width);
    // console.log('height: '+task_element_height);

	if (typeof new_task_point_offset !== 'undefined') {
		var task_element_centerX = new_task_point_offset.left + task_element_width / 2;
		var task_element_centerY = new_task_point_offset.top + task_element_height / 2;
	}
	else {
		var task_element_centerX = 0;
		var task_element_centerY = 0;
	}
    // console.log('centerX: '+task_element_centerX);
    // console.log('centerY: '+task_element_centerY);

    response['left']=task_element_centerX;
    response['top']=task_element_centerY;

    return response;
}