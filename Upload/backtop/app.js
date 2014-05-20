var video_player=[];

function pageInit(){
    menuSelected=3;
    initDisplayStyleBtns();
    if(video_player[0])loadPlayer(video_player[0][0],video_player[0][1],video_player[0][2],video_player[0][3]);
}
function initDisplayStyleBtns(){
    $('#display-style-btns div').click(function(){
        classes = ['large','large_active','small','small_active'];
        other = (this.className==classes[0])?classes[3]:classes[1];
        other_will = (this.className==classes[0])?classes[2]:classes[0];
        $('#display-style-btns div.'+other)[0].className=other_will;
        this.className = (this.className==classes[0])?classes[1]:classes[3];
    });
}
function loadProjects(){
    
}
function loadNextProject(){

}
function loadPlayer(id,file,image,xml){
    var so = new SWFObject('/img/template/video-player/player.swf','flashContent','838','580','9');
    so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','always');
    so.addParam('bgcolor','#000000');
    so.addParam('flashvars','video='+file+'&autoplay=no'+'&first_slide='+image+'&XMLPath='+xml);
    so.write(id);
    $('#'+id).fadeIn(anim_time);
}