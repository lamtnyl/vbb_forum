var SongID = $('#songID').val();
var genreID = $('#genreID').val();
var StatusID = $('#StatusID').val();
var BxhStatus = $('#BxhStatus').val();
init();
function init(){		
	if(BxhStatus>0&BxhStatus<=40){
		$('#imgBxhStatus').attr('src',imageServer+'skins/gentle/images/toprank-'+BxhStatus+'.png');
		$('#imgBxhStatus').show();
	}
	if(!$('#uploadUserName').val()){
		$('#spanHomePage').html('');
	}
	if (!$('#composer a')[0].innerHTML) {
		$('#composer').hide();
	}
	if (!$('#album a')[0].innerHTML) {
		$('#album').hide();
	}
	if(StatusID==-2){
		deActiveLink('lnkAddSongToCart');
		deActiveLink('lnkDownload');
		$('#lnkDownload').attr('href','#');	
	}
	Init_Lyric();	
	if(!$('#uploadUserName').val()){
		$('#spanHomePage').html('');
	}
	if(disableBadSongReport(SongID)){
		deActiveLink('imgBadSongNotify')
	}
	//writeLogSongToCookie(SongID,genreID);
	setTimeout(function writeLogSongToCookie(){
		// friend listen (app me)
		friendListen();
		// set songid to cookies
		var strSongID = Os_Cookiess.$Get('strSongID');
		if (!strSongID) {
			strSongID = SongID+'-'+genreID;
		} else {
			strSongID += ',' + SongID+'-'+genreID;
		}
		Os_Cookiess.$Set('strSongID', strSongID, 24, '/', false);
	}, 30000);
	
}

function Init_Lyric(){
	var msgNoLyric='Rất tiếc, hiện chưa có lời cho bài <b>'+$('#txtSongTitle').val()+' - '+$('#hidArtist').val()+'</b>. Mời bạn "xung phong" đóng góp!';		
	if($('#isHaveLyric').val()!=1){ //don't have lyric
		$('#imgLyricSwitch').hide();
		$('#divLyric').html(msgNoLyric);
	}else{ //have lyric
		$('#linkLyricAdd').hide();	
		var value = imageServer+'skins/gentle/images/move-down.png';
		$('#imgLyricSwitch').attr('src',value);	
		$('#divLyric').css('height','100px');
		if ($('#LyricUsername').val()==''){
			$('#lyricThanksMessage').hide();
		}  
	}
}

function disableBadSongReport(SongID){
	var strBadSongID = ','+Os_Cookiess.$Get('strBadSongID');
	if(strBadSongID.indexOf(','+SongID+',') != -1){
		return 1;
	}else{
		return 0;
	}
}
/*
$('#imgBadSongNotify').click(
	function(){
		if(!disableBadSongReport(SongID)){
			var lightbox_url = '/mp3/bao-xau-ca-khuc/index.'+SongID+'.html?TB_iframe=true&height=300&width=600&modal=false';
			tb_show('Bao Xau',lightbox_url);
		}
		return false;
	}
)*/



function textEmbed_Blur(obj){
	obj.select();
	copy(obj.value);
}

//function textEmbed_Click(obj){
	//copy(obj.value);
	//obj.select();
//	$('#'+obj.id).css('background-color','#FFFF00');
//}

