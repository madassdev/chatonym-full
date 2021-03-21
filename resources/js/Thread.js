import Vue from "vue";

//Main pages
import Thread from "./views/Thread.vue";
import store from "./store/threadMessage";
Vue.use(require("vue-moment"));

const app = new Vue({
    el: "#threads",
    store,
    components: { Thread },
    render: h => h(Thread),

});
