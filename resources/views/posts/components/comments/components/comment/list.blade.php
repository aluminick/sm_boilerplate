@foreach ($comments as $comment)
  @include('posts.components.comments.components.comment')
@endforeach

@if ($offset == 5)
  <div class="row view-more-comments-container" data-offset="{{ $offset }}">
    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4" style="text-align: center">
        <button class="btn btn-default btn-view-more-comments">View More</button>
    </div>
  </div>
@endif
