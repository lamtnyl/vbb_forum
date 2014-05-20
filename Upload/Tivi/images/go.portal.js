// portal js content
// merge
// script process portal content

// CONFIG MYGO8
var MyGo8Obj = {
    day: 0, //0
    time: 22, // 22
    minute: 0,
    urlMyGo: 'http://my.go.vn?id=70569045',
    urlFanpage: 'http://clubs.go.vn/myGo8/',
    urlFanpageFeed: 'http://clubs.go.vn/Forum/NewClubComment.aspx?gtype=0&gid=6224'
};

var GoPortal = {
    Env: {
        urlMyGo: "http://my.go.vn/",
        urlRequest: "/portalmodule.request",
        timeout: 10000
    }
}

if (IsTestGoPortal) {
    isAllowDisplayMyGoTam = true;
    var now = new Date();
    MyGo8Obj.day = now.getDay();
    MyGo8Obj.time = now.getHours();
}
var txtSearchPortal = 'Tìm kiếm';

var IsShowBannerPortal = true;
// Cookie Functions
function createCookie(name, value, min) {
    if (min) {
        var date = new Date();
        date.setTime(date.getTime() + (min * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
function eraseCookie(name) {
    createCookie(name, "", -1);
}

var GoPortalShowBannerCookieName = "goPortal_banner";

if (readCookie(GoPortalShowBannerCookieName)) {
    IsShowBannerPortal = readCookie(GoPortalShowBannerCookieName) == 0 ? false : true; // Load cookied preference

    //eraseCookie(GoPortalShowBannerCookieName);
}
if (HomeEnv.accountId > 0) {
    $("#pnlIsAccNotLogin").remove();
    //  $("#pnlIsAccLogin").show();
}
else {
    if (IsShowBannerPortal)
        $("#pnlIsAccNotLogin").show();
}


function reSizeTextBox(elm) {

    $(elm).autoResize({
        // On resize:
        onResize: function () {
            $(this).css({ opacity: 0.8 });
        },
        // After resize:
        animateCallback: function () {
            $(this).css({ opacity: 1 });
        },
        // Quite slow animation:
        animateDuration: 0,
        limit: 100
    });
}
function IsShowMyGoTamByTime(d, t, m) {
    var dateTime = new Date(HomeEnv.serverTime);
    var day = dateTime.getDay();
    var time = dateTime.getHours();
    var min = dateTime.getMinutes();

    if (
		(day == d && time > t)
		|| (day == d && time == t && min >= m)
		|| (day == (d + 1) && time < t)
		|| (day == (d + 1) && time == t)
		)
        isAllowDisplayMyGoTam = true; // && min < m
}
// 22h Sunday to 22h Monday
//IsShowMyGoTamByTime(MyGo8Obj.day, MyGo8Obj.time, MyGo8Obj.minute); //0,22

// feed
function getLiveFeedByFilterPortal() {
    $('#activity_img_awaiting').show();
    GetLiveFeed_Portal(PAGE_INDEX + 1, HomeEnv.accountId, ACT_FILTER, activity_app, ACT_ACTION);
    scrollMoreFeed();
}

// xu ly search
var ObjTxtSearch = {
    "portalall": "",
    "photo": "ảnh",
    "music": "nhạc",
    "edu": "bài giảng",
    "clip": "video",
    "blog": "bài viết",
    "play": "",
    "bid": "",
    "muaban": "",
    "link": "",
    "tinmoi":"tin tức"
};
// location link
function getQuerystring() {

    var search = unescape(location.href);
    if (search == "") {
        return "";
    }
    //search = search.substr(1);
    var params = [];
    if (search.indexOf("#") == -1)
        return "";
    params = search.split("#");

    return params[1];
}
function Portal_bindHtml(id) {
    switch (id) {
        case "music":
            //if (IsTestGoPortal)
           // Portal_getMusicPortalContent();

            break;
        case "photo":
            Portal_getPhotoPortalContent();

            break;
        case "play":
            Portal_getPlayPortalContent();
            // PortalPlay_bind.bindHtml(data);
            break;
        case "clip":

            Portal_getClipPortalContent();
            //  PortalClip_bind.bindRightHtml(data);
            break;
        case "edu":
            //Portal_getEduPortalContent();
            break;
        case "blog":
            Portal_getBlogPortalContent();
            break;
        default:
            break;
    }
}
//
var IsGetMediaPortal = {
    "photo": false, "blog": false,
    "music": false, "play": false,
    "clip": false, "edu": false
}
function includeArr(arr, obj) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == obj) return true;
    }
}

function IsIdHasNoHtml(id) {
    if (id == 'edu' || id == 'link' || id == 'bid' || id == 'tinmoi' || id == 'muaban' || id == 'music')
        return true;
    return false;
}
// get mygo8 ajax 
function genGoTV8() {

    if (isAllowDisplayMyGoTam) {
        $.ajax({
            beforeSend: function (x) {
                if (x && x.overrideMimeType) {
                    x.overrideMimeType("application/j-son;charset=UTF-8");
                }
            },

            type: 'GET',
            url: PORTAL_URL + "portalmodule.request?r=" + Math.random(),
            data: { type: 'MyGo8' },
            dataType: "text",
            cache: false,
            success: function (data) {
                if (data) {
                    Portal_bindHtmlMyGo8(data);
                }
            },
            error: function (data, error, errorThrown) {

            }
        });
    }

}
function Portal_PlayMyGo8(info, autoPlay) {
    strHtml = '<object width="520" height="332" name="ClipPlayer" id="ClipPlayer" style="visibility: visible; background-color: rgb(0, 0, 0);" data="http://clips.go.vn/Player/Player_S1.1.swf" type="application/x-shockwave-flash">';
    strHtml += '<param name="allowScriptAccess" value="always">';
    strHtml += '<param name="menu" value="false">';
    strHtml += '<param name="allowFullscreen" value="true">';
    strHtml += '<param name="wmode" value="transparent">';
    strHtml += '<param name="movie" value="http://clips.go.vn/Player/Player_S1.1.swf">';
    strHtml += '<param name="quality" value="high">';
    // not sure
    // var linkEncode = '<a href=' + link + '">' + titleMyGoTam + '</a>';
    //  linkEncode = encodeURIComponent(linkEncode); //encodeURI

    var embed = '<embed width="520" height="332" align="middle" name="player" '
				+ 'src="http://clips.go.vn/Player/Player_S1.1.swf" allowscriptaccess="always"'
+ '				wmode="transparent" quality="high" stretching="exactfit" bgcolor="#000000"'
+ ' allowfullscreen="true"'
+ ' flashvars="mode_autoplay=' + autoPlay
+ '&amp;clip_info=&amp;embed=&amp;mode_wall=false&amp;server_path='
+ (info.ServerPath) + '&amp;'
+ 'file_path=' + (info.FilePath) + '&amp;link="'
    //+ linkEncode
+ ' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">';

    strHtml += '<param name="flashvars" value="mode_autoplay=' + autoPlay
                + '&amp;clip_info=&amp;embed=' +
				encodeURIComponent(embed) + '&amp;mode_wall=false&amp;server_path='
				+ info.ServerPath + '&amp;file_path='
				+ info.FilePath + '&amp;'
				+ 'title=myGo8&amp;link=';

    //  strHtml += linkEncode;

    strHtml += '">'; //'+link+'
    strHtml += embed + '</object>';
    return strHtml;
}
function Portal_bindHtmlMyGo8(data) {
    var d = eval('(' + data + ')');
    var msg = eval('(' + d.Message + ')');
    var info = eval('(' + msg.Description + ')');
    var likeList = eval('[' + d.LikeList + ']');
    var isLike = false, accId = '';
    // if (navigator.userAgent.indexOf('MSIE') != -1)
    $.each(likeList, function (i, r) {
        accId = r.AccountId;
        if (accId)
            if (accId == ACTIVITY_CURRENT_ACCOUNT) {
                isLike = true;
                return;
            }
    });
    var link = MyGo8Obj.urlMyGo + '&lid=' + d.Id + '&aid=4&ac=link&action=detail&at=3&uid='
    + ACTIVITY_CURRENT_ACCOUNT;

    //link = MyGo8Obj.urlFanpageFeed + '&ti='++'&ci='++'&cin=T%E1%BB%95ng%20h%E1%BB%A3p%20Clip%20myGo8';

    var titleMyGoTam = 'Chương trình <span>myGo8</span> ' + info.Number;
    var autoPlay = false;
    var dateTime = new Date(HomeEnv.serverTime);

    var time = dateTime.getHours();
    if (time == 22) autoPlay = true;
    strHtml = '';
    strHtml += '<div class="go8_tv">';
    strHtml += '<div class="title_go8_tv">';
    strHtml += titleMyGoTam;
    strHtml += '</div>';
    strHtml += '<div class="info_go8_tv">';
    strHtml += info.Title;
    strHtml += '</div>';
    strHtml += '<div id="mygo8Play" class="play_go8_tv">';
    if (!autoPlay)
        strHtml += '<div id="mygo8thumb" style="position: absolute; width: 520px; top: 100px; height: 303px; background: url('
    + HomeEnv.urlMedia + 'portal/images/backgrounds/mygo8-thumb.jpg) no-repeat scroll 0pt 0pt transparent;"></div>';
    // mygo8 player
    strHtml += '<div id="mygo8Player">';
    strHtml += Portal_PlayMyGo8(info, autoPlay);
    strHtml += '</div>';

    strHtml += '</div>';
    strHtml += '<div class="option_go8_tv">';
    strHtml += '<a class="button fr mr5" href="http://clubs.go.vn/Default.aspx?gtype=0&gid=6224&lid=' + d.Id + '"><span class="comment_button">Bình luận</span></a>';
    if (!isLike)
        strHtml += '<a id="spnLikeMyGoTam' + d.Id + '" class="button mr5 fr" href="http://clubs.go.vn/Default.aspx?gtype=0&gid=6224&lid=' + d.Id + '">'
				+ '<span class="like_button" >Thích</span></a>';

    strHtml += '<p class="num_go8_tv"> <span id="likeCount' + d.Id + '">' + d.LikeCount + '</span> Lượt thích</p>'
+ '				<p class="num_go8_tv"> <span>' + d.CommentCount + '</span> Bình luận</p>';
    strHtml += '<div style="clear: both;"></div>';
    strHtml += '</div></div>';

    $("#pnlGoTV8").html(strHtml);
    $("#pnlGoTV8").show();
    $("#mygo8Play").click(function () {
        if (!autoPlay) {
            autoPlay = true;
            $("#mygo8Player").html(Portal_PlayMyGo8(info, autoPlay));
            $('#mygo8thumb').fadeOut();
        }
    });
}
function feed_Like_Array_Mygo8(logId) {
    var logType = 478;
    var whereId = 0;
    if (checkActionTime('like')) {
        showJAlert("Thông báo", 'Bạn cần chờ 5s để thực hiện');
        return;
    }

    var urlRequest = '';
    if (isPortalActivity == true) urlRequest = PORTAL_URL + 'like';

    $.ajax({
        type: 'POST',
        url: urlRequest + ".request",
        data: { "action": "like", "actionid": whereId, "logtype": logType, "logid": logId },
        //dataType: "html",//json
        success: function (data) {
            data = eval(data);
            if (isPortalActivity == true && data.IsSuccess == false) {
                var currUrl = location.href;
                showJAlert("Thông báo", 'Bạn cần <a href="http://go.vn/accounts/account.register.aspx" style="color:#007EBF;">đăng ký</a>'
+ '				hoặc <a href="http://go.vn/accounts/account.login.aspx?sid=660006&ur='
+ currUrl + '&m=1" style="color:#007EBF;">đăng nhập</a> để thực hiện chức năng này.');
                return;
            }

            // var likecount = $('#likeCount' + logId).html();
            //likecount = parseInt(likecount) + 1;
            // $('#likeCount' + logId).html(likecount);

            if (data == "") return;

            if (data.IsSuccess == false) {
                if (data.Result == 'SESSION_EXPIRE') {
                    window.location.reload();
                    return;
                }
                showJAlert("Thông báo", data.Message);
                return;
            }

            if (data.IsLiked) {
                showJAlert("Thông báo", "Bạn đã thích nội dung này");
                $('#spnLikeMyGoTam' + logId).hide();
                like_time = new Date();

                var likecount = $('#likeCount' + logId).html();
                likecount = parseInt(likecount) + 1;
                $('#likeCount' + logId).html(likecount);
                return;
            }

        }
    });

}
function Portal_getMyGoTam_right() {

    $.ajax({
        beforeSend: function (x) {
            if (x && x.overrideMimeType) {
                x.overrideMimeType("application/j-son;charset=UTF-8");
            }
        },

        type: 'GET',
        url: PORTAL_URL + "portalmodule.request",
        data: { type: 'GetLast3ClipMyGo8' },
        dataType: "json",
        cache: false,
        success: function (data) {
            if (data) {

                Portal_getMyGoTam_right_bindHtml(data);
            }
        },
        error: function (data, error, errorThrown) {

        }
    });
}
function Portal_getMyGoTam_right_bindHtml(d) {

    //        "LikeCount": 10,
    //        "CommentCount": 20,

    var min = Math.min(3, d.length);
    //var r = {};
    var strHtml = '', title = '';
    $.each(d, function (i, r) {
        //for (var i = 0; i < min; i++) {
        //r = d[i];
        title = r.Tittle;

        strHtml += '<div class="block_go8_right">';
        strHtml += '<a href="' + r.Url + '">'
                            + '<img width="124" height="94" class="img_colright_myGo8" alt=""'
                            + ' src="' + r.Thumbs + '">' //.124.94.cache
                            + '</a>';
        strHtml += '<a href="' + r.Url + '">'
                            + title + '</a>'
                            + ' <div class="info_event" style="margin-left:130px;">'
                            + '                     <img class="icon_event" src="http://static.gox.vn/media/homepage/images/icon/cmmt.gif" alt="">'
                            + r.CommentCount
                            + '                   &nbsp;&nbsp;'
                            + '                 <img class="icon_event" src="http://static.gox.vn/media/homepage/images/icon/likeonly.gif" alt="">'
                            + r.LikeCount
                            + '           </div>'
        //+ '         <p>' + r.LikeCount + ' Lượt thích</p>'
                            + '          <div style="clear: both;"></div>'
                            + '        </div>'
        //+ MyGo8Obj.urlFanpage
                            + '';

    });
    //}
    strHtml += ' <div class="more_go8_right"><a href="'
    + MyGo8Obj.urlFanpage + '">Xem thêm »</a></div>';
    $("#pnlPortal_MyGo8_right").html(strHtml);
    $("#pnlPortal_MyGo8_rightBox").show();

}

// xu ly khi query va click loc portal theo phan he
function processGoPortalFilter(id) {
    if (isGetFeed == true && activity_app == id)
        return;

    //$(".hlkPortalGroups").show();
    // $(".hlkPortalGroups_active").hide();

    $("#hlkGoPortal_" + id).hide();
    $("#boxGoPortal_" + activity_app).hide();

    $("#hlkGoPortal_" + activity_app).show();
    $("#boxGoPortal_" + id).show();

    if (id == 'portalall') {
        $("#hlkGoPortal_" + id).hide();
        //  $("#boxGoPortal_" + id).show();
    }
    //$(this).addClass("active");

    PAGE_INDEX = -1;
    $("#LiveFeed1").empty('');
    $("#activity_morefeed").hide();

    activity_app = id;

    isGetFeed = true;
    // if (navigator.userAgent.indexOf('MSIE') != -1) {

    //  }
    /// get media by domain id
    if (id == 'portalall') {
        IsGoPortalAll = true;
        $("#SN_goportal_topbanner").show();
        if (HomeEnv.accountId > 0 && IsShowBannerPortal == true) {

            $("#pnlIsAccLogin").show();
        }
        // get myGo8
        if (isAllowDisplayMyGoTam && IsGoPortalAll) {
            $("#top_banner,#hlk_closeBanner").hide();
            genGoTV8();
        }
        $("#goPortal_colRight,#goPortal_colLeft,#goPortal_flashtop,#goPortal_top_banner,#top_banner_2").hide();

        if (IsShowBannerPortal == true && isAllowDisplayMyGoTam == false)
            $("#top_banner,#hlk_closeBanner").show();
        $("#goPortal_colRight_default,#goPortal_colLeft_default").show();
//        initPortalLeft();
//        initPortalRight();
        
    }
    else {
        IsGoPortalAll = false;
        $("#hlkGoPortal_portalall").attr("style", "display:block;");

        $("#pnlIsAccLogin").hide();

        $("#SN_goportal_topbanner").hide();
        if (IsIdHasNoHtml(id)) {

            $("#goPortal_colRight,#goPortal_colLeft,#goPortal_flashtop,#goPortal_top_banner,#pnlPortal_MyGo8_rightBox,#pnlGoTV8").hide();
            $("#goPortal_colRight_default,#goPortal_colLeft_default").show();

            $("#top_banner").hide();
            if (IsShowBannerPortal)
                $("#top_banner_2,#hlk_closeBanner").show();
//            initPortalLeft();
//            initPortalRight();
        
        }
        else {

            $("#top_banner,#top_banner_2,#hlk_closeBanner,#pnlPortal_MyGo8_rightBox,#pnlGoTV8").hide();

            $("#goPortal_colRight,#goPortal_colLeft,#goPortal_flashtop,#goPortal_top_banner").empty();

            $('#boxGoPortal_' + id).attr("class", "GoPortal_" + id);

            if (IsGetMediaPortal[id]) {
                //  goi ham khong get media
                Portal_bindHtml(id);
            }
            else { // get media tung phan he
                MyGoLib.appendCssToHead(HomeEnv.urlMedia + "portal/css/" + id + ".css?v=" + HomeEnv.version);
                MyGoLib.addScript(HomeEnv.urlMedia + "portal/js/go.portal." + id + ".js?v=" + HomeEnv.version);
                IsGetMediaPortal[id] = true;
            }
            $("#goPortal_colRight,#goPortal_flashtop,#goPortal_top_banner").show();
            if (id == 'blog' || id == 'photo')
                $("#goPortal_colLeft_default").show();
        }
    }
    /// end get media by domain id
    getLiveFeedByFilterPortal();
    if (id == "tinmoi") {
        txtSearchPortal = "Tìm kiếm " + ObjTxtSearch[id];
        $("input[name=keyword]").val(txtSearchPortal);

        $("input[name=page]").val("news");
        //mygo_obj.searchOption = id;
        mygo_searchOption = id;
        //http: //news.go.vn/search.htm?s=a
    }
    else
        if (id != 'play' && id != 'link' && id != 'bid' && id != 'muaban') {
        txtSearchPortal = "Tìm kiếm " + ObjTxtSearch[id];
        $("input[name=keyword]").val(txtSearchPortal);

        $("input[name=page]").val(id);
        //mygo_obj.searchOption = id;
        mygo_searchOption = id;
    }
   
    else {
        txtSearchPortal = "Tìm kiếm";
        $("input[name=keyword]").val(txtSearchPortal);
        //mygo_obj.searchOption = 'all';
        mygo_searchOption = 'all';
    }
    //focusAndBlur("input[name=keyword]");
    Portal_GA(id);
} // end function processGoPortalFilter by event click

// Google Analytic

var ObjGAAccount = {
    "portalall": "UA-15924106-1",
    "photo": "UA-15924106-4",
    "music": "UA-15924106-32",
    "edu": "UA-15924106-1",
    "clip": "UA-15924106-20",
    "blog": "UA-15924106-3",
    "play": "UA-15924106-28",
    "bid": "UA-15924106-1",
    "muaban": "UA-15924106-1",
    "link": "UA-15924106-1",
    "tinmoi": "UA-15924106-1"
};
function Portal_GA(id) {
    //  $(document).ready(function () {
    if (id == 'clip') {
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www')
            + '.google-analytics.com/urchin.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        try { _uacct = "UA-15924106-20"; urchinTracker(); } catch (err) { }
    }
    else {
        var _gaq = _gaq || [];
        var GAAccountId = ObjGAAccount[id];
        _gaq.push(['_setAccount', GAAccountId]);
        if (id == 'play')
            _gaq.push(['_setDomainName', id + '.go.vn']);
        else
            _gaq.push(['_setDomainName', 'www.go.vn']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_setAllowHash', false]);

        //  _gaq.push(['_trackPageview']);
        _gaq.push(['_trackPageview', location.href]);
        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    }
    //  });
}
$(document).ready(function () {
    // page load
    goPortalFilterId = getQuerystring();
    if (goPortalFilterId != "")
        processGoPortalFilter(goPortalFilterId);
    else {
        IsGoPortalAll = true;
        // get myGo8
        if (isAllowDisplayMyGoTam && IsGoPortalAll) {
            $("#top_banner,#hlk_closeBanner").hide();
            genGoTV8();
        }
        activity_app = 'portalall';
        if (HomeEnv.accountId > 0 && IsShowBannerPortal == true) {

            $("#pnlIsAccLogin").show();
        }
        $("#hlkGoPortal_" + activity_app).hide();
        $("#boxGoPortal_" + activity_app).show();
        try {
            $.ajaxSetup({ cache: true });

            feedResponse(activity_dataresponse, HomeEnv.readerId, '');
            scrollMoreFeed();
        } catch (ex) { }
        $("#goPortal_colRight_default").show();
        Portal_GA('portalall');
    }
});
//var GoMetaTitle = "Go.vn - Mạng Việt Nam | Ngôi nhà số của bạn";
$(".hlkPortalGroups").click(function () {
    var arr = (this.id).split('GoPortal_');
    goPortalFilterId = arr[1];
    processGoPortalFilter(goPortalFilterId);

});
//          $("#box_img_"+ id).click(function() {
//              $("#box_content_"+ id).slideToggle();
//          });          
$("#hlk_closeBanner").click(function () {
    $('#top_banner,#top_banner_2').fadeOut();
    IsShowBannerPortal = false;
    $(this).hide();
    createCookie(GoPortalShowBannerCookieName, 0, 20);
});
$("#hlk_closeBannerLogin").click(function () {
    $('#pnlIsAccLogin').remove();
    IsShowBannerPortal = false;
    createCookie(GoPortalShowBannerCookieName, 0, 20);

});
    // focus search form
function focusAndBlur(selector) {
    $(selector).focus(function () {
        var val = $(this).val();
        switch (val) {
            case txtSearchPortal:
                val = '';
                break;
            case '':
                val = txtSearchPortal;
                break;
        }
        $(this).val(val);
    }).blur(function () {
        if ($(this).val() == '')
            $(this).val(txtSearchPortal);
    });
}
focusAndBlur("input[name=keyword]");

var img_go_icon_src = "";
$("img.img_go_icon").hover(function () {
    img_go_icon_src = $(this).attr("src");
    // img_go_icon_src = img_go_icon_src.split(".gif")[0];
    $(this).attr("src", img_go_icon_src.split(".gif")[0] + "_hover.gif");
},
    function () {
        $(this).attr("src", img_go_icon_src);
    });

function scrollMoreFeed() {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
            if ($("#activity_morefeed").is(":visible") == true) {
                if (PAGE_INDEX < 1) {
                    getLiveFeedByFilterPortal();
                }
            }
        }
    });
}


