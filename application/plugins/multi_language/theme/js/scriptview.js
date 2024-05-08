var LANGUAGEVIEW = (function(){

	var init = function(){

		var trs = $('a.active[data-lang]').parents('tr');

		for (var i = 0; i < trs.length; i++) {

			var item = $(trs[i]);

			var alang = item.find('a.active[data-lang]');

			var eye = item.find('.icon-eye-open');

			var a = eye.parent();

			var lang = alang.data('lang');

			if(lang!=defaultLanguageFrontend){

				a.attr('href',alang.data('lang')+'/'+a.attr('href'));

			}

		}

	}

	init();

})();