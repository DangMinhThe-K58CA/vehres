import Comment from './../Comment';

export default class Article
{
    constructor(app) {
        this.app = app;
        this.window = app.window;
        this.jQuery = app.jQuery;
        this.commentableType = 'App\\Models\\Article';
        this.commentManager = {};
        this.sideBarFieldId = 'articleBound';
    }

    init() {
        var self = this;
        self.initActions();
    }

    initActions() {
        const $ = this.jQuery;
        var self = this;

        $('#commentField').on('click', '.editCommentBtn', function (event) {
            var btn = $(event.currentTarget);
            var cmtId = btn.attr('commentId');
            btn.hide();

            var showCmtContent = $('#showCommentContent' + cmtId);
            showCmtContent.addClass('hidden');

            $('#editCommentField' + cmtId).removeClass('hidden');

            var newCommentContent = $('#commentContent' + cmtId);
            newCommentContent.val(showCmtContent.text()).focus();
            newCommentContent.off('keydown');

            newCommentContent.keydown(function(e) {
                if (e.which === 13) {
                    if(e.shiftKey){
                        e.stopPropagation();
                    } else {
                        var curContent = showCmtContent.text();
                        var newContent = newCommentContent.val();
                        $('#editCommentField' + cmtId).addClass('hidden');
                        showCmtContent.removeClass('hidden');
                        btn.show();
                        newCommentContent.off('keydown');
                        if (newContent !== curContent) {
                            self.commentManager.update(cmtId, newContent);
                        }
                    }
                }
                if (e.which === 27) {
                    $('#editCommentField' + cmtId).addClass('hidden');
                    showCmtContent.removeClass('hidden');
                    btn.show();
                    newCommentContent.off('keydown');
                }
            });
        });

        $('#commentField').on('click', '.deleteCommentBtn', function (event) {
            var cnf = confirm('Delete this comment ?');
            if (cnf) {
                var btn = $(event.currentTarget);
                var cmtId = btn.attr('commentId');
                self.commentManager.destroy(cmtId);
            }
        });

        $('#showCommentField').ready(function () {

            self.id = $('#articleId').val();
            $('#commentBtn').click(function () {
                var content = $('#commentContent').val();
                self.commentManager = new Comment(self);
                self.commentManager.store(content);
            });

            $('#viewCommentBtn').click(function (event) {

                $('#' + self.sideBarFieldId).off('scroll');
                var btn = event.currentTarget;
                var btnStt = $(btn).attr('btnStatus');
                if (btnStt == '0') {
                    self.commentManager = new Comment(self);
                    $('#commentField').removeClass('hidden');
                    self.commentManager.getByOffset(1);
                    $(btn).attr('btnStatus', '1');
                } else {
                    $('#' + self.sideBarFieldId).unbind('scroll');
                    $(btn).attr('btnStatus', '0');
                    $('#commentField').addClass('hidden').html('');
                }
            });
        });
    }
}
