/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};



Date.fromString=(function(){var defaults={order:'MDY',strict:false};var months=["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];var abs=["AM","PM","AFTERNOON","MORNING"];var mark=function(str,val){var lval=val.toLowerCase();var regex=new RegExp('^'+lval+'|(.*[^:alpha:])'+lval,'g');return str.replace(regex,'$1'+val);};var normalize=function(str){str=str.toLowerCase();str=str.replace(/[^:a-z0-9]/g,'-');for(var i=0;i<months.length;i++)str=mark(str,months[i]);for(var i=0;i<abs.length;i++)str=mark(str,abs[i]);str=str.replace(/[a-z]/g,'');str=str.replace(/([0-9])([A-Z])/g,'$1-$2');str=('-'+str+'-').replace(/-+/g,'-');return str;};var find_time=function(norm){var obj={date:norm,time:''};obj.time=norm.replace(/^.*-(\d\d?(:\d\d){1,2}(:\d\d\d)?(-(AM|PM))?)-.*$/,'$1');if(obj.time==obj.date)
obj.time=norm.replace(/^.*-(\d\d?-(AM|PM))-.*$/,'$1');if(obj.time==obj.date)obj.time='';obj.date=norm.replace(obj.time,'');obj.time=('-'+obj.time+'-').replace(/-+/g,'-');obj.date=('-'+obj.date+'-').replace(/-+/g,'-');return obj;};var find_year=function(norm){var year=null;year=norm.replace(/^.*-(\d\d\d\d)-.*$/,'$1');if(year!=norm)return year;else year=null;year=norm.replace(/^.*-((3[2-9])|([4-9][0-9]))-.*$/,'$1');if(year!=norm)return year;else year=null;year=norm.replace(/^.*-[A-Z]{3}-\d\d?-(\d\d?)-.*$/,'$1');if(year!=norm)return year;else year=null;year=norm.replace(/^.*-(\d\d?)-\d\d?-[A-Z]{3}-.*$/,'$1');if(year!=norm)return year;else year=null;var pos='$3';if(defaults.opts.order.charAt(0)=='Y')pos='$1';else if(defaults.opts.order.charAt(1)=='Y')pos='$2';year=norm.replace(/^.*-(\d\d?)-([A-Z]{3}|\d{1,2})-(\d\d?)-.*$/,pos);if(year!=norm)return year;else year=null;return year;};var find_month=function(norm,year){var matches=norm.match(/[A-Z]{3}/);if(matches&&matches.length)return matches[0];var parts=norm.replace(year+'-','').split('-');if(parts.length!=4)return null;var order=defaults.opts.order;var md=order.indexOf('M')<order.indexOf('D')?1:2;return(parseInt(parts[md],10)<=12)?parts[md]:parts[md==1?2:1];};var find_day=function(norm,year,month){return norm.replace(year,'').replace(month,'').replace(/-/g,'');};var create_absolute=function(obj){var time=obj.time.replace(/[-APM]/g,'');var parts=time.split(':');parts[1]=parts[1]||0;parts[2]=parts[2]||0;parts[3]=parts[3]||0;var ihr=parseInt(parts[0],10);if(obj.time.match(/-AM-/)&&ihr==12)parts[0]=0;else if(obj.time.match(/-PM-/)&&ihr<12)parts[0]=ihr+12;parts[0]=("0"+parts[0]).substring(("0"+parts[0]).length-2);parts[1]=("0"+parts[1]).substring(("0"+parts[1]).length-2);parts[2]=("0"+parts[2]).substring(("0"+parts[2]).length-2);time=parts[0]+":"+parts[1]+":"+parts[2];var millisecs=parts[3];var strict=defaults.opts.strict;if(!obj.year&&!strict)obj.year=(new Date()).getFullYear();var year=parseInt(obj.year,10);if(year<100){year+=(year<70?2000:1900);}
if(!obj.month&&!strict)obj.month=(new Date()).getMonth()+1;var month=String(obj.month);if(month.match(/[A-Z]{3}/)){month="JAN-FEB-MAR-APR-MAY-JUN-JUL-AUG-SEP-OCT-NOV-DEC-".indexOf(month)/4+1;}
month=("0"+month).substring(("0"+month).length-2);if(!obj.day&&!strict)obj.day=(new Date()).getDate();var day=("0"+obj.day).substring(("0"+obj.day).length-2);var date=new Date();date.setTime(Date.parse(year+'/'+month+'/'+day+' '+time));date.setMilliseconds(millisecs);return date;};var parse=function(norm){return absolute(norm);};var absolute=function(norm){var obj=find_time(norm);obj.norm=norm;obj.year=find_year(obj.date);obj.month=find_month(obj.date,obj.year);obj.day=find_day(obj.date,obj.year,obj.month);return create_absolute(obj);};return function(fuzz,opts){defaults.opts={order:defaults.order,strict:defaults.strict};if(opts&&opts.order)defaults.opts.order=opts.order;if(opts&&opts.strict!=undefined)defaults.opts.strict=opts.strict;var date=parse(normalize(fuzz));return date;};})();