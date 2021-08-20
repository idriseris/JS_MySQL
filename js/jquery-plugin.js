(function($) {
	"use strict";
	$.MySQL = function(type,arg){
		var object = this;
		var setup = $.extend({
			finis: function(){}
		}, arg);
		$.get("js/jquery.mysql.php",{type:type,arg}).done(function(res){
			setup.finis.call(setup,res);
		});
	}
})(jQuery);
