import Vue from 'vue';
import Vuex from 'vuex';
import Thread from './modules/Thread';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Thread,
    }
})