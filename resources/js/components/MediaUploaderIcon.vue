<template>
  <div
    id="imgBtn"
    @click="selectMedia"
    class="flex items-center justify-center top-2 right-2 h-8 w-8 cursor-pointer rounded-full"
  >
    <input
      id="mediaInput"
      type="file"
      ref="mediaInput"
      :v-model="media"
      class="h-0 w-0"
      accept="image/*"
      @change="setMedia"
    />
    <i
      class="mdi mdi-camera-image text-cha-primary text-xl cursor-pointer media-upload image"
    ></i>
  </div>
</template>

<script>
export default {
  props: ["text"],
  data() {
    return {
      media: null,
    };
  },
  mounted() {},
  methods: {
    selectMedia() {
      if (!auth) {
        doLogin();
        return false;
      }
      this.$refs.mediaInput.click();
    },
    setMedia(event) {
      const files = event.target.files;
      let filename = files[0].name;
      const fileReader = new FileReader();
      fileReader.addEventListener("load", () => {
        this.imageUrl = fileReader.result;
      });
      fileReader.readAsDataURL(files[0]);
      this.media = files[0];
      this.$emit("mediaSelected", this.media);
      this.resetMedia();
    },
    resetMedia() {
      this.$refs.mediaInput.value = null;
    },
  },
};
</script>
