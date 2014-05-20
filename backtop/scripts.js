var browser_detect = {
    IE:     !!(window.attachEvent && !window.opera),
    Opera:  !!window.opera,
    WebKit: navigator.userAgent.indexOf('AppleWebKit/') > -1,
    Gecko:  navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1,
    MobileSafari: !!navigator.userAgent.match(/Apple.*Mobile.*Safari/)
}
var mobileSafari = browser_detect.MobileSafari;
var upAnimate=false;
var anim_time;
if($.browser.msie)anim_time=0;
else anim_time=500;
var anim_time_short = (anim_time==0)?0:350;
var scroll_animate=false;
var menuSelected=false;
var domStart = new Date();
function culculateDomRedy(ads){
    domStop = new Date();
    loadTime = (domStop.getTime()-domStart.getTime());
    if(console){
        logStr = (ads)?ads+' ':'';
        logStr +=(loadTime<1000)?'cache =>':'full refresh =>';
        console.log((logStr + loadTime));
    }
}

if(mobileSafari){
    $('#wrapper').css({'overflow':'hidden'});
    $('#wrapper').css({'min-height':'1000px'});
}
function getNewSrc(src,fType){
    // src = $('#description_01')[0].src;
    preNewSrc = src.split('/');
    preNewSrc = preNewSrc[preNewSrc.length-1].split('.');
    newSrc = preNewSrc[0]+fType;
    return newSrc;
}
function setImgSrc(id){
    id = '#'+id;
    $(id)[0].src=project_path+getNewSrc($(id)[0].src,'.svg');
}
function getScrollY(){
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }
  return scrOfY;
}
function initSimpleBtn(){
    $('a.simple-btn').hover(function(){
        $(this).css({'background-position':'0 -48px'});
    },function(){
        $(this).css({'background-position':'0 0'});
    });
    if(!mobileSafari){
        $('a.simple-btn').mousedown(function(){
            $(this).css({'background-position':'0 -96px'});
        });
        $('a.simple-btn').mouseup(function(){
            $(this).css({'background-position':'0 -48px'});
        });
    }
    else{
        $('a.simple-btn').click(function(){
            $(this).css({'background-position':'0 -96px'});
            setTimeout(function(){$(this).css({'background-position':'0 0'});},350);
        });
    }
}
function initAppStoreBtn(){
    $('a.app-store-btn').hover(function(){
        $(this).css({'background-position':'0 -68px'});
    },function(){
        $(this).css({'background-position':'0 0'});
    });
    if(!mobileSafari){
        $('a.app-store-btn').mousedown(function(){
            $(this).css({'background-position':'0 -136px'});
        });
        $('a.app-store-btn').mouseup(function(){
            $(this).css({'background-position':'0 -68px'});
        });
    }
    else{
        $('a.app-store-btn').click(function(){
            $(this).css({'background-position':'0 -136px'});
            setTimeout(function(){$(this).css({'background-position':'0 0'});},350);
        });
    }
}
function initDownloadBtn(){
    $('a.download-btn').hover(function(){
        $(this).css({'background-position':'0 -68px'});
    },function(){
        $(this).css({'background-position':'0 0'});
    });
    if(!mobileSafari){
        $('a.download-btn').mousedown(function(){
            $(this).css({'background-position':'0 -136px'});
        });
        $('a.download-btn').mouseup(function(){
            $(this).css({'background-position':'0 -68px'});
        });
    }
    else{
        $('a.download-btn').click(function(){
            $(this).css({'background-position':'0 -136px'});
            setTimeout(function(){$(this).css({'background-position':'0 0'});},350);
        });
    }
}
function initTwitterBtn(){
    $('a.twitter-btn').hover(function(){
        $(this).css({'background-position':'0 -68px'});
    },function(){
        $(this).css({'background-position':'0 0'});
    });
    if(!mobileSafari){
        $('a.twitter-btn').mousedown(function(){
            $(this).css({'background-position':'0 -136px'});
        });
        $('a.twitter-btn').mouseup(function(){
            $(this).css({'background-position':'0 -68px'});
        });
    }
    else{
        $('a.twitter-btn').click(function(){
            $(this).css({'background-position':'0 -136px'});
            setTimeout(function(){$(this).css({'background-position':'0 0'});},350);
        });
    }
}
function scrollTo(key){
    NewDocumentHeight=0;
    switch(key){
        case 'top':{
            NewDocumentHeight=0;
            break;
        }
        case 'contact':{
            var browserWindow = $(window);
            var WindowHeight = browserWindow.height();
            var ContentHeight = ($('#content').height()>$('#wrapper').height())?$('#content').height()+237:$('#wrapper').height();
            NewDocumentHeight = (WindowHeight>ContentHeight)?WindowHeight:ContentHeight;
            break;
        }
    }
    op = $.browser.opera ? $("html") : $("html, body");
    op.animate({ scrollTop: NewDocumentHeight }, 'slow');
}