var SkinEmbbed = {
	songIDEnCode: $('#songIDEnCode').val(),
	totalIcon: 11,
	firstID:1,
	totalIconDisplay:7,
	currentID:4,
	width:300,	
	height:61,
	autoPlay:'false',
	xmlUrl:$('#xmlUrlNoAuto').val(),
	txtForumID:'txtEmbedCode',
	txtBlogID: 'txtBlogCode',	
	createIcon: function(id,display){
		var template = '<a href="#" onclick="SkinEmbbed.changeSkin('+id+');return false;" id="lnkSkin'+id+'" style="display:'+display+'"><img height="30" width="37" border="0" alt=" " src="'+imageServer+'skins/gentle/images/iconskin'+id+'.gif"/></a>';
		return template;
	},
	createEmbbedCodeBlog: function(){
		var imageServer = 'http://static.mp3.zing.vn/';
		//var tpl = '<object width="'+this.width+'" height="'+this.height+'"><param name="movie" value="'+imageServer+'skins/default/flash/player/mp3Player_skin'+this.currentID+'.swf?xmlurl=http://' + window.location.hostname + '/blog/?'+this.xmlUrl+'" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><embed width="'+this.width+'" height="'+this.height+'" src="'+imageServer+'skins/default/flash/player/mp3Player_skin'+this.currentID+'.swf?xmlurl=http://' + window.location.hostname + '/blog/?'+this.xmlUrl+'" quality="high" wmode="transparent" type="application/x-shockwave-flash"></embed></object>';
		var tpl = '<embed width="'+this.width+'" height="'+this.height+'" src="'+imageServer+'skins/default/flash/player/mp3Player_skin'+this.currentID+'.swf?xmlurl=http://' + window.location.hostname + '/blog/?'+this.xmlUrl+'" quality="high" wmode="transparent" type="application/x-shockwave-flash"></embed>';
		return tpl;
	},
	createEmbbedCodeForum: function(){
		var imageServer = 'http://static.mp3.zing.vn/';		
		var tpl = '[FLASH]'+imageServer+'skins/default/flash/player/mp3Player_skin'+this.currentID+'.swf?xmlurl=http://'  + window.location.hostname  + '/blog/?'+this.xmlUrl+'[/FLASH]';
		return tpl;
	},	
	createListIcon: function(){
		var html = '';
		var display = '';
		for(i=1;i<=this.totalIcon;i++){
			if((i>=this.firstID) && (i<=this.firstID+this.totalIconDisplay-1)){
				display = '';
			}else{
				display = 'none';				
			}
			html=html+this.createIcon(i,display);			
		}
		return html;
	},
	changeSkin: function(id){
		var src = imageServer+'skins/gentle/images/SkinPlayer/'+id+'.jpg';
		$('#imgSkinPlayer').attr('src',src);
		this.currentID = id;
		$('#divSkinPanel').show('fast');
		this.setEmbededCode();
//		this.setDemoSkin();
	},
	createMain: function(){
		var list = this.createListIcon();
        var text = unescape('%53%65%6C%65%63%74%20%53%6B%69%6E%20%6E%68%E9%20%3A%29%20%43%6F%64%65%64%20%62%79%20%68%6F%41%6E%67%74%75%5F%45%63%68%3A');
		var main = '<span class="title-skin">'+text+'</span><div style="background-color: white;padding-top:5px;padding-left:5px; height: 50px;display:none" id="divSkinPanel"><div style="float: left; width: 320px;" id="divPanelLeft"><img id="imgSkinPlayer" src="'+imageServer+'skins/gentle/images/SkinPlayer/1.jpg" style="background-color: transparent;"/></div><div id="divPanelRight" style="float: left;"><div><input id="chkAutoPlay" onclick="SkinEmbbed.changeAutoPlay()" type="checkbox" style="width: 20px; height: 10px;border:0px"/>Tự động Play</div><div><input id="chkBackGround" onclick="return SkinEmbbed.changeBackGround();" type="checkbox" style="width: 20px; height: 10px; border:0px"/>Nhạc nền</div></div></div><div class="skinIcon"><div class="left"><img onclick="return SkinEmbbed.moveLeft();" height="30" width="9" src="'+imageServer+'skins/gentle/images/left-link.png"/></div><div class="icon">'+list+'</div><div class="right"><img onclick="SkinEmbbed.moveRight()" id="imgRight" height="30" width="9" src="'+imageServer+'skins/gentle/images/right-link.png"/></div><br class="clr"/></div>';
		return main;		
	},
	setEmbededCode: function(){
		var forumCode = this.createEmbbedCodeForum();
		var blogCode = this.createEmbbedCodeBlog();		
		//$('#lblShareLocation').html('Blog');
		//$('#lblLinkSong').html('Forum');		
		$('#'+this.txtForumID).val(forumCode);
		$('#'+this.txtBlogID).val(blogCode);		
	},	
	setDemoSkin: function(){
		this.width = 260;
		this.height = 51;	
		$('#divPanelLeft').html(this.createEmbbedCodeBlog());
	},	
	changeAutoPlay: function(){
		var chkAutoPlay = $('#chkAutoPlay').attr('checked');
		if(chkAutoPlay){
			this.autoPlay = 'true';
			this.xmlUrl = $('#xmlUrlAuto').val();
		}else{
			this.autoPlay = 'false';
			this.xmlUrl = $('#xmlUrlNoAuto').val();			
		}
		this.setEmbededCode();
	},
	changeBackGround: function(){
		var chkBackGround = $('#chkBackGround').attr('checked');		
		if(chkBackGround){
			$('#chkAutoPlay').attr('checked','checked');
			this.changeAutoPlay();
			$('#chkAutoPlay').attr('disabled','disabled');
			this.width = 1;
			this.height = 1;			
		}else{
			$('#chkAutoPlay').attr('disabled','');
			this.width = 360;
			this.height = 61;						
		}
		this.setEmbededCode();		
	},	
	show: function(id){
		$('#lnkSkin'+id).show();
	},
	
	hide: function(id){
		$('#lnkSkin'+id).hide();
	},	

	moveLeft: function(){
		var firstID_new = this.firstID-1;
		if(firstID_new>=1){
			this.hide(firstID_new+this.totalIconDisplay);						
			this.show(firstID_new);
			this.firstID = firstID_new;
		}
		return false;
	},
	
	moveRight: function(){
		var lastID_new = this.firstID+this.totalIconDisplay;
		if(lastID_new<=this.totalIcon){
			this.hide(this.firstID);									
			this.show(lastID_new);			
			this.firstID +=1;
		}
		return false;
	}
}

$('#divSkins').html(SkinEmbbed.createMain());
