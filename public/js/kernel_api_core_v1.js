; /* /bitrix/js/api.core/form.js?15736390021657*/
; /* /bitrix/js/api.core/modal.js?15736390022616*/
; /* /bitrix/js/api.core/alert.js?15736390027820*/

; /* Start:"a:4:{s:4:"full";s:42:"/bitrix/js/api.core/form.js?15736390021657";s:6:"source";s:27:"/bitrix/js/api.core/form.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/*!
 * $.fn.apiForm
 */
(function ($, undefined ) {

	"use strict"; // Hide scope, no $ conflict

	var defaults = {};
	var options = {};

	var methods = {
		init: function (params) {

			var options = $.extend(true, {}, defaults, options, params);

			if (!this.data('apiForm')) {
				this.data('apiForm', options);
			}

			if($(this).hasClass('api_form_style')){

				//-----------------------------------//
				//            api_checkbox           //
				//-----------------------------------//
				$(this).find('.api_checkbox').on('click touch', function (e) {
					e.preventDefault();

					if (!$(this).is('.api_active')) {
						$(this).addClass('api_active').find(':checkbox').prop('checked', true).change();
					}
					else {
						$(this).removeClass('api_active').find(':checkbox').prop('checked', false).change();
					}
				});


				//-----------------------------------//
				//            api_radio              //
				//-----------------------------------//
				$(this).find('.api_radio').on('click touch', function (e) {
					e.preventDefault();

					$(this).addClass('api_active').siblings().removeClass('api_active');
					$(this).find(':radio').prop('checked', true).change();

				});
			}

			return this;
		}
	};

	$.fn.apiForm = function (method) {

		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Error! Method "' + method + '" not found in plugin $.fn.apiForm');
		}
	};

})(jQuery);
/* End */
;
; /* Start:"a:4:{s:4:"full";s:43:"/bitrix/js/api.core/modal.js?15736390022616";s:6:"source";s:28:"/bitrix/js/api.core/modal.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/*!
 * $.fn.apiModal
 */
(function ($, undefined ) {

	"use strict"; // Hide scope, no $ conflict

	var defaults = {
		id: '',
		header: '',
		footer: '',
	};

	var methods = {
		init: function (params) {

			var $html = $('html');
			var options = $.extend({}, defaults, options, params);

			if (!this.data('apiModal')) {
				this.data('apiModal', options);

				if (!$html.hasClass('api-modal-init'))
					$html.addClass('api-modal-init');

				$('window').on('resize', function () {
					$.fn.apiModal('resize', options);
				});

				$(document).on('click', '.api_modal,.api_modal_close', function (e) {
					e.preventDefault();

					$('.api_modal .api_modal_dialog').css({
						'transform': 'translateY(-200px)',
						'-webkit-transform': 'translateY(-200px)'
					});
					$('.api_modal').animate({opacity: 0}, 250, function () {
						$(this).hide().removeClass('api_modal_open');
						$html.removeClass('api_modal_active');
					});
				});

				$(document).on('click', '.api_modal .api_modal_dialog', function (e) {
					//e.preventDefault();
					e.stopPropagation();
				});
			}

			return this;
		},
		show: function (options) {
			$('html').addClass('api_modal_active');
			if (options.header) {
				$(options.id + ' .api_modal_header').html(options.header);
			}
			$(options.id + ' .api_modal_dialog').removeAttr('style');
			$(options.id).show().animate({opacity: 1}, 1, function () {
				$(this).addClass('api_modal_open');
				$.fn.apiModal('resize', options);
			});
		},
		resize: function (options) {

			var dialog = options.id + ' .api_modal_dialog';

			if (options.width) {
				$(dialog).width(options.width);
			}

			if ($(options.id + '.api_modal_open').length) {
				var dh = $(dialog).outerHeight(),
					 pad = parseInt($(dialog).css('margin-top'), 10) + parseInt($(dialog).css('margin-bottom'), 10);

				if ((dh + pad) < window.innerHeight) {
					$(dialog).animate({top: (window.innerHeight - (dh + pad)) / 2}, 100);
				} else {
					$(dialog).animate({top: ''}, 100);
				}
			}
		},
		hide: function (options) {
			$(options.id).hide().removeClass('api_modal_open');
			$('html').removeClass('api_modal_active');
		}
	};

	$.fn.apiModal = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Error! Method "' + method + '" not found in plugin $.fn.apiModal');
		}
	};

})(jQuery);
/* End */
;
; /* Start:"a:4:{s:4:"full";s:43:"/bitrix/js/api.core/alert.js?15736390027820";s:6:"source";s:28:"/bitrix/js/api.core/alert.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/*!
 * $.fn.apiAlert
 */
