
<template>
  <div class="modal micromodal-slide" id="feed-open-modal" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div
        class="modal__container p-3 w-full mx-2"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-1-title"
      >
        <header class="modal__header text-cha-primary">
          <h2 class="modal__title" id="modal-1-title"></h2>
          <button
            class="modal__close"
            aria-label="Close modal"
            data-micromodal-close
          ></button>
        </header>
        <main class="modal__content p-3" id="modal-1-content">
          <div class="flex w-full items-center justify-center">
            <img
              :src="image_url"
              class="feed-modal-image md:h-80 rounded-xl"
              alt=""
              srcset=""
            />
          </div>
        </main>
      </div>
    </div>
  </div>
</template>
<script>
const default_layout = "default";

export default {
  computed: {},
  props: ["image_url"],
  data() {
    return {};
  },
};
</script>