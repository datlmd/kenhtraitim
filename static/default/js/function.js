/**
 * Listen music
 */
function addListenMusic(idd) {
    var params = $('#' + idd).html();
    var aurl = base_url + "musics/add_listen";
    $.post(aurl, {params: params});
}

/**
 * Listen music on Album
 */
function addListenAlbum(id, iddtoken) {
    var token = $('#' + iddtoken).html();
    var aurl = base_url + "musics/add_album_listen";
    $.post(aurl, {id: id, token: token}, function (data) {
        $('#' + iddtoken).html(data);
    });
}

/**
 * get Time on View Album
 */
function getTimeOnView(length) {
    length = parseInt(length);
    length_view = ((length * 70) / 100) * 1000;
    return length_view;
}

/**
 * add vote
 */
function AddVote(params) {
    var aurl = base_url + "votes/add";
    $.post(aurl, {vparams: params}, function (json) {
        var data = $.parseJSON(json);
        jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);
    });
}

/**
 * Add comment
 */
function AddComment(id_div_content_comment, id_div_content_params, id_div_show_comment) {
    var aurl = base_url + "comments/add";

    var comment = $('#' + id_div_content_comment).val();
    var params = $('#' + id_div_content_params).val();

    comment = $.trim(comment);

    if (comment == '') {
        $('#' + id_div_content_comment).val('');
        return;
    }

    $.post(aurl, {comment: comment, params: params}, function (json) {
        var data = $.parseJSON(json);
        jAlert(data.status, data.message, JsLang[data.status.toUpperCase()]);

        if (data.status == 'success') {
            $('#' + id_div_content_comment).val('');
            $('#' + id_div_show_comment).prepend(comment);
        } else {
            $('#' + id_div_content_comment).val(comment);
            $('#' + id_div_content_comment).focus();
        }
    });
}

/**
 * author: dungdv3@vng.com.vn
 * created date: 23/09/2013
 * This is function to call ajax to check spell of name of user.
 * It will return TRUE if this name is right spell in Vietnamese, FALSE if not.
 */
function CheckSpell(name) {
    var url = base_url + "users/users/ajax_check_spell";
    var result = true;
    $.ajax({
        url: url,
        type: "POST",
        async: false,
        data: {name: name},
        success: function (result_ajax) {
            if (result_ajax != true) {
                result = false;
            }
        }
    });
    return result;
}

// get image thumb
function getImageThumb(image_uri, thumb_maker) {
    return image_uri.substr(0, image_uri.indexOf('.')) + '_' + thumb_maker + image_uri.substr(image_uri.indexOf('.'), image_uri.length);
}
