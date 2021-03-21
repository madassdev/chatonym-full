const state = {
    feeds: [],
    loadingFeeds: true,
    shouldFetchFeeds: true,
    appUser: app_user,
    next_url: "feeds/fetch",
    modal_image_url: "/img/placeholders/smileys.jpg",
    messageMediaText: "",
    mediaImageObject: null,
    modalMediaObject: null,
    modalMediaCaption: "Default caption"
};

const getters = {
    feeds: state => {
        return state.feeds;
    },
    loadingFeeds: state => {
        return state.loadingFeeds;
    },
    shouldFetchFeeds: state => {
        return state.shouldFetchFeeds;
    },
    next_url: state => {
        return state.next_url;
    },
    modalMediaObject: state => {
        return state.modalMediaObject;
    },
    modalMediaCaption: state => {
        return state.modalMediaCaption;
    }
};

async function updateFeedImage() {}

// async function saveFeed(f) {
//     let r =
//     return r;
// }

const actions = {
    openMediaModal({ commit, state }, payload) {
        commit("configureMediaModal", payload);
        MicroModal.show("media-upload-modal");
    },
    closeMediaModal({ commit, state }) {
        commit("configureMediaModal", { caption: null, media: null });
        MicroModal.close("media-upload-modal");
    },

    fetchFeeds({ commit, state }) {
        axios
            .get("feeds/fetch")
            .then(res => {
                commit("setFeeds", res.data.data.feeds.data);
                commit("setNextUrl", res.data.data.feeds.next_page_url);
                commit("setLoadingFeeds", false);
            })
            .catch(function(error) {
                notyf.error({
                    message:
                        "Action failed, please check your internet connection and retry",
                    duration: 5000
                });
            });
    },

    async fetchMoreFeeds({ commit, state }) {
        commit("setLoadingFeeds", true);
        await axios
            .get(state.next_url)
            .then(res => {
                commit("setLoadingFeeds", false);
                commit("setFetching", false);
                commit("setMoreFeeds", res.data.data.feeds.data);
                commit("setNextUrl", res.data.data.feeds.next_page_url);
            })
            .catch(function(error) {
                notyf.error({
                    message:
                        "Action failed, please check your internet connection and retry",
                    duration: 5000
                });
            });
    },

    async saveMockFeed({ commit, state }, mock_feed) {
        const saved_feed = await axios
            .post("/feeds", { message: mock_feed.message })
            .then(res => {
                res.data.data.mock_image = mock_feed.mock_image;
                return res.data.data;
            })
            .catch(function(error) {
                clog(error);
                notyf.error({
                    message:
                        "Action failed, please check your internet connection and retry",
                    duration: 5000
                });
            });
        return saved_feed;
    },

    async updateFeedImage({ commit, state }, payload) {
        var new_img_feed = await axios
            .post("/feeds/" + payload.feed_id + "/update_image", {
                image_url: payload.image_url
            })
            .then(res => {
                return res.data.data;
            })
            .catch(function(error) {
                clog(error);
                notyf.error({
                    message:
                        "Action failed, please check your internet connection and retry",
                    duration: 5000
                });
            });
        return new_img_feed;
    },

    async uploadToCloudinary({ commit, state }, payload) {
        var fd = new FormData();
        fd.append("file", payload.image);
        fd.append("api_key", CLOUDINARY_API_KEY);
        fd.append("folder", CLOUDINARY_FOLDER_ID + "/feeds");
        fd.append("upload_preset", CLOUDINARY_UPLOAD_PRESET);
        var cloudinary_img_url;
        await $.ajax({
            // url: "https://chatonym.dv/mock",
            url: CLOUDINARY_UPLOAD_URL,
            type: "post",
            data: fd,
            contentType: false,
            processData: false
        }).done(function(res) {
            var image_url = [
                {
                    public_id: res.secure_url,
                    url: res.secure_url
                }
            ];
            cloudinary_img_url = image_url;
        });

        return cloudinary_img_url
    }
};
var replaceObject = function(old, fresh) {
    var prop;
    for (prop in old) delete old[prop];
    for (prop in fresh) old[prop] = fresh[prop];
    return old;
};

const mutations = {
    setFeeds(state, feeds) {
        state.feeds = feeds;
    },

    configureMediaModal(state, payload) {
        state.modalMediaObject = payload.media;
        state.modalMediaCaption = payload.caption;
    },
    setNextUrl(state, url) {
        state.next_url = url;
    },
    setLoadingFeeds(state, value) {
        state.loadingFeeds = value;
    },
    removeMockFeedLoader(state, fd) {
        clog("fdis");
        clog(fd.data);
        state.feeds = state.feeds.map(f => {
            if (f.id == fd.data.id) {
                clog("found");
                fd.data.loadingSpinner = "remove";
                fd.data.message = "foul";
                replaceObject(f, fd.data);
                clog(fd.data);
                clog(f);
            }
            return f;
        });

        // this.commit('setFeeds', nfd)
    },
    setMoreFeeds(state, newFeeds) {
        state.feeds = state.feeds.concat(newFeeds);
    },
    setNewFeed(state, newFeed) {
        state.feeds.unshift(newFeed);
    },
    incrementItemQuantity(state, { id }) {
        const cartItem = state.items.find(item => item.id === id);
        cartItem.quantity++;
    },
    updateMockFeed(state, payload) {
        Object.assign(
            state.feeds.find(feed => (feed.id = payload.id)),
            payload.data
        );
    },
    setFetching(state, value) {
        state.shouldFetchFeeds = value;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
