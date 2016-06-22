<div class="post">
  <hr>
  @if(Auth::user()->id == $post->owner_id)
  @include('posts.components.post.confirm')
  @endif
  <div class="post-container row-fluid" data-id="{{ $post->id }}">

    <!-- Post Info (posts/components/post/info.blade.php)-->
    @include('posts.components.post.info')
    <!-- End of Post Info-->

    <!-- Post Info (posts/components/post/edit.blade.php)-->
    @if(Auth::user()->id == $post->owner_id)
    @include('posts.components.post.edit')
    @endif
    <!-- End of Post Edit-->

    <!-- Post Action (posts/components/post/actions.blade.php)-->
    @include('posts.components.post.actions')
    <!-- End of Post Action -->

    <!-- Comments Container -->
    @include('posts.components.comments.container')
    <!-- End of Comments Container -->

  </div>
  <div class="clearfix"></div>
</div>
