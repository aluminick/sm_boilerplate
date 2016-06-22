<div class="comment-list-container col-md-12 row-fluid hide">

  <!-- Add Comment (posts.components.comments.add.blade.php)-->
  @include('posts.components.comments.components.add')
  <!-- End of Add Comment -->

  <!-- Comment (posts.components.comments.components.container.blade.php) -->
  <div class="comment-list">
    @if (count($comments) > 0)
      @foreach($comments as $comment)
        @include('posts.components.comments.components.comment')
      @endforeach
    @endif
  </div>
  <!-- End of Comment -->

</div>
