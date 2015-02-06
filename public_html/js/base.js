if (isDefined(window.domain))
	document.domain = window.domain;

var debuging = (isDefined(window._env) && window._env == 'development') ? true : false;

if (debuging == true && window.loadFirebugConsole)
	window.loadFirebugConsole();

/**
 *
 * @param mixed str
 * @param boolean caller_fnc
 */
function debug(str, caller_fnc)
// *************************************************************************
{
	if (debuging)
	{
		var _log = (isDefined(window.log) && typeof window.log == 'function') ? window.log : ((isDefined(window.console) && window.console.log) ? function () { window.console.log.apply(window.console, arguments); } : undefined);
		if (isDefined(_log))
		{
			_log(str);

			if (caller_fnc)
				_log(arguments.callee.caller+' called me');
		}
		else {
			if (!$('#debugger').length)
				$('body').append($('<div>', {
					id: 'debugger',
					css: {
						position: 'absolute',
						top: '0px',
						left: '0px',
						border: '1px solid red',
						backgroundColor: '#fff'
					}
				}));

			$('#debugger').append($('<div>', {html: str+''}));
		}
	}
}

// ******************************************************************
function isDefined(obj)
// ******************************************************************
{
	try {
		if (typeof(obj) == "undefined") return false;
		if (typeof obj == 'undefined') return false;
		if (obj === null) return false;
		if (obj == null) return false;
		if (obj == 'null') return false;
		if (obj == 'NULL') return false;
		return true;
	}
	catch (e) {return false;}
}

/**
 * @param ref - jQuery DOM element object
 * @param msg string - message text
 * @param type string - type of message success|warning|error
 * @param append bool - append or ater
 */
function showMessage(ref, msg, type, append)
// *************************************************************************
{
	type = type || 'success';

	if (append)
		ref.append('<div class="alert alert-'+type+'">'+msg+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
	else
		ref.after('<div class="alert alert-'+type+'">'+msg+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
}

// *************************************************************************
function hideAllMessages()
// *************************************************************************
{
	$('div.alert button.close,div.alert a.close').trigger('click');
}


// **********************************************************
// Dom Ready
// **********************************************************
$(document).ready(function() {

	$(document).on('click', 'li.nl > a,a.nl', function(e) {
		e.preventDefault();
	});

	$(document).on('click', 'div.alert-box a.close', function(e) {
		e.preventDefault();
		$(this).parent('div.alert-box').fadeOut();
	});

});
