
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
  import VueBootstrapDatetimePicker from 'vue-bootstrap-datetimepicker';
  import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('task-options', require('./components/TasksOptionsComponent.vue').default);
Vue.component('task-list', require('./components/TasksList.vue').default);
Vue.component('task-form', require('./components/TaskForm.vue').default);
Vue.component('date-picker', VueBootstrapDatetimePicker);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
$.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'far fa-trash-alt',
      close: 'far fa-times-circle'
    }
});
const app = new Vue({
    el: '#app',
    data: {
      date: null,
      options: {
        format: 'YYYY-MM-DD hh:mm:ss',
        minDate:new Date(),
        useCurrent: true,
        showClear: true,
        showClose: true,
      }
    },
});
