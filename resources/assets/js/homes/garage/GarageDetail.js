import Comment from './../Comment';

export default class GarageDetail
{
    constructor(app, id) {
        this.app = app;
        this.window = app.window;
        this.jQuery = app.jQuery;
        this.id = id;
        this.commentableType = 'App\\Models\\Garage';
        this.commentManager = {};
        this.sideBarFieldId = 'mySidebar';
    }

    init() {
        var self = this;
        self.initActions();
    }

    initActions() {
        const $ = this.jQuery;
        var self = this;

        // var sideBar = $('#' + self.sideBarFieldId);
        // sideBar.unbind('scroll');

        $('#showRatingField').ready(function () {
            $('#showRatingStatisticBtn').click(function () {
                if ($('#ratingStatisticField').hasClass('hidden')) {
                    $('#ratingStatisticField').removeClass('hidden');
                } else {
                    $('#ratingStatisticField').addClass('hidden');
                }
            });
        });

        $('#viewGarageDetailFieldResponsed').on('click', '.ratingStarBtn', function (event) {
            var star = $(event.currentTarget);
            var score = star.data('score');
            var cnf = confirm('Rate ' + score + ' stars for this garage ?');
            if (cnf) {
                $.ajax({
                    url : laroute.action('App\Http\Controllers\Home\GarageController@rate'),
                    method : 'POST',
                    data : {'garage_id' : self.id, 'score' : score},
                    success: function  (response) {
                        if (response.status == -1) {
                            var errors = response.data;
                            errors.forEach(function (error) {
                                alert(error.message);
                            });
                        } else {
                            var div = star.closest('div');
                            var stars = div.find('i.fa');
                            for (var i = 0; i < stars.length; i ++) {
                                var curStar = $(stars[i]);
                                var curStarBtn = $(curStar.closest('a'));
                                if (curStarBtn.data('score') <= score) {
                                    curStar.removeClass();
                                    curStar.addClass('fa fa-star');
                                } else {
                                    curStar.removeClass();
                                    curStar.addClass('fa fa-star-o');
                                }
                            }
                        }
                    }
                });
            }
        });

        $('#viewGarageDetailFieldResponsed').on('click', '.editCommentBtn', function (event) {
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

        $('#viewGarageDetailFieldResponsed').on('click', '.deleteCommentBtn', function (event) {
            var cnf = confirm('Delete this comment ?');
            if (cnf) {
                var btn = $(event.currentTarget);
                var cmtId = btn.attr('commentId');
                self.commentManager.destroy(cmtId);
            }
        });

        $('#showCommentField').ready(function () {

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

        $('#garageDescriptionField').ready(function () {
            $('#showMoreGarageDetailBtn').click(function () {
                $('#garageDescriptionInShort').addClass('hidden');
                $('#garageFullDescription').removeClass('hidden');
            });

            $('#hideGarageDetailBtn').click(function () {
                $('#garageDescriptionInShort').removeClass('hidden');
                $('#garageFullDescription').addClass('hidden');
            });
        });
    }
}
