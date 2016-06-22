<div class="row">
  <div class="form-group">
    <div class="col-md-12">
      <form id="post-form" action="{{ url('post') }}" method="POST">
        {{ csrf_field() }}
        <textarea name="content" id="add-post" class="form-control noresize-textarea" style="height: 100px; margin-bottom: 10px" placeholder="Create content...">{{ old('content') }}</textarea>
        <div id="post-error-container">
        </div>
        <button type="submit" class="btn btn-success btn-md pull-right">Post</button>
        <select name="is_private" class="form-control pull-right" id="post-privacy">
          <option value="0">Public</option>
          <option value="1">Only Me</option>
        </select>
      </form>
    </div>
  </div>
</div><div class="clearfix"></div>
