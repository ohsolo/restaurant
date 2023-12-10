import { createApp } from "vue";

import "bootstrap/dist/css/bootstrap.min.css";
import "vue-select/dist/vue-select.css";
import "./assets/scss/style.scss";
import "./assets/font/font.css?family=Goldplay:100,300,400,500,600,700,900&display=swap";

import App from "./App.vue";
import router from "./router";
import Vue3Storage from "vue3-storage";
import axios from "axios";
import VueAxios from "vue-axios";
import { store } from "./store";
import { createI18n } from "vue-i18n";
import vSelect from "vue-select";
import titleMixin from "./mixins/titleMixin";
import FontAwesomeIcon from "./fa";
import { messages } from "./lang";
import firebase from './fire';

const app = createApp(App);
app.config.globalProperties.$Firebase = firebase;
app.config.globalProperties.$Messaging = firebase.messaging();
app.config.globalProperties.$WebPC = 'BDmPY-ldaoJ2kSiKTY_LvNlScniKiluUXzrWmihuEjOxJK2dTOzoalMvYavXjo22y4shZkLXY-USA6lB7jgzIb0';

export const i18n = createI18n({
  locale: "por",
  fallbackLocale: "por",
  messages,
});

app.use(i18n);
app.use(router);
app.use(Vue3Storage);
app.use(VueAxios, axios);
app.use(store);
app.mixin(titleMixin);
app.component("fa", FontAwesomeIcon);
app.component("v-select", vSelect);
app.mount("#app");

import "bootstrap/dist/js/bootstrap.bundle.min.js";
