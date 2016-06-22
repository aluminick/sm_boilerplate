(function() {
  $(function () {


    //**Toggle comments event**//

    $('#post-list').on('click', '.btn-comment-post', function () {

      var $this = $(this);
      var parent = $this.parent();
      var postId = parent.parents('.post-container').data('id');
      var commentListContainer = parent.next('.comment-list-container');
      var commentList = commentListContainer.find('.comment-list');

      if (!parent.hasClass('initialized')) {
        $.ajax({
          url: '/api/comments/findfive/'+postId,
          type: 'GET',
          dataType: 'json'
        })
        .done(function(data, textStatus, xhr){
          console.log(xhr);
          commentList.prepend(data.html);
        })
        .fail(function(xhr, textStatus, err) {
          $this.append(xhr.responseText);
          console.log(xhr);
          console.log(textStatus);
          console.log(err);
        })
        .always(function() {
          // Complete
        });

      }

      commentListContainer.toggleClass('hide');
      parent.addClass('initialized');

    });

    //**End of Toggle comments event**//

    //**Add Comment event**//

    $('#post-list').on('keydown', '.comment-add > textarea', function (event) {

      var $this = $(this);
      var parent = $this.parent();
      var commentList = parent.next('.comment-list');
      var commentErrors = parent.find('.comment-error-container');

      var params = {
        post_id: parent.parents('.post-container').data('id'),
        comment: $this.val()
      };

      if (event.which == 13) {
        event.preventDefault();
        $.ajax({
          url: '/comment',
          type: 'POST',
          dataType: 'json',
          data: params
        })
        .done(function(data, textStatus, xhr) {
          $this.val('');
          commentList.prepend(data.html);
        })
        .fail(function(xhr, textStatus, err) {
          console.log(xhr);
          commentErrors.html(xhr.responseJSON.html);
        })
        .always(function() {
          // Complete
        });

        //$this.val('');
      }

    })

    //**End of Add Comment event**//


    //**Edit Comment event**//

    var toggleEditCommentUI = function ($el, action) {
      var $this = $el;
      var icon = $this.find('i');
      var parent = $this.parents('.comment-action');
      var commentContainer = parent.parent();
      var commentId = commentContainer.data('id');
      var editCommentContainer = parent.prev('.comment-edit-container');
      var commentEdit = editCommentContainer.find('.comment-edit');
      var commentEditTextarea = commentEdit.find('textarea');
      var commentEditContent = commentEditTextarea.val();
      var commentInfo = editCommentContainer.prev('.comment-info');
      var comment = commentInfo.find('.comment-content');
      var postId = commentContainer.parents('.post-container').data('id');


      var params = {
        post_id: postId,
        comment: commentEditContent
      };

      var commentError = '<div class="alert alert-danger fade in comment-error">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                        <strong>Error!</strong> Can\'t edit comment at the moment.\
                       </div>';

      $this.toggleClass('btn-edit-comment');
      $this.toggleClass('btn-edit-comment-done');
      icon.toggleClass('fa-pencil');
      icon.toggleClass('fa-check');
      editCommentContainer.toggleClass('hide');
      comment.toggleClass('hide');

      if (action == 'done') {
        /**
          TODO: Ajax Optimistic UI
        **/
        let prevComment = comment.text().trim();
        $.ajax({
          url: '/comment/'+commentId,
          type: 'PUT',
          dataType: 'json',
          data: params
        })
        .done(function(data, textStatus, xhr) {
          console.log(xhr);
        })
        .fail(function(xhr, textStatus, err) {
          console.log(xhr);
          comment.text(prevComment);
          commentEditTextarea.val(prevComment);
          if (typeof(xhr.responseJSON) !== 'undefined') {
            $this.parent().prepend(xhr.responseJSON.html);
          } else {
            $this.parent().prepend(commentError);
          }
        })
        .always(function() {
          console.log("complete");
        });

        comment.text(commentEditContent);
      } else {
        if ($this.parent().find('.comment-error, .common-errors').length > 0) {
          $this.parent().find('.comment-error, .common-errors').remove();
        }
      }
    };

    $('#post-list').on('click', '.btn-edit-comment', function () {
      toggleEditCommentUI($(this), 'edit');
    });

    $('#post-list').on('click', '.btn-edit-comment-done', function () {
      toggleEditCommentUI($(this), 'done');
    });

    //**End of Edit Comment event**//


    //**Delete Comment event**//

    $('#post-list').on('click', '.btn-delete-comment', function () {
      var $this = $(this);
      var parent = $this.parents('.comment-container');
      var confirm = parent.prev('.delete-comment-confirmation');

      parent.toggleClass('hide');
      confirm.toggleClass('hide');
      if ($this.parent().find('.comment-error, .common-errors').length > 0) {
        $this.parent().find('.comment-error, .common-errors').remove();
      }
    });

    $('#post-list').on('click', '.btn-delete-comment-undo', function (event) {
      event.preventDefault();
      var $this = $(this);
      var parent = $this.parents('.delete-comment-confirmation');
      var comment = parent.next('.comment-container');

      parent.toggleClass('hide');
      comment.toggleClass('hide');
    });

    $('#post-list').on('click', '.btn-delete-comment-confirm', function (event) {
      event.preventDefault();
      var $this = $(this);
      var parent = $this.parents('.delete-comment-confirmation');
      var comment = parent.next('.comment-container');
      var commentId = comment.data('id');
      var commentParent = comment.parents('.comment');
      var commentAction = comment.find('.comment-action div:first-child');

      var commentError = '<div class="alert alert-danger fade in comment-error">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                        <strong>Error!</strong> Can\'t delete comment at the moment.\
                       </div>';

      /**
        TODO: Ajax Optimistic UI
      **/
      var elCopy = [parent.detach(), comment.detach()];
      $.ajax({
        url: '/comment/'+commentId,
        type: 'DELETE',
        dataType: 'json',
      })
      .done(function(data, textStatus, xhr) {
        console.log(xhr);
        commentParent.remove();
      })
      .fail(function(xhr, textStatus, err) {
        console.log(xhr);
        commentParent.prepend(elCopy);
        parent.toggleClass('hide');
        comment.toggleClass('hide');
        commentAction.prepend(commentError);
      })
      .always(function() {
        console.log("complete");
      });

    });

    //**End of Delete Comment event**//


    //**View more Comment event**//

    $('#post-list').on('click', '.btn-view-more-comments', function () {
      var $this = $(this);
      var parent = $this.parents('.view-more-comments-container');
      var offset = parent.data('offset');
      var postId = $this.parents('.post-container').data('id');
      $.ajax({
        url: '/api/comments/nextfive/'+postId,
        type: 'GET',
        dataType: 'json',
        data: {offset: offset}
      })
      .done(function(data, textStatus, xhr) {
        $(data.html).insertBefore(parent);
        console.log(data);
        if (data.offset == 0) {
          parent.remove();
        } else {
          parent.data('offset', data.offset);
        }
      })
      .fail(function(xhr, textStatus, err) {
        console.log(xhr);
        parent.append(xhr.responseText);
      })
      .always(function() {
        console.log("complete");
      });

    });

    //**End of View more Comment event**//

  })
}());
