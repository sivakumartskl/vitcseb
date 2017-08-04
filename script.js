var DataTablePractice = (function () {

    var apiUrl = "http://vitcseb1115.atspace.eu/api.php";

    function init() {
        submitPost();
        getAllVitFriendsPosts();
        addPostComment();
        storePostComment();
        showAllCommOfPost();
        addLikeForComment();
        addDislikeForComment();
    }

    function makeAjaxCall(data, cbFunction, message, additional) {
        jQuery.blockUI({message: '<h5>' + message + '</h5>',
            css: {
                'padding-bottom': '10px',
                height: '40px',
                width: '500px'
            }
        });
        jQuery.ajax({
            url: apiUrl,
            method: 'GET',
            timeout: 20000,
            dataType: 'json',
            data: {
                details: data
            },
            crossDomain: true,
            success: function (data) {
                if (cbFunction != '' && additional == '') {
                    cbFunction(data);
                }
                else {
                    cbFunction(data, additional);
                }
            },
            complete: function () {
                jQuery.unblockUI();
            },
            error: function (xhr) {
                jQuery('#ajaxFailMsg').show().html("Unable to process your request, Please try again.");
                jQuery('#ajaxFailMsg').delay(4000).fadeOut();
            }
        });
    }

    function submitPost() {
        $('#ysubmit').click(function (e) {
            e.preventDefault();
            var url = $('#yurl').val();
            var userid = $('#currentLoggedInUserId').val();
            if (url == '' || url == null) {
                alert("Please enter the youtube url...");
            }
            else {
                var data = {
                    'method': 'storeUserPost',
                    'url': url,
                    'userid': userid,
                    'likes' : 0,
                    'dislikes' : 0,
                    'comments' : 0
                };

                var message = "Please be patient, We are storing your post...";

                makeAjaxCall(data, appendAllPreviousPosts, message);
            }
        });
    }

    function getAllVitFriendsPosts() {
        var data = {
            'method': 'getAllVitPosts'
        };

        var message = "Please be patient, We are gathering all previous posts";

        makeAjaxCall(data, appendAllPreviousPosts, message);
    }

    function appendAllPreviousPosts(data) {
        var postsdiv = "";

        for (var i = 0; i < (data['data']).length; i++) {
            postsdiv += '<div class="post-container">' +
                    '<input type="hidden" id=' + data["data"][i]["post_id"] + '>' +
                    '<input type="hidden" id="postIdTofetch" value=' + data["data"][i]["post_id"] + '>' +
                    '<div class="vit-shared-by">' +
                    '<h4 class="shared-head-style">Posted by :</h4>' + data["data"][i]["user_name"] +
                    '</div>' +
                    '<div class="vit-post">' +
                    '<iframe src="http://www.youtube.com/embed/' + data["data"][i]["post"] + '?autoplay=0&;modestbranding=1&;rel=0&;showinfo=0" allowfullscreen></iframe>' +
                    '</div>' +
                    '<div class="vit-post-actions">' +
                    '<div class="row">' +
                    '<div class="col-sm-3 action-align"><a href="" class="anc-dec-showed" id="incPostLike">Like</a>&nbsp<a href=""><span>(0)</span></a></div>' +
                    '<div class="col-sm-3 action-align"><a href="" class="anc-dec-showed" id="incPostDislike">Dislike</a>&nbsp<a href=""><span>(0)</span></a></div>' +
                    '<div class="col-sm-3 action-align"><a href="" class="anc-dec-showed" id="incPostComment">Comment</a>&nbsp<a href="" data-toggle="modal"><span id="comsubsuccres">(' + data["data"][i]["comments"] + ')</span></a></div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="putCommentBox hide-comment-box">' +
                    '<input type="text" placeholder="Type your comment here..." class="comboxDec">' +
                    '</div>' +
                    '<div class="comsuccmsgtoshow"></div>' +
                    '</div>' +
                    '<br><br>';
        }
        $('#sampleTest').empty();
        $('#sampleTest').append(postsdiv);
        $('.ytp-watermark').hide();
        $('.yt-uix-sessionlink').hide();
    }

    function addPostComment() {
        $('#sampleTest').on('click', '#incPostComment', function (e) {
            e.preventDefault();
            $(this).parents('.post-container').find('.putCommentBox').toggleClass('hide-comment-box');
        });
    }

    function storePostComment() {
        $('#sampleTest').on('keypress', '.comboxDec', function (e) {
            if (e.keyCode === 13) {
                var comment = $(this).parents('.post-container').find('.comboxDec').val();
                var userid = $('#currentLoggedInUserId').val();
                var postid = $(this).parents('.post-container').find('#postIdTofetch').val();
                var details = {
                    'method': 'addCommentToComTab',
                    'userid': userid,
                    'postid': postid,
                    'comment': comment
                };
                var message = "Please be patient, We are processing your request...";

                $(this).parents('.post-container').find('.comboxDec').val("");
                $(this).parents('.post-container').find('.putCommentBox').toggleClass('hide-comment-box');

                makeAjaxCall(details, showComSucMsg, message, postid.toString());
            }
        });
    }

    function showComSucMsg(data, additional) {
        var poid = parseInt(additional);
        if (data['data']) {
            $('#' + poid).parents('.post-container').find('.comsuccmsgtoshow').show().html("Your comment has been successfully submited.").css({
                'text-align': 'center',
                'background-color': 'green',
                'color': 'white',
                'padding': '5px'
            });
            $('.comsuccmsgtoshow').delay(2500).fadeOut();
            $('#' + poid).parents('.post-container').find('#comsubsuccres').empty();
            $('#' + poid).parents('.post-container').find('#comsubsuccres').append('(' + data['data'] + ')');
        }
    }

    function showAllCommOfPost() {
        $('#sampleTest').on('click', '#comsubsuccres', function (e) {
            e.preventDefault();

            var postid = $(this).parents('.post-container').find('#postIdTofetch').val();

            var data = {
                'method': 'showCommsRel',
                'postid': postid
            };

            var message = "Please be patient, We are gathering comments related to this post...";

            makeAjaxCall(data, showAllComms, message);
        });
    }

    function showAllComms(data) {
        if(data['data']==="no") {
            var msg = "There are no comments for this post yet...";
            var divs = "";
            divs+= "<div class='comm-dec'><h4 aligh='center'>"+msg+"</h4></div>";
            
            $('#appendAllComms').empty();

            $('#appendAllComms').append(divs);
            
            $('#commentsModalVit').modal({
                show: true,
                closeOnEscape: true
            });
        }
        else {
            var divs = "";

            for (var i = 0; i < (data['data']).length; i++) {
                divs += "<div class='comm-dec'><h4>" + data['data'][i]['user_name'] + "</h4>" + data['data'][i]['comment'] + "</div>";
            }

            $('#appendAllComms').empty();

            $('#appendAllComms').append(divs);

            $('#commentsModalVit').modal({
                show: true,
                closeOnEscape: true
            });
        }
    }

    function addLikeForComment() {
        $('#sampleTest').on('click', '#incPostLike', function (e) {
            e.preventDefault();
            var postid = $(this).parents('.post-container').find('#postIdTofetch').val();
            var userid = $('#currentLoggedInUserId').val();
            var data = {
                'method': 'addLikeForComment',
                'postid': postid,
                'userid': userid
            };

            var message = "Please be patient, We are processing your request...";

            makeAjaxCall(data, changeToLiked, message, postid.toString());
        });
    }

    function changeToLiked(data, additional) {
        var poid = parseInt(additional);
    }

    function addDislikeForComment() {
        $('#sampleTest').on('click', '#incPostDislike', function (e) {
            e.preventDefault();
            var postid = $(this).parents('.post-container').find('#postIdTofetch').val();
            var userid = $('#currentLoggedInUserId').val();
            var data = {
                'method': 'addDislikeForComment',
                'postid': postid,
                'userid': userid
            };

            var message = "Please be patient, We are processing your request...";

            makeAjaxCall(data, changeToDisliked, message, postid.toString());
        });
    }

    function changeToDisliked(data, additional) {
        var poid = parseInt(additional);
    }

    return {
        init: init
    };

})();

$(DataTablePractice.init);