(function ($, undefined ) {

	"use strict"; // Hide scope, no $ conflict

	var defaults = {
		type: 'alert', //['confirm','prompt']
		class: 'info', //['info', 'error', 'warning', 'success']
		//single: true,
		close: true,
		theme: 'default', //['jbox', 'noty', 'sweetalert', 'dark', 'uikit2', 'bootstrap4']
		title: '',
		content: '',
		width: 350,
		timeout: 0,
		showIcon: false,
		hideButtons: false,
		labels: {
			ok: 'OK',
			cancel: 'Cancel',
		},
		header: {
			text: '',
			align: 'center', //left|center|right
		},
		footer: {
			text: '',
			align: 'center', //left|center|right
		},
		input: {
			class: '',
			text: '',
			placeholder: ''
		},
		form: {
			text: '',
		},
		load: {
			url: '',
			data: {},
			callback: function (responseText, textStatus, jqXHR) {
				//console.info(responseText);
				//console.info(textStatus);
			}
		},
		callback: {
			onConfirm: function (isConfirm) {
				console.info('isConfirm', isConfirm);
			},
			onPrompt: function (isPrompt, data) {
				data = data || {};
				console.info('isPrompt', isPrompt);
				console.info('isPromptData', data);
			},
			onShow: function () {}, //TODO
			onClose: function () {},//TODO
		}
	};

	var methods = {

		init: function (params) {

			var $html = $('html');
			var options = $.extend(true, {}, defaults, params);

			if (!this.data('apiAlert')) {
				this.data('apiAlert', options);

				// ???????????? ????????????????????????????
				if (options.type === 'confirm') {
					//if(!options.title)
					//options.title = 'Are you sure?';
				}

				if (!$html.hasClass('api-alert-init'))
					$html.addClass('api-alert-init');

				//api_alert_alert
				$html.addClass('api_alert_active');

				if (!$('.api_alert_overlay').length) {
					$('body').append('<div class="api_alert_overlay"/>');
				}

				var html = '';
				var alertId = '#apiAlert' + ($('.api_alert').length + 1);

				html += '<div id="' + alertId.replace('#', '') + '" class="api_alert api_alert_' + options.class + ' api_alert_theme_' + options.theme + ' api_alert_type_' + options.type + '">';
				html += '<div class="api_alert_dialog">';
				html += '<div class="api_alert_close api_icon_close">&#10005;</div>';

				if (options.header.text.length) {
					html += '<div class="api_alert_header" style="text-align: ' + options.header.align + '">' + options.header.text + '</div>';
				}

				//start content
				html += '<div class="api_alert_content">';

				if (options.showIcon) {
					html += '<div class="api_alert_icon"></div>';
				}

				if (options.title.length) {
					html += '<div class="api_title">' + options.title + '</div>';
				}

				//START content!!!
				html += '<div class="api_content">' + options.content;

				if (options.input.text.length) {
					html += '<div class="api_input"><input type="text" value="' + options.input.text + '" class="' + options.input.class + '" placeholder="' + options.input.placeholder + '"></div>';
				}

				if (options.type === 'prompt') {
					if (options.form.text.length) {
						html += options.form.text;
					}
					else {
						html += '<div class="api_input"><input type="text" value="' + options.input.text + '" class="' + options.input.class + '" placeholder="' + options.input.placeholder + '"></div>';
					}
				}

				//{{buttons}}
				if (!options.hideButtons)
					html += '<div class="api_buttons">{{buttons}}</div>';

				//END content!!!
				html += '</div>';

				if (options.footer.text.length) {
					html += '<div class="api_alert_footer" style="text-align: ' + options.footer.align + '">' + options.footer.text + '</div>';
				}

				html += '</div>';
				html += '</div>';

				//Replace buttons
				switch (options.type) {
					case "confirm":
						html = html.replace("{{buttons}}", '<button type="button" class="api_button api_button_primary api_alert_confirm">{{ok}}</button><button type="button" class="api_button api_alert_close">{{cancel}}</button>');
						html = html.replace("{{ok}}", options.labels.ok).replace("{{cancel}}", options.labels.cancel);
						break;
					case "prompt":
						html = html.replace("{{buttons}}", '<button type="button" class="api_button api_button_primary api_alert_prompt">{{ok}}</button><button type="button" class="api_button api_alert_close">{{cancel}}</button>');
						html = html.replace("{{ok}}", options.labels.ok).replace("{{cancel}}", options.labels.cancel);
						break;
					case "alert":
					default:
						html = html.replace("{{buttons}}", '<button type="button" class="api_button api_button_primary api_alert_close">{{ok}}</button>');
						html = html.replace("{{ok}}", options.labels.ok);
						break;
				}

				//Show alert
				$('body').append(html);
				$(alertId).find('.api_alert_dialog').width(options.width);
				$(alertId).show();

				options.id = alertId;
				$.fn.apiAlert('resize', options);

				$(window).on('resize', function () {
					$.fn.apiAlert('resize', options);
				});

				//close
				$(alertId).on('click', '.api_alert_close', function () {
					if (options.type === 'confirm') {
						options.callback.onConfirm.call(options, false);
					}
					methods.close(alertId);
				});

				//confirm
				$(alertId).on('click', '.api_alert_confirm', function () {
					options.callback.onConfirm.call(options, true);
					if (options.close) {
						methods.close(alertId);
					}
				});

				//prompt
				$(alertId).on('click', '.api_alert_prompt', function () {

					var promptData = {};
					var promptForm = $(alertId + ' form');
					var promptInput = $(alertId + ' input[type=text]');

					if (promptForm.length)
						promptData = promptForm.serializeArray();
					else if (promptInput.length)
						promptData = promptInput.val();

					options.callback.onPrompt.call(options, true, promptData);
					if (options.close) {
						methods.close(alertId);
					}
				});

				//$.load()
				if (options.load.url.length) {
					$(alertId).find('.api_content').html('<div class="api_alert_busy"></div>');
					$(alertId).find('.api_alert_header, .api_alert_footer').hide();

					$(alertId).find('.api_content').load(
						 options.load.url,
						 options.load.data,
						 function (responseText, textStatus, jqXHR) {
							 $(alertId).find('.api_alert_header, .api_alert_footer').show();
							 $.fn.apiAlert('resize', options);
							 options.load.callback.call(options, responseText, textStatus, jqXHR);
						 }
					);
				}

			}

			return this;
		},
		close: function (alertId) {
			$(alertId).hide().remove();
			if (!$('.api_alert').length) {
				$('.api_alert_overlay').hide().remove();
				$('html').removeClass('api_alert_active');
			}
		},
		resize: function (options) {

			var dialog = options.id + ' .api_alert_dialog';

			var dh = $(dialog).outerHeight(),
				 pad = parseInt($(dialog).css('margin-top'), 10) + parseInt($(dialog).css('margin-bottom'), 10);

			if ((dh + pad) < window.innerHeight) {
				$(dialog).css({top: (window.innerHeight - (dh + pad)) / 2});
			} else {
				$(dialog).css({top: ''}, 100);
			}

		},

		showWait: function (alertId) {
			$(alertId).find('.api_alert_content').append('<div class="api_alert_wait"></div>');
		},
		hideWait: function (alertId) {
			$(alertId).find('.api_alert_wait').remove();
		},
	};

	$.fn.apiAlert = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Error! Method "' + method + '" not found in plugin $.fn.apiAlert');
		}
	};

})(jQuery);
/* End */
;