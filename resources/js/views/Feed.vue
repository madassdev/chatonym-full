<template>
  <div>
    <NewFeed @sendClicked="saveFeed" ref="newFeed" />
    <FeedCard
      v-for="feed in feeds"
      :key="feed.id"
      :feed="feed"
      @imageClicked="openImageModal"
      :ref="'feed-ref-' + feed.id"
      :finder="'feed-ref-' + feed.id"
    />
    <!-- <FeedCard v-bind:feed="feed"/> -->
    <Spinner v-if="loadingFeeds" :text="'Loading feeds...'" />
    <ImageModal :image_url="modal_image_url" />
    <MediaUploadModal
      :caption="modalMediaCaption"
      :media="modalMediaObject"
      :intent="modalMediaIntent"
      @mediaSent="dispatchMediaModal"
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
      "modalMediaIntent",
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
    alert('mounted')
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
    $(document.body).on('touchmove', this.handleScroll);
    window.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    $(document.body).on('touchmove', this.handleScroll);
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    async dispatchMediaModal(caption, media, intent) {
      if (intent.type === "saveFeed") {
        await this.saveFeed(caption, media);
        return;
      }
      if (intent.type === "feedReply") {
        //find the feed to reply
        const intended_feed = this.$refs[intent.ref][0];
        clog(intended_feed);
        intended_feed.saveReplyMedia(caption, media);
        return;
      }
    },
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
          .then(async (uploaded_image) => {
            saved_feed.is_uploading = false;
            store.commit("updateMockFeed", {
              id: saved_feed.id,
              data: saved_feed,
            });

            clog("uploaded_image");
            await store
              .dispatch("updateFeedImage", {
                feed_id: saved_feed.id,
                image_url: uploaded_image,
              })
              .then(function (data) {});
          });
      }
    },
    async handleScroll(event) {
      if (
        $(window).scrollTop() + window.innerHeight >=
          document.body.scrollHeight &&
        this.shouldFetchFeeds
      ) {
        var store = this.$store;
        this.$store.commit("setLoadingFeeds", true);
        await this.$store.dispatch("fetchMoreFeeds").then(function () {
          store.commit("setFetching", true);
        });
        store.commit("setFetching", true);
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