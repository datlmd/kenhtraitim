function LoadData(page, page_size, action_link) {
    $.ajax({
        url: action_link,
        data: {
            "page": page,
            "page_size": page_size
        },
        success: function (data) {
            $("#basic_load_list").html(data);
            window.location.hash = page
        }
    });
}

function LoadFirstData(page_size, action_link){
    $(document).ready(function () {
        if (window.location.hash) {
            var hash = window.location.hash.replace('#','').trim();
            var str_array = new Array();
            str_array = hash.split(',');
            if(str_array.length == 1)
            {
                var page = str_array[0];
                LoadData(page, page_size, action_link); //Load data lần đầu theo url
            }
            else
            {
                LoadData(1, page_size, action_link);
            }
        }
        else {
            LoadData(1, page_size, action_link);
        }
    });
}