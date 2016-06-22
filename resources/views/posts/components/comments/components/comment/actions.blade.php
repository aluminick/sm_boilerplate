<div class="row-fluid comment-action">
  <div class="col-md-12">
    @if(Auth::user()->id == $comment->owner_id)
      <button type="button" class="btn btn-default btn-sm btn-edit-comment"><i class="fa fa-pencil"></i></button>
      <button type="button" class="btn btn-default btn-sm btn-delete-comment"><i class="fa fa-trash"></i></button>
    @endif
    <button type="button" class="btn unlike {{ $comment->is_unliked? 'btn-primary': 'btn-default' }} btn-sm {{ $comment->is_unliked? 'btn-undo-unlike-comment': 'btn-unlike-comment'}} pull-right"><i class="fa fa-thumbs-o-down"></i></button>
    <button type="button" class="btn like {{ $comment->is_liked? 'btn-primary': 'btn-default' }} btn-sm {{ $comment->is_liked? 'btn-undo-like-comment': 'btn-like-comment' }} pull-right"><i class="fa fa-thumbs-o-up"></i></button>
  </div>
</div>