// merge portal js org
var formatDateGo = function (d) {
    if (d < 10)
        d = "0" + d;
    return d;
}

function focusAndBlur(selector, defaultVal) {
    $(selector).focus(function () {
        var val = $(this).val();
        switch (val) {
            case defaultVal:
                val = '';
                break;
            case '':
                val = defaultVal;
                break;
        }
        $(this).val(val);
    }).blur(function () {
        if ($(this).val() == '')
            $(this).val(defaultVal);
    })
}

function getTimeNowToString() {
    var newDate = new Date(HomeEnv.serverTime);
    var day = newDate.getDay();
    var result = formatDateGo(newDate.getHours()) + ':' + formatDateGo(newDate.getMinutes());
    //result += ' GMT ';

    result += ' - ';
    if (day == 0)
        result += 'Chủ nhật ';
    else
        result += 'Thứ ' + (day + 1);
    result += ' ngày ' + formatDateGo(newDate.getDate()) + " tháng " +
            formatDateGo(newDate.getMonth() + 1) + " năm " + newDate.getUTCFullYear();
    return result;
}
$("#imgRssEvent").attr("src", HomeEnv.urlMedia + "homepage/images/icon/rss_small.png");
$("#lblTimeNow").append(getTimeNowToString());
var DATA_WEATHER = null;

