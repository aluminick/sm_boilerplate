
<div class="row-fluid" id="post-list">
  @if(count($posts) > 0)
    @foreach($posts as $post)
      <!-- Post (posts/post.blade.php)-->
      @include('posts.components.post')
      <!-- End of Post -->
    @endforeach
  @else
    <div id="no-posts" style="margin-top: 10px" class="alert alert-warning">
      No posts to show
    </div>
  @endif
</div>
