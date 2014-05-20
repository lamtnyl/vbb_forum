var checkdiv = document.getElementsByTagName("div");
var arraydiv = new Array();
var checkdivlength = checkdiv.length;

var k = new Array();
///////////////// EFFECT 1 ///////////////////////
k[1]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb1")!=-1)
    {
    arraydiv[k[1]]= strdiv;  
    k[1]++;
    }
 }
function toSpans(span) {
  var str=span.firstChild.data;
  var a=str.length;

  span.removeChild(span.firstChild);
  for(var i=0; i<a; i++) {
    var theSpan=document.createElement("SPAN");
    theSpan.appendChild(document.createTextNode(str.charAt(i)));
    span.appendChild(theSpan);
  }
}

function RainbowSpan(span, hue, deg, brt, spd, hspd) {
    this.deg=(deg==null?360:Math.abs(deg));
    this.hue=(hue==null?0:Math.abs(hue)%360);
    this.hspd=(hspd==null?3:Math.abs(hspd)%360);
    text1= span.innerHTML;
    text1 = text1.replace(/(<([^>]+)>)/gi,'');
    span.innerHTML =text1;
    this.length=span.firstChild.data.length;
    this.span=span;
    this.speed=(spd==null?50:Math.abs(spd));
    this.hInc=this.deg/this.length;
    this.brt=(brt==null?255:Math.abs(brt)%256);
    this.timer=null;
    toSpans(span);
    this.moveRainbow();
}

RainbowSpan.prototype.moveRainbow = function() {
  if(this.hue>359) this.hue-=360;
  var color;
  var b=this.brt;
  var a=this.length;
  var h=this.hue;

  for(var i=0; i<a; i++) {

    if(h>359) h-=360;

    if(h<60) { color=Math.floor(((h)/60)*b); red=b;grn=color;blu=0; }
    else if(h<120) { color=Math.floor(((h-60)/60)*b); red=b-color;grn=b;blu=0; }
    else if(h<180) { color=Math.floor(((h-120)/60)*b); red=0;grn=b;blu=color; }
    else if(h<240) { color=Math.floor(((h-180)/60)*b); red=0;grn=b-color;blu=b; }
    else if(h<300) { color=Math.floor(((h-240)/60)*b); red=color;grn=0;blu=b; }
    else { color=Math.floor(((h-300)/60)*b); red=b;grn=0;blu=b-color; }

    h+=this.hInc;

    this.span.childNodes[i].style.color="rgb("+red+", "+grn+", "+blu+")";
  }
  this.hue+=this.hspd;
}
var myRainbowSpan = new Array();
 for(i=0;i<k[1];i++)
  {
var r1=document.getElementById(arraydiv[i]);
 if(r1)
  {
myRainbowSpan[i]=new RainbowSpan(r1, 0, 360, 255, 50, 20); 
myRainbowSpan[i].timer=window.setInterval("myRainbowSpan["+i+"].moveRainbow()", myRainbowSpan[i].speed);
 }
  
  }


/////////////////////// EFFECT 2 //////////////////////////////
k[2]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb2")!=-1)
    {
    arraydiv[k[2]]= strdiv;  
    k[2]++;
    }
 }
  if(k[2]!=0)
 {

var text = new Array();
var storetext = new Array();
var speed=70 // SPEED OF FADE
for(i=0;i<k[2];i++)
 {
text[i] = document.getElementById(arraydiv[i]);

  text2= text[i].innerHTML.replace(/(<([^>]+)>)/gi,'');
  text[i].innerHTML = "<B>"+text2+"</b>";
  text[i]=text[i].firstChild.data;
if (document.all||document.getElementById){
storetext[i]=document.getElementById? document.getElementById(arraydiv[i]) : document.all.highlight
}
else
document.write(text[i])
}
var hex=new Array("00","14","28","3C","50","64","78","8C","A0","B4","C8","DC","F0")
var r=1
var g=1
var b=1
var seq=1
function changetext(){
rainbow="#"+hex[r]+hex[g]+hex[b]
for(i=0;i<k[2];i++)
 {
storetext[i].style.color=rainbow
 }
}
function change(){
if (seq==6){
b--
if (b==0)
seq=1
}
if (seq==5){
r++
if (r==12)
seq=6
}
if (seq==4){
g--
if (g==0)
seq=5
}
if (seq==3){
b++
if (b==12)
seq=4
}
if (seq==2){
r--
if (r==0)
seq=3
}
if (seq==1){
g++
if (g==12)
seq=2
}
changetext()
}
function starteffect(){
if (document.all||document.getElementById)
flash=setInterval("change()",speed)
}
starteffect()
}

