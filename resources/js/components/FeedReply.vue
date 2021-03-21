<template>
  <div class="feed-replies">
    <p class="replies-count text-cha-primary text-xs mx-4 hiddden"></p>
    <div class="replies-container flex flex-col space-y-2">
      <div
        v-for="reply in replies" v-bind:key="reply.id" class="reply-template w-5/6 mx-auto px-4 my-1 border-l border-gray-300 hiddden"
      >
        <p
          class="font-light truncate-2 text-gray-600 text-xs-12 leading-1 reply-text"
        >
          {{reply.message}}
        </p>
        <p
          class="font-light text-gray-400 text-xs-10 flex items-center space-x-1"
        >
          <i class="mdi mdi-circle text-gray-400" style="font-size: 4px"></i>
          <span class="reply-date"> {{ reply.created_at | moment("calendar")  }} </span>
        </p>
      </div>
    </div>
    <div class="see-more hiddden mx-auto w-3/4">
      <a href="#" class="text-cha-primary text-xs">See more...</a>
    </div>
  </div>
</template>

<script>
export default {
    props:["replies"],
  mounted() {
    // console.log(this.replies);
  },
};
</script>
