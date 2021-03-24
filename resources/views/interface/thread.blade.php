@extends('layouts.vue')

@section('content')
<section>
    <div id="threads" class="">

    </div>
</section>
@endsection

@section('scripts')
<script>
function ScrollPosition(node) {
  this.node = node;
  this.previousScrollHeightMinusTop = 0;
  this.readyFor = 'up';
}

ScrollPosition.prototype.restore = function() {
    if (this.readyFor === 'up') {
        this.node.scrollTop = this.node.scrollHeight - this.previousScrollHeightMinusTop - 50;
    }

  // 'down' doesn't need to be special cased unless the
  // content was flowing upwards, which would only happen
  // if the container is position: absolute, bottom: 0 for
  // a Facebook messages effect
}

ScrollPosition.prototype.prepareFor = function(direction) {
  this.readyFor = direction || 'up';
  this.previousScrollHeightMinusTop = this.node.scrollHeight - this.node.scrollTop;
}


var app_thread = @json($thread) 
// clog(app_thread)
</script>
<script src="{{ asset('js/Thread.js') }}"></script>
@endsection