(function() {
  $(function() {
    /** Like Post event **/
    var likeUnlikePost = function (el, action) {
      var $this = el;
      var postContainer = $this.parents('.post-container');
      var postId = postContainer.data('id');
      var type = (action == 'like')? 'POST': 'PUT';
      $this.toggleClass('btn-default');
      $this.toggleClass('btn-primary');
      $this.toggleClass('btn-like-post').toggleClass('btn-unlike-post');

      /**
        TODO: Ajax
      **/
      $.ajax({
        url: '/likes/post/'+postId,
        type: type,
        dataType: 'json'
      })
      .done(function(data, textStatus, xhr) {
        //Done
      })
      .fail(function(xhr, textStatus, err) {
        $this.append(xhr.responseText);
      })
      .always(function() {
        //Complete
      });

    };

    $('#post-list').on('click', '.btn-like-post', function() {
      var $this = $(this);
      likeUnlikePost($this, 'like');
    });

    $('#post-list').on('click', '.btn-unlike-post', function() {
      var $this = $(this);
      likeUnlikePost($this, 'unlike');
    });
    /** End of Like Post event **/


    /** Like Comment Event**/

    var likeUnlikeComment = function ($el, action) {
      var $this = $el;
      var commentContainer = $this.parents('.comment-container');
      var commentId = commentContainer.data('id');
      var sibling = $this.siblings('.like, .unlike');
      var type = (action == 'like' || action == 'unlike')? 'POST': 'PUT';

      $this.toggleClass('btn-default').toggleClass('btn-primary');
      if (sibling.hasClass('btn-primary')) {
        sibling.toggleClass('btn-default').toggleClass('btn-primary');
      }

      console.log(action);
      console.log(type);

      if(action == 'like' || action == 'undoLike') {
        $this.toggleClass('btn-like-comment').toggleClass('btn-undo-like-comment');
      }

      if(action == 'unlike' || action == 'undoUnlike') {
        $this.toggleClass('btn-unlike-comment').toggleClass('btn-undo-unlike-comment');
      }

      /**
        TODO: Ajax
      **/
      $.ajax({
        url: '/likes/comment/'+commentId,
        type: type,
        dataType: 'json',
        data: {
          action: action
        }
      })
      .done(function(data, textStatus, xhr) {
        console.log(xhr);
      })
      .fail(function(xhr, textStatus, err) {
        console.log(xhr);
        $this.append(xhr.responseText);
      })
      .always(function() {
        console.log("complete");
      });

    };

    $('#post-list').on('click', '.btn-like-comment', function() {
      var $this = $(this);
      likeUnlikeComment($this, 'like');
    });

    $('#post-list').on('click', '.btn-unlike-comment', function() {
      var $this = $(this);
      likeUnlikeComment($this, 'unlike');
    });

    $('#post-list').on('click', '.btn-undo-like-comment', function() {
      var $this = $(this);
      likeUnlikeComment($this, 'undoLike');
    });

    $('#post-list').on('click', '.btn-undo-unlike-comment', function() {
      var $this = $(this);
      likeUnlikeComment($this, 'undoUnlike');
    });
    /** End of Like Comment Event**/
  });
}());
