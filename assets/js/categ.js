(function($) {
	'use strict';

	// Set & unset primary template
	var setPrimary = wp.template('categ-set-admin-views');

	var removePrimary = wp.template('categ-unset-admin-views');

	// Wrapper for the primary category UI

	var categWrapper = (function() {
		var taxEl, templateData, firstParent, topParent;

		function taxonomyData(el) {
			return {
				taxonomy: $(el).data('tax')
			};
		}

		function setPrimaryVal(el, val = false) {
			taxEl = $(firstParent).find('input[type=checkbox]');
			taxEl.prop('checked', true);
			taxEl.attr('checked', true);

			val = (val ? $(taxEl).val() : 0);
			$('[name="categ_primary_' + $(el).data('tax') + '"]').val(val);
		}

		function setPrimaryDisplay(el, isPrimary = false) {

			firstParent.removeChild(el);
			
			templateData = taxonomyData(el);

			var parentHTML = $(firstParent).html();

			if(!isPrimary) {
				$(firstParent).html(parentHTML + setPrimary(templateData));
			} else {
				$(firstParent).html(parentHTML + removePrimary(templateData));
			}
		}

		return {
			initcategDisplay : function(taxonomy) {

				firstParent = $('#' + taxonomy.taxonomy + 'checklist')[0];

				if(firstParent !== null) {
					var nodeChildren = $(firstParent).find('li');

					if(nodeChildren.length > 0) {
						templateData = {
							taxonomy: taxonomy.taxonomy
						};

						for(var i = 0; i < nodeChildren.length; i++) {
							var child = $(nodeChildren[i]);
							var childVal = child.find('input[type=checkbox]').val();
							var templateMarkup;

							if(childVal == taxonomy.primary) {
								templateMarkup = removePrimary(templateData);
							} else {
								templateMarkup = setPrimary(templateData);
							}

							var curMarkup = child.html();
							child.html(curMarkup + templateMarkup);
						}
					}

					var primaryCatInput = '<input type="hidden" name="categ_primary_' + taxonomy.taxonomy + '" value="' + taxonomy.primary + '" />';
					$(firstParent).parent('div').append(primaryCatInput);
				}
			},

			setPrimary : function(el) {
				firstParent = $(el).parent('li')[0];

				templateData = taxonomyData(el);

				var currentPrimary = $(firstParent).parent('ul').find('.categ-unset-primary');

				if( currentPrimary.length > 0 ) {
					topParent = currentPrimary.parent('li');

					currentPrimary.remove();

					var topParentHTML = topParent.html();
					topParent.html(topParentHTML + setPrimary(templateData));
				}

				setPrimaryDisplay(el, true);
				setPrimaryVal(el, true);
			},

			removePrimary : function(el) {
				firstParent = $(el).parent('li')[0];
				setPrimaryDisplay(el);
				setPrimaryVal(el);
			}
		};
	})();

	$('.categorydiv').on('click', 'a.categ-category', function(e) {
		e.preventDefault();
		var el = $(this)[0];

		if($(this).hasClass('categ-set-primary')) {
			categWrapper.setPrimary(el);
		} else if($(this).hasClass('categ-unset-primary')) {
			categWrapper.removePrimary(el);
		}
	});

	if(categVars.taxonomies.length > 0) {
		for(var i = 0; i < categVars.taxonomies.length; i++) {
			categWrapper.initcategDisplay(categVars.taxonomies[i]);
		}
	}

})(jQuery);