/////////////////////// EFFECT 3 ////////////////////////////
k[3]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb3")!=-1)
    {
    arraydiv[k[3]]= strdiv;  
    k[3]++;
    }
 }

 if(k[3]!=0)
  {
 var getdiv = new Array();
 for(l=0;l<k[3];l++)
 {
getdiv[l] = document.getElementById(arraydiv[l]);
}
var message = new Array();
 for(l=0;l<k[3];l++)
 {
  text3= getdiv[l].innerHTML.replace(/(<([^>]+)>)/gi,'');
  getdiv[l].innerHTML = text3;    
message[l]=getdiv[l].firstChild.data;
getdiv[l].innerHTML = ""; 
}


var flashspeed=50						// speed of flashing in milliseconds
var flashingletters=4						// number of letters flashing in neontextcolor
var flashingletters2=1						// number of letters flashing in neontextcolor2 (0 to disable)
var flashpause=0						// the pause between flash-cycles in milliseconds

///No need to edit below this line/////

var n = new Array();
for(l=0;l<k[3];l++)
 {
n[l]=0;
}
for(l=0;l<k[3];l++)
  {
if (document.all||document.getElementById){

for (m=0;m<message[l].length;m++)
{
getdiv[l].innerHTML += '<span id="neonlight'+l+m+'"><b>'+message[l].charAt(m)+'</b></span>';
}
}
else
{
getdiv[l].document.write(message[l])
}
}
function crossref(number,l){
var crossobj=document.all? eval("document.all.neonlight"+l+number) : document.getElementById("neonlight"+l+number)
return crossobj
}

function get_random_color()  
{ 
    var r = function () { return Math.floor(Math.random()*256) }; 
    return "rgb(" + r() + "," + r() + "," + r() + ")"; 
} 


function neon(l){
 
//Change all letters to base color
if (n[l]==0){
for (m=0;m<message[l].length;m++)
crossref(m,l).style.color=get_random_color()
}

//cycle through and change individual letters to neon color
crossref(n[l],l).style.color=get_random_color()  

if (n[l]>flashingletters-1) crossref(n[l]-flashingletters,l).style.color=get_random_color()   
if (n[l]>(flashingletters+flashingletters2)-1) crossref(n[l]-flashingletters-flashingletters2,l).style.color=get_random_color()  


if (n[l]<message[l].length-1)
n[l]++
else{
n[l]=0
clearInterval(flashing[l])
setTimeout("beginneon("+l+")",flashpause)
return
}

}

var flashing= new Array();
for(l=0;l<k[3];l++)
{
function beginneon(l){
if (document.all||document.getElementById)
{

flashing[l]=setInterval("neon("+l+")",flashspeed)
}
}
beginneon(l)
}}

/////////////////// EFFECT 4 ////////////////////////////
k[4]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb4")!=-1)
    {
    arraydiv[k[4]]= strdiv;  
    k[4]++;
    }
 }
 var text4 = new Array();
 for(l=0;l<k[4];l++)
 {
text4[l] = document.getElementById(arraydiv[l]);
}
 if(k[4]!=0)
 {
 var message = new Array();
  for(l=0;l<k[4];l++)
 {

message[l]=text4[l].innerHTML.replace(/(<([^>]+)>)/gi,'');
 }
 
var j=0; 
for(i=0;i<message.length;i++) 
{ 
if(message[i].length>message[j].length) 
j=i; 
} 
ns6switch=1

var ns6=document.getElementById&&!document.all
mes=new Array();
mes[0]=-1;
mes[1]=-4;
mes[2]=-7;mes[3]=-10;
mes[4]=-7;
mes[5]=-4;
mes[6]=-1;
num=0;
num2=0;
txt="";

function jump0(){
if (ns6&&!ns6switch){
    
jumptext.innerHTML=message
return
}
  for(l=0;l<k[4];l++)
 {
if(message[l].length > 2){
for(i=0; i != message[l].length;i++){
txt=txt+"<span style='position:relative;' id='n"+i+"' ><b>"+message[l].charAt(i)+"</b></span>"};
jumptext[l].innerHTML=txt;
txt="";
}}
jump1a()


}

function jump1a(){
 
nfinal=(document.getElementById)? document.getElementById("n0") : document.all.n0
nfinal.style.left=-num2;
if(num2 != 9){
num2=num2+3;
setTimeout("jump1a()",50)
}
else{
jump1b()
}
}

function jump1b(){

nfinal.style.left=-num2;

jump2()

}


function jump2(){
txt="";
  for(l=0;l<k[4];l++)
 {
for(i=0;i != message[l].length;i++){
var colorcode = Math.round(0xffffff * Math.random()).toString(16);
if(i+num > -1 && i+num < 7){
txt=txt+"<span style='position:relative;color:#"+colorcode+";top:"+mes[i+num]+"px'></b>"+message[l].charAt(i)+"</b></span>"
}
else{txt=txt+"<span><b>"+message[l].charAt(i)+"</b></span>"}
}
jumptext[l].innerHTML=txt;
txt="";
}

if(num != (-message[j].length)){
num--;
setTimeout("jump2()",50)}
else{num=0;
setTimeout("jump0()",50)}
}

if (document.all||document.getElementById){
    var jumptext = new Array();
    for(m=0;m<k[4];m++)
 { 
jumptext[m]=(document.getElementById)? document.getElementById(arraydiv[m]) : document.all.arraydiv[m]
 }
jump0()
}
else
document.write(message)
}

