/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueMask from 'v-mask';

window.Vue = require('vue').default;
Vue.use(VueMask);
Vue.use(require('vue-resource'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Admin Components
Vue.component('admin-component',require('./components/Admin/AdminComponent').default);
Vue.component('admin-list-appointment-component', require('./components/Admin/AdminListAppointmentComponent').default);
Vue.component('admin-waiting-appointment-component', require('./components/Admin/AdminWaitingAppointmentComponent').default);
Vue.component('admin-cancel-appointment-component', require('./components/Admin/AdminCancelAppointmentComponent').default);
Vue.component('admin-appointment-component', require('./components/Admin/AdminAppointmentComponent').default);
Vue.component('admin-today-appointment-component', require('./components/Admin/AdminTodayAppointmentComponent').default);
Vue.component('admin-last-appointment-component', require('./components/Admin/AdminLastAppointmentComponent').default);

//Form Component
Vue.component('appointment-form-component', require('./components/AppointmentFormComponent').default);

//Vue Pagination
Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