function getInfoFromNews(type) {
    $.ajax({
        url: "http://www1.vtc.vn/api/",
        // data: { "type":type },     
        type: "GET",
        dataType: "script", //dataType: ($.browser.msie) ? "text" : "xml",

        cache: false,
        timeout: 25000,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
        },
        success: function (data) {
            //     if (typeof data == "string") {
            data = commonService;
            DATA_WEATHER = data[0].Value;
            getExchangerateFromNews(data[2].Value);
            getGoldfareFromNews(data[1].Value);
            getWeatherFromNews();
            $("#pnlPortalInfoNews").removeClass("hidden");
        }
    });
}
function callInfoFromNews(type) {
    var mf = document.createelement('script'); mf.type = 'text/javascript'; mf.async = false;
    mf.src = 'http://vtc.vn/api/?type=' + type + '&callback=getWeatherFromNews';
    var smf = document.getelementsByTagName('script')[0]; smf.parentNode.insertBefore(mf, smf);
}
function getWeatherFromNews() {
    if (DATA_WEATHER) {
        var h = '';
        $.each(DATA_WEATHER, function (i, r) {
            h += '<option value="' + r.Code + '">' + r.Location + '</option>';
        });
        h = h.replace("Tân Sơn Nhất", "TP HCM");
        $("#sltWeather").html(h);

        showWeather('Ha-Noi');
        $("select[name='sltWeather'] option[value='Ha-Noi']").attr("selected", true);
        $("#sltWeather").change(function () {
            var val = $("#sltWeather option:selected").val();
            showWeather(val);
        });
    }
}
function showWeather(code) {
    var img = '';
    $.each(DATA_WEATHER, function (i, r) {
        if ((r.Code).indexOf(code) != -1) {

            img = r.WeatherSymbol;
            img = img.replace("&lt;", "<").replace("&gt;", ">").replace("30px", "48px");
            $("#weather_sky").html(img);
            $("#weather_temp").html(r.Temperature);
            //$("#weather_info").html(h);  
        }
    });

}
function selectOption(select_id, option_val) {
    $('#' + select_id + ' option:selected').removeAttr('selected');
    $('#' + select_id + ' option[value=' + option_val + ']').attr('selected', 'selected');
}

