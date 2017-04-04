export default class Comment
{
    constructor(instanceDetail) {
        this.instance = instanceDetail;
        this.commentOffset = 1;
        this.paginateNumber = $('#commentPaginateNumber').val();
        this.numberOfComment = $('#numberOfComment').val();
    }

    update(cmtId, newContent) {
        var self = this;
        const $ = self.instance.jQuery;
        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\CommentController@update', {'comment' : cmtId}),
            method: 'POST',
            data: { '_method' : 'PUT', 'content' : newContent},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    $('#showCommentContent' + cmtId).text(newContent);
                }
            }
        });
    }

    destroy(cmtId) {
        var self = this;
        const $ = self.instance.jQuery;
        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\CommentController@destroy', {'comment' : cmtId}),
            method: 'POST',
            data: { '_method' : 'DELETE' },
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    self.numberOfComment = parseInt(self.numberOfComment) - 1;
                    $('#numberOfComment').val(self.numberOfComment);
                    $('#viewCommentBtn').html('<b>Comments: ' + self.numberOfComment + '</b> <i class="fa fa fa-commenting-o" style="font-size:16px;color:#21d7ef"></i>');
                    $('#comment' + cmtId).remove();
                }
            }
        });
    }

    store(content) {
        var self = this;
        const $ = self.instance.jQuery;
        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\CommentController@store'),
            method: 'POST',
            data: {'commentable_type' : self.instance.commentableType, 'commentable_id' : self.instance.id, 'content' : content},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    $('#commentContent').val('');
                    if(! $('#commentField').hasClass('hidden')) {
                        $('#commentField').prepend(response);
                    }
                    self.numberOfComment = parseInt(self.numberOfComment) + 1;
                    $('#numberOfComment').val(self.numberOfComment);
                    $('#viewCommentBtn').html('<b>Comments: ' + self.numberOfComment + '</b> <i class="fa fa fa-commenting-o" style="font-size:16px;color:#21d7ef"></i>');
                }
            }
        });
    }

    getCommentsCallback(self, response) {
        const $ = self.instance.jQuery;

        if (response.status === -1) {
            var errors = response.data;
            errors.forEach(function (error) {
                alert(error.message);
            });
        } else {
            $('#commentField').append(response);
            if (self.commentOffset == 1) {
                $('#' + self.instance.sideBarFieldId).scroll(function (event) {
                    var scrollHeight = event.currentTarget.scrollHeight;
                    var clientHeight = event.currentTarget.clientHeight;
                    var top = event.target.scrollTop;

                    if (scrollHeight - top <= clientHeight) {
                        self.commentOffset += 1;
                        self.getByOffset(self.commentOffset);
                    }
                });
            }
        }
    }

    getByOffset(offset) {
        var self = this;
        const $ = self.instance.jQuery;
        var maxOffset = Math.ceil(self.numberOfComment / self.paginateNumber);
        if (offset > maxOffset) {
            $('#' + self.instance.sideBarFieldId).unbind('scroll');
            return null;
        } else {
            self.commentOffset = offset;

            $.ajax({
                url: laroute.action('App\Http\Controllers\Home\CommentController@index'),
                method: 'GET',
                data: {'commentable_type' : self.instance.commentableType, 'commentable_id' : self.instance.id, 'page' : offset},
                success: function (response) {
                    if (response.status == -1) {
                        var errors = response.data;
                        errors.forEach(function (error) {
                            alert(error.message);
                        });
                    } else {
                        self.getCommentsCallback(self, response);
                    }
                }
            });
        }
    }
}
