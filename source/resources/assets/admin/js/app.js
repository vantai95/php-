
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.Vue = require('vue');
import _ from 'lodash';

//Vue Components
Vue.component('menus-component',require('./components/MenusComponent.vue'));
Vue.component('sub-menus-component',require('./components/SubMenusComponent.vue'));
Vue.component('categories-component',require('./components/CategoriesComponent.vue'));
Vue.component('sub-categories-component',require('./components/SubCategoriesComponent.vue'));
Vue.component('items-component',require('./components/ItemsComponent.vue'));
Vue.component('promotions-component',require('./components/PromotionsComponent.vue'));
Vue.component('sub-items-component',require('./components/SubItemsComponent.vue'));

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};


const app = new Vue({
    el: '#app',
    // data:{
    //     subItems: [
    //         {'subItem': {}}
    //     ],
    //     subItem: {},
    // },
    // methods: {
    //     addSubItem: function () {
    //         this.subItems.push({'subItem': {}})
    //     },
    //     removeSubItem: function (index) {
    //         this.subItems.splice(index, 1);
    //     }
    //   }
})

import I18nJs from '../../common/js/I18nJs';
window.I18nJs = I18nJs;
window.translator = new I18nJs();