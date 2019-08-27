var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * Datepicker for Bootstrap v1.8.0 (https://github.com/uxsolutions/bootstrap-datepicker)
 *
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if ((typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) === 'object') {
		factory(require('jquery'));
	} else {
		factory(jQuery);
	}
})(function ($, undefined) {
	function UTCDate() {
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday() {
		var today = new Date();
		return UTCDate(today.getFullYear(), today.getMonth(), today.getDate());
	}
	function isUTCEquals(date1, date2) {
		return date1.getUTCFullYear() === date2.getUTCFullYear() && date1.getUTCMonth() === date2.getUTCMonth() && date1.getUTCDate() === date2.getUTCDate();
	}
	function alias(method, deprecationMsg) {
		return function () {
			if (deprecationMsg !== undefined) {
				$.fn.datepicker.deprecated(deprecationMsg);
			}

			return this[method].apply(this, arguments);
		};
	}
	function isValidDate(d) {
		return d && !isNaN(d.getTime());
	}

	var DateArray = function () {
		var extras = {
			get: function get(i) {
				return this.slice(i)[0];
			},
			contains: function contains(d) {
				// Array.indexOf is not cross-browser;
				// $.inArray doesn't work with Dates
				var val = d && d.valueOf();
				for (var i = 0, l = this.length; i < l; i++) {
					// Use date arithmetic to allow dates with different times to match
					if (0 <= this[i].valueOf() - val && this[i].valueOf() - val < 1000 * 60 * 60 * 24) return i;
				}return -1;
			},
			remove: function remove(i) {
				this.splice(i, 1);
			},
			replace: function replace(new_array) {
				if (!new_array) return;
				if (!$.isArray(new_array)) new_array = [new_array];
				this.clear();
				this.push.apply(this, new_array);
			},
			clear: function clear() {
				this.length = 0;
			},
			copy: function copy() {
				var a = new DateArray();
				a.replace(this);
				return a;
			}
		};

		return function () {
			var a = [];
			a.push.apply(a, arguments);
			$.extend(a, extras);
			return a;
		};
	}();

	// Picker object

	var Datepicker = function Datepicker(element, options) {
		$.data(element, 'datepicker', this);
		this._process_options(options);

		this.dates = new DateArray();
		this.viewDate = this.o.defaultViewDate;
		this.focusDate = null;

		this.element = $(element);
		this.isInput = this.element.is('input');
		this.inputField = this.isInput ? this.element : this.element.find('input');
		this.component = this.element.hasClass('date') ? this.element.find('.add-on, .input-group-addon, .btn') : false;
		if (this.component && this.component.length === 0) this.component = false;
		this.isInline = !this.component && this.element.is('div');

		this.picker = $(DPGlobal.template);

		// Checking templates and inserting
		if (this._check_template(this.o.templates.leftArrow)) {
			this.picker.find('.prev').html(this.o.templates.leftArrow);
		}

		if (this._check_template(this.o.templates.rightArrow)) {
			this.picker.find('.next').html(this.o.templates.rightArrow);
		}

		this._buildEvents();
		this._attachEvents();

		if (this.isInline) {
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		} else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl) {
			this.picker.addClass('datepicker-rtl');
		}

		if (this.o.calendarWeeks) {
			this.picker.find('.datepicker-days .datepicker-switch, thead .datepicker-title, tfoot .today, tfoot .clear').attr('colspan', function (i, val) {
				return Number(val) + 1;
			});
		}

		this._process_options({
			startDate: this._o.startDate,
			endDate: this._o.endDate,
			daysOfWeekDisabled: this.o.daysOfWeekDisabled,
			daysOfWeekHighlighted: this.o.daysOfWeekHighlighted,
			datesDisabled: this.o.datesDisabled
		});

		this._allow_update = false;
		this.setViewMode(this.o.startView);
		this._allow_update = true;

		this.fillDow();
		this.fillMonths();

		this.update();

		if (this.isInline) {
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_resolveViewName: function _resolveViewName(view) {
			$.each(DPGlobal.viewModes, function (i, viewMode) {
				if (view === i || $.inArray(view, viewMode.names) !== -1) {
					view = i;
					return false;
				}
			});

			return view;
		},

		_resolveDaysOfWeek: function _resolveDaysOfWeek(daysOfWeek) {
			if (!$.isArray(daysOfWeek)) daysOfWeek = daysOfWeek.split(/[,\s]*/);
			return $.map(daysOfWeek, Number);
		},

		_check_template: function _check_template(tmp) {
			try {
				// If empty
				if (tmp === undefined || tmp === "") {
					return false;
				}
				// If no html, everything ok
				if ((tmp.match(/[<>]/g) || []).length <= 0) {
					return true;
				}
				// Checking if html is fine
				var jDom = $(tmp);
				return jDom.length > 0;
			} catch (ex) {
				return false;
			}
		},

		_process_options: function _process_options(opts) {
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]) {
				lang = lang.split('-')[0];
				if (!dates[lang]) lang = defaults.language;
			}
			o.language = lang;

			// Retrieve view index from any aliases
			o.startView = this._resolveViewName(o.startView);
			o.minViewMode = this._resolveViewName(o.minViewMode);
			o.maxViewMode = this._resolveViewName(o.maxViewMode);

			// Check view is between min and max
			o.startView = Math.max(this.o.minViewMode, Math.min(this.o.maxViewMode, o.startView));

			// true, false, or Number > 0
			if (o.multidate !== true) {
				o.multidate = Number(o.multidate) || false;
				if (o.multidate !== false) o.multidate = Math.max(0, o.multidate);
			}
			o.multidateSeparator = String(o.multidateSeparator);

			o.weekStart %= 7;
			o.weekEnd = (o.weekStart + 6) % 7;

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity) {
				if (!!o.startDate) {
					if (o.startDate instanceof Date) o.startDate = this._local_to_utc(this._zero_time(o.startDate));else o.startDate = DPGlobal.parseDate(o.startDate, format, o.language, o.assumeNearbyYear);
				} else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity) {
				if (!!o.endDate) {
					if (o.endDate instanceof Date) o.endDate = this._local_to_utc(this._zero_time(o.endDate));else o.endDate = DPGlobal.parseDate(o.endDate, format, o.language, o.assumeNearbyYear);
				} else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = this._resolveDaysOfWeek(o.daysOfWeekDisabled || []);
			o.daysOfWeekHighlighted = this._resolveDaysOfWeek(o.daysOfWeekHighlighted || []);

			o.datesDisabled = o.datesDisabled || [];
			if (!$.isArray(o.datesDisabled)) {
				o.datesDisabled = o.datesDisabled.split(',');
			}
			o.datesDisabled = $.map(o.datesDisabled, function (d) {
				return DPGlobal.parseDate(d, format, o.language, o.assumeNearbyYear);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
			    _plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function (word) {
				return (/^auto|left|right|top|bottom$/.test(word)
				);
			});
			o.orientation = { x: 'auto', y: 'auto' };
			if (!_plc || _plc === 'auto') ; // no action
			else if (plc.length === 1) {
					switch (plc[0]) {
						case 'top':
						case 'bottom':
							o.orientation.y = plc[0];
							break;
						case 'left':
						case 'right':
							o.orientation.x = plc[0];
							break;
					}
				} else {
					_plc = $.grep(plc, function (word) {
						return (/^left|right$/.test(word)
						);
					});
					o.orientation.x = _plc[0] || 'auto';

					_plc = $.grep(plc, function (word) {
						return (/^top|bottom$/.test(word)
						);
					});
					o.orientation.y = _plc[0] || 'auto';
				}
			if (o.defaultViewDate instanceof Date || typeof o.defaultViewDate === 'string') {
				o.defaultViewDate = DPGlobal.parseDate(o.defaultViewDate, format, o.language, o.assumeNearbyYear);
			} else if (o.defaultViewDate) {
				var year = o.defaultViewDate.year || new Date().getFullYear();
				var month = o.defaultViewDate.month || 0;
				var day = o.defaultViewDate.day || 1;
				o.defaultViewDate = UTCDate(year, month, day);
			} else {
				o.defaultViewDate = UTCToday();
			}
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function _applyEvents(evs) {
			for (var i = 0, el, ch, ev; i < evs.length; i++) {
				el = evs[i][0];
				if (evs[i].length === 2) {
					ch = undefined;
					ev = evs[i][1];
				} else if (evs[i].length === 3) {
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.on(ev, ch);
			}
		},
		_unapplyEvents: function _unapplyEvents(evs) {
			for (var i = 0, el, ev, ch; i < evs.length; i++) {
				el = evs[i][0];
				if (evs[i].length === 2) {
					ch = undefined;
					ev = evs[i][1];
				} else if (evs[i].length === 3) {
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.off(ev, ch);
			}
		},
		_buildEvents: function _buildEvents() {
			var events = {
				keyup: $.proxy(function (e) {
					if ($.inArray(e.keyCode, [27, 37, 39, 38, 40, 32, 13, 9]) === -1) this.update();
				}, this),
				keydown: $.proxy(this.keydown, this),
				paste: $.proxy(this.paste, this)
			};

			if (this.o.showOnFocus === true) {
				events.focus = $.proxy(this.show, this);
			}

			if (this.isInput) {
				// single input
				this._events = [[this.element, events]];
			}
			// component: input + button
			else if (this.component && this.inputField.length) {
					this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.inputField, events], [this.component, {
						click: $.proxy(this.show, this)
					}]];
				} else {
					this._events = [[this.element, {
						click: $.proxy(this.show, this),
						keydown: $.proxy(this.keydown, this)
					}]];
				}
			this._events.push(
			// Component: listen for blur on element descendants
			[this.element, '*', {
				blur: $.proxy(function (e) {
					this._focused_from = e.target;
				}, this)
			}],
			// Input: listen for blur on element
			[this.element, {
				blur: $.proxy(function (e) {
					this._focused_from = e.target;
				}, this)
			}]);

			if (this.o.immediateUpdates) {
				// Trigger input updates immediately on changed year/month
				this._events.push([this.element, {
					'changeYear changeMonth': $.proxy(function (e) {
						this.update(e.date);
					}, this)
				}]);
			}

			this._secondaryEvents = [[this.picker, {
				click: $.proxy(this.click, this)
			}], [this.picker, '.prev, .next', {
				click: $.proxy(this.navArrowsClick, this)
			}], [this.picker, '.day:not(.disabled)', {
				click: $.proxy(this.dayCellClick, this)
			}], [$(window), {
				resize: $.proxy(this.place, this)
			}], [$(document), {
				'mousedown touchstart': $.proxy(function (e) {
					// Clicked outside the datepicker, hide it
					if (!(this.element.is(e.target) || this.element.find(e.target).length || this.picker.is(e.target) || this.picker.find(e.target).length || this.isInline)) {
						this.hide();
					}
				}, this)
			}]];
		},
		_attachEvents: function _attachEvents() {
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function _detachEvents() {
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function _attachSecondaryEvents() {
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function _detachSecondaryEvents() {
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function _trigger(event, altdate) {
			var date = altdate || this.dates.get(-1),
			    local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				viewMode: this.viewMode,
				dates: $.map(this.dates, this._utc_to_local),
				format: $.proxy(function (ix, format) {
					if (arguments.length === 0) {
						ix = this.dates.length - 1;
						format = this.o.format;
					} else if (typeof ix === 'string') {
						format = ix;
						ix = this.dates.length - 1;
					}
					format = format || this.o.format;
					var date = this.dates.get(ix);
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function show() {
			if (this.inputField.prop('disabled') || this.inputField.prop('readonly') && this.o.enableOnReadonly === false) return;
			if (!this.isInline) this.picker.appendTo(this.o.container);
			this.place();
			this.picker.show();
			this._attachSecondaryEvents();
			this._trigger('show');
			if ((window.navigator.msMaxTouchPoints || 'ontouchstart' in document) && this.o.disableTouchKeyboard) {
				$(this.element).blur();
			}
			return this;
		},

		hide: function hide() {
			if (this.isInline || !this.picker.is(':visible')) return this;
			this.focusDate = null;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.setViewMode(this.o.startView);

			if (this.o.forceParse && this.inputField.val()) this.setValue();
			this._trigger('hide');
			return this;
		},

		destroy: function destroy() {
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput) {
				delete this.element.data().date;
			}
			return this;
		},

		paste: function paste(e) {
			var dateString;
			if (e.originalEvent.clipboardData && e.originalEvent.clipboardData.types && $.inArray('text/plain', e.originalEvent.clipboardData.types) !== -1) {
				dateString = e.originalEvent.clipboardData.getData('text/plain');
			} else if (window.clipboardData) {
				dateString = window.clipboardData.getData('Text');
			} else {
				return;
			}
			this.setDate(dateString);
			this.update();
			e.preventDefault();
		},

		_utc_to_local: function _utc_to_local(utc) {
			if (!utc) {
				return utc;
			}

			var local = new Date(utc.getTime() + utc.getTimezoneOffset() * 60000);

			if (local.getTimezoneOffset() !== utc.getTimezoneOffset()) {
				local = new Date(utc.getTime() + local.getTimezoneOffset() * 60000);
			}

			return local;
		},
		_local_to_utc: function _local_to_utc(local) {
			return local && new Date(local.getTime() - local.getTimezoneOffset() * 60000);
		},
		_zero_time: function _zero_time(local) {
			return local && new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function _zero_utc_time(utc) {
			return utc && UTCDate(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate());
		},

		getDates: function getDates() {
			return $.map(this.dates, this._utc_to_local);
		},

		getUTCDates: function getUTCDates() {
			return $.map(this.dates, function (d) {
				return new Date(d);
			});
		},

		getDate: function getDate() {
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function getUTCDate() {
			var selected_date = this.dates.get(-1);
			if (selected_date !== undefined) {
				return new Date(selected_date);
			} else {
				return null;
			}
		},

		clearDates: function clearDates() {
			this.inputField.val('');
			this.update();
			this._trigger('changeDate');

			if (this.o.autoclose) {
				this.hide();
			}
		},

		setDates: function setDates() {
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, args);
			this._trigger('changeDate');
			this.setValue();
			return this;
		},

		setUTCDates: function setUTCDates() {
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.setDates.apply(this, $.map(args, this._utc_to_local));
			return this;
		},

		setDate: alias('setDates'),
		setUTCDate: alias('setUTCDates'),
		remove: alias('destroy', 'Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead'),

		setValue: function setValue() {
			var formatted = this.getFormattedDate();
			this.inputField.val(formatted);
			return this;
		},

		getFormattedDate: function getFormattedDate(format) {
			if (format === undefined) format = this.o.format;

			var lang = this.o.language;
			return $.map(this.dates, function (d) {
				return DPGlobal.formatDate(d, format, lang);
			}).join(this.o.multidateSeparator);
		},

		getStartDate: function getStartDate() {
			return this.o.startDate;
		},

		setStartDate: function setStartDate(startDate) {
			this._process_options({ startDate: startDate });
			this.update();
			this.updateNavArrows();
			return this;
		},

		getEndDate: function getEndDate() {
			return this.o.endDate;
		},

		setEndDate: function setEndDate(endDate) {
			this._process_options({ endDate: endDate });
			this.update();
			this.updateNavArrows();
			return this;
		},

		setDaysOfWeekDisabled: function setDaysOfWeekDisabled(daysOfWeekDisabled) {
			this._process_options({ daysOfWeekDisabled: daysOfWeekDisabled });
			this.update();
			return this;
		},

		setDaysOfWeekHighlighted: function setDaysOfWeekHighlighted(daysOfWeekHighlighted) {
			this._process_options({ daysOfWeekHighlighted: daysOfWeekHighlighted });
			this.update();
			return this;
		},

		setDatesDisabled: function setDatesDisabled(datesDisabled) {
			this._process_options({ datesDisabled: datesDisabled });
			this.update();
			return this;
		},

		place: function place() {
			if (this.isInline) return this;
			var calendarWidth = this.picker.outerWidth(),
			    calendarHeight = this.picker.outerHeight(),
			    visualPadding = 10,
			    container = $(this.o.container),
			    windowWidth = container.width(),
			    scrollTop = this.o.container === 'body' ? $(document).scrollTop() : container.scrollTop(),
			    appendOffset = container.offset();

			var parentsZindex = [0];
			this.element.parents().each(function () {
				var itemZIndex = $(this).css('z-index');
				if (itemZIndex !== 'auto' && Number(itemZIndex) !== 0) parentsZindex.push(Number(itemZIndex));
			});
			var zIndex = Math.max.apply(Math, parentsZindex) + this.o.zIndexOffset;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left - appendOffset.left;
			var top = offset.top - appendOffset.top;

			if (this.o.container !== 'body') {
				top += scrollTop;
			}

			this.picker.removeClass('datepicker-orient-top datepicker-orient-bottom ' + 'datepicker-orient-right datepicker-orient-left');

			if (this.o.orientation.x !== 'auto') {
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right') left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
					if (offset.left < 0) {
						// component is outside the window on the left side. Move it into visible range
						this.picker.addClass('datepicker-orient-left');
						left -= offset.left - visualPadding;
					} else if (left + calendarWidth > windowWidth) {
						// the calendar passes the widow right edge. Align it to component right side
						this.picker.addClass('datepicker-orient-right');
						left += width - calendarWidth;
					} else {
						if (this.o.rtl) {
							// Default to right
							this.picker.addClass('datepicker-orient-right');
						} else {
							// Default to left
							this.picker.addClass('datepicker-orient-left');
						}
					}
				}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
			    top_overflow;
			if (yorient === 'auto') {
				top_overflow = -scrollTop + top - calendarHeight;
				yorient = top_overflow < 0 ? 'bottom' : 'top';
			}

			this.picker.addClass('datepicker-orient-' + yorient);
			if (yorient === 'top') top -= calendarHeight + parseInt(this.picker.css('padding-top'));else top += height;

			if (this.o.rtl) {
				var right = windowWidth - (left + width);
				this.picker.css({
					top: top,
					right: right,
					zIndex: zIndex
				});
			} else {
				this.picker.css({
					top: top,
					left: left,
					zIndex: zIndex
				});
			}
			return this;
		},

		_allow_update: true,
		update: function update() {
			if (!this._allow_update) return this;

			var oldDates = this.dates.copy(),
			    dates = [],
			    fromArgs = false;
			if (arguments.length) {
				$.each(arguments, $.proxy(function (i, date) {
					if (date instanceof Date) date = this._local_to_utc(date);
					dates.push(date);
				}, this));
				fromArgs = true;
			} else {
				dates = this.isInput ? this.element.val() : this.element.data('date') || this.inputField.val();
				if (dates && this.o.multidate) dates = dates.split(this.o.multidateSeparator);else dates = [dates];
				delete this.element.data().date;
			}

			dates = $.map(dates, $.proxy(function (date) {
				return DPGlobal.parseDate(date, this.o.format, this.o.language, this.o.assumeNearbyYear);
			}, this));
			dates = $.grep(dates, $.proxy(function (date) {
				return !this.dateWithinRange(date) || !date;
			}, this), true);
			this.dates.replace(dates);

			if (this.o.updateViewDate) {
				if (this.dates.length) this.viewDate = new Date(this.dates.get(-1));else if (this.viewDate < this.o.startDate) this.viewDate = new Date(this.o.startDate);else if (this.viewDate > this.o.endDate) this.viewDate = new Date(this.o.endDate);else this.viewDate = this.o.defaultViewDate;
			}

			if (fromArgs) {
				// setting date by clicking
				this.setValue();
				this.element.change();
			} else if (this.dates.length) {
				// setting date by typing
				if (String(oldDates) !== String(this.dates) && fromArgs) {
					this._trigger('changeDate');
					this.element.change();
				}
			}
			if (!this.dates.length && oldDates.length) {
				this._trigger('clearDate');
				this.element.change();
			}

			this.fill();
			return this;
		},

		fillDow: function fillDow() {
			if (this.o.showWeekDays) {
				var dowCnt = this.o.weekStart,
				    html = '<tr>';
				if (this.o.calendarWeeks) {
					html += '<th class="cw">&#160;</th>';
				}
				while (dowCnt < this.o.weekStart + 7) {
					html += '<th class="dow';
					if ($.inArray(dowCnt, this.o.daysOfWeekDisabled) !== -1) html += ' disabled';
					html += '">' + dates[this.o.language].daysMin[dowCnt++ % 7] + '</th>';
				}
				html += '</tr>';
				this.picker.find('.datepicker-days thead').append(html);
			}
		},

		fillMonths: function fillMonths() {
			var localDate = this._utc_to_local(this.viewDate);
			var html = '';
			var focused;
			for (var i = 0; i < 12; i++) {
				focused = localDate && localDate.getMonth() === i ? ' focused' : '';
				html += '<span class="month' + focused + '">' + dates[this.o.language].monthsShort[i] + '</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function setRange(range) {
			if (!range || !range.length) delete this.range;else this.range = $.map(range, function (d) {
				return d.valueOf();
			});
			this.fill();
		},

		getClassNames: function getClassNames(date) {
			var cls = [],
			    year = this.viewDate.getUTCFullYear(),
			    month = this.viewDate.getUTCMonth(),
			    today = UTCToday();
			if (date.getUTCFullYear() < year || date.getUTCFullYear() === year && date.getUTCMonth() < month) {
				cls.push('old');
			} else if (date.getUTCFullYear() > year || date.getUTCFullYear() === year && date.getUTCMonth() > month) {
				cls.push('new');
			}
			if (this.focusDate && date.valueOf() === this.focusDate.valueOf()) cls.push('focused');
			// Compare internal UTC date with UTC today, not local today
			if (this.o.todayHighlight && isUTCEquals(date, today)) {
				cls.push('today');
			}
			if (this.dates.contains(date) !== -1) cls.push('active');
			if (!this.dateWithinRange(date)) {
				cls.push('disabled');
			}
			if (this.dateIsDisabled(date)) {
				cls.push('disabled', 'disabled-date');
			}
			if ($.inArray(date.getUTCDay(), this.o.daysOfWeekHighlighted) !== -1) {
				cls.push('highlighted');
			}

			if (this.range) {
				if (date > this.range[0] && date < this.range[this.range.length - 1]) {
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) !== -1) {
					cls.push('selected');
				}
				if (date.valueOf() === this.range[0]) {
					cls.push('range-start');
				}
				if (date.valueOf() === this.range[this.range.length - 1]) {
					cls.push('range-end');
				}
			}
			return cls;
		},

		_fill_yearsView: function _fill_yearsView(selector, cssClass, factor, year, startYear, endYear, beforeFn) {
			var html = '';
			var step = factor / 10;
			var view = this.picker.find(selector);
			var startVal = Math.floor(year / factor) * factor;
			var endVal = startVal + step * 9;
			var focusedVal = Math.floor(this.viewDate.getFullYear() / step) * step;
			var selected = $.map(this.dates, function (d) {
				return Math.floor(d.getUTCFullYear() / step) * step;
			});

			var classes, tooltip, before;
			for (var currVal = startVal - step; currVal <= endVal + step; currVal += step) {
				classes = [cssClass];
				tooltip = null;

				if (currVal === startVal - step) {
					classes.push('old');
				} else if (currVal === endVal + step) {
					classes.push('new');
				}
				if ($.inArray(currVal, selected) !== -1) {
					classes.push('active');
				}
				if (currVal < startYear || currVal > endYear) {
					classes.push('disabled');
				}
				if (currVal === focusedVal) {
					classes.push('focused');
				}

				if (beforeFn !== $.noop) {
					before = beforeFn(new Date(currVal, 0, 1));
					if (before === undefined) {
						before = {};
					} else if (typeof before === 'boolean') {
						before = { enabled: before };
					} else if (typeof before === 'string') {
						before = { classes: before };
					}
					if (before.enabled === false) {
						classes.push('disabled');
					}
					if (before.classes) {
						classes = classes.concat(before.classes.split(/\s+/));
					}
					if (before.tooltip) {
						tooltip = before.tooltip;
					}
				}

				html += '<span class="' + classes.join(' ') + '"' + (tooltip ? ' title="' + tooltip + '"' : '') + '>' + currVal + '</span>';
			}

			view.find('.datepicker-switch').text(startVal + '-' + endVal);
			view.find('td').html(html);
		},

		fill: function fill() {
			var d = new Date(this.viewDate),
			    year = d.getUTCFullYear(),
			    month = d.getUTCMonth(),
			    startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
			    startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
			    endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
			    endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
			    todaytxt = dates[this.o.language].today || dates['en'].today || '',
			    cleartxt = dates[this.o.language].clear || dates['en'].clear || '',
			    titleFormat = dates[this.o.language].titleFormat || dates['en'].titleFormat,
			    tooltip,
			    before;
			if (isNaN(year) || isNaN(month)) return;
			this.picker.find('.datepicker-days .datepicker-switch').text(DPGlobal.formatDate(d, titleFormat, this.o.language));
			this.picker.find('tfoot .today').text(todaytxt).css('display', this.o.todayBtn === true || this.o.todayBtn === 'linked' ? 'table-cell' : 'none');
			this.picker.find('tfoot .clear').text(cleartxt).css('display', this.o.clearBtn === true ? 'table-cell' : 'none');
			this.picker.find('thead .datepicker-title').text(this.o.title).css('display', typeof this.o.title === 'string' && this.o.title !== '' ? 'table-cell' : 'none');
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month, 0),
			    day = prevMonth.getUTCDate();
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7) % 7);
			var nextMonth = new Date(prevMonth);
			if (prevMonth.getUTCFullYear() < 100) {
				nextMonth.setUTCFullYear(prevMonth.getUTCFullYear());
			}
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var weekDay, clsName;
			while (prevMonth.valueOf() < nextMonth) {
				weekDay = prevMonth.getUTCDay();
				if (weekDay === this.o.weekStart) {
					html.push('<tr>');
					if (this.o.calendarWeeks) {
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
						// Start of current week: based on weekstart/current date
						ws = new Date(+prevMonth + (this.o.weekStart - weekDay - 7) % 7 * 864e5),

						// Thursday of this week
						th = new Date(Number(ws) + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),

						// First Thursday of year, year from thursday
						yth = new Date(Number(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay()) % 7 * 864e5),

						// Calendar week: ms between thursdays, div ms per day, div 7 days
						calWeek = (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">' + calWeek + '</td>');
					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				var content = prevMonth.getUTCDate();

				if (this.o.beforeShowDay !== $.noop) {
					before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
					if (before === undefined) before = {};else if (typeof before === 'boolean') before = { enabled: before };else if (typeof before === 'string') before = { classes: before };
					if (before.enabled === false) clsName.push('disabled');
					if (before.classes) clsName = clsName.concat(before.classes.split(/\s+/));
					if (before.tooltip) tooltip = before.tooltip;
					if (before.content) content = before.content;
				}

				//Check if uniqueSort exists (supported by jquery >=1.12 and >=2.2)
				//Fallback to unique function for older jquery versions
				if ($.isFunction($.uniqueSort)) {
					clsName = $.uniqueSort(clsName);
				} else {
					clsName = $.unique(clsName);
				}

				html.push('<td class="' + clsName.join(' ') + '"' + (tooltip ? ' title="' + tooltip + '"' : '') + ' data-date="' + prevMonth.getTime().toString() + '">' + content + '</td>');
				tooltip = null;
				if (weekDay === this.o.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate() + 1);
			}
			this.picker.find('.datepicker-days tbody').html(html.join(''));

			var monthsTitle = dates[this.o.language].monthsTitle || dates['en'].monthsTitle || 'Months';
			var months = this.picker.find('.datepicker-months').find('.datepicker-switch').text(this.o.maxViewMode < 2 ? monthsTitle : year).end().find('tbody span').removeClass('active');

			$.each(this.dates, function (i, d) {
				if (d.getUTCFullYear() === year) months.eq(d.getUTCMonth()).addClass('active');
			});

			if (year < startYear || year > endYear) {
				months.addClass('disabled');
			}
			if (year === startYear) {
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year === endYear) {
				months.slice(endMonth + 1).addClass('disabled');
			}

			if (this.o.beforeShowMonth !== $.noop) {
				var that = this;
				$.each(months, function (i, month) {
					var moDate = new Date(year, i, 1);
					var before = that.o.beforeShowMonth(moDate);
					if (before === undefined) before = {};else if (typeof before === 'boolean') before = { enabled: before };else if (typeof before === 'string') before = { classes: before };
					if (before.enabled === false && !$(month).hasClass('disabled')) $(month).addClass('disabled');
					if (before.classes) $(month).addClass(before.classes);
					if (before.tooltip) $(month).prop('title', before.tooltip);
				});
			}

			// Generating decade/years picker
			this._fill_yearsView('.datepicker-years', 'year', 10, year, startYear, endYear, this.o.beforeShowYear);

			// Generating century/decades picker
			this._fill_yearsView('.datepicker-decades', 'decade', 100, year, startYear, endYear, this.o.beforeShowDecade);

			// Generating millennium/centuries picker
			this._fill_yearsView('.datepicker-centuries', 'century', 1000, year, startYear, endYear, this.o.beforeShowCentury);
		},

		updateNavArrows: function updateNavArrows() {
			if (!this._allow_update) return;

			var d = new Date(this.viewDate),
			    year = d.getUTCFullYear(),
			    month = d.getUTCMonth(),
			    startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
			    startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
			    endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
			    endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
			    prevIsDisabled,
			    nextIsDisabled,
			    factor = 1;
			switch (this.viewMode) {
				case 4:
					factor *= 10;
				/* falls through */
				case 3:
					factor *= 10;
				/* falls through */
				case 2:
					factor *= 10;
				/* falls through */
				case 1:
					prevIsDisabled = Math.floor(year / factor) * factor < startYear;
					nextIsDisabled = Math.floor(year / factor) * factor + factor > endYear;
					break;
				case 0:
					prevIsDisabled = year <= startYear && month < startMonth;
					nextIsDisabled = year >= endYear && month > endMonth;
					break;
			}

			this.picker.find('.prev').toggleClass('disabled', prevIsDisabled);
			this.picker.find('.next').toggleClass('disabled', nextIsDisabled);
		},

		click: function click(e) {
			e.preventDefault();
			e.stopPropagation();

			var target, dir, day, year, month;
			target = $(e.target);

			// Clicked on the switch
			if (target.hasClass('datepicker-switch') && this.viewMode !== this.o.maxViewMode) {
				this.setViewMode(this.viewMode + 1);
			}

			// Clicked on today button
			if (target.hasClass('today') && !target.hasClass('day')) {
				this.setViewMode(0);
				this._setDate(UTCToday(), this.o.todayBtn === 'linked' ? null : 'view');
			}

			// Clicked on clear button
			if (target.hasClass('clear')) {
				this.clearDates();
			}

			if (!target.hasClass('disabled')) {
				// Clicked on a month, year, decade, century
				if (target.hasClass('month') || target.hasClass('year') || target.hasClass('decade') || target.hasClass('century')) {
					this.viewDate.setUTCDate(1);

					day = 1;
					if (this.viewMode === 1) {
						month = target.parent().find('span').index(target);
						year = this.viewDate.getUTCFullYear();
						this.viewDate.setUTCMonth(month);
					} else {
						month = 0;
						year = Number(target.text());
						this.viewDate.setUTCFullYear(year);
					}

					this._trigger(DPGlobal.viewModes[this.viewMode - 1].e, this.viewDate);

					if (this.viewMode === this.o.minViewMode) {
						this._setDate(UTCDate(year, month, day));
					} else {
						this.setViewMode(this.viewMode - 1);
						this.fill();
					}
				}
			}

			if (this.picker.is(':visible') && this._focused_from) {
				this._focused_from.focus();
			}
			delete this._focused_from;
		},

		dayCellClick: function dayCellClick(e) {
			var $target = $(e.currentTarget);
			var timestamp = $target.data('date');
			var date = new Date(timestamp);

			if (this.o.updateViewDate) {
				if (date.getUTCFullYear() !== this.viewDate.getUTCFullYear()) {
					this._trigger('changeYear', this.viewDate);
				}

				if (date.getUTCMonth() !== this.viewDate.getUTCMonth()) {
					this._trigger('changeMonth', this.viewDate);
				}
			}
			this._setDate(date);
		},

		// Clicked on prev or next
		navArrowsClick: function navArrowsClick(e) {
			var $target = $(e.currentTarget);
			var dir = $target.hasClass('prev') ? -1 : 1;
			if (this.viewMode !== 0) {
				dir *= DPGlobal.viewModes[this.viewMode].navStep * 12;
			}
			this.viewDate = this.moveMonth(this.viewDate, dir);
			this._trigger(DPGlobal.viewModes[this.viewMode].e, this.viewDate);
			this.fill();
		},

		_toggle_multidate: function _toggle_multidate(date) {
			var ix = this.dates.contains(date);
			if (!date) {
				this.dates.clear();
			}

			if (ix !== -1) {
				if (this.o.multidate === true || this.o.multidate > 1 || this.o.toggleActive) {
					this.dates.remove(ix);
				}
			} else if (this.o.multidate === false) {
				this.dates.clear();
				this.dates.push(date);
			} else {
				this.dates.push(date);
			}

			if (typeof this.o.multidate === 'number') while (this.dates.length > this.o.multidate) {
				this.dates.remove(0);
			}
		},

		_setDate: function _setDate(date, which) {
			if (!which || which === 'date') this._toggle_multidate(date && new Date(date));
			if (!which && this.o.updateViewDate || which === 'view') this.viewDate = date && new Date(date);

			this.fill();
			this.setValue();
			if (!which || which !== 'view') {
				this._trigger('changeDate');
			}
			this.inputField.trigger('change');
			if (this.o.autoclose && (!which || which === 'date')) {
				this.hide();
			}
		},

		moveDay: function moveDay(date, dir) {
			var newDate = new Date(date);
			newDate.setUTCDate(date.getUTCDate() + dir);

			return newDate;
		},

		moveWeek: function moveWeek(date, dir) {
			return this.moveDay(date, dir * 7);
		},

		moveMonth: function moveMonth(date, dir) {
			if (!isValidDate(date)) return this.o.defaultViewDate;
			if (!dir) return date;
			var new_date = new Date(date.valueOf()),
			    day = new_date.getUTCDate(),
			    month = new_date.getUTCMonth(),
			    mag = Math.abs(dir),
			    new_month,
			    test;
			dir = dir > 0 ? 1 : -1;
			if (mag === 1) {
				test = dir === -1
				// If going back one month, make sure month is not current month
				// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
				? function () {
					return new_date.getUTCMonth() === month;
				}
				// If going forward one month, make sure month is as expected
				// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
				: function () {
					return new_date.getUTCMonth() !== new_month;
				};
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				new_month = (new_month + 12) % 12;
			} else {
				// For magnitudes >1, move one month at a time...
				for (var i = 0; i < mag; i++) {
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				} // ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function test() {
					return new_month !== new_date.getUTCMonth();
				};
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()) {
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function moveYear(date, dir) {
			return this.moveMonth(date, dir * 12);
		},

		moveAvailableDate: function moveAvailableDate(date, dir, fn) {
			do {
				date = this[fn](date, dir);

				if (!this.dateWithinRange(date)) return false;

				fn = 'moveDay';
			} while (this.dateIsDisabled(date));

			return date;
		},

		weekOfDateIsDisabled: function weekOfDateIsDisabled(date) {
			return $.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1;
		},

		dateIsDisabled: function dateIsDisabled(date) {
			return this.weekOfDateIsDisabled(date) || $.grep(this.o.datesDisabled, function (d) {
				return isUTCEquals(date, d);
			}).length > 0;
		},

		dateWithinRange: function dateWithinRange(date) {
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function keydown(e) {
			if (!this.picker.is(':visible')) {
				if (e.keyCode === 40 || e.keyCode === 27) {
					// allow down to re-show picker
					this.show();
					e.stopPropagation();
				}
				return;
			}
			var dateChanged = false,
			    dir,
			    newViewDate,
			    focusDate = this.focusDate || this.viewDate;
			switch (e.keyCode) {
				case 27:
					// escape
					if (this.focusDate) {
						this.focusDate = null;
						this.viewDate = this.dates.get(-1) || this.viewDate;
						this.fill();
					} else this.hide();
					e.preventDefault();
					e.stopPropagation();
					break;
				case 37: // left
				case 38: // up
				case 39: // right
				case 40:
					// down
					if (!this.o.keyboardNavigation || this.o.daysOfWeekDisabled.length === 7) break;
					dir = e.keyCode === 37 || e.keyCode === 38 ? -1 : 1;
					if (this.viewMode === 0) {
						if (e.ctrlKey) {
							newViewDate = this.moveAvailableDate(focusDate, dir, 'moveYear');

							if (newViewDate) this._trigger('changeYear', this.viewDate);
						} else if (e.shiftKey) {
							newViewDate = this.moveAvailableDate(focusDate, dir, 'moveMonth');

							if (newViewDate) this._trigger('changeMonth', this.viewDate);
						} else if (e.keyCode === 37 || e.keyCode === 39) {
							newViewDate = this.moveAvailableDate(focusDate, dir, 'moveDay');
						} else if (!this.weekOfDateIsDisabled(focusDate)) {
							newViewDate = this.moveAvailableDate(focusDate, dir, 'moveWeek');
						}
					} else if (this.viewMode === 1) {
						if (e.keyCode === 38 || e.keyCode === 40) {
							dir = dir * 4;
						}
						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveMonth');
					} else if (this.viewMode === 2) {
						if (e.keyCode === 38 || e.keyCode === 40) {
							dir = dir * 4;
						}
						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveYear');
					}
					if (newViewDate) {
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 13:
					// enter
					if (!this.o.forceParse) break;
					focusDate = this.focusDate || this.dates.get(-1) || this.viewDate;
					if (this.o.keyboardNavigation) {
						this._toggle_multidate(focusDate);
						dateChanged = true;
					}
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.setValue();
					this.fill();
					if (this.picker.is(':visible')) {
						e.preventDefault();
						e.stopPropagation();
						if (this.o.autoclose) this.hide();
					}
					break;
				case 9:
					// tab
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.fill();
					this.hide();
					break;
			}
			if (dateChanged) {
				if (this.dates.length) this._trigger('changeDate');else this._trigger('clearDate');
				this.inputField.trigger('change');
			}
		},

		setViewMode: function setViewMode(viewMode) {
			this.viewMode = viewMode;
			this.picker.children('div').hide().filter('.datepicker-' + DPGlobal.viewModes[this.viewMode].clsName).show();
			this.updateNavArrows();
			this._trigger('changeViewMode', new Date(this.viewDate));
		}
	};

	var DateRangePicker = function DateRangePicker(element, options) {
		$.data(element, 'datepicker', this);
		this.element = $(element);
		this.inputs = $.map(options.inputs, function (i) {
			return i.jquery ? i[0] : i;
		});
		delete options.inputs;

		this.keepEmptyValues = options.keepEmptyValues;
		delete options.keepEmptyValues;

		datepickerPlugin.call($(this.inputs), options).on('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function (i) {
			return $.data(i, 'datepicker');
		});
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function updateDates() {
			this.dates = $.map(this.pickers, function (i) {
				return i.getUTCDate();
			});
			this.updateRanges();
		},
		updateRanges: function updateRanges() {
			var range = $.map(this.dates, function (d) {
				return d.valueOf();
			});
			$.each(this.pickers, function (i, p) {
				p.setRange(range);
			});
		},
		clearDates: function clearDates() {
			$.each(this.pickers, function (i, p) {
				p.clearDates();
			});
		},
		dateUpdated: function dateUpdated(e) {
			// `this.updating` is a workaround for preventing infinite recursion
			// between `changeDate` triggering and `setUTCDate` calling.  Until
			// there is a better mechanism.
			if (this.updating) return;
			this.updating = true;

			var dp = $.data(e.target, 'datepicker');

			if (dp === undefined) {
				return;
			}

			var new_date = dp.getUTCDate(),
			    keep_empty_values = this.keepEmptyValues,
			    i = $.inArray(e.target, this.inputs),
			    j = i - 1,
			    k = i + 1,
			    l = this.inputs.length;
			if (i === -1) return;

			$.each(this.pickers, function (i, p) {
				if (!p.getUTCDate() && (p === dp || !keep_empty_values)) p.setUTCDate(new_date);
			});

			if (new_date < this.dates[j]) {
				// Date being moved earlier/left
				while (j >= 0 && new_date < this.dates[j]) {
					this.pickers[j--].setUTCDate(new_date);
				}
			} else if (new_date > this.dates[k]) {
				// Date being moved later/right
				while (k < l && new_date > this.dates[k]) {
					this.pickers[k++].setUTCDate(new_date);
				}
			}
			this.updateDates();

			delete this.updating;
		},
		destroy: function destroy() {
			$.map(this.pickers, function (p) {
				p.destroy();
			});
			$(this.inputs).off('changeDate', this.dateUpdated);
			delete this.element.data().datepicker;
		},
		remove: alias('destroy', 'Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead')
	};

	function opts_from_el(el, prefix) {
		// Derive options from element data-attrs
		var data = $(el).data(),
		    out = {},
		    inkey,
		    replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])');
		prefix = new RegExp('^' + prefix.toLowerCase());
		function re_lower(_, a) {
			return a.toLowerCase();
		}
		for (var key in data) {
			if (prefix.test(key)) {
				inkey = key.replace(replace, re_lower);
				out[inkey] = data[key];
			}
		}return out;
	}

	function opts_from_locale(lang) {
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]) {
			lang = lang.split('-')[0];
			if (!dates[lang]) return;
		}
		var d = dates[lang];
		$.each(locale_opts, function (i, k) {
			if (k in d) out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	var datepickerPlugin = function datepickerPlugin(option) {
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return;
		this.each(function () {
			var $this = $(this),
			    data = $this.data('datepicker'),
			    options = (typeof option === 'undefined' ? 'undefined' : _typeof(option)) === 'object' && option;
			if (!data) {
				var elopts = opts_from_el(this, 'date'),

				// Preliminary otions
				xopts = $.extend({}, defaults, elopts, options),
				    locopts = opts_from_locale(xopts.language),

				// Options priority: js args, data-attrs, locales, defaults
				opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.hasClass('input-daterange') || opts.inputs) {
					$.extend(opts, {
						inputs: opts.inputs || $this.find('input').toArray()
					});
					data = new DateRangePicker(this, opts);
				} else {
					data = new Datepicker(this, opts);
				}
				$this.data('datepicker', data);
			}
			if (typeof option === 'string' && typeof data[option] === 'function') {
				internal_return = data[option].apply(data, args);
			}
		});

		if (internal_return === undefined || internal_return instanceof Datepicker || internal_return instanceof DateRangePicker) return this;

		if (this.length > 1) throw new Error('Using only allowed for the collection of a single element (' + option + ' function)');else return internal_return;
	};
	$.fn.datepicker = datepickerPlugin;

	var defaults = $.fn.datepicker.defaults = {
		assumeNearbyYear: false,
		autoclose: false,
		beforeShowDay: $.noop,
		beforeShowMonth: $.noop,
		beforeShowYear: $.noop,
		beforeShowDecade: $.noop,
		beforeShowCentury: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		toggleActive: false,
		daysOfWeekDisabled: [],
		daysOfWeekHighlighted: [],
		datesDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keepEmptyValues: false,
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		maxViewMode: 4,
		multidate: false,
		multidateSeparator: ',',
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		updateViewDate: true,
		weekStart: 0,
		disableTouchKeyboard: false,
		enableOnReadonly: true,
		showOnFocus: true,
		zIndexOffset: 10,
		container: 'body',
		immediateUpdates: false,
		title: '',
		templates: {
			leftArrow: '&#x00AB;',
			rightArrow: '&#x00BB;'
		},
		showWeekDays: true
	};
	var locale_opts = $.fn.datepicker.locale_opts = ['format', 'rtl', 'weekStart'];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear",
			titleFormat: "MM yyyy"
		}
	};

	var DPGlobal = {
		viewModes: [{
			names: ['days', 'month'],
			clsName: 'days',
			e: 'changeMonth'
		}, {
			names: ['months', 'year'],
			clsName: 'months',
			e: 'changeYear',
			navStep: 1
		}, {
			names: ['years', 'decade'],
			clsName: 'years',
			e: 'changeDecade',
			navStep: 10
		}, {
			names: ['decades', 'century'],
			clsName: 'decades',
			e: 'changeCentury',
			navStep: 100
		}, {
			names: ['centuries', 'millennium'],
			clsName: 'centuries',
			e: 'changeMillennium',
			navStep: 1000
		}],
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\u5e74\u6708\u65e5\[-`{-~\t\n\r]+/g,
		parseFormat: function parseFormat(format) {
			if (typeof format.toValue === 'function' && typeof format.toDisplay === 'function') return format;
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
			    parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0) {
				throw new Error("Invalid date format.");
			}
			return { separators: separators, parts: parts };
		},
		parseDate: function parseDate(date, format, language, assumeNearby) {
			if (!date) return undefined;
			if (date instanceof Date) return date;
			if (typeof format === 'string') format = DPGlobal.parseFormat(format);
			if (format.toValue) return format.toValue(date, format, language);
			var fn_map = {
				d: 'moveDay',
				m: 'moveMonth',
				w: 'moveWeek',
				y: 'moveYear'
			},
			    dateAliases = {
				yesterday: '-1d',
				today: '+0d',
				tomorrow: '+1d'
			},
			    parts,
			    part,
			    dir,
			    i,
			    fn;
			if (date in dateAliases) {
				date = dateAliases[date];
			}
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/i.test(date)) {
				parts = date.match(/([\-+]\d+)([dmwy])/gi);
				date = new Date();
				for (i = 0; i < parts.length; i++) {
					part = parts[i].match(/([\-+]\d+)([dmwy])/i);
					dir = Number(part[1]);
					fn = fn_map[part[2].toLowerCase()];
					date = Datepicker.prototype[fn](date, dir);
				}
				return Datepicker.prototype._zero_utc_time(date);
			}

			parts = date && date.match(this.nonpunctuation) || [];

			function applyNearbyYear(year, threshold) {
				if (threshold === true) threshold = 10;

				// if year is 2 digits or less, than the user most likely is trying to get a recent century
				if (year < 100) {
					year += 2000;
					// if the new year is more than threshold years in advance, use last century
					if (year > new Date().getFullYear() + threshold) {
						year -= 100;
					}
				}

				return year;
			}

			var parsed = {},
			    setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
			    setters_map = {
				yyyy: function yyyy(d, v) {
					return d.setUTCFullYear(assumeNearby ? applyNearbyYear(v, assumeNearby) : v);
				},
				m: function m(d, v) {
					if (isNaN(d)) return d;
					v -= 1;
					while (v < 0) {
						v += 12;
					}v %= 12;
					d.setUTCMonth(v);
					while (d.getUTCMonth() !== v) {
						d.setUTCDate(d.getUTCDate() - 1);
					}return d;
				},
				d: function d(_d, v) {
					return _d.setUTCDate(v);
				}
			},
			    val,
			    filtered;
			setters_map['yy'] = setters_map['yyyy'];
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCToday();
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length !== fparts.length) {
				fparts = $(fparts).filter(function (i, p) {
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			function match_part() {
				var m = this.slice(0, parts[i].length),
				    p = parts[i].slice(0, m.length);
				return m.toLowerCase() === p.toLowerCase();
			}
			if (parts.length === fparts.length) {
				var cnt;
				for (i = 0, cnt = fparts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)) {
						switch (part) {
							case 'MM':
								filtered = $(dates[language].months).filter(match_part);
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(match_part);
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				var _date, s;
				for (i = 0; i < setters_order.length; i++) {
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])) {
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date)) date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function formatDate(date, format, language) {
			if (!date) return '';
			if (typeof format === 'string') format = DPGlobal.parseFormat(format);
			if (format.toDisplay) return format.toDisplay(date, format, language);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			date = [];
			var seps = $.extend([], format.separators);
			for (var i = 0, cnt = format.parts.length; i <= cnt; i++) {
				if (seps.length) date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>' + '<tr>' + '<th colspan="7" class="datepicker-title"></th>' + '</tr>' + '<tr>' + '<th class="prev">' + defaults.templates.leftArrow + '</th>' + '<th colspan="5" class="datepicker-switch"></th>' + '<th class="next">' + defaults.templates.rightArrow + '</th>' + '</tr>' + '</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot>' + '<tr>' + '<th colspan="7" class="today"></th>' + '</tr>' + '<tr>' + '<th colspan="7" class="clear"></th>' + '</tr>' + '</tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">' + '<div class="datepicker-days">' + '<table class="table-condensed">' + DPGlobal.headTemplate + '<tbody></tbody>' + DPGlobal.footTemplate + '</table>' + '</div>' + '<div class="datepicker-months">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + DPGlobal.footTemplate + '</table>' + '</div>' + '<div class="datepicker-years">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + DPGlobal.footTemplate + '</table>' + '</div>' + '<div class="datepicker-decades">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + DPGlobal.footTemplate + '</table>' + '</div>' + '<div class="datepicker-centuries">' + '<table class="table-condensed">' + DPGlobal.headTemplate + DPGlobal.contTemplate + DPGlobal.footTemplate + '</table>' + '</div>' + '</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;

	/* DATEPICKER NO CONFLICT
 * =================== */

	$.fn.datepicker.noConflict = function () {
		$.fn.datepicker = old;
		return this;
	};

	/* DATEPICKER VERSION
  * =================== */
	$.fn.datepicker.version = '1.8.0';

	$.fn.datepicker.deprecated = function (msg) {
		var console = window.console;
		if (console && console.warn) {
			console.warn('DEPRECATED: ' + msg);
		}
	};

	/* DATEPICKER DATA-API
 * ================== */

	$(document).on('focus.datepicker.data-api click.datepicker.data-api', '[data-provide="datepicker"]', function (e) {
		var $this = $(this);
		if ($this.data('datepicker')) return;
		e.preventDefault();
		// component click requires us to explicitly show it
		datepickerPlugin.call($this, 'show');
	});
	$(function () {
		datepickerPlugin.call($('[data-provide="datepicker-inline"]'));
	});
});

/**
* Japanese translation for bootstrap-datepicker
* Norio Suzuki <https://github.com/suzuki/>
*/
;(function ($) {
	$.fn.datepicker.dates['ja'] = {
		days: ["日曜", "月曜", "火曜", "水曜", "木曜", "金曜", "土曜"],
		daysShort: ["日", "月", "火", "水", "木", "金", "土"],
		daysMin: ["日", "月", "火", "水", "木", "金", "土"],
		months: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
		monthsShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
		today: "今日",
		format: "yyyy/mm/dd",
		titleFormat: "yyyy年mm月",
		clear: "クリア"
	};
})(jQuery);
/**
* Vietnamese translation for bootstrap-datepicker
* An Vo <https://github.com/anvoz/>
*/
;(function ($) {
	$.fn.datepicker.dates['vi'] = {
		days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
		daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
		daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
		months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
		monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
		today: "Hôm nay",
		clear: "Xóa",
		format: "dd/mm/yyyy"
	};
})(jQuery);
/*! bootstrap-timepicker v0.5.2 
* http://jdewit.github.com/bootstrap-timepicker 
* Copyright (c) 2016 Joris de Wit and bootstrap-timepicker contributors 
* MIT License 
*/!function (a, b, c) {
	"use strict";
	var d = function d(b, c) {
		this.widget = "", this.$element = a(b), this.defaultTime = c.defaultTime, this.disableFocus = c.disableFocus, this.disableMousewheel = c.disableMousewheel, this.isOpen = c.isOpen, this.minuteStep = c.minuteStep, this.modalBackdrop = c.modalBackdrop, this.orientation = c.orientation, this.secondStep = c.secondStep, this.snapToStep = c.snapToStep, this.showInputs = c.showInputs, this.showMeridian = c.showMeridian, this.showSeconds = c.showSeconds, this.template = c.template, this.appendWidgetTo = c.appendWidgetTo, this.showWidgetOnAddonClick = c.showWidgetOnAddonClick, this.icons = c.icons, this.maxHours = c.maxHours, this.explicitMode = c.explicitMode, this.handleDocumentClick = function (a) {
			var b = a.data.scope;b.$element.parent().find(a.target).length || b.$widget.is(a.target) || b.$widget.find(a.target).length || b.hideWidget();
		}, this._init();
	};d.prototype = { constructor: d, _init: function _init() {
			var b = this;this.showWidgetOnAddonClick && this.$element.parent().hasClass("input-group") && this.$element.parent().hasClass("bootstrap-timepicker") ? (this.$element.parent(".input-group.bootstrap-timepicker").find(".input-group-addon").on({ "click.timepicker": a.proxy(this.showWidget, this) }), this.$element.on({ "focus.timepicker": a.proxy(this.highlightUnit, this), "click.timepicker": a.proxy(this.highlightUnit, this), "keydown.timepicker": a.proxy(this.elementKeydown, this), "blur.timepicker": a.proxy(this.blurElement, this), "mousewheel.timepicker DOMMouseScroll.timepicker": a.proxy(this.mousewheel, this) })) : this.template ? this.$element.on({ "focus.timepicker": a.proxy(this.showWidget, this), "click.timepicker": a.proxy(this.showWidget, this), "blur.timepicker": a.proxy(this.blurElement, this), "mousewheel.timepicker DOMMouseScroll.timepicker": a.proxy(this.mousewheel, this) }) : this.$element.on({ "focus.timepicker": a.proxy(this.highlightUnit, this), "click.timepicker": a.proxy(this.highlightUnit, this), "keydown.timepicker": a.proxy(this.elementKeydown, this), "blur.timepicker": a.proxy(this.blurElement, this), "mousewheel.timepicker DOMMouseScroll.timepicker": a.proxy(this.mousewheel, this) }), this.template !== !1 ? this.$widget = a(this.getTemplate()).on("click", a.proxy(this.widgetClick, this)) : this.$widget = !1, this.showInputs && this.$widget !== !1 && this.$widget.find("input").each(function () {
				a(this).on({ "click.timepicker": function clickTimepicker() {
						a(this).select();
					}, "keydown.timepicker": a.proxy(b.widgetKeydown, b), "keyup.timepicker": a.proxy(b.widgetKeyup, b) });
			}), this.setDefaultTime(this.defaultTime);
		}, blurElement: function blurElement() {
			this.highlightedUnit = null, this.updateFromElementVal();
		}, clear: function clear() {
			this.hour = "", this.minute = "", this.second = "", this.meridian = "", this.$element.val("");
		}, decrementHour: function decrementHour() {
			if (this.showMeridian) {
				if (1 === this.hour) this.hour = 12;else {
					if (12 === this.hour) return this.hour--, this.toggleMeridian();if (0 === this.hour) return this.hour = 11, this.toggleMeridian();this.hour--;
				}
			} else this.hour <= 0 ? this.hour = this.maxHours - 1 : this.hour--;
		}, decrementMinute: function decrementMinute(a) {
			var b;b = a ? this.minute - a : this.minute - this.minuteStep, 0 > b ? (this.decrementHour(), this.minute = b + 60) : this.minute = b;
		}, decrementSecond: function decrementSecond() {
			var a = this.second - this.secondStep;0 > a ? (this.decrementMinute(!0), this.second = a + 60) : this.second = a;
		}, elementKeydown: function elementKeydown(a) {
			switch (a.which) {case 9:
					if (a.shiftKey) {
						if ("hour" === this.highlightedUnit) {
							this.hideWidget();break;
						}this.highlightPrevUnit();
					} else {
						if (this.showMeridian && "meridian" === this.highlightedUnit || this.showSeconds && "second" === this.highlightedUnit || !this.showMeridian && !this.showSeconds && "minute" === this.highlightedUnit) {
							this.hideWidget();break;
						}this.highlightNextUnit();
					}a.preventDefault(), this.updateFromElementVal();break;case 27:
					this.updateFromElementVal();break;case 37:
					a.preventDefault(), this.highlightPrevUnit(), this.updateFromElementVal();break;case 38:
					switch (a.preventDefault(), this.highlightedUnit) {case "hour":
							this.incrementHour(), this.highlightHour();break;case "minute":
							this.incrementMinute(), this.highlightMinute();break;case "second":
							this.incrementSecond(), this.highlightSecond();break;case "meridian":
							this.toggleMeridian(), this.highlightMeridian();}this.update();break;case 39:
					a.preventDefault(), this.highlightNextUnit(), this.updateFromElementVal();break;case 40:
					switch (a.preventDefault(), this.highlightedUnit) {case "hour":
							this.decrementHour(), this.highlightHour();break;case "minute":
							this.decrementMinute(), this.highlightMinute();break;case "second":
							this.decrementSecond(), this.highlightSecond();break;case "meridian":
							this.toggleMeridian(), this.highlightMeridian();}this.update();}
		}, getCursorPosition: function getCursorPosition() {
			var a = this.$element.get(0);if ("selectionStart" in a) return a.selectionStart;if (c.selection) {
				a.focus();var b = c.selection.createRange(),
				    d = c.selection.createRange().text.length;return b.moveStart("character", -a.value.length), b.text.length - d;
			}
		}, getTemplate: function getTemplate() {
			var a, b, c, d, e, f;switch (this.showInputs ? (b = '<input type="text" class="bootstrap-timepicker-hour" maxlength="2"/>', c = '<input type="text" class="bootstrap-timepicker-minute" maxlength="2"/>', d = '<input type="text" class="bootstrap-timepicker-second" maxlength="2"/>', e = '<input type="text" class="bootstrap-timepicker-meridian" maxlength="2"/>') : (b = '<span class="bootstrap-timepicker-hour"></span>', c = '<span class="bootstrap-timepicker-minute"></span>', d = '<span class="bootstrap-timepicker-second"></span>', e = '<span class="bootstrap-timepicker-meridian"></span>'), f = '<table><tr><td><a href="#" data-action="incrementHour"><span class="' + this.icons.up + '"></span></a></td><td class="separator">&nbsp;</td><td><a href="#" data-action="incrementMinute"><span class="' + this.icons.up + '"></span></a></td>' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="incrementSecond"><span class="' + this.icons.up + '"></span></a></td>' : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td class="meridian-column"><a href="#" data-action="toggleMeridian"><span class="' + this.icons.up + '"></span></a></td>' : "") + "</tr><tr><td>" + b + '</td> <td class="separator">:</td><td>' + c + "</td> " + (this.showSeconds ? '<td class="separator">:</td><td>' + d + "</td>" : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td>' + e + "</td>" : "") + '</tr><tr><td><a href="#" data-action="decrementHour"><span class="' + this.icons.down + '"></span></a></td><td class="separator"></td><td><a href="#" data-action="decrementMinute"><span class="' + this.icons.down + '"></span></a></td>' + (this.showSeconds ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="decrementSecond"><span class="' + this.icons.down + '"></span></a></td>' : "") + (this.showMeridian ? '<td class="separator">&nbsp;</td><td><a href="#" data-action="toggleMeridian"><span class="' + this.icons.down + '"></span></a></td>' : "") + "</tr></table>", this.template) {case "modal":
					a = '<div class="bootstrap-timepicker-widget modal hide fade in" data-backdrop="' + (this.modalBackdrop ? "true" : "false") + '"><div class="modal-header"><a href="#" class="close" data-dismiss="modal">&times;</a><h3>Pick a Time</h3></div><div class="modal-content">' + f + '</div><div class="modal-footer"><a href="#" class="btn btn-primary" data-dismiss="modal">OK</a></div></div>';break;case "dropdown":
					a = '<div class="bootstrap-timepicker-widget dropdown-menu">' + f + "</div>";}return a;
		}, getTime: function getTime() {
			return "" === this.hour ? "" : this.hour + ":" + (1 === this.minute.toString().length ? "0" + this.minute : this.minute) + (this.showSeconds ? ":" + (1 === this.second.toString().length ? "0" + this.second : this.second) : "") + (this.showMeridian ? " " + this.meridian : "");
		}, hideWidget: function hideWidget() {
			this.isOpen !== !1 && (this.$element.trigger({ type: "hide.timepicker", time: { value: this.getTime(), hours: this.hour, minutes: this.minute, seconds: this.second, meridian: this.meridian } }), "modal" === this.template && this.$widget.modal ? this.$widget.modal("hide") : this.$widget.removeClass("open"), a(c).off("mousedown.timepicker, touchend.timepicker", this.handleDocumentClick), this.isOpen = !1, this.$widget.detach());
		}, highlightUnit: function highlightUnit() {
			this.position = this.getCursorPosition(), this.position >= 0 && this.position <= 2 ? this.highlightHour() : this.position >= 3 && this.position <= 5 ? this.highlightMinute() : this.position >= 6 && this.position <= 8 ? this.showSeconds ? this.highlightSecond() : this.highlightMeridian() : this.position >= 9 && this.position <= 11 && this.highlightMeridian();
		}, highlightNextUnit: function highlightNextUnit() {
			switch (this.highlightedUnit) {case "hour":
					this.highlightMinute();break;case "minute":
					this.showSeconds ? this.highlightSecond() : this.showMeridian ? this.highlightMeridian() : this.highlightHour();break;case "second":
					this.showMeridian ? this.highlightMeridian() : this.highlightHour();break;case "meridian":
					this.highlightHour();}
		}, highlightPrevUnit: function highlightPrevUnit() {
			switch (this.highlightedUnit) {case "hour":
					this.showMeridian ? this.highlightMeridian() : this.showSeconds ? this.highlightSecond() : this.highlightMinute();break;case "minute":
					this.highlightHour();break;case "second":
					this.highlightMinute();break;case "meridian":
					this.showSeconds ? this.highlightSecond() : this.highlightMinute();}
		}, highlightHour: function highlightHour() {
			var a = this.$element.get(0),
			    b = this;this.highlightedUnit = "hour", a.setSelectionRange && setTimeout(function () {
				b.hour < 10 ? a.setSelectionRange(0, 1) : a.setSelectionRange(0, 2);
			}, 0);
		}, highlightMinute: function highlightMinute() {
			var a = this.$element.get(0),
			    b = this;this.highlightedUnit = "minute", a.setSelectionRange && setTimeout(function () {
				b.hour < 10 ? a.setSelectionRange(2, 4) : a.setSelectionRange(3, 5);
			}, 0);
		}, highlightSecond: function highlightSecond() {
			var a = this.$element.get(0),
			    b = this;this.highlightedUnit = "second", a.setSelectionRange && setTimeout(function () {
				b.hour < 10 ? a.setSelectionRange(5, 7) : a.setSelectionRange(6, 8);
			}, 0);
		}, highlightMeridian: function highlightMeridian() {
			var a = this.$element.get(0),
			    b = this;this.highlightedUnit = "meridian", a.setSelectionRange && (this.showSeconds ? setTimeout(function () {
				b.hour < 10 ? a.setSelectionRange(8, 10) : a.setSelectionRange(9, 11);
			}, 0) : setTimeout(function () {
				b.hour < 10 ? a.setSelectionRange(5, 7) : a.setSelectionRange(6, 8);
			}, 0));
		}, incrementHour: function incrementHour() {
			if (this.showMeridian) {
				if (11 === this.hour) return this.hour++, this.toggleMeridian();12 === this.hour && (this.hour = 0);
			}return this.hour === this.maxHours - 1 ? void (this.hour = 0) : void this.hour++;
		}, incrementMinute: function incrementMinute(a) {
			var b;b = a ? this.minute + a : this.minute + this.minuteStep - this.minute % this.minuteStep, b > 59 ? (this.incrementHour(), this.minute = b - 60) : this.minute = b;
		}, incrementSecond: function incrementSecond() {
			var a = this.second + this.secondStep - this.second % this.secondStep;a > 59 ? (this.incrementMinute(!0), this.second = a - 60) : this.second = a;
		}, mousewheel: function mousewheel(b) {
			if (!this.disableMousewheel) {
				b.preventDefault(), b.stopPropagation();var c = b.originalEvent.wheelDelta || -b.originalEvent.detail,
				    d = null;switch ("mousewheel" === b.type ? d = -1 * b.originalEvent.wheelDelta : "DOMMouseScroll" === b.type && (d = 40 * b.originalEvent.detail), d && (b.preventDefault(), a(this).scrollTop(d + a(this).scrollTop())), this.highlightedUnit) {case "minute":
						c > 0 ? this.incrementMinute() : this.decrementMinute(), this.highlightMinute();break;case "second":
						c > 0 ? this.incrementSecond() : this.decrementSecond(), this.highlightSecond();break;case "meridian":
						this.toggleMeridian(), this.highlightMeridian();break;default:
						c > 0 ? this.incrementHour() : this.decrementHour(), this.highlightHour();}return !1;
			}
		}, changeToNearestStep: function changeToNearestStep(a, b) {
			return a % b === 0 ? a : Math.round(a % b / b) ? (a + (b - a % b)) % 60 : a - a % b;
		}, place: function place() {
			if (!this.isInline) {
				var c = this.$widget.outerWidth(),
				    d = this.$widget.outerHeight(),
				    e = 10,
				    f = a(b).width(),
				    g = a(b).height(),
				    h = a(b).scrollTop(),
				    i = parseInt(this.$element.parents().filter(function () {
					return "auto" !== a(this).css("z-index");
				}).first().css("z-index"), 10) + 10,
				    j = this.component ? this.component.parent().offset() : this.$element.offset(),
				    k = this.component ? this.component.outerHeight(!0) : this.$element.outerHeight(!1),
				    l = this.component ? this.component.outerWidth(!0) : this.$element.outerWidth(!1),
				    m = j.left,
				    n = j.top;this.$widget.removeClass("timepicker-orient-top timepicker-orient-bottom timepicker-orient-right timepicker-orient-left"), "auto" !== this.orientation.x ? (this.$widget.addClass("timepicker-orient-" + this.orientation.x), "right" === this.orientation.x && (m -= c - l)) : (this.$widget.addClass("timepicker-orient-left"), j.left < 0 ? m -= j.left - e : j.left + c > f && (m = f - c - e));var o,
				    p,
				    q = this.orientation.y;"auto" === q && (o = -h + j.top - d, p = h + g - (j.top + k + d), q = Math.max(o, p) === p ? "top" : "bottom"), this.$widget.addClass("timepicker-orient-" + q), "top" === q ? n += k : n -= d + parseInt(this.$widget.css("padding-top"), 10), this.$widget.css({ top: n, left: m, zIndex: i });
			}
		}, remove: function remove() {
			a("document").off(".timepicker"), this.$widget && this.$widget.remove(), delete this.$element.data().timepicker;
		}, setDefaultTime: function setDefaultTime(a) {
			if (this.$element.val()) this.updateFromElementVal();else if ("current" === a) {
				var b = new Date(),
				    c = b.getHours(),
				    d = b.getMinutes(),
				    e = b.getSeconds(),
				    f = "AM";0 !== e && (e = Math.ceil(b.getSeconds() / this.secondStep) * this.secondStep, 60 === e && (d += 1, e = 0)), 0 !== d && (d = Math.ceil(b.getMinutes() / this.minuteStep) * this.minuteStep, 60 === d && (c += 1, d = 0)), this.showMeridian && (0 === c ? c = 12 : c >= 12 ? (c > 12 && (c -= 12), f = "PM") : f = "AM"), this.hour = c, this.minute = d, this.second = e, this.meridian = f, this.update();
			} else a === !1 ? (this.hour = 0, this.minute = 0, this.second = 0, this.meridian = "AM") : this.setTime(a);
		}, setTime: function setTime(a, b) {
			if (!a) return void this.clear();var c, d, e, f, g, h;if ("object" == (typeof a === 'undefined' ? 'undefined' : _typeof(a)) && a.getMonth) e = a.getHours(), f = a.getMinutes(), g = a.getSeconds(), this.showMeridian && (h = "AM", e > 12 && (h = "PM", e %= 12), 12 === e && (h = "PM"));else {
				if (c = (/a/i.test(a) ? 1 : 0) + (/p/i.test(a) ? 2 : 0), c > 2) return void this.clear();if (d = a.replace(/[^0-9\:]/g, "").split(":"), e = d[0] ? d[0].toString() : d.toString(), this.explicitMode && e.length > 2 && e.length % 2 !== 0) return void this.clear();f = d[1] ? d[1].toString() : "", g = d[2] ? d[2].toString() : "", e.length > 4 && (g = e.slice(-2), e = e.slice(0, -2)), e.length > 2 && (f = e.slice(-2), e = e.slice(0, -2)), f.length > 2 && (g = f.slice(-2), f = f.slice(0, -2)), e = parseInt(e, 10), f = parseInt(f, 10), g = parseInt(g, 10), isNaN(e) && (e = 0), isNaN(f) && (f = 0), isNaN(g) && (g = 0), g > 59 && (g = 59), f > 59 && (f = 59), e >= this.maxHours && (e = this.maxHours - 1), this.showMeridian ? (e > 12 && (c = 2, e -= 12), c || (c = 1), 0 === e && (e = 12), h = 1 === c ? "AM" : "PM") : 12 > e && 2 === c ? e += 12 : e >= this.maxHours ? e = this.maxHours - 1 : (0 > e || 12 === e && 1 === c) && (e = 0);
			}this.hour = e, this.snapToStep ? (this.minute = this.changeToNearestStep(f, this.minuteStep), this.second = this.changeToNearestStep(g, this.secondStep)) : (this.minute = f, this.second = g), this.meridian = h, this.update(b);
		}, showWidget: function showWidget() {
			this.isOpen || this.$element.is(":disabled") || (this.$widget.appendTo(this.appendWidgetTo), a(c).on("mousedown.timepicker, touchend.timepicker", { scope: this }, this.handleDocumentClick), this.$element.trigger({ type: "show.timepicker", time: { value: this.getTime(), hours: this.hour, minutes: this.minute, seconds: this.second, meridian: this.meridian } }), this.place(), this.disableFocus && this.$element.blur(), "" === this.hour && (this.defaultTime ? this.setDefaultTime(this.defaultTime) : this.setTime("0:0:0")), "modal" === this.template && this.$widget.modal ? this.$widget.modal("show").on("hidden", a.proxy(this.hideWidget, this)) : this.isOpen === !1 && this.$widget.addClass("open"), this.isOpen = !0);
		}, toggleMeridian: function toggleMeridian() {
			this.meridian = "AM" === this.meridian ? "PM" : "AM";
		}, update: function update(a) {
			this.updateElement(), a || this.updateWidget(), this.$element.trigger({ type: "changeTime.timepicker", time: { value: this.getTime(), hours: this.hour, minutes: this.minute, seconds: this.second, meridian: this.meridian } });
		}, updateElement: function updateElement() {
			this.$element.val(this.getTime()).change();
		}, updateFromElementVal: function updateFromElementVal() {
			this.setTime(this.$element.val());
		}, updateWidget: function updateWidget() {
			if (this.$widget !== !1) {
				var a = this.hour,
				    b = 1 === this.minute.toString().length ? "0" + this.minute : this.minute,
				    c = 1 === this.second.toString().length ? "0" + this.second : this.second;this.showInputs ? (this.$widget.find("input.bootstrap-timepicker-hour").val(a), this.$widget.find("input.bootstrap-timepicker-minute").val(b), this.showSeconds && this.$widget.find("input.bootstrap-timepicker-second").val(c), this.showMeridian && this.$widget.find("input.bootstrap-timepicker-meridian").val(this.meridian)) : (this.$widget.find("span.bootstrap-timepicker-hour").text(a), this.$widget.find("span.bootstrap-timepicker-minute").text(b), this.showSeconds && this.$widget.find("span.bootstrap-timepicker-second").text(c), this.showMeridian && this.$widget.find("span.bootstrap-timepicker-meridian").text(this.meridian));
			}
		}, updateFromWidgetInputs: function updateFromWidgetInputs() {
			if (this.$widget !== !1) {
				var a = this.$widget.find("input.bootstrap-timepicker-hour").val() + ":" + this.$widget.find("input.bootstrap-timepicker-minute").val() + (this.showSeconds ? ":" + this.$widget.find("input.bootstrap-timepicker-second").val() : "") + (this.showMeridian ? this.$widget.find("input.bootstrap-timepicker-meridian").val() : "");this.setTime(a, !0);
			}
		}, widgetClick: function widgetClick(b) {
			b.stopPropagation(), b.preventDefault();var c = a(b.target),
			    d = c.closest("a").data("action");d && this[d](), this.update(), c.is("input") && c.get(0).setSelectionRange(0, 2);
		}, widgetKeydown: function widgetKeydown(b) {
			var c = a(b.target),
			    d = c.attr("class").replace("bootstrap-timepicker-", "");switch (b.which) {case 9:
					if (b.shiftKey) {
						if ("hour" === d) return this.hideWidget();
					} else if (this.showMeridian && "meridian" === d || this.showSeconds && "second" === d || !this.showMeridian && !this.showSeconds && "minute" === d) return this.hideWidget();break;case 27:
					this.hideWidget();break;case 38:
					switch (b.preventDefault(), d) {case "hour":
							this.incrementHour();break;case "minute":
							this.incrementMinute();break;case "second":
							this.incrementSecond();break;case "meridian":
							this.toggleMeridian();}this.setTime(this.getTime()), c.get(0).setSelectionRange(0, 2);break;case 40:
					switch (b.preventDefault(), d) {case "hour":
							this.decrementHour();break;case "minute":
							this.decrementMinute();break;case "second":
							this.decrementSecond();break;case "meridian":
							this.toggleMeridian();}this.setTime(this.getTime()), c.get(0).setSelectionRange(0, 2);}
		}, widgetKeyup: function widgetKeyup(a) {
			(65 === a.which || 77 === a.which || 80 === a.which || 46 === a.which || 8 === a.which || a.which >= 48 && a.which <= 57 || a.which >= 96 && a.which <= 105) && this.updateFromWidgetInputs();
		} }, a.fn.timepicker = function (b) {
		var c = Array.apply(null, arguments);return c.shift(), this.each(function () {
			var e = a(this),
			    f = e.data("timepicker"),
			    g = "object" == (typeof b === 'undefined' ? 'undefined' : _typeof(b)) && b;f || e.data("timepicker", f = new d(this, a.extend({}, a.fn.timepicker.defaults, g, a(this).data()))), "string" == typeof b && f[b].apply(f, c);
		});
	}, a.fn.timepicker.defaults = { defaultTime: "current", disableFocus: !1, disableMousewheel: !1, isOpen: !1, minuteStep: 15, modalBackdrop: !1, orientation: { x: "auto", y: "auto" }, secondStep: 15, snapToStep: !1, showSeconds: !1, showInputs: !0, showMeridian: !0, template: "dropdown", appendWidgetTo: "body", showWidgetOnAddonClick: !0, icons: { up: "glyphicon glyphicon-chevron-up", down: "glyphicon glyphicon-chevron-down" }, maxHours: 24, explicitMode: !1 }, a.fn.timepicker.Constructor = d, a(c).on("focus.timepicker.data-api click.timepicker.data-api", '[data-provide="timepicker"]', function (b) {
		var c = a(this);c.data("timepicker") || (b.preventDefault(), c.timepicker());
	});
}(jQuery, window, document);
// Unite Gallery, Version: 1.7.45, released 27 Feb 2017 

function debugLine(e, t, i) {
	e === !0 && (e = "true"), e === !1 && (e = "false");var n = e;if ("object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e))) {
		n = "";for (name in e) {
			var r = e[name];n += " " + name + ": " + r;
		}
	}if (1 != t || i || (n += " " + Math.random()), 1 == i) {
		var o = jQuery("#debug_line");o.width(200), o.height() >= 500 && o.html("");var a = o.html();n = a + "<br> -------------- <br>" + n;
	}jQuery("#debug_line").show().html(n);
}function debugSide(e) {
	var t = "";for (name in e) {
		var i = e[name];t += name + " : " + i + "<br>";
	}jQuery("#debug_side").show().html(t);
}function trace(e) {
	"undefined" != typeof console && console.log(e);
}function UGFunctions() {
	function e(e, t, i) {
		t.addEventListener ? t.addEventListener(e, i, !1) : t.attachEvent ? t.attachEvent("on" + e, i) : t[e] = i;
	}var t = null,
	    i = this,
	    n = { starTime: 0, arrThemes: [], isTouchDevice: -1, isRgbaSupported: -1, timeCache: {}, dataCache: {}, lastEventType: "", lastEventTime: 0, lastTouchStartElement: null, touchThreshold: 700, handle: null };this.debugVar = "", this.z__________FULL_SCREEN___________ = function () {}, this.toFullscreen = function (e, t) {
		if (e.requestFullscreen) e.requestFullscreen();else if (e.mozRequestFullScreen) e.mozRequestFullScreen();else if (e.webkitRequestFullscreen) e.webkitRequestFullscreen();else {
			if (!e.msRequestFullscreen) return !1;e.msRequestFullscreen();
		}return !0;
	}, this.exitFullscreen = function () {
		if (0 == i.isFullScreen()) return !1;if (document.exitFullscreen) document.exitFullscreen();else if (document.cancelFullScreen) document.cancelFullScreen();else if (document.mozCancelFullScreen) document.mozCancelFullScreen();else if (document.webkitExitFullscreen) document.webkitExitFullscreen();else {
			if (!document.msExitFullscreen) return !1;document.msExitFullscreen();
		}return !0;
	}, this.addFullScreenChangeEvent = function (t) {
		document.webkitCancelFullScreen ? e("webkitfullscreenchange", document, t) : document.msExitFullscreen ? e("MSFullscreenChange", document, t) : document.mozCancelFullScreen ? e("mozfullscreenchange", document, t) : e("fullscreenchange", document, t);
	}, this.destroyFullScreenChangeEvent = function () {
		jQuery(document).unbind("fullscreenChange"), jQuery(document).unbind("mozfullscreenchange"), jQuery(document).unbind("webkitfullscreenchange"), jQuery(document).unbind("MSFullscreenChange");
	}, this.getFullScreenElement = function () {
		var e = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;return e;
	}, this.isFullScreen = function () {
		var e = document.fullscreen || document.mozFullScreen || document.webkitIsFullScreen || document.msFullscreenElement;return e = e ? !0 : !1;
	}, this.z__________GET_PROPS___________ = function () {}, this.getBrowserPrefix = function () {
		if (null !== t) return t;var e = ["webkit", "Moz", "ms", "O"],
		    i = document.createElement("div");for (var n in e) {
			var r = e[n];if (r + "Transform" in i.style) return r = r.toLowerCase(), t = r, r;
		}return t = "", "";
	}, this.getImageInsideParentDataByImage = function (e, t, n) {
		var r = e.parent(),
		    o = i.getImageOriginalSize(e),
		    a = i.getImageInsideParentData(r, o.width, o.height, t, n);return a;
	}, this.getImageInsideParentData = function (e, t, i, n, r, o, a) {
		if (!r) var r = {};var s = {};if ("undefined" == typeof o) var o = e.width();if ("undefined" == typeof a) var a = e.height();r.padding_left && (o -= r.padding_left), r.padding_right && (o -= r.padding_right), r.padding_top && (a -= r.padding_top), r.padding_bottom && (a -= r.padding_bottom);var l = null,
		    u = "100%",
		    d = null,
		    _ = null,
		    g = "display:block;margin:0px auto;";if (t > 0 && i > 0) {
			if ("down" == n && o > t && a > i) u = i, l = t, _ = (o - l) / 2, d = (a - u) / 2;else if ("fill" == n) {
				var c = t / i;u = a, l = u * c, o > l ? (l = o, u = l / c, _ = 0, d = Math.round((u - a) / 2 * -1)) : (d = 0, _ = Math.round((l - o) / 2 * -1));
			} else {
				var c = t / i;u = a, l = u * c, d = 0, _ = (o - l) / 2, "fitvert" != n && l > o && (l = o, u = l / c, _ = 0, d = (a - u) / 2);
			}l = Math.floor(l), u = Math.floor(u), d = Math.floor(d), _ = Math.floor(_), g = "position:absolute;";
		}return r.padding_top && (d += r.padding_top), r.padding_left && (_ += r.padding_left), s.imageWidth = l, s.imageHeight = u, s.imageTop = d, s.imageLeft = _, s.imageRight = _ + l, 0 == d || "100%" == u ? s.imageBottom = null : s.imageBottom = d + u, s.style = g, s;
	}, this.getElementCenterPosition = function (e, t) {
		var n = e.parent(),
		    r = i.getElementSize(e),
		    o = i.getElementSize(n),
		    a = o.width,
		    s = o.height;t && void 0 !== t.padding_top && (s -= t.padding_top), t && void 0 !== t.padding_bottom && (s -= t.padding_bottom), t && void 0 !== t.padding_left && (a -= t.padding_left), t && void 0 !== t.padding_right && (a -= t.padding_right);var l = {};return l.left = Math.round((a - r.width) / 2), l.top = Math.round((s - r.height) / 2), t && void 0 !== t.padding_top && (l.top += t.padding_top), t && void 0 !== t.padding_left && (l.left += t.padding_left), l;
	}, this.getElementCenterPoint = function (e, t) {
		if (!t) var t = !1;var n = i.getElementSize(e),
		    r = {};return r.x = n.width / 2, r.y = n.height / 2, 1 == t && (r.x += n.left, r.y += n.top), r.x = Math.round(r.x), r.y = Math.round(r.y), r;
	}, this.getMousePosition = function (e, t) {
		var i = { pageX: e.pageX, pageY: e.pageY, clientX: e.clientX, clientY: e.clientY };if (e.originalEvent && e.originalEvent.touches && e.originalEvent.touches.length > 0 && (i.pageX = e.originalEvent.touches[0].pageX, i.pageY = e.originalEvent.touches[0].pageY, i.clientX = e.originalEvent.touches[0].clientX, i.clientY = e.originalEvent.touches[0].clientY), t) {
			var n = t.offset();i.mouseX = i.pageX - n.left, i.mouseY = i.pageY - n.top;
		}return i;
	}, this.getMouseElementPoint = function (e, t) {
		var n = { x: e.pageX, y: e.pageY },
		    r = i.getElementLocalPoint(n, t);return r;
	}, this.getElementLocalPoint = function (e, t) {
		var i = {},
		    n = t.offset();return i.x = Math.round(e.x - n.left), i.y = Math.round(e.y - n.top), i;
	}, this.getImageOriginalSize = function (e, t, i) {
		if ("undefined" != typeof t && "undefined" != typeof i) return { width: t, height: i };var n = e[0];if ("undefined" == typeof n) throw new Error("getImageOriginalSize error - Image not found");var r = {};if ("undefined" == typeof n.naturalWidth) {
			if ("number" == typeof e.data("naturalWidth")) {
				var r = {};return r.width = e.data("naturalWidth"), r.height = e.data("naturalHeight"), r;
			}var o = new Image();return o.src = n.src, o.complete ? (r.width = o.width, r.height = o.height, e.data("naturalWidth", r.width), e.data("naturalHeight", r.height), r) : { width: 0, height: 0 };
		}return r.width = n.naturalWidth, r.height = n.naturalHeight, r;
	}, this.getimageRatio = function (e) {
		var t = i.getImageOriginalSize(e),
		    n = i.getElementSize(e),
		    r = n.width / t.width;return r;
	}, this.isImageFitParent = function (e) {
		var t = e.parent(),
		    n = i.getElementSize(e),
		    r = i.getElementSize(t);return n.width <= r.width && n.height <= r.height ? !0 : !1;
	}, this.getElementSize = function (e) {
		if (void 0 === e) throw new Error("Can't get size, empty element");var t = e.position();return t.height = e.outerHeight(), t.width = e.outerWidth(), t.left = Math.round(t.left), t.top = Math.round(t.top), t.right = t.left + t.width, t.bottom = t.top + t.height, t;
	}, this.isElementBiggerThenParent = function (e) {
		var t = e.parent(),
		    n = i.getElementSize(e),
		    r = i.getElementSize(t);return n.width > r.width || n.height > r.height ? !0 : !1;
	}, this.isPointInsideElement = function (e, t) {
		var i = e.x >= 0 && e.x < t.width;if (0 == i) return !1;var n = e.y >= 0 && e.y < t.height;return 0 == n ? !1 : !0;
	}, this.getElementRelativePos = function (e, t, n, r) {
		if (!r) var r = e.parent();if ("number" == typeof e) var o = { width: e, height: e };else var o = i.getElementSize(e);var a = i.getElementSize(r);switch (t) {case "top":case "left":
				t = 0, n && (t += n);break;case "center":
				t = Math.round((a.width - o.width) / 2), n && (t += n);break;case "right":
				t = a.width - o.width, n && (t -= n);break;case "middle":
				t = Math.round((a.height - o.height) / 2), n && (t += n);break;case "bottom":
				t = a.height - o.height, n && (t -= n);}return t;
	}, this.z_________SET_ELEMENT_PROPS_______ = function () {}, this.zoomImageInsideParent = function (e, t, n, r, o, a, s) {
		if (!n) var n = 1.2;if (!o) var o = "fit";var l,
		    u,
		    d,
		    _,
		    g = n,
		    c = e.parent(),
		    h = i.getElementSize(e),
		    p = i.getImageOriginalSize(e),
		    f = !1,
		    m = 0,
		    v = 0,
		    b = 0,
		    y = 0;if (r) {
			var I = i.getMouseElementPoint(r, e);f = i.isPointInsideElement(I, h), b = I.x, y = I.y;
		} else f = !1;if (0 == f) {
			var w = i.getElementCenterPoint(e);b = w.x, y = w.y;
		}if (1 == t) l = h.height * g, u = h.width * g, 0 != b && (m = -(b * g - b)), 0 != y && (v = -(y * g - y));else {
			l = h.height / g, u = h.width / g;var E = i.getImageInsideParentData(c, p.width, p.height, o, s);if (u < E.imageWidth) return i.scaleImageFitParent(e, p.width, p.height, o, s), !0;1 == f && (0 != b && (m = -(b / g - b)), 0 != y && (v = -(y / g - y)));
		}if (a) {
			var T = 1;if (0 != p.width && (T = u / p.width), T > a) return !1;
		}if (i.setElementSize(e, u, l), 0 == t && 0 == f) {
			var S = i.getElementCenterPosition(e);d = S.left, _ = S.top;
		} else d = h.left + m, _ = h.top + v;return i.placeElement(e, d, _), !0;
	}, this.placeElement = function (e, t, n, r, o, a) {
		if (0 == jQuery.isNumeric(t) || 0 == jQuery.isNumeric(n)) {
			if (!a) var a = e.parent();var s = i.getElementSize(e),
			    l = i.getElementSize(a);
		}if (0 == jQuery.isNumeric(t)) switch (t) {case "left":
				t = 0, r && (t += r);break;case "center":
				t = Math.round((l.width - s.width) / 2), r && (t += r);break;case "right":
				t = l.width - s.width, r && (t -= r);}if (0 == jQuery.isNumeric(n)) switch (n) {case "top":
				n = 0, o && (n += o);break;case "middle":case "center":
				n = Math.round((l.height - s.height) / 2), o && (n += o);break;case "bottom":
				n = l.height - s.height, o && (n -= o);}var u = { position: "absolute", margin: "0px" };null !== t && (u.left = t), null !== n && (u.top = n), e.css(u);
	}, this.placeElementInParentCenter = function (e) {
		i.placeElement(e, "center", "middle");
	}, this.setElementSizeAndPosition = function (e, t, i, n, r) {
		var o = { width: n + "px", height: r + "px", left: t + "px", top: i + "px", position: "absolute", margin: "0px" };e.css(o);
	}, this.setElementSize = function (e, t, i) {
		var n = { width: t + "px" };null !== i && "undefined" != typeof i && (n.height = i + "px"), e.css(n);
	}, this.cloneElementSizeAndPos = function (e, t, n, r, o) {
		var a = e.position();if (void 0 == a) throw new Error("Can't get size, empty element");n === !0 ? (a.height = e.outerHeight(), a.width = e.outerWidth()) : (a.height = e.height(), a.width = e.width()), a.left = Math.round(a.left), a.top = Math.round(a.top), r && (a.left += r), o && (a.top += o), i.setElementSizeAndPosition(t, a.left, a.top, a.width, a.height);
	}, this.placeImageInsideParent = function (e, t, n, r, o, a) {
		var s = i.getImageInsideParentData(t, n, r, o, a),
		    l = "<img";null !== s.imageWidth && (l += " width = '" + s.imageWidth + "'", s.style += "width:" + s.imageWidth + ";"), null != s.imageHeight && ("100%" == s.imageHeight ? (l += " height = '" + s.imageHeight + "'", s.style += "height:" + s.imageHeight + ";") : (l += " height = '" + s.imageHeight + "'", s.style += "height:" + s.imageHeight + "px;")), null !== s.imageTop && (s.style += "top:" + s.imageTop + "px;"), null !== s.imageLeft && (s.style += "left:" + s.imageLeft + "px;"), e = i.escapeDoubleSlash(e), l += " style='" + s.style + "'", l += ' src="' + e + '"', l += ">", t.html(l);var u = t.children("img");return u;
	}, this.scaleImageCoverParent = function (e, t, n) {
		if ("number" == typeof t) var r = t,
		    o = n;else var r = t.outerWidth(),
		    o = t.outerHeight();var a = i.getImageOriginalSize(e),
		    s = a.width,
		    l = a.height,
		    u = s / l,
		    d = o,
		    _ = d * u,
		    g = 0,
		    c = 0;r > _ ? (_ = r, d = _ / u, c = 0, g = Math.round((d - o) / 2 * -1)) : (g = 0, c = Math.round((_ - r) / 2 * -1)), _ = Math.round(_), d = Math.round(d), e.css({ width: _ + "px", height: d + "px", left: c + "px", top: g + "px" });
	}, this.scaleImageFitParent = function (e, t, n, r, o) {
		var a = e.parent(),
		    s = i.getImageInsideParentData(a, t, n, r, o),
		    l = !1,
		    u = {};return null !== s.imageWidth && (l = !0, e.removeAttr("width"), u.width = s.imageWidth + "px"), null != s.imageHeight && (l = !0, e.removeAttr("height"), u.height = s.imageHeight + "px"), null !== s.imageTop && (l = !0, u.top = s.imageTop + "px"), null !== s.imageLeft && (l = !0, u.left = s.imageLeft + "px"), 1 == l && (u.position = "absolute", u.margin = "0px 0px", e.css(u)), s;
	}, this.scaleImageByHeight = function (e, t, n, r) {
		var o = i.getImageOriginalSize(e, n, r),
		    a = o.width / o.height,
		    s = Math.round(t * a);t = Math.round(t), i.setElementSize(e, s, t);
	}, this.scaleImageByWidth = function (e, t, n, r) {
		var o = i.getImageOriginalSize(e, n, r),
		    a = o.width / o.height,
		    s = Math.round(t / a);t = Math.round(t), i.setElementSize(e, t, s);
	}, this.scaleImageExactSizeInParent = function (e, t, n, r, o, a) {
		var s = e.parent(),
		    l = i.getElementSize(s);l.width < r && (r = l.width), l.height < o && (o = l.height);var u = i.getImageInsideParentData(null, t, n, a, null, r, o),
		    d = r,
		    _ = o,
		    g = u.imageLeft,
		    c = u.imageLeft,
		    h = u.imageTop,
		    p = u.imageTop,
		    f = Math.round((l.width - r) / 2),
		    m = Math.round((l.height - o) / 2),
		    v = u.imageWidth + g + c,
		    b = r - v;0 != b && (c += b);var y = u.imageHeight + h + p,
		    b = o - y;0 != b && (p += b), e.removeAttr("width"), e.removeAttr("height");var I = { position: "absolute", margin: "0px 0px" };I.width = d + "px", I.height = _ + "px", I.left = f + "px", I.top = m + "px", I["padding-left"] = g + "px", I["padding-top"] = h + "px", I["padding-right"] = c + "px", I["padding-bottom"] = p + "px", e.css(I);var w = {};return w.imageWidth = d, w.imageHeight = _, w;
	}, this.showElement = function (e, t, i) {
		e.show().fadeTo(0, 1), t && t.show().fadeTo(0, 1), i && i.show().fadeTo(0, 1);
	}, this.z_________GALLERY_RELATED_FUNCTIONS_______ = function () {}, this.disableButton = function (e, t) {
		if (!t) var t = "ug-button-disabled";0 == i.isButtonDisabled(e, t) && e.addClass(t);
	}, this.convertCustomPrefixOptions = function (e, t, i) {
		if (!t) return e;var n = {};return jQuery.each(e, function (e, r) {
			if (0 === e.indexOf(t + "_" + i + "_")) {
				var o = e.replace(t + "_" + i + "_", i + "_");n[o] = r;
			} else n[e] = r;
		}), n;
	}, this.enableButton = function (e, t) {
		if (!t) var t = "ug-button-disabled";1 == i.isButtonDisabled(e, t) && e.removeClass(t);
	}, this.isButtonDisabled = function (e, t) {
		if (!t) var t = "ug-button-disabled";return e.hasClass(t) ? !0 : !1;
	}, this.z_________MATH_FUNCTIONS_______ = function () {}, this.normalizeSetting = function (e, t, i, n, r, o) {
		if (!o) var o = !1;var a = (r - i) / (n - i);return r = e + (t - e) * a, 1 == o && (e > r && (r = e), r > t && (r = t)), r;
	}, this.getNormalizedValue = function (e, t, i, n, r) {
		var o = (r - e) / (t - e);return r = e + (n - i) * o;
	}, this.getDistance = function (e, t, i, n) {
		var r = Math.round(Math.sqrt(Math.abs((i - e) * (i - e) + (n - t) * (n - t))));return r;
	}, this.getMiddlePoint = function (e, t, i, n) {
		var r = {};return r.x = e + Math.round((i - e) / 2), r.y = t + Math.round((n - t) / 2), r;
	}, this.getNumItemsInSpace = function (e, t, i) {
		var n = Math.floor((e + i) / (t + i));return n;
	}, this.getNumItemsInSpaceRound = function (e, t, i) {
		var n = Math.round((e + i) / (t + i));return n;
	}, this.getSpaceByNumItems = function (e, t, i) {
		var n = e * t + (e - 1) * i;return n;
	}, this.getItemSizeInSpace = function (e, t, i) {
		var n = Math.floor((e - (t - 1) * i) / t);return n;
	}, this.getColX = function (e, t, i) {
		var n = e * (t + i);return n;
	}, this.getColByIndex = function (e, t) {
		var i = t % e;return i;
	}, this.getColRowByIndex = function (e, t) {
		var i = Math.floor(e / t),
		    n = Math.floor(e % t);return { col: n, row: i };
	}, this.getIndexByRowCol = function (e, t, i) {
		if (0 > e) return -1;if (0 > t) return -1;var n = e * i + t;return n;
	}, this.getPrevRowSameColIndex = function (e, t) {
		var n = i.getColRowByIndex(e, t),
		    r = i.getIndexByRowCol(n.row - 1, n.col, t);return r;
	}, this.getNextRowSameColIndex = function (e, t) {
		var n = i.getColRowByIndex(e, t),
		    r = i.getIndexByRowCol(n.row + 1, n.col, t);return r;
	}, this.z_________DATA_FUNCTIONS_______ = function () {}, this.setGlobalData = function (e, t) {
		jQuery.data(document.body, e, t);
	}, this.getGlobalData = function (e) {
		var t = jQuery.data(document.body, e);return t;
	}, this.z_________EVENT_DATA_FUNCTIONS_______ = function () {}, this.handleScrollTop = function (e) {
		if (0 == i.isTouchDevice()) return null;var t = i.getStoredEventData(e),
		    r = 15,
		    o = 15;if (null === t.scrollDir && (Math.abs(t.diffMouseX) > r ? t.scrollDir = "hor" : Math.abs(t.diffMouseY) > o && Math.abs(t.diffMouseY) > Math.abs(t.diffMouseX) && (t.scrollDir = "vert", t.scrollStartY = t.lastMouseClientY, t.scrollOrigin = jQuery(document).scrollTop(), n.dataCache[e].scrollStartY = t.lastMouseClientY, n.dataCache[e].scrollOrigin = t.scrollOrigin), n.dataCache[e].scrollDir = t.scrollDir), "vert" !== t.scrollDir) return t.scrollDir;var a = (jQuery(document).scrollTop(), t.scrollOrigin - (t.lastMouseClientY - t.scrollStartY));return a >= 0 && jQuery(document).scrollTop(a), t.scrollDir;
	}, this.wasVerticalScroll = function (e) {
		var t = i.getStoredEventData(e);return "vert" === t.scrollDir ? !0 : !1;
	}, this.storeEventData = function (e, t, r) {
		var o = i.getMousePosition(e),
		    a = jQuery.now(),
		    s = { startTime: a, lastTime: a, startMouseX: o.pageX, startMouseY: o.pageY, lastMouseX: o.pageX, lastMouseY: o.pageY, startMouseClientY: o.clientY, lastMouseClientY: o.clientY, scrollTop: jQuery(document).scrollTop(), scrollDir: null };r && (s = jQuery.extend(s, r)), n.dataCache[t] = s;
	}, this.updateStoredEventData = function (e, t, r) {
		if (!n.dataCache[t]) throw new Error("updateEventData error: must have stored cache object");var o = n.dataCache[t],
		    a = i.getMousePosition(e);o.lastTime = jQuery.now(), void 0 !== a.pageX && (o.lastMouseX = a.pageX, o.lastMouseY = a.pageY, o.lastMouseClientY = a.clientY), r && (o = jQuery.extend(o, r)), n.dataCache[t] = o;
	}, this.getStoredEventData = function (e, t) {
		if (!n.dataCache[e]) throw new Error("updateEventData error: must have stored cache object");var i = n.dataCache[e];return i.diffMouseX = i.lastMouseX - i.startMouseX, i.diffMouseY = i.lastMouseY - i.startMouseY, i.diffMouseClientY = i.lastMouseClientY - i.startMouseClientY, i.diffTime = i.lastTime - i.startTime, t === !0 ? (i.startMousePos = i.lastMouseY, i.lastMousePos = i.lastMouseY, i.diffMousePos = i.diffMouseY) : (i.startMousePos = i.lastMouseX, i.lastMousePos = i.lastMouseX, i.diffMousePos = i.diffMouseX), i;
	}, this.isApproveStoredEventClick = function (e, t) {
		if (!n.dataCache[e]) return !0;var r = i.getStoredEventData(e, t),
		    o = Math.abs(r.diffMousePos);return r.diffTime > 400 ? !1 : o > 30 ? !1 : !0;
	}, this.clearStoredEventData = function (e) {
		n.dataCache[e] = null;
	}, this.z_________CHECK_SUPPORT_FUNCTIONS_______ = function () {}, this.isCanvasExists = function () {
		var e = jQuery('<canvas width="500" height="500" > </canvas>')[0];return "function" == typeof e.getContext ? !0 : !1;
	}, this.isScrollbarExists = function () {
		var e = window.innerWidth > document.documentElement.clientWidth;return e;
	}, this.isTouchDevice = function () {
		if (-1 !== n.isTouchDevice) return n.isTouchDevice;try {
			document.createEvent("TouchEvent"), n.isTouchDevice = !0;
		} catch (e) {
			n.isTouchDevice = !1;
		}return n.isTouchDevice;
	}, this.isRgbaSupported = function () {
		if (-1 !== n.isRgbaSupported) return n.isRgbaSupported;var e = document.getElementsByTagName("script")[0],
		    t = e.style.color;try {
			e.style.color = "rgba(1,5,13,0.44)";
		} catch (i) {}var r = e.style.color != t;return e.style.color = t, n.isRgbaSupported = r, r;
	}, this.z_________GENERAL_FUNCTIONS_______ = function () {}, this.checkMinJqueryVersion = function (e) {
		for (var t = jQuery.fn.jquery.split("."), i = e.split("."), n = 0, r = t.length; r > n; n++) {
			var o = parseInt(t[n]),
			    a = parseInt(i[n]);if ("undefined" == typeof i[n]) return !0;if (a > o) return !1;if (o > a) return !0;
		}return !0;
	}, this.getCssSizeParam = function (e) {
		return jQuery.isNumeric(e) ? e + "px" : e;
	}, this.convertHexToRGB = function (e, t) {
		var i = e.replace("#", "");return i === e ? e : (r = parseInt(i.substring(0, 2), 16), g = parseInt(i.substring(2, 4), 16), b = parseInt(i.substring(4, 6), 16), result = "rgba(" + r + "," + g + "," + b + "," + t + ")", result);
	}, this.timestampToString = function (e) {
		var t = new Date(e),
		    i = t.getDate() + "/" + t.getMonth();return i += " " + t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds() + ":" + t.getMilliseconds();
	}, this.getArrTouches = function (e) {
		var t = [];return e.originalEvent && e.originalEvent.touches && e.originalEvent.touches.length > 0 && (t = e.originalEvent.touches), t;
	}, this.getArrTouchPositions = function (e) {
		for (var t = [], i = 0; i < e.length; i++) {
			var n = { pageX: e[i].pageX, pageY: e[i].pageY };t.push(n);
		}return t;
	}, this.startTimeDebug = function () {
		n.starTime = jQuery.now();
	}, this.showTimeDebug = function () {
		var e = jQuery.now(),
		    t = e - n.starTime;debugLine({ "Time Passed": t }, !0);
	}, this.initProgressIndicator = function (e, t, n) {
		switch ("bar" != e && 0 == i.isCanvasExists() && (e = "bar"), e) {case "bar":
				var r = new UGProgressBar();r.putHidden(n, t);break;default:case "pie":
				var r = new UGProgressPie();r.putHidden(n, t);break;case "pie2":
				t.type_fill = !0;var r = new UGProgressPie();r.putHidden(n, t);}return r;
	}, this.setButtonMobileReady = function (e) {
		e.on("touchstart", function (e) {
			jQuery(this).addClass("ug-nohover");
		}), e.on("mousedown touchend", function (e) {
			return e.stopPropagation(), e.stopImmediatePropagation(), !1;
		});
	}, this.registerTheme = function (e) {
		n.arrThemes.push(e);
	}, this.getArrThemes = function () {
		return n.arrThemes;
	}, this.isThemeRegistered = function (e) {
		return -1 !== jQuery.inArray(e, n.arrThemes) ? !0 : !1;
	}, this.getFirstRegisteredTheme = function () {
		if (0 == n.arrThemes.length) return "";var e = n.arrThemes[0];return e;
	}, this.isTimePassed = function (e, t) {
		if (!t) var t = 100;var i = jQuery.now();0 == n.timeCache.hasOwnProperty(e) ? lastTime = 0 : lastTime = n.timeCache[e];var r = i - lastTime;return n.timeCache[e] = i, t >= r ? !1 : !0;
	}, this.whenContiniousEventOver = function (e, t, i) {
		if (!i) var i = 300;1 == n.timeCache.hasOwnProperty(e) && null != n.timeCache[e] && (clearTimeout(n.timeCache[e]), n.timeCache[e] = null), n.timeCache[e] = setTimeout(t, i);
	}, this.validateClickTouchstartEvent = function (e) {
		var t = !0,
		    i = jQuery.now() - n.lastEventTime;return "click" == e && "touchstart" == n.lastEventType && 1e3 > i && (t = !1), n.lastEventTime = jQuery.now(), n.lastEventType = e, t;
	}, this.addClassOnHover = function (e, t) {
		if (!t) var t = "ug-button-hover";e.hover(function () {
			jQuery(this).addClass(t);
		}, function () {
			jQuery(this).removeClass(t);
		});
	}, this.destroyButton = function (e) {
		e.off("mouseenter"), e.off("mouseleave"), e.off("click"), e.off("touchstart"), e.off("touchend"), e.off("mousedown"), e.off("tap");
	}, this.setButtonOnClick = function (e, t) {
		i.setButtonMobileReady(e), e.on("click touchstart", function (e) {
			return objThis = jQuery(this), e.stopPropagation(), e.stopImmediatePropagation(), 0 == i.validateClickTouchstartEvent(e.type) ? !0 : void t(objThis, e);
		});
	}, this.setButtonOnTap = function (e, t) {
		e.on("tap", t), 0 == i.isTouchDevice() ? e.on("click", function (e) {
			var t = jQuery(this);return 0 == i.validateClickTouchstartEvent(e.type) ? !0 : void t.trigger("tap");
		}) : (e.on("touchstart", function (e) {
			var t = jQuery(this);t.addClass("ug-nohover"), n.lastTouchStartElement = jQuery(this), n.lastEventTime = jQuery.now();
		}), e.on("touchend", function (e) {
			var t = jQuery(this);if (0 == t.is(n.lastTouchStartElement)) return !0;if (!n.lastEventTime) return !0;var i = jQuery.now() - n.lastEventTime;return i > n.touchThreshold ? !0 : void t.trigger("tap");
		}));
	}, this.loadJs = function (e, t) {
		t === !0 && (e = location.protocol + "//" + e);var i = document.createElement("script");i.src = e;var n = document.getElementsByTagName("script")[0];n.parentNode.insertBefore(i, n);
	}, this.loadCss = function (e, t) {
		t === !0 && (e = location.protocol + "//" + e);var i = document.createElement("link");i.setAttribute("rel", "stylesheet"), i.setAttribute("type", "text/css"), i.setAttribute("href", e), document.getElementsByTagName("head")[0].appendChild(i);
	}, this.addEvent = function (e, t, i) {
		"undefined" != typeof e.addEventListener ? e.addEventListener(t, i, !1) : e.attachEvent && e.attachEvent("on" + t, i);
	}, this.checkImagesLoaded = function (e, t, i) {
		function n(e, n) {
			r++, "function" == typeof i && setTimeout(function () {
				i(e, n);
			}), r == o && "function" == typeof t && setTimeout(function () {
				t();
			});
		}var r = 0,
		    o = e.length;return 0 == o && t ? (t(), !1) : void setTimeout(function () {
			for (var t = 0; o > t; t++) {
				var i = e[t];if (void 0 !== i.naturalWidth && 0 !== i.naturalWidth) n(e[t], !1);else {
					var r = jQuery("<img/>");r.data("index", t), r.on("load", function () {
						var t = jQuery(this).data("index");n(e[t], !1);
					}), r.on("error", function () {
						var t = jQuery(this).data("index");n(e[t], !0);
					}), r.attr("src", i.src);
				}
			}
		});
	}, this.waitForWidth = function (e, t) {
		var i = e.width();return 0 != i ? (t(), !1) : void (n.handle = setInterval(function () {
			i = e.width(), 0 != i && (clearInterval(n.handle), t());
		}, 300));
	}, this.arrayShuffle = function (e) {
		if ("object" != (typeof e === 'undefined' ? 'undefined' : _typeof(e))) return e;for (var t, i, n = e.length; n; t = parseInt(Math.random() * n), i = e[--n], e[n] = e[t], e[t] = i) {}return e;
	}, this.getObjectLength = function (e) {
		var t = 0;for (var i in e) {
			t++;
		}return t;
	}, this.normalizePercent = function (e) {
		return 0 > e && (e = 0), e > 1 && (e = 1), e;
	}, this.stripTags = function (e) {
		var t = e.replace(/(<([^>]+)>)/gi, "");return t;
	}, this.escapeDoubleSlash = function (e) {
		return e.replace('"', '"');
	}, this.htmlentitles = function (e) {
		var t = jQuery("<div/>").text(e).html();return t;
	}, this.z_________END_GENERAL_FUNCTIONS_______ = function () {};
}function UGThumbsGeneral() {
	function e(e, t) {
		var i = w[e],
		    n = "";0 == C.customThumbs && (n = " ug-thumb-generated");var r = i.index + 1,
		    o = "style='z-index:" + r + ";'",
		    a = "<div class='ug-thumb-wrapper" + n + "' " + o + "></div>";if (1 == j.thumb_wrapper_as_link) {
			var s = i.link;"" == i.link && (s = "javascript:void(0)");var l = "";1 == j.thumb_link_newpage && i.link && (l = " target='_blank'");var a = "<a href='" + s + "'" + l + " class='ug-thumb-wrapper" + n + "'></a>";
		}var u = jQuery(a),
		    d = i.objThumbImage;if (0 == C.customThumbs) {
			if (1 == j.thumb_show_loader && d) {
				var _ = "ug-thumb-loader-dark";"bright" == j.thumb_loader_type && (_ = "ug-thumb-loader-bright"), u.append("<div class='ug-thumb-loader " + _ + "'></div>"), u.append("<div class='ug-thumb-error' style='display:none'></div>");
			}if (d) {
				if (d.addClass("ug-thumb-image"), 1 == j.thumb_image_overlay_effect) {
					var g = d.clone().appendTo(u);g.addClass("ug-thumb-image-overlay " + t).removeClass("ug-thumb-image"), g.fadeTo(0, 0), i.objImageOverlay = g;
				}u.append(d);
			}
		}return C.isEffectBorder && u.append("<div class='ug-thumb-border-overlay'></div>"), C.isEffectOverlay && u.append("<div class='ug-thumb-overlay'></div>"), E.append(u), C.customThumbs && C.funcSetCustomThumbHtml(u, i), w[e].objThumbWrapper = u, u;
	}function t(e, t, i, n) {
		var r = { width: e + "px", height: t + "px" },
		    o = { width: e - C.thumbInnerReduce + "px", height: t - C.thumbInnerReduce + "px" },
		    a = ".ug-thumb-loader, .ug-thumb-error, .ug-thumb-border-overlay, .ug-thumb-overlay";i ? (n !== !0 && i.css(r), i.find(a).css(o)) : (E.children(".ug-thumb-wrapper").css(r), E.find(a).css(o));
	}function i(e, t, i, n) {
		if (!n) var n = !1;P.isFakeFullscreen() && (n = !0);var r = e.children(".ug-thumb-border-overlay"),
		    o = {};o["border-width"] = t + "px", 0 != t && (o["border-color"] = i), n && n === !0 ? (r.css(o), 0 == t ? r.hide() : r.show()) : (0 == t ? r.stop().fadeOut(j.thumb_transition_duration) : r.show().stop().fadeIn(j.thumb_transition_duration), l(r, o));
	}function n(e, t, i) {
		var n = e.children(".ug-thumb-overlay"),
		    r = j.thumb_transition_duration;i && i === !0 && (r = 0), t ? n.stop(!0).fadeTo(r, C.colorOverlayOpacity) : n.stop(!0).fadeTo(r, 0);
	}function r(e, t, i) {
		var n = e.children("img.ug-thumb-image"),
		    r = e.children("img.ug-thumb-image-overlay"),
		    o = j.thumb_transition_duration;i && i === !0 && (o = 0), t ? r.stop(!0).fadeTo(o, 1) : (n.fadeTo(0, 1), r.stop(!0).fadeTo(o, 0));
	}function o(e, t) {
		if (C.isEffectBorder && i(e, j.thumb_selected_border_width, j.thumb_selected_border_color, t), C.isEffectOverlay) {
			var o = 1 == j.thumb_overlay_reverse ? !0 : !1;n(e, o, t);
		}C.isEffectImage && r(e, !1, t), S.trigger(T.events.SETSELECTEDSTYLE, e);
	}function a(e) {
		var t = T.getItemByThumb(e);return t.isLoaded = !0, t.isThumbImageLoaded = !1, 1 == C.customThumbs ? (S.trigger(T.events.IMAGELOADERROR, e), !0) : (e.children(".ug-thumb-loader").hide(), void e.children(".ug-thumb-error").show());
	}function s(e) {
		if (j.thumb_round_corners_radius <= 0) return !1;var t = { "border-radius": j.thumb_round_corners_radius + "px" };e ? (e.css(t), e.find(".ug-thumb-border-overlay").css(t)) : E.find(".ug-thumb-wrapper, .ug-thumb-wrapper .ug-thumb-border-overlay").css(t);
	}function l(e, t) {
		e.stop(!0).animate(t, { duration: j.thumb_transition_duration, easing: j.thumb_transition_easing, queue: !1 });
	}function u(e) {
		1 == c(e) ? o(e, !0, "redraw") : T.setThumbNormalStyle(e, !0, "redraw");
	}function d(e, i, n) {
		if (1 == j.thumb_fixed_size) x.scaleImageCoverParent(i, e);else {
			"height" == j.thumb_resize_by ? x.scaleImageByHeight(i, j.thumb_height) : x.scaleImageByWidth(i, j.thumb_width);var r = x.getElementSize(i);x.placeElement(i, 0, 0), t(r.width, r.height, e);
		}e.children(".ug-thumb-loader").hide(), i.show(), 0 == j.thumb_image_overlay_effect ? i.fadeTo(0, 1) : (1 == j.thumb_image_overlay_effect && _(i), i.fadeTo(0, 0), u(e)), S.trigger(T.events.AFTERPLACEIMAGE, e);
	}function _(e) {
		var t = e.siblings(".ug-thumb-image-overlay");if (0 == t.length) return !1;var i = x.getElementSize(e),
		    n = { width: i.width + "px", height: i.height + "px", left: i.left + "px", top: i.top + "px" };t.css(n), 0 == C.customThumbs && t.fadeTo(0, 1);
	}function g() {
		var e = "",
		    t = j.thumb_image_overlay_type.split(",");for (var i in t) {
			var n = t[i];switch (n) {case "bw":
					e += " ug-bw-effect";break;case "blur":
					e += " ug-blur-effect";break;case "sepia":
					e += " ug-sepia-effect";}
		}return e;
	}function c(e) {
		return e.hasClass("ug-thumb-selected") ? !0 : !1;
	}function h(e, i) {
		i = jQuery(i);var n = (T.getItemByThumb(i), x.getElementSize(i));t(n.width, n.height, i, !0), u(i);
	}function p(e) {
		return 1 == C.touchEnabled ? (objThumbs.off("mouseenter").off("mouseleave"), !0) : void (0 == c(e) && T.setThumbOverStyle(e));
	}function f(e) {
		return 1 == C.touchEnabled ? !0 : void (0 == c(e) && T.setThumbNormalStyle(e, !1));
	}function m(e, t) {
		if (!t) var t = !1;var i = jQuery(e),
		    n = i.parents(".ug-thumb-wrapper");return 0 == n.parent().length ? !1 : (objItem = T.getItemByThumb(n), 1 == objItem.isLoaded && t === !1 ? !1 : (T.triggerImageLoadedEvent(n, i), void (1 == C.customThumbs ? S.trigger(T.events.PLACEIMAGE, [n, i]) : d(n, i, objItem))));
	}function v(e, t, i) {
		objItem = T.getItemByThumb(t), objItem.isLoaded = !0, objItem.isThumbImageLoaded = !0;var n = x.getImageOriginalSize(i);objItem.thumbWidth = n.width, objItem.thumbHeight = n.height, objItem.thumbRatioByWidth = n.width / n.height, objItem.thumbRatioByHeight = n.height / n.width, t.addClass("ug-thumb-ratio-set");
	}var b,
	    y,
	    I,
	    w,
	    E,
	    T = this,
	    S = jQuery(T),
	    P = new UniteGalleryMain(),
	    x = new UGFunctions();this.type = { GET_THUMBS_ALL: "all", GET_THUMBS_RATIO: "ratio", GET_THUMBS_NO_RATIO: "no_ratio", GET_THUMBS_NEW: "new" }, this.events = { SETOVERSTYLE: "thumbmouseover", SETNORMALSTYLE: "thumbmouseout", SETSELECTEDSTYLE: "thumbsetselected", PLACEIMAGE: "thumbplaceimage", AFTERPLACEIMAGE: "thumb_after_place_image", IMAGELOADERROR: "thumbimageloaderror", THUMB_IMAGE_LOADED: "thumb_image_loaded" };var j = { thumb_width: 88, thumb_height: 50, thumb_fixed_size: !0, thumb_resize_by: "height", thumb_border_effect: !0, thumb_border_width: 0, thumb_border_color: "#000000", thumb_over_border_width: 0, thumb_over_border_color: "#d9d9d9", thumb_selected_border_width: 1, thumb_selected_border_color: "#d9d9d9", thumb_round_corners_radius: 0, thumb_color_overlay_effect: !0, thumb_overlay_color: "#000000", thumb_overlay_opacity: .4, thumb_overlay_reverse: !1, thumb_image_overlay_effect: !1, thumb_image_overlay_type: "bw", thumb_transition_duration: 200, thumb_transition_easing: "easeOutQuad", thumb_show_loader: !0, thumb_loader_type: "dark", thumb_wrapper_as_link: !1, thumb_link_newpage: !1 },
	    C = { touchEnabled: !1, num_thumbs_checking: 0, customThumbs: !1, funcSetCustomThumbHtml: null, isEffectBorder: !1, isEffectOverlay: !1, isEffectImage: !1, colorOverlayOpacity: 1, thumbInnerReduce: 0, allowOnResize: !0, classNewThumb: "ug-new-thumb" },
	    A = { timeout_thumb_check: 100, thumb_max_check_times: 600, eventSizeChange: "thumb_size_change" };this.init = function (e, t) {
		y = e.getObjects(), P = e, b = jQuery(e), I = y.g_objWrapper, w = y.g_arrItems, j = jQuery.extend(j, t), C.isEffectBorder = j.thumb_border_effect, C.isEffectOverlay = j.thumb_color_overlay_effect, C.isEffectImage = j.thumb_image_overlay_effect;
	}, this._____________EXTERNAL_SETTERS__________ = function () {}, this.setHtmlThumbs = function (t, i) {
		if (E = t, 1 == C.isEffectImage) var n = g();if (i !== !0) for (var r = P.getNumItems(), o = 0; r > o; o++) {
			e(o, n);
		} else {
			var a = T.getThumbs();a.removeClass(C.classNewThumb);var s = P.getNewAddedItemsIndexes();jQuery.each(s, function (t, i) {
				var r = e(i, n);r.addClass(C.classNewThumb);
			});
		}
	}, this.setThumbNormalStyle = function (e, t, o) {
		if (1 == C.customThumbs && e.removeClass("ug-thumb-over"), C.isEffectBorder && i(e, j.thumb_border_width, j.thumb_border_color, t), C.isEffectOverlay) {
			var a = 1 == j.thumb_overlay_reverse ? !1 : !0;n(e, a, t);
		}C.isEffectImage && r(e, !0, t), S.trigger(T.events.SETNORMALSTYLE, e);
	}, this.setThumbOverStyle = function (e) {
		if (1 == C.customThumbs && e.addClass("ug-thumb-over"), C.isEffectBorder && i(e, j.thumb_over_border_width, j.thumb_over_border_color), C.isEffectOverlay) {
			var t = 1 == j.thumb_overlay_reverse ? !0 : !1;n(e, t);
		}1 == C.isEffectImage && r(e, !1), S.trigger(T.events.SETOVERSTYLE, e);
	}, this.setHtmlProperties = function (e) {
		if (!e) var e = T.getThumbs();if (0 == C.customThumbs) {
			1 == j.thumb_fixed_size && t(j.thumb_width, j.thumb_height, e), s(e);
		}if (e.each(function () {
			var e = jQuery(this);u(e);
		}), C.isEffectOverlay && j.thumb_overlay_color) {
			var i = {};if (x.isRgbaSupported()) {
				var n = x.convertHexToRGB(j.thumb_overlay_color, j.thumb_overlay_opacity);i["background-color"] = n;
			} else i["background-color"] = j.thumb_overlay_color, C.colorOverlayOpacity = j.thumb_overlay_opacity;e.find(".ug-thumb-overlay").css(i);
		}
	}, this.setThumbSelected = function (e) {
		return 1 == C.customThumbs && e.removeClass("ug-thumb-over"), 1 == c(e) ? !0 : (e.addClass("ug-thumb-selected"), void o(e));
	}, this.setThumbUnselected = function (e) {
		e.removeClass("ug-thumb-selected"), T.setThumbNormalStyle(e, !1, "set unselected");
	}, this.setOptions = function (e) {
		j = jQuery.extend(j, e);
	}, this.setThumbInnerReduce = function (e) {
		C.thumbInnerReduce = e;
	}, this.setCustomThumbs = function (e, t, i) {
		if (C.customThumbs = !0, "function" != typeof e) throw new Error("The argument should be function");C.funcSetCustomThumbHtml = e, -1 == jQuery.inArray("overlay", t) && (C.isEffectOverlay = !1), -1 == jQuery.inArray("border", t) && (C.isEffectBorder = !1), C.isEffectImage = !1, i && i.allow_onresize === !1 && (C.allowOnResize = !1);
	}, this._____________EXTERNAL_GETTERS__________ = function () {}, this.getOptions = function () {
		return j;
	}, this.getNumThumbs = function () {
		var e = w.length;return e;
	}, this.getThumbImage = function (e) {
		var t = e.find(".ug-thumb-image");return t;
	}, this.getThumbByIndex = function (e) {
		var t = T.getThumbs();if (e >= t.length || 0 > e) throw new Error("Wrong thumb index");var i = jQuery(t[e]);return i;
	}, this.getThumbs = function (e) {
		var t = ".ug-thumb-wrapper",
		    i = ".ug-thumb-ratio-set";switch (e) {default:case T.type.GET_THUMBS_ALL:
				var n = E.children(t);break;case T.type.GET_THUMBS_NO_RATIO:
				var n = E.children(t).not(i);break;case T.type.GET_THUMBS_RATIO:
				var n = E.children(t + i);break;case T.type.GET_THUMBS_NEW:
				var n = E.children("." + C.classNewThumb);}return n;
	}, this.getItemByThumb = function (e) {
		var t = e.data("index");void 0 === t && (t = e.index());var i = w[t];return i;
	}, this.isThumbLoaded = function (e) {
		var t = T.getItemByThumb(e);return t.isLoaded;
	}, this.getGlobalThumbSize = function () {
		var e = { width: j.thumb_width,
			height: j.thumb_height };return e;
	}, this._____________EXTERNAL_OTHERS__________ = function () {}, this.initEvents = function () {
		var e = ".ug-thumb-wrapper";1 == C.allowOnResize && I.on(A.eventSizeChange, h), S.on(T.events.THUMB_IMAGE_LOADED, v), E.on("touchstart", e, function () {
			C.touchEnabled = !0, E.off("mouseenter").off("mouseleave");
		}), E.on("mouseenter", e, function (e) {
			var t = jQuery(this);p(t);
		}), E.on("mouseleave", e, function (e) {
			var t = jQuery(this);f(t);
		});
	}, this.destroy = function () {
		var e = ".ug-thumb-wrapper";E.off("touchstart", e), I.off(A.eventSizeChange), E.off("mouseenter", e), E.off("mouseleave", e), S.off(T.events.THUMB_IMAGE_LOADED);
	}, this.loadThumbsImages = function () {
		var e = E.find(".ug-thumb-image");x.checkImagesLoaded(e, null, function (e, t) {
			if (0 == t) m(e, !0);else {
				var i = jQuery(e).parent();a(i);
			}
		});
	}, this.triggerImageLoadedEvent = function (e, t) {
		S.trigger(T.events.THUMB_IMAGE_LOADED, [e, t]);
	}, this.hideThumbs = function () {
		E.find(".ug-thumb-wrapper").hide();
	};
}function UGThumbsStrip() {
	function e(e, i) {
		S = e.getObjects(), z = e, z.attachThumbsPanel("strip", O), T = jQuery(e), P = S.g_objWrapper, x = S.g_arrItems, k = jQuery.extend(k, i), H = k.strip_vertical_type, 1 == H && (k = jQuery.extend(k, D), k = jQuery.extend(k, i), i.thumb_resize_by = "width"), N.init(e, i), t();
	}function t() {
		var e = N.getOptions();R.isNotFixedThumbs = e.thumb_fixed_size === !1, H = k.strip_vertical_type;
	}function n() {
		N.setHtmlProperties(), o(), l(), s(), 0 == R.isRunOnce && (1 == k.strip_control_touch && (M = new UGTouchThumbsControl(), M.init(O)), 1 == k.strip_control_avia && (A = new UGAviaControl(), A.init(O)), p(), N.loadThumbsImages(), y()), R.isRunOnce = !0;
	}function r(e) {
		G.stripSize = e, 0 == H ? G.stripActiveSize = G.stripSize - k.strip_padding_left - k.strip_padding_right : G.stripActiveSize = G.stripSize - k.strip_padding_top - k.strip_padding_bottom, G.stripActiveSize < 0 && (G.stripActiveSize = 0);
	}function o() {
		var e = C.children(".ug-thumb-wrapper"),
		    t = jQuery(e[0]),
		    i = t.outerWidth(),
		    n = t.outerHeight(),
		    o = N.getOptions();0 == H ? (G.thumbSize = i, 1 == o.thumb_fixed_size ? G.thumbSecondSize = n : G.thumbSecondSize = o.thumb_height, r(j.width()), G.stripInnerSize = C.width()) : (G.thumbSize = n, 1 == o.thumb_fixed_size ? G.thumbSecondSize = i : G.thumbSecondSize = o.thumb_width, r(j.height()), G.stripInnerSize = C.height());
	}function a(e) {
		0 == H ? C.width(e) : C.height(e), G.stripInnerSize = e, p(), jQuery(O).trigger(O.events.INNER_SIZE_CHANGE);
	}function s() {
		var e = C.children(".ug-thumb-wrapper"),
		    t = 0,
		    n = 0;for (0 == H && (n = k.strip_padding_top), i = 0; i < e.length; i++) {
			var r = jQuery(e[i]);if (1 == R.isNotFixedThumbs) {
				if (objItem = N.getItemByThumb(r), 0 == objItem.isLoaded) continue;r.show();
			}L.placeElement(r, t, n), 0 == H ? t += r.outerWidth() + k.strip_space_between_thumbs : n += r.outerHeight() + k.strip_space_between_thumbs;
		}if (0 == H) var o = t - k.strip_space_between_thumbs;else var o = n - k.strip_space_between_thumbs;a(o);
	}function l() {
		if (0 == H) {
			var e = G.thumbSecondSize,
			    t = {};t.height = e + "px";var i = {};i.height = e + "px";
		} else {
			var n = G.thumbSecondSize,
			    t = {};t.width = n + "px";var i = {};i.width = n + "px";
		}j.css(t), C.css(i);
	}function u(e) {
		var t = O.getInnerStripPos(),
		    i = t + e;i = O.fixInnerStripLimits(i), O.positionInnerStrip(i, !0);
	}function d(e) {
		var t = E(e),
		    i = -1 * t.min;i = O.fixInnerStripLimits(i), O.positionInnerStrip(i, !0);
	}function _(e) {
		var t = E(e),
		    i = -1 * t.max + G.stripSize;i = O.fixInnerStripLimits(i), O.positionInnerStrip(i, !0);
	}function g(e) {
		if (0 == I()) return !1;var t = w(),
		    i = E(e);if (i.min < t.minPosThumbs) {
			var n = e.prev();d(n.length ? n : e);
		} else if (i.max > t.maxPosThumbs) {
			var r = e.next();_(r.length ? r : e);
		}
	}function c() {
		var e = z.getSelectedItem();if (null == e) return !0;var t = e.objThumbWrapper;t && g(t);
	}function h() {
		if (0 == I()) return !1;var e = O.getInnerStripPos(),
		    t = O.fixInnerStripLimits(e);e != t && O.positionInnerStrip(t, !0);
	}function p() {
		var e = I();1 == e ? (A && A.enable(), M && M.enable()) : (A && A.disable(), M && M.disable());
	}function f() {
		return I() ? !1 : void (0 == H ? L.placeElement(C, k.strip_thumbs_align, 0) : L.placeElement(C, 0, k.strip_thumbs_align));
	}function m(e) {
		if (O.isTouchMotionActive()) {
			var t = M.isSignificantPassed();if (1 == t) return !0;
		}var i = N.getItemByThumb(e);z.selectItem(i);
	}function v() {
		clearTimeout(R.handle), R.handle = setTimeout(function () {
			s();
		}, 50);
	}function b() {
		var e = z.getSelectedItem();N.setThumbSelected(e.objThumbWrapper), g(e.objThumbWrapper);
	}function y() {
		N.initEvents();var e = j.find(".ug-thumb-wrapper");e.on("click touchend", function (e) {
			var t = jQuery(this);m(t);
		}), T.on(z.events.ITEM_CHANGE, b), R.isNotFixedThumbs && jQuery(N).on(N.events.AFTERPLACEIMAGE, v);
	}function I() {
		return G.stripInnerSize > G.stripActiveSize ? !0 : !1;
	}function w() {
		var e = {},
		    t = O.getInnerStripPos();return e.minPosThumbs = -1 * t + 1, e.maxPosThumbs = -1 * t + G.stripSize - 1, e;
	}function E(e) {
		var t = {},
		    i = e.position();return 0 == H ? (t.min = i.left, t.max = i.left + G.thumbSize) : (t.min = i.top, t.max = i.top + G.thumbSize), t;
	}var T,
	    S,
	    P,
	    x,
	    j,
	    C,
	    A,
	    M,
	    O = this,
	    z = new UniteGalleryMain(),
	    L = new UGFunctions(),
	    H = !1,
	    N = new UGThumbsGeneral(),
	    L = new UGFunctions(),
	    k = { strip_vertical_type: !1, strip_thumbs_align: "left", strip_space_between_thumbs: 6, strip_thumb_touch_sensetivity: 15, strip_scroll_to_thumb_duration: 500, strip_scroll_to_thumb_easing: "easeOutCubic", strip_control_avia: !0, strip_control_touch: !0, strip_padding_top: 0, strip_padding_bottom: 0, strip_padding_left: 0, strip_padding_right: 0 },
	    R = { isRunOnce: !1, is_placed: !1, isNotFixedThumbs: !1, handle: null },
	    G = { stripSize: 0, stripActiveSize: 0, stripInnerSize: 0, thumbSize: 0, thumbSecondSize: 0 };this.events = { STRIP_MOVE: "stripmove", INNER_SIZE_CHANGE: "size_change" };var D = { strip_thumbs_align: "top", thumb_resize_by: "width" };this.setHtml = function (e) {
		if (!e) {
			var e = P;null != k.parent_container && (e = k.parent_container);
		}e.append("<div class='ug-thumbs-strip'><div class='ug-thumbs-strip-inner'></div></div>"), j = e.children(".ug-thumbs-strip"), C = j.children(".ug-thumbs-strip-inner"), N.setHtmlThumbs(C), 1 == R.isNotFixedThumbs && N.hideThumbs();
	}, this.destroy = function () {
		var e = j.find(".ug-thumb-wrapper");e.off("click"), e.off("touchend"), T.off(z.events.ITEM_CHANGE), jQuery(N).off(N.events.AFTERPLACEIMAGE), M && M.destroy(), A && A.destroy(), N.destroy();
	}, this.________EXTERNAL_GENERAL___________ = function () {}, this.init = function (t, i) {
		e(t, i);
	}, this.run = function () {
		n();
	}, this.positionInnerStrip = function (e, t) {
		if (void 0 === t) var t = !1;if (0 == H) var i = { left: e + "px" };else var i = { top: e + "px" };0 == t ? (C.css(i), O.triggerStripMoveEvent()) : (O.triggerStripMoveEvent(), C.stop(!0).animate(i, { duration: k.strip_scroll_to_thumb_duration, easing: k.strip_scroll_to_thumb_easing, queue: !1, progress: function progress() {
				O.triggerStripMoveEvent();
			}, always: function always() {
				O.triggerStripMoveEvent();
			} }));
	}, this.triggerStripMoveEvent = function () {
		jQuery(O).trigger(O.events.STRIP_MOVE);
	}, this.isTouchMotionActive = function () {
		if (!M) return !1;var e = M.isTouchActive();return e;
	}, this.isItemThumbVisible = function (e) {
		var t = e.objThumbWrapper,
		    i = t.position(),
		    n = -1 * O.getInnerStripPos();if (0 == H) var r = n + G.stripSize,
		    o = i.left,
		    a = i.left + t.width();else var r = n + G.stripSize,
		    o = i.top,
		    a = i.top + t.height();var s = !1;return a >= n && r >= o && (s = !0), s;
	}, this.getInnerStripPos = function () {
		return 0 == H ? C.position().left : C.position().top;
	}, this.getInnerStripLimits = function () {
		var e = {};return 0 == H ? e.maxPos = k.strip_padding_left : e.maxPos = k.strip_padding_top, e.minPos = -(G.stripInnerSize - G.stripActiveSize), e;
	}, this.fixInnerStripLimits = function (e) {
		var t = O.getInnerStripLimits();return e > t.maxPos && (e = t.maxPos), e < t.minPos && (e = t.minPos), e;
	}, this.scrollForeward = function () {
		u(-G.stripSize);
	}, this.scrollBack = function () {
		u(G.stripSize);
	}, this.________EXTERNAL_SETTERS___________ = function () {}, this.setOptions = function (e) {
		k = jQuery.extend(k, e), N.setOptions(e), t();
	}, this.setSizeVertical = function (e) {
		if (0 == H) throw new Error("setSizeVertical error, the strip size is not vertical");var t = G.thumbSecondSize,
		    i = {};i.width = t + "px", i.height = e + "px", j.css(i), r(e);var n = {};n.width = t + "px", n.left = "0px", n.top = "0px", C.css(n), R.is_placed = !0, p();
	}, this.setSizeHorizontal = function (e) {
		if (1 == H) throw new Error("setSizeHorizontal error, the strip size is not horizontal");var t = G.thumbSecondSize + k.strip_padding_top + k.strip_padding_bottom,
		    i = {};i.width = e + "px", i.height = t + "px", j.css(i), r(e);var n = k.strip_padding_left,
		    o = {};o.height = t + "px", o.left = n + "px", o.top = "0px", C.css(o), R.is_placed = !0, p();
	}, this.setPosition = function (e, t, i, n) {
		L.placeElement(j, e, t, i, n);
	}, this.resize = function (e) {
		0 == H ? (j.width(e), G.stripActiveSize = e - k.strip_padding_left - k.strip_padding_right) : (j.height(e), G.stripActiveSize = e - k.strip_padding_top - k.strip_padding_bottom), r(e), p(), h(), f(), c();
	}, this.setThumbUnselected = function (e) {
		N.setThumbUnselected(e);
	}, this.setCustomThumbs = function (e) {
		N.setCustomThumbs(e);
	}, this.________EXTERNAL_GETTERS___________ = function () {}, this.getObjects = function () {
		var e = N.getOptions(),
		    t = jQuery.extend(k, e),
		    i = { g_gallery: z, g_objGallery: T, g_objWrapper: P, g_arrItems: x, g_objStrip: j, g_objStripInner: C, g_aviaControl: A, g_touchThumbsControl: M, isVertical: H, g_options: t, g_thumbs: N };return i;
	}, this.getObjThumbs = function () {
		return N;
	}, this.getSelectedThumb = function () {
		var e = z.getSelectedItemIndex();return -1 == e ? null : N.getThumbByIndex(e);
	}, this.getSizeAndPosition = function () {
		var e = L.getElementSize(j);return e;
	}, this.getHeight = function () {
		var e = j.outerHeight();return e;
	}, this.getWidth = function () {
		var e = j.outerWidth();return e;
	}, this.getSizes = function () {
		return G;
	}, this.isVertical = function () {
		return H;
	}, this.isPlaced = function () {
		return R.is_placed;
	}, this.isMoveEnabled = function () {
		var e = I();return e;
	};
}function UGTouchThumbsControl() {
	function e() {
		var e = jQuery.now(),
		    t = {};return t.passedTime = T.lastTime - T.startTime, t.lastActiveTime = e - T.buttonReleaseTime, t.passedDistance = T.lastPos - T.startPos, t.passedDistanceAbs = Math.abs(t.passedDistance), t;
	}function t() {
		E.thumb_touch_slowFactor = w.normalizeSetting(5e-5, .01, 1, 100, y.strip_thumb_touch_sensetivity, !0);
	}function i(e) {
		return 0 == I ? w.getMousePosition(e).pageX : w.getMousePosition(e).pageY;
	}function n(e) {
		var t = T.mousePos - e,
		    i = T.innerPos - t,
		    n = h.getInnerStripLimits();if (i > n.maxPos) {
			var r = i - n.maxPos;i = n.maxPos + r / 3;
		}if (i < n.minPos) {
			var r = n.minPos - i;i = n.minPos - r / 3;
		}h.positionInnerStrip(i);
	}function r(e) {
		var t = h.getInnerStripPos();T.mousePos = e, T.innerPos = t, T.lastPortionPos = t, T.lastDeltaTime = 0, T.lastDeltaPos = 0, T.startTime = jQuery.now(), T.startPos = T.innerPos, T.lastTime = T.startTime, T.lastPos = T.startPos, T.speed = 0;
	}function o() {
		var e = jQuery.now(),
		    t = e - T.lastTime;t >= E.touch_portion_time && (T.lastDeltaTime = e - T.lastTime, T.lastDeltaTime > E.touch_portion_time && (T.lastDeltaTime = E.touch_portion_time), T.lastDeltaPos = T.lastPos - T.lastPortionPos, T.lastPortionPos = T.lastPos, T.lastTime = e);
	}function a() {
		var e = E.thumb_touch_slowFactor,
		    t = E.minDeltaTime,
		    i = E.minPath,
		    n = h.getInnerStripPos(),
		    r = jQuery.now(),
		    o = r - T.lastTime,
		    a = n - T.lastPortionPos;t > o && T.lastDeltaTime > 0 && (o = T.lastDeltaTime, a = T.lastDeltaPos + a), t > o && (o = t);var l = a > 0 ? 1 : -1,
		    u = 0;o > 0 && (u = a / o);var d = u * u / (2 * e) * l;Math.abs(d) <= i && (d = 0);var _ = h.getInnerStripPos(),
		    g = _ + d,
		    c = h.fixInnerStripLimits(g),
		    p = h.getInnerStripLimits(),
		    f = E.limitsBreakAddition,
		    m = !1,
		    v = c;if (g > p.maxPos && (m = !0, c = f, f > g && (c = g)), g < p.minPos) {
			m = !0;var y = p.minPos - f;c = y, g > y && (c = g);
		}var w = c - _,
		    S = Math.abs(Math.round(u / e));if (0 != d && (S = S * w / d), _ != c) {
			var P = { left: c + "px" };1 == I && (P = { top: c + "px" }), b.animate(P, { duration: S, easing: E.animationEasing, queue: !0, progress: s });
		}if (1 == m) {
			var x = E.returnAnimateSpeed,
			    j = { left: v + "px" };1 == I && (j = { top: v + "px" }), b.animate(j, { duration: x, easing: E.returnAnimationEasing, queue: !0, progress: s });
		}
	}function s() {
		T.lastPos = h.getInnerStripPos(), h.triggerStripMoveEvent();
	}function l() {
		return 1 == T.loop_active ? !0 : (T.loop_active = !0, void (T.handle = setInterval(o, 10)));
	}function u(e) {
		if (0 == T.loop_active) return !0;if (e) {
			var t = i(e);a(t);
		}T.loop_active = !1, T.handle = clearInterval(T.handle);
	}function d(e) {
		return 0 == T.isControlEnabled ? !0 : (T.buttonReleaseTime = jQuery.now(), 0 == T.touch_active ? (u(e), !0) : (e.preventDefault(), T.touch_active = !1, u(e), void v.removeClass("ug-dragging")));
	}function _(e) {
		if (0 == T.isControlEnabled) return !0;e.preventDefault(), T.touch_active = !0;var t = i(e);b.stop(!0), r(t), l(), v.addClass("ug-dragging");
	}function g(e) {
		if (0 == T.isControlEnabled) return !0;if (0 == T.touch_active) return !0;if (e.preventDefault(), 0 == e.buttons) return T.touch_active = !1, u(e), !0;var t = i(e);T.lastPos = h.getInnerStripPos(), n(t), o();
	}function c() {
		v.bind("mousedown touchstart", _), jQuery(window).add("body").bind("mouseup touchend", d), jQuery("body").bind("mousemove touchmove", g);
	}var h,
	    p,
	    f,
	    m,
	    v,
	    b,
	    y,
	    I,
	    w = new UGFunctions(),
	    E = { touch_portion_time: 200, thumb_touch_slowFactor: 0, minDeltaTime: 70, minPath: 10, limitsBreakAddition: 30, returnAnimateSpeed: 500, animationEasing: "easeOutCubic", returnAnimationEasing: "easeOutCubic" },
	    T = { touch_active: !1, loop_active: !1, mousePos: 0, innerPos: 0, startPos: 0, startTime: 0, lastTime: 0, buttonReleaseTime: 0, lastPos: 0, lastPortionPos: 0, lastDeltaTime: 0, lastDeltaPos: 0, speed: 0, handle: "", touchEnabled: !1, isControlEnabled: !0 };this.enable = function () {
		T.isControlEnabled = !0;
	}, this.disable = function () {
		T.isControlEnabled = !1;
	}, this.init = function (e) {
		h = e, m = e.getObjects(), p = m.g_gallery, f = m.g_objGallery, v = m.g_objStrip, b = m.g_objStripInner, y = m.g_options, I = m.isVertical, t(), c();
	}, this.isSignificantPassed = function () {
		var t = e();return t.passedTime > 300 ? !0 : t.passedDistanceAbs > 30 ? !0 : !1;
	}, this.isTouchActive = function () {
		if (1 == T.touch_active) return !0;if (1 == b.is(":animated")) return !0;var t = e();return t.lastActiveTime < 50 ? !0 : !1;
	}, this.destroy = function () {
		v.unbind("mousedown"), v.unbind("touchstart"), jQuery(window).add("body").unbind("mouseup").unbind("touchend"), jQuery("body").unbind("mousemove").unbind("touchmove");
	};
}function UGPanelsBase() {
	function e(e, t) {
		switch (n.orientation) {case "right":case "left":
				var i = { left: e + "px" };break;case "top":case "bottom":
				var i = { top: e + "px" };}o.stop(!0).animate(i, { duration: 300, easing: "easeInOutQuad", queue: !1, complete: function complete() {
				t && t();
			} });
	}function t(e) {
		switch (n.orientation) {case "right":case "left":
				g.placeElement(o, e, null);break;case "top":case "bottom":
				g.placeElement(o, null, e);}
	}function i() {
		s.trigger(r.events.FINISH_MOVE);
	}var n,
	    r,
	    o,
	    a,
	    s,
	    l,
	    u,
	    d = new UniteGalleryMain(),
	    _ = this,
	    g = new UGFunctions();this.init = function (e, t, i, o, l) {
		n = t, r = i, d = e, a = o, s = l, u = jQuery(d);
	}, this.setHtml = function (e) {
		if (o = e, "strip" == n.panelType) var t = a.strippanel_enable_handle;else var t = a.gridpanel_enable_handle;if (1 == t && (l = new UGPanelHandle(), l.init(r, o, a, n.panelType, d), l.setHtml()), n.isDisabledAtStart === !0) {
			var i = "<div class='ug-overlay-disabled'></div>";o.append(i), setTimeout(function () {
				o.children(".ug-overlay-disabled").hide();
			}, n.disabledAtStartTimeout);
		}
	}, this.placeElements = function () {
		l && l.placeHandle();
	}, this.initEvents = function () {
		l && (l.initEvents(), u.on(d.events.SLIDER_ACTION_START, function () {
			l.hideHandle();
		}), u.on(d.events.SLIDER_ACTION_END, function () {
			l.showHandle();
		}));
	}, this.destroy = function () {
		l && (l.destroy(), u.off(d.events.SLIDER_ACTION_START), u.off(d.events.SLIDER_ACTION_END));
	}, this.openPanel = function (a) {
		if (!a) var a = !1;return o.is(":animated") ? !1 : 0 == n.isClosed ? !1 : (n.isClosed = !1, s.trigger(r.events.OPEN_PANEL), void (a === !1 ? e(n.originalPos, i) : (t(n.originalPos), i())));
	}, this.closePanel = function (a) {
		if (!a) var a = !1;if (o.is(":animated")) return !1;if (1 == n.isClosed) return !1;var l = _.getClosedPanelDest();n.isClosed = !0, s.trigger(r.events.CLOSE_PANEL), a === !1 ? e(l, i) : (t(l), i());
	}, this.setClosedState = function (e) {
		n.originalPos = e, s.trigger(r.events.CLOSE_PANEL), n.isClosed = !0;
	}, this.setOpenedState = function (e) {
		s.trigger(r.events.OPEN_PANEL), n.isClosed = !1;
	}, this.getClosedPanelDest = function () {
		var e,
		    t = g.getElementSize(o);switch (n.orientation) {case "left":
				n.originalPos = t.left, e = -n.panelWidth;break;case "right":
				n.originalPos = t.left;var i = d.getSize();e = i.width;break;case "top":
				n.originalPos = t.top, e = -n.panelHeight;break;case "bottom":
				n.originalPos = t.top;var i = d.getSize();e = i.height;}return e;
	}, this.isPanelClosed = function () {
		return n.isClosed;
	}, this.setDisabledAtStart = function (e) {
		return 0 >= e ? !1 : (n.isDisabledAtStart = !0, void (n.disabledAtStartTimeout = e));
	};
}function UGPanelHandle() {
	function e() {
		s.removeClass("ug-button-hover");
	}function t() {
		s.addClass("ug-button-closed");
	}function i() {
		s.removeClass("ug-button-closed");
	}function n(e) {
		return e.stopPropagation(), e.stopImmediatePropagation(), 0 == l.validateClickTouchstartEvent(e.type) ? !0 : void (a.isPanelClosed() ? a.openPanel() : a.closePanel());
	}function r() {
		var e = a.getOrientation();switch (e) {case "right":case "left":
				"top" != u.panel_handle_align && "bottom" != u.panel_handle_align && (u.panel_handle_align = "top");break;case "bottom":
				"left" != u.panel_handle_align && "right" != u.panel_handle_align && (u.panel_handle_align = "left");break;case "top":
				"left" != u.panel_handle_align && "right" != u.panel_handle_align && (u.panel_handle_align = "right");}
	}var o,
	    a,
	    s,
	    l = new UGFunctions(),
	    u = { panel_handle_align: "top", panel_handle_offset: 0, panel_handle_skin: 0 };this.init = function (e, t, i, n, r) {
		switch (a = e, o = t, n) {case "grid":
				u.panel_handle_align = i.gridpanel_handle_align, u.panel_handle_offset = i.gridpanel_handle_offset, u.panel_handle_skin = i.gridpanel_handle_skin;break;case "strip":
				u.panel_handle_align = i.strippanel_handle_align, u.panel_handle_offset = i.strippanel_handle_offset, u.panel_handle_skin = i.strippanel_handle_skin;break;default:
				throw new Error("Panel handle error: wrong panel type: " + n);}var s = r.getOptions(),
		    l = s.gallery_skin;"" == u.panel_handle_skin && (u.panel_handle_skin = l);
	}, this.setHtml = function () {
		var e = a.getOrientation(),
		    t = "ug-panel-handle-tip";switch (e) {case "right":
				t += " ug-handle-tip-left";break;case "left":
				t += " ug-handle-tip-right";break;case "bottom":
				t += " ug-handle-tip-top";break;case "top":
				t += " ug-handle-tip-bottom";}o.append("<div class='" + t + " ug-skin-" + u.panel_handle_skin + "'></div>"), s = o.children(".ug-panel-handle-tip");
	}, this.initEvents = function () {
		l.addClassOnHover(s), s.bind("click touchstart", n), jQuery(a).on(a.events.OPEN_PANEL, function () {
			e(), i();
		}), jQuery(a).on(a.events.CLOSE_PANEL, function () {
			e(), t();
		});
	}, this.destroy = function () {
		l.destroyButton(s), jQuery(a).off(a.events.OPEN_PANEL), jQuery(a).off(a.events.CLOSE_PANEL);
	}, this.placeHandle = function () {
		var e = l.getElementSize(s);r();var t = a.getOrientation();switch (t) {case "left":
				l.placeElement(s, "right", u.panel_handle_align, -e.width);break;case "right":
				l.placeElement(s, -e.width, u.panel_handle_align, 0, u.panel_handle_offset);break;case "top":
				l.placeElement(s, u.panel_handle_align, "bottom", u.panel_handle_offset, -e.height);break;case "bottom":
				l.placeElement(s, u.panel_handle_align, "top", u.panel_handle_offset, -e.height);break;default:
				throw new Error("Wrong panel orientation: " + t);}
	}, this.hideHandle = function () {
		1 == s.is(":visible") && s.hide();
	}, this.showHandle = function () {
		0 == s.is(":visible") && s.show();
	};
}function UGStripPanel() {
	function e(e, t) {
		T = e, m = jQuery(T), j = jQuery.extend(j, t);var i = !1;1 == j.strippanel_vertical_type && (j = jQuery.extend(j, C), i = !0), 0 == j.strippanel_enable_buttons && (j = jQuery.extend(j, A), i = !0), 1 == i && (j = jQuery.extend(j, t));var n = T.getOptions(),
		    r = n.gallery_skin;"" == j.strippanel_buttons_skin && (j.strippanel_buttons_skin = r), v = T.getElement(), x.init(T, M, w, j, E), P = new UGThumbsStrip(), P.init(T, j);
	}function t() {
		if (0 == j.strippanel_vertical_type) {
			if (0 == M.panelWidth) throw new Error("Strip panel error: The width not set, please set width");
		} else if (0 == M.panelHeight) throw new Error("Strip panel error: The height not set, please set height");if (null == M.orientation) throw new Error("Wrong orientation, please set panel orientation before run");return !0;
	}function i() {
		return 1 == M.isFirstRun && 0 == t() ? !1 : (P.run(), s(), d(), f(), M.isFirstRun = !1, void c());
	}function n(e) {
		if (!e) var e = v;if (e.append("<div class='ug-strip-panel'></div>"), b = e.children(".ug-strip-panel"), 1 == j.strippanel_enable_buttons) {
			var t = "ug-strip-arrow-left",
			    i = "ug-strip-arrow-right";1 == j.strippanel_vertical_type && (t = "ug-strip-arrow-up", i = "ug-strip-arrow-down"), b.append("<div class='ug-strip-arrow " + t + " ug-skin-" + j.strippanel_buttons_skin + "'><div class='ug-strip-arrow-tip'></div></div>"), b.append("<div class='ug-strip-arrow " + i + " ug-skin-" + j.strippanel_buttons_skin + "'><div class='ug-strip-arrow-tip'></div></div>");
		}x.setHtml(b), P.setHtml(b), 1 == j.strippanel_enable_buttons && (I = b.children("." + t), y = b.children("." + i)), r();
	}function r() {
		"" != j.strippanel_background_color && b.css("background-color", j.strippanel_background_color);
	}function o() {
		var e = P.getHeight(),
		    t = M.panelWidth;if (y) {
			I.height(e), y.height(e);var i = I.children(".ug-strip-arrow-tip");S.placeElement(i, "center", "middle");var n = y.children(".ug-strip-arrow-tip");S.placeElement(n, "center", "middle");
		}var r = e + j.strippanel_padding_top + j.strippanel_padding_bottom;b.width(t), b.height(r), M.panelHeight = r;var o = t - j.strippanel_padding_left - j.strippanel_padding_right;if (y) {
			var a = y.outerWidth();o = o - 2 * a - 2 * j.strippanel_padding_buttons;
		}P.resize(o);
	}function a() {
		var e = P.getWidth(),
		    t = M.panelHeight;if (y) {
			I.width(e), y.width(e);var i = I.children(".ug-strip-arrow-tip");S.placeElement(i, "center", "middle");var n = y.children(".ug-strip-arrow-tip");S.placeElement(n, "center", "middle");
		}var r = e + j.strippanel_padding_left + j.strippanel_padding_right;b.width(r), b.height(t), M.panelWidth = r;var o = t - j.strippanel_padding_top - j.strippanel_padding_bottom;if (y) {
			var a = y.outerHeight();o = o - 2 * a - 2 * j.strippanel_padding_buttons;
		}P.resize(o);
	}function s() {
		0 == j.strippanel_vertical_type ? o() : a();
	}function l() {
		y && (S.placeElement(I, "left", "top", j.strippanel_padding_left, j.strippanel_padding_top), S.placeElement(y, "right", "top", j.strippanel_padding_right, j.strippanel_padding_top));var e = j.strippanel_padding_left;y && (e += y.outerWidth() + j.strippanel_padding_buttons), P.setPosition(e, j.strippanel_padding_top);
	}function u() {
		y && (S.placeElement(I, "left", "top", j.strippanel_padding_left, j.strippanel_padding_top), S.placeElement(y, "left", "bottom", j.strippanel_padding_left, j.strippanel_padding_bottom));var e = j.strippanel_padding_top;y && (e += y.outerHeight() + j.strippanel_padding_buttons), P.setPosition(j.strippanel_padding_left, e);
	}function d() {
		0 == j.strippanel_vertical_type ? l() : u(), x.placeElements();
	}function _(e) {
		return S.isButtonDisabled(e) ? !0 : void ("advance_item" == j.strippanel_buttons_role ? T.nextItem() : P.scrollForeward());
	}function g(e) {
		return S.isButtonDisabled(e) ? !0 : void ("advance_item" == j.strippanel_buttons_role ? T.prevItem() : P.scrollBack());
	}function c() {
		if (!y) return !0;if (0 == P.isMoveEnabled()) return S.disableButton(I), S.disableButton(y), !0;var e = P.getInnerStripLimits(),
		    t = P.getInnerStripPos();t >= e.maxPos ? S.disableButton(I) : S.enableButton(I), t <= e.minPos ? S.disableButton(y) : S.enableButton(y);
	}function h() {
		c();
	}function p() {
		T.isLastItem() ? S.disableButton(y) : S.enableButton(y), T.isFirstItem() ? S.disableButton(I) : S.enableButton(I);
	}function f() {
		if (1 == M.isEventsInited) return !1;if (M.isEventsInited = !0, y) if (S.addClassOnHover(y, "ug-button-hover"), S.addClassOnHover(I, "ug-button-hover"), S.setButtonOnClick(I, g), S.setButtonOnClick(y, _), "advance_item" != j.strippanel_buttons_role) jQuery(P).on(P.events.STRIP_MOVE, h), jQuery(P).on(P.events.INNER_SIZE_CHANGE, c), m.on(T.events.SIZE_CHANGE, c);else {
			var e = T.getOptions();0 == e.gallery_carousel && jQuery(T).on(T.events.ITEM_CHANGE, p);
		}x.initEvents();
	}var m,
	    v,
	    b,
	    y,
	    I,
	    w = this,
	    E = jQuery(this),
	    T = new UniteGalleryMain(),
	    S = new UGFunctions(),
	    P = new UGThumbsStrip(),
	    x = new UGPanelsBase();this.events = { FINISH_MOVE: "gridpanel_move_finish", OPEN_PANEL: "open_panel", CLOSE_PANEL: "close_panel" };var j = { strippanel_vertical_type: !1, strippanel_padding_top: 8, strippanel_padding_bottom: 8, strippanel_padding_left: 0, strippanel_padding_right: 0, strippanel_enable_buttons: !0, strippanel_buttons_skin: "", strippanel_padding_buttons: 2, strippanel_buttons_role: "scroll_strip", strippanel_enable_handle: !0, strippanel_handle_align: "top", strippanel_handle_offset: 0, strippanel_handle_skin: "", strippanel_background_color: "" },
	    C = { strip_vertical_type: !0, strippanel_padding_left: 8, strippanel_padding_right: 8, strippanel_padding_top: 0, strippanel_padding_bottom: 0 },
	    A = { strippanel_padding_left: 8, strippanel_padding_right: 8, strippanel_padding_top: 8, strippanel_padding_bottom: 8 },
	    M = { panelType: "strip", panelWidth: 0, panelHeight: 0, isEventsInited: !1, isClosed: !1, orientation: null, originalPos: null, isFirstRun: !0 };this.destroy = function () {
		y && (S.destroyButton(y), S.destroyButton(I), jQuery(P).off(P.events.STRIP_MOVE), jQuery(T).off(T.events.ITEM_CHANGE), jQuery(T).off(T.events.SIZE_CHANGE)), x.destroy(), P.destroy();
	}, this.getOrientation = function () {
		return M.orientation;
	}, this.setOrientation = function (e) {
		M.orientation = e;
	}, this.init = function (t, i) {
		e(t, i);
	}, this.run = function () {
		i();
	}, this.setHtml = function (e) {
		n(e);
	}, this.getElement = function () {
		return b;
	}, this.getSize = function () {
		var e = S.getElementSize(b);return e;
	}, this.setWidth = function (e) {
		M.panelWidth = e;
	}, this.setHeight = function (e) {
		M.panelHeight = e;
	}, this.resize = function (e) {
		w.setWidth(e), s(), d();
	}, this.__________Functions_From_Base_____ = function () {}, this.isPanelClosed = function () {
		return x.isPanelClosed();
	}, this.getClosedPanelDest = function () {
		return x.getClosedPanelDest();
	}, this.openPanel = function (e) {
		x.openPanel(e);
	}, this.closePanel = function (e) {
		x.closePanel(e);
	}, this.setOpenedState = function (e) {
		x.setOpenedState(e);
	}, this.setClosedState = function (e) {
		x.setClosedState(e);
	}, this.setCustomThumbs = function (e) {
		P.setCustomThumbs(e);
	}, this.setDisabledAtStart = function (e) {
		x.setDisabledAtStart(e);
	};
}function UGGridPanel() {
	function e(e, i) {
		x = e, t(), i && i.vertical_scroll && (M.gridpanel_vertical_scroll = i.vertical_scroll), M = jQuery.extend(M, i), 1 == L.isHorType ? (M = jQuery.extend(M, z), M = jQuery.extend(M, i)) : 1 == M.gridpanel_vertical_scroll && (M = jQuery.extend(M, O), M = jQuery.extend(M, i), M.grid_panes_direction = "bottom");var n = x.getOptions(),
		    r = n.gallery_skin;"" == M.gridpanel_arrows_skin && (M.gridpanel_arrows_skin = r);var o = e.getObjects();I = o.g_objWrapper, A.init(x, L, S, M, P), C = new UGThumbsGrid(), C.init(x, M);
	}function t() {
		if (null == L.orientation) throw new Error("Wrong orientation, please set panel orientation before run");
	}function i() {
		t(), o(), C.run(), l(), u(), y(), d();
	}function n() {
		I.append("<div class='ug-grid-panel'></div>"), w = I.children(".ug-grid-panel"), L.isHorType ? (w.append("<div class='grid-arrow grid-arrow-left-hortype ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), w.append("<div class='grid-arrow grid-arrow-right-hortype ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), T = w.children(".grid-arrow-left-hortype"), E = w.children(".grid-arrow-right-hortype")) : 0 == M.gridpanel_vertical_scroll ? (w.append("<div class='grid-arrow grid-arrow-left ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), w.append("<div class='grid-arrow grid-arrow-right ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), T = w.children(".grid-arrow-left"), E = w.children(".grid-arrow-right")) : (w.append("<div class='grid-arrow grid-arrow-up ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), w.append("<div class='grid-arrow grid-arrow-down ug-skin-" + M.gridpanel_arrows_skin + "'></div>"), T = w.children(".grid-arrow-up"), E = w.children(".grid-arrow-down")), A.setHtml(w), T.fadeTo(0, 0), E.fadeTo(0, 0), C.setHtml(w), r();
	}function r() {
		"" != M.gridpanel_background_color && w.css("background-color", M.gridpanel_background_color);
	}function o() {
		"center" == M.gridpanel_grid_align && (M.gridpanel_grid_align = "middle");
	}function a() {
		var e = M.gridpanel_padding_border_top + M.gridpanel_padding_border_bottom,
		    t = L.panelHeight - e;if (0 == M.gridpanel_arrows_always_on) {
			var i = C.getNumPanesEstimationByHeight(t);if (1 == i) return t;
		}var n = j.getElementSize(E),
		    r = n.height,
		    e = r + M.gridpanel_arrows_padding_vert;return 1 == M.gridpanel_vertical_scroll && (e *= 2), e += M.gridpanel_padding_border_top + M.gridpanel_padding_border_bottom, t = L.panelHeight - e;
	}function s() {
		var e = M.gridpanel_padding_border_left + M.gridpanel_padding_border_right,
		    t = L.panelWidth - e;if (0 == M.gridpanel_arrows_always_on) {
			var i = C.getNumPanesEstimationByWidth(t);if (1 == i) return t;
		}var n = j.getElementSize(E),
		    r = n.width;return e += 2 * (r + M.gridpanel_arrows_padding_hor), t = L.panelWidth - e;
	}function l() {
		var e = !1;if (1 == M.gridpanel_arrows_always_on) e = !0;else {
			var t = C.getNumPanes();t > 1 && (e = !0);
		}1 == e ? (E.show().fadeTo(0, 1), T.show().fadeTo(0, 1), L.arrowsVisible = !0) : (E.hide(), T.hide(), L.arrowsVisible = !1);
	}function u() {
		var e = C.getSize();1 == L.isHorType ? L.panelHeight = e.height + M.gridpanel_padding_border_top + M.gridpanel_padding_border_bottom : L.panelWidth = e.width + M.gridpanel_padding_border_left + M.gridpanel_padding_border_right, j.setElementSize(w, L.panelWidth, L.panelHeight);
	}function d() {
		return 1 == L.isEventsInited ? !1 : (L.isEventsInited = !0, T && (j.addClassOnHover(T), C.attachPrevPaneButton(T)), E && (j.addClassOnHover(E), C.attachNextPaneButton(E)), void A.initEvents());
	}function _() {
		var e = M.gridpanel_padding_border_left;return e;
	}function g() {
		var e = M.gridpanel_grid_align,
		    t = 0;switch (e) {case "top":
				t = M.gridpanel_padding_border_top;break;case "bottom":
				t = M.gridpanel_padding_border_bottom;}var i = _(),
		    n = C.getElement();j.placeElement(n, i, e, 0, t);
	}function c() {
		var e,
		    t,
		    i,
		    n,
		    r = j.getElementSize(T),
		    o = C.getSize();switch (M.gridpanel_grid_align) {default:case "top":
				e = M.gridpanel_padding_border_top + r.height + M.gridpanel_arrows_padding_vert;break;case "middle":
				e = "middle";break;case "bottom":
				e = L.panelHeight - o.height - r.height - M.gridpanel_padding_border_bottom - M.gridpanel_arrows_padding_vert;}var a = _(),
		    s = C.getElement();j.placeElement(s, a, e);var o = C.getSize();switch (M.gridpanel_arrows_align_vert) {default:case "center":case "middle":
				t = (o.top - r.height) / 2, i = o.bottom + (L.panelHeight - o.bottom - r.height) / 2, n = 0;break;case "grid":
				t = o.top - r.height - M.gridpanel_arrows_padding_vert_vert, i = o.bottom + M.gridpanel_arrows_padding_vert, n = 0;break;case "border":case "borders":
				t = M.gridpanel_padding_border_top, i = "bottom", n = M.gridpanel_padding_border_bottom;}j.placeElement(T, "center", t), j.placeElement(E, "center", i, 0, n);
	}function h() {
		1 == L.arrowsVisible ? c() : g();
	}function p() {
		var e,
		    t,
		    i,
		    n,
		    r = j.getElementSize(T),
		    o = C.getSize(),
		    a = M.gridpanel_padding_border_top;switch (M.gridpanel_grid_align) {case "middle":
				switch (M.gridpanel_arrows_align_vert) {default:
						var s = o.height + M.gridpanel_arrows_padding_vert + r.height;a = (L.panelHeight - s) / 2;break;case "border":case "borders":
						var l = L.panelHeight - r.height - M.gridpanel_padding_border_bottom;a = (l - o.height) / 2;}break;case "bottom":
				var s = o.height + r.height + M.gridpanel_arrows_padding_vert;a = L.panelHeight - s - M.gridpanel_padding_border_bottom;}var u = C.getElement(),
		    d = _();j.placeElement(u, d, a);var o = C.getSize();switch (M.gridpanel_arrows_align_vert) {default:case "center":case "middle":
				e = o.bottom + (L.panelHeight - o.bottom - r.height) / 2, i = 0;break;case "grid":
				e = o.bottom + M.gridpanel_arrows_padding_vert, i = 0;break;case "border":case "borders":
				e = "bottom", i = M.gridpanel_padding_border_bottom;}t = -r.width / 2 - M.gridpanel_space_between_arrows / 2, j.placeElement(T, "center", e, t, i);var n = Math.abs(t);j.placeElement(E, "center", e, n, i);
	}function f() {
		1 == L.arrowsVisible ? p() : g();
	}function m() {
		var e,
		    t,
		    i,
		    n,
		    r = j.getElementSize(T),
		    o = C.getSize();switch (M.gridpanel_grid_align) {default:case "left":
				e = M.gridpanel_padding_border_left + M.gridpanel_arrows_padding_hor + r.width;break;case "middle":case "center":
				e = "center";break;case "right":
				e = L.panelWidth - o.width - r.width - M.gridpanel_padding_border_right - M.gridpanel_arrows_padding_hor;}var a = C.getElement();switch (j.placeElement(a, e, M.gridpanel_padding_border_top), o = C.getSize(), M.gridpanel_arrows_align_vert) {default:case "center":case "middle":
				n = (o.height - r.height) / 2 + o.top;break;case "top":
				n = M.gridpanel_padding_border_top + M.gridpanel_arrows_padding_vert;break;case "bottom":
				n = L.panelHeight - M.gridpanel_padding_border_bottom - M.gridpanel_arrows_padding_vert - r.height;}switch (M.gridpanel_arrows_align_hor) {default:case "borders":
				t = M.gridpanel_padding_border_left, i = L.panelWidth - M.gridpanel_padding_border_right - r.width;break;case "grid":
				t = o.left - M.gridpanel_arrows_padding_hor - r.width, i = o.right + M.gridpanel_arrows_padding_hor;break;case "center":
				t = (o.left - r.width) / 2, i = o.right + (L.panelWidth - o.right - r.width) / 2;}j.placeElement(T, t, n), j.placeElement(E, i, n);
	}function v() {
		var e,
		    t = C.getSize();switch (M.gridpanel_grid_align) {default:case "left":
				e = M.gridpanel_padding_border_left;break;case "middle":case "center":
				e = "center";break;case "right":
				e = L.panelWidth - t.width - M.gridpanel_padding_border_right;}var i = C.getElement();j.placeElement(i, e, M.gridpanel_padding_border_top);
	}function b() {
		1 == L.arrowsVisible ? m() : v();
	}function y() {
		0 == L.isHorType ? 1 == M.gridpanel_vertical_scroll ? h() : f() : b(), A.placeElements();
	}var I,
	    w,
	    E,
	    T,
	    S = this,
	    P = jQuery(this),
	    x = new UniteGalleryMain(),
	    j = new UGFunctions(),
	    C = new UGThumbsGrid(),
	    A = new UGPanelsBase();this.events = { FINISH_MOVE: "gridpanel_move_finish", OPEN_PANEL: "open_panel", CLOSE_PANEL: "close_panel" };var M = { gridpanel_vertical_scroll: !0, gridpanel_grid_align: "middle", gridpanel_padding_border_top: 10, gridpanel_padding_border_bottom: 4, gridpanel_padding_border_left: 10, gridpanel_padding_border_right: 10, gridpanel_arrows_skin: "", gridpanel_arrows_align_vert: "middle", gridpanel_arrows_padding_vert: 4, gridpanel_arrows_align_hor: "center", gridpanel_arrows_padding_hor: 10, gridpanel_space_between_arrows: 20, gridpanel_arrows_always_on: !1, gridpanel_enable_handle: !0, gridpanel_handle_align: "top",
		gridpanel_handle_offset: 0, gridpanel_handle_skin: "", gridpanel_background_color: "" },
	    O = { gridpanel_grid_align: "middle", gridpanel_padding_border_top: 2, gridpanel_padding_border_bottom: 2 },
	    z = { gridpanel_grid_align: "center" },
	    L = { panelType: "grid", isHorType: !1, arrowsVisible: !1, panelHeight: 0, panelWidth: 0, originalPosX: null, isEventsInited: !1, isClosed: !1, orientation: null };this.destroy = function () {
		T && j.destroyButton(T), E && j.destroyButton(E), A.destroy(), C.destroy();
	}, this.getOrientation = function () {
		return L.orientation;
	}, this.setOrientation = function (e) {
		switch (L.orientation = e, e) {case "right":case "left":
				L.isHorType = !1;break;case "top":case "bottom":
				L.isHorType = !0;break;default:
				throw new Error("Wrong grid panel orientation: " + e);}
	}, this.setHeight = function (e) {
		if (1 == L.isHorType) throw new Error("setHeight is not appliable to this orientatio (" + L.orientation + "). Please use setWidth");L.panelHeight = e;var t = a();C.setMaxHeight(t);
	}, this.setWidth = function (e) {
		if (0 == L.isHorType) throw new Error("setWidth is not appliable to this orientatio (" + L.orientation + "). Please use setHeight");L.panelWidth = e;var t = s();C.setMaxWidth(t);
	}, this.init = function (t, i) {
		e(t, i);
	}, this.setHtml = function () {
		n();
	}, this.run = function () {
		i();
	}, this.getElement = function () {
		return w;
	}, this.getSize = function () {
		var e = j.getElementSize(w);return e;
	}, this.__________Functions_From_Base_____ = function () {}, this.isPanelClosed = function () {
		return A.isPanelClosed();
	}, this.getClosedPanelDest = function () {
		return A.getClosedPanelDest();
	}, this.openPanel = function (e) {
		A.openPanel(e);
	}, this.closePanel = function (e) {
		A.closePanel(e);
	}, this.setOpenedState = function (e) {
		A.setOpenedState(e);
	}, this.setClosedState = function (e) {
		A.setClosedState(e);
	}, this.setDisabledAtStart = function (e) {
		A.setDisabledAtStart(e);
	};
}function UGThumbsGrid() {
	function e(e, t, i) {
		if (N = e.getObjects(), B = e, B.attachThumbsPanel("grid", Q), H = jQuery(e), k = N.g_objWrapper, R = N.g_arrItems, i === !0 && (X.isTilesMode = !0), X.numThumbs = R.length, _(t), 1 == X.isTilesMode) {
			U.setFixedMode(), U.setApproveClickFunction(x), U.init(e, V);var n = U.getOptions();X.tileMaxHeight = n.tile_height, X.tileMaxWidth = n.tile_width, Y = U.getObjThumbs();
		} else t.thumb_fixed_size = !0, Y.init(e, t);
	}function t(e) {
		var t = k;e && (t = e), t.append("<div class='ug-thumbs-grid'><div class='ug-thumbs-grid-inner'></div></div>"), G = t.children(".ug-thumbs-grid"), D = G.children(".ug-thumbs-grid-inner"), 1 == X.isTilesMode ? U.setHtml(D) : Y.setHtmlThumbs(D);
	}function n() {
		if (0 == X.isHorizontal) {
			if (0 == X.gridHeight) throw new Error("You must set height before run.");
		} else if (0 == X.gridWidth) throw new Error("You must set width before run.");
	}function r() {
		var e = B.getSelectedItem();if (n(), 1 == X.isFirstTimeRun) L(), 1 == X.isTilesMode ? (a(), u(), U.run()) : (Y.setHtmlProperties(), u(), Y.loadThumbsImages());else if (1 == X.isTilesMode) {
			var t = a();1 == t && (u(), U.run());
		}if (p(), 1 == X.isFirstTimeRun && X.isTilesMode) {
			var i = Y.getThumbs();i.each(function (e, t) {
				k.trigger(X.eventSizeChange, jQuery(t));
			}), i.fadeTo(0, 1);
		}null != e && d(e.index), W.trigger(Q.events.PANE_CHANGE, X.currentPane), X.isFirstTimeRun = !1;
	}function o() {
		if (1 == X.isTilesMode) var e = U.getGlobalTileSize();else var e = Y.getGlobalThumbSize();return e;
	}function a() {
		if (0 == X.isTilesMode) throw new Error("Dynamic size can be set only in tiles mode");var e = !1,
		    t = B.isMobileMode(),
		    i = X.spaceBetweenCols;1 == t ? (X.spaceBetweenCols = V.grid_space_between_mobile, X.spaceBetweenRows = V.grid_space_between_mobile) : (X.spaceBetweenCols = V.grid_space_between_cols, X.spaceBetweenRows = V.grid_space_between_rows), X.spaceBetweenCols != i && (e = !0);var n = o(),
		    r = n.width,
		    a = X.tileMaxWidth,
		    s = F.getNumItemsInSpace(X.gridWidth, X.tileMaxWidth, X.spaceBetweenCols);return s < V.grid_min_cols && (a = F.getItemSizeInSpace(X.gridWidth, V.grid_min_cols, X.spaceBetweenCols)), U.setTileSizeOptions(a), a != r && (e = !0), e;
	}function s() {
		var e = o(),
		    t = e.height,
		    i = X.gridWidth,
		    n = V.grid_num_rows * t + (V.grid_num_rows - 1) * X.spaceBetweenRows + 2 * V.grid_padding;X.gridHeight = n, F.setElementSize(G, i, n), F.setElementSize(D, i, n), X.innerWidth = i, X.innerHeight = n;
	}function l() {
		var e = o(),
		    t = e.width,
		    i = V.grid_num_cols * t + (V.grid_num_cols - 1) * X.spaceBetweenCols + 2 * V.grid_padding,
		    n = X.gridHeight;X.gridWidth = i, F.setElementSize(G, i, n), F.setElementSize(D, i, n), X.innerWidth = i, X.innerHeight = n;
	}function u() {
		0 == X.isHorizontal ? l() : s();
	}function d(e) {
		var t = T(e);return -1 == t ? !1 : void Q.gotoPane(t, "scroll");
	}function _(e) {
		V = jQuery.extend(V, e), Y.setOptions(e), X.isNavigationVertical = "top" == V.grid_panes_direction || "bottom" == V.grid_panes_direction, X.spaceBetweenCols = V.grid_space_between_cols, X.spaceBetweenRows = V.grid_space_between_rows;
	}function g() {
		var e = D.children(".ug-thumb-wrapper"),
		    t = 0,
		    n = 0,
		    r = 0,
		    o = 0,
		    a = 0,
		    s = 0;X.innerWidth = 0, X.numPanes = 1, X.arrPanes = [], X.numThumbsInPane = 0, X.arrPanes.push(o);var l = e.length;for (i = 0; i < l; i++) {
			var u = jQuery(e[i]);F.placeElement(u, t, n);var d = u.outerWidth(),
			    _ = u.outerHeight();t > a && (a = t);var g = n + _;g > s && (s = g);var c = a + d;c > X.innerWidth && (X.innerWidth = c), t += d + X.spaceBetweenCols, r++, r >= V.grid_num_cols && (n += _ + X.spaceBetweenRows, t = o, r = 0), 1 == X.numPanes && X.numThumbsInPane++, n + _ > X.gridHeight && (n = 0, o = X.innerWidth + X.spaceBetweenCols, t = o, r = 0, 1 == X.isMaxHeight && 1 == X.numPanes && (X.gridHeight = s, G.height(X.gridHeight)), i < l - 1 && (X.numPanes++, X.arrPanes.push(o)));
		}D.width(X.innerWidth), 1 == X.isMaxHeight && 1 == X.numPanes && (X.gridHeight = s, G.height(s));
	}function c() {
		var e = D.children(".ug-thumb-wrapper"),
		    t = 0,
		    n = 0,
		    r = 0,
		    o = 0,
		    a = 0,
		    s = 0;X.innerWidth = 0, X.numPanes = 1, X.arrPanes = [], X.numThumbsInPane = 0, X.arrPanes.push(a);var l = e.length;for (i = 0; i < l; i++) {
			var u = jQuery(e[i]);F.placeElement(u, t, n);var d = u.outerWidth(),
			    _ = u.outerHeight();t += d + X.spaceBetweenCols;var g = n + _;g > r && (r = g), o++, o >= V.grid_num_cols && (n += _ + X.spaceBetweenRows, t = a, o = 0), 1 == X.numPanes && X.numThumbsInPane++, g = n + _;var c = s + X.gridHeight;g > c && (1 == X.isMaxHeight && 1 == X.numPanes && (X.gridHeight = r, G.height(X.gridHeight), c = X.gridHeight), n = c + X.spaceBetweenRows, s = n, a = 0, t = a, o = 0, i < l - 1 && (X.numPanes++, X.arrPanes.push(n)));
		}D.height(r), X.innerHeight = r, 1 == X.isMaxHeight && 1 == X.numPanes && (X.gridHeight = r, G.height(r));
	}function h() {
		var e = D.children(".ug-thumb-wrapper"),
		    t = V.grid_padding,
		    n = V.grid_padding,
		    r = n,
		    o = t,
		    a = 0,
		    s = 0,
		    l = 0,
		    u = 0,
		    d = 0;X.innerWidth = 0, X.numPanes = 1, X.arrPanes = [], X.numThumbsInPane = 0, X.arrPanes.push(t - V.grid_padding);var _ = e.length;for (i = 0; i < _; i++) {
			var g = jQuery(e[i]),
			    c = g.outerWidth(),
			    h = g.outerHeight();o - t + c > X.gridWidth && (d++, r = 0, d >= V.grid_num_rows ? (d = 0, t = o, r = n, l = 0, 1 == X.numPanes && (X.gridWidth = a + V.grid_padding, G.width(X.gridWidth), X.gridHeight = u + V.grid_padding, G.height(X.gridHeight)), X.numPanes++, X.arrPanes.push(t - V.grid_padding)) : (o = t, r = l + X.spaceBetweenRows)), F.placeElement(g, o, r);var p = o + c;p > a && (a = p);var f = r + h;f > l && (l = f), f > u && (u = f), f > s && (s = f);var p = a + c;p > X.innerWidth && (X.innerWidth = p), o += c + X.spaceBetweenCols, 1 == X.numPanes && X.numThumbsInPane++;
		}X.innerWidth = a + V.grid_padding, X.innerHeight = u + V.grid_padding, D.width(X.innerWidth), D.height(X.innerHeight), 1 == X.numPanes && (X.gridWidth = a + V.grid_padding, X.gridHeight = u + V.grid_padding, G.width(X.gridWidth), G.height(X.gridHeight));
	}function p() {
		0 == X.isHorizontal ? X.isNavigationVertical ? c() : g() : h();
	}function f(e) {
		if (0 > e || e >= X.numThumbs) throw new Error("Thumb not exists: " + e);return !0;
	}function m(e) {
		if (e >= X.numPanes || 0 > e) throw new Error("Pane " + index + " doesn't exists.");return !0;
	}function v(e) {
		var t = w(e);return 0 == t ? !1 : void D.css(t);
	}function b(e) {
		var t = w(e);return 0 == t ? !1 : void D.stop(!0).animate(t, { duration: V.grid_transition_duration, easing: V.grid_transition_easing, queue: !1 });
	}function y() {
		var e = -X.arrPanes[X.currentPane];b(e);
	}function I() {
		return 1 == X.isNavigationVertical ? X.gridHeight : X.gridWidth;
	}function w(e) {
		var t = {};return 1 == X.isNavigationVertical ? t.top = e + "px" : t.left = e + "px", t;
	}function E() {
		var e = F.getElementSize(D);return 1 == X.isNavigationVertical ? e.top : e.left;
	}function T(e) {
		if (0 == f(e)) return -1;var t = Math.floor(e / X.numThumbsInPane);return t;
	}function S() {
		if (1 == X.numPanes) return !1;var e = F.getStoredEventData(X.storedEventID),
		    t = e.diffTime,
		    i = E(),
		    n = Math.abs(i - e.startInnerPos);return n > 30 ? !0 : n > 5 && t > 300 ? !0 : !1;
	}function P() {
		var e = F.getStoredEventData(X.storedEventID),
		    t = E();diffPos = Math.abs(e.startInnerPos - t);var i = I(),
		    n = Math.round(3 * i / 8);return diffPos >= n ? !0 : e.diffTime < 300 && diffPos > 25 ? !0 : !1;
	}function x() {
		if (1 == X.numPanes) return !0;var e = F.isApproveStoredEventClick(X.storedEventID, X.isNavigationVertical);return e;
	}function j(e) {
		if (1 == S()) return !0;var t = jQuery(this),
		    i = Y.getItemByThumb(t);B.selectItem(i);
	}function C(e) {
		if (1 == X.numPanes) return !0;if (1 == X.touchActive) return !0;0 == X.isTilesMode && e.preventDefault(), X.touchActive = !0;var t = { startInnerPos: E() };F.storeEventData(e, X.storedEventID, t);
	}function A() {
		if (0 == V.grid_vertical_scroll_ondrag) return !1;if (1 == X.isNavigationVertical) return !1;var e = F.handleScrollTop(X.storedEventID);return "vert" === e ? !0 : !1;
	}function M(e) {
		if (0 == X.touchActive) return !0;e.preventDefault(), F.updateStoredEventData(e, X.storedEventID);var t = F.getStoredEventData(X.storedEventID, X.isNavigationVertical),
		    i = A();if (i) return !0;var n = t.diffMousePos,
		    r = t.startInnerPos + n,
		    o = n > 0 ? "prev" : "next",
		    a = X.arrPanes[X.numPanes - 1];0 == V.grid_carousel && r > 0 && "prev" == o && (r /= 3), 0 == V.grid_carousel && -a > r && "next" == o && (r = t.startInnerPos + n / 3), v(r);
	}function O(e) {
		if (0 == X.touchActive) return !0;F.updateStoredEventData(e, X.storedEventID);var t = F.getStoredEventData(X.storedEventID, X.isNavigationVertical);if (X.touchActive = !1, 0 == P()) return y(), !0;var i = E(),
		    n = i - t.startInnerPos,
		    r = n > 0 ? "prev" : "next";"next" == r ? 0 == V.grid_carousel && Q.isLastPane() ? y() : Q.nextPane() : 0 == V.grid_carousel && Q.isFirstPane() ? y() : Q.prevPane();
	}function z() {
		var e = B.getSelectedItem();Y.setThumbSelected(e.objThumbWrapper), d(e.index);
	}function L() {
		if (0 == X.isTilesMode) {
			Y.initEvents();var e = G.find(".ug-thumb-wrapper");e.on("click touchend", j), H.on(B.events.ITEM_CHANGE, z);
		} else U.initEvents();G.bind("mousedown touchstart", C), jQuery("body").bind("mousemove touchmove", M), jQuery(window).add("body").bind("mouseup touchend", O);
	}var H,
	    N,
	    k,
	    R,
	    G,
	    D,
	    Q = this,
	    W = jQuery(this),
	    B = new UniteGalleryMain(),
	    F = new UGFunctions(),
	    Y = new UGThumbsGeneral(),
	    U = new UGTileDesign(),
	    V = { grid_panes_direction: "left", grid_num_cols: 2, grid_min_cols: 2, grid_num_rows: 2, grid_space_between_cols: 10, grid_space_between_rows: 10, grid_space_between_mobile: 10, grid_transition_duration: 300, grid_transition_easing: "easeInOutQuad", grid_carousel: !1, grid_padding: 0, grid_vertical_scroll_ondrag: !1 };this.events = { PANE_CHANGE: "pane_change" };var X = { eventSizeChange: "thumb_size_change", isHorizontal: !1, isMaxHeight: !1, isMaxWidth: !1, gridHeight: 0, gridWidth: 0, innerWidth: 0, innerHeight: 0, numPanes: 0, arrPanes: 0, numThumbs: 0, currentPane: 0, numThumbsInPane: 0, isNavigationVertical: !1, touchActive: !1, startScrollPos: 0, isFirstTimeRun: !0, isTilesMode: !1, storedEventID: "thumbsgrid", tileMaxWidth: null, tileMaxHeight: null, spaceBetweenCols: null, spaceBetweenRows: null };this.destroy = function () {
		if (0 == X.isTilesMode) {
			var e = G.find(".ug-thumb-wrapper");e.off("click"), e.off("touchend"), H.on(B.events.ITEM_CHANGE), Y.destroy();
		} else U.destroy();G.unbind("mousedown"), G.unbind("touchstart"), jQuery("body").unbind("mousemove"), jQuery("body").unbind("touchmove"), jQuery(window).add("body").unbind("touchend"), jQuery(window).add("body").unbind("mouseup"), W.off(Q.events.PANE_CHANGE);
	}, this.__________EXTERNAL_GENERAL_________ = function () {}, this.setThumbUnselected = function (e) {
		Y.setThumbUnselected(e);
	}, this.isItemThumbVisible = function (e) {
		var t = e.index,
		    i = T(t);return i == X.currentPane ? !0 : !1;
	}, this.__________EXTERNAL_API_________ = function () {}, this.getNumPanesEstimationByHeight = function (e) {
		if (1 == X.isTilesMode) var t = V.tile_height;else var i = Y.getOptions(),
		    t = i.thumb_height;var n = Y.getNumThumbs(),
		    r = Math.ceil(n / V.grid_num_cols),
		    o = r * t + (r - 1) * X.spaceBetweenRows,
		    a = Math.ceil(o / e);return a;
	}, this.getNumPanesEstimationByWidth = function (e) {
		if (X.isTilesMode) var t = V.tile_width;else var i = Y.getOptions(),
		    t = i.thumb_width;var n = Y.getNumThumbs(),
		    r = Math.ceil(n / V.grid_num_rows),
		    o = r * t + (r - 1) * X.spaceBetweenCols,
		    a = Math.ceil(o / e);return a;
	}, this.getHeightEstimationByWidth = function (e) {
		if (0 == X.isTilesMode) throw new Error("This function works only with tiles mode");var t = Y.getNumThumbs(),
		    i = F.getNumItemsInSpace(e, V.tile_width, X.spaceBetweenCols),
		    n = Math.ceil(t / i);n > V.grid_num_rows && (n = V.grid_num_rows);var r = F.getSpaceByNumItems(n, V.tile_height, X.spaceBetweenRows);return r += 2 * V.grid_padding;
	}, this.getElement = function () {
		return G;
	}, this.getSize = function () {
		var e = F.getElementSize(G);return e;
	}, this.getNumPanes = function () {
		return X.numPanes;
	}, this.isFirstPane = function () {
		return 0 == X.currentPane ? !0 : !1;
	}, this.isLastPane = function () {
		return X.currentPane == X.numPanes - 1 ? !0 : !1;
	}, this.getPaneInfo = function () {
		var e = { pane: X.currentPane, total: X.numPanes };return e;
	}, this.getPane = function () {
		return X.currentPane;
	}, this.setWidth = function (e) {
		X.gridWidth = e, X.isHorizontal = !0;
	}, this.setMaxWidth = function (e) {
		X.gridWidth = e, X.isMaxWidth = !0, X.isHorizontal = !0;
	}, this.setHeight = function (e) {
		X.gridHeight = e, X.isHorizontal = !1;
	}, this.setMaxHeight = function (e) {
		X.gridHeight = e, X.isMaxHeight = !0, X.isHorizontal = !1;
	}, this.gotoPane = function (e, t) {
		if (0 == m(e)) return !1;if (e == X.currentPane) return !1;var i = -X.arrPanes[e];X.currentPane = e, b(i), W.trigger(Q.events.PANE_CHANGE, e);
	}, this.nextPane = function () {
		var e = X.currentPane + 1;if (e >= X.numPanes) {
			if (0 == V.grid_carousel) return !0;e = 0;
		}Q.gotoPane(e, "next");
	}, this.prevPane = function () {
		var e = X.currentPane - 1;return 0 > e && (e = X.numPanes - 1, 0 == V.grid_carousel) ? !1 : void Q.gotoPane(e, "prev");
	}, this.attachNextPaneButton = function (e) {
		return F.setButtonOnClick(e, Q.nextPane), 1 == V.grid_carousel ? !0 : (Q.isLastPane() && e.addClass("ug-button-disabled"), void W.on(Q.events.PANE_CHANGE, function () {
			Q.isLastPane() ? e.addClass("ug-button-disabled") : e.removeClass("ug-button-disabled");
		}));
	}, this.attachPrevPaneButton = function (e) {
		return F.setButtonOnClick(e, Q.prevPane), 1 == V.grid_carousel ? !0 : (Q.isFirstPane() && e.addClass("ug-button-disabled"), void W.on(Q.events.PANE_CHANGE, function () {
			Q.isFirstPane() ? e.addClass("ug-button-disabled") : e.removeClass("ug-button-disabled");
		}));
	}, this.attachBullets = function (e) {
		e.setActive(X.currentPane), jQuery(e).on(e.events.BULLET_CLICK, function (t, i) {
			Q.gotoPane(i, "theme"), e.setActive(i);
		}), jQuery(Q).on(Q.events.PANE_CHANGE, function (t, i) {
			e.setActive(i);
		});
	}, this.getObjTileDesign = function () {
		return U;
	}, this.init = function (t, i, n) {
		e(t, i, n);
	}, this.run = function () {
		r();
	}, this.setHtml = function (e) {
		t(e);
	};
}function UGTiles() {
	function e(e, i) {
		g_objects = e.getObjects(), oe = e, K = jQuery(e), J = g_objects.g_objWrapper, ee = g_objects.g_arrItems, de = jQuery.extend(de, i), t(), se.init(e, de), le = se.getObjThumbs();
	}function t() {
		de.tiles_min_columns < 1 && (de.tiles_min_columns = 1), 0 != de.tiles_max_columns && de.tiles_max_columns < de.tiles_min_columns && (de.tiles_max_columns = de.tiles_min_columns);
	}function i(e) {
		if (!e) if ($) e = $;else var e = J;$ = e;var t = de.tiles_type;e.addClass("ug-tiletype-" + t), se.setHtml(e), e.children(".ug-thumb-wrapper").hide();
	}function n() {
		if ($.addClass("ug-tiles-rest-mode"), _e.isTransInited = !0, 1 == de.tiles_enable_transition) {
			$.addClass("ug-tiles-transit");var e = se.getOptions();1 == e.tile_enable_image_effect && 0 == e.tile_image_effect_reverse && $.addClass("ug-tiles-transit-overlays"), _e.isTransActive = !0;
		}
	}function r() {
		return ae.getElementSize($).width;
	}function o() {
		return 0 == _e.isTransInited ? !1 : ($.addClass("ug-tiles-transition-active"), $.removeClass("ug-tiles-rest-mode"), 0 == _e.isTransActive ? !1 : void se.disableEvents());
	}function a() {
		return 0 == _e.isTransInited ? !1 : ($.removeClass("ug-tiles-transition-active"), void $.addClass("ug-tiles-rest-mode"));
	}function s() {
		1 == _e.isTransActive ? (setTimeout(function () {
			se.enableEvents(), se.triggerSizeChangeEventAllTiles(), a();
		}, 800), _e.handle && clearTimeout(_e.handle), _e.handle = setTimeout(function () {
			a(), se.triggerSizeChangeEventAllTiles(), _e.handle = null;
		}, 2e3)) : (se.triggerSizeChangeEventAllTiles(), a());
	}function l() {
		ue.colWidth = (ue.availWidth - ue.colGap * (ue.numCols - 1)) / ue.numCols, ue.colWidth = Math.floor(ue.colWidth), ue.totalWidth = ae.getSpaceByNumItems(ue.numCols, ue.colWidth, ue.colGap);
	}function u() {
		if (ue.colWidth = de.tiles_col_width, ue.minCols = de.tiles_min_columns, ue.maxCols = de.tiles_max_columns, 0 == oe.isMobileMode() ? ue.colGap = de.tiles_space_between_cols : ue.colGap = de.tiles_space_between_cols_mobile, ue.galleryWidth = r(), ue.availWidth = ue.galleryWidth, 1 == de.tiles_include_padding && (ue.availWidth = ue.galleryWidth - 2 * ue.colGap), 1 == de.tiles_exact_width) ue.numCols = ae.getNumItemsInSpace(ue.availWidth, ue.colWidth, ue.colGap), ue.maxCols > 0 && ue.numCols > ue.maxCols && (ue.numCols = ue.maxCols), ue.numCols < ue.minCols ? (ue.numCols = ue.minCols, l()) : ue.totalWidth = ue.numCols * (ue.colWidth + ue.colGap) - ue.colGap;else {
			var e = ae.getNumItemsInSpaceRound(ue.availWidth, ue.colWidth, ue.colGap);e < ue.minCols ? e = ue.minCols : 0 != ue.maxCols && e > ue.maxCols && (e = ue.maxCols), ue.numCols = e, l();
		}switch (de.tiles_align) {case "center":default:
				ue.addX = Math.round((ue.galleryWidth - ue.totalWidth) / 2);break;case "left":
				ue.addX = 0;break;case "right":
				ue.addX = ue.galleryWidth - ue.totalWidth;}for (ue.arrPosx = [], col = 0; col < ue.numCols; col++) {
			var t = ae.getColX(col, ue.colWidth, ue.colGap);ue.arrPosx[col] = t + ue.addX;
		}
	}function d() {
		ue.maxColHeight = 0, ue.colHeights = [0];
	}function _() {
		var e = 0,
		    t = 999999999;for (col = 0; col < ue.numCols; col++) {
			if (void 0 == ue.colHeights[col] || 0 == ue.colHeights[col]) return col;ue.colHeights[col] < t && (e = col, t = ue.colHeights[col]);
		}return e;
	}function g(e, t, i, n) {
		if (null === n || "undefined" == typeof n) var n = _();var r = 0;void 0 !== ue.colHeights[n] && (r = ue.colHeights[n]);var o = se.getTileHeightByWidth(ue.colWidth, e);if (null === o) {
			if (1 == de.tiles_enable_transition) throw new Error("Can't know tile height, please turn off transition");var a = ae.getElementSize(e);o = a.height;
		}var s = ue.arrPosx[n];ae.placeElement(e, s, r);var l = r + o;ue.colHeights[n] = l + ue.colGap, ue.maxColHeight < l && (ue.maxColHeight = l), 1 == t && e.show().fadeTo(0, 1), 1 == i && $.height(ue.maxColHeight);
	}function c(e) {
		e || (e = !1), u(), d();var t = le.getThumbs(le.type.GET_THUMBS_RATIO);o(), se.resizeAllTiles(ue.colWidth, se.resizemode.VISIBLE_ELEMENTS, t);for (var i = 0; i < t.length; i++) {
			var n = jQuery(t[i]),
			    r = void 0;1 == de.tiles_keep_order && (r = ae.getColByIndex(ue.numCols, i)), g(n, e, !1, r);
		}s();var a = $.height();1 == _e.isTransActive && a > ue.maxColHeight ? setTimeout(function () {
			$.height(ue.maxColHeight);
		}, 700) : $.height(ue.maxColHeight);
	}function h(e) {
		var t = e.index(),
		    i = oe.getItem(t);if (i.ordered_placed === !0) return !1;var n = ae.getPrevRowSameColIndex(t, ue.numCols);if (0 > n) return !0;var r = oe.getItem(n);return r.ordered_placed === !0 ? !0 : !1;
	}function p(e, t) {
		if (t !== !0) {
			var i = h(e);if (0 == i) return !1;
		}var n = e.index(),
		    r = ae.getColByIndex(ue.numCols, n),
		    o = oe.getItem(n);se.resizeTile(e, ue.colWidth), g(e, !0, !0, r), o.ordered_placed = !0;var a = oe.getNumItems(),
		    s = ae.getNextRowSameColIndex(n, ue.numCols);if (s >= a) return !1;var l = le.getThumbByIndex(s),
		    u = oe.getItem(s);le.isThumbLoaded(l);le.isThumbLoaded(l) && !u.ordered_placed && p(l, !0);
	}function f(e, t) {
		if (1 == t) return !1;e = jQuery(e);var i = jQuery(e).parent();le.triggerImageLoadedEvent(i, e), 1 == de.tiles_keep_order ? p(i) : (se.resizeTile(i, ue.colWidth), g(i, !0, !0));
	}function m() {
		var e = le.getThumbs(le.type.GET_THUMBS_NO_RATIO);if (!e || 0 == e.length) return !1;if (_e.isAllLoaded = !1, 1 == _e.isFirstPlaced) {
			u(), d();var t = Math.abs(ue.galleryWidth - ue.totalWidth);if (1 == de.tiles_set_initial_height && 0 == ae.isScrollbarExists() && 25 > t) {
				var i = (e.length, Math.ceil(e.length / ue.numCols)),
				    r = i * de.tiles_col_width * .75;$.height(r), u();
			}
		}e.fadeTo(0, 0);var o = e.find("img.ug-thumb-image"),
		    a = ue.numCols,
		    s = ue.galleryWidth;ae.checkImagesLoaded(o, function () {
			u(), (a != ue.numCols || s != ue.galleryWidth) && c(!1), n(), re.trigger(ne.events.ALL_TILES_LOADED);
		}, function (e, t) {
			1 == _e.isFirstPlaced && oe.triggerEvent(ne.events.TILES_FIRST_PLACED), f(e, t);
		});
	}function v() {
		var e = r(),
		    t = le.getThumbs(!0),
		    i = de.tiles_justified_row_height,
		    n = [],
		    o = 0,
		    a = de.tiles_justified_space_between,
		    s = t.length;jQuery.each(t, function (e, t) {
			t = jQuery(t);var r = le.getItemByThumb(t),
			    a = r.thumbWidth,
			    s = r.thumbHeight;s !== i && (a = Math.floor(r.thumbRatioByWidth * i)), n[e] = a, o += a;
		});var l = Math.ceil(o / e);l > s && (l = s);var u = o / l,
		    d = [],
		    _ = 0,
		    g = [],
		    c = [],
		    h = 0,
		    p = 0;jQuery.each(t, function (e, t) {
			var i = n[e];h + i / 2 > (p + 1) * u && (g[d.length] = _, d.push(c), c = [], _ = 0, p++), h += i, _ += i, c.push(t);
		}), g[d.length] = _, d.push(c);var f = [],
		    m = [],
		    v = 0;jQuery.each(d, function (t, r) {
			var o = (r.length, g[t]),
			    s = (r.length - 1) * a,
			    l = (e - s) / o,
			    u = Math.round(i * l);v += u, t > 0 && (v += a), m.push(u);var d = u / i,
			    _ = [],
			    c = s;jQuery.each(r, function (e, t) {
				var i = jQuery(t),
				    r = i.index(),
				    o = n[r],
				    a = Math.round(o * d);_[e] = a, c += a;
			});var h = c - e;jQuery.each(_, function (e, t) {
				return 0 == h ? !1 : (0 > h ? (_[e] = t + 1, h++) : (_[e] = t - 1, h--), void (e == _.length - 1 && 0 != h && (_[e] -= h)));
			}), f[t] = _;
		});var b = { arrRows: d, arrRowWidths: f, arrRowHeights: m, gap: a, totalHeight: v };return b;
	}function b(e) {
		if (!e) var e = !1;var t = r(),
		    i = v();$.height(i.totalHeight);var n = r();n != t && (i = v()), o();var a = 0,
		    l = 0;jQuery.each(i.arrRows, function (t, n) {
			var r = i.arrRowWidths[t],
			    o = i.arrRowHeights[t],
			    s = 0;jQuery.each(n, function (t, n) {
				var u = jQuery(n),
				    d = o,
				    _ = r[t];se.resizeTile(u, _, d, se.resizemode.VISIBLE_ELEMENTS), ae.placeElement(u, s, a), s += _, s > l && (l = s), s += i.gap, 1 == e && jQuery(n).show();
			}), a += o + i.gap;
		}), s();
	}function y() {
		var e = jQuery(J).find("img.ug-thumb-image"),
		    t = le.getThumbs();_e.isAllLoaded = !1, t.fadeTo(0, 0), ae.checkImagesLoaded(e, function () {
			setTimeout(function () {
				b(!0), t.fadeTo(0, 1), oe.triggerEvent(ne.events.TILES_FIRST_PLACED), n(), re.trigger(ne.events.ALL_TILES_LOADED);
			});
		}, function (e, t) {
			e = jQuery(e);var i = jQuery(e).parent();le.triggerImageLoadedEvent(i, e);
		});
	}function I() {
		var e = jQuery(J).find("img.ug-thumb-image"),
		    t = le.getThumbs();_e.isAllLoaded = !1, t.fadeTo(0, 0), ae.checkImagesLoaded(e, function () {
			1 == oe.isMobileMode() ? c(!0) : E(!0), oe.triggerEvent(ne.events.TILES_FIRST_PLACED), n(), re.trigger(ne.events.ALL_TILES_LOADED);
		}, function (e, t) {
			e = jQuery(e);var i = jQuery(e).parent();le.triggerImageLoadedEvent(i, e);
		});
	}function w() {
		var e = r();ge.galleryWidth = e, te = {}, ge.colWidth = de.tiles_nested_col_width, ge.optimalTileWidth = de.tiles_nested_optimal_tile_width, ge.currentGap = de.tiles_space_between_cols, 1 == oe.isMobileMode() && (ge.currentGap = de.tiles_space_between_cols_mobile), null == ge.colWidth ? ge.colWidth = Math.floor(ge.optimalTileWidth / ge.nestedOptimalCols) : ge.optimalTileWidth > ge.colWidth ? ge.nestedOptimalCols = Math.ceil(ge.optimalTileWidth / ge.colWidth) : ge.nestedOptimalCols = 1, ge.maxColumns = ae.getNumItemsInSpace(e, ge.colWidth, ge.currentGap), ge.colWidth = ae.getItemSizeInSpace(e, ge.maxColumns, ge.currentGap), ge.gridY = 0, ie = [];var t = le.getThumbs(!0);switch (t.each(function () {
			var e = jQuery(this),
			    t = T(e);ie.push(t);
		}), ge.optimalTileWidth > ge.colWidth ? ge.nestedOptimalCols = Math.ceil(ge.optimalTileWidth / ge.colWidth) : ge.nestedOptimalCols = 1, ge.totalWidth = ge.maxColumns * (ge.colWidth + ge.currentGap) - ge.currentGap, de.tiles_align) {case "center":default:
				ge.addX = Math.round((ge.galleryWidth - ge.totalWidth) / 2);break;case "left":
				ge.addX = 0;break;case "right":
				ge.addX = ge.galleryWidth - ge.totalWidth;}ge.maxGridY = 0;
	}function E(e) {
		var t = r();w(), x();var i = ge.maxGridY * (ge.colWidth + ge.currentGap) - ge.currentGap;$.height(i);var n = r();n != t && (w(), x()), 0 == de.tiles_nested_debug && U(e);
	}function T(e) {
		var t,
		    i,
		    n = {},
		    r = ge.colWidth,
		    o = ge.currentGap,
		    a = se.getTileImageSize(e),
		    s = e.index(),
		    l = Math.ceil(S(s) * (1 * ge.nestedOptimalCols / 3) + 2 * ge.nestedOptimalCols / 3),
		    u = a.width,
		    d = a.height,
		    _ = u / d;return u > d ? (t = l, i = Math.round(t / _), 0 == i && (i = 1)) : (i = l, t = Math.round(i * _), 0 == t && (t = 1)), n.dimWidth = t, n.dimHeight = i, n.width = t * r + o * (t - 1), n.height = i * r + o * (i - 1), n.imgWidth = u, n.imgHeight = d, n.left = 0, n.top = 0, n;
	}function S(e) {
		return Math.abs(Math.sin(Math.abs(1e3 * Math.sin(e))));
	}function P(e, t) {
		if (0 == t) {
			for (var i = ge.currentItem; i < ie.length; i++) {
				j(i, !0);
			}ge.currentItem = ie.length - 1;
		} else j(ge.currentItem, !0);for (var i = 0; i <= ge.currentItem; i++) {
			V(i, !0);
		}ge.currentItem++;
	}function x(e) {
		if (1 == de.tiles_nested_debug) return "undefined" == typeof e && (e = !0), P(!0, e), !1;for (var t = 0; t < ie.length; t++) {
			j(t, !0);
		}
	}function j(e, t) {
		if (!t) var t = !1;ge.maxColHeight = 0;for (var i = ae.getObjectLength(te), n = ge.gridY; i + 1 >= n; n++) {
			for (var r = 0; r < ge.maxColumns; r++) {
				if (0 == Q(ge.gridY) || 0 == F(ge.gridY, r)) {
					var o = D(r);return void C(e, o, r);
				}
			}ge.gridY++;
		}
	}function C(e, t, i) {
		var n = jQuery.extend(!0, {}, ie[e]),
		    r = n.dimWidth,
		    o = t - n.dimWidth,
		    a = ge.nestedOptimalCols,
		    s = t <= n.dimWidth || .33 * a >= o || a >= t;if (s) N(e, t);else if (a >= o) a >= 4 ? 1 == G(Math.floor(t / 2), i) ? N(e, Math.floor(t / 2) + 1) : N(e, Math.floor(t / 2)) : N(objImage, t);else if (1 == G(r, i)) switch (r >= a) {case !0:
				N(e, r - 1);break;case !1:
				N(e, r + 1);}n = jQuery.extend(!0, {}, ie[e]);var l = L(e, n.dimWidth, i);if (ge.columnsValueToEnableHeightResize <= l[0] && ge.maxColumns >= 2 * ge.nestedOptimalCols) {
			var u = H(i, n),
			    d = k(e, u.newHeight, !0);ie[e].dimHeight = d.dimHeight;var _ = z(l, d.dimWidth, i),
			    g = A(_),
			    c = !1;g >= 2 && (c = !0), u.newHeight >= n.dimHeight && (n = k(e, u.newHeight, !0));var h = M(u.idToResize, u.newHeight, n.dimHeight);n.top = ge.gridY, n.left = i, h.push({ tileID: e, sizes: n });var p = R(h),
			    f = R(_);return f > p || 1 == c ? void O(h) : void O(_);
		}n.left = i, n.top = ge.gridY, ie[e] = n, W(e, n, i, ge.gridY), ge.maxGridY = n.top + n.dimHeight;
	}function A(e) {
		for (var t = 0, i = 0, n = 0; n < e.length - 1; n++) {
			var r = e[n].sizes,
			    o = -1,
			    a = -1;Q(r.top + r.dimHeight) && ge.maxColumns > r.left + r.dimWidth && (o = te[r.top + r.dimHeight - 1][r.left + r.dimWidth], a = te[r.top + r.dimHeight][r.left + r.dimWidth]), o != a && t++;
		}for (var n = 0; n < e.length - 1; n++) {
			var r = e[n].sizes,
			    o = -1,
			    a = -1;Q(r.top + r.dimHeight) && r.left - 1 >= 0 && (o = te[r.top + r.dimHeight - 1][r.left - 1], a = te[r.top + r.dimHeight][r.left - 1]), o != a && i++;
		}return Math.max(i, t);
	}function M(e, t, i) {
		var n = ie[e],
		    r = n.dimHeight,
		    o = (n.dimWidth, n.left),
		    a = n.top,
		    s = (parseInt(a / (ge.colWidth + ge.currentGap)), parseInt(o / (ge.colWidth + ge.currentGap)), r - t + i),
		    l = k(e, s, !0),
		    u = [];return u.push({ tileID: e, sizes: l }), u;
	}function O(e) {
		for (var t = 0; t < e.length; t++) {
			var i = e[t].sizes,
			    n = e[t].tileID;ie[n] = jQuery.extend(!0, {}, i), W(n, i, i.left, i.top);
		}
	}function z(e, t) {
		for (var i = 0, n = 0, r = [], o = 0, a = 0, s = 0; s < e[1].length; s++) {
			var l = e[1][s],
			    u = ie[e[1][s]];if (n += u.dimHeight, 0 != s) i += u.dimHeight, r.push([l, u.dimHeight]);else {
				var d = N(l, t, !0);i += d.dimHeight, r.push([e[1][s], d.dimHeight]);
			}
		}o = u.left, a = u.top;for (var _ = n, g = [], s = r.length - 1; s >= 0; s--) {
			var c,
			    l = r[s][0];0 != s ? (c = Math.max(Math.round(1 * n / 3), Math.floor(r[s][1] * (n / i))), _ -= c, d = k(l, c, !0), d.left = o, d.top = a, g.push({ tileID: l, sizes: d }), a += d.dimHeight) : (c = _, d = k(l, c, !0), d.left = o, d.top = a, g.push({ tileID: l, sizes: d }));
		}return g;
	}function L(e, t, i) {
		var n = ge.gridY - 1,
		    r = 0,
		    o = 0,
		    a = 1,
		    s = [],
		    l = [];if (s.push(e), n >= 0) {
			for (o = 0; n >= 0;) {
				if (r = te[n][i], "undefined" != typeof te[n][i - 1] && te[n][i - 1] == te[n][i] || "undefined" != typeof te[n][i + t] && te[n][i + t - 1] == te[n][i + t] || te[n][i] != te[n][i + t - 1]) return l.push(a), l.push(s), l;o != r && (a++, s.push(r)), n--, o = r;
			}return l.push(a), l.push(s), l;
		}return [0, []];
	}function H(e, t) {
		var i = 0,
		    n = 0,
		    r = t.dimWidth,
		    o = t.dimHeight,
		    a = 0,
		    s = 0,
		    l = jQuery.map(te, function (e, t) {
			return [e];
		});if ("undefined" == typeof l[ge.gridY] || "undefined" == typeof l[ge.gridY][e - 1]) n = 0;else for (var u = 0;;) {
			if ("undefined" == typeof te[ge.gridY + u] || -1 == te[ge.gridY + u][e - 1]) break;a = te[ge.gridY + u][e - 2], u++, n++;
		}if ("undefined" == typeof l[ge.gridY] || "undefined" == typeof l[ge.gridY][e + r]) i = 0;else for (u = 0;;) {
			if ("undefined" == typeof te[ge.gridY + u] || -1 == te[ge.gridY + u][e + r]) break;s = te[ge.gridY + u][e + r + 1], u++, i++;
		}var d = 0,
		    _ = 0;Math.abs(o - n) < Math.abs(o - i) && 0 != n ? (d = n, _ = a) : 0 != i ? (d = i, _ = s) : d = o;var g = { newHeight: d, idToResize: _ };return g;
	}function N(e, t, i) {
		i || (i = !1);var n = ge.colWidth,
		    r = ge.currentGap,
		    o = ie[e],
		    a = o.imgWidth,
		    s = o.imgHeight,
		    l = a / s;if (dimWidth = t, dimHeight = Math.round(dimWidth / l), 1 == i) {
			var u = jQuery.extend(!0, {}, o);return u.dimWidth = dimWidth, u.dimHeight = dimHeight, u.width = dimWidth * n + r * (dimWidth - 1), u.height = dimHeight * n + r * (dimHeight - 1), u;
		}o.dimWidth = dimWidth, o.dimHeight = dimHeight, o.width = dimWidth * n + r * (dimWidth - 1), o.height = dimHeight * n + r * (dimHeight - 1);
	}function k(e, t, i) {
		i || (i = !1);var n = ie[e],
		    r = n.dimWidth,
		    o = ge.colWidth,
		    a = ge.currentGap;if (1 == i) {
			var s = jQuery.extend(!0, {}, n);return s.dimHeight = t, s.width = r * o + a * (r - 1), s.height = t * o + a * (t - 1), s;
		}n.dimHeight = t, n.width = r * o + a * (r - 1), n.height = t * o + a * (t - 1);
	}function R(e) {
		for (var t = 0, i = 0, n = 0; n < e.length; n++) {
			var r = ie[e[n].tileID];if (0 == r.dimHeight || 0 == r.height) return;resizeVal = r.dimWidth / r.dimHeight / (r.imgWidth / r.imgHeight), resizeVal < 1 && (resizeVal = 1 / resizeVal), t += resizeVal, i++;
		}return t / i;
	}function G(e, t) {
		var i = ge.gridY - 1;return 0 >= i || 0 == Q(i) ? !1 : te[i][t + e - 1] != te[i][t + e] ? !0 : !1;
	}function D(e) {
		var t = e,
		    i = 0;if (1 == Q(ge.gridY)) for (; 0 == F(ge.gridY, t);) {
			i++, t++;
		} else i = ge.maxColumns;return i;
	}function Q(e) {
		return "undefined" == typeof te[e] ? !1 : !0;
	}function W(e, t, i, n) {
		for (var r = 0; r < t.dimHeight; r++) {
			for (var o = 0; o < t.dimWidth; o++) {
				0 == Q(n + r) && B(n + r), Y(n + r, i + o, e);
			}
		}
	}function B(e) {
		te[e] = new Object();for (var t = 0; t < ge.maxColumns; t++) {
			te[e][t] = -1;
		}
	}function F(e, t) {
		return -1 != te[e][t];
	}function Y(e, t, i) {
		te[e][t] = i;
	}function U(e) {
		if (!e) var e = !1;o();for (var t = 0; t < ie.length; t++) {
			V(t, e);
		}$.height(ge.maxColHeight), s();
	}function V(e, t) {
		var i = le.getThumbByIndex(e),
		    n = ie[e],
		    r = n.top * (ge.colWidth + ge.currentGap),
		    o = ge.addX + n.left * (ge.colWidth + ge.currentGap);se.resizeTile(i, n.width, n.height, se.resizemode.VISIBLE_ELEMENTS), ae.placeElement(i, o, r), r + n.height > ge.maxColHeight && (ge.maxColHeight = r + n.height), 1 == t && i.fadeTo(0, 1);
	}function X() {
		if (1 == _e.isFirstTimeRun) return !0;if (0 == _e.isAllLoaded) return !1;switch (de.tiles_type) {case "columns":
				c(!1);break;case "justified":
				b(!1);break;case "nested":
				var e = oe.isMobileMode();1 == e ? c(!1) : E(!1);}
	}function Z() {
		re.on(ne.events.ALL_TILES_LOADED, function () {
			_e.isAllLoaded = !0;
		}), K.on(oe.events.SIZE_CHANGE, X), K.on(ne.events.TILES_FIRST_PLACED, function () {
			_e.isFirstPlaced = !1;
		}), se.initEvents();
	}function q() {
		switch (J.children(".ug-tile").show(), 1 == _e.isFirstTimeRun && Z(), se.run(), de.tiles_type) {default:case "columns":
				m();break;case "justified":
				y();break;case "nested":
				I();}_e.isFirstTimeRun = !1;
	}var K,
	    J,
	    $,
	    ee,
	    te,
	    ie,
	    ne = this,
	    re = jQuery(this),
	    oe = new UniteGalleryMain(),
	    ae = new UGFunctions(),
	    se = new UGTileDesign(),
	    le = new UGThumbsGeneral(),
	    ue = {},
	    de = { tiles_type: "columns", tiles_col_width: 250, tiles_align: "center", tiles_exact_width: !1, tiles_space_between_cols: 3, tiles_space_between_cols_mobile: 3, tiles_include_padding: !0, tiles_min_columns: 2, tiles_max_columns: 0, tiles_keep_order: !1, tiles_set_initial_height: !0, tiles_justified_row_height: 150, tiles_justified_space_between: 3, tiles_nested_optimal_tile_width: 250, tiles_nested_col_width: null, tiles_nested_debug: !1, tiles_enable_transition: !0 };this.events = { THUMB_SIZE_CHANGE: "thumb_size_change", TILES_FIRST_PLACED: "tiles_first_placed", ALL_TILES_LOADED: "all_tiles_loaded" };var _e = { isFirstTimeRun: !0, handle: null, isTransActive: !1, isTransInited: !1, isFirstPlaced: !0, isAllLoaded: !1 },
	    ge = { colWidth: null, nestedOptimalCols: 5, gridY: 0, maxColumns: 0, columnsValueToEnableHeightResize: 3, resizeLeftRightToColumn: !0, currentItem: 0, currentGap: null, optimalTileWidth: null, maxGridY: 0 };this.destroy = function () {
		K.off(oe.events.SIZE_CHANGE), se.destroy(), K.off(ne.events.TILES_FIRST_PLACED);
	}, this.init = function (t, i) {
		e(t, i);
	}, this.setHtml = function (e) {
		i(e);
	}, this.getObjTileDesign = function () {
		return se;
	}, this.run = function () {
		q();
	}, this.runNewItems = function () {
		if (!$) throw new Error("Can't run new items - parent not set");switch (se.setHtml($, !0), se.run(!0), de.tiles_type) {case "columns":
				m();break;default:case "justified":case "nested":
				throw new Error("Tiles type: " + de.tiles_type + " not support load more yet");}
	};
}function UGTileDesign() {
	function e(e, i) {
		D = e, L = jQuery(e);var r = D.getObjects();N = r.g_objWrapper, k = D.getArrItems(), B = jQuery.extend(B, F), B = jQuery.extend(B, i), t(), W.init(e, B);var o = { allow_onresize: !1 },
		    a = ["overlay"];Y.funcCustomTileHtml && (a = []), W.setCustomThumbs(n, a, o);var s = W.getOptions();B = jQuery.extend(B, s), Y.ratioByWidth = B.tile_width / B.tile_height, Y.ratioByHeight = B.tile_height / B.tile_width, B.tile_size_by == R.sizeby.GLOBAL_RATIO && Y.isTextpanelOutside && (Y.hasImageContainer = !0);
	}function t() {
		if (1 == B.tile_enable_overlay ? (B.thumb_overlay_opacity = B.tile_overlay_opacity, B.thumb_overlay_color = B.tile_overlay_color) : 0 == B.tile_enable_icons ? B.thumb_color_overlay_effect = !1 : B.thumb_overlay_opacity = 0, B.tile_as_link && (B.thumb_wrapper_as_link = !0, B.thumb_link_newpage = B.tile_link_newpage), 1 == B.tile_enable_outline && 0 == B.tile_enable_border && (B.tile_enable_outline = !1), Y.tileInnerReduce = 0, B.tile_enable_border && (Y.tileInnerReduce = 2 * B.tile_border_width, W.setThumbInnerReduce(Y.tileInnerReduce)), Y.isSaparateIcons = !Q.isRgbaSupported(), 1 == B.tile_enable_textpanel) {
			switch (B.tile_textpanel_position) {case "top":
					B.tile_textpanel_align = "top";case "bottom":
					Y.isTextpanelOutside = !0, B.tile_textpanel_always_on = !0, B.tile_textpanel_offset = 0;break;case "inside_top":
					B.tile_textpanel_align = "top";break;case "middle":
					B.tile_textpanel_align = "middle", B.tile_textpanel_appear_type = "fade";}0 == B.tile_textpanel_always_on && (Y.isSaparateIcons = !0);
		}0 != B.tile_textpanel_offset && (B.tile_textpanel_appear_type = "fade", B.tile_textpanel_margin = B.tile_textpanel_offset), "title_and_desc" == B.tile_textpanel_source && (B.tile_textpanel_enable_description = !0, B.tile_textpanel_desc_style_as_title = !0);
	}function i() {
		var e = D.isMobileMode();switch (Y.isTextPanelHidden = !1, 1 == e && 0 == B.tile_textpanel_always_on && (Y.isTextPanelHidden = !0), Y.isVideoplayIconAlwaysOn = B.tile_videoplay_icon_always_on, B.tile_videoplay_icon_always_on) {case "always":
				Y.isVideoplayIconAlwaysOn = !0;break;case "never":
				Y.isVideoplayIconAlwaysOn = !1;break;case "mobile_only":
				Y.isVideoplayIconAlwaysOn = 1 == e ? !0 : !1;break;case "desktop_only":
				Y.isVideoplayIconAlwaysOn = 0 == e ? !0 : !1;}
	}function n(e, t) {
		if (e.addClass("ug-tile"), Y.funcCustomTileHtml) return Y.funcCustomTileHtml(e, t), !1;var i = "";1 == Y.hasImageContainer && (i += "<div class='ug-image-container ug-trans-enabled'>");var n = "ug-thumb-image";(0 == B.tile_enable_image_effect || 1 == B.tile_image_effect_reverse) && (n += " ug-trans-enabled");var r = Q.stripTags(t.title);r = Q.htmlentitles(r), i += '<img src="' + Q.escapeDoubleSlash(t.urlThumb) + "\" alt='" + r + "' class='" + n + "'>", 1 == Y.hasImageContainer && (i += "</div>"), e.append(i), B.tile_size_by == R.sizeby.GLOBAL_RATIO && e.fadeTo(0, 0);var o = {};if (1 == B.tile_enable_background && (o["background-color"] = B.tile_background_color), 1 == B.tile_enable_border && (o["border-width"] = B.tile_border_width + "px", o["border-style"] = "solid", o["border-color"] = B.tile_border_color, B.tile_border_radius && (o["border-radius"] = B.tile_border_radius + "px")), 1 == B.tile_enable_outline && (o.outline = "1px solid " + B.tile_outline_color), 1 == B.tile_enable_shadow) {
			var a = B.tile_shadow_h + "px ";a += B.tile_shadow_v + "px ", a += B.tile_shadow_blur + "px ", a += B.tile_shadow_spread + "px ", a += B.tile_shadow_color, o["box-shadow"] = a;
		}e.css(o);var s = "";if (B.tile_enable_icons) {
			if (0 == B.tile_as_link && 1 == B.tile_enable_action) {
				var l = "ug-button-play ug-icon-zoom";"image" != t.type && (l = "ug-button-play ug-icon-play"), s += "<div class='ug-tile-icon " + l + "' style='display:none'></div>";
			}if (t.link && 1 == B.tile_show_link_icon || 1 == B.tile_as_link) if (0 == B.tile_as_link) {
				var u = "";1 == B.tile_link_newpage && (u = " target='_blank'"), s += "<a href='" + t.link + "'" + u + " class='ug-tile-icon ug-icon-link'></a>";
			} else s += "<div class='ug-tile-icon ug-icon-link' style='display:none'></div>";var _ = Y.isSaparateIcons;if (0 == _ && "image" != t.type && 1 == Y.isVideoplayIconAlwaysOn && (_ = !0), _) var g = e;else var g = e.children(".ug-thumb-overlay");g.append(s);var c = g.children("." + l);0 == c.length ? c = null : c.hide();var h = g.children(".ug-icon-link");0 == h.length ? h = null : h.hide(), h || 1 != B.tile_enable_action || e.addClass("ug-tile-clickable");
		} else 1 == B.tile_enable_action && e.addClass("ug-tile-clickable");if (1 == B.tile_enable_image_effect) {
			var p = "";0 == B.tile_image_effect_reverse && (p = " ug-trans-enabled");var f = "<div class='ug-tile-image-overlay" + p + "' >",
			    m = " ug-" + B.tile_image_effect_type + "-effect";f += '<img src="' + Q.escapeDoubleSlash(t.urlThumb) + "\" alt='" + t.title + "' class='" + m + p + "'>", f += "</div>", e.append(f), 1 == B.tile_image_effect_reverse && e.children(".ug-tile-image-overlay").fadeTo(0, 0);
		}if (1 == B.tile_enable_textpanel) {
			var v = new UGTextPanel();v.init(D, B, "tile");var b = "";(1 == B.tile_textpanel_always_on || 1 == Y.isTextpanelOutside) && (b = "ug-trans-enabled"), v.appendHTML(e, b);var y = t.title,
			    I = "";switch (B.tile_textpanel_source) {case "desc":case "description":
					y = t.description;break;case "desc_title":
					"" != t.description && (y = t.description);break;case "title_and_desc":
					y = t.title, I = t.description;}if (v.setTextPlain(y, I), 0 == B.tile_textpanel_always_on && v.getElement().fadeTo(0, 0), e.data("objTextPanel", v), 1 == B.tile_textpanel_always_on) {
				var w = d(e);w.css("z-index", 2);
			}if (1 == Y.isTextpanelOutside) {
				var E = "<div class='ug-tile-cloneswrapper'></div>";e.append(E);var T = e.children(".ug-tile-cloneswrapper"),
				    S = new UGTextPanel();S.init(D, B, "tile"), S.appendHTML(T), S.setTextPlain(y, I), e.data("objTextPanelClone", S);
			}
		}null !== t.addHtml && e.append(t.addHtml);
	}function r(e) {
		var t = e.children(".ug-tile-image-overlay");return t;
	}function o(e) {
		var t = e.children(".ug-thumb-overlay");return t;
	}function a(e) {
		if (0 == Y.hasImageContainer) return null;var t = e.children(".ug-image-container");return t;
	}function s(e) {
		var t = e.find(".ug-tile-image-overlay img");return t;
	}function l(e) {
		var t = e.data("objTextPanel");return t;
	}function u(e) {
		var t = e.data("objTextPanelClone");return t;
	}function d(e) {
		var t = e.children(".ug-textpanel");return t;
	}function _(e) {
		var t = e.find(".ug-tile-cloneswrapper .ug-textpanel");if (0 == t.length) throw new Error("text panel cloned element not found");return t;
	}function g(e) {
		if (1 == Y.isTextpanelOutside) var t = _(e);else var t = d(e);if (!t) return 0;var i = Q.getElementSize(t);return i.height;
	}function c(e) {
		var t = e.find(".ug-icon-link");return 0 == t.length ? null : t;
	}function h(e) {
		var t = Y.ratioByHeight;switch (B.tile_size_by) {default:
				t = Y.ratioByHeight;break;case R.sizeby.IMAGE_RATIO:
				if (!e) throw new Error("tile should be given for tile ratio");var i = R.getItemByTile(e);if ("undefined" != typeof i.thumbRatioByHeight) {
					if (0 == i.thumbRatioByHeight) throw trace(i), new Error("the item ratio not inited yet");t = i.thumbRatioByHeight;
				}break;case R.sizeby.CUSTOM:
				return null;}return t;
	}function p(e) {
		var t = e.find(".ug-button-play");return 0 == t.length ? null : t;
	}function f(e) {
		return e.hasClass("ug-thumb-over") ? !0 : !1;
	}function m(e) {
		return e.hasClass("ug-tile-clickable");
	}function v(e) {
		return 1 == B.tile_enable_icons && 1 == Y.isVideoplayIconAlwaysOn && "image" != e.type ? !0 : !1;
	}function b(e, t, i, n) {
		var o = r(e),
		    l = R.getTileImage(e),
		    u = s(e);t -= Y.tileInnerReduce, i -= Y.tileInnerReduce;var d = null;if (1 == Y.isTextpanelOutside) {
			var _ = g(e);if (i -= _, "top" == B.tile_textpanel_position && (d = _), 1 == Y.hasImageContainer) {
				var c = a(e);Q.setElementSize(c, t, i), null !== d && Q.placeElement(c, 0, d);
			}
		}if (0 == B.tile_enable_image_effect) Q.scaleImageCoverParent(l, t, i), 0 == Y.hasImageContainer && null !== d && Q.placeElement(l, 0, d);else {
			var h = "nothing";n === !0 && 0 == Y.isTextpanelOutside && (h = 1 == B.tile_image_effect_reverse ? "effect" : "image"), "effect" != h && (Q.setElementSize(o, t, i), null !== d && Q.placeElement(o, 0, d), Q.scaleImageCoverParent(u, t, i)), "image" != h && (1 == Y.hasImageContainer ? Q.scaleImageCoverParent(l, t, i) : "effect" == h ? (Q.scaleImageCoverParent(l, t, i), null !== d && Q.placeElement(l, 0, d)) : Q.cloneElementSizeAndPos(u, l, !1, null, d));
		}
	}function y(e, t, i, n) {
		var r = null;if (i && (r = i - Y.tileInnerReduce), n && (n -= Y.tileInnerReduce), "clone" == t) {
			var o = u(e);o.refresh(!0, !0, r);var a = R.getItemByTile(e);return a.textPanelCloneSizeSet = !0, !1;
		}var s = l(e);if (!s) return !1;var d = null;1 == Y.isTextpanelOutside && (d = g(e)), s.refresh(!1, !0, r, d);var _ = 1 == B.tile_textpanel_always_on || "fade" == B.tile_textpanel_appear_type;if (_) if (1 == Y.isTextpanelOutside && n && "bottom" == B.tile_textpanel_position) {
			var c = n - d;s.positionPanel(c);
		} else s.positionPanel();
	}function I(e) {
		var t = (R.getItemByTile(e), p(e)),
		    i = c(e),
		    n = Q.getElementSize(e);b(e, n.width, n.height), 1 == B.tile_enable_textpanel && y(e, "regular", n.width, n.height);var r = n.width - Y.tileInnerReduce,
		    a = n.height - Y.tileInnerReduce,
		    s = 0;if (1 == Y.isTextpanelOutside) {
			var l = g(e);a -= l, "top" == B.tile_textpanel_position && (s = l);
		}var u = o(e);if (Q.setElementSizeAndPosition(u, 0, s, r, a), t || i) {
			var _ = 0;if (1 == B.tile_enable_textpanel && 0 == Y.isTextPanelHidden && 0 == Y.isTextpanelOutside) {
				var h = d(e),
				    f = Q.getElementSize(h);f.height > 0 && (_ = Math.floor(f.height / 2 * -1));
			}
		}if (t && i) {
			var m = Q.getElementSize(t),
			    v = Q.getElementSize(i),
			    I = B.tile_space_between_icons,
			    w = m.width + I + v.width,
			    E = Math.floor((n.width - w) / 2);I > E && (I = Math.floor((n.width - m.width - v.width) / 3), w = m.width + I + v.width, E = Math.floor((n.width - w) / 2)), Q.placeElement(t, E, "middle", 0, _), Q.placeElement(i, E + m.width + I, "middle", 0, _);
		} else t && Q.placeElement(t, "center", "middle", 0, _), i && Q.placeElement(i, "center", "middle", 0, _);t && t.show(), i && i.show();
	}function w(e, t) {
		var i = (R.getItemByTile(e), r(e)),
		    n = B.thumb_transition_duration;if (0 == B.tile_image_effect_reverse) {
			var o = R.getTileImage(e);t ? (o.fadeTo(0, 1), i.stop(!0).fadeTo(n, 0)) : i.stop(!0).fadeTo(n, 1);
		} else t ? i.stop(!0).fadeTo(n, 1) : i.stop(!0).fadeTo(n, 0);
	}function E(e, t) {
		var i = B.thumb_transition_duration,
		    n = d(e);if (!n) return !0;if ("slide" == B.tile_textpanel_appear_type) {
			var r = Q.getElementSize(n);if (0 == r.width) return !1;var o = -r.height,
			    a = 0,
			    s = {},
			    l = {},
			    u = "bottom";"inside_top" == B.tile_textpanel_position && (u = "top"), s[u] = o + "px", l[u] = a + "px", 1 == t ? (n.fadeTo(0, 1), 0 == n.is(":animated") && n.css(s), l.opacity = 1, n.stop(!0).animate(l, i)) : n.stop(!0).animate(s, i);
		} else 1 == t ? n.stop(!0).fadeTo(i, 1) : n.stop(!0).fadeTo(i, 0);
	}function T(e, t, i) {
		var n = B.thumb_transition_duration;i && i === !0 && (n = 0);var r = p(e),
		    o = c(e),
		    a = t ? 1 : 0;r && r.stop(!0).fadeTo(n, a), o && o.stop(!0).fadeTo(n, a);
	}function S(e, t) {
		if (t = jQuery(t), B.tile_enable_image_effect && w(t, !0), 1 == B.tile_enable_textpanel && 0 == B.tile_textpanel_always_on && 0 == Y.isTextPanelHidden && E(t, !0), Y.isSaparateIcons && 1 == B.tile_enable_icons) {
			var i = 1 == B.thumb_overlay_reverse,
			    n = R.getItemByTile(t);0 == v(n) && T(t, i, !1);
		}
	}function P(e, t) {
		if (t = jQuery(t), B.tile_enable_image_effect && w(t, !1), 1 == B.tile_enable_textpanel && 0 == B.tile_textpanel_always_on && E(t, !1), 1 == Y.isSaparateIcons && 1 == B.tile_enable_icons) {
			var i = 1 == B.thumb_overlay_reverse ? !1 : !0,
			    n = R.getItemByTile(t);0 == v(n) ? T(t, i, !1) : T(t, !0, !0);
		}
	}function x(e) {
		var t = W.getThumbs().not(e);t.each(function (e, t) {
			W.setThumbNormalStyle(jQuery(t));
		});
	}function j(e, t, i) {
		return t = jQuery(t), 1 == B.tile_visible_before_image && t.data("image_placed") !== !0 && i !== !0 ? !0 : (I(t), void W.setThumbNormalStyle(t));
	}function C(e, t, i) {
		I(t), i.fadeTo(0, 1), t.data("image_placed", !0);
	}function A(e) {
		return 1 == m(e) ? (G.trigger(R.events.TILE_CLICK, e), !0) : void (0 == f(e) && (x(e), W.setThumbOverStyle(e)));
	}function M(e) {
		var t = jQuery(this),
		    i = t.prop("tagName").toLowerCase(),
		    n = !0;if (Y.funcParentApproveClick && 0 == Y.funcParentApproveClick() && (n = !1), "a" == i) 0 == n && e.preventDefault();else if (0 == f(t)) 1 == n && A(t);else {
			if (0 == m(t)) return !0;1 == n && G.trigger(R.events.TILE_CLICK, t);
		}
	}function O(e) {
		e.stopPropagation();var t = jQuery(this).parents(".ug-tile"),
		    i = !0;return Y.funcParentApproveClick && 0 == Y.funcParentApproveClick() && (i = !1), 0 == f(t) ? (A(t), !0) : 1 == i ? (G.trigger(R.events.TILE_CLICK, t), !1) : void 0;
	}function z(e) {
		var t = jQuery(this).parents(".ug-tile");Y.funcParentApproveClick && 0 == Y.funcParentApproveClick() && e.preventDefault(), 0 == f(t) && 0 == B.tile_as_link && (e.preventDefault(), A(t));
	}var L,
	    H,
	    N,
	    k,
	    R = this,
	    G = jQuery(this),
	    D = new UniteGalleryMain(),
	    Q = new UGFunctions(),
	    W = new UGThumbsGeneral();this.resizemode = { FULL: "full", WRAPPER_ONLY: "wrapper_only", VISIBLE_ELEMENTS: "visible_elements" }, this.sizeby = { GLOBAL_RATIO: "global_ratio", TILE_RATIO: "tile_ratio", IMAGE_RATIO: "image_ratio", CUSTOM: "custom" }, this.events = { TILE_CLICK: "tile_click" };var B = { tile_width: 250, tile_height: 200, tile_size_by: R.sizeby.IMAGE_RATIO, tile_visible_before_image: !1, tile_enable_background: !0, tile_background_color: "#F0F0F0", tile_enable_border: !1, tile_border_width: 3, tile_border_color: "#F0F0F0", tile_border_radius: 0, tile_enable_outline: !1, tile_outline_color: "#8B8B8B", tile_enable_shadow: !1, tile_shadow_h: 1, tile_shadow_v: 1, tile_shadow_blur: 3, tile_shadow_spread: 2, tile_shadow_color: "#8B8B8B", tile_enable_action: !0, tile_as_link: !1, tile_link_newpage: !0, tile_enable_overlay: !0, tile_overlay_opacity: .4, tile_overlay_color: "#000000", tile_enable_icons: !0, tile_show_link_icon: !1, tile_videoplay_icon_always_on: "never", tile_space_between_icons: 26, tile_enable_image_effect: !1, tile_image_effect_type: "bw", tile_image_effect_reverse: !1, tile_enable_textpanel: !1, tile_textpanel_source: "title", tile_textpanel_always_on: !1, tile_textpanel_appear_type: "slide", tile_textpanel_position: "inside_bottom", tile_textpanel_offset: 0 },
	    F = { thumb_color_overlay_effect: !0, thumb_overlay_reverse: !0, thumb_image_overlay_effect: !1, tile_textpanel_enable_description: !1, tile_textpanel_bg_opacity: .6, tile_textpanel_padding_top: 8, tile_textpanel_padding_bottom: 8 },
	    Y = { ratioByHeight: 0, ratioByWidth: 0, eventSizeChange: "thumb_size_change", funcCustomTileHtml: null, funcCustomPositionElements: null, funcParentApproveClick: null, isSaparateIcons: !1, tileInnerReduce: 0, isTextpanelOutside: !1, hasImageContainer: !1, isVideoplayIconAlwaysOn: !1, isTextPanelHidden: !1 };this.loadTileImage = function (e) {
		var t = R.getTileImage(e);Q.checkImagesLoaded(t, null, function (t, i) {
			C(null, e, jQuery(t));
		});
	}, this.setHtml = function (e, t) {
		H = e, t !== !0 && i(), W.setHtmlThumbs(e, t);
	}, this.initEvents = function () {
		W.initEvents(), jQuery(W).on(W.events.SETOVERSTYLE, S), jQuery(W).on(W.events.SETNORMALSTYLE, P), jQuery(W).on(W.events.PLACEIMAGE, C), N.on(Y.eventSizeChange, j), H.on("click", ".ug-tile", M), H.on("click", ".ug-tile .ug-button-play", O), H.on("click", ".ug-tile .ug-icon-link", z);
	}, this.destroy = function () {
		if (H.off("click", ".ug-tile"), H.off("click", ".ug-tile .ug-button-play"), H.off("click", ".ug-tile .ug-icon-link"), jQuery(W).off(W.events.SETOVERSTYLE), jQuery(W).off(W.events.SETNORMALSTYLE), jQuery(W).off(W.events.PLACEIMAGE), N.off(Y.eventSizeChange), 1 == B.tile_enable_textpanel) {
			var e = W.getThumbs();jQuery.each(e, function (e, t) {
				var i = l(jQuery(t));i && i.destroy();
			});
		}W.destroy();
	}, this.init = function (t, i, n) {
		e(t, i, n);
	}, this.setFixedMode = function () {
		B.tile_size_by = R.sizeby.GLOBAL_RATIO, B.tile_visible_before_image = !0;
	}, this.setApproveClickFunction = function (e) {
		Y.funcParentApproveClick = e;
	}, this.resizeTile = function (e, t, i, n) {
		if (1 == Y.isTextpanelOutside && y(e, "clone", t), t) {
			if (!i) var i = R.getTileHeightByWidth(t, e);
		} else var t = B.tile_width,
		    i = B.tile_height;switch (Q.setElementSize(e, t, i), n) {default:case R.resizemode.FULL:
				R.triggerSizeChangeEvent(e, !0);break;case R.resizemode.WRAPPER_ONLY:
				return !0;case R.resizemode.VISIBLE_ELEMENTS:
				if (Y.funcCustomTileHtml) return R.triggerSizeChangeEvent(e, !0), !0;b(e, t, i, !0), 1 == B.tile_enable_textpanel && 1 == B.tile_textpanel_always_on && t && y(e, "regular", t, i);}
	}, this.resizeAllTiles = function (e, t, n) {
		i();var r = null;if (B.tile_size_by == R.sizeby.GLOBAL_RATIO && (r = R.getTileHeightByWidth(e)), !n) var n = W.getThumbs();n.each(function (i, n) {
			R.resizeTile(jQuery(n), e, r, t);
		});
	}, this.triggerSizeChangeEvent = function (e, t) {
		if (!e) return !1;if (!t) var t = !1;N.trigger(Y.eventSizeChange, [e, t]);
	}, this.triggerSizeChangeEventAllTiles = function (e) {
		var t = W.getThumbs();t.each(function () {
			var t = jQuery(this);R.triggerSizeChangeEvent(t, e);
		});
	}, this.disableEvents = function () {
		var e = W.getThumbs();e.css("pointer-events", "none");
	}, this.enableEvents = function () {
		var e = W.getThumbs();e.css("pointer-events", "auto");
	}, this.setOptions = function (e) {
		B = jQuery.extend(B, e), W.setOptions(e);
	}, this.setTileSizeOptions = function (e) {
		if (B.tile_size_by !== R.sizeby.GLOBAL_RATIO) throw new Error("setNewTileOptions works with global ration only");B.tile_width = e, B.tile_height = Math.floor(e * Y.ratioByHeight);
	}, this.setCustomFunctions = function (e, t) {
		Y.funcCustomTileHtml = e, Y.funcCustomPositionElements = t;
	}, this.run = function (e) {
		var t = W.type.GET_THUMBS_ALL;e === !0 && (t = W.type.GET_THUMBS_NEW);var i = W.getThumbs(t);B.tile_size_by == R.sizeby.GLOBAL_RATIO && R.resizeAllTiles(B.tile_width, R.resizemode.WRAPPER_ONLY, i), 1 == B.tile_enable_image_effect && 0 == B.tile_image_effect_reverse && i.children(".ug-thumb-image").fadeTo(0, 0), W.setHtmlProperties(i), 1 == B.tile_visible_before_image && (i.children(".ug-thumb-image").fadeTo(0, 0), W.loadThumbsImages());
	}, this._____________EXTERNAL_GETTERS____________ = function () {}, this.getObjThumbs = function () {
		return W;
	}, this.getOptions = function () {
		return B;
	}, this.getTileImage = function (e) {
		var t = e.find("img.ug-thumb-image");return t;
	}, this.getItemByTile = function (e) {
		return W.getItemByThumb(e);
	}, this.getTileHeightByWidth = function (e, t) {
		var i = h(t);if (null === i) return null;var n = Math.floor((e - Y.tileInnerReduce) * i) + Y.tileInnerReduce;return t && 1 == Y.isTextpanelOutside && B.tile_size_by == R.sizeby.IMAGE_RATIO && (n += g(t)), n;
	}, this.getTileImageSize = function (e) {
		var t = R.getItemByTile(e);if (!t.thumbWidth || !t.thumbHeight) throw new Error("Can't get image size - image not inited.");var i = { width: t.thumbWidth, height: t.thumbHeight };return i;
	}, this.getGlobalTileSize = function () {
		if (B.tile_size_by != R.sizeby.GLOBAL_RATIO) throw new Error("The size has to be global ratio");var e = { width: B.tile_width, height: B.tile_height };return e;
	};
}function UGAviaControl() {
	function e(e) {
		return 0 == p ? e.pageX : e.pageY;
	}function t(t) {
		jQuery("body").on("touchstart", function (e) {
			return 0 == f.isControlEnabled ? !0 : void (f.touchEnabled = !0);
		}), jQuery("body").mousemove(function (t) {
			if (0 == f.isControlEnabled) return !0;if (1 == f.touchEnabled) return jQuery("body").off("mousemove"), !0;f.isMouseInsideStrip = g.ismouseover();var i = u.isTouchMotionActive();if (1 == f.isMouseInsideStrip && 0 == i) {
				var n = e(t);l(n);
			} else a();
		});
	}function i(e) {
		var t = h.strip_padding_top,
		    i = (h.strip_padding_bottom, g.height()),
		    n = c.height();if (i > n) return null;var r = g.offset(),
		    o = r.top,
		    a = e - o - t;if (0 > a) return null;var s = h.thumb_height,
		    l = i - h.thumb_height,
		    u = l - s;s > a && (a = s), a > l && (a = l);var d = (a - s) / u,
		    _ = (n - i) * d;return _ = -1 * Math.round(_) + t;
	}function n(e) {
		var t = h.strip_padding_left,
		    i = h.strip_padding_right,
		    n = g.width() - t - i,
		    r = c.width();if (n > r) return null;var o = g.offset(),
		    a = o.left,
		    s = e - a - t,
		    l = h.thumb_width,
		    u = n - h.thumb_width,
		    d = u - l;l > s && (s = l), s > u && (s = u);var _ = (s - l) / d,
		    p = (r - n) * _;return p = -1 * Math.round(p) + t;
	}function r() {
		if (0 == f.is_strip_moving) return !1;var e = u.getInnerStripPos();Math.floor(e) == Math.floor(f.strip_finalPos) && a();var t,
		    i = Math.abs(f.strip_finalPos - e);1 > i ? t = i : (t = i / 4, t > 0 && 1 > t && (t = 1)), f.strip_finalPos < e && (t = -1 * t);var n = e + t;u.positionInnerStrip(n);
	}function o() {
		return 1 == f.isStripMoving ? !1 : (f.isStripMoving = !0, void (f.handle_timeout = setInterval(r, 10)));
	}function a() {
		return 0 == f.isStripMoving ? !1 : (f.isStripMoving = !1, void (f.handle_timeout = clearInterval(f.handle_timeout)));
	}function s(e) {
		return 0 == p ? n(e) : i(e);
	}function l(e) {
		var t = s(e);return null === t ? !1 : (f.is_strip_moving = !0, f.strip_finalPos = t, void o());
	}var u,
	    d,
	    _,
	    g,
	    c,
	    h,
	    p,
	    f = { touchEnabled: !1, isMouseInsideStrip: !1, strip_finalPos: 0, handle_timeout: "", isStripMoving: !1, isControlEnabled: !0 };this.enable = function () {
		f.isControlEnabled = !0;
	}, this.disable = function () {
		f.isControlEnabled = !1;
	}, this.init = function (e) {
		u = e, _ = e.getObjects(), d = _.g_gallery, g = _.g_objStrip, c = _.g_objStripInner, h = _.g_options, p = _.isVertical, t();
	}, this.destroy = function () {
		jQuery("body").off("touchstart"), jQuery("body").off("mousemove");
	};
}function UGSlider() {
	function e(e, t, n) {
		me = e, n && (he = n, t = we.convertCustomPrefixOptions(t, he, "slider")), te = jQuery(e);var r = me.getObjects();if (ie = r.g_objWrapper, ne = r.g_objThumbs, t.hasOwnProperty("slider_progress_indicator_type") && (Se.slider_progress_indicator_type = t.slider_progress_indicator_type), "bar" == Se.slider_progress_indicator_type && (Se = jQuery.extend(Se, Pe)), t && pe.setOptions(t), i(), 1 == Se.slider_enable_bullets) {
			ye = new UGBullets();var o = { bullets_skin: Se.slider_bullets_skin, bullets_space_between: Se.slider_bullets_space_between };ye.init(me, o);
		}Se.slider_enable_text_panel && (Te = new UGTextPanel(), Te.init(me, Se, "slider")), Se.slider_enable_zoom_panel && (ce = new UGZoomButtonsPanel(), ce.init(pe, Se));var a = me.getGalleryID();Ie.init(Se, !1, a);
	}function t() {
		if (1 == xe.isRunOnce) return !1;if (xe.isRunOnce = !0, Se.slider_background_color) {
			var e = Se.slider_background_color;1 != Se.slider_background_opacity && (e = we.convertHexToRGB(e, Se.slider_background_opacity)), re.css("background-color", e);
		} else 1 != Se.slider_background_opacity && (e = we.convertHexToRGB("#000000", Se.slider_background_opacity), re.css("background-color", e));1 == Se.slider_control_swipe && (_e = new UGTouchSliderControl(), _e.init(pe, Se)), 1 == Se.slider_control_zoom && (ge = new UGZoomSliderControl(), ge.init(pe, Se)), Te && Te.run(), X();
	}function i() {
		var e = me.getOptions(),
		    t = e.gallery_skin;"" == Se.slider_bullets_skin && (Se.slider_bullets_skin = t), "" == Se.slider_arrows_skin && (Se.slider_arrows_skin = t), "" == Se.slider_zoompanel_skin && (Se.slider_zoompanel_skin = t), "" == Se.slider_play_button_skin && (Se.slider_play_button_skin = t), "" == Se.slider_fullscreen_button_skin && (Se.slider_fullscreen_button_skin = t), Se.video_enable_closebutton = Se.slider_video_enable_closebutton, "zoom" != e.gallery_mousewheel_role && (Se.slider_zoom_mousewheel = !1);
	}function n(e, t) {
		var i = "ug-type-square";"round" == Se.slider_videoplay_button_type && (i = "ug-type-round");var n = "";return n += "<div class='ug-slide-wrapper ug-slide" + t + "'>", n += "<div class='ug-item-wrapper'></div>", n += "<div class='ug-slider-preloader " + e + "'></div>", n += "<div class='ug-button-videoplay " + i + "' style='display:none'></div>", n += "</div>";
	}function r(e) {
		e && (ie = e);var t = Z(),
		    i = (me.getOptions(), "<div class='ug-slider-wrapper'>");if (i += "<div class='ug-slider-inner'>", i += n(t, 1), i += n(t, 2), i += n(t, 3), i += "</div>", 1 == Se.slider_enable_arrows && (i += "<div class='ug-slider-control ug-arrow-left ug-skin-" + Se.slider_arrows_skin + "'></div>", i += "<div class='ug-slider-control ug-arrow-right ug-skin-" + Se.slider_arrows_skin + "'></div>"), 1 == Se.slider_enable_play_button && (i += "<div class='ug-slider-control ug-button-play ug-skin-" + Se.slider_play_button_skin + "'></div>"), 1 == Se.slider_enable_fullscreen_button && (i += "<div class='ug-slider-control ug-button-fullscreen ug-skin-" + Se.slider_fullscreen_button_skin + "'></div>"), i += "</div>", ie.append(i), re = ie.children(".ug-slider-wrapper"), oe = re.children(".ug-slider-inner"), ae = oe.children(".ug-slide1"), se = oe.children(".ug-slide2"), le = oe.children(".ug-slide3"), ae.data("slidenum", 1), se.data("slidenum", 2), le.data("slidenum", 3), ye && ye.appendHTML(re), 1 == Se.slider_enable_arrows && (ue = re.children(".ug-arrow-left"), de = re.children(".ug-arrow-right")), 1 == Se.slider_enable_play_button && (ve = re.children(".ug-button-play")), 1 == Se.slider_enable_fullscreen_button && (be = re.children(".ug-button-fullscreen")), 1 == Se.slider_enable_progress_indicator) {
			Ee = we.initProgressIndicator(Se.slider_progress_indicator_type, Se, re);var r = Ee.getType();"bar" == r && "pie" == Se.slider_progress_indicator_type && (Se.slider_progress_indicator_type = "bar", Se = jQuery.extend(Se, Pe)), me.setProgressIndicator(Ee);
		}if (1 == Se.slider_enable_text_panel && (Te.appendHTML(re), 0 == Se.slider_textpanel_always_on)) {
			var o = Te.getElement();o.hide().data("isHidden", !0), xe.isTextPanelSaparateHover = !0;
		}1 == Se.slider_enable_zoom_panel && ce.appendHTML(re), Ie.setHtml(oe);
	}function o(e) {
		var t = J(e);we.placeElementInParentCenter(t);var i = $(e);we.placeElementInParentCenter(i);
	}function a() {
		if (ye && (objBullets = ye.getElement(), we.placeElement(objBullets, Se.slider_bullets_align_hor, Se.slider_bullets_align_vert, Se.slider_bullets_offset_hor, Se.slider_bullets_offset_vert), we.placeElement(objBullets, Se.slider_bullets_align_hor, Se.slider_bullets_align_vert, Se.slider_bullets_offset_hor, Se.slider_bullets_offset_vert)), 1 == Se.slider_enable_arrows && (we.placeElement(ue, Se.slider_arrow_left_align_hor, Se.slider_arrow_left_align_vert, Se.slider_arrow_left_offset_hor, Se.slider_arrow_left_offset_vert), we.placeElement(de, Se.slider_arrow_right_align_hor, Se.slider_arrow_left_align_vert, Se.slider_arrow_right_offset_hor, Se.slider_arrow_right_offset_vert)), 0 == Se.slider_controls_always_on && M(!0), Ee) {
			var e = Ee.getElement();if ("bar" == Se.slider_progress_indicator_type) {
				var t = re.width();Ee.setSize(t), we.placeElement(e, "left", Se.slider_progress_indicator_align_vert, 0, Se.slider_progress_indicator_offset_vert);
			} else we.placeElement(e, Se.slider_progress_indicator_align_hor, Se.slider_progress_indicator_align_vert, Se.slider_progress_indicator_offset_hor, Se.slider_progress_indicator_offset_vert);
		}Te && Te.positionPanel(), s(), o(ae), o(se), o(le), C();
	}function s() {
		if (ve && we.placeElement(ve, Se.slider_play_button_align_hor, Se.slider_play_button_align_vert, Se.slider_play_button_offset_hor, Se.slider_play_button_offset_vert), be && we.placeElement(be, Se.slider_fullscreen_button_align_hor, Se.slider_fullscreen_button_align_vert, Se.slider_fullscreen_button_offset_hor, Se.slider_fullscreen_button_offset_vert), ce) {
			var e = ce.getElement();we.placeElement(e, Se.slider_zoompanel_align_hor, Se.slider_zoompanel_align_vert, Se.slider_zoompanel_offset_hor, Se.slider_zoompanel_offset_vert);
		}
	}function l() {
		var e,
		    t,
		    i,
		    n,
		    r = pe.getSlidesReference(),
		    o = 0,
		    a = 0,
		    s = 0;i = pe.isSlideHasItem(r.objNextSlide), n = pe.isSlideHasItem(r.objPrevSlide), n ? (s = r.objPrevSlide.outerWidth(), r.objPrevSlide.css("z-index", 1)) : r.objPrevSlide.hide(), t = s + r.objCurrentSlide.outerWidth(), e = t, i ? (e = t + r.objNextSlide.outerWidth(), r.objPrevSlide.css("z-index", 2)) : r.objNextSlide.hide(), r.objCurrentSlide.css("z-index", 3), we.placeElement(r.objCurrentSlide, s, o), oe.css({ left: -s + "px", width: e + "px" }), n && (we.placeElement(r.objPrevSlide, a, o), we.showElement(r.objPrevSlide)), i && (we.showElement(r.objNextSlide), we.placeElement(r.objNextSlide, t, o));
	}function u(e) {
		var t = e.data("index");if (void 0 === t || null == t) return !1;var i = me.getItem(t);return i ? void f(e, i) : !1;
	}function d(e) {
		e.stop(!0).show(100);
	}function _(e) {
		e.stop(!0).hide(100);
	}function g(e, t) {
		var i = Se.slider_image_border_width;if (10 >= i) return i;var n = we.getElementSize(e),
		    r = n.width,
		    o = n.height;if (t && (t.hasOwnProperty("imageWidth") && (r = t.imageWidth), t.hasOwnProperty("imageHeight") && (o = t.imageHeight)), 0 >= r) return i;var a = o > r ? r : o,
		    s = 2 * i,
		    l = s / a;if (l < Se.slider_image_border_maxratio) return i;var i = a * Se.slider_image_border_maxratio / 2;return i = Math.round(i);
	}function c(e, t, i) {
		var n = {};if (1 == Se.slider_image_border) {
			n["border-style"] = "solid";var r = g(e, i);n["border-width"] = r + "px", n["border-color"] = Se.slider_image_border_color, n["border-radius"] = Se.slider_image_border_radius;
		}"image" != t && 1 == Se.slider_video_constantsize && (n["background-color"] = "#000000"), 1 == Se.slider_image_shadow && (n["box-shadow"] = "3px 3px 10px 0px #353535"), e.css(n);
	}function h(e, t) {
		var i = Se.slider_video_constantsize_width,
		    n = Se.slider_video_constantsize_height,
		    r = Se.slider_video_constantsize_scalemode,
		    o = we.scaleImageExactSizeInParent(e, t.imageWidth, t.imageHeight, i, n, r);return o;
	}function p(e, t, i) {
		var n = e.children(".ug-item-wrapper"),
		    r = J(e);if ("undefined" == typeof t.urlImage || "" == t.urlImage) throw new Error("The slide don't have big image defined ( data-image='imageurl' ). Please check gallery items.", "showbig");var o = t.urlImage,
		    a = e.data("urlImage");e.data("urlImage", o);var s = pe.getScaleMode(e),
		    l = pe.getSlideType(e);if (objPadding = pe.getObjImagePadding(), a == o && i !== !0) {
			var u = n.children("img");(0 == t.imageWidth || 0 == t.imageHeight) && me.checkFillImageSize(u, t);var g = {};g = "image" != l && 1 == Se.slider_video_constantsize ? h(u, t) : we.scaleImageFitParent(u, t.imageWidth, t.imageHeight, s, objPadding), c(u, l, g), fe.trigger(pe.events.AFTER_PUT_IMAGE, e);
		} else if (u = we.placeImageInsideParent(o, n, t.imageWidth, t.imageHeight, s, objPadding), 1 == t.isBigImageLoaded) {
			if (u.fadeTo(0, 1), _(r), "image" != l && 1 == Se.slider_video_constantsize) var g = h(u, t);else var g = we.getImageInsideParentData(n, t.imageWidth, t.imageHeight, s, objPadding);u.css("width", g.imageWidth + "px"), c(u, l, g), fe.trigger(pe.events.AFTER_PUT_IMAGE, e);
		} else u.fadeTo(0, 0), d(r), e.data("isLoading", !0), pe.isSlideCurrent(e) && fe.trigger(pe.events.CURRENTSLIDE_LOAD_START), u.data("itemIndex", t.index), u.on("load", function () {
			var e = jQuery(this),
			    t = e.data("itemIndex");e.fadeTo(0, 1);var i = e.parent().parent(),
			    n = pe.getSlideType(i),
			    r = J(i),
			    o = pe.getObjImagePadding(),
			    a = pe.getScaleMode(i);_(r), i.data("isLoading", !1), pe.isSlideCurrent(i) && fe.trigger(pe.events.CURRENTSLIDE_LOAD_END), me.onItemBigImageLoaded(null, e);var s = me.getItem(t),
			    l = {};"image" != n && 1 == Se.slider_video_constantsize ? h(e, s) : l = we.scaleImageFitParent(e, s.imageWidth, s.imageHeight, a, o), e.fadeTo(0, 1), c(e, n, l), fe.trigger(pe.events.AFTER_PUT_IMAGE, i);
		});
	}function f(e, t) {
		try {
			var i = e.children(".ug-item-wrapper");if (null == t) return i.html(""), e.removeData("index"), e.removeData("type"), e.removeData("urlImage"), !1;e.data("index");e.data("index", t.index), e.data("type", t.type), 1 == Se.slider_enable_links && "image" == t.type && (t.link ? e.addClass("ug-slide-clickable") : e.removeClass("ug-slide-clickable")), p(e, t);var n = $(e);switch (t.type) {case "image":
					n.hide();break;default:
					n.show();}
		} catch (r) {
			throw "undefined" != typeof r.fileName && "showbig" == r.fileName && me.showErrorMessageReplaceGallery(r.message), i.html(""), new Error(r);
		}
	}function m() {
		if (!Te) return !1;if (1 == b()) return !1;var e = Te.getElement(),
		    t = 0;(1 == xe.isTextPanelSaparateHover || 1 == Se.slider_textpanel_always_on) && (t = Se.slider_controls_appear_duration), e.stop().fadeTo(t, 0), e.data("isHidden", !0);
	}function v() {
		if (!Te) return !1;if (0 == b()) return !1;var e = Te.getElement(),
		    t = 0;(1 == xe.isTextPanelSaparateHover || 1 == Se.slider_textpanel_always_on) && (e.show(), Te.positionElements(), t = Se.slider_controls_appear_duration), e.stop().show().fadeTo(t, 1), e.data("isHidden", !1);
	}function b() {
		var e = Te.getElement(),
		    t = e.data("isHidden");return t === !1 ? !1 : !0;
	}function y(e, t) {
		if (void 0 == t) var t = pe.getCurrentSlide();var i = pe.getSlideType(t);if (i != e) throw new Error("Wrong slide type: " + i + ", should be: " + e);return !0;
	}function I() {
		var e = pe.getCurrentSlide(),
		    t = pe.getSlideImage(e),
		    i = we.getElementSize(e),
		    n = i.left,
		    r = i.top;if (1 == Se.slider_video_constantsize) {
			var o = we.getElementSize(t);n += o.left, r += o.top;
		} else n += Se.slider_video_padding_left, r += Se.slider_video_padding_top;Ie.setPosition(n, r);
	}function w() {
		var e = Se.slider_video_constantsize_width,
		    t = Se.slider_video_constantsize_height;Ie.setSize(e, t);var i = Ie.getObject();c(i, "video");
	}function E(e, t, i) {
		fe.trigger(pe.events.TRANSITION_START);var n = Se.slider_transition;switch (i && (n = i), pe.stopSlideAction(null, !0), n) {default:case "fade":
				P(t);break;case "slide":
				T(e, t);break;case "lightbox_open":
				P(t, !1, !0);}
	}function T(e, t) {
		var i = pe.isAnimating();if (1 == i) return xe.itemWaiting = t, !0;null != xe.itemWaiting && (xe.itemWaiting = null);var n = pe.getSlidesReference();switch (e) {case "right":
				f(n.objPrevSlide, t), l();var r = we.getElementSize(n.objPrevSlide),
				    o = -r.left;pe.switchSlideNums("right");break;case "left":
				f(n.objNextSlide, t), l();var a = we.getElementSize(n.objNextSlide),
				    o = -a.left;pe.switchSlideNums("left");break;default:
				throw new Error("wrong direction: " + e);}var s = Se.slider_transition_speed,
		    u = Se.slider_transition_easing,
		    d = { duration: s, easing: u, queue: !1, always: function always() {
				if (pe.stopSlideAction(), Ie.hide(), null != xe.itemWaiting) {
					var e = K(xe.itemWaiting);T(e, xe.itemWaiting);
				} else pe.placeNabourItems(), fe.trigger(pe.events.TRANSITION_END);
			} };oe.animate({ left: o + "px" }, d);
	}function S(e, t, i) {
		i ? e.fadeTo(Se.slider_transition_speed, t, i) : e.fadeTo(Se.slider_transition_speed, t);
	}function P(e, t, i) {
		if (!t) var t = !1;var n = pe.getSlidesReference();f(n.objNextSlide, e);var r = we.getElementSize(n.objCurrentSlide);we.placeElement(n.objNextSlide, r.left, r.top);var o = xe.numCurrent;if (xe.numCurrent = xe.numNext, xe.numNext = o, fe.trigger(pe.events.ITEM_CHANGED), n.objNextSlide.stop(!0), n.objCurrentSlide.stop(!0), 1 == t) n.objCurrentSlide.fadeTo(0, 0), n.objNextSlide.fadeTo(0, 1), pe.placeNabourItems(), fe.trigger(pe.events.TRANSITION_END), i !== !0 && Ie.hide();else {
			if (n.objNextSlide.fadeTo(0, 0), S(n.objCurrentSlide, 0, function () {
				pe.placeNabourItems(), fe.trigger(pe.events.TRANSITION_END), i !== !0 && Ie.hide();
			}), 1 == Ie.isVisible()) {
				var a = Ie.getObject();S(a, 0);
			}S(n.objNextSlide, 1);
		}
	}function x() {
		1 == Se.slider_fullscreen_button_mobilehide && be && be.hide(), 1 == Se.slider_play_button_mobilehide && ve && ve.hide(), 1 == Se.slider_zoompanel_mobilehide && ce && ce.getElement().hide();
	}function j() {
		1 == Se.slider_fullscreen_button_mobilehide && be && be.show(), 1 == Se.slider_play_button_mobilehide && ve && ve.show(), 1 == Se.slider_zoompanel_mobilehide && ce && ce.getElement().show();
	}function C() {
		var e = me.isMobileMode();e ? x() : j();
	}function A() {
		var e = re.children(".ug-slider-control");return e;
	}function M(e) {
		if (0 == we.isTimePassed("sliderControlsToggle")) return !1;if (0 == xe.isControlsVisible) return !1;if (!e) var e = !1;var t = A();e === !0 ? t.stop().fadeTo(0, 0).hide() : t.stop().fadeTo(Se.slider_controls_appear_duration, 0, function () {
			t.hide();
		}), xe.isControlsVisible = !1;
	}function O(e) {
		if (0 == we.isTimePassed("sliderControlsToggle")) return !1;if (1 == xe.isControlsVisible) return !0;if (!e) var e = !1;var t = A();e === !0 ? t.stop().show() : (t.stop().show().fadeTo(0, 0), t.fadeTo(Se.slider_controls_appear_duration, 1)), xe.isControlsVisible = !0;
	}function z() {
		0 == xe.isControlsVisible ? O() : M();
	}function L(e) {
		if (e == xe.currentControlsMode) return !1;switch (e) {case "image":
				ce && ce.getElement().show();break;case "video":
				ce && ce.getElement().hide();break;default:
				throw new Error("wrong controld mode: " + e);}xe.currentControlsMode = e;
	}function H(e, t, i) {
		var n = me.getSelectedItem();pe.setItem(n, !1, i);var r = n.index;ye && ye.setActive(r), Te && 0 == xe.isTextPanelSaparateHover && v(), L("image" == n.type ? "image" : "video");
	}function N(e, t) {
		me.selectItem(t);
	}function k(e) {
		return _e && 0 == _e.isTapEventOccured(e) ? !0 : void fe.trigger(pe.events.CLICK, e);
	}function R() {
		var e = pe.getCurrentSlide(),
		    t = e.hasClass("ug-slide-clickable"),
		    i = pe.getCurrentItem();return t ? (0 == Se.slider_links_newpage ? location.href = i.link : window.open(i.link, "_blank"), !0) : void (0 == Se.slider_controls_always_on && 1 == Se.slider_controls_appear_ontap && 1 == pe.isCurrentSlideType("image") && (z(), Te && 1 == Se.slider_textpanel_always_on && pe.isCurrentSlideType("image") && pe.isCurrentSlideImageFit() && v()));
	}function G(e) {
		Te && pe.isCurrentSlideType("image") && 0 == pe.isCurrentSlideImageFit() && m();
	}function D() {
		O();
	}function Q() {
		M();
	}function W(e) {
		var t = e.parent();pe.startSlideAction(t);
	}function B() {
		me.isPlayMode() && me.pausePlaying(), fe.trigger(pe.events.ACTION_START);
	}function F() {
		me.isPlayMode() && me.continuePlaying(), fe.trigger(pe.events.ACTION_END);
	}function Y(e, t, i) {
		ae.data("index") == t && (objItem = me.getItem(t), p(ae, objItem, !0)), se.data("index") == t && (objItem = me.getItem(t), p(se, objItem, !0)), le.data("index") == t && (objItem = me.getItem(t), p(le, objItem, !0));
	}function U(e, t) {
		t = jQuery(t);var i = pe.getSlideImage(t),
		    n = $(t),
		    r = we.getElementSize(i);we.placeElement(n, "center", "middle", r.left, r.top, i);
	}function V(e) {
		var t = $(e);we.addClassOnHover(t), we.setButtonOnClick(t, W);
	}function X() {
		te.on(me.events.ITEM_IMAGE_UPDATED, Y), te.on(me.events.ITEM_CHANGE, H), ye && jQuery(ye).on(ye.events.BULLET_CLICK, N), 1 == Se.slider_enable_arrows && (we.addClassOnHover(de, "ug-arrow-hover"), we.addClassOnHover(ue, "ug-arrow-hover"), me.setNextButton(de), me.setPrevButton(ue)), 0 == Se.slider_controls_always_on && re.hover(D, Q), re.on("touchend click", k), fe.on(pe.events.CLICK, R), Te && 1 == xe.isTextPanelSaparateHover && re.hover(v, m), ve && (we.addClassOnHover(ve, "ug-button-hover"), me.setPlayButton(ve)), be && (we.addClassOnHover(be, "ug-button-hover"), me.setFullScreenToggleButton(be)), ge && fe.on(pe.events.ZOOM_CHANGE, G), ce && ce.initEvents(), Ie.initEvents(), jQuery(Ie).on(Ie.events.SHOW, B), jQuery(Ie).on(Ie.events.HIDE, F), V(ae), V(se), V(le), fe.on(pe.events.AFTER_PUT_IMAGE, U), re.on("mouseenter", ".ug-item-wrapper img", function (e) {
			fe.trigger(pe.events.IMAGE_MOUSEENTER);
		}), re.on("mouseleave", ".ug-item-wrapper img", function (e) {
			var t = pe.isMouseInsideSlideImage(e);0 == t && fe.trigger(pe.events.IMAGE_MOUSELEAVE);
		});
	}function Z() {
		var e;switch (Se.slider_loader_type) {default:case 1:
				e = "ug-loader1";break;case 2:
				e = "ug-loader2";break;case 3:
				e = "ug-loader3";break;case 4:
				e = "ug-loader4";break;case 5:
				e = "ug-loader5";break;case 6:
				e = "ug-loader6";break;case 7:
				e = "ug-loader7";break;case 8:
				e = "ug-loader8";break;case 9:
				e = "ug-loader9";}return "black" == Se.slider_loader_color && (e += " ug-loader-black"), e;
	}function q(e) {
		switch (e) {case 1:
				return ae;case 2:
				return se;case 3:
				return le;default:
				throw new Error("wrong num: " + e);}
	}function K(e) {
		var t = pe.getSlidesReference(),
		    i = t.objCurrentSlide.data("index"),
		    n = e.index,
		    r = "left";return i > n && (r = "right"), r;
	}function J(e) {
		if (!e) var e = pe.getCurrentSlide();var t = e.children(".ug-slider-preloader");return t;
	}function $(e) {
		var t = e.children(".ug-button-videoplay");return t;
	}function ee(e) {
		if (!e) var e = pe.getCurrentSlide();var t = e.data("index");if (void 0 == t) return null;var i = me.getItem(t);return i;
	}var te,
	    ie,
	    ne,
	    re,
	    oe,
	    ae,
	    se,
	    le,
	    ue,
	    de,
	    _e,
	    ge,
	    ce,
	    he,
	    pe = this,
	    fe = jQuery(pe),
	    me = new UniteGalleryMain(),
	    ve = null,
	    be = null,
	    ye = null,
	    Ie = new UGVideoPlayer(),
	    we = new UGFunctions(),
	    Ee = null,
	    Te = null;this.events = { ITEM_CHANGED: "item_changed", BEFORE_SWITCH_SLIDES: "before_switch", BEFORE_RETURN: "before_return", AFTER_RETURN: "after_return", ZOOM_START: "slider_zoom_start", ZOOM_END: "slider_zoom_end", ZOOMING: "slider_zooming", ZOOM_CHANGE: "slider_zoom_change", START_DRAG: "start_drag", AFTER_DRAG_CHANGE: "after_drag_change", ACTION_START: "action_start", ACTION_END: "action_end", CLICK: "slider_click", TRANSITION_START: "slider_transition_start", TRANSITION_END: "slider_transition_end", AFTER_PUT_IMAGE: "after_put_image", IMAGE_MOUSEENTER: "slider_image_mouseenter", IMAGE_MOUSELEAVE: "slider_image_mouseleave", CURRENTSLIDE_LOAD_START: "slider_current_loadstart", CURRENTSLIDE_LOAD_END: "slider_current_loadend" };var Se = { slider_scale_mode: "fill", slider_scale_mode_media: "fill", slider_scale_mode_fullscreen: "down", slider_item_padding_top: 0, slider_item_padding_bottom: 0, slider_item_padding_left: 0, slider_item_padding_right: 0, slider_background_color: "", slider_background_opacity: 1, slider_image_padding_top: 0, slider_image_padding_bottom: 0, slider_image_padding_left: 0, slider_image_padding_right: 0, slider_image_border: !1, slider_image_border_width: 10, slider_image_border_color: "#ffffff", slider_image_border_radius: 0, slider_image_border_maxratio: .35, slider_image_shadow: !1, slider_video_constantsize: !1, slider_video_constantsize_scalemode: "fit", slider_video_constantsize_width: 854, slider_video_constantsize_height: 480, slider_video_padding_top: 0, slider_video_padding_bottom: 0, slider_video_padding_left: 0, slider_video_padding_right: 0, slider_video_enable_closebutton: !0, slider_transition: "slide", slider_transition_speed: 300, slider_transition_easing: "easeInOutQuad", slider_control_swipe: !0, slider_control_zoom: !0, slider_zoom_mousewheel: !0, slider_vertical_scroll_ondrag: !1, slider_loader_type: 1, slider_loader_color: "white", slider_enable_links: !0, slider_links_newpage: !1, slider_enable_bullets: !1, slider_bullets_skin: "", slider_bullets_space_between: -1, slider_bullets_align_hor: "center", slider_bullets_align_vert: "bottom", slider_bullets_offset_hor: 0, slider_bullets_offset_vert: 10, slider_enable_arrows: !0, slider_arrows_skin: "", slider_arrow_left_align_hor: "left", slider_arrow_left_align_vert: "middle", slider_arrow_left_offset_hor: 20, slider_arrow_left_offset_vert: 0, slider_arrow_right_align_hor: "right", slider_arrow_right_align_vert: "middle", slider_arrow_right_offset_hor: 20, slider_arrow_right_offset_vert: 0, slider_enable_progress_indicator: !0, slider_progress_indicator_type: "pie", slider_progress_indicator_align_hor: "right", slider_progress_indicator_align_vert: "top", slider_progress_indicator_offset_hor: 10, slider_progress_indicator_offset_vert: 10, slider_enable_play_button: !0, slider_play_button_skin: "", slider_play_button_align_hor: "left", slider_play_button_align_vert: "top", slider_play_button_offset_hor: 40, slider_play_button_offset_vert: 8, slider_play_button_mobilehide: !1, slider_enable_fullscreen_button: !0, slider_fullscreen_button_skin: "", slider_fullscreen_button_align_hor: "left", slider_fullscreen_button_align_vert: "top", slider_fullscreen_button_offset_hor: 11, slider_fullscreen_button_offset_vert: 9, slider_fullscreen_button_mobilehide: !1, slider_enable_zoom_panel: !0, slider_zoompanel_skin: "", slider_zoompanel_align_hor: "left", slider_zoompanel_align_vert: "top", slider_zoompanel_offset_hor: 12, slider_zoompanel_offset_vert: 92, slider_zoompanel_mobilehide: !1, slider_controls_always_on: !1, slider_controls_appear_ontap: !0, slider_controls_appear_duration: 300, slider_enable_text_panel: !0, slider_textpanel_always_on: !0, slider_videoplay_button_type: "square" },
	    Pe = { slider_progress_indicator_align_hor: "left", slider_progress_indicator_align_vert: "bottom", slider_progress_indicator_offset_hor: 0, slider_progress_indicator_offset_vert: 0 },
	    xe = { isRunOnce: !1, isTextPanelSaparateHover: !1, numPrev: 1, numCurrent: 2, numNext: 3, isControlsVisible: !0, currentControlsMode: "image" };this.switchSlideNums = function (e) {
		switch (fe.trigger(pe.events.BEFORE_SWITCH_SLIDES), e) {case "left":
				var t = xe.numCurrent;xe.numCurrent = xe.numNext, xe.numNext = xe.numPrev, xe.numPrev = t;break;case "right":
				var t = xe.numCurrent;xe.numCurrent = xe.numPrev, xe.numPrev = xe.numNext, xe.numNext = t;break;default:
				throw new Error("wrong direction: " + e);}fe.trigger(pe.events.ITEM_CHANGED);
	}, this.destroy = function () {
		fe.off(pe.events.AFTER_PUT_IMAGE), te.off(me.events.ITEM_IMAGE_UPDATED), te.off(me.events.ITEM_CHANGE), ye && jQuery(ye).on(ye.events.BULLET_CLICK), re.off("mouseenter"), re.off("mouseleave"), re.off("touchend"), re.off("click"), fe.off(pe.events.CLICK), ge && fe.off(pe.events.ZOOM_CHANGE), fe.off(pe.events.BEFORE_SWITCH_SLIDES), jQuery(Ie).off(Ie.events.SHOW), jQuery(Ie).off(Ie.events.HIDE), Ie.destroy(), re.off("mouseenter", ".ug-item-wrapper img"), re.off("mouseleave", ".ug-item-wrapper img");
	}, this.________EXTERNAL_GENERAL___________ = function () {}, this.init = function (t, i, n) {
		e(t, i, n);
	}, this.getSlideImage = function (e) {
		if (!e) var e = pe.getCurrentSlide();var t = e.find(".ug-item-wrapper img");return t;
	}, this.setHtml = function (e) {
		r(e);
	}, this.run = function () {
		t();
	}, this.isInnerInPlace = function () {
		var e = pe.getSlidesReference(),
		    t = we.getElementSize(e.objCurrentSlide),
		    i = -t.left,
		    n = we.getElementSize(oe);return i == n.left ? !0 : !1;
	}, this.isAnimating = function () {
		var e = oe.is(":animated");return e;
	}, this.isSlideCurrent = function (e) {
		var t = e.data("slidenum");return xe.numCurrent == t ? !0 : !1;
	}, this.isSlideHasItem = function (e) {
		var t = e.data("index");return void 0 === t || null === t ? !1 : !0;
	}, this.getObjImagePadding = function () {
		var e = { padding_top: Se.slider_image_padding_top, padding_bottom: Se.slider_image_padding_bottom, padding_left: Se.slider_image_padding_left, padding_right: Se.slider_image_padding_right };return e;
	}, this.getSlidesReference = function () {
		var e = { objPrevSlide: q(xe.numPrev), objNextSlide: q(xe.numNext), objCurrentSlide: q(xe.numCurrent) };return e;
	}, this.getCurrentSlide = function () {
		var e = pe.getSlidesReference();return e.objCurrentSlide;
	}, this.getCurrentItemIndex = function () {
		var e = pe.getSlidesReference(),
		    t = e.objCurrentSlide.data("index");return (null === t || void 0 === t) && (t = -1), t;
	}, this.getCurrentItem = function () {
		var e = pe.getCurrentItemIndex();if (-1 == e) return null;var t = me.getItem(e);return t;
	}, this.getSlideType = function (e) {
		void 0 == e && (e = pe.getCurrentSlide());var t = e.data("type");return t;
	}, this.isMouseInsideSlideImage = function (e) {
		var t = pe.getSlideImage(),
		    i = we.getMousePosition(e);void 0 === i.pageX && (i = _e.getLastMousePos());var n = we.getMouseElementPoint(i, t),
		    r = we.getElementSize(t);return isMouseInside = we.isPointInsideElement(n, r), isMouseInside;
	}, this.isCurrentSlideType = function (e) {
		var t = pe.getSlideType();return t == e ? !0 : !1;
	}, this.isCurrentSlideLoadingImage = function () {
		var e = pe.getCurrentSlide(),
		    t = e.data("isLoading");return t === !0 ? !0 : !1;
	}, this.setItem = function (e, t, i) {
		var n = pe.getSlidesReference(),
		    r = n.objCurrentSlide.data("index"),
		    o = e.index;if (o == r) return !0;var a = void 0 == r;if (a) f(n.objCurrentSlide, e), pe.placeNabourItems();else {
			var s = "left";me.getNumItems();"next" == i ? s = "left" : "prev" == i || r > o ? s = "right" : r > o && (s = "right"), E(s, e, t);
		}
	}, this.placeNabourItems = function () {
		var e = pe.getSlidesReference(),
		    t = e.objCurrentSlide.data("index"),
		    i = me.getPrevItem(t),
		    n = me.getNextItem(t);f(e.objNextSlide, n), f(e.objPrevSlide, i), l();
	}, this.________EXTERNAL_API___________ = function () {}, this.stopSlideAction = function (e, t) {
		e || (e = pe.getCurrentSlide()), t === !0 ? Ie.pause() : Ie.hide();
	}, this.startSlideAction = function (e) {
		e || (e = pe.getCurrentSlide());var t = ee(e);if ("image" == t.type) return !0;switch (1 == Se.slider_video_constantsize && w(), I(), Ie.show(), t.type) {case "youtube":
				Ie.playYoutube(t.videoid);break;case "vimeo":
				Ie.playVimeo(t.videoid);break;case "html5video":
				Ie.playHtml5Video(t.videoogv, t.videowebm, t.videomp4, t.urlImage);break;case "soundcloud":
				Ie.playSoundCloud(t.trackid);break;case "wistia":
				Ie.playWistia(t.videoid);}
	}, this.getScaleMode = function (e) {
		if (!e) var e = pe.getCurrentSlide();var t = pe.getSlideType(e);return "image" != t ? Se.slider_scale_mode_media : Se.slider_scale_mode == Se.slider_scale_mode_fullscreen ? Se.slider_scale_mode : 1 == me.isFullScreen() ? Se.slider_scale_mode_fullscreen : Se.slider_scale_mode;
	}, this.getObjects = function () {
		var e = { g_objSlider: re, g_objInner: oe, g_options: Se, g_objZoomSlider: ge };return e;
	}, this.getObjZoom = function () {
		return ge;
	}, this.getOptions = function () {
		return Se;
	}, this.getElement = function () {
		return re;
	}, this.getVideoObject = function () {
		return Ie;
	}, this.isCurrentSlideImageFit = function () {
		var e = pe.getCurrentSlide();pe.getSlideType(e);y("image", e);var t = pe.getSlideImage(e);if (0 == t.length) return !1;var i = we.isImageFitParent(t);return i;
	}, this.isCurrentImageInPlace = function () {
		var e = pe.getSlideImage();if (0 == e.length) return !1;var t = pe.getScaleMode(),
		    i = pe.getObjImagePadding(),
		    n = ee(),
		    r = e.parent(),
		    o = we.getImageInsideParentData(r, n.imageWidth, n.imageHeight, t, i),
		    a = we.getElementSize(e),
		    s = !1;return o.imageWidth == a.width && (s = !0), s;
	}, this.isSlideActionActive = function () {
		return Ie.isVisible();
	}, this.isSwiping = function () {
		if (!_e) return !1;var e = _e.isTouchActive();return e;
	}, this.isPreloading = function () {
		var e = J();return e.is(":visible") ? !0 : !1;
	}, this.setOptions = function (e) {
		he && (e = we.convertCustomPrefixOptions(e, he, "slider")), Se = jQuery.extend(Se, e);
	}, this.setSize = function (e, t) {
		if (0 > e || 0 > t) return !0;var i = {};i.width = e + "px", i.height = t + "px", re.css(i);var n = {};n.height = t + "px", n.top = "0px", n.left = "0px", oe.css(n);var r = {};r.height = t + "px", r.width = e + "px", ae.css(r), se.css(r), le.css(r);var o = e - Se.slider_item_padding_left - Se.slider_item_padding_right,
		    s = t - Se.slider_item_padding_top - Se.slider_item_padding_bottom,
		    d = {};d.width = o + "px", d.height = s + "px", d.top = Se.slider_item_padding_top + "px", d.left = Se.slider_item_padding_left + "px", re.find(".ug-item-wrapper").css(d), Te && Te.setSizeByParent(), a(), u(ae), u(se), u(le), l();var _ = pe.getSlideType();if ("image" != _ && 1 == Se.slider_video_constantsize) w();else {
			var g = e - Se.slider_video_padding_left - Se.slider_video_padding_right,
			    c = t - Se.slider_video_padding_top - Se.slider_video_padding_bottom;Ie.setSize(g, c);
		}I();
	}, this.refreshSlideItems = function () {
		return 1 == pe.isAnimating() ? !0 : (u(ae), u(se), u(le), void l());
	}, this.isMouseOver = function () {
		return re.ismouseover();
	}, this.setPosition = function (e, t) {
		we.placeElement(re, e, t);
	}, this.zoomIn = function () {
		return ge ? void ge.zoomIn() : !0;
	}, this.zoomOut = function () {
		return ge ? void ge.zoomOut() : !0;
	}, this.zoomBack = function () {
		return ge ? void ge.zoomBack() : !0;
	};
}function UGTextPanel() {
	function e(e, t) {
		if (!t) var t = v.textpanel_padding_top;var i = t;if (d) {
			var n = i;f.placeElement(d, 0, n);var o = d.is(":visible");if (1 == o) {
				var a = f.getElementSize(d),
				    i = a.bottom;i > 0 && (b.lastTitleBottom = i);
			} else {
				var i = 20;b.lastTitleBottom > 0 && (i = b.lastTitleBottom);
			}
		}var s = "";if (_ && (s = jQuery.trim(_.text())), "" != s) {
			var l = i;d && (l += v.textpanel_padding_title_description), f.placeElement(_, 0, l);var u = jQuery(_).is(":visible");if (1 == u) {
				var g = f.getElementSize(_);i = g.bottom, g.height > 0 && (b.lastDescHeight = g.height);
			} else {
				var c = 16;b.lastDescHeight > 0 && (c = b.lastDescHeight), i = l + c;
			}
		}if (!v.textpanel_height && 1 == b.setInternalHeight) {
			var h = i + v.textpanel_padding_bottom;r(h, e);
		}
	}function t() {
		var e = 0;if (d && (e += d.outerHeight()), _) {
			var t = "";_ && (t = jQuery.trim(_.text())), "" != t && (d && (e += v.textpanel_padding_title_description), e += _.outerHeight());
		}return e;
	}function i() {
		var i = t(),
		    n = (c.height() - i) / 2;e(!1, n);
	}function n() {
		var i = t(),
		    n = c.height() - i - v.textpanel_padding_bottom;e(!1, n);
	}function r(e, t) {
		if (!t) var t = !1;if (1 == t) {
			if (g) {
				var i = g.height();e > i && g.height(e);
			}var n = { height: e + "px" };l.add(c).animate(n, v.textpanel_fade_duration);
		} else g && g.height(e), l.add(c).height(e);
	}function o() {
		if (1 == v.textpanel_enable_bg) {
			g = l.children(".ug-textpanel-bg"), g.fadeTo(0, v.textpanel_bg_opacity);var e = { "background-color": v.textpanel_bg_color };e = jQuery.extend(e, v.textpanel_bg_css), g.css(e);
		}if (1 == v.textpanel_enable_title) {
			d = c.children(".ug-textpanel-title");var t = {};null !== v.textpanel_title_color && (t.color = v.textpanel_title_color), null !== v.textpanel_title_font_family && (t["font-family"] = v.textpanel_title_font_family), null !== v.textpanel_title_text_align && (t["text-align"] = v.textpanel_title_text_align), null !== v.textpanel_title_font_size && (t["font-size"] = v.textpanel_title_font_size + "px"), null !== v.textpanel_title_bold && (v.textpanel_title_bold === !0 ? t["font-weight"] = "bold" : t["font-weight"] = "normal"), v.textpanel_css_title && (t = jQuery.extend(t, v.textpanel_css_title)), d.css(t);
		}if (1 == v.textpanel_enable_description) {
			_ = c.children(".ug-textpanel-description");var i = {};null !== v.textpanel_desc_color && (i.color = v.textpanel_desc_color), null !== v.textpanel_desc_font_family && (i["font-family"] = v.textpanel_desc_font_family), null !== v.textpanel_desc_text_align && (i["text-align"] = v.textpanel_desc_text_align), null !== v.textpanel_desc_font_size && (i["font-size"] = v.textpanel_desc_font_size + "px"), null !== v.textpanel_desc_bold && (v.textpanel_desc_bold === !0 ? i["font-weight"] = "bold" : i["font-weight"] = "normal"), v.textpanel_css_title && (i = jQuery.extend(i, v.textpanel_css_description)), _.css(i);
		}
	}function a() {
		var e = h.getSelectedItem();p.setText(e.title, e.description);
	}function s() {
		jQuery(h).on(h.events.ITEM_CHANGE, a);
	}var l,
	    u,
	    d,
	    _,
	    g,
	    c,
	    h,
	    p = this,
	    f = new UGFunctions(),
	    m = "",
	    v = { textpanel_align: "bottom", textpanel_margin: 0, textpanel_text_valign: "middle", textpanel_padding_top: 10, textpanel_padding_bottom: 10, textpanel_height: null, textpanel_padding_title_description: 5, textpanel_padding_right: 11, textpanel_padding_left: 11, textpanel_fade_duration: 200, textpanel_enable_title: !0, textpanel_enable_description: !0, textpanel_enable_bg: !0, textpanel_bg_color: "#000000", textpanel_bg_opacity: .4, textpanel_title_color: null, textpanel_title_font_family: null, textpanel_title_text_align: null, textpanel_title_font_size: null, textpanel_title_bold: null, textpanel_css_title: {}, textpanel_desc_color: null, textpanel_desc_font_family: null, textpanel_desc_text_align: null, textpanel_desc_font_size: null, textpanel_desc_bold: null, textpanel_css_description: {}, textpanel_desc_style_as_title: !1, textpanel_bg_css: {} },
	    b = { isFirstTime: !0, setInternalHeight: !0, lastTitleBottom: 0, lastDescHeight: 0 };this.positionElements = function (t) {
		if (!v.textpanel_height || "top" == v.textpanel_text_valign) return e(t), !1;switch (v.textpanel_text_valign) {default:case "top":
				e(!1);break;case "bottom":
				n();break;case "center":case "middle":
				i();}
	}, this.init = function (e, t, i) {
		if (h = e, i && (m = i, t = f.convertCustomPrefixOptions(t, m, "textpanel")), t && (v = jQuery.extend(v, t)), 0 == v.textpanel_enable_title && 0 == v.textpanel_enable_description) throw new Error("Textpanel Error: The title or description must be enabled");v.textpanel_height && v.textpanel_height < 0 && (v.textpanel_height = null), 1 == v.textpanel_desc_style_as_title && (v.textpanel_desc_color || (v.textpanel_desc_color = v.textpanel_title_color), v.textpanel_desc_bold || (v.textpanel_desc_bold = v.textpanel_title_bold), v.textpanel_desc_font_family || (v.textpanel_desc_font_family = v.textpanel_title_font_family), v.textpanel_desc_font_size || (v.textpanel_desc_font_size = v.textpanel_title_font_size), v.textpanel_desc_text_align || (v.textpanel_desc_text_align = v.textpanel_title_text_align));
	}, this.appendHTML = function (e, t) {
		u = e, t = t ? " " + t : "";var i = "<div class='ug-textpanel" + t + "'>";1 == v.textpanel_enable_bg && (i += "<div class='ug-textpanel-bg" + t + "'></div>"), i += "<div class='ug-textpanel-textwrapper" + t + "'>", 1 == v.textpanel_enable_title && (i += "<div class='ug-textpanel-title" + t + "'></div>"), 1 == v.textpanel_enable_description && (i += "<div class='ug-textpanel-description" + t + "'></div>"), i += "</div></div>", e.append(i), l = e.children(".ug-textpanel"), c = l.children(".ug-textpanel-textwrapper"), o();
	}, this.destroy = function () {
		jQuery(h).off(h.events.ITEM_CHANGE);
	}, this.run = function () {
		p.setSizeByParent(), s();
	}, this.setPanelSize = function (e, t) {
		if (b.setInternalHeight = !0, t) b.setInternalHeight = !1;else var t = 80;v.textpanel_height && (t = v.textpanel_height), l.width(e), l.height(t), g && (g.width(e), g.height(t));var i = e - v.textpanel_padding_left - v.textpanel_padding_right,
		    n = v.textpanel_padding_left;f.setElementSizeAndPosition(c, n, 0, i, t), d && d.width(i), _ && _.width(i), 0 == b.isFirstTime && p.positionElements(!1);
	}, this.setSizeByParent = function () {
		var e = f.getElementSize(u);p.setPanelSize(e.width);
	}, this.setTextPlain = function (e, t) {
		d && d.html(e), _ && _.html(t);
	}, this.setText = function (e, t) {
		1 == b.isFirstTime ? (p.setTextPlain(e, t), b.isFirstTime = !1, p.positionElements(!1)) : c.stop().fadeTo(v.textpanel_fade_duration, 0, function () {
			p.setTextPlain(e, t), p.positionElements(!0), jQuery(this).fadeTo(v.textpanel_fade_duration, 1);
		});
	}, this.positionPanel = function (e, t) {
		var i = {};if (void 0 !== e && null !== e) i.top = e, i.bottom = "auto";else switch (v.textpanel_align) {case "top":
				i.top = v.textpanel_margin + "px";break;case "bottom":
				i.top = "auto", i.bottom = v.textpanel_margin + "px";break;case "middle":
				i.top = f.getElementRelativePos(l, "middle", v.textpanel_margin);}void 0 !== t && null !== t && (i.left = t), l.css(i);
	}, this.setOptions = function (e) {
		m && (e = f.convertCustomPrefixOptions(e, m, "textpanel")), v = jQuery.extend(v, e);
	}, this.getElement = function () {
		return l;
	}, this.getSize = function () {
		var e = f.getElementSize(l);return e;
	}, this.refresh = function (e, t, i, n) {
		o(), i ? p.setPanelSize(i, n) : p.setSizeByParent(), p.positionElements(!1), t !== !0 && p.positionPanel(), e === !0 && p.show();
	}, this.hide = function () {
		l.hide();
	}, this.show = function () {
		l.show();
	}, this.getOptions = function () {
		return v;
	}, this.getOption = function (e) {
		return 0 == v.hasOwnProperty(e) ? null : v[e];
	};
}function UGZoomButtonsPanel() {
	function e(e) {
		return e ? e.hasClass("ug-zoompanel-button-disabled") ? !0 : !1 : !0;
	}function t(e) {
		e && e.addClass("ug-zoompanel-button-disabled");
	}function i(e) {
		e && e.removeClass("ug-zoompanel-button-disabled");
	}function n() {
		if (0 == d.isCurrentSlideType("image")) return !0;var n = d.isCurrentSlideImageFit();1 == n ? 0 == e(s) && (t(s), t(l)) : 1 == e(s) && (i(s), i(l));
	}var r,
	    o,
	    a,
	    s,
	    l,
	    u = this,
	    d = new UGSlider(),
	    _ = new UGFunctions(),
	    g = { slider_zoompanel_skin: "" };this.init = function (e, t) {
		d = e, t && (g = jQuery.extend(g, t));
	}, this.appendHTML = function (e) {
		o = e;var t = "<div class='ug-slider-control ug-zoompanel ug-skin-" + g.slider_zoompanel_skin + "'>";t += "<div class='ug-zoompanel-button ug-zoompanel-plus'></div>", t += "<div class='ug-zoompanel-button ug-zoompanel-minus ug-zoompanel-button-disabled'></div>", t += "<div class='ug-zoompanel-button ug-zoompanel-return ug-zoompanel-button-disabled'></div>", t += "</div>", e.append(t), r = e.children(".ug-zoompanel"), a = r.children(".ug-zoompanel-plus"), s = r.children(".ug-zoompanel-minus"), l = r.children(".ug-zoompanel-return");
	}, this.setObjects = function (e, t, i) {
		a = e, s = t, l = i, s && s.addClass("ug-zoompanel-button-disabled"), l && l.addClass("ug-zoompanel-button-disabled");
	}, this.getElement = function () {
		return r;
	}, u.initEvents = function () {
		_.addClassOnHover(a, "ug-button-hover"), _.addClassOnHover(s, "ug-button-hover"), _.addClassOnHover(l, "ug-button-hover"), _.setButtonOnClick(a, function () {
			return 1 == e(a) ? !0 : void d.zoomIn();
		}), _.setButtonOnClick(s, function () {
			return 1 == e(s) ? !0 : void d.zoomOut();
		}), _.setButtonOnClick(l, function () {
			return 1 == e(l) ? !0 : void d.zoomBack();
		}), jQuery(d).on(d.events.ZOOM_CHANGE, n), jQuery(d).on(d.events.ITEM_CHANGED, n);
	};
}function UGBullets() {
	function e() {
		var e = "",
		    t = "";-1 != h.bullets_space_between && (t = " style='margin-left:" + h.bullets_space_between + "px'");for (var i = 0; u > i; i++) {
			e += 0 == i ? "<div class='ug-bullet'></div>" : "<div class='ug-bullet'" + t + "></div>";
		}if (o.html(e), !s) {
			var n = o.find(".ug-bullet:first-child");n.length && (s = n.width());
		}
	}function t(e) {
		if (1 == l.isActive(e)) return !0;var t = e.index();jQuery(l).trigger(l.events.BULLET_CLICK, t);
	}function i() {
		var e = o.children(".ug-bullet");g.setButtonOnClick(e, t), e.on("mousedown mouseup", function (e) {
			return !1;
		});
	}function n(e) {
		if (0 > e || e >= u) throw new Error("wrong bullet index: " + e);
	}function r() {
		if (1 == c.isInited) return !0;throw new Error("The bullets are not inited!");
	}var o,
	    a,
	    s,
	    l = this,
	    u = 0,
	    d = new UniteGalleryMain(),
	    _ = -1,
	    g = new UGFunctions(),
	    c = { isInited: !1 },
	    h = { bullets_skin: "", bullets_addclass: "", bullets_space_between: -1 };this.events = { BULLET_CLICK: "bullet_click" }, this.init = function (e, t, i) {
		d = e, u = i ? i : d.getNumItems(), c.isInited = !0, h = jQuery.extend(h, t), "" == h.bullets_skin && (h.bullets_skin = h.gallery_skin);
	}, this.getBulletsWidth = function () {
		if (0 == u) return 0;if (!s) return 0;var e = u * s + (u - 1) * h.bullets_space_between;return e;
	}, this.appendHTML = function (t) {
		a = t, r();var n = "";"" != h.bullets_addclass && (n = " " + h.bullets_addclass);var s = "<div class='ug-slider-control ug-bullets ug-skin-" + h.bullets_skin + n + "'>";s += "</div>", o = jQuery(s), t.append(o), e(), i();
	}, this.updateNumBullets = function (t) {
		u = t, e(), i();
	}, this.getElement = function () {
		return o;
	}, this.setActive = function (e) {
		r(), n(e);var t = o.children(".ug-bullet");t.removeClass("ug-bullet-active");var i = jQuery(t[e]);i.addClass("ug-bullet-active"), _ = e;
	}, this.isActive = function (e) {
		if (n(e), "number" != typeof e) var t = e;else var t = o.children(".ug-bullet")[e];return t.hasClass("ug-bullet-active") ? !0 : !1;
	}, this.getNumBullets = function () {
		return u;
	};
}function UGProgressBar() {
	var e,
	    t,
	    i = this,
	    n = 0,
	    r = new UGFunctions(),
	    o = { slider_progressbar_color: "#ffffff", slider_progressbar_opacity: .6, slider_progressbar_line_width: 5 };this.put = function (i, n) {
		n && (o = jQuery.extend(o, n)), i.append("<div class='ug-progress-bar'><div class='ug-progress-bar-inner'></div></div>"), e = i.children(".ug-progress-bar"), t = e.children(".ug-progress-bar-inner"), t.css("background-color", o.slider_progressbar_color), e.height(o.slider_progressbar_line_width), t.height(o.slider_progressbar_line_width), t.width("0%");var r = o.slider_progressbar_opacity,
		    a = t[0];a.style.opacity = r, a.style.filter = "alpha(opacity=" + 100 * r + ")";
	}, this.putHidden = function (t, n) {
		i.put(t, n), e.hide();
	}, this.getElement = function () {
		return e;
	}, this.setSize = function (n) {
		e.width(n), t.width(n), i.draw();
	}, this.setPosition = function (t, i, n, o) {
		r.placeElement(e, t, i, n, o);
	}, this.draw = function () {
		var e = 100 * n;t.width(e + "%");
	}, this.setProgress = function (e) {
		n = r.normalizePercent(e), i.draw();
	}, this.getType = function () {
		return "bar";
	};
}function UGProgressPie() {
	function e(e) {
		if (!e) var e = 0;var t = Math.min(a.slider_progresspie_width, a.slider_progresspie_height) / 2,
		    n = i[0].getContext("2d");0 == r && (r = !0, n.rotate(1.5 * Math.PI), n.translate(-2 * t, 0)), n.clearRect(0, 0, a.slider_progresspie_width, a.slider_progresspie_height);var o = a.slider_progresspie_width / 2,
		    s = a.slider_progresspie_height / 2,
		    l = 0,
		    u = e * Math.PI * 2;if (1 == a.slider_progresspie_type_fill) n.beginPath(), n.moveTo(o, s), n.arc(o, s, t, l, u), n.lineTo(o, s), n.fillStyle = a.slider_progresspie_color1, n.fill(), n.closePath();else {
			n.globalCompositeOperation = "source-over", n.beginPath(), n.moveTo(o, s), n.arc(o, s, t, l, u), n.lineTo(o, s), n.fillStyle = a.slider_progresspie_color1, n.fill(), n.closePath(), n.globalCompositeOperation = "destination-out";var d = t - a.slider_progresspie_stroke_width;n.beginPath(), n.moveTo(o, s), n.arc(o, s, d, l, u), n.lineTo(o, s), n.fillStyle = a.slider_progresspie_color1, n.fill(), n.closePath();
		}1 == a.slider_progresspie_type_fill && (l = u, u = 2 * Math.PI, n.beginPath(), n.arc(o, s, t, l, u), n.lineTo(o, s), n.fillStyle = a.slider_progresspie_color2, n.fill(), n.closePath());
	}var t,
	    i,
	    n = this,
	    r = !1,
	    o = new UGFunctions(),
	    a = { slider_progresspie_type_fill: !1, slider_progresspie_color1: "#B5B5B5", slider_progresspie_color2: "#E5E5E5", slider_progresspie_stroke_width: 6, slider_progresspie_width: 30, slider_progresspie_height: 30 };this.put = function (e, t) {
		t && (a = jQuery.extend(a, t)), e.append("<canvas class='ug-canvas-pie' width='" + a.slider_progresspie_width + "' height='" + a.slider_progresspie_height + "'></canvas>"), i = e.children(".ug-canvas-pie");
	}, this.putHidden = function (t, r) {
		n.put(t, r), e(.1), i.hide();
	}, this.getElement = function () {
		return i;
	}, this.setPosition = function (e, t) {
		o.placeElement(i, e, t);
	}, this.getSize = function () {
		var e = { width: a.slider_progresspie_width, height: a.slider_progresspie_height };return e;
	}, this.setProgress = function (i) {
		i = o.normalizePercent(i), t = i, e(i);
	}, this.getType = function () {
		return "pie";
	};
}function UGTouchSliderControl() {
	function e(e) {
		if (!e) var e = m.getSlidesReference();var t = v.getElementSize(e.objCurrentSlide),
		    i = -t.left,
		    n = v.getElementSize(h),
		    r = i - n.left;return r;
	}function t() {
		var t = m.getSlidesReference(),
		    i = e(t),
		    n = Math.round(3 * t.objCurrentSlide.width() / 8);if (Math.abs(i) >= n) return !0;var r = Math.abs(b.lastMouseX - b.startMouseX);Math.abs(b.lastMouseY - b.startMouseY);if (20 > r) return !1;var o = jQuery.now(),
		    a = o - b.startTime;return 500 > a ? !0 : !1;
	}function i(e) {
		if (1 == m.isInnerInPlace()) return !1;if (p.trigger(m.events.BEFORE_RETURN), !e) var e = m.getSlidesReference();var t = v.getElementSize(e.objCurrentSlide),
		    i = -t.left;h.animate({ left: i + "px" }, { duration: f.slider_transition_return_speed, easing: f.slider_transition_continuedrag_easing, queue: !1, progress: function progress(e, t, n) {
				if (1 == b.isDragVideo) {
					var r = v.getElementSize(h),
					    o = r.left,
					    a = o - i,
					    s = b.videoStartX + a;b.videoObject.css("left", s);
				}
			}, complete: function complete() {
				p.trigger(m.events.AFTER_RETURN);
			} });
	}function n(e) {
		m.getVideoObject().hide(), m.switchSlideNums(e), m.placeNabourItems();
	}function r() {
		var t = m.getSlidesReference(),
		    r = e(t);if (0 == r) return !1;var o = r > 0 ? "left" : "right",
		    a = !1;switch (o) {case "right":
				if (m.isSlideHasItem(t.objPrevSlide)) var s = v.getElementSize(t.objPrevSlide),
				    l = -s.left;else a = !0;break;case "left":
				if (m.isSlideHasItem(t.objNextSlide)) var u = v.getElementSize(t.objNextSlide),
				    l = -u.left;else a = !0;}1 == a ? i(t) : h.stop().animate({ left: l + "px" }, { duration: f.slider_transition_continuedrag_speed, easing: f.slider_transition_continuedrag_easing, queue: !1, progress: function progress() {
				if (1 == b.isDragVideo) {
					var e = v.getElementSize(h),
					    t = e.left,
					    i = t - b.startPosx,
					    n = b.videoStartX + i;b.videoObject.css("left", n);
				}
			}, always: function always() {
				n(o), p.trigger(m.events.AFTER_DRAG_CHANGE);
			} });
	}function o(e) {
		var t = b.lastMouseX - b.startMouseX;if (0 == t) return !0;var i = 0 > t ? "left" : "right",
		    n = m.getObjZoom();if (n) {
			var r = n.isPanEnabled(e, i);if (1 == r) return b.isInitDataValid = !1, !0;if (0 == b.isInitDataValid) return a(e), !0;
		}var o = b.startPosx + t;if (t > 0 && o > 0) o /= 3;else if (0 > t) {
			var s = o + h.width(),
			    l = c.width();l > s && (o = b.startPosx + t / 3);
		}if (0 == b.isDragging && (b.isDragging = !0, p.trigger(m.events.START_DRAG)), h.css("left", o + "px"), 1 == b.isDragVideo) {
			var u = o - b.startPosx,
			    d = b.videoStartX + u;b.videoObject.css("left", d);
		}
	}function a(e) {
		var t = v.getMousePosition(e);b.startMouseX = t.pageX, b.startMouseY = t.pageY, b.lastMouseX = b.startMouseX, b.lastMouseY = b.startMouseY, b.startTime = jQuery.now();var i = v.getArrTouches(e);b.startArrTouches = v.getArrTouchPositions(i);var n = v.getElementSize(h);b.startPosx = n.left, b.isInitDataValid = !0, b.isDragVideo = !1, v.storeEventData(e, b.storedEventID);
	}function s(e) {
		b.touch_active = !1;
	}function l(e, t) {
		b.touch_active = !0, a(t);
	}function u(e) {
		e.preventDefault(), b.isDragging = !1, 1 == m.isAnimating() && h.stop(!0, !0);var t = v.getArrTouches(e);return t.length > 1 ? (1 == b.touch_active && s("1"), !0) : 1 == b.touch_active ? !0 : void l("1", e);
	}function d(e) {
		if (0 == b.touch_active) return !0;if (0 == e.buttons) return s("2"), r(), !0;v.updateStoredEventData(e, b.storedEventID), e.preventDefault();var t = v.getMousePosition(e);b.lastMouseX = t.pageX, b.lastMouseY = t.pageY;var i = null;1 == f.slider_vertical_scroll_ondrag && (i = v.handleScrollTop(b.storedEventID)), "vert" !== i && o(e);
	}function _(e) {
		var n = v.getArrTouches(e),
		    o = n.length,
		    a = m.isInnerInPlace();if (1 == a && 0 == b.touch_active && 0 == o) return !0;if (0 == o && 1 == b.touch_active) {
			s("3");var u = !1,
			    d = v.wasVerticalScroll(b.storedEventID);0 == d && (u = t()), 1 == u ? r() : i();
		} else 1 == o && 0 == b.touch_active && l("2", e);
	}function g() {
		c.bind("mousedown touchstart", u), jQuery("body").bind("mousemove touchmove", d), jQuery(window).add("body").bind("mouseup touchend", _);
	}var c,
	    h,
	    p,
	    f,
	    m = new UGSlider(),
	    v = new UGFunctions(),
	    f = { slider_transition_continuedrag_speed: 250, slider_transition_continuedrag_easing: "linear", slider_transition_return_speed: 300, slider_transition_return_easing: "easeInOutQuad" },
	    b = { touch_active: !1, startMouseX: 0, startMouseY: 0, lastMouseX: 0, lastMouseY: 0, startPosx: 0, startTime: 0, isInitDataValid: !1, slides: null, lastNumTouches: 0, isDragging: !1, storedEventID: "touchSlider", videoStartX: 0, isDragVideo: !1, videoObject: null };this.isTapEventOccured = function (t) {
		var i = v.getArrTouches(t),
		    n = i.length;if (0 != n || 0 != b.lastNumTouches) return b.lastNumTouches = n, !1;b.lastNumTouches = n;var r = m.getSlidesReference(),
		    o = (e(r), Math.abs(b.lastMouseX - b.startMouseX)),
		    a = Math.abs(b.lastMouseY - b.startMouseY),
		    s = jQuery.now(),
		    l = s - b.startTime;return 20 > o && 50 > a && 500 > l ? !0 : !1;
	}, this.init = function (e, t) {
		m = e, p = jQuery(m), g_objects = e.getObjects(), c = g_objects.g_objSlider, h = g_objects.g_objInner, f = jQuery.extend(f, t), g();
	}, this.getLastMousePos = function () {
		var e = { pageX: b.lastMouseX, pageY: b.lastMouseY };return e;
	}, this.isTouchActive = function () {
		return b.touch_active;
	};
}function UGZoomSliderControl() {
	function e(e, t) {
		E = e, w = jQuery(E), g_objects = e.getObjects(), y = g_objects.g_objSlider, I = g_objects.g_objInner, S = jQuery.extend(S, t), b();
	}function t() {
		var e = E.getScaleMode();return "down" != e && (e = "fit"), e;
	}function i() {
		var e = jQuery.now(),
		    i = e - P.storeImageLastTime;if (20 > i) return !1;var n = E.getSlidesReference();if (P.objSlide = n.objCurrentSlide, P.objImage = n.objCurrentSlide.find("img"), 0 == P.objImage.length) return !1;P.objImageSize = T.getElementSize(P.objImage), P.objParent = P.objImage.parent(), P.objParentSize = T.getElementSize(P.objParent);var r = t();objPadding = E.getObjImagePadding(), P.objFitImageSize = T.getImageInsideParentDataByImage(P.objImage, r, objPadding);var e = jQuery.now();return P.storeImageLastTime = e, !0;
	}function n(e, i) {
		var n = E.getSlidesReference(),
		    r = n.objCurrentSlide.find("img"),
		    o = t();w.trigger(E.events.ZOOM_START);var a = !0,
		    s = E.getObjImagePadding();if ("back" == e) {
			var l = T.getImageOriginalSize(r);T.scaleImageFitParent(r, l.width, l.height, o, s);
		} else {
			var u = "in" == e ? !0 : !1;a = T.zoomImageInsideParent(r, u, S.slider_zoom_step, i, o, S.slider_zoom_max_ratio, s);
		}1 == a && (w.trigger(E.events.ZOOMING), w.trigger(E.events.ZOOM_CHANGE), w.trigger(E.events.ZOOM_END));
	}function r(e, t, i) {
		var n = T.getArrTouches(t);if (i === !0) {
			if (1 != n.length) return !1;
		} else if (n.length > 1) return !1;return T.isElementBiggerThenParent(e) ? !0 : !1;
	}function o(e) {
		var t = T.getMousePosition(e);P.startMouseX = t.pageX, P.startMouseY = t.pageY, P.lastMouseX = P.startMouseX, P.lastMouseY = P.startMouseY, P.startImageX = P.objImageSize.left, P.startImageY = P.objImageSize.top, P.panXActive = P.objImageSize.width > P.objParentSize.width, P.panYActive = P.objImageSize.height > P.objParentSize.height;
	}function a(e) {
		P.isPanActive = !0, o(e);
	}function s(e) {
		if (void 0 == P.objImage || 0 == P.objImage.length) return !0;var t = T.getMousePosition(e),
		    i = (t.pageX - P.startMouseX, t.pageY - P.startMouseY, t.pageX - P.lastMouseX),
		    n = t.pageY - P.lastMouseY,
		    r = 0 > i ? "left" : "right",
		    o = 0 > n ? "up" : "down";P.lastMouseX = t.pageX, P.lastMouseY = t.pageY;var a = T.getElementSize(P.objImage);0 == P.panYActive ? n = 0 : "down" == o && a.top > 0 ? n /= 3 : "up" == o && a.bottom < P.objParentSize.height && (n /= 3), 0 == P.panXActive || 0 == E.isInnerInPlace() ? i = 0 : "right" == r && a.left > 0 ? i /= 3 : "left" == r && a.right < P.objParentSize.width && (i /= 3);var s = a.left + i,
		    l = a.top + n;T.placeElement(P.objImage, s, l);
	}function l() {
		var e = !1,
		    t = !1,
		    i = 0,
		    n = 0,
		    r = T.getElementSize(P.objImage),
		    o = E.getObjImagePadding(),
		    a = T.getElementCenterPosition(P.objImage, o);P.panXActive = P.objImageSize.width > P.objParentSize.width, P.panYActive = P.objImageSize.height > P.objParentSize.height, 1 == P.panYActive ? r.top > 0 ? (n = 0, t = !0) : r.bottom < P.objParentSize.height && (n = P.objParentSize.height - r.height, t = !0) : r.top != a.top && (t = !0, n = a.top), 1 == P.panXActive ? r.left > 0 ? (i = 0, e = !0) : r.right < P.objParentSize.width && (i = P.objParentSize.width - r.width, e = !0) : r.left != a.left && (e = !0, i = a.left);var s = {};1 == t && (s.top = n + "px"), 1 == e && (s.left = i + "px"), (1 == t || 1 == e) && P.objImage.animate(s, { duration: S.slider_zoom_return_pan_duration, easing: S.slider_zoom_return_pan_easing, queue: !1 });
	}function u() {
		return P.objImage && P.objImage.is(":animated") ? !0 : !1;
	}function d(e) {
		P.isZoomActive = !0, P.startDistance = T.getDistance(e[0].pageX, e[0].pageY, e[1].pageX, e[1].pageY), 0 == P.startDistance && (P.startDistance = 1), P.startMiddlePoint = T.getMiddlePoint(e[0].pageX, e[0].pageY, e[1].pageX, e[1].pageY), P.objImageSize = T.getElementSize(P.objImage), P.startImageX = P.objImageSize.left, P.startImageY = P.objImageSize.top, P.imageOrientPoint = T.getElementLocalPoint(P.startMiddlePoint, P.objImage);var t = T.isPointInsideElement(P.imageOrientPoint, P.objImageSize);0 == t && (P.imageOrientPoint = T.getElementCenterPoint(P.objImage)), w.trigger(E.events.ZOOM_START);
	}function _(e) {
		if (0 == P.isZoomActive) return !1;var t = T.getArrTouches(e);2 != t.length && (P.isZoomActive = !1, w.trigger(E.events.ZOOM_END));
	}function g(e) {
		if (1 == P.isZoomActive) return !0;var t = T.getArrTouches(e);return 2 != t.length ? !0 : void d(t);
	}function c(e) {
		var t = T.getArrTouches(e),
		    i = T.getDistance(t[0].pageX, t[0].pageY, t[1].pageX, t[1].pageY),
		    n = i / P.startDistance,
		    r = T.getMiddlePoint(t[0].pageX, t[0].pageY, t[1].pageX, t[1].pageY),
		    o = P.objImageSize.width * n,
		    a = P.objImageSize.height * n,
		    s = T.getImageOriginalSize(P.objImage),
		    l = 1;if (s.width > 0 && (l = o / s.width), l > S.slider_zoom_max_ratio) return !0;panX = -(P.imageOrientPoint.x * n - P.imageOrientPoint.x), panY = -(P.imageOrientPoint.y * n - P.imageOrientPoint.y);var u = r.x - P.startMiddlePoint.x,
		    d = r.y - P.startMiddlePoint.y,
		    _ = P.startImageX + panX + u,
		    g = P.startImageY + panY + d;T.setElementSizeAndPosition(P.objImage, _, g, o, a), w.trigger(E.events.ZOOMING), w.trigger(E.events.ZOOM_CHANGE);
	}function h() {
		if (void 0 == P.objImage || 0 == P.objImage.length) return !0;var e = T.getElementSize(P.objImage);if (e.width < P.objFitImageSize.imageWidth) {
			P.objImage.css({ position: "absolute", margin: "none" });var t = { top: P.objFitImageSize.imageTop + "px", left: P.objFitImageSize.imageLeft + "px", width: P.objFitImageSize.imageWidth + "px", height: P.objFitImageSize.imageHeight + "px" };P.objImage.animate(t, { duration: S.slider_zoom_return_pan_duration, easing: S.slider_zoom_return_pan_easing, queue: !1 });
		} else l();
	}function p(e) {
		if (0 == E.isCurrentSlideType("image")) return !0;i();return void 0 == P.objImage || 0 == P.objImage.length ? !0 : (e.preventDefault(), 1 == u() && P.objImage.stop(!0), 1 == P.isZoomActive ? _(e) : g(e), void (1 == P.isZoomActive ? P.isPanActive = !1 : 1 == r(P.objImage, e) && 1 == P.isZoomedOnce && a(e)));
	}function f(e) {
		if (0 == E.isCurrentSlideType("image")) return !0;var t = jQuery(e.target);if (1 == t.data("ug-button")) return !1;i();if (void 0 == P.objImage || 0 == P.objImage.length) return !0;var n = P.isPanActive,
		    o = P.isZoomActive;if (0 == E.isInnerInPlace()) return P.isZoomActive = !1, P.isPanActive = !1, !0;if (1 == P.isZoomActive ? _(e) : g(e), 1 == P.isZoomActive) P.isPanActive = !1;else {
			var s = r(P.objImage, e, !0);1 == P.isPanActive ? P.isPanActive = !1 : 1 == s && a(e);
		}(n || o) && 0 == P.isZoomActive && 0 == P.isPanActive && h();
	}function m(e) {
		return 0 == E.isCurrentSlideType("image") ? !0 : void (1 == P.isZoomActive ? c(e) : 1 == P.isPanActive && s(e));
	}function v(e, t, i, r) {
		if (0 == S.slider_zoom_mousewheel) return !0;if (0 == E.isCurrentSlideType("image")) return !0;e.preventDefault();var o = t > 0,
		    a = T.getMousePosition(e),
		    s = 1 == o ? "in" : "out";n(s, a);
	}function b() {
		y.on("mousewheel", v), y.bind("mousedown touchstart", p), jQuery("body").bind("mousemove touchmove", m), jQuery(window).add("body").bind("mouseup touchend", f), w.bind(E.events.BEFORE_RETURN, function () {
			h();
		}), w.bind(E.events.ITEM_CHANGED, function () {
			P.isZoomedOnce = !1;
		}), w.bind(E.events.ZOOM_CHANGE, function () {
			P.isZoomedOnce = !0;
		});
	}var y,
	    I,
	    w,
	    E = new UGSlider(),
	    T = new UGFunctions(),
	    S = { slider_zoom_step: 1.2, slider_zoom_max_ratio: 6, slider_zoom_return_pan_duration: 400, slider_zoom_return_pan_easing: "easeOutCubic" },
	    P = { isPanActive: !1, startMouseX: 0, startMouseY: 0, lastMouseX: 0, lastMouseY: 0, startImageX: 0, startImageY: 0, panXActive: !1, panYActive: !1, objImage: null, objImageSize: null, objParent: null, objParentSize: null, objSlide: null, storeImageLastTime: 0, isZoomActive: !1, startDistance: 0, startMiddlePoint: null, imageOrientPoint: null, objFitImageSize: null, isZoomedOnce: !1 };this.________EXTERNAL_____________ = function () {}, this.isPanEnabled = function (e, t) {
		if (i(), void 0 == P.objImage || 0 == P.objImage.length) return !1;if (0 == P.isZoomedOnce) return !1;if (0 == r(P.objImage, e)) return !1;if (0 == E.isInnerInPlace()) return !1;if ("left" == t) {
			if (P.objImageSize.right <= P.objParentSize.width) return !1;
		} else if (P.objImageSize.left >= 0) return !1;return !0;
	}, this.init = function (t, i) {
		e(t, i);
	}, this.zoomIn = function () {
		n("in");
	}, this.zoomOut = function () {
		n("out");
	}, this.zoomBack = function () {
		n("back");
	};
}function UGWistiaAPI() {
	function e() {
		return "undefined" != typeof Wistia;
	}function t(e, t, n, o, a) {
		r = null, s = !1;var l = e + "_video",
		    u = "<div id='" + l + "' class='wistia_embed' style='width:" + n + ";height:" + o + ";' data-video-width='" + n + "' data-video-height='" + o + "'>&nbsp;</div>";jQuery("#" + e).html(u), r = Wistia.embed(t, { version: "v1", videoWidth: n, videoHeight: o, container: l, autoPlay: a }), s = !0, i();
	}function i() {
		r.bind("play", function () {
			a.trigger(o.events.START_PLAYING);
		}), r.bind("pause", function () {
			a.trigger(o.events.STOP_PLAYING);
		}), r.bind("end", function () {
			a.trigger(o.events.STOP_PLAYING), a.trigger(o.events.VIDEO_ENDED);
		});
	}this.isAPILoaded = !1;var n,
	    r,
	    o = this,
	    a = jQuery(this),
	    s = !1;this.events = { START_PLAYING: "start_playing", STOP_PLAYING: "stop_playing", VIDEO_ENDED: "video_ended" }, this.loadAPI = function () {
		return 1 == g_ugWistiaAPI.isAPILoaded ? !0 : e() ? (g_ugWistiaAPI.isAPILoaded = !0, !0) : (g_ugFunctions.loadJs("fast.wistia.com/assets/external/E-v1.js", !0), void (g_ugWistiaAPI.isAPILoaded = !0));
	}, this.doCommand = function (e) {
		if (null == r) return !1;if (0 == s) return !1;switch (e) {case "play":
				r.play();break;case "pause":
				r.pause();}
	}, this.pause = function () {
		o.doCommand("pause");
	}, this.play = function () {
		o.doCommand("play");
	}, this.putVideo = function (i, r, o, a, s) {
		return e() ? (t(i, r, o, a, s), !0) : (this.loadAPI(), void (n = setInterval(function () {
			e() && (t(i, r, o, a, s), clearInterval(n));
		}, 500)));
	}, this.isPlayerReady = function () {
		return s && r ? !0 : !1;
	};
}function UGSoundCloudAPI() {
	function e() {
		return "undefined" != typeof SC;
	}function t(e, t, n, a, s) {
		r = null, g_isPlayerReady = !1;var l = e + "_iframe",
		    u = location.protocol + "//w.soundcloud.com/player/?url=http://api.soundcloud.com/tracks/" + t;u += "&amp;buying=false&amp;liking=false&amp;download=false&amp;sharing=false&amp;show_artwork=true&show_comments=false&amp;show_playcount=true&amp;show_user=false&amp;hide_related=true&amp;visual=true&amp;start_track=0&amp;callback=true", u += s === !0 ? "&amp;auto_play=true" : "&amp;auto_play=false";var d = "<iframe id='" + l + "' src=" + u + " width='" + n + "' height='" + a + "' frameborder='0' scrolling='no' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";jQuery("#" + e).html(d), r = SC.Widget(l), r.bind(SC.Widget.Events.READY, function () {
			r && (g_isPlayerReady = !0, i());
		}), o = e;
	}function i() {
		r.bind(SC.Widget.Events.PLAY, function () {
			s.trigger(a.events.START_PLAYING);
		}), r.bind(SC.Widget.Events.PAUSE, function () {
			s.trigger(a.events.STOP_PLAYING);
		}), r.bind(SC.Widget.Events.FINISH, function () {
			s.trigger(a.events.STOP_PLAYING), s.trigger(a.events.VIDEO_ENDED);
		});
	}this.isAPILoaded = !1;var n,
	    r,
	    o,
	    a = this,
	    s = jQuery(this);this.events = { START_PLAYING: "start_playing", STOP_PLAYING: "stop_playing", VIDEO_ENDED: "video_ended" }, this.loadAPI = function () {
		return 1 == g_ugSoundCloudAPI.isAPILoaded ? !0 : e() ? (g_ugSoundCloudAPI.isAPILoaded = !0, !0) : (g_ugFunctions.loadJs("w.soundcloud.com/player/api.js", !0), void (g_ugSoundCloudAPI.isAPILoaded = !0));
	}, this.putSound = function (i, r, o, a, s) {
		return e() ? (t(i, r, o, a, s), !0) : (this.loadAPI(), void (n = setInterval(function () {
			e() && (t(i, r, o, a, s), clearInterval(n));
		}, 500)));
	}, this.doCommand = function (e) {
		if (null == r) return !1;if (0 == g_isPlayerReady) return !1;switch (e) {case "play":
				r.play();break;case "pause":
				r.pause();}
	}, this.pause = function () {
		a.doCommand("pause");
	}, this.play = function () {
		a.doCommand("play");
	}, this.destroy = function () {
		g_isPlayerReady = !1, r = null, o && (jQuery("#" + o).html(""), o = null);
	};
}function UGHtml5MediaAPI() {
	function e() {
		return "undefined" != typeof mejs;
	}function t(e, t, n, o, a) {
		r = null, g_isPlayerReady = !1;var s = location.protocol + "//cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/flashmediaelement-cdn.swf",
		    l = location.protocol + "//cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/silverlightmediaelement.xap",
		    u = e + "_video",
		    d = "";a && a === !0 && (d = "autoplay='autoplay'");var _ = "";t.posterImage && (_ = "poster='" + t.posterImage + "'");var g = "<video id='" + u + "' width='" + n + "' height='" + o + "'  controls='controls' preload='none' " + d + " " + _ + ">";"" != t.mp4 && (g += "<source type='video/mp4' src='" + t.mp4 + "' />"), "" != t.webm && (g += "<source type='video/webm' src='" + t.webm + "' />"), "" != t.ogv && (g += "<source type='video/ogg' src='" + t.ogv + "' />"), g += "<object width='" + n + "' height='" + o + "' type='application/x-shockwave-flash' data='" + s + "'>", g += "<param name='movie' value='" + s + "' />", g += "<param name='flashvars' value='controls=true&file=" + t.mp4 + "' />", g += "</object>", g += "</video>", jQuery("#" + e).html(g), new MediaElement(u, { enablePluginDebug: !1, flashName: s, silverlightName: l, success: function success(e, t) {
				g_isPlayerReady = !0, r = e, 0 == a && r.pause(), i();
			}, error: function error(e) {
				trace(e);
			} });
	}function i() {
		g_ugFunctions.addEvent(r, "play", function () {
			a.trigger(o.events.START_PLAYING);
		}), g_ugFunctions.addEvent(r, "pause", function () {
			a.trigger(o.events.STOP_PLAYING);
		}), g_ugFunctions.addEvent(r, "ended", function () {
			a.trigger(o.events.STOP_PLAYING), a.trigger(o.events.VIDEO_ENDED);
		});
	}this.isAPILoaded = !1;var n,
	    r,
	    o = this,
	    a = jQuery(this);this.events = { START_PLAYING: "start_playing", STOP_PLAYING: "stop_playing", VIDEO_ENDED: "video_ended" }, this.loadAPI = function () {
		return 1 == g_ugHtml5MediaAPI.isAPILoaded ? !0 : e() ? (g_ugHtml5MediaAPI.isAPILoaded = !0, !0) : (g_ugFunctions.loadJs("cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/mediaelement.min.js", !0), g_ugFunctions.loadCss("cdnjs.cloudflare.com/ajax/libs/mediaelement/2.18.1/mediaelementplayer.min.css", !0), void (g_ugHtml5MediaAPI.isAPILoaded = !0));
	}, this.putVideo = function (i, r, o, a, s) {
		return e() ? (t(i, r, o, a, s), !0) : (this.loadAPI(), void (n = setInterval(function () {
			e() && (t(i, r, o, a, s), clearInterval(n));
		}, 500)));
	}, this.doCommand = function (e) {
		if (null == r) return !1;if (0 == g_isPlayerReady) return !1;switch (e) {case "play":
				r.play();break;case "pause":
				r.pause();}
	}, this.pause = function () {
		o.doCommand("pause");
	}, this.play = function () {
		o.doCommand("play");
	};
}function UGVimeoAPI() {
	function e() {
		return "undefined" != typeof Froogaloop;
	}function t(e, t, n, o, a) {
		s = null, l = !1;var u = location.protocol + "//player.vimeo.com/video/" + t + "?api=1";a === !0 && (u += "&amp;byline=0&amp;autoplay=1&amp;title=0&amp;portrait=0");var d = "<iframe src=" + u + " width='" + n + "' height='" + o + "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";jQuery("#" + e).html(d);var _ = jQuery("#" + e + " iframe")[0];s = Froogaloop(_), s.addEvent("ready", function () {
			s && (l = !0, i());
		}), r = e;
	}function i() {
		return s ? (s.addEvent("cuechange", function () {
			1 == u && o.play();
		}), s.addEvent("play", function () {
			a.trigger(o.events.START_PLAYING);
		}), s.addEvent("pause", function () {
			a.trigger(o.events.STOP_PLAYING);
		}), void s.addEvent("finish", function () {
			a.trigger(o.events.STOP_PLAYING), a.trigger(o.events.VIDEO_ENDED);
		})) : !1;
	}this.isAPILoaded = !1;var n,
	    r,
	    o = this,
	    a = jQuery(this),
	    s = null,
	    l = !1,
	    u = !1;this.events = { START_PLAYING: "start_playing", STOP_PLAYING: "stop_playing", VIDEO_ENDED: "video_ended" }, this.loadAPI = function () {
		return 1 == g_ugVimeoAPI.isAPILoaded ? !0 : e() ? (g_ugVimeoAPI.isAPILoaded = !0, !0) : (g_ugFunctions.loadJs("f.vimeocdn.com/js/froogaloop2.min.js", !0), void (g_ugVimeoAPI.isAPILoaded = !0));
	}, this.doCommand = function (e) {
		if (null == s) return !1;if (0 == l) return !1;switch (e) {default:
				s.api(e);}
	}, this.pause = function () {
		o.doCommand("pause");
	}, this.play = function () {
		o.doCommand("play");
	}, this.destroy = function () {
		s && (s.api("unload"), s = null, l = !1), r && jQuery("#" + r).html("");
	}, this.putVideo = function (i, r, o, a, s) {
		return e() ? (t(i, r, o, a, s), !0) : (this.loadAPI(), void (n = setInterval(function () {
			e() && (t(i, r, o, a, s), clearInterval(n));
		}, 500)));
	}, this.isPlayerReady = function () {
		return l && s ? !0 : !1;
	}, this.changeVideo = function (e, t) {
		return 0 == o.isPlayerReady() ? !1 : (u = t, void s.api("loadVideo", e));
	}, this.getVideoImages = function (e, t, i) {
		var n = location.protocol + "//vimeo.com/api/v2/video/" + e + ".json";jQuery.get(n, {}, function (e) {
			var n = {};n.preview = e[0].thumbnail_large, n.thumb = e[0].thumbnail_medium, i(t, n);
		});
	};
}function UGYoutubeAPI() {
	function e(e, t, r, a, u) {
		s && l && s.destroy();var d = { controls: 2, showinfo: _.video_youtube_showinfo, rel: 0 };u === !0 && (d.autoplay = 1), l = !1, s = new YT.Player(e, { height: a, width: r, videoId: t, playerVars: d, events: { onReady: i, onStateChange: n } }), o = e;
	}function t() {
		return "undefined" != typeof YT && "undefined" != typeof YT.Player ? !0 : !1;
	}function i() {
		l = !0;
	}function n() {
		if ("function" != typeof s.getPlayerState) return trace("Youtube API error: can't get player state"), !1;var e = s.getPlayerState();switch (e) {case YT.PlayerState.PLAYING:
				u.trigger(a.events.START_PLAYING);break;case YT.PlayerState.ENDED:
				u.trigger(a.events.STOP_PLAYING), u.trigger(a.events.VIDEO_ENDED);break;default:
				d == YT.PlayerState.PLAYING && u.trigger(a.events.STOP_PLAYING);}d = e;
	}this.isAPILoaded = !1;var r,
	    o,
	    a = this,
	    s = null,
	    l = !1,
	    u = jQuery(this),
	    d = -1,
	    _ = { video_youtube_showinfo: !0 };this.events = { START_PLAYING: "start_playing", STOP_PLAYING: "stop_playing", VIDEO_ENDED: "video_ended" }, this.setOptions = function (e) {
		_ = jQuery.extend(_, e);
	}, this.putVideo = function (i, n, o, a, s) {
		return t() ? (e(i, n, o, a, s), !0) : (this.loadAPI(), void (r = setInterval(function () {
			t() && (e(i, n, o, a, s), clearInterval(r));
		}, 500)));
	}, this.loadAPI = function () {
		return 1 == g_ugYoutubeAPI.isAPILoaded ? !0 : "undefined" != typeof YT ? (g_ugYoutubeAPI.isAPILoaded = !0, !0) : (g_ugFunctions.loadJs("https://www.youtube.com/player_api", !1), void (g_ugYoutubeAPI.isAPILoaded = !0));
	}, this.doCommand = function (e, t) {
		if (!s) return !0;if (0 == l) return !1;switch (e) {case "play":
				if ("function" != typeof s.playVideo) return !1;s.playVideo();break;case "pause":
				if ("function" != typeof s.pauseVideo) return !1;s.pauseVideo();break;case "seek":
				if ("function" != typeof s.seekTo) return !1;s.seekTo(t);break;case "stopToBeginning":
				var i = s.getPlayerState();switch (s.pauseVideo(), i) {case YT.PlayerState.PLAYING:case YT.PlayerState.ENDED:case YT.PlayerState.PAUSED:
						s.seekTo(0);}}
	}, this.play = function () {
		a.doCommand("play");
	}, this.pause = function () {
		a.doCommand("pause");
	}, this.destroy = function () {
		try {
			s && (l = !1, s.clearVideo(), s.destroy());
		} catch (e) {
			jQuery("#" + o).html("");
		}
	}, this.stopToBeginning = function () {
		a.doCommand("stopToBeginning");
	}, this.changeVideo = function (e, t) {
		return 0 == a.isPlayerReady() ? !1 : void (t && 1 == t ? s.loadVideoById(e, 0, "large") : s.cueVideoById(e, 0, "large"));
	}, this.isPlayerReady = function () {
		return l && s ? !0 : !1;
	}, this.getVideoImages = function (e) {
		var t = {};return t.preview = "https://i.ytimg.com/vi/" + e + "/sddefault.jpg", t.thumb = "https://i.ytimg.com/vi/" + e + "/default.jpg", t;
	};
}function UGVideoPlayer() {
	function e() {
		h.hide();
	}function t() {
		p.trigger(h.events.PLAY_START), _ && _.hide();
	}function i() {
		p.trigger(h.events.PLAY_STOP), _ && _.show();
	}function n() {
		p.trigger(h.events.VIDEO_ENDED);
	}function r() {
		_ && (f.setButtonMobileReady(_), f.setButtonOnClick(_, e)), jQuery(m).on(m.events.START_PLAYING, t), jQuery(m).on(m.events.STOP_PLAYING, i), jQuery(m).on(m.events.VIDEO_ENDED, n), jQuery(v).on(v.events.START_PLAYING, t), jQuery(v).on(v.events.STOP_PLAYING, i), jQuery(v).on(v.events.VIDEO_ENDED, n), jQuery(b).on(b.events.START_PLAYING, t), jQuery(b).on(b.events.STOP_PLAYING, i), jQuery(b).on(b.events.VIDEO_ENDED, n), jQuery(y).on(y.events.START_PLAYING, t), jQuery(y).on(y.events.STOP_PLAYING, i), jQuery(y).on(y.events.VIDEO_ENDED, n), jQuery(I).on(I.events.START_PLAYING, t), jQuery(I).on(I.events.STOP_PLAYING, i), jQuery(I).on(I.events.VIDEO_ENDED, n);
	}function o(e) {
		var t = ["youtube", "vimeo", "html5", "soundcloud", "wistia"];for (var i in t) {
			var n = t[i];if (n != e) switch (n) {case "youtube":
					m.pause(), m.destroy(), l.hide();break;case "vimeo":
					v.pause(), v.destroy(), u.hide();break;case "html5":
					b.pause(), d.hide();break;case "soundcloud":
					y.pause(), y.destroy(), g.hide();break;case "wistia":
					I.pause(), c.hide();}
		}
	}var a,
	    s,
	    l,
	    u,
	    d,
	    _,
	    g,
	    c,
	    h = this,
	    p = jQuery(this),
	    f = new UGFunctions(),
	    m = new UGYoutubeAPI(),
	    v = new UGVimeoAPI(),
	    b = new UGHtml5MediaAPI(),
	    y = new UGSoundCloudAPI(),
	    I = new UGWistiaAPI(),
	    w = null,
	    E = { video_enable_closebutton: !0 };this.events = { SHOW: "video_show", HIDE: "video_hide", PLAY_START: "video_play_start", PLAY_STOP: "video_play_stop", VIDEO_ENDED: "video_ended" };var T = { standAloneMode: !1, youtubeInnerID: "", vimeoPlayerID: "", html5PlayerID: "", wistiaPlayerID: "", soundCloudPlayerID: "" };this.init = function (e, t, i) {
		if (a = i, !a) throw new Error("missing gallery ID for video player, it's a must!");E = jQuery.extend(E, e), m.setOptions(E), t && 1 == t && (T.standAloneMode = !0);
	}, this.setHtml = function (e) {
		T.youtubeInnerID = a + "_youtube_inner", T.vimeoPlayerID = a + "_videoplayer_vimeo", T.html5PlayerID = a + "_videoplayer_html5", T.wistiaPlayerID = a + "_videoplayer_wistia", T.soundCloudPlayerID = a + "_videoplayer_soundcloud";var t = "<div class='ug-videoplayer' style='display:none'>";t += "<div class='ug-videoplayer-wrapper ug-videoplayer-youtube' style='display:none'><div id='" + T.youtubeInnerID + "'></div></div>", t += "<div id='" + T.vimeoPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-vimeo' style='display:none'></div>", t += "<div id='" + T.html5PlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-html5'></div>", t += "<div id='" + T.soundCloudPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-soundcloud'></div>", t += "<div id='" + T.wistiaPlayerID + "' class='ug-videoplayer-wrapper ug-videoplayer-wistia'></div>", 0 == T.standAloneMode && 1 == E.video_enable_closebutton && (t += "<div class='ug-videoplayer-button-close'></div>"), t += "</div>", e.append(t), s = e.children(".ug-videoplayer"), l = s.children(".ug-videoplayer-youtube"), u = s.children(".ug-videoplayer-vimeo"), d = s.children(".ug-videoplayer-html5"), g = s.children(".ug-videoplayer-soundcloud"), c = s.children(".ug-videoplayer-wistia"), 0 == T.standAloneMode && 1 == E.video_enable_closebutton && (_ = s.children(".ug-videoplayer-button-close"));
	}, this.destroy = function () {
		_ && (_.off("click"), _.off("touchend")), jQuery(m).off(m.events.START_PLAYING), jQuery(m).off(m.events.STOP_PLAYING), jQuery(v).off(v.events.START_PLAYING), jQuery(v).off(v.events.STOP_PLAYING), jQuery(b).off(b.events.START_PLAYING), jQuery(b).off(b.events.STOP_PLAYING), jQuery(y).off(y.events.START_PLAYING, t), jQuery(y).off(y.events.STOP_PLAYING, i), jQuery(I).off(I.events.START_PLAYING, t), jQuery(I).off(I.events.STOP_PLAYING, i), w = null;
	}, this.initEvents = function () {
		r();
	}, this.setSize = function (e, t) {
		f.setElementSize(s, e, t), _ && f.placeElement(_, "right", "top");
	}, this.setPosition = function (e, t) {
		f.placeElement(s, e, t);
	}, this.getObject = function () {
		return s;
	}, this.show = function () {
		return 1 == h.isVisible() ? !0 : (s.show(), s.fadeTo(0, 1), _ && _.show(), void p.trigger(h.events.SHOW));
	}, this.hide = function () {
		return 0 == h.isVisible() ? !0 : (o(), w = null, s.hide(), void p.trigger(h.events.HIDE));
	}, this.getActiveAPI = function () {
		switch (w) {case "youtube":
				return m;case "vimeo":
				return v;case "wistia":
				return I;case "soundcloud":
				return y;case "html5":
				return b;default:
				return null;}
	}, this.pause = function () {
		var e = h.getActiveAPI();return null == e ? !1 : void ("function" == typeof e.pause && e.pause());
	}, this.isVisible = function () {
		return s.is(":visible");
	}, this.playYoutube = function (e, t) {
		if ("undefined" == typeof t) var t = !0;o("youtube"), l.show();var i = l.children("#" + T.youtubeInnerID);0 == i.length && l.append("<div id='" + T.youtubeInnerID + "'></div>"), 1 == m.isPlayerReady() && 1 == T.standAloneMode ? m.changeVideo(e, t) : m.putVideo(T.youtubeInnerID, e, "100%", "100%", t), w = "youtube";
	}, this.playVimeo = function (e, t) {
		if ("undefined" == typeof t) var t = !0;o("vimeo"), u.show(), v.putVideo(T.vimeoPlayerID, e, "100%", "100%", t), w = "vimeo";
	}, this.playHtml5Video = function (e, t, i, n, r) {
		if ("undefined" == typeof r) var r = !0;o("html5"), d.show();var a = { ogv: e, webm: t, mp4: i, posterImage: n };b.putVideo(T.html5PlayerID, a, "100%", "100%", r), w = "html5";
	}, this.playSoundCloud = function (e, t) {
		if ("undefined" == typeof t) var t = !0;o("soundcloud"), g.show(), y.putSound(T.soundCloudPlayerID, e, "100%", "100%", t), w = "soundcloud";
	}, this.playWistia = function (e, t) {
		if ("undefined" == typeof t) var t = !0;o("wistia"), c.show(), I.putVideo(T.wistiaPlayerID, e, "100%", "100%", t), w = "wistia";
	};
}function ugCheckForMinJQueryVersion() {
	var e = g_ugFunctions.checkMinJqueryVersion("1.8.0");if (0 == e) throw new Error("The gallery can run from jquery 1.8 You have jQuery " + jQuery.fn.jquery + " Please update your jQuery library.");
}function ugCheckForErrors(e, t) {
	function i() {
		if ("undefined" == typeof jQuery) throw new Error("jQuery library not included");
	}function n() {
		if ("function" == typeof jQuery.fn.unitegallery) return !0;var e = "You have some jquery.js library include that comes after the gallery files js include.";throw e += "<br> This include eliminates the gallery libraries, and make it not work.", "cms" == t ? (e += "<br><br> To fix it you can:<br>&nbsp;&nbsp;&nbsp; 1. In the Gallery Settings -> Troubleshooting set option:  <strong><b>Put JS Includes To Body</b></strong> option to true.", e += "<br>&nbsp;&nbsp;&nbsp; 2. Find the double jquery.js include and remove it.") : e += "<br><br> Please find and remove this jquery.js include and the gallery will work. <br> * There should be only one jquery.js include before all other js includes in the page.", new Error(e);
	}try {
		"jquery" == t ? (i(), ugCheckForMinJQueryVersion()) : (ugCheckForMinJQueryVersion(), n());
	} catch (r) {
		var o = r.message;if (o = "Unite Gallery Error: " + o, o = "<div style='font-size:16px;color:#BC0C06;max-width:900px;border:1px solid red;padding:10px;'>" + o + "</div>", "jquery" == t) {
			var a = document.getElementById(e);a.innerHTML = o, a.style.display = "block";
		} else jQuery(e).show().html(o);return !1;
	}return !0;
}function UniteGalleryMain() {
	function __________INIT_GALLERY_______() {}function getThemeFunction(e) {
		var t = e;return -1 == t.indexOf("UGTheme_") && (t = "UGTheme_" + t), t;
	}function initTheme(objCustomOptions) {
		if (objCustomOptions.hasOwnProperty("gallery_theme")) g_options.gallery_theme = objCustomOptions.gallery_theme;else {
			var defaultTheme = g_options.gallery_theme;0 == g_ugFunctions.isThemeRegistered(defaultTheme) && (g_options.gallery_theme = g_ugFunctions.getFirstRegisteredTheme());
		}var themeFunction = getThemeFunction(g_options.gallery_theme);try {
			g_options.gallery_theme = eval(themeFunction);
		} catch (e) {}g_options.gallery_theme = eval(themeFunction), g_objTheme = new g_options.gallery_theme(), g_objTheme.init(t, objCustomOptions);
	}function resetOptions() {
		g_options = jQuery.extend({}, g_temp.originalOptions), g_selectedItemIndex = -1, g_selectedItem = null, g_objSlider = void 0, g_objThumbs = void 0, g_objSlider = void 0;
	}function checkForStartupErrors() {
		try {
			ugCheckForMinJQueryVersion();
		} catch (e) {
			throwErrorShowMessage(e.message);
		}"object" == _typeof(g_objWrapper.outerWidth()) && throwErrorShowMessage("You have some buggy script. most chances jquery-ui.js that destroy jquery outerWidth, outerHeight functions. The gallery can't run. Please update jquery-ui.js to latest version."), setTimeout(function () {
			ugCheckForErrors(g_galleryID, "cms");
		}, 5e3);
	}function runGallery(e, i, n, r) {
		var o = "object" == (typeof i === 'undefined' ? 'undefined' : _typeof(i));if (o && (g_temp.objCustomOptions = i), 1 == g_temp.isRunFirstTime) {
			if (g_galleryID = e, g_objWrapper = jQuery(g_galleryID), 0 == g_objWrapper.length) return trace("div with id: " + g_galleryID + " not found"), !1;g_objParent = g_objWrapper.parent(), checkForStartupErrors(), g_temp.originalOptions = jQuery.extend({}, g_options), o && (g_options = jQuery.extend(g_options, i)), 1 == g_options.gallery_enable_cache && g_options.gallery_initial_catid && cacheItems(g_options.gallery_initial_catid), t.setSizeClass();var a = g_objWrapper.children();fillItemsArray(a), loadAPIs(), g_objWrapper.find("img").fadeTo(0, 0).hide(), g_objWrapper.show(), clearInitData();
		} else if (t.destroy(), resetOptions(), g_options = jQuery.extend(g_options, g_temp.objCustomOptions), n) {
			if (r && 1 == g_options.gallery_enable_cache && cacheItems(r, n), "noitems" == n) return showErrorMessage("No items in this category", ""), !1;g_objWrapper.html(n);var a = g_objWrapper.children();fillItemsArray(a), loadAPIs(), g_objWrapper.children().fadeTo(0, 0).hide(), g_objWrapper.show(), clearInitData();
		}1 == g_temp.isRunFirstTime && 1 == g_options.gallery_enable_tabs && (g_objTabs = new UGTabs(), g_objTabs.init(t, g_options)), 1 == g_temp.isRunFirstTime && 1 == g_options.gallery_enable_loadmore && (g_objLoadMore = new UGLoadMore(), g_objLoadMore.init(t, g_options)), o && modifyInitParams(g_temp.objCustomOptions), validateParams(), 1 == g_options.gallery_shuffle && t.shuffleItems(), initTheme(g_temp.objCustomOptions), setGalleryHtml(), setHtmlObjectsProperties();var s = g_objWrapper.width();0 == s ? g_functions.waitForWidth(g_objWrapper, runGalleryActually) : runGalleryActually();
	}function runGalleryActually() {
		t.setSizeClass(), 0 == g_temp.isFreestyleMode && 1 == g_options.gallery_preserve_ratio && setHeightByOriginalRatio(), g_objTheme.run(), g_objTabs && g_temp.isRunFirstTime && g_objTabs.run(), preloadBigImages(), initEvents(), g_numItems > 0 && t.selectItem(0), 1 == g_options.gallery_autoplay && t.startPlayMode(), g_temp.isRunFirstTime = !1;
	}function showErrorMessage(e, t) {
		if ("undefined" == typeof t) var t = "<b>Unite Gallery Error: </b>";else t = "<b>" + t + ": </b>";e = t + e;var i = "<div class='ug-error-message-wrapper'><div class='ug-error-message'>" + e + "</div></div>";g_objWrapper.children().remove(), g_objWrapper.html(i), g_objWrapper.show();
	}function throwErrorShowMessage(e) {
		throw showErrorMessage(e), new Error(e);
	}function modifyInitParams() {
		g_options.gallery_images_preload_type || (g_options.gallery_images_preload_type = "minimal"), (void 0 == g_options.gallery_min_height || g_options.gallery_height < g_options.gallery_min_height) && (g_options.gallery_min_height = 0), (void 0 == g_options.gallery_min_width || g_options.gallery_width < g_options.gallery_min_width) && (g_options.gallery_min_width = 0);
	}function validateParams() {
		if (!g_options.gallery_theme) throw new Error("The gallery can't run without theme");if (jQuery.isNumeric(g_options.gallery_height) && g_options.gallery_height < g_options.gallery_min_height) throw new Error("The <b>gallery_height</b> option must be bigger then <b>gallery_min_height option</b>");if (g_options.gallery_width < g_options.gallery_min_width) throw new Error("The <b>gallery_width</b> option must be bigger then <b>gallery_min_width option</b>");
	}function setGalleryHtml() {
		g_objWrapper.addClass("ug-gallery-wrapper"), g_objWrapper.append("<div class='ug-overlay-disabled' style='display:none'></div>"), t.setSizeClass();
	}function clearInitData() {
		g_objWrapper.children().remove();
	}function storeLastSize() {
		var e = t.getSize();g_temp.lastWidth = e.width, g_temp.lastHeight = e.height;
	}function setHeightByOriginalRatio() {
		var e = t.getSize(),
		    i = e.width / e.height;if (i != e.orig_ratio) {
			var n = e.width / e.orig_ratio;n = Math.round(n), n < g_options.gallery_min_height && (n = g_options.gallery_min_height), g_objWrapper.height(n);
		}
	}function setHtmlObjectsProperties() {
		var e = g_functions.getCssSizeParam(g_options.gallery_width),
		    t = { "max-width": e, "min-width": g_functions.getCssSizeParam(g_options.gallery_min_width) };if (0 == g_temp.isFreestyleMode) {
			var i = g_functions.getCssSizeParam(g_options.gallery_height);t.height = i;
		} else t.overflow = "visible";g_options.gallery_background_color && (t["background-color"] = g_options.gallery_background_color), g_objWrapper.css(t);
	}function fillItemByChild(e) {
		var i = t.isMobileMode(),
		    n = e.prop("tagName").toLowerCase(),
		    r = "";if ("a" == n) {
			r = e.attr("href"), e = e.children();var n = e.prop("tagName").toLowerCase();
		}var o = e.data("type");void 0 == o && (o = "image");var a = {};if (a.type = o, "img" == n) {
			var s = e.data("lazyload-src");s && "" != s && (e.attr("src", s), jQuery.removeData(e, "lazyload-src"));var l = e.data("image"),
			    u = e.data("thumb");"undefined" == typeof l && (l = null), "undefined" == typeof u && (u = null);var d = e.attr("src");l || (l = d), u || (u = d), u || (u = l), l || (l = u), a.urlThumb = u, a.urlImage = l, a.title = e.attr("alt"), a.objThumbImage = e, a.objThumbImage.attr("src", a.urlThumb);
		} else {
			if ("image" == o) throw trace("Problematic gallery item found:"), trace(e), trace("Please look for some third party js script that could add this item to the gallery"), new Error("The item should not be image type");a.urlThumb = e.data("thumb"), a.title = e.data("title"), a.objThumbImage = null, a.urlImage = e.data("image");
		}if (1 == i) {
			var _ = e.data("thumb-mobile");"undefined" != typeof _ && "" != _ && (a.urlThumb = _, "img" == n && e.attr("src", a.urlThumb));var g = e.data("image-mobile");"undefined" != typeof g && "" != g && (a.urlImage = g);
		}a.link = r, a.description = e.attr("title"), a.description || (a.description = e.data("description")), a.description || (a.description = ""), a.isNewAdded = !1, a.isLoaded = !1, a.isThumbImageLoaded = !1, a.objPreloadImage = null, a.isBigImageLoadStarted = !1, a.isBigImageLoaded = !1, a.isBigImageLoadError = !1, a.imageWidth = 0, a.imageHeight = 0, a.thumbWidth = 0, a.thumbHeight = 0, a.thumbRatioByWidth = 0, a.thumbRatioByHeight = 0;var c = e.data("width"),
		    h = e.data("height");c && "number" == typeof c && h && "number" == typeof h && (a.thumbWidth = c, a.thumbHeight = h, a.thumbRatioByWidth = c / h, a.thumbRatioByHeight = h / c), a.addHtml = null;var p = void 0 == a.urlImage || "" == a.urlImage,
		    f = void 0 == a.urlThumb || "" == a.urlThumb;switch (a.type) {case "youtube":
				if (a.videoid = e.data("videoid"), p || f) {
					var m = g_ugYoutubeAPI.getVideoImages(a.videoid);p && (a.urlImage = m.preview), f && (a.urlThumb = m.thumb, "img" == n && e.attr("src", a.urlThumb));
				}g_temp.isYoutubePresent = !0;break;case "vimeo":
				a.videoid = e.data("videoid"), g_temp.isVimeoPresent = !0;break;case "html5video":
				a.videoogv = e.data("videoogv"), a.videowebm = e.data("videowebm"), a.videomp4 = e.data("videomp4"), g_temp.isHtml5VideoPresent = !0;break;case "soundcloud":
				a.trackid = e.data("trackid"), g_temp.isSoundCloudPresent = !0;break;case "wistia":
				a.videoid = e.data("videoid"), g_temp.isWistiaPresent = !0;break;case "custom":
				var v = e.children("img");v.length && (v = jQuery(v[0]), a.urlThumb = v.attr("src"), a.title = v.attr("alt"), a.objThumbImage = v);var b = e.children().not("img:first-child");b.length && (a.addHtml = b.clone());}return a.objThumbImage && (a.objThumbImage.removeAttr("data-description", ""), a.objThumbImage.removeAttr("data-image", ""), a.objThumbImage.removeAttr("data-thumb", ""), a.objThumbImage.removeAttr("title", "")), a;
	}function fillItemsArray(e, t) {
		if (t !== !0) g_arrItems = [];else for (var i = 0; g_numItems > i; i++) {
			g_arrItems[i].isNewAdded = !1;
		}for (var i = 0; i < e.length; i++) {
			var n = jQuery(e[i]),
			    r = fillItemByChild(n);numIndex = g_arrItems.length, r.index = numIndex, t === !0 && (r.isNewAdded = !0), g_arrItems.push(r);
		}g_numItems = g_arrItems.length;
	}function loadAPIs() {
		g_temp.isYoutubePresent && g_ugYoutubeAPI.loadAPI(), g_temp.isVimeoPresent && g_ugVimeoAPI.loadAPI(), g_temp.isHtml5VideoPresent && g_ugHtml5MediaAPI.loadAPI(), g_temp.isSoundCloudPresent && g_ugSoundCloudAPI.loadAPI(), g_temp.isWistiaPresent && g_ugWistiaAPI.loadAPI();
	}function preloadBigImages() {
		if ("visible" != g_options.gallery_images_preload_type || g_objThumbs || (g_options.gallery_images_preload_type = "minimal"), 1 == g_temp.isAllItemsPreloaded) return !0;switch (g_options.gallery_images_preload_type) {default:case "minimal":
				break;case "all":
				jQuery(g_arrItems).each(function () {
					preloadItemImage(this);
				});break;case "visible":
				jQuery(g_arrItems).each(function () {
					var e = this,
					    t = g_objThumbs.isItemThumbVisible(e);1 == t && preloadItemImage(e);
				});}
	}function checkPreloadItemImage(e) {
		if (1 == e.isBigImageLoadStarted || 1 == e.isBigImageLoaded || 1 == e.isBigImageLoadError) return !1;switch (g_options.gallery_images_preload_type) {default:case "minimal":
				break;case "all":
				preloadItemImage(e);break;case "visible":
				var t = g_objThumbs.isItemThumbVisible(e);1 == t && preloadItemImage(e);}
	}function preloadItemImage(e) {
		if (1 == e.isBigImageLoadStarted || 1 == e.isBigImageLoaded || 1 == e.isBigImageLoadError) return !0;var i = e.urlImage;
		return "" == i || void 0 == i ? (e.isBigImageLoadError = !0, !1) : (e.isBigImageLoadStarted = !0, e.objPreloadImage = jQuery("<img/>").attr("src", i), e.objPreloadImage.data("itemIndex", e.index), e.objPreloadImage.on("load", t.onItemBigImageLoaded), e.objPreloadImage.on("error", function () {
			var e = jQuery(this),
			    i = e.data("itemIndex"),
			    n = g_arrItems[i];n.isBigImageLoadError = !0, n.isBigImageLoaded = !1;var r = jQuery(this).attr("src");console.log("Can't load image: " + r), g_objGallery.trigger(t.events.ITEM_IMAGE_UPDATED, [i, n.urlImage]), n.objThumbImage.attr("src", n.urlThumb);
		}), void checkAllItemsStartedPreloading());
	}function preloadNearBigImages(e) {
		if (1 == g_temp.isAllItemsPreloaded) return !1;if (!e) var e = g_selectedItem;if (!e) return !0;var t = e.index,
		    i = t - 1,
		    n = t + 1;i > 0 && preloadItemImage(g_arrItems[i]), g_numItems > n && preloadItemImage(g_arrItems[n]);
	}function checkAllItemsStartedPreloading() {
		if (1 == g_temp.isAllItemsPreloaded) return !1;for (var e in g_arrItems) {
			if (0 == g_arrItems[e].isBigImageLoadStarted) return !1;
		}g_temp.isAllItemsPreloaded = !0;
	}function __________END_INIT_GALLERY_______() {}function __________EVENTS_____________() {}function onSliderMouseEnter(e) {
		1 == g_options.gallery_pause_on_mouseover && 0 == t.isFullScreen() && 1 == g_temp.isPlayMode && g_objSlider && 0 == g_objSlider.isSlideActionActive() && t.pausePlaying();
	}function onSliderMouseLeave(e) {
		if (1 == g_options.gallery_pause_on_mouseover && 1 == g_temp.isPlayMode && g_objSlider && 0 == g_objSlider.isSlideActionActive()) {
			var i = g_objSlider.isCurrentSlideLoadingImage();0 == i && t.continuePlaying();
		}
	}function onKeyPress(e) {
		var i = jQuery(e.target);if (i.is("textarea") || i.is("select") || i.is("input")) return !0;var n = e.charCode ? e.charCode : e.keyCode ? e.keyCode : e.which ? e.which : 0,
		    r = !0;switch (n) {case 39:
				t.nextItem();break;case 37:
				t.prevItem();break;default:
				r = !1;}1 == r && (e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation()), g_objGallery.trigger(t.events.GALLERY_KEYPRESS, [n, e]);
	}function onGalleryResized() {
		var e = t.getSize();if (0 == e.width) return !0;t.setSizeClass();var e = t.getSize();if (e.width != g_temp.lastWidth || 0 == g_temp.isFreestyleMode && e.height != g_temp.lastHeight) {
			var i = !1;if (g_temp.funcCustomHeight) {
				var n = g_temp.funcCustomHeight(e);n && (g_objWrapper.height(n), i = !0);
			}0 == i && 1 == g_options.gallery_preserve_ratio && 0 == g_temp.isFreestyleMode && setHeightByOriginalRatio(), storeLastSize(), g_objGallery.trigger(t.events.SIZE_CHANGE);
		}
	}function onThumbsChange(e) {
		"visible" == g_options.gallery_images_preload_type && 0 == g_temp.isAllItemsPreloaded && preloadBigImages();
	}function onFullScreenChange() {
		var e = g_functions.isFullScreen(),
		    i = e ? t.events.ENTER_FULLSCREEN : t.events.EXIT_FULLSCREEN,
		    n = g_functions.getGlobalData("fullscreenID");return g_galleryID !== n ? !0 : (e ? g_objWrapper.addClass("ug-fullscreen") : g_objWrapper.removeClass("ug-fullscreen"), g_objGallery.trigger(i), void onGalleryResized());
	}function onItemImageUpdated(e, i) {
		var n = t.getItem(i);checkPreloadItemImage(n);
	}function onCurrentSlideImageLoadEnd() {
		1 == t.isPlayMode() && t.continuePlaying();
	}function initEvents() {
		if (g_objWrapper.on("dragstart", function (e) {
			e.preventDefault();
		}), g_objGallery.on(t.events.ITEM_IMAGE_UPDATED, onItemImageUpdated), g_objThumbs) switch (g_temp.thumbsType) {case "strip":
				jQuery(g_objThumbs).on(g_objThumbs.events.STRIP_MOVE, onThumbsChange);break;case "grid":
				jQuery(g_objThumbs).on(g_objThumbs.events.PANE_CHANGE, onThumbsChange);}if ("advance" == g_options.gallery_mousewheel_role && 0 == g_temp.isFreestyleMode && g_objWrapper.on("mousewheel", t.onGalleryMouseWheel), storeLastSize(), jQuery(window).resize(function () {
			g_objWrapper.css("width", "auto"), g_functions.whenContiniousEventOver("gallery_resize", onGalleryResized, g_temp.resizeDelay);
		}), setTimeout(function () {
			setInterval(onGalleryResized, 2e3);
		}, 1e4), g_functions.addFullScreenChangeEvent(onFullScreenChange), g_objSlider) {
			if (jQuery(g_objSlider).on(g_objSlider.events.ITEM_CHANGED, function () {
				var e = g_objSlider.getCurrentItemIndex();-1 != e && t.selectItem(e);
			}), 1 == g_options.gallery_pause_on_mouseover) {
				var e = g_objSlider.getElement();e.hover(onSliderMouseEnter, onSliderMouseLeave), g_objGallery.on(t.events.ENTER_FULLSCREEN, function () {
					onSliderMouseLeave();
				});
			}retriggerEvent(g_objSlider, g_objSlider.events.ACTION_START, t.events.SLIDER_ACTION_START), retriggerEvent(g_objSlider, g_objSlider.events.ACTION_END, t.events.SLIDER_ACTION_END), jQuery(g_objSlider).on(g_objSlider.events.CURRENTSLIDE_LOAD_END, onCurrentSlideImageLoadEnd);
		}1 == g_options.gallery_control_keyboard && jQuery(document).keydown(onKeyPress);
	}function __________GENERAL_______() {}function cacheItems(e, t) {
		if (t) {
			var i = t;"noitems" != i && (i = jQuery(t).clone());
		} else var i = g_objWrapper.children().clone();g_objCache[e] = i;
	}function removeAllSizeClasses(e) {
		e || (e = g_objWrapper), e.removeClass("ug-under-480"), e.removeClass("ug-under-780"), e.removeClass("ug-under-960");
	}function retriggerEvent(e, t, i) {
		jQuery(e).on(t, function (e) {
			g_objGallery.trigger(i, [this]);
		});
	}function advanceNextStep() {
		var e = jQuery.now(),
		    i = e - g_temp.playTimeLastStep;g_temp.playTimeLastStep = e;var n = t.isGalleryVisible();if (0 == n) return !1;if (g_temp.playTimePassed += i, g_temp.objProgress) {
			var r = g_temp.playTimePassed / g_options.gallery_play_interval;g_temp.objProgress.setProgress(r);
		}g_temp.playTimePassed >= g_options.gallery_play_interval && (t.nextItem(), g_temp.playTimePassed = 0);
	}function unselectSeletedItem() {
		return null == g_selectedItem ? !0 : (g_objThumbs && g_objThumbs.setThumbUnselected(g_selectedItem.objThumbWrapper), g_selectedItem = null, void (g_selectedItemIndex = -1));
	}function toFakeFullScreen() {
		jQuery("body").addClass("ug-body-fullscreen"), g_objWrapper.addClass("ug-fake-fullscreen"), g_temp.isFakeFullscreen = !0, g_objGallery.trigger(t.events.ENTER_FULLSCREEN), g_objGallery.trigger(t.events.SIZE_CHANGE);
	}function exitFakeFullscreen() {
		jQuery("body").removeClass("ug-body-fullscreen"), g_objWrapper.removeClass("ug-fake-fullscreen"), g_temp.isFakeFullscreen = !1, g_objGallery.trigger(t.events.EXIT_FULLSCREEN), g_objGallery.trigger(t.events.SIZE_CHANGE);
	}var t = this,
	    g_galleryID,
	    g_objGallery = jQuery(t),
	    g_objWrapper,
	    g_objParent,
	    g_objThumbs,
	    g_objSlider,
	    g_functions = new UGFunctions(),
	    g_objTabs,
	    g_objLoadMore,
	    g_arrItems = [],
	    g_numItems,
	    g_selectedItem = null,
	    g_selectedItemIndex = -1,
	    g_objTheme,
	    g_objCache = {};this.events = { ITEM_CHANGE: "item_change", SIZE_CHANGE: "size_change", ENTER_FULLSCREEN: "enter_fullscreen", EXIT_FULLSCREEN: "exit_fullscreen", START_PLAY: "start_play", STOP_PLAY: "stop_play", PAUSE_PLAYING: "pause_playing", CONTINUE_PLAYING: "continue_playing", SLIDER_ACTION_START: "slider_action_start", SLIDER_ACTION_END: "slider_action_end", ITEM_IMAGE_UPDATED: "item_image_updated", GALLERY_KEYPRESS: "gallery_keypress", GALLERY_BEFORE_REQUEST_ITEMS: "gallery_before_request_items", OPEN_LIGHTBOX: "open_lightbox", CLOSE_LIGHTBOX: "close_lightbox" };var g_options = { gallery_width: 900, gallery_height: 500, gallery_min_width: 150, gallery_min_height: 100, gallery_theme: "default", gallery_skin: "default", gallery_images_preload_type: "minimal", gallery_autoplay: !1, gallery_play_interval: 3e3, gallery_pause_on_mouseover: !0, gallery_mousewheel_role: "zoom", gallery_control_keyboard: !0, gallery_carousel: !0, gallery_preserve_ratio: !0, gallery_background_color: "", gallery_debug_errors: !1, gallery_shuffle: !1, gallery_urlajax: null, gallery_enable_tabs: !1, gallery_enable_loadmore: !1, gallery_enable_cache: !0, gallery_initial_catid: "" },
	    g_temp = { objCustomOptions: {}, isAllItemsPreloaded: !1, isFreestyleMode: !1, lastWidth: 0, lastHeigh: 0, handleResize: null, isInited: !1, isPlayMode: !1, isPlayModePaused: !1, playTimePassed: 0, playTimeLastStep: 0, playHandle: "", playStepInterval: 33, objProgress: null, isFakeFullscreen: !1, thumbsType: null, isYoutubePresent: !1, isVimeoPresent: !1, isHtml5VideoPresent: !1, isSoundCloudPresent: !1, isWistiaPresent: !1, resizeDelay: 100, isRunFirstTime: !0, originalOptions: {}, funcCustomHeight: null };this.onItemBigImageLoaded = function (e, t) {
		if (!t) var t = jQuery(this);var i = t.data("itemIndex"),
		    n = g_arrItems[i];n.isBigImageLoaded = !0;var r = g_functions.getImageOriginalSize(t);n.imageWidth = r.width, n.imageHeight = r.height;
	}, this.checkFillImageSize = function (e, t) {
		if (!t) {
			var i = e.data("itemIndex");if (void 0 === i) throw new Error("Wrong image given to gallery.checkFillImageSize");var t = g_arrItems[i];
		}var n = g_functions.getImageOriginalSize(e);t.imageWidth = n.width, t.imageHeight = n.height;
	}, this.setFreestyleMode = function () {
		g_temp.isFreestyleMode = !0;
	}, this.attachThumbsPanel = function (e, t) {
		g_temp.thumbsType = e, g_objThumbs = t;
	}, this.initSlider = function (e, i) {
		if (!e) var e = {};e = jQuery.extend(g_temp.objCustomOptions, e), g_objSlider = new UGSlider(), g_objSlider.init(t, e, i);
	}, this.onGalleryMouseWheel = function (e, i, n, r) {
		e.preventDefault(), i > 0 ? t.prevItem() : t.nextItem();
	}, this.destroy = function () {
		if (g_objWrapper.off("dragstart"), g_objGallery.off(t.events.ITEM_IMAGE_UPDATED), g_objThumbs) switch (g_temp.thumbsType) {case "strip":
				jQuery(g_objThumbs).off(g_objThumbs.events.STRIP_MOVE);break;case "grid":
				jQuery(g_objThumbs).off(g_objThumbs.events.PANE_CHANGE);}if (g_objWrapper.off("mousewheel"), jQuery(window).off("resize"), g_functions.destroyFullScreenChangeEvent(), g_objSlider) {
			jQuery(g_objSlider).off(g_objSlider.events.ITEM_CHANGED);var e = g_objSlider.getElement();e.off("mouseenter"), e.off("mouseleave"), g_objGallery.off(t.events.ENTER_FULLSCREEN), jQuery(g_objSlider).off(g_objSlider.events.ACTION_START), jQuery(g_objSlider).off(g_objSlider.events.ACTION_END), jQuery(g_objSlider).off(g_objSlider.events.CURRENTSLIDE_LOAD_END);
		}1 == g_options.gallery_control_keyboard && jQuery(document).off("keydown"), g_objTheme && "function" == typeof g_objTheme.destroy && g_objTheme.destroy(), g_objWrapper.html("");
	}, this.getArrItems = function () {
		return g_arrItems;
	}, this.getObjects = function () {
		var e = { g_galleryID: g_galleryID, g_objWrapper: g_objWrapper, g_objThumbs: g_objThumbs, g_objSlider: g_objSlider, g_options: g_options, g_arrItems: g_arrItems, g_numItems: g_numItems };return e;
	}, this.getObjSlider = function () {
		return g_objSlider;
	}, this.getItem = function (e) {
		if (0 > e) throw new Error("item with index: " + e + " not found");if (e >= g_numItems) throw new Error("item with index: " + e + " not found");return g_arrItems[e];
	}, this.getWidth = function () {
		var e = t.getSize();return e.width;
	}, this.getHeight = function () {
		var e = t.getSize();return e.height;
	}, this.getSize = function () {
		var e = g_functions.getElementSize(g_objWrapper);return e.orig_width = g_options.gallery_width, e.orig_height = g_options.gallery_height, e.orig_ratio = e.orig_width / e.orig_height, e;
	}, this.getGalleryID = function () {
		var e = g_galleryID.replace("#", "");return e;
	}, this.getNextItem = function (e, t) {
		"object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) && (e = e.index);var i = e + 1;if (t !== !0 && 1 == g_numItems) return null;if (i >= g_numItems) {
			if (1 != g_options.gallery_carousel && t !== !0) return null;i = 0;
		}var n = g_arrItems[i];return n;
	}, this.getPrevItem = function (e) {
		"object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) && (e = e.index);var t = e - 1;if (0 > t) {
			if (1 != g_options.gallery_carousel && forceCarousel !== !0) return null;t = g_numItems - 1;
		}var i = g_arrItems[t];return i;
	}, this.getSelectedItem = function () {
		return g_selectedItem;
	}, this.getSelectedItemIndex = function () {
		return g_selectedItemIndex;
	}, this.getNumItems = function () {
		return g_numItems;
	}, this.isLastItem = function () {
		return g_selectedItemIndex == g_numItems - 1 ? !0 : !1;
	}, this.isFirstItem = function () {
		return 0 == g_selectedItemIndex ? !0 : !1;
	}, this.getOptions = function () {
		return g_options;
	}, this.getElement = function () {
		return g_objWrapper;
	}, this.___________SET_CONTROLS___________ = function () {}, this.setNextButton = function (e) {
		e.data("ug-button", !0), g_functions.setButtonOnClick(e, t.nextItem);
	}, this.setPrevButton = function (e) {
		e.data("ug-button", !0), g_functions.setButtonOnClick(e, t.prevItem);
	}, this.setFullScreenToggleButton = function (e) {
		e.data("ug-button", !0), g_functions.setButtonOnTap(e, t.toggleFullscreen), g_objGallery.on(t.events.ENTER_FULLSCREEN, function () {
			e.addClass("ug-fullscreenmode");
		}), g_objGallery.on(t.events.EXIT_FULLSCREEN, function () {
			e.removeClass("ug-fullscreenmode");
		});
	}, this.destroyFullscreenButton = function (e) {
		g_functions.destroyButton(e), g_objGallery.off(t.events.ENTER_FULLSCREEN), g_objGallery.off(t.events.EXIT_FULLSCREEN);
	}, this.setPlayButton = function (e) {
		e.data("ug-button", !0), g_functions.setButtonOnClick(e, t.togglePlayMode), g_objGallery.on(t.events.START_PLAY, function () {
			e.addClass("ug-stop-mode");
		}), g_objGallery.on(t.events.STOP_PLAY, function () {
			e.removeClass("ug-stop-mode");
		});
	}, this.destroyPlayButton = function (e) {
		g_functions.destroyButton(e), g_objGallery.off(t.events.START_PLAY), g_objGallery.off(t.events.STOP_PLAY);
	}, this.setProgressIndicator = function (e) {
		g_temp.objProgress = e;
	}, this.setTextContainers = function (e, i) {
		g_objGallery.on(t.events.ITEM_CHANGE, function () {
			var n = t.getSelectedItem();e.html(n.title), i.html(n.description);
		});
	}, this.showDisabledOverlay = function () {
		g_objWrapper.children(".ug-overlay-disabled").show();
	}, this.hideDisabledOverlay = function () {
		g_objWrapper.children(".ug-overlay-disabled").hide();
	}, this.___________END_SET_CONTROLS___________ = function () {}, this.___________PLAY_MODE___________ = function () {}, this.startPlayMode = function () {
		if (g_temp.isPlayMode = !0, g_temp.isPlayModePaused = !1, g_temp.playTimePassed = 0, g_temp.playTimeLastStep = jQuery.now(), g_temp.playHandle = setInterval(advanceNextStep, g_temp.playStepInterval), g_temp.objProgress) {
			var e = g_temp.objProgress.getElement();g_temp.objProgress.setProgress(0), e.show();
		}g_objGallery.trigger(t.events.START_PLAY), g_objSlider && 1 == g_objSlider.isCurrentSlideLoadingImage() && t.pausePlaying();
	}, this.resetPlaying = function () {
		return 0 == g_temp.isPlayMode ? !0 : (g_temp.playTimePassed = 0, void (g_temp.playTimeLastStep = jQuery.now()));
	}, this.pausePlaying = function () {
		return 1 == g_temp.isPlayModePaused ? !0 : (g_temp.isPlayModePaused = !0, clearInterval(g_temp.playHandle), void g_objGallery.trigger(t.events.PAUSE_PLAYING));
	}, this.continuePlaying = function () {
		return 0 == g_temp.isPlayModePaused ? !0 : (g_temp.isPlayModePaused = !1, g_temp.playTimeLastStep = jQuery.now(), void (g_temp.playHandle = setInterval(advanceNextStep, g_temp.playStepInterval)));
	}, this.stopPlayMode = function () {
		if (g_temp.isPlayMode = !1, clearInterval(g_temp.playHandle), g_temp.playTimePassed = 0, g_temp.objProgress) {
			var e = g_temp.objProgress.getElement();e.hide();
		}g_objGallery.trigger(t.events.STOP_PLAY);
	}, this.isPlayMode = function () {
		return g_temp.isPlayMode;
	}, this.togglePlayMode = function () {
		0 == t.isPlayMode() ? t.startPlayMode() : t.stopPlayMode();
	}, this.___________GENERAL_EXTERNAL___________ = function () {}, this.shuffleItems = function () {
		g_arrItems = g_functions.arrayShuffle(g_arrItems);for (var e in g_arrItems) {
			g_arrItems[e].index = parseInt(e);
		}
	}, this.setOptions = function (e) {
		g_options = jQuery.extend(g_options, e);
	}, this.selectItem = function (e, i) {
		"number" == typeof e && (e = t.getItem(e));var n = e.index;if (n == g_selectedItemIndex) return !0;if (unselectSeletedItem(), g_selectedItem = e, g_selectedItemIndex = n, g_objGallery.trigger(t.events.ITEM_CHANGE, [e, i]), 1 == g_temp.isPlayMode) {
			t.resetPlaying();var r = g_objSlider.isCurrentSlideLoadingImage();1 == r && t.pausePlaying();
		}
	}, this.nextItem = function () {
		var e = g_selectedItemIndex + 1;return 0 == g_numItems ? !0 : 0 == g_options.gallery_carousel && e >= g_numItems ? !0 : (e >= g_numItems && (e = 0), void t.selectItem(e, "next"));
	}, this.prevItem = function () {
		var e = g_selectedItemIndex - 1;return -1 == g_selectedItemIndex && (e = 0), 0 == g_numItems ? !0 : 0 == g_options.gallery_carousel && 0 > e ? !0 : (0 > e && (e = g_numItems - 1), void t.selectItem(e, "prev"));
	}, this.isFullScreen = function () {
		return 1 == g_temp.isFakeFullscreen ? !0 : 1 == g_functions.isFullScreen() ? !0 : !1;
	}, this.isFakeFullscreen = function () {
		return g_temp.isFakeFullscreen;
	}, this.toFullScreen = function () {
		g_functions.setGlobalData("fullscreenID", g_galleryID);var e = g_objWrapper.get(0),
		    t = g_functions.toFullscreen(e);0 == t && toFakeFullScreen();
	}, this.exitFullScreen = function () {
		1 == g_temp.isFakeFullscreen ? exitFakeFullscreen() : g_functions.exitFullscreen();
	}, this.toggleFullscreen = function () {
		0 == t.isFullScreen() ? t.toFullScreen() : t.exitFullScreen();
	}, this.resize = function (e, t, i) {
		g_objWrapper.css("width", "auto"), g_objWrapper.css("max-width", e + "px"), t && g_objWrapper.height(t), i || i === !0 || onGalleryResized();
	}, this.setSizeClass = function (e, i) {
		if (!e) var e = g_objWrapper;if (!i) var n = t.getSize(),
		    i = n.width;if (0 == i) var i = jQuery(window).width();var r = "";return 480 >= i ? r = "ug-under-480" : 780 >= i ? r = "ug-under-780" : 960 > i && (r = "ug-under-960"), 1 == e.hasClass(r) ? !0 : (removeAllSizeClasses(e), void ("" != r && e.addClass(r)));
	}, this.isMobileMode = function () {
		return g_objWrapper.hasClass("ug-under-480") ? !0 : !1;
	}, this.isSmallWindow = function () {
		var e = jQuery(window).width();return e ? 480 >= e ? !0 : !1 : !0;
	}, this.isGalleryVisible = function () {
		var e = g_objWrapper.is(":visible");return e;
	}, this.changeItems = function (e, t) {
		if (!e) var e = "noitems";runGallery(g_galleryID, "nochange", e, t);
	}, this.addItems = function (e) {
		if (!e || 0 == e.length) return !1;var t = g_objWrapper.children(".ug-newitems-wrapper");0 == t.length && g_objWrapper.append("<div class='ug-newitems-wrapper' style='display:none'></div>"), t = g_objWrapper.children(".ug-newitems-wrapper"), t.append(e);var i = jQuery(t.children());if (fillItemsArray(i, !0), loadAPIs(), !g_objTheme || "function" != typeof g_objTheme.addItems) throw new Error("addItems function not found in the theme");t.remove(), g_objTheme.addItems();
	}, this.getNewAddedItemsIndexes = function () {
		var e = [];return jQuery.each(g_arrItems, function (t, i) {
			1 == i.isNewAdded && e.push(t);
		}), e;
	}, this.showErrorMessageReplaceGallery = function (e) {
		showErrorMessage(e);
	}, this.setFuncCustomHeight = function (e) {
		g_temp.funcCustomHeight = e;
	}, this.__________EXTERNAL_EVENTS_______ = function () {}, this.triggerEvent = function (e, t) {
		t ? ("array" != jQuery.type(t) && (t = [t]), g_objGallery.trigger(e, t)) : g_objGallery.trigger(e);
	}, this.onEvent = function (e, t) {
		g_objGallery.on(e, t);
	}, this.destroyEvent = function (e) {
		g_objGallery.off(e);
	}, this.__________AJAX_REQUEST_______ = function () {}, this.ajaxRequest = function (e, t, i, n) {
		if (!i || "function" != typeof i) throw new Error("ajaxRequest error: success function should be passed");var r = g_options.gallery_urlajax;if (!r || "" == r) throw new Error("ajaxRequest error: Ajax url don't passed");if ("undefined" == typeof t) var t = {};var o = { action: "unitegallery_ajax_action", client_action: e, galleryID: g_galleryID, data: t };jQuery.ajax({ type: "post", url: g_options.gallery_urlajax, dataType: "json", data: o, success: function success(e) {
				if (!e) throw new Error("Empty ajax response!");if (-1 == e || 0 === e) throw new Error("ajax error!!!");if ("undefined" == typeof e.success) throw new Error("ajax error!!!");return 0 == e.success ? (showErrorMessage(e.message, "ajax error"), !1) : void i(e);
			}, error: function error(e, t, i) {
				console.log("Ajax Error!!! " + t), responseText = e.responseText, n && "function" == typeof n ? n(responseText) : trace(responseText);
			} });
	}, this.requestNewItems = function (e, i, n) {
		var r = g_options.gallery_enable_cache;if (n || (n = e), 1 == i && (r = !1), 1 == r && g_objCache.hasOwnProperty(n)) {
			var o = g_objCache[n];t.changeItems(o, n);
		} else g_objGallery.trigger(t.events.GALLERY_BEFORE_REQUEST_ITEMS), t.ajaxRequest("front_get_cat_items", { catid: e }, function (e) {
			var i = e.html;t.changeItems(i, n);
		});
	}, this.run = function (e, t) {
		g_options.gallery_debug_errors;if (t && t.hasOwnProperty("gallery_debug_errors") && (g_options.gallery_debug_errors = t.gallery_debug_errors), 1 == g_options.gallery_debug_errors) try {
			runGallery(e, t);
		} catch (i) {
			if ("object" == (typeof i === 'undefined' ? 'undefined' : _typeof(i))) {
				var n = i.message,
				    r = i.lineNumber,
				    o = i.fileName;i.stack;n += " <br><br> in file: " + o, n += " <b> line " + r + "</b>", trace(i);
			} else var n = i;n = n.replace("Error:", ""), showErrorMessage(n);
		} else runGallery(e, t);
	};
}function UGLightbox() {
	function e(e, i) {
		ie = e, U = jQuery(e), ae = jQuery.extend(ae, le), ae = jQuery.extend(ae, i), se.originalOptions = jQuery.extend({}, ae), "compact" == ae.lightbox_type && (se.isCompact = !0, ae = jQuery.extend(ae, ue), ae = jQuery.extend(ae, i)), t(), 1 == se.putSlider ? (ie.initSlider(ae, "lightbox"), g_objects = e.getObjects(), ne = g_objects.g_objSlider) : ne = null, 1 == ae.lightbox_show_textpanel ? oe.init(ie, ae, "lightbox") : oe = null;
	}function t() {
		1 == se.isCompact && 1 == ae.lightbox_show_textpanel && (ae.lightbox_slider_image_padding_bottom = se.initTextPanelHeight), 1 == se.isCompact && "inside" == ae.lightbox_arrows_position && (se.isArrowsInside = !0), 1 == se.isArrowsInside && 0 == ae.lightbox_arrows_inside_alwayson && (se.isArrowsOnHoverMode = !0), 0 == ae.lightbox_show_textpanel && (se.isTopPanelEnabled = !1, se.topPanelHeight = 0, ae.lightbox_slider_image_padding_top = 0);
	}function i() {
		var e = "",
		    t = "";1 == se.isCompact && (t = " ug-lightbox-compact"), e += "<div class='ug-gallery-wrapper ug-lightbox" + t + "'>", e += "<div class='ug-lightbox-overlay'></div>", 0 == se.isCompact && se.isTopPanelEnabled ? (e += "<div class='ug-lightbox-top-panel'>", e += "<div class='ug-lightbox-top-panel-overlay'></div>", ae.lightbox_show_numbers && (e += "<div class='ug-lightbox-numbers'></div>"), e += "</div>") : ae.lightbox_show_numbers && (e += "<div class='ug-lightbox-numbers'></div>"), e += "<div class='ug-lightbox-button-close'></div>", e += "<div class='ug-lightbox-arrow-left'></div>", e += "<div class='ug-lightbox-arrow-right'></div>", e += "</div>", V = jQuery(e), jQuery("body").append(V), ne && ne.setHtml(V), X = V.children(".ug-lightbox-overlay"), 0 == se.isCompact && 1 == se.isTopPanelEnabled && ($ = V.children(".ug-lightbox-top-panel"), 0 == $.length && ($ = null)), K = V.find(".ug-lightbox-button-close"), ae.lightbox_show_numbers && (J = V.find(".ug-lightbox-numbers")), Z = V.children(".ug-lightbox-arrow-left"), q = V.children(".ug-lightbox-arrow-right"), oe && ($ ? oe.appendHTML($) : oe.appendHTML(V));
	}function n() {
		if (null !== ae.lightbox_overlay_color && X.css("background-color", ae.lightbox_overlay_color), null !== ae.lightbox_overlay_opacity && X.fadeTo(0, ae.lightbox_overlay_opacity), $ && null !== ae.lightbox_top_panel_opacity && $.children(".ug-lightbox-top-panel-overlay").fadeTo(0, ae.lightbox_top_panel_opacity), J) {
			var e = {};null !== ae.lightbox_numbers_size && (e["font-size"] = ae.lightbox_numbers_size + "px"), ae.lightbox_numbers_color && (e.color = ae.lightbox_numbers_color), null !== ae.lightbox_numbers_padding_right && (e["padding-right"] = ae.lightbox_numbers_padding_right + "px"), null !== ae.lightbox_numbers_padding_top && (e["padding-top"] = ae.lightbox_numbers_padding_top + "px"), J.css(e);
		}
	}function r(e) {
		if (!ne) return !0;var t = { slider_image_padding_top: e };ne.setOptions(t), ne.refreshSlideItems();
	}function o(e) {
		if (!$) return !1;if (!oe) return !1;var t = $.height();if (0 == t) return !1;if (0 == $.is(":visible")) return !1;var i = t,
		    n = oe.getSize(),
		    o = n.height;t != se.topPanelHeight && (i = se.topPanelHeight), o > i && (i = o), t != i && ($.height(i), ne && 0 == ne.isAnimating() && r(i));
	}function a(e) {
		var t = {},
		    i = ae.lightbox_textpanel_width,
		    n = 47,
		    r = 40,
		    a = e.width - n - r;i > a ? (t.textpanel_padding_left = n, t.textpanel_padding_right = r, t.textpanel_title_text_align = "center", t.textpanel_desc_text_align = "center") : (t.textpanel_padding_left = Math.floor((e.width - i) / 2), t.textpanel_padding_right = t.textpanel_padding_left, t.textpanel_title_text_align = "left", t.textpanel_desc_text_align = "left", ae.lightbox_textpanel_title_text_align && (t.textpanel_title_text_align = ae.lightbox_textpanel_desc_text_align), ae.lightbox_textpanel_desc_text_align && (t.textpanel_desc_text_align = ae.lightbox_textpanel_desc_text_align)), oe.setOptions(t), oe.refresh(!0, !0), o("positionTextPanelWide"), oe.positionPanel();
	}function s() {
		return $ ? void $.hide() : !1;
	}function l() {
		return $ ? void $.show() : !1;
	}function u(e) {
		if (0 == se.isOpened) return !1;if (!oe) return !1;if (!ne) return !1;var t = re.getElementSize(V),
		    i = oe.getSize();if (0 == i.width || i.height > 120) return !1;if (!e) var n = ne.getSlideImage(),
		    e = re.getElementSize(n);if (0 == e.height || 0 == e.width) return !1;var r = e.bottom + i.height;if (r < t.height) return !1;var o = ne.getOptions(),
		    a = i.height;if (a != o.slider_image_padding_bottom) {
			var s = { slider_image_padding_bottom: a };if (0 == ne.isAnimating()) return ne.setOptions(s), ne.refreshSlideItems(), !0;
		}return !1;
	}function d(e, t) {
		if (!e) var i = ne.getSlideImage(),
		    e = re.getElementSize(i);se.textPanelTop = e.bottom, t === !0 && oe.positionPanel(se.textPanelTop, se.textPanelLeft);
	}function _(e) {
		var t = (re.getElementSize(V), ne.getSlideImage()),
		    i = re.getElementSize(t);if (0 == i.width) return !1;se.textPanelLeft = i.left, se.textPanelTop = i.bottom;var n = i.width;if (J) {
			var r = re.getElementSize(J);n -= r.width;var o = i.right - r.width;re.placeElement(J, o, se.textPanelTop);
		}oe && (oe.show(), oe.refresh(!0, !0, n), d(i));var a = u(i);0 == a && (se.positionFrom = "handleCompactTextpanelSizes", oe && (oe.positionPanel(se.textPanelTop, se.textPanelLeft), e === !0 && (e(), j())));
	}function g() {
		if (0 == ne.isCurrentSlideType("image")) return !0;var e = 1 == ne.isCurrentImageInPlace();return e;
	}function c(e, t) {
		if (0 == se.isArrowsInside) return !1;if (!Z) return !1;var i = g();if (Z.show(), q.show(), se.positionFrom = "positionArrowsInside", 1 == se.isArrowsOnHoverMode && 1 == i && 0 == y() && I(!0), 0 == i) var n = re.getElementRelativePos(Z, "left", ae.lightbox_arrows_offset),
		    r = re.getElementRelativePos(Z, "middle"),
		    o = re.getElementRelativePos(q, "right", ae.lightbox_arrows_offset),
		    a = r;else var s = ne.getSlideImage(),
		    l = re.getElementSize(s),
		    n = (re.getElementSize(ne.getElement()), re.getElementRelativePos(Z, "left", 0, s) + l.left + ae.lightbox_arrows_inside_offset),
		    r = re.getElementRelativePos(Z, "middle", 0, s) + l.top,
		    o = re.getElementRelativePos(Z, "right", 0, s) + l.left - ae.lightbox_arrows_inside_offset,
		    a = r;if (t === !0) {
			var u = { left: n, top: r },
			    d = { left: o, top: a };Z.stop().animate(u, { duration: se.fadeDuration }), q.stop().animate(d, { duration: se.fadeDuration });
		} else Z.stop(), q.stop(), re.placeElement(Z, n, r), re.placeElement(q, o, a);1 == e && E(t);
	}function h(e, t) {
		se.positionFrom = null;var i = g(),
		    n = 2,
		    r = re.getElementRelativePos(K, "right", 2, V);if (0 == i) var o = n,
		    a = r;else {
			var s = ne.getSlideImage(),
			    l = re.getElementSize(s),
			    u = re.getElementSize(ne.getElement()),
			    d = re.getElementSize(K);u.top == u.height && (u.top = 0);var a = u.left + l.right - d.width / 2 + ae.lightbox_compact_closebutton_offsetx,
			    o = u.top + l.top - d.height / 2 - ae.lightbox_compact_closebutton_offsety;n > o && (o = n), a > r && (a = r);
		}if (t === !0) {
			var _ = { left: a, top: o };K.stop().animate(_, { duration: se.fadeDuration });
		} else K.stop(), re.placeElement(K, a, o);e === !0 && T(t);
	}function p() {
		K && K.stop().fadeTo(se.fadeDuration, 0), v(), b(), se.positionFrom = "hideCompactElements", 1 == se.isArrowsInside && I();
	}function f() {
		K && K.hide(), Z && 1 == se.isArrowsInside && (Z.hide(), q.hide()), J && J.hide(), oe && oe.hide();
	}function m() {
		var e = re.getElementSize(V);$ && re.setElementSizeAndPosition($, 0, 0, e.width, se.topPanelHeight), Z && 0 == se.isArrowsInside && (1 == ae.lightbox_hide_arrows_onvideoplay && (Z.show(), q.show()), re.placeElement(Z, "left", "middle", ae.lightbox_arrows_offset), re.placeElement(q, "right", "middle", ae.lightbox_arrows_offset)), 0 == se.isCompact && re.placeElement(K, "right", "top", 2, 2), oe && (se.positionFrom = "positionElements", 0 == se.isCompact ? a(e) : (x(), j()));var t = e.width,
		    i = e.height,
		    n = 0,
		    r = 0;if (ne) {
			if ($) {
				var o = $.height(),
				    s = { slider_image_padding_top: o };ne.setOptions(s);
			}ne.setSize(t, i), ne.setPosition(r, n);
		}
	}function v() {
		oe && oe.getElement().stop().fadeTo(se.fadeDuration, 0);
	}function b() {
		J && J.stop().fadeTo(se.fadeDuration, 0);
	}function y() {
		if (!se.lastMouseX) return !0;var e = { pageX: se.lastMouseX, pageY: se.lastMouseY },
		    t = ne.isMouseInsideSlideImage(e);return t;
	}function I(e, t) {
		return Z ? 1 == se.isArrowsOnHoverMode && t === !1 ? (1 == y(), !0) : void (e === !0 ? (Z.stop().fadeTo(0, 0), q.stop().fadeTo(0, 0)) : (Z.stop().fadeTo(se.fadeDuration, 0), q.stop().fadeTo(se.fadeDuration, 0))) : !1;
	}function w() {
		if (!Z) return !0;if (0 == Z.is(":visible")) return !0;var e = Z.css("opacity");return 1 != e ? !0 : !1;
	}function E(e, t) {
		return Z ? 1 == se.isArrowsOnHoverMode && t !== !0 && 1 == g() ? !0 : 1 == ne.isSwiping() ? !0 : (e !== !0 && (Z.stop(), q.stop()), Z.fadeTo(se.fadeDuration, 1), void q.fadeTo(se.fadeDuration, 1)) : !1;
	}function T(e) {
		e !== !0 && K.stop(), K.fadeTo(se.fadeDuration, 1);
	}function S(e) {
		if (!oe) return !1;if (!e) var e = ne.getCurrentItem();oe.setTextPlain(e.title, e.description);
	}function P(e) {
		if (!J) return !1;if (!e) var e = ne.getCurrentItem();var t = ie.getNumItems(),
		    i = e.index + 1;J.html(i + " / " + t);
	}function x() {
		return oe ? void oe.getElement().show().stop().fadeTo(se.fadeDuration, 1) : !1;
	}function j() {
		J && J.stop().fadeTo(se.fadeDuration, 1);
	}function C() {
		return 0 == se.isCompact ? !0 : void p();
	}function A() {
		if (0 == se.isCompact) return !0;if (se.positionFrom = "onZoomChange", h(!1, !0), c(!1, !0), 1 == se.isCompact) {
			var e = ne.isCurrentSlideType("image") && 1 == ne.isCurrentImageInPlace();0 == e ? (v(), b()) : (se.positionFrom = "onZoomChange", x(), j());
		}
	}function M() {
		if (0 == se.isCompact) return !0;se.positionFrom = "onSliderAfterReturn", h(!0), c(!0);var e = u();0 == e && _(), x(), j();
	}function O(e, t) {
		return t = jQuery(t), 0 == se.isCompact ? !0 : 0 == ne.isSlideCurrent(t) ? !0 : (se.positionFrom = "onSliderAfterPutImage", h(!0), c(!0), void _());
	}function z() {
		var e = ne.getOptions(),
		    t = e.slider_image_padding_top;if ($) {
			var i = $.height();i != t && r(i);
		}if (1 == se.isCompact) {
			if (S(), P(), se.positionFrom = "onSliderTransitionEnd", h(!0), c(!0), 0 == ne.isSlideActionActive()) {
				var n = u();0 == n && _();
			}x(), j();
		}
	}function L(e, t) {
		0 == se.isCompact ? (J && P(t), oe && (S(t), 0 == se.isRightNowOpened && (oe.positionElements(!1), o("onchange"), oe.positionPanel()))) : 0 == ne.isAnimating() && (oe && S(t), J && P(t)), 0 == se.isSliderChangedOnce && (se.isSliderChangedOnce = !0, te.trigger(ee.events.LIGHTBOX_INIT));
	}function H(e, t) {
		var i = ne.getSlideType();if ("image" != i && 0 == se.isCompact && ne.isSlideActionActive()) return !0;var n = ne.isPreloading();if (1 == n) return ee.close("slider"), !0;if (1 == ae.lightbox_close_on_emptyspace) {
			var r = ne.isMouseInsideSlideImage(t);0 == r && ee.close("slider_inside");
		}
	}function N() {
		m();
	}function k() {
		$ ? s() : J && J.hide(), Z && 1 == ae.lightbox_hide_arrows_onvideoplay && (Z.hide(), q.hide());
	}function R() {
		$ ? (l(), o("onStopVideo")) : J && J.show(), Z && 1 == ae.lightbox_hide_arrows_onvideoplay && (Z.show(), q.show());
	}function G(e, t, i) {
		var n = !1;switch (t) {case 27:
				1 == se.isOpened && ee.close("keypress");break;case 38:case 40:case 33:case 34:
				n = !0;}1 == se.isOpened && 1 == n && i.preventDefault();
	}function D() {
		1 == se.isArrowsOnHoverMode && E(!1, !0);
	}function Q(e) {
		se.positionFrom = "hideCompactElements", 1 == se.isArrowsOnHoverMode && 1 == g() && I(!1, !0);
	}function W(e) {
		se.lastMouseX = e.pageX, se.lastMouseY = e.pageY;var t = w();1 == t && y() && 0 == ne.isAnimating() && (se.positionFrom = "onMouseMove", Z && 0 == Z.is(":animated") && E(!1, !0));
	}function B(e, t, i, n) {
		if (0 == se.isOpened) return !0;switch (ae.gallery_mousewheel_role) {default:case "zoom":
				var r = ne.getSlideType();"image" != r && e.preventDefault();break;case "none":
				e.preventDefault();break;case "advance":
				ie.onGalleryMouseWheel(e, t, i, n);}
	}function F() {
		if (X.on("touchstart", function (e) {
			e.preventDefault();
		}), X.on("touchend", function (e) {
			ee.close("overlay");
		}), re.addClassOnHover(q, "ug-arrow-hover"), re.addClassOnHover(Z, "ug-arrow-hover"), re.addClassOnHover(K), ie.setNextButton(q), ie.setPrevButton(Z), K.click(function () {
			ee.close("button");
		}), U.on(ie.events.ITEM_CHANGE, L), ne) {
			jQuery(ne).on(ne.events.TRANSITION_END, z), jQuery(ne).on(ne.events.CLICK, H);var e = ne.getVideoObject();jQuery(e).on(e.events.PLAY_START, k), jQuery(e).on(e.events.PLAY_STOP, R), jQuery(ne).on(ne.events.START_DRAG, C), jQuery(ne).on(ne.events.TRANSITION_START, C), jQuery(ne).on(ne.events.AFTER_DRAG_CHANGE, M), jQuery(ne).on(ne.events.AFTER_RETURN, M), jQuery(ne).on(ne.events.AFTER_PUT_IMAGE, O), jQuery(ne).on(ne.events.ZOOM_CHANGE, A), jQuery(ne).on(ne.events.IMAGE_MOUSEENTER, D), jQuery(ne).on(ne.events.IMAGE_MOUSELEAVE, Q);
		}jQuery(window).resize(function () {
			return 0 == se.isOpened ? !0 : void re.whenContiniousEventOver("lightbox_resize", N, 100);
		}), U.on(ie.events.GALLERY_KEYPRESS, G), 1 == se.isArrowsOnHoverMode && jQuery(document).bind("mousemove", W), V.on("mousewheel", B);
	}function Y() {
		se.isCompact = !1, t(), se.isArrowsInside = !1, se.isArrowsOnHoverMode = !1, ae = jQuery.extend({}, se.originalOptions), ae.lightbox_arrows_position = "sides", ne.setOptions(ae);
	}var U,
	    V,
	    X,
	    Z,
	    q,
	    K,
	    J,
	    $,
	    ee = this,
	    te = jQuery(this),
	    ie = new UniteGalleryMain(),
	    ne = new UGSlider(),
	    re = new UGFunctions(),
	    oe = new UGTextPanel(),
	    ae = { lightbox_type: "wide", lightbox_show_textpanel: !0, lightbox_textpanel_width: 550, lightbox_hide_arrows_onvideoplay: !0, lightbox_arrows_position: "sides", lightbox_arrows_offset: 10, lightbox_arrows_inside_offset: 10, lightbox_arrows_inside_alwayson: !1, lightbox_overlay_color: null, lightbox_overlay_opacity: 1, lightbox_top_panel_opacity: null, lightbox_show_numbers: !0, lightbox_numbers_size: null, lightbox_numbers_color: null, lightbox_numbers_padding_top: null, lightbox_numbers_padding_right: null, lightbox_compact_closebutton_offsetx: 1, lightbox_compact_closebutton_offsety: 1, lightbox_close_on_emptyspace: !0 };this.events = { LIGHTBOX_INIT: "lightbox_init" };var se = { topPanelHeight: 44, initTextPanelHeight: 26, isOpened: !1, isRightNowOpened: !1, putSlider: !0, isCompact: !1, fadeDuration: 300, positionFrom: null, textPanelTop: null, textPanelLeft: null, isArrowsInside: !1, isArrowsOnHoverMode: !1, lastMouseX: null, lastMouseY: null, originalOptions: null, isSliderChangedOnce: !1, isTopPanelEnabled: !0 },
	    le = { lightbox_slider_controls_always_on: !0, lightbox_slider_enable_bullets: !1, lightbox_slider_enable_arrows: !1, lightbox_slider_enable_progress_indicator: !1, lightbox_slider_enable_play_button: !1, lightbox_slider_enable_fullscreen_button: !1, lightbox_slider_enable_zoom_panel: !1, lightbox_slider_enable_text_panel: !1,
		lightbox_slider_scale_mode_media: "down", lightbox_slider_scale_mode: "down", lightbox_slider_loader_type: 3, lightbox_slider_loader_color: "black", lightbox_slider_transition: "fade", lightbox_slider_image_padding_top: se.topPanelHeight, lightbox_slider_image_padding_bottom: 0, lightbox_slider_video_padding_top: 0, lightbox_slider_video_padding_bottom: 0, lightbox_textpanel_align: "middle", lightbox_textpanel_padding_top: 5, lightbox_textpanel_padding_bottom: 5, slider_video_constantsize: !1, lightbox_slider_image_border: !1, lightbox_textpanel_enable_title: !0, lightbox_textpanel_enable_description: !1, lightbox_textpanel_desc_style_as_title: !0, lightbox_textpanel_enable_bg: !1, video_enable_closebutton: !1, lightbox_slider_video_enable_closebutton: !1, video_youtube_showinfo: !1, lightbox_slider_enable_links: !1 },
	    ue = { lightbox_overlay_opacity: .6, lightbox_slider_image_border: !0, lightbox_slider_image_shadow: !0, lightbox_slider_image_padding_top: 30, lightbox_slider_image_padding_bottom: 30, slider_video_constantsize: !0, lightbox_textpanel_align: "bottom", lightbox_textpanel_title_text_align: "left", lightbox_textpanel_desc_text_align: "left", lightbox_textpanel_padding_left: 10, lightbox_textpanel_padding_right: 10 };this.destroy = function () {
		if (jQuery(document).unbind("mousemove"), X.off("touchstart"), X.off("touchend"), K.off("click"), U.off(ie.events.ITEM_CHANGE), ne) {
			jQuery(ne).off(ne.events.TRANSITION_END), jQuery(ne).off(ne.events.CLICK), jQuery(ne).off(ne.events.START_DRAG), jQuery(ne).off(ne.events.TRANSITION_START), jQuery(ne).off(ne.events.AFTER_DRAG_CHANGE), jQuery(ne).off(ne.events.AFTER_RETURN);var e = ne.getVideoObject();jQuery(e).off(e.events.PLAY_START), jQuery(e).off(e.events.PLAY_STOP), jQuery(ne).on(ne.events.IMAGE_MOUSEENTER, D), jQuery(ne).on(ne.events.IMAGE_MOUSELEAVE, Q), ne.destroy();
		}jQuery(window).unbind("resize"), U.off(ie.events.GALLERY_KEYPRESS, G), V.off("mousewheel"), V.remove();
	}, this.open = function (e) {
		var t = ie.getItem(e);if (se.isOpened = !0, se.isRightNowOpened = !0, setTimeout(function () {
			se.isRightNowOpened = !1;
		}, 100), ne && ne.setItem(t, "lightbox_open"), oe && oe.setTextPlain(t.title, t.description), X.stop().fadeTo(0, 0), V.show(), V.fadeTo(0, 1), X.stop().fadeTo(se.fadeDuration, ae.lightbox_overlay_opacity), m(), 1 == se.isCompact) {
			var i = ne.isPreloading();1 == i ? f() : 1 == se.isArrowsInside && (Z.hide(), q.hide());
		}ne && ne.startSlideAction(), U.trigger(ie.events.OPEN_LIGHTBOX, t);
	}, this.close = function (e) {
		se.isOpened = !1, 1 == se.isCompact && p(), ne && ne.stopSlideAction();var t = ne.getSlideType();"image" != t ? V.hide() : V.fadeTo(se.fadeDuration, 0, function () {
			V.hide();
		}), U.trigger(ie.events.CLOSE_LIGHTBOX);
	}, this.init = function (t, i) {
		e(t, i);
	}, this.putHtml = function () {
		var e = ie.isSmallWindow();e && 1 == se.isCompact && Y(), i();
	}, this.run = function () {
		n(), ne && ne.run(), F();
	};
}function UGCarousel() {
	function e(e, t) {
		g_objects = e.getObjects(), W = e, H = jQuery(e), N = g_objects.g_objWrapper, k = g_objects.g_arrItems, U = jQuery.extend(U, t), F.setFixedMode(), F.setApproveClickFunction(L), F.init(e, U), Y = F.getObjThumbs(), U = F.getOptions(), V.initTileWidth = U.tile_width, V.initTileHeight = U.tile_height, V.tileWidth = U.tile_width;
	}function t(e) {
		if (!e) var e = N;var t = "<div class='ug-carousel-wrapper'><div class='ug-carousel-inner'></div></div>";N.append(t), R = N.children(".ug-carousel-wrapper"), G = R.children(".ug-carousel-inner"), F.setHtml(G), Y.getThumbs().fadeTo(0, 1);
	}function i(e, t) {
		if (!t) var t = V.initTileHeight / V.initTileWidth * e;V.tileWidth = e;var i = { tile_width: e, tile_height: t };F.setOptions(i), U.tile_width = e, U.tile_height = t, F.resizeAllTiles(e), m(!0);
	}function n() {
		if (null === V.carouselMaxWidth) throw new Error("The carousel width not set");if (V.tileWidth < V.initTileWidth) {
			var e = V.carouselMaxWidth - 2 * U.carousel_padding;e > V.initTileWidth && (e = V.initTileWidth), i(e);var t = B.getNumItemsInSpace(V.carouselMaxWidth, e, U.carousel_space_between_tiles);
		} else {
			var t = B.getNumItemsInSpace(V.carouselMaxWidth, V.tileWidth, U.carousel_space_between_tiles);if (0 >= t) {
				t = 1;var e = V.carouselMaxWidth - 2 * U.carousel_padding;i(e);
			}
		}var n = B.getSpaceByNumItems(t, V.tileWidth, U.carousel_space_between_tiles);n += 2 * U.carousel_padding, R.width(n), 1 == V.isFirstTimeRun ? (z(), F.run(), jQuery.each(k, function (e, t) {
			t.objThumbWrapper.data("index", e), N.trigger(V.eventSizeChange, [t.objThumbWrapper, !0]), t.objTileOriginal = t.objThumbWrapper.clone(!0, !0);
		}), m(!0), 1 == U.carousel_autoplay && D.startAutoplay()) : (1 == U.carousel_autoplay && D.pauseAutoplay(), w(0, !1), 1 == U.carousel_autoplay && D.startAutoplay()), P(), V.isFirstTimeRun = !1;
	}function r() {
		return B.getElementSize(G).left;
	}function o(e) {
		return B.getMousePosition(e).pageX;
	}function a() {
		var e = G.children(".ug-thumb-wrapper");return e;
	}function s(e) {
		var t = B.getNumItemsInSpace(e, V.tileWidth, U.carousel_space_between_tiles);return t;
	}function l() {
		return a().length;
	}function u(e) {
		v(e);var t = a(),
		    i = jQuery(t[e]);return i;
	}function d() {
		return G.children(".ug-thumb-wrapper").first();
	}function _() {
		return G.children(".ug-thumb-wrapper").last();
	}function g(e, t, i) {
		var n = e.data("index");if (void 0 == n) throw new Error("every tile should have index!");for (var r = [], o = 0; t > o; o++) {
			if ("prev" == i) var a = W.getPrevItem(n, !0);else var a = W.getNextItem(n, !0);if (!a) throw new Error("the item to add is empty");var s = a.objTileOriginal.clone(!0, !0);n = a.index, s.addClass("cloned"), r.push(s);
		}return r;
	}function c() {
		var e = B.getElementSize(R),
		    t = B.getElementSize(G),
		    i = t.width - e.width + t.left,
		    n = V.sideSpace - i;return n;
	}function h() {
		var e = -r(),
		    t = V.sideSpace - e;return t;
	}function p() {
		var e = B.getElementSize(R);return e.width;
	}function f() {
		var e = p(),
		    t = s(e);return t;
	}function m(e) {
		if (!e) var e = !1;var t,
		    i = a(),
		    n = 0,
		    r = 0;return jQuery.each(i, function (e, o) {
			o = jQuery(o), B.placeElement(o, n, 0);var a = B.getElementSize(o);n += a.width + U.carousel_space_between_tiles, r = Math.max(r, a.height), e == i.length - 1 && (t = a.right);
		}), G.width(t), r += 2 * U.carousel_padding, e === !0 && (G.height(r), R.height(r)), w(V.numCurrent, !1), t;
	}function v(e) {
		if (e > a().length - 1) throw new Error("Wrogn tile number: " + e);
	}function b(e, t) {
		if ("left" == t) var i = d();else var i = _();var n = "left" == t ? "prev" : "next",
		    r = g(i, e, n);jQuery.each(r, function (e, i) {
			"left" == t ? G.prepend(i) : G.append(i), N.trigger(V.eventSizeChange, i), F.loadTileImage(i);
		});
	}function y(e, t) {
		v(n);for (var i = a(), n = i.length, r = 0; e > r; r++) {
			"left" == t ? jQuery(i[r]).remove() : jQuery(i[n - 1 - r]).remove();
		}
	}function I(e) {
		var t = { left: e + "px" };G.css(t);
	}function w(e, t, i) {
		if (void 0 === t) {
			var t = !0;if (G.is(":animated")) return !0;
		}var n = u(e),
		    r = B.getElementSize(n),
		    o = -r.left + U.carousel_padding,
		    a = { left: o + "px" };if (t === !0) {
			var s = U.carousel_scroll_duration,
			    l = U.carousel_scroll_easing;i === !0 && (s = V.scrollShortDuration, l = V.scrollShortEasing), G.stop(!0).animate(a, { duration: s, easing: l, queue: !1, complete: function complete() {
					V.numCurrent = e, S(!0);
				} });
		} else V.numCurrent = e, G.css(a);
	}function E() {
		var e = -r(),
		    t = s(e),
		    i = B.getElementSize(u(t)).left,
		    n = B.getElementSize(u(t + 1)).left;return Math.abs(i - e) < Math.abs(n - e) ? t : t + 1;
	}function T() {
		var e = E();w(e, !0, !0);
	}function S() {
		var e = h(),
		    t = c(),
		    i = 0,
		    n = 0,
		    r = 0,
		    o = 0,
		    a = l();if (e > V.spaceActionSize) i = s(e), b(i, "left"), V.numCurrent += i;else if (e < -V.spaceActionSize) {
			var r = s(Math.abs(e));y(r, "left"), V.numCurrent -= r;
		}if (t > V.spaceActionSize ? (n = s(t), b(n, "right")) : t < -V.spaceActionSize && (o = s(Math.abs(t)), y(o, "right")), o > a) throw new Error("Can't remove more then num tiles");var u = !1;return (i || n || r || o) && (m(), u = !0), u;
	}function P(e) {
		B.placeElement(G, 0, U.carousel_padding), S();
	}function x() {
		"left" == U.carousel_autoplay_direction ? D.scrollRight(1) : D.scrollLeft(1);
	}function j(e) {
		return 1 == V.touchActive ? !0 : (V.touchActive = !0, D.pauseAutoplay(), V.startTime = jQuery.now(), V.startMousePos = o(e), V.startInnerPos = r(), V.lastTime = V.startTime, V.lastMousePos = V.startMousePos, void B.storeEventData(e, V.storedEventID));
	}function C(e) {
		if (0 == V.touchActive) return !0;B.updateStoredEventData(e, V.storedEventID), e.preventDefault();var t = null;if (1 == U.carousel_vertical_scroll_ondrag && (t = B.handleScrollTop(V.storedEventID)), "vert" === t) return !0;V.lastMousePos = o(e);var i = V.lastMousePos - V.startMousePos,
		    n = V.startInnerPos + i,
		    r = i > 0 ? "prev" : "next",
		    a = B.getElementSize(G).width;n > 0 && "prev" == r && (n /= 3), -a > n && "next" == r && (n = V.startInnerPos + i / 3), I(n);
	}function A(e) {
		return 0 == V.touchActive ? !0 : (V.touchActive = !1, T(), void D.unpauseAutoplay());
	}function M(e) {
		return 0 == U.carousel_autoplay_pause_onhover ? !0 : void (1 == V.isPlayMode && 0 == V.isPaused && D.pauseAutoplay());
	}function O(e) {
		return 0 == U.carousel_autoplay_pause_onhover ? !0 : void D.unpauseAutoplay();
	}function z() {
		F.initEvents(), R.bind("mousedown touchstart", j), jQuery("body").bind("mousemove touchmove", C), jQuery(window).add("body").bind("mouseup touchend", A), R.hover(M, O);
	}function L() {
		var e = V.lastTime - V.startTime,
		    t = Math.abs(V.lastMousePos - V.startMousePos);return e > 300 ? !1 : t > 30 ? !1 : !0;
	}var H,
	    N,
	    k,
	    R,
	    G,
	    D = this,
	    Q = jQuery(this),
	    W = new UniteGalleryMain(),
	    B = new UGFunctions(),
	    F = new UGTileDesign(),
	    Y = new UGThumbsGeneral(),
	    U = { carousel_padding: 8, carousel_space_between_tiles: 20, carousel_navigation_numtiles: 3, carousel_scroll_duration: 500, carousel_scroll_easing: "easeOutCubic", carousel_autoplay: !0, carousel_autoplay_timeout: 3e3, carousel_autoplay_direction: "right", carousel_autoplay_pause_onhover: !0, carousel_vertical_scroll_ondrag: !1 };this.events = { START_PLAY: "carousel_start_play", PAUSE_PLAY: "carousel_pause_play", STOP_PLAY: "carousel_stop_play" };var V = { eventSizeChange: "thumb_size_change", isFirstTimeRun: !0, carouselMaxWidth: null, tileWidth: 0, initTileWidth: 0, initTileHeight: 0, sideSpace: 1500, spaceActionSize: 500, numCurrent: 0, touchActive: !1, startInnerPos: 0, lastTime: 0, startTime: 0, startMousePos: 0, lastMousePos: 0, scrollShortDuration: 200, scrollShortEasing: "easeOutQuad", handle: null, isPlayMode: !1, isPaused: !1, storedEventID: "carousel" };this.startAutoplay = function () {
		V.isPlayMode = !0, V.isPaused = !1, Q.trigger(D.events.START_PLAY), V.handle && clearInterval(V.handle), V.handle = setInterval(x, U.carousel_autoplay_timeout);
	}, this.unpauseAutoplay = function () {
		return 0 == V.isPlayMode ? !0 : 0 == V.isPaused ? !0 : void D.startAutoplay();
	}, this.pauseAutoplay = function () {
		return 0 == V.isPlayMode ? !0 : (V.isPaused = !0, V.handle && clearInterval(V.handle), void Q.trigger(D.events.PAUSE_PLAY));
	}, this.stopAutoplay = function () {
		return 0 == V.isPlayMode ? !0 : (V.isPaused = !1, V.isPlayMode = !1, V.handle && clearInterval(V.handle), void Q.trigger(D.events.STOP_PLAY));
	}, this.destroy = function () {
		V.handle && clearInterval(V.handle), Q.off(D.events.START_PLAY), Q.off(D.events.STOP_PLAY), R.unbind("mousedown"), R.unbind("touchstart"), jQuery("body").unbind("mousemove"), jQuery("body").unbind("touchmove"), jQuery(window).add("body").unbind("mouseup").unbind("touchend"), R.off("mouseenter").off("mouseleave"), F.destroy();
	}, this.init = function (t, i, n) {
		n && this.setMaxWidth(n), e(t, i);
	}, this.setMaxWidth = function (e) {
		V.carouselMaxWidth = e;
	}, this.setHtml = function (e) {
		t(e);
	}, this.getElement = function () {
		return R;
	}, this.getObjTileDesign = function () {
		return F;
	}, this.getEstimatedHeight = function () {
		var e = U.tile_height + 2 * U.carousel_padding;return e;
	}, this.run = function () {
		n();
	}, this.scrollRight = function (e) {
		if (!e || "object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e))) var e = U.carousel_navigation_numtiles;var t = f();e > t && (e = t);var i = V.numCurrent - e;0 >= i && (i = 0), w(i);
	}, this.scrollLeft = function (e) {
		if (!e || "object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e))) var e = U.carousel_navigation_numtiles;var t = f();e > t && (e = t);var i = l(),
		    n = V.numCurrent + e;n >= i && (n = i - 1), w(n);
	}, this.setScrollLeftButton = function (e) {
		B.setButtonMobileReady(e), B.setButtonOnClick(e, D.scrollLeft);
	}, this.setScrollRightButton = function (e) {
		B.setButtonMobileReady(e), B.setButtonOnClick(e, D.scrollRight);
	}, this.setPlayPauseButton = function (e) {
		B.setButtonMobileReady(e), 1 == V.isPlayMode && 0 == V.isPaused && e.addClass("ug-pause-icon"), Q.on(D.events.START_PLAY, function () {
			e.addClass("ug-pause-icon");
		}), Q.on(D.events.STOP_PLAY, function () {
			e.removeClass("ug-pause-icon");
		}), B.setButtonOnClick(e, function () {
			0 == V.isPlayMode || 1 == V.isPaused ? D.startAutoplay() : D.stopAutoplay();
		});
	};
}function UGTabs() {
	function e(e, t) {
		u = e, a = jQuery(u), d = jQuery.extend(d, t), "select" == d.tabs_type ? l = jQuery(d.tabs_container) : s = jQuery(d.tabs_container + " .ug-tab");
	}function t() {
		o();
	}function i(e) {
		u.requestNewItems(e);
	}function n() {
		var e = d.tabs_class_selected,
		    t = jQuery(this);if (t.hasClass(e)) return !0;s.not(t).removeClass(e), t.addClass(e);var n = t.data("catid");return n ? void i(n) : !0;
	}function r() {
		var e = jQuery(this),
		    t = e.val();return t ? void i(t) : !0;
	}function o() {
		"select" == d.tabs_type ? l.change(r) : s.click(n);
	}var a,
	    s,
	    l,
	    u = (jQuery(this), new UniteGalleryMain()),
	    d = (new UGFunctions(), { tabs_type: "tabs", tabs_container: "#ug_tabs", tabs_class_selected: "ug-tab-selected" });this.events = {}, this.destroy = function () {
		l && l.off("change"), s && s.off("click");
	}, this.init = function (t, i) {
		e(t, i);
	}, this.run = function () {
		t();
	};
}function UG_API(e) {
	function t(e) {
		var t = { index: e.index, title: e.title, description: e.description, urlImage: e.urlImage, urlThumb: e.urlThumb },
		    i = e.objThumbImage.data();for (var n in i) {
			switch (n) {case "image":case "description":
					continue;}t[n] = i[n];
		}return t;
	}var i,
	    n = this,
	    r = (jQuery(n), new UniteGalleryMain()),
	    o = [];r = e, i = jQuery(e), this.events = { API_INIT_FUNCTIONS: "api_init", API_ON_EVENT: "api_on_event" }, this.on = function (e, a, s) {
		switch (s !== !0 && o.push({ event: e, func: a }), e) {case "item_change":
				i.on(r.events.ITEM_CHANGE, function () {
					var e = r.getSelectedItem(),
					    i = t(e);a(i.index, i);
				});break;case "resize":
				i.on(r.events.SIZE_CHANGE, a);break;case "enter_fullscreen":
				i.on(r.events.ENTER_FULLSCREEN, a);break;case "exit_fullscreen":
				i.on(r.events.EXIT_FULLSCREEN, a);break;case "play":
				i.on(r.events.START_PLAY, a);break;case "stop":
				i.on(r.events.STOP_PLAY, a);break;case "pause":
				i.on(r.events.PAUSE_PLAYING, a);break;case "continue":
				i.on(r.events.CONTINUE_PLAYING, a);break;case "open_lightbox":
				i.on(r.events.OPEN_LIGHTBOX, a);break;case "close_lightbox":
				i.on(r.events.CLOSE_LIGHTBOX, a);break;default:
				console && console.log("wrong api event: " + e);}i.trigger(n.events.API_ON_EVENT, [e, a]);
	}, this.play = function () {
		r.startPlayMode();
	}, this.stop = function () {
		r.stopPlayMode();
	}, this.togglePlay = function () {
		r.togglePlayMode();
	}, this.enterFullscreen = function () {
		r.toFullScreen();
	}, this.exitFullscreen = function () {
		r.exitFullScreen();
	}, this.toggleFullscreen = function () {
		r.toggleFullscreen();
	}, this.resetZoom = function () {
		var e = r.getObjSlider();return e ? void e.zoomBack() : !1;
	}, this.zoomIn = function () {
		var e = r.getObjSlider();return e ? void e.zoomIn() : !1;
	}, this.zoomOut = function () {
		var e = r.getObjSlider();return e ? void e.zoomOut() : !1;
	}, this.nextItem = function () {
		r.nextItem();
	}, this.prevItem = function () {
		r.prevItem();
	}, this.selectItem = function (e) {
		r.selectItem(e);
	}, this.resize = function (e, t) {
		t ? r.resize(e, t) : r.resize(e);
	}, this.getItem = function (e) {
		var i = r.getItem(e),
		    n = t(i);return n;
	}, this.getNumItems = function () {
		var e = r.getNumItems();return e;
	}, this.reloadGallery = function (e) {
		if (!e) var e = {};r.run(null, e), o.map(function (e) {
			n.on(e.event, e.func, !0);
		});
	}, this.destroy = function () {
		r.destroy();
	}, i.trigger(n.events.API_INIT_FUNCTIONS, n);
}function UGLoadMore() {
	function e() {
		return o = jQuery("#" + _.loadmore_container), 0 == o.length ? !1 : (a = o.find(".ug-loadmore-button"), 0 == a.length ? !1 : (s = o.find(".ug-loadmore-loader"), 0 == s.length ? !1 : (l = o.find(".ug-loadmore-error"), 0 == l.length ? !1 : void (d.isInited = !0))));
	}function t() {
		o.show();
	}function i() {
		a.hide(), s.show();var e = { numitems: u.getNumItems() };u.ajaxRequest("front_loadmore", e, function (e) {
			s.hide();var t = e.html_items,
			    i = e.show_loadmore;1 == i ? (a.blur().show(), s.hide()) : o.hide(), u.addItems(t);
		}, function (e) {
			e = "Ajax Error!" + e, s.hide(), l.show(), l.html(e);
		});
	}function n() {
		u.onEvent("tiles_first_placed", t), a.click(i);
	}var r,
	    o,
	    a,
	    s,
	    l,
	    u = (jQuery(this), new UniteGalleryMain()),
	    d = (new UGFunctions(), { isInited: !1 }),
	    _ = { loadmore_container: "ug_loadmore_wrapper" };this.events = {}, this.destroy = function () {
		return 0 == d.isInited ? !1 : void 0;
	}, this.init = function (t, i) {
		return u = t, r = jQuery(u), _ = jQuery.extend(_, i), e(), 0 == d.isInited ? (trace("load more not inited, something is wrong"), !1) : void n();
	};
}var g_ugFunctions = new UGFunctions();!function (e) {
	"function" == typeof define && define.amd ? define(["jquery"], e) : "object" == (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) ? module.exports = e : e(jQuery);
}(function (e) {
	function t(t) {
		var a = t || window.event,
		    s = l.call(arguments, 1),
		    u = 0,
		    d = 0,
		    _ = 0,
		    g = 0;if (t = e.event.fix(a), t.type = "mousewheel", "detail" in a && (_ = -1 * a.detail), "wheelDelta" in a && (_ = a.wheelDelta), "wheelDeltaY" in a && (_ = a.wheelDeltaY), "wheelDeltaX" in a && (d = -1 * a.wheelDeltaX), "axis" in a && a.axis === a.HORIZONTAL_AXIS && (d = -1 * _, _ = 0), u = 0 === _ ? d : _, "deltaY" in a && (_ = -1 * a.deltaY, u = _), "deltaX" in a && (d = a.deltaX, 0 === _ && (u = -1 * d)), 0 !== _ || 0 !== d) {
			if (1 === a.deltaMode) {
				var c = e.data(this, "mousewheel-line-height");u *= c, _ *= c, d *= c;
			} else if (2 === a.deltaMode) {
				var h = e.data(this, "mousewheel-page-height");u *= h, _ *= h, d *= h;
			}return g = Math.max(Math.abs(_), Math.abs(d)), (!o || o > g) && (o = g, n(a, g) && (o /= 40)), n(a, g) && (u /= 40, d /= 40, _ /= 40), u = Math[u >= 1 ? "floor" : "ceil"](u / o), d = Math[d >= 1 ? "floor" : "ceil"](d / o), _ = Math[_ >= 1 ? "floor" : "ceil"](_ / o), t.deltaX = d, t.deltaY = _, t.deltaFactor = o, t.deltaMode = 0, s.unshift(t, u, d, _), r && clearTimeout(r), r = setTimeout(i, 200), (e.event.dispatch || e.event.handle).apply(this, s);
		}
	}function i() {
		o = null;
	}function n(e, t) {
		return d.settings.adjustOldDeltas && "mousewheel" === e.type && t % 120 === 0;
	}var r,
	    o,
	    a = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
	    s = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
	    l = Array.prototype.slice;if (e.event.fixHooks) for (var u = a.length; u;) {
		e.event.fixHooks[a[--u]] = e.event.mouseHooks;
	}var d = e.event.special.mousewheel = { version: "3.1.9", setup: function setup() {
			if (this.addEventListener) for (var i = s.length; i;) {
				this.addEventListener(s[--i], t, !1);
			} else this.onmousewheel = t;e.data(this, "mousewheel-line-height", d.getLineHeight(this)), e.data(this, "mousewheel-page-height", d.getPageHeight(this));
		}, teardown: function teardown() {
			if (this.removeEventListener) for (var e = s.length; e;) {
				this.removeEventListener(s[--e], t, !1);
			} else this.onmousewheel = null;
		}, getLineHeight: function getLineHeight(t) {
			return parseInt(e(t)["offsetParent" in e.fn ? "offsetParent" : "parent"]().css("fontSize"), 10);
		}, getPageHeight: function getPageHeight(t) {
			return e(t).height();
		}, settings: { adjustOldDeltas: !0 } };e.fn.extend({ mousewheel: function mousewheel(e) {
			return e ? this.bind("mousewheel", e) : this.trigger("mousewheel");
		}, unmousewheel: function unmousewheel(e) {
			return this.unbind("mousewheel", e);
		} });
}), function (e) {
	"function" == typeof define && define.amd ? define(["jquery"], function (t) {
		return e(t);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && "object" == _typeof(module.exports) ? exports = e(require("jquery")) : e(jQuery);
}(function (e) {
	function t(e) {
		var t = 7.5625,
		    i = 2.75;return 1 / i > e ? t * e * e : 2 / i > e ? t * (e -= 1.5 / i) * e + .75 : 2.5 / i > e ? t * (e -= 2.25 / i) * e + .9375 : t * (e -= 2.625 / i) * e + .984375;
	}e.easing.jswing = e.easing.swing;var i = Math.pow,
	    n = Math.sqrt,
	    r = Math.sin,
	    o = Math.cos,
	    a = Math.PI,
	    s = 1.70158,
	    l = 1.525 * s,
	    u = s + 1,
	    d = 2 * a / 3,
	    _ = 2 * a / 4.5;e.extend(e.easing, { def: "easeOutQuad", swing: function swing(t) {
			return e.easing[e.easing.def](t);
		}, easeInQuad: function easeInQuad(e) {
			return e * e;
		}, easeOutQuad: function easeOutQuad(e) {
			return 1 - (1 - e) * (1 - e);
		}, easeInOutQuad: function easeInOutQuad(e) {
			return .5 > e ? 2 * e * e : 1 - i(-2 * e + 2, 2) / 2;
		}, easeInCubic: function easeInCubic(e) {
			return e * e * e;
		}, easeOutCubic: function easeOutCubic(e) {
			return 1 - i(1 - e, 3);
		}, easeInOutCubic: function easeInOutCubic(e) {
			return .5 > e ? 4 * e * e * e : 1 - i(-2 * e + 2, 3) / 2;
		}, easeInQuart: function easeInQuart(e) {
			return e * e * e * e;
		}, easeOutQuart: function easeOutQuart(e) {
			return 1 - i(1 - e, 4);
		}, easeInOutQuart: function easeInOutQuart(e) {
			return .5 > e ? 8 * e * e * e * e : 1 - i(-2 * e + 2, 4) / 2;
		}, easeInQuint: function easeInQuint(e) {
			return e * e * e * e * e;
		}, easeOutQuint: function easeOutQuint(e) {
			return 1 - i(1 - e, 5);
		}, easeInOutQuint: function easeInOutQuint(e) {
			return .5 > e ? 16 * e * e * e * e * e : 1 - i(-2 * e + 2, 5) / 2;
		}, easeInSine: function easeInSine(e) {
			return 1 - o(e * a / 2);
		}, easeOutSine: function easeOutSine(e) {
			return r(e * a / 2);
		}, easeInOutSine: function easeInOutSine(e) {
			return -(o(a * e) - 1) / 2;
		}, easeInExpo: function easeInExpo(e) {
			return 0 === e ? 0 : i(2, 10 * e - 10);
		}, easeOutExpo: function easeOutExpo(e) {
			return 1 === e ? 1 : 1 - i(2, -10 * e);
		}, easeInOutExpo: function easeInOutExpo(e) {
			return 0 === e ? 0 : 1 === e ? 1 : .5 > e ? i(2, 20 * e - 10) / 2 : (2 - i(2, -20 * e + 10)) / 2;
		}, easeInCirc: function easeInCirc(e) {
			return 1 - n(1 - i(e, 2));
		}, easeOutCirc: function easeOutCirc(e) {
			return n(1 - i(e - 1, 2));
		}, easeInOutCirc: function easeInOutCirc(e) {
			return .5 > e ? (1 - n(1 - i(2 * e, 2))) / 2 : (n(1 - i(-2 * e + 2, 2)) + 1) / 2;
		}, easeInElastic: function easeInElastic(e) {
			return 0 === e ? 0 : 1 === e ? 1 : -i(2, 10 * e - 10) * r((10 * e - 10.75) * d);
		}, easeOutElastic: function easeOutElastic(e) {
			return 0 === e ? 0 : 1 === e ? 1 : i(2, -10 * e) * r((10 * e - .75) * d) + 1;
		}, easeInOutElastic: function easeInOutElastic(e) {
			return 0 === e ? 0 : 1 === e ? 1 : .5 > e ? -(i(2, 20 * e - 10) * r((20 * e - 11.125) * _)) / 2 : i(2, -20 * e + 10) * r((20 * e - 11.125) * _) / 2 + 1;
		}, easeInBack: function easeInBack(e) {
			return u * e * e * e - s * e * e;
		}, easeOutBack: function easeOutBack(e) {
			return 1 + u * i(e - 1, 3) + s * i(e - 1, 2);
		}, easeInOutBack: function easeInOutBack(e) {
			return .5 > e ? i(2 * e, 2) * (2 * (l + 1) * e - l) / 2 : (i(2 * e - 2, 2) * ((l + 1) * (2 * e - 2) + l) + 2) / 2;
		}, easeInBounce: function easeInBounce(e) {
			return 1 - t(1 - e);
		}, easeOutBounce: t, easeInOutBounce: function easeInOutBounce(e) {
			return .5 > e ? (1 - t(1 - 2 * e)) / 2 : (1 + t(2 * e - 1)) / 2;
		} });
}), !function (e, t) {
	function i(e, t, i) {
		var n = _[t.type] || {};return null == e ? i || !t.def ? null : t.def : (e = n.floor ? ~~e : parseFloat(e), isNaN(e) ? t.def : n.mod ? (e + n.mod) % n.mod : 0 > e ? 0 : n.max < e ? n.max : e);
	}function n(t) {
		var i = u(),
		    n = i._rgba = [];return t = t.toLowerCase(), h(l, function (e, r) {
			var o,
			    a = r.re.exec(t),
			    s = a && r.parse(a),
			    l = r.space || "rgba";return s ? (o = i[l](s), i[d[l].cache] = o[d[l].cache], n = i._rgba = o._rgba, !1) : void 0;
		}), n.length ? ("0,0,0,0" === n.join() && e.extend(n, o.transparent), i) : o[t];
	}function r(e, t, i) {
		return i = (i + 1) % 1, 1 > 6 * i ? e + (t - e) * i * 6 : 1 > 2 * i ? t : 2 > 3 * i ? e + (t - e) * (2 / 3 - i) * 6 : e;
	}if ("undefined" == typeof e.cssHooks) return !1;var o,
	    a = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor",
	    s = /^([\-+])=\s*(\d+\.?\d*)/,
	    l = [{ re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/, parse: function parse(e) {
			return [e[1], e[2], e[3], e[4]];
		} }, { re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/, parse: function parse(e) {
			return [2.55 * e[1], 2.55 * e[2], 2.55 * e[3], e[4]];
		} }, { re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/, parse: function parse(e) {
			return [parseInt(e[1], 16), parseInt(e[2], 16), parseInt(e[3], 16)];
		} }, { re: /#([a-f0-9])([a-f0-9])([a-f0-9])/, parse: function parse(e) {
			return [parseInt(e[1] + e[1], 16), parseInt(e[2] + e[2], 16), parseInt(e[3] + e[3], 16)];
		} }, { re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/, space: "hsla", parse: function parse(e) {
			return [e[1], e[2] / 100, e[3] / 100, e[4]];
		} }],
	    u = e.Color = function (t, i, n, r) {
		return new e.Color.fn.parse(t, i, n, r);
	},
	    d = { rgba: { props: { red: { idx: 0, type: "byte" }, green: { idx: 1, type: "byte" }, blue: { idx: 2, type: "byte" } } }, hsla: { props: { hue: { idx: 0, type: "degrees" }, saturation: { idx: 1, type: "percent" }, lightness: { idx: 2, type: "percent" } } } },
	    _ = { "byte": { floor: !0, max: 255 }, percent: { max: 1 }, degrees: { mod: 360, floor: !0 } },
	    g = u.support = {},
	    c = e("<p>")[0],
	    h = e.each;c.style.cssText = "background-color:rgba(1,1,1,.5)", g.rgba = c.style.backgroundColor.indexOf("rgba") > -1, h(d, function (e, t) {
		t.cache = "_" + e, t.props.alpha = { idx: 3, type: "percent", def: 1 };
	}), u.fn = e.extend(u.prototype, { parse: function parse(r, a, s, l) {
			if (r === t) return this._rgba = [null, null, null, null], this;(r.jquery || r.nodeType) && (r = e(r).css(a), a = t);var _ = this,
			    g = e.type(r),
			    c = this._rgba = [];return a !== t && (r = [r, a, s, l], g = "array"), "string" === g ? this.parse(n(r) || o._default) : "array" === g ? (h(d.rgba.props, function (e, t) {
				c[t.idx] = i(r[t.idx], t);
			}), this) : "object" === g ? (r instanceof u ? h(d, function (e, t) {
				r[t.cache] && (_[t.cache] = r[t.cache].slice());
			}) : h(d, function (t, n) {
				var o = n.cache;h(n.props, function (e, t) {
					if (!_[o] && n.to) {
						if ("alpha" === e || null == r[e]) return;_[o] = n.to(_._rgba);
					}_[o][t.idx] = i(r[e], t, !0);
				}), _[o] && e.inArray(null, _[o].slice(0, 3)) < 0 && (_[o][3] = 1, n.from && (_._rgba = n.from(_[o])));
			}), this) : void 0;
		}, is: function is(e) {
			var t = u(e),
			    i = !0,
			    n = this;return h(d, function (e, r) {
				var o,
				    a = t[r.cache];return a && (o = n[r.cache] || r.to && r.to(n._rgba) || [], h(r.props, function (e, t) {
					return null != a[t.idx] ? i = a[t.idx] === o[t.idx] : void 0;
				})), i;
			}), i;
		}, _space: function _space() {
			var e = [],
			    t = this;return h(d, function (i, n) {
				t[n.cache] && e.push(i);
			}), e.pop();
		}, transition: function transition(e, t) {
			var n = u(e),
			    r = n._space(),
			    o = d[r],
			    a = 0 === this.alpha() ? u("transparent") : this,
			    s = a[o.cache] || o.to(a._rgba),
			    l = s.slice();return n = n[o.cache], h(o.props, function (e, r) {
				var o = r.idx,
				    a = s[o],
				    u = n[o],
				    d = _[r.type] || {};null !== u && (null === a ? l[o] = u : (d.mod && (u - a > d.mod / 2 ? a += d.mod : a - u > d.mod / 2 && (a -= d.mod)), l[o] = i((u - a) * t + a, r)));
			}), this[r](l);
		}, blend: function blend(t) {
			if (1 === this._rgba[3]) return this;var i = this._rgba.slice(),
			    n = i.pop(),
			    r = u(t)._rgba;return u(e.map(i, function (e, t) {
				return (1 - n) * r[t] + n * e;
			}));
		}, toRgbaString: function toRgbaString() {
			var t = "rgba(",
			    i = e.map(this._rgba, function (e, t) {
				return null == e ? t > 2 ? 1 : 0 : e;
			});return 1 === i[3] && (i.pop(), t = "rgb("), t + i.join() + ")";
		}, toHslaString: function toHslaString() {
			var t = "hsla(",
			    i = e.map(this.hsla(), function (e, t) {
				return null == e && (e = t > 2 ? 1 : 0), t && 3 > t && (e = Math.round(100 * e) + "%"), e;
			});return 1 === i[3] && (i.pop(), t = "hsl("), t + i.join() + ")";
		}, toHexString: function toHexString(t) {
			var i = this._rgba.slice(),
			    n = i.pop();return t && i.push(~~(255 * n)), "#" + e.map(i, function (e) {
				return e = (e || 0).toString(16), 1 === e.length ? "0" + e : e;
			}).join("");
		}, toString: function toString() {
			return 0 === this._rgba[3] ? "transparent" : this.toRgbaString();
		} }), u.fn.parse.prototype = u.fn, d.hsla.to = function (e) {
		if (null == e[0] || null == e[1] || null == e[2]) return [null, null, null, e[3]];var t,
		    i,
		    n = e[0] / 255,
		    r = e[1] / 255,
		    o = e[2] / 255,
		    a = e[3],
		    s = Math.max(n, r, o),
		    l = Math.min(n, r, o),
		    u = s - l,
		    d = s + l,
		    _ = .5 * d;return t = l === s ? 0 : n === s ? 60 * (r - o) / u + 360 : r === s ? 60 * (o - n) / u + 120 : 60 * (n - r) / u + 240, i = 0 === u ? 0 : .5 >= _ ? u / d : u / (2 - d), [Math.round(t) % 360, i, _, null == a ? 1 : a];
	}, d.hsla.from = function (e) {
		if (null == e[0] || null == e[1] || null == e[2]) return [null, null, null, e[3]];var t = e[0] / 360,
		    i = e[1],
		    n = e[2],
		    o = e[3],
		    a = .5 >= n ? n * (1 + i) : n + i - n * i,
		    s = 2 * n - a;return [Math.round(255 * r(s, a, t + 1 / 3)), Math.round(255 * r(s, a, t)), Math.round(255 * r(s, a, t - 1 / 3)), o];
	}, h(d, function (n, r) {
		var o = r.props,
		    a = r.cache,
		    l = r.to,
		    d = r.from;u.fn[n] = function (n) {
			if (l && !this[a] && (this[a] = l(this._rgba)), n === t) return this[a].slice();var r,
			    s = e.type(n),
			    _ = "array" === s || "object" === s ? n : arguments,
			    g = this[a].slice();return h(o, function (e, t) {
				var n = _["object" === s ? e : t.idx];null == n && (n = g[t.idx]), g[t.idx] = i(n, t);
			}), d ? (r = u(d(g)), r[a] = g, r) : u(g);
		}, h(o, function (t, i) {
			u.fn[t] || (u.fn[t] = function (r) {
				var o,
				    a = e.type(r),
				    l = "alpha" === t ? this._hsla ? "hsla" : "rgba" : n,
				    u = this[l](),
				    d = u[i.idx];return "undefined" === a ? d : ("function" === a && (r = r.call(this, d), a = e.type(r)), null == r && i.empty ? this : ("string" === a && (o = s.exec(r), o && (r = d + parseFloat(o[2]) * ("+" === o[1] ? 1 : -1))), u[i.idx] = r, this[l](u)));
			});
		});
	}), u.hook = function (t) {
		var i = t.split(" ");h(i, function (t, i) {
			e.cssHooks[i] = { set: function set(t, r) {
					var o,
					    a,
					    s = "";if ("transparent" !== r && ("string" !== e.type(r) || (o = n(r)))) {
						if (r = u(o || r), !g.rgba && 1 !== r._rgba[3]) {
							for (a = "backgroundColor" === i ? t.parentNode : t; ("" === s || "transparent" === s) && a && a.style;) {
								try {
									s = e.css(a, "backgroundColor"), a = a.parentNode;
								} catch (l) {}
							}r = r.blend(s && "transparent" !== s ? s : "_default");
						}r = r.toRgbaString();
					}try {
						t.style[i] = r;
					} catch (l) {}
				} }, e.fx.step[i] = function (t) {
				t.colorInit || (t.start = u(t.elem, i), t.end = u(t.end), t.colorInit = !0), e.cssHooks[i].set(t.elem, t.start.transition(t.end, t.pos));
			};
		});
	}, u.hook(a), e.cssHooks.borderColor = { expand: function expand(e) {
			var t = {};return h(["Top", "Right", "Bottom", "Left"], function (i, n) {
				t["border" + n + "Color"] = e;
			}), t;
		} }, o = e.Color.names = { aqua: "#00ffff", black: "#000000", blue: "#0000ff", fuchsia: "#ff00ff", gray: "#808080", green: "#008000", lime: "#00ff00", maroon: "#800000", navy: "#000080", olive: "#808000", purple: "#800080", red: "#ff0000", silver: "#c0c0c0", teal: "#008080", white: "#ffffff", yellow: "#ffff00", transparent: [null, null, null, 0], _default: "#ffffff" };
}(jQuery), !function (e) {
	function t() {
		try {
			var i = this === document ? e(this) : e(this).contents();
		} catch (n) {
			return !1;
		}i.mousemove(function (t) {
			e.mlp = { x: t.pageX, y: t.pageY };
		}), i.find("iframe").on("load", t);
	}e.mlp = { x: 0, y: 0 }, e(t), e.fn.ismouseover = function () {
		var t = !1;return this.eq(0).each(function () {
			var i = e(this).is("iframe") ? e(this).contents().find("body") : e(this),
			    n = i.offset();t = n.left <= e.mlp.x && n.left + i.outerWidth() > e.mlp.x && n.top <= e.mlp.y && n.top + i.outerHeight() > e.mlp.y;
		}), t;
	};
}(jQuery);var g_ugYoutubeAPI = new UGYoutubeAPI(),
    g_ugVimeoAPI = new UGVimeoAPI(),
    g_ugHtml5MediaAPI = new UGHtml5MediaAPI(),
    g_ugSoundCloudAPI = new UGSoundCloudAPI(),
    g_ugWistiaAPI = new UGWistiaAPI();jQuery.fn.unitegallery = function (e) {
	var t = jQuery(this),
	    i = "#" + t.attr("id");if (!e) var e = {};var n = new UniteGalleryMain();n.run(i, e);var r = new UG_API(n);return r;
};

if (typeof g_ugFunctions != "undefined") g_ugFunctions.registerTheme("tiles");else jQuery(document).ready(function () {
	g_ugFunctions.registerTheme("tiles");
});

/**
 * Grid gallery theme
 */
function UGTheme_tiles() {

	var t = this;
	var g_gallery = new UniteGalleryMain(),
	    g_objGallery,
	    g_objects,
	    g_objWrapper;
	var g_tiles = new UGTiles(),
	    g_lightbox = new UGLightbox(),
	    g_objPreloader,
	    g_objTilesWrapper;
	var g_functions = new UGFunctions(),
	    g_objTileDesign = new UGTileDesign();

	var g_options = {
		theme_enable_preloader: true, //enable preloader circle
		theme_preloading_height: 200, //the height of the preloading div, it show before the gallery
		theme_preloader_vertpos: 100, //the vertical position of the preloader
		theme_gallery_padding: 0, //the horizontal padding of the gallery from the sides
		theme_appearance_order: "normal", //normal, shuffle, keep - the appearance order of the tiles. applying only to columns type
		theme_auto_open: null //auto open lightbox at start
	};

	var g_defaults = {
		gallery_width: "100%"
	};

	//temp variables
	var g_temp = {
		showPreloader: false
	};

	/**
  * Init the theme
  */
	function initTheme(gallery, customOptions) {

		g_gallery = gallery;

		//set default options
		g_options = jQuery.extend(g_options, g_defaults);

		//set custom options
		g_options = jQuery.extend(g_options, customOptions);

		modifyOptions();

		//set gallery options
		g_gallery.setOptions(g_options);

		g_gallery.setFreestyleMode();

		g_objects = gallery.getObjects();

		//get some objects for local use
		g_objGallery = jQuery(gallery);
		g_objWrapper = g_objects.g_objWrapper;

		//init objects
		g_tiles.init(gallery, g_options);
		g_lightbox.init(gallery, g_options);

		g_objTileDesign = g_tiles.getObjTileDesign();
	}

	/**
  * modift options
  */
	function modifyOptions() {

		if (g_options.theme_enable_preloader == true) g_temp.showPreloader = true;

		switch (g_options.theme_appearance_order) {
			default:
			case "normal":
				break;
			case "shuffle":
				g_gallery.shuffleItems();
				break;
			case "keep":
				g_options.tiles_keep_order = true;
				break;
		}
	}

	/**
  * set gallery html elements
  */
	function setHtml() {

		//add html elements
		g_objWrapper.addClass("ug-theme-tiles");

		g_objWrapper.append("<div class='ug-tiles-wrapper' style='position:relative'></div>");

		//add preloader
		if (g_temp.showPreloader == true) {
			g_objWrapper.append("<div class='ug-tiles-preloader ug-preloader-trans'></div>");
			g_objPreloader = g_objWrapper.children(".ug-tiles-preloader");
			g_objPreloader.fadeTo(0, 0);
		}

		g_objTilesWrapper = g_objWrapper.children(".ug-tiles-wrapper");

		//set padding
		if (g_options.theme_gallery_padding) g_objWrapper.css({
			"padding-left": g_options.theme_gallery_padding + "px",
			"padding-right": g_options.theme_gallery_padding + "px"
		});

		g_tiles.setHtml(g_objTilesWrapper);
		g_lightbox.putHtml();
	}

	/**
  * actually run the theme
  */
	function actualRun() {

		//set preloader mode
		if (g_objPreloader) {
			g_objPreloader.fadeTo(0, 1);
			g_objWrapper.height(g_options.theme_preloading_height);
			g_functions.placeElement(g_objPreloader, "center", g_options.theme_preloader_vertpos);
		}

		initEvents();

		g_tiles.run();
		g_lightbox.run();
	}

	/**
  * run the theme
  */
	function runTheme() {

		setHtml();

		actualRun();
	}

	/**
  * init size of the thumbs panel
  */
	function initThumbsPanel() {

		//set size:
		var objGallerySize = g_gallery.getSize();

		if (g_temp.isVertical == false) g_objPanel.setWidth(objGallerySize.width);else g_objPanel.setHeight(objGallerySize.height);

		g_objPanel.run();
	}

	/**
  * on tile click - open lightbox
  */
	function onTileClick(data, objTile) {

		objTile = jQuery(objTile);

		var objItem = g_objTileDesign.getItemByTile(objTile);
		var index = objItem.index;

		g_lightbox.open(index);
	}

	/**
  * before items request: hide items, show preloader
  */
	function onBeforeReqestItems() {

		g_objTilesWrapper.hide();

		if (g_objPreloader) {
			g_objPreloader.show();

			var preloaderSize = g_functions.getElementSize(g_objPreloader);
			var galleryHeight = preloaderSize.bottom + 30;

			g_objWrapper.height(galleryHeight);
		}
	}

	/**
  * open lightbox at start if needed
  */
	function onLightboxInit() {

		if (g_options.theme_auto_open !== null) {
			g_lightbox.open(g_options.theme_auto_open);
			g_options.theme_auto_open = null;
		}
	}

	/**
  * init buttons functionality and events
  */
	function initEvents() {

		//remove preloader on tiles first placed
		if (g_objPreloader) {

			g_gallery.onEvent(g_tiles.events.TILES_FIRST_PLACED, function () {

				g_objWrapper.height("auto");
				g_objPreloader.hide();
			});
		}

		jQuery(g_objTileDesign).on(g_objTileDesign.events.TILE_CLICK, onTileClick);

		g_objGallery.on(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS, onBeforeReqestItems);

		jQuery(g_lightbox).on(g_lightbox.events.LIGHTBOX_INIT, onLightboxInit);
	}

	/**
  * destroy the theme
  */
	this.destroy = function () {

		jQuery(g_objTileDesign).off(g_objTileDesign.events.TILE_CLICK);

		g_gallery.destroyEvent(g_tiles.events.TILES_FIRST_PLACED);

		g_objGallery.off(g_gallery.events.GALLERY_BEFORE_REQUEST_ITEMS);

		jQuery(g_lightbox).off(g_lightbox.events.LIGHTBOX_INIT);

		g_tiles.destroy();
		g_lightbox.destroy();
	};

	/**
  * run the theme setting
  */
	this.run = function () {

		runTheme();
	};

	/**
  * add items
  */
	this.addItems = function () {

		g_tiles.runNewItems();
	};

	/**
  * init 
  */
	this.init = function (gallery, customOptions) {

		initTheme(gallery, customOptions);
	};
}
