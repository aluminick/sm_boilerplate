(function() {

  $(function() {

    //**Add post event**//

    $('#post-form').on('submit', function (event) {
      event.preventDefault();
      var params = {
        'content': $(this).find('[name="content"]').val(),
        'is_private': $(this).find('[name="is_private"]').val()
      };

      $.ajax({
        url: '/post',
        type: 'POST',
        dataType: 'json',
        data: params
      })
      .done(function(data, textStatus, xhr) {
        if ($('#post-list').find('#no-posts').length) {
          $('#no-posts').remove();
        }
        $('#post-form').find('[name="content"]').val('');
        $('#post-list').prepend(data.html);
        $('#post-form').find('#post-error-container').find('.common-errors').remove();
      })
      .fail(function(xhr, textStatus, err) {
        console.log(xhr);
        console.log(textStatus);
        console.log(err);
        $('#post-form').find('#post-error-container').append(xhr.responseText);
        $('#post-form').find('#post-error-container').html(xhr.responseJSON.html);
      })
      .always(function() {
        //Complete
      });

    });

    //**End of Add post event**//


    //**Edit post event**//
    var toggleEditPostUI = function ($el, action) {
      var parent = $el.parents('.post-action');
      var postId = parent.parents('.post-container').data('id');
      var postEdit = parent.siblings('.post-edit');
      var postEditContent = postEdit.find('[name="content"]');
      var postEditIsPrivate = postEdit.find('[name="is_private"]');

      var params = {
        content: postEditContent.val(),
        is_private: postEditIsPrivate.val()
      };

      var postContent = parent.siblings('.post-info').find('.post-content');
      var postError = '<div class="alert alert-danger fade in post-error">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                        <strong>Error!</strong> Can\'t edit post at the moment.\
                       </div>';

      postEdit.toggleClass('hide');
      postContent.toggleClass('hide');

      $el.find('i').toggleClass('fa-pencil').toggleClass('fa-check');
      $el.toggleClass('btn-edit-post');
      $el.toggleClass('btn-edit-post-done');

      if (action === 'edit') {
        let postError = parent.find('.post-error');
        if(postError.length > 0) {
          postError.remove();
        }
        $el.find('span').text('Done');
      } else { //done editing
        $el.find('span').text('Edit');
        let prevContent = postContent.text().trim();
        postContent.text(postEditContent.val());

        $.ajax({
          url: '/post/'+postId,
          type: 'PUT',
          dataType: 'json',
          data: params
        })
        .done(function(data, textStatus, xhr) {
          //Done
        })
        .fail(function(xhr, textStatus, err) {
          console.log(xhr);
          postContent.text(prevContent);
          postEditContent.val(prevContent);
          if(typeof(xhr.responseJSON) !== 'undefined') {
            parent.prepend(xhr.responseJSON.html);
          } else {
            parent.prepend(postError);
          }
        })
        .always(function() {
          //Complete
        });

      }
    };

    $('#post-list').on('click', '.btn-edit-post', function () {
      toggleEditPostUI($(this), 'edit');
    });

    $('#post-list').on('click', '.btn-edit-post-done', function () {
      toggleEditPostUI($(this), 'done');
    });

    //**End of Edit post event**//



    //**Delete post event**//
    var deletePostUI = function ($el) {
      var parent = $el.parents('.post-container');
      var postAction = parent.find('.post-action');
      var confirm = parent.prev('.delete-post-confirmation');
      var postError = postAction.find('.post-error');

      if (postError.length > 0) {
        postError.remove();
      }

      parent.toggleClass('hide');
      confirm.toggleClass('hide');
    };

    $('#post-list').on('click', '.btn-delete-post', function () {
      deletePostUI($(this));
    });

    $('#post-list').on('click', '.btn-delete-post-undo', function (event) {
      event.preventDefault();

      var parent = $(this).parents('.delete-post-confirmation');
      var post = parent.next('.post-container');

      parent.toggleClass('hide');
      post.toggleClass('hide');
    });

    $('#post-list').on('click', '.btn-delete-post-confirm', function (event) {
      event.preventDefault();

      var parent = $(this).parents('.delete-post-confirmation');
      var postParent = parent.parents('.post');
      var post = parent.next('.post-container');
      var postAction = post.find('.post-action');
      var hr = parent.prev('hr');
      var clearFix = post.next('.clearfix');
      var postError = '<div class="alert alert-danger fade in post-error">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                        <strong>Error!</strong> Can\'t delete post at the moment.\
                       </div>';

      var postId = post.data('id');

      // post.addClass('hide');
      // hr.addClass('hide');
      // clearFix.addClass('hide');

      // For Optimistic UI
      var elCopy = [hr.detach(), parent.detach(), post.detach(), clearFix.detach()];

      $.ajax({
        url: '/post/'+postId,
        type: 'DELETE',
        dataType: 'json'
      })
      .done(function(data, textStatus, xhr) {
        console.log(xhr);
        postParent.remove();
      })
      .fail(function(xhr, textStatus, err) {
        console.log(xhr);
        postParent.prepend(elCopy);
        post.removeClass('hide');
        parent.addClass('hide');
        hr.removeClass('hide');
        clearFix.removeClass('hide');
        postAction.prepend(postError);
      })
      .always(function() {
        console.log("complete");
      });


    });
    //**End of Delete post event**//
  });
}());
