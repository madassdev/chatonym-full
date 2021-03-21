<template>
  <div>
    <NewFeed @sendClicked="saveFeed" ref="newFeed" />
    <FeedCard
      v-for="feed in feeds"
      :key="feed.id"
      :feed="feed"
      @imageClicked="openImageModal"
    />
    <!-- <FeedCard v-bind:feed="feed"/> -->
    <Spinner v-if="loadingFeeds" :text="'Loading feeds...'" />
    <ImageModal :image_url="modal_image_url" />
    <MediaUploadModal
      :caption="modalMediaCaption"
      :media="modalMediaObject"
      @mediaSent="saveFeed"
    />
  </div>
</template>
<script>
var app_url = $("head base").attr("href");
var feeds_url = "https://chatonym.dv";

const default_layout = "default";

import Spinner from "../components/Spinner";
import FeedCard from "../components/FeedCard";
import ImageModal from "../components/ImageModal";
import MediaUploadModal from "../components/MediaUploadModal";
import NewFeed from "../components/NewFeed";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters([
      "feeds",
      "loadingFeeds",
      "shouldFetchFeeds",
      "next_url",
      "modalMediaObject",
      "modalMediaCaption",
    ]),
  },
  data() {
    return {
      // feeds: [],
      // loadingFeeds: true,
      modal_image_url: "/img/placeholders/smileys.jpg",
    };
  },
  async mounted() {
    await this.$store.dispatch("fetchFeeds");
  },
  components: {
    Spinner,
    FeedCard,
    ImageModal,
    NewFeed,
    MediaUploadModal,
  },
  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    async saveFeed(message, image = null) {
      this.$refs.newFeed.reset();
      var store = this.$store;

      let timestamp = Date.now();
      const mock_feed = {
        is_mock: true,
        id: timestamp,
        parent_id: null,
        user_id: 1,
        message: message,
        media_type: "text-and-image",
        image_url: null,
        mock_image: image,
        is_uploading: image !== null,
        status: "submitted-with-image",
        reactions_count: 0,
        created_at: timestamp,
        replies: [],
        reacted_by_user: null,
      };

      store.commit("setNewFeed", mock_feed);
      var saved_feed = await this.$store
        .dispatch("saveMockFeed", mock_feed)
        .then(function (feed) {
          return feed;
        });

      saved_feed.is_mock = false;
      store.commit("updateMockFeed", {
        id: mock_feed.id,
        data: saved_feed,
      });

      if (image !== null) {
        var uploaded_feed_image = await this.$store
          .dispatch("uploadToCloudinary", {
            image: image,
          })
          .then(async () => {
            saved_feed.is_uploading = false;
            store.commit("updateMockFeed", {
              id: saved_feed.id,
              data: saved_feed,
            });
            await store.dispatch('updateFeedImage', {
              feed_id: saved_feed.id,
              image_url: uploaded_feed_image
            }).then(function(data){
              clog('updated image data')
              clog(data)
            })
          });
      }

    },
    async handleScroll(event) {
      if (
        $(window).scrollTop() + window.innerHeight >=
          document.body.scrollHeight &&
        this.shouldFetchFeeds
      ) {
        await this.$store.dispatch("fetchMoreFeeds");
        this.$store.commit("setFetching", true);
        if (this.next_url === null) {
          this.$store.commit("setFetching", false);
        }
      }
    },

    openImageModal(image_url) {
      if (!auth) {
        doLogin();
      } else {
        this.modal_image_url = image_url;
        MicroModal.show("feed-open-modal");
      }
    },
  },
};
</script>