function getExchangerateFromNews(data) {
    var h = '';
    $.each(data, function (i, r) {
        h += '<tr>';
        h += '<td>' + r.Code + '</td>';
        h += '<td>' + r.Buy + '</td>';
        h += '<td>' + r.Sell + '</td>';
        h += '</tr>';
    });
    $("#box_ExchangeRate").append(h);
}
function getGoldfareFromNews(data) {
    var h = '';
    $.each(data, function (i, r) {
        h += '<tr>';
        h += '<td>' + r.Name + '</td>';
        h += '<td>' + r.Buy + '</td>';
        h += '<td>' + r.Sell + '</td>';
        h += '</tr>';
    });
    $("#box_GoldFare").append(h);

}
function setHomepage(d) {
    if (document.all) {
        document.body.style.behavior = 'url(#default#homepage)';
        document.body.setHomePage(d);

    }
    else if (window.sidebar) {
        var guide = "";
        // guide = "Để đặt <a href=\"" + d + "\">Go.vn</a> làm trang chủ, "
        //+"vui lòng nhập <strong>about:config</strong> vào thanh địa chỉ.";
        //guide += "<br /><br /> Sau đó tìm và thay đổi giá trị <strong>signed.applets.codebase_principal_support</strong> thành <strong>true</strong>.";
       guide += "Trên Menu chính bạn chọn Tools>> Option>> General>> nhập \"go.vn\" vào trường [home page]>> bấm [Ok].";
        if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }
            catch (e) {
                alertDialog(guide);
            }
        }
        try {
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage', d);
        }
        catch (e) {
            //alertDialogTimeOut("Đặt Go.vn làm trang chủ không thành công.", 2);
            alertDialog(guide);

        }
    }
}