var rocketFireTimer=false;
var rocketFireState = [0,0,0,1];
var rocketFireFrameLength = 149;
var rocketFireFrameStart = 298;
var rocketFireAnimateTime = 100;
var toLeftFireAnimation = false;
function rocketFireAnimate(){
    for(i=0;i<rocketFireState.length;i++){
        if(rocketFireState[i]==1){
            rocketFireState[i]=0;
            if(!toLeftFireAnimation){
                if((i+2)<rocketFireState.length)rocketFireState[i+1]=1;
                else {
                    rocketFireState[0]=1;
                    toLeftFireAnimation=true;
                }
            }
            else{
                if((i-1)<0)rocketFireState[1]=1;
                else {
                    rocketFireState[i-1]=1;
                    toLeftFireAnimation = false;
                }
            }
            break;
        }
    }
    $('#scrollTop .level-2').css({'background-position':'-'+(rocketFireFrameStart+(i*rocketFireFrameLength))+'px 0px','display':'block'});
    rocketFireTimer = setTimeout('rocketFireAnimate()',rocketFireAnimateTime);
}
function initScrollTop(){
    if(!mobileSafari){
        $('#scrollTop div.level-3').hover(function(){
            if($.browser.msie)this.parentNode.children[0].style.display='block';
            else $(this.parentNode.children[0]).stop().fadeTo(500,1);
        },function(){
            if(upAnimate||scroll_animate)return;
            if($.browser.msie) this.parentNode.children[0].style.display='none';//.css({'background-position':'0 -68px'})
            else $(this.parentNode.children[0]).stop().fadeTo(500,0);
        });
        $('#scrollTop div.level-3').click(function(){
            scroll_animate = true;
            $('#scrollTop .level-2').css({'background-position':'-298px 0','display':'block'});
            // $(this.parentNode.children[0]).css({'background-position':'0 -500px'});
            op = $.browser.opera ? $("html") : $("html, body");
            rocketFireTimer = setTimeout('rocketFireAnimate()',rocketFireAnimateTime);
            op.animate({ scrollTop: 0 }, 'slow',function(){
                scroll_animate = false;
                if(!upAnimate){
                    upAnimate=true;
                    thisTop = $('#scrollTop')[0].offsetTop+250;
                    $('#scrollTop').animate({'margin-top':'-='+thisTop+'px'},300,function(){resetScrollUpBtn();});
                }
            });
        });    
        window.onscroll = function () {
            if((!scroll_animate)&&(!upAnimate)){
                body_elem = $("#body_id")[0];
                window_elem = $("#html_id")[0];
                if(window.innerHeight){
                    wind_height = window.innerHeight;
                    wind_scroll = window.scrollY;
                }
                else{
                    wind_height = document.documentElement.clientHeight;
                    wind_scroll = getScrollY();
                }
                elem = $("#body_id")[0];
                scrollBtn = $("#scrollTop")[0];
                if((elem)&&(scrollBtn)){
                    // $('#log').append('Zzz...<br />');
                    if((scrollBtn.style.display=='none')&&((wind_height*1.5)<wind_scroll)){
                        scroll_animate = true;
                        $("#scrollTop").fadeIn(anim_time,function(){scroll_animate = false;this.style.display='block';});
                    }
                    if((scrollBtn.style.display=='block')&&((wind_height*1.5)>wind_scroll)){
                        scroll_animate = true;
                        $("#scrollTop").fadeOut(anim_time,function(){scroll_animate = false;this.style.display='none';});
                    }
                }
            }
        };    
    }
    else{
        setTimeout(function() { window.scrollTo(0, 1);}, 100);
    }
}
function resetScrollUpBtn(){
    $('#scrollTop .level-2').css({'background-position':'-149px 0px','display':'none'});
    $('#scrollTop').css({'margin-top':'-125px','display':'none'});
    upAnimate=false;
    clearTimeout(rocketFireTimer);
}
function followBtnLink(elem){
    linkElem = $('a.simple-btn',elem.parentNode);
    if((linkElem[0])&&(linkElem[0].className!='simple-btn back-btn')){
        if((linkElem[0].target)&&(linkElem[0].target=='_blank'))window.open(linkElem[0].href);
        else window.location = linkElem[0].href;
        return;
    }
    linkElem = $('a.app-store-btn',elem.parentNode);
    if(linkElem[0]){
        window.location = linkElem[0].href;
        return;
    }        
    linkElem = $('a.twitter-btn',elem.parentNode);
    if(linkElem[0]){
        window.open(linkElem[0].href);
        return;
    }
}
function initImagesClick(){
    $('div.oneProject img').click(function(){followBtnLink(this)});
    $('div.oneImage img').click(function(){followBtnLink(this)});
    $('a.index-project-btn').parent().click(function(){window.location=$('a.index-project-btn')[0].href;});
}
function load_on_load(){
    pageInit();
    initSimpleBtn();
    initAppStoreBtn();
    initDownloadBtn();
    initTwitterBtn();
    menuSelected = (menuSelected)?menuSelected:0;
    initScrollTop();
    gooeymenu.setup({id:'gooeymenu', selectitem:menuSelected});
    if(mobileSafari){
        initImagesClick();
        $('#mobilePlayerPitty a').bind('touchstart',function(){
            $(this).css({'background-position':'0 -162px'});
            setTimeout(function(){$('#mobilePlayerPitty a').css({'background-position':'0 0'});},500);
        });
    }
    setTimeout(function(){
        $('#gooeymenu li.mask-left')[0].style.display ='block';
        $('#gooeymenu li.mask-right')[0].style.display ='block';
    },1500);
}
$(document).ready(function(){load_on_load();});