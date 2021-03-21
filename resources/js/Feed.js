import Vue from "vue";

//Main pages
import Feed from "./views/Feed.vue";
import store from "./store/feed";
Vue.use(require("vue-moment"));

const app = new Vue({
    el: "#feeds",
    store,
    components: { Feed },
    render: h => h(Feed),

});
