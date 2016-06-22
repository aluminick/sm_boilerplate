<div class="post-action row-fluid">
  <button type="button" class="btn {{ $post->is_liked? 'btn-primary': 'btn-default'}} btn-sm {{ $post->is_liked? 'btn-unlike-post': 'btn-like-post'}}"><i class="fa fa-thumbs-o-up"></i>&nbsp;<span>Like</span></button>
  <button type="button" class="btn btn-default btn-sm btn-comment-post"><i class="fa fa-comment-o"></i>&nbsp;<span>Comment</span></button>
  @if(Auth::user()->id == $post->owner_id)
    <button type="button" class="btn btn-default btn-sm btn-edit-post"><i class="fa fa-pencil"></i>&nbsp;<span>Edit</span></button>
    <button type="button" class="btn btn-default btn-sm btn-delete-post"><i class="fa fa-trash"></i></button>
  @endif
</div>
