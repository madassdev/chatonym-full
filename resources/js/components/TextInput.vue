<template>
  <div
    class="w-full mx-auto rounded-full flex items-center mb-1 md:space-x-1 space-x-2"
  >
    <div
      class="textarea flex space-x-4 items-center pr-3 w-full rounded-full bg-white"
    >
      <textarea
        name=""
        ref="replyInput"
        v-model="message"
        id="reply-message"
        cols="30"
        class="px-4 py-1 text-xs text-gray-600 border-0 resize-none rounded-full w-full placeholder-gray-400"
        placeholder="Write something.."
      ></textarea>
      <MediaUploaderIcon @mediaSelected="mediaSelected" />

      <i
        @click="sendClicked"
        class="mdi mdi-send text-xl text-cha-primary cursor-pointer reply-send"
      ></i>
    </div>
  </div>
</template>

<script>
import MediaUploaderIcon from './MediaUploaderIcon'
export default {
  props: ["text"],
  computed: {
    reactionIcon: function () {},
  },
  data() {
    return {
      message: this.text,
      media: null,
    };
  },

  components:{
      MediaUploaderIcon
  },

  mounted() {
    this.$refs.replyInput.focus();
  },
  methods: {
    sendClicked() {
      this.$emit("sendClicked", { message: this.message, media: this.media });
    },
    mediaSelected(media){
      this.$emit("mediaSelected", {message:this.message, media:media});
    }
  },
};
</script>