/////////////////////// EFFECT 5 /////////////////////////////
k[5]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb5")!=-1)
    {
    arraydiv[k[5]]= strdiv;  
    k[5]++;
    }
 }
 var text5= new Array();
 for(l=0;l<k[5];l++)
 {
text5[l] = document.getElementById(arraydiv[l]);
 }
 if(k[5]!=0)
 {
     for(l=0;l<k[5];l++)
 {
 textWidth = text5[l].offsetWidth;
    text5[l].style.filter="wave(add=0, freq=4, light=2, phase=0px, strength=5px)";
    text5[l].style.width =  "120px";
 }
	var TimerID;
	var updown = true;
	var str = 1;

	function start()
	{
    
	  TimerID = window.setInterval( "wave()", 100 );
	}

	function wave()
	{
	  if ( str > 20 || str < 1 )
		updown = !updown;

	  if ( updown )
		str++;
	   else
		str--;
for(l=0;l<k[5];l++)
 {
    
    text5[l].filters( "wave" ).phase = str * 20;
    text5[l].filters( "wave" ).strength = str;
 
 }
	}

window.onload=start
}

///////////////////// EFFECT 6 ///////////////////////////
k[6]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb6")!=-1)
    {
    arraydiv[k[6]]= strdiv;  
    k[6]++;
    }
 }
var text6 = new Array();
for(l=0;l<k[6];l++)
 {
text6[l] = document.getElementById(arraydiv[l]);
 }
 if(k[6]!=0)
 {
var divs = new Array();
var da = document.all;
var start;

var speed = 50;

function initVars(){
for(l=0;l<k[6];l++)
 {
addDiv(text6[l],0,1,3);
}

startGlow();
}

function addDiv(id,color,min,max)
{
var j = divs.length;
divs[j] = new Array(5);
divs[j][0] = id;
divs[j][1] = color;
divs[j][2] = min;
divs[j][3] = max;
divs[j][4] = true;
}

function startGlow()
{
   
	for(var i=0;i<divs.length;i++)
	{
		divs[i][0].style.filter = "Glow(Color=" + divs[i][1] + ", Strength=" + divs[i][2] + ")";
		divs[i][0].style.width = "120px";
	}

	start = setInterval('update()',speed);
}

function update()
{
    
	for (var i=0;i<divs.length;i++)
	{
	
		if (divs[i][4])
		{
		
			divs[i][0].filters.Glow.Strength++;
			if (divs[i][0].filters.Glow.Strength == divs[i][3])
				divs[i][4] = false;
		}
	
		if (!divs[i][4])
		{
			divs[i][0].filters.Glow.Strength--;
			if (divs[i][0].filters.Glow.Strength == divs[i][2])
				divs[i][4] = true;
		}
	}
}
window.onLoad = initVars();
}

///////////////////////// EFFECT 7 //////////////////////////////////////
k[7]=0;
for(i=0;i<checkdivlength;i++)
 {
   strdiv = checkdiv[i].id;
     if(strdiv.search("fs_rb7")!=-1)
    {
    arraydiv[k[7]]= strdiv;  
    k[7]++;
    }
 }

 if(k[7]!=0)
 {
 var getdiv = new Array();
 for(l=0;l<k[7];l++)
 {
getdiv[l] = document.getElementById(arraydiv[l]);
}
var theText = new Array();
 for(l=0;l<k[7];l++)
 {
  text3= getdiv[l].innerHTML.replace(/(<([^>]+)>)/gi,'');
  getdiv[l].innerHTML = text3;    
theText[l]=getdiv[l].firstChild.data;

}
function nextSize(i,incMethod,textLength)
{
if (incMethod == 1) return (18*Math.abs( Math.sin(i/(textLength/2.5))) );
}

function sizeCycle(text,method,dis,theDiv)
{
   
     var colorcode = Math.round(0xffffff * Math.random()).toString(16);
	output = "";
	for (i = 0; i < text.length; i++)
	{
	  
		size = parseInt(nextSize(i +dis,method,text.length));
        output += "<font style='color:#"+colorcode+";font-size: "+ size +"px;font'>" +text.substring(i,i+1)+ "</font>";
	}
	theDiv.innerHTML = output;
}

function doWave(n) 
{   
    for(l=0;l<k[7];l++)
    {
	sizeCycle(theText[l],1,n,getdiv[l]);
  	if (n > theText[l].length) {n=0}
    }
  	setTimeout("doWave(" + (n+1) + ")", 60);
}

window.Onload=doWave(0);
}
 