/* Modified to support Opera */
function AddBookmark(title, url) {
    if (window.sidebar) // firefox
        window.sidebar.addPanel(title, url, "");
    else if (window.opera && window.print) { // opera
        var elem = document.createelement('a');
        elem.setAttribute('href', url);
        elem.setAttribute('title', title);
        elem.setAttribute('rel', 'sidebar');
        elem.click();
    }
    else if (document.all)// ie
        window.external.AddFavorite(url, title);
}
function IsXmasTime() {
    var newDate = new Date(HomeEnv.server_time);
    // get date
    var date = newDate.getDate(), month = newDate.getMonth() + 1;
    // date from 1 - 31 of December
    var start = 1, end = 31;

    if (month == 12)
        if (date > 1 && date < 31)
            return true;
    return false;
}

function showFlashKonami() {
    var keys = [];
    var konami = '38,38,40,40,37,39,37,39,66,65';

    $(document)
    .keydown(
        function (e) {
            keys.push(e.keyCode);
            if (keys.toString().indexOf(konami) >= 0) {
                var str = "";
                str += '<div id="DivKonamiCode" style="z-index: 1; left: 0px; width: 45px; position: absolute; top: 7px; height: 1px" onclick=\'$("#DivKonamiCode").remove();\'>';
                str += '<object height="54" width="209">';

                var ran = Math.round(Math.random() * 49) + 1;

                var strUrl = ACTIVITY_MEDIA + "konami/" + ran + ".swf";
                str += '<embed src="' + strUrl + '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" ; type="application/x-shockwave-flash" menu="false" wmode="transparent" height="440" width="940"></object></div>';

                $('#blockKonami').html(str);
                $("#blockKonami").animate({
                    width: "70%",
                    opacity: 1,
                    marginLeft: "0.6in",
                    fontSize: "3em",
                    borderWidth: "10px"
                }, 1500);
               // if (window.auto_scroll)
                    auto_scroll('#goPortal_goTop', 100);
                keys = [];
//                if (IsXmasTime()) {
//                    if (window.SNOW_Time)
//                        SNOW_Weather();
//                    else
//                        $.getScript(HomeEnv.urlMedia + "homepage/js/snow.js");
//                    $(document).click(function () {
//                        hidesnow();
//                    });
//                }
            }
        }
    );
}

