<div class="comment">
  @if(Auth::user()->id == $comment->owner_id)
  <!-- Comment Info (posts.components.comments.components.comment.confirm.blade.php)-->
  @include('posts.components.comments.components.comment.confirm')
  <!-- End of Comment Confirm Delete-->
  @endif

  <div class="row comment-container" data-id="{{ $comment->id }}">

    <!-- Comment Info (posts.components.comments.components.comment.info.blade.php)-->
    @include('posts.components.comments.components.comment.info')
    <!-- End of Comment Info-->

    @if(Auth::user()->id == $comment->owner_id)
    <div class="col-md-12 comment-edit-container hide">
      <!-- Comment Edit (posts.components.comments.components.comment.edit.blade.php)-->
      @include('posts.components.comments.components.comment.edit')
      <!-- End of Comment Info-->
    </div>
    @endif
    <!-- Comment Action (posts.components.comments.components.comment.actions.blade.php) -->
    @include('posts.components.comments.components.comment.actions')
    <!-- End of Comment Action -->

  </div>

</div>
