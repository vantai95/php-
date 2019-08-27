/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');


import 'slick-carousel';
import I18nJs from '../../common/js/I18nJs';
window.I18nJs = I18nJs;
window.translator = new I18nJs();

// Toastr Notification
window.toastr = require('toastr');