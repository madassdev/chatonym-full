import Vue from 'vue';
import Vuex from 'vuex';
import User from './modules/User';
import Feed from './modules/Feed';
import Thread from './modules/Thread';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        User,
        Feed,
        Thread,
    }
})