//-------------start processRightColumn-------------//
function setAsHomePage(control) {
    if (document.all) {
        control.style.behavior = 'url(#default#homepage)';
        control.setHomePage(homePageUri.url);
    }
    else if ($.browser.mozilla) {
        showJAlert("Hỗ trợ đặt [Mạng Việt Nam] làm trang chủ.", 'Trên Menu chính bạn chọn Tools>> Option>> General>> nhập "go.vn" vào trường [home page]>> bấm [Ok].');
    }
}
var homePageUri = { url: "http://go.vn", title: "Mạng Việt Nam" };
var lastestLogConfig = {
    pageIndex: 1
    , pageSize: 5
    , currentIndex: 0
    , isInit: false
    , height: 360
    , init: initPage
    , speed: 1000
    , pause: 5000
    , animation: ''
    , mousePause: true
    , showItems: 5
};

function processRightColumn() {  
    for (var i = 0; i < 5; i++) {
        initPage(lastestLogConfig, true);
    }
    $('#lastestLogs-content').vnews(lastestLogConfig);

    $("#lnkBookmarkSite").click(function () {
        bookmarksite(homePageUri.title, homePageUri.url);
    });
    
    $("#taskOpenTrailerGoVN").click(function (handler) {
        popupDialog("#trailerGoVN", 768, 534, "Giới thiệu Mạng Việt Nam");
    });    
}

