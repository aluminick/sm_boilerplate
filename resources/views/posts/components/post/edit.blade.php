<div class="post-edit hide">
  <textarea name="content" class="form-control noresize-textarea content" value="{{ $post->content }}">{{ $post->content }}</textarea>
  <select name="is_private" class="form-control post-edit-privacy pull-right">
    <option value="0">Public</option>
    <option value="1" @if ($post->is_private == 1)
      selected
    @endif>Only Me</option>
  </select>
</div>
