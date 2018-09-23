
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCoffee } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.component('app-chat', require('./components/AppChat.vue'));
Vue.component('ChatPortal', require('./components/ChatPortal.vue'));
Vue.component('FriendsList', require('./components/FriendsList.vue'));
Vue.component('ChatFeed', require('./components/ChatFeed.vue'));
Vue.component('ChatComposer', require('./components/ChatComposer.vue'));
Vue.component('font-awesome-icon', FontAwesomeIcon);

const app = new Vue({
    el: '#app'
});