function initPage(options, isShow) {
    options.currentIndex++;

    if (options.currentIndex == lasestLogs.length) {
        options.isInit = true;
    }
    $("#lastestLogs-pages").prepend('<li id="lastestLogs-page-' + options.currentIndex + '"</li>');
    if (isShow == undefined)
        $("#lastestLogs-page-" + options.currentIndex).hide();
    //$("#lastestLogs-page-" + options.currentIndex).hide();
    var element = lasestLogs[options.currentIndex - 1];
    var newLog = $("#logTemplate").clone();
    newLog.removeAttr("style");
    newLog.attr("id", "logId_" + element.Id);

    var linkToUser1 = newLog.find("a.linkToUser1");
    linkToUser1.attr("href", "http://my.go.vn/?id=" + element.SourceUserId);
    var avata = newLog.find("img.avata50x50");
    avata.attr("src", replaceDataByDomain(MyGoLib.GetAvatarPath(element.SourceUserId, 50, 50)));
    avata.attr("alt", element.SourceUserName);
    var linkToUser2 = newLog.find("a.linkToUser2");
    linkToUser2.attr("href", "http://my.go.vn/?id=" + element.SourceUserId);
    linkToUser2.text(element.SourceUserName);
    
    var logInfo = getActionLink(element);
    changeIcon(newLog, element);
    linkToUser2.after(logInfo);
    $("#lastestLogs-page-" + options.currentIndex).prepend(newLog);
}

function changeIcon(container, jsonLog) {
    var icon = container.find("img.icon_col_right");
    var imageSrc = eval("ActivityEnum.ActionEx.l" + jsonLog.LogType + ".Icon");
    if (imageSrc != "") {
        icon.attr("src", HomeEnv.urlMedia + "portal/" + imageSrc);
    }
    else {
        icon.attr("style", "display:none;");
    }
    container.find("span.text_grey_blog").text(activity_formatDateTime(parseInt(jsonLog.CreateTime.getTime())));
}

function getActionLink(jsonLog) {
    var logInfo = " ", linkToLog ='';
    var actionText = eval("ActivityEnum.ActionEx.l" + jsonLog.LogType + ".Text");
    var actionLinkCaption = eval("ActivityEnum.ActionEx.l" + jsonLog.LogType + ".LinkCaption");
    var message = jQuery.parseJSON(jsonLog.Message);
    if (!eval("ActivityEnum.ActionEx.l" + jsonLog.LogType + ".isShowTitle")) {
        if (jsonLog.LogType == 3) {
            logInfo += actionText + " <a href='http://my.go.vn/?action=detail&id=" + jsonLog.SourceUserId + "&lid=" + jsonLog.Id + "'>" + actionLinkCaption + "</a>"
        }
        else {
            if (message.UrlDetail != undefined && message.UrlDetail != null) {
                $("#divTemp").html(message.UrlDetail);
            }
            else {
                $("#divTemp").html(message.Description);
            }
            linkToLog = $("#divTemp").find("a").first();
            logInfo += actionText + " <a href='" + linkToLog.attr("href") + "'>" + actionLinkCaption + "</a>"
        }
        if (jsonLog.DestUserId != 0) {
            logInfo +=" của <a href='http://my.go.vn/?id=" + jsonLog.DestUserId + "' class=\"mygo_accName\">" + jsonLog.DestUserName + "</a>"
        }
    }
    else {
        logInfo += actionText + " " + actionLinkCaption;
        if (message.UrlDetail != undefined && message.UrlDetail != null) {
            logInfo += " " + message.UrlDetail;
        }
        else {
            $("#divTemp").html(message.Description);
            linkToLog = $("#divTemp").find("a").first();
            if (linkToLog.text() != "")
                logInfo += " <a href='" + linkToLog.attr("href") + "'>" + linkToLog.text() + "</a>"
            else
                logInfo += " <a href='" + linkToLog.attr("href") + "'>" + linkToLog.attr("href") + "</a>"
        }
    }
    return replaceDataByDomain(logInfo);
}
//-------------end processRightColumn-------------//

// bind html top result for ioe
var htmlIoe = '', IsGetSuccessIOE = false;
var IOE = {
    Level: 3,
    MaxLevel: 13,
    Location: 0,
    MaxLocation: 64,
    ServiceUrl: 'http://services.ioe.go.vn/View/Top4Portal.ashx',
    Timeout: 5000,
    MaxDisplay: 5,
    Avatar: 50
};
function Portal_IOE_bindLevelHtml() {
    htmlIoe = '<span class="fl">Lớp:</span>';
    for (var i = IOE.Level; i < IOE.MaxLevel; i++)
        htmlIoe += '<a onclick="Portal_IOE_changeClass(' + i + ')"'
                + ' href="javascript:void(0)" id="hlk_Portal_IOE_loc_' + i + '" class="hlk_Portal_IOE_loc">'
                + i + '</a>';
    $("#pnl_Portal_IOE_topClass").html(htmlIoe);
}

