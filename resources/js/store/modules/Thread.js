import handler from '../../handler'
const state = {
    threadMessages: [],
    appThread: app_thread,
    appUser: app_user,
    loadingThreadMessages: true,
    shouldFetchThreadMessages: true,
    nextThreadMessagesUrl: "threads/fetch",
    threadMessagemodalImageUrl: "/img/placeholders/smileys.jpg",
    threadMessageMediaText: "",
    threadMessageMediaImageObject: null
};

const getters = {
    threadMessages: state => {
        return state.threadMessages;
    },
    appThread: state => {
        return state.appThread;
    },
    appUser: state => {
        return state.appUser;
    },
    loadingThreadMessages: state => {
        return state.loadingThreadMessages;
    },
    shouldFetchThreadMessages: state => {
        return state.shouldFetchThreadMessages;
    },
    nextThreadMessagesUrl: state => {
        return state.nextThreadMessagesUrl;
    }
};


const actions = {
    async fetchThreadMessages({ commit, state }) {
        await axios
            .get(app_url+`thread/${state.appThread.slug}/fetch`)
            .then(res => {
                commit(
                    "setThreadMessages",
                    res.data.data.messages.data.reverse()
                );
                commit(
                    "setNextThreadMessagesUrl",
                    res.data.data.messages.next_page_url
                );
                commit("setLoadingThreadMessages", false);
            })
            .catch(function(error) {
                handler.handle(error)
            });
    },

    async fetchMoreThreadMessages({ commit, state }) {
        commit("setLoadingThreadMessages", true);
        await axios
            .get(state.nextThreadMessagesUrl)
            .then(res => {
                commit("setLoadingThreadMessages", false);
                commit("setShouldFetchThreadMessages", false);
                commit(
                    "setMoreThreadMessages",
                    res.data.data.messages.data.reverse()
                );
                commit(
                    "setNextThreadMessagesUrl",
                    res.data.data.messages.next_page_url
                );
            })
            .catch(function(error) {
                handler.handle(error)
            });
    },

    async sendNewThreadMessage({ commit, state }, payload) {
        // var created_message = {
        //     id: Date.now(),
        //     parent_id: payload.replying.id,
        //     thread_id: state.appThread.id,
        //     message: payload.message,
        //     status: "submitted",
        //     created_at: Date.now(),
        //     image_url: null,
        //     media_type: "text",
        //     reactions_count: 0,
        //     replies: 0,
        //     total_reactions: 0,
        //     reacted_by_user: null,
        //     parent: payload.replying ? payload.replying : null
        // };
        // // await ;
        await axios
            .post(app_url+`thread/${state.appThread.slug}`, {
                message: payload.message,
                message_id: payload.replying.id
            })
            .then(res => {
                commit("setNewThreadMessage", res.data.data);
            })
            .catch(function(error) {
                clog(error);
                notyf.error({
                    message:
                        "sav new Action failed, please check your internet connection and retry",
                    duration: 5000
                });
            });
    }
};

const mutations = {
    setThreadMessages(state, threadMessages) {
        state.threadMessages = threadMessages;
    },
    setAppThread(state, thread) {
        state.appThread = thread;
    },
    setAppUser(state, user) {
        state.appUser = user;
    },
    setNextThreadMessagesUrl(state, url) {
        state.nextThreadMessagesUrl = url;
    },
    setLoadingThreadMessages(state, value) {
        state.loadingThreadMessages = value;
    },
    setMoreThreadMessages(state, newThreadMessages) {
        state.threadMessages = newThreadMessages.concat(state.threadMessages);
    },
    setNewThreadMessage(state, newThreadMesage) {
        state.threadMessages.push(newThreadMesage);
    },
    setShouldFetchThreadMessages(state, value) {
        state.shouldFetchThreadMessages = value;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