// change class number
function Portal_IOE_getContent(classNum) {
   if (IsGetSuccessIOE) return;
    var paramsIoe = {};
    paramsIoe.c = classNum;
    paramsIoe.type = "NTopN4P"
    $.ajax({
        url: IOE.ServiceUrl,
        data: paramsIoe,
        type: "GET",
        timeout: IOE.Timeout,
        cache: true,
        dataType: "jsonp",
        error: function () {
            // $("#pnl_Portal_IOE_topContent").html(HomeEnv.error);
        },
        success: function (data) {
            // bind data by list object
            if (data) {
                Portal_IOE_bindHtml(eval(data.data));
                $("#pnl_Portal_IOE_top").show();
                IsGetSuccessIOE = true;
            }
        }
    });

}
// bind html ioe
function Portal_IOE_bindHtml(data) {
    var accId, accPubName, accAvatar = '', accAddress, r;
   
    var length = data.length;
    var min = Math.min(IOE.MaxDisplay, length);
    var html = '<div class="ioe_topResult"><ul>';
     for (var i = 0; i < min; i++) {
         r = data[i];
        accId = r.fk_user_id;
        accPubName = r.s_full_name;

        accAvatar = MyGoLib.GetAvatarPath(accId, IOE.Avatar, IOE.Avatar);
       
        accAddress = r.s_class + " " + r.s_school_name + " - " + r.s_district_name + " - " + r.s_province_name;
       
        html += '<li class="clearfix">'
                                   + '<a class="fl" style="padding-right:5px" href="http://my.go.vn/?id=' + accId + '">'
                                   + '<img src="' + accAvatar + '" alt="' + accPubName + '" /></a>'
                                   + '<a class="mygo_accName" href="http://my.go.vn/?id=' + accId + '">'
                                   + accPubName + '</a>'
                                   + ' <a class="colorName" href="http://ioe.go.vn/PersonalAchievements.aspx?uid=' + accId + '"'
                                   + '>[Kết quả]</a><br>'
                                   + accAddress + '</li>';

    }
    html += '</ul>';
    
    html += '</div>';
    $("#pnl_Portal_IOE_topContent").html(html);
}
// change class number
function Portal_IOE_changeClass(i) {

    $(".hlk_Portal_IOE_loc").removeClass("active");
    $("#hlk_Portal_IOE_loc_" + i).addClass("active");
    IOE.Level = i;
    IsGetSuccessIOE = false;
    Portal_IOE_getContent(IOE.Level);
}
function auto_scroll(anchor, top) {
    var $target = $(anchor);

    $target = $target.length && $target || $('[name=' + anchor.slice(1) + ']');

    if ($target.length) {
        var targetOffset = $target.offset().top - top;
        $('html,body').animate({ scrollTop: targetOffset }, 100);
        return false;
    }
}
function initPortalRight() {
//    if (isAllowDisplayMyGoTam && IsGoPortalAll)
//        Portal_getMyGoTam_right();
    $('#slidesHotPhoto li:first').show();
    $(document).ready(function () {
        /* get mygo8 clips on right*/
        var html_MyGo8_right = $('#pnlPortal_MyGo8_right').html();
        if (isAllowDisplayMyGoTam && IsGoPortalAll && html_MyGo8_right == '')
            Portal_getMyGoTam_right();
        $('#slidesHotPhoto').cycle({
            delay: 0,
            speed: 'fast',
            fx: 'fade', /*turnDown, fade*/
            pause: 1,
            pauseOnPagerHover: 1,
            prev: '#hlk_backHotPhoto',
            next: '#hlk_nextHotPhoto',
            random: 0,
            pager: '#paginationHotPhoto',
            pagerAnchorBuilder: function (idx, slide) {
                return ' <a id="hlk_hotPhoto_' + (idx + 1) + '" href="javascript:void(0);">'
                        + (idx + 1) + '</a>';
            },
            activePagerClass: 'selected'
        });
    });
    processRightColumn(); // hoanNN
    // bind html for content ioe
    Portal_IOE_bindLevelHtml();

    IOE.Level = 3 + Math.floor(Math.random() * (IOE.MaxLevel - 3));
    setTimeout('Portal_IOE_changeClass(IOE.Level);', IOE.Timeout);
    // end ioe
}
function initPortalLeft() {
    if (DATA_WEATHER) return;
    else
        getInfoFromNews('all');
    //        $.getScript("http://search.go.vn/newstyles/js/tagcloud.js", function () {
    //            $("#pnlPortalTagCloud").removeClass("hidden");
    //        });
}
function initPortalEvent() {
    $(".hlkSetHomepage").click(function () {
        setHomepage(HomeEnv.domainGo);
    });
    $(".hlkAddBookmark").click(function () {
        AddBookmark('Mạng Việt Nam', HomeEnv.domainGo);
    });
    //  focusAndBlur("#txtSearchAll", $("#txtSearchAll").val());

    $(".footer_line").css("border", "none");
    $("#hlkPortal_goTop").click(function () {
        auto_scroll('#goPortal_goTop', 100);
    });

    //showFlashKonami();
}
function loadScriptZone() {
    var delayZoneTimeout = 3000;
    setTimeout(function () {
        $(document).ready(function () {
            (function () {
                var gozone = document.createElement('script');
                gozone.type = 'text/javascript';
                gozone.async = true;
                gozone.src = "http://zone.go.vn/boxnhung/code_nhung/right/left/SN_right_left_content.js?" + Math.random() * 10000;
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(gozone);
            })();
        });
    }, delayZoneTimeout);
    //  setTimeout(function () {
    ///   $(document).ready(function () {
    (function () {
        var goSNPortal = document.createElement('script');
        goSNPortal.type = 'text/javascript';
        goSNPortal.async = true;
        goSNPortal.src = "http://zone.go.vn/boxnhung/code_nhung/goportal/topbanner/SN_goportal_topbanner_content.js?" + Math.random() * 10000;
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(goSNPortal);
    })();
    //    });
    //  }, 3000);
}
// page load complete
$(document).ready(function () {
    //    if (typeof goPortalFilterId == 'undefined')
    //        var goPortalFilterId = 'portalall';
    // if (IsGoPortalAll || IsIdHasNoHtml(goPortalFilterId)) {
    //   initPortalLeft(); /* weather */
    initPortalRight(); /* show mygo8, hot photo*/
    // }
    initPortalEvent();
   // if (IsGoPortalAll) loadScriptZone();
});