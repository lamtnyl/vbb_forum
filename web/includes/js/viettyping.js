/*** Freeware Open Source writen by ngoCanh 4-2002 v. 7.3     */
/*** Original by Vietdev  http://vietdev.sourceforge.net      */
/*** Release 12.04.2002  R3.0                                 */
/*** The script is as literature and not copyright protected  */
/*** Please fair-play to keep the notice intact               */

/*** Modified by FrzzMan - vnOCzone.com                       */
/*** http://www.vnoczone.com                                  */
/*** Version: 1.1 Core VietTyping R3.0                        */
/*** The name changed to vozViet because I like it            */
/*** I AIN'T THE ORIGIN AUTHOR OF THIS TOOL                   */

var	TYPMOD=0;


// From here please don't change
var	ENGLISH=0, NOCHANGE=0, CODE, CHANGE=0;

function notWord(cc)
{
 return ("\ \r\n#,\\;.:-_()<>+-*/=?!\"§$%{}[]\'~|^°€ß²³\@\&".indexOf(cc)>=0);
}

function viewViet(obj,key)
{
	obj.focus();

	var caret=obj.document.selection.createRange();
	var caret2=caret.duplicate();
	var wrd="", i=0, chrx, len ;
	while(1)
	{
		caret2.moveStart("character", -1);
		obj.curword=caret2.duplicate();
		len=obj.curword.text.length
		if(len==wrd.length) break;
		wrd=obj.curword.text
		chrx=wrd.substring(0,1);
		if(notWord(chrx))
		{
			if(chrx.charCodeAt(0)==13) wrd=wrd.substr(2);
			else wrd=wrd.substr(1);
			break;
		}
		i++;
	}

	wrd=toViet(wrd,key);

	caret.moveStart("character", -i);
	obj.curword=caret.duplicate();
	obj.curword.text=wrd;
}

function	toViet(str1,key)
{
		if(ENGLISH) return str1;

		var c2= key
		if( (TYPMOD==1 && isNaN(c2)) || (TYPMOD==2 && !isNaN(c2)) ) return str1

		var c3=c2.toUpperCase();
		if( !str1 ) return str1 ;

		//*** TELEX ***
		var sx=''
		if(TYPMOD==2 || TYPMOD==0)
		{
				 if(c3=='D') sx=UNIDD(str1,c2)
		else if(c3=='A') sx=UNIAA(str1,c2)
		else if(c3=='E') sx=UNIEE(str1,c2)
		else if(c3=='O') sx=UNIOO(str1,c2)
		else if(c3=='W') sx=UNIWW(str1,c2)
		else if(c3=='S') sx=UNISS(str1,c2)
		else if(c3=='F') sx=UNIFF(str1,c2)
		else if(c3=='R') sx=UNIRR(str1,c2)
		else if(c3=='X') sx=UNIXX(str1,c2)
		else if(c3=='J') sx=UNIJJ(str1,c2)
		}

		//*** VNI
		if(TYPMOD==1 || TYPMOD==0)
		{
				 if(c3=='9') sx=UNIDD(str1,c2)
		else if(c3=='6')
		{
			sx=UNIAA(str1,c2);
			if(!CODE) sx=UNIEE(str1,c2);
			if(!CODE) sx=UNIOO(str1,c2);
		}
		else if(c2=='1') sx=UNISS(str1,c2)
		else if(c2=='2') sx=UNIFF(str1,c2)
		else if(c2=='3') sx=UNIRR(str1,c2)
		else if(c2=='4') sx=UNIXX(str1,c2)
		else if(c2=='5') sx=UNIJJ(str1,c2)
		else if(c3=='7'|| c3=='8') sx=UNIWW(str1,c2)
	}

	if(TYPMOD==0 && c2=='0') sx=UNI00(str1,c2)
	else if(c3=='Z'|| c2=='0') sx=UNIZZ(str1,c2)

	if(sx!=''){ CHANGE=1;  str1=sx }

	return str1;
}

function UNI(str1,key,codeA)
{
	var codeH=new Array();
	for(var i=0;i<codeA.length-1;i+=2) codeH[codeA[i]]=codeA[i+1];

	var lenX=str1.length
	var sX1, sX2, c1X, c2X, c3X, c4X, code, code1, first=1;
	var ACCENT= 'sfrxjSFRXJ12345'.indexOf(key)>=0
	CODE=''
	for(var i=lenX;i>=0;i--)
	{
		sX1=str1.substring(0,i-1)
		sX2=str1.substring(i,lenX)
		c1X=str1.substring(i-1,i); code2=c1X.charCodeAt(0) ;
		c2X=str1.substring(i-2,i-1); code=c2X.charCodeAt(0) ;
		c3X=str1.substring(i-3,i-2); code1=c3X.charCodeAt(0) ;
		c4X=(c3X+c2X).toLowerCase() ;

	/**************** typing assistance *****************/
	if( !key&&(code1==432||code1==431)&&(code==417||code==416) ) // Z+0 and u'o' -> undo
		{
			c3X= (code1==432) ? 'u':'U'; c2X= (code==417) ? 'o':'O' ; CODE=1;
			return sX1.substring(0,sX1.length-2)+c3X+c2X+c1X+sX2
		}

		if(key&&'wW7'.indexOf(key)>=0)
		{
			if(c4X=='uo') // uon
			{
				 c3X= (c3X=='u') ? 432:431 ; c2X= (c2X=='o') ? 417:416; CODE=1;
				return sX1.substring(0,sX1.length-2)+String.fromCharCode(c3X)+String.fromCharCode(c2X)+c1X+sX2
			}
			if('aA'.indexOf(c1X)>=0 && (i<lenX||c4X=='qu') ) {} // qua
			else if( c2X && 'oO'.indexOf(c2X)>=0 && 'uU'.indexOf(c1X)>=0) // ou by no' u'
			{ continue }
			else if( c2X && 'uU'.indexOf(c2X)>=0 && 'uUaA'.indexOf(c1X)>=0) // uu, ua
			{ continue }
			else if( c2X && 'aA'.indexOf(c2X)>=0 && 'uU'.indexOf(c1X)>=0) // au
			{
				c2X= (c2X=='a') ? 226:194; CODE=1; // a^ , A^
				return sX1.substring(0,sX1.length-1)+String.fromCharCode(c2X)+c1X+sX2
			}
		}

		if( c4X=='gi' && c1X && 'aAuU'.indexOf(c1X)>=0 ) {}
		else if( c2X && c1X && 'iI'.indexOf(c2X)>=0 && 'aAuU'.indexOf(c1X)>=0 )continue // ia,iu
		else if( ('aAiIyY'.indexOf(c1X)>=0 && (i<lenX||c4X=='qu') ) || (c2X && 'iI'.indexOf(c2X)>=0) ){} // --qua, qui, quy , ia, i..
		else if( ACCENT && 'oO'.indexOf(c1X)>=0 && c2X && 'uU'.indexOf(c2X)>=0 ){} // uo and ACCENT
		else if( ACCENT && first && 'aAiIoOuUyY'.indexOf(c1X)>=0 && !('aA'.indexOf(c1X)>=0 && i<lenX) )
		 { first=0; continue }
	/**************** end typing assistance *****************/

	CODE=codeH[c1X.charCodeAt(0)]
	if(CODE) break;
	if(!CODE && !first){ ACCENT=0; first=1; i=lenX+1; continue}
	}

 if(!CODE) return str1+key
 if(isNaN(CODE)){str1=sX1+CODE+sX2+key;ENGLISH=1}
 else str1=sX1+String.fromCharCode(CODE)+sX2;
 return str1;
}

/****************	U N I C O D E *************************/

function UNIDD(str1,key)
{
	var codeA=new Array(100,273,68,272,273,'d',272,'D');
	return UNI(str1,key,codeA);
}

function UNIAA(str1,key)
{
	var codeA=new Array(97,226,65,194,226,'a',194,'A',
											259,226,7855,7845,7857,7847,7859,7849,7861,7851,7863,7853,
											258,194,7854,7844,7856,7846,7858,7848,7860,7850,7862,7852,
											225,7845,224,7847,7843,7849,227,7851,7841,7853,
											193,7844,192,7846,7842,7848,195,7850,7840,7852
											);
	return UNI(str1,key,codeA);
}

function UNIWW(str1,key)
{
	var codeA=new Array(97,259,65,258,111,417,79,416,117,432,85,431,
											259,'a',258,'A',417,'o',416,'O',432,'u',431,'U',
											226,259,7845,7855,7847,7857,7849,7859,7851,7861,7853,7863,
											194,258,7844,7854,7846,7856,7848,7858,7850,7860,7852,7862,
											244,417,7889,7899,7891,7901,7893,7903,7895,7905,7897,7907,
											212,416,7888,7898,7890,7900,7892,7902,7894,7904,7896,7906,
											225,7855,224,7857,7843,7859,227,7861,7841,7863,
											193,7854,192,7856,7842,7858,195,7860,7840,7862,
											250,7913,249,7915,7911,7917,361,7919,7909,7921,
											218,7912,217,7914,7910,7916,360,7918,7908,7920,
											243,7899,242,7901,7887,7903,245,7905,7885,7907,
											211,7898,210,7900,7886,7902,213,7904,7884,7906
											);
	return UNI(str1,key,codeA)
}

function UNIEE(str1,key)
{
	var codeA=new Array(101,234,69,202,234,'e',202,'E',
											233,7871,232,7873,7867,7875,7869,7877,7865,7879,
											201,7870,200,7872,7866,7874,7866,7876,7864,7878
											);
	return UNI(str1,key,codeA)
}

function UNIOO(str1,key)
{
	var codeA=new Array(111,244,79,212,244,'o',212,'O',
											417,244,7899,7889,7901,7891,7903,7893,7905,7895,7907,7897,
											416,212,7898,7888,7900,7890,7902,7892,7904,7894,7906,7896,
											243,7889,242,7891,7887,7893,245,7895,7885,7897,
											211,7888,210,7890,7886,7892,213,7894,7884,7896
											);
	return UNI(str1,key,codeA)
}

function UNISS(str1,key)
{
	var codeA=new Array(65,193,192,193,7842,193,195,193,7840,193,
											97,225,224,225,7843,225,227,225,7841,225,
											258,7854,7856,7854,7858,7854,7860,7854,7862,7854,
											259,7855,7857,7855,7859,7855,7861,7855,7863,7855,
											194,7844,7846,7844,7848,7844,7850,7844,7852,7844,
											226,7845,7847,7845,7849,7845,7851,7845,7853,7845,
											69,201,200,202,7866,202,7868,202,7864,202,
											101,233,232,233,7867,233,7869,233,7865,233,
											202,7870,7872,7870,7874,7870,7876,7870,7878,7870,
											234,7871,7873,7871,7875,7871,7877,7871,7879,7871,
											73,205,204,205,7880,205,296,205,7882,205,
											105,237,236,237,7881,237,297,237,7883,237,
											79,211,210,211,7886,211,213,211,7884,211,
											111,243,242,243,7887,243,245,243,7885,243,
											212,7888,7890,7888,7892,7888,7894,7888,7896,7888,
											244,7889,7891,7889,7893,7889,7895,7889,7897,7889,
											416,7898,7900,7898,7902,7898,7904,7898,7906,7898,
											417,7899,7901,7899,7903,7899,7905,7899,7907,7899,
											85,218,217,218,7910,218,360,218,7908,218,
											117,250,249,250,7911,250,361,250,7909,250,
											431,7912,7914,7912,7916,7912,7918,7912,7920,7912,
											432,7913,7915,7913,7917,7913,7919,7913,7921,7913,
											89,221,7922,221,7926,221,7928,221,7924,221,
											121,253,7923,253,7927,253,7929,253,7925,253,
											193,'A',225,'a',201,'E',233,'e',205,'I',237,'i',
											211,'O',243,'o',218,'U',250,'u',221,'Y',253,'y'
											);
	return UNI(str1,key,codeA);
}

function UNIFF(str1,key)
{
	var codeA=new Array(65,192,193,192,7842,192,195,192,7840,192,
											97,224,225,224,7843,224,227,224,7841,224,
											258,7856,7854,7856,7858,7856,7860,7856,7862,7856,
											259,7857,7855,7857,7859,7857,7861,7857,7863,7857,
											194,7846,7844,7846,7848,7846,7850,7846,7852,7846,
											226,7847,7845,7847,7849,7847,7851,7847,7853,7847,
											69,200,201,200,7866,200,7868,200,7864,200,
											101,232,233,232,7867,232,7869,232,7865,232,
											202,7872,7870,7872,7874,7872,7876,7872,7878,7872,
											234,7873,7871,7873,7875,7873,7877,7873,7879,7873,
											73,204,205,204,7880,204,296,204,7882,204,
											105,236,237,236,7881,236,297,236,7883,236,
											79,210,211,210,7886,210,213,210,7884,210,
											111,242,243,242,7887,242,245,242,7885,242,
											212,7890,7888,7890,7892,7890,7894,7890,7896,7890,
											244,7891,7889,7891,7893,7891,7895,7891,7897,7891,
											416,7900,7898,7900,7902,7900,7904,7900,7906,7900,
											417,7901,7899,7901,7903,7901,7905,7901,7907,7901,
											85,217,218,217,7910,217,360,217,7908,217,
											117,249,250,249,7911,249,361,249,7909,249,
											431,7914,7912,7914,7916,7914,7918,7914,7920,7914,
											432,7915,7913,7915,7917,7915,7919,7915,7921,7915,
											89,7922,221,7922,7926,7922,7928,7922,7924,7922,
											121,7923,253,7923,7927,7923,7929,7923,7925,7923,
											192,'A',224,'a',200,'E',232,'e',204,'I',236,'i',
											210,'O',242,'o',217,'U',249,'u',7922,'Y',7923,'y'
											);
	return UNI(str1,key,codeA);
}



function UNIRR(str1,key)
{
	var codeA=new Array(65,7842,193,7842,192,7842,195,7842,7840,7842,
											97,7843,225,7843,224,7843,227,7843,7841,7843,
											258,7858,7854,7858,7856,7858,7860,7858,7862,7858,
											259,7859,7855,7859,7857,7859,7861,7859,7863,7859,
											194,7848,7844,7848,7846,7848,7850,7848,7852,7848,
											226,7849,7845,7849,7847,7849,7851,7849,7853,7849,
											69,7866,201,7866,200,7866,7868,7866,7864,7866,
											101,7867,233,7867,232,7867,7869,7867,7865,7867,
											202,7874,7870,7874,7872,7874,7876,7874,7878,7874,
											234,7875,7871,7875,7873,7875,7877,7875,7879,7875,
											73,7880,205,7880,204,7880,296,7880,7882,7880,
											105,7881,237,7881,236,7881,297,7881,7883,7881,
											79,7886,211,7886,210,7886,213,7886,7884,7886,
											111,7887,243,7887,242,7887,245,7887,7885,7887,
											212,7892,7888,7892,7890,7892,7894,7892,7896,7892,
											244,7893,7889,7893,7891,7893,7895,7893,7897,7893,
											416,7902,7898,7902,7900,7902,7904,7902,7906,7902,
											417,7903,7899,7903,7901,7903,7905,7903,7907,7903,
											85,7910,218,7910,217,7910,360,7910,7908,7910,
											117,7911,250,7911,249,7911,361,7911,7909,7911,
											431,7916,7912,7916,7914,7916,7918,7916,7920,7916,
											432,7917,7913,7917,7915,7917,7919,7917,7921,7917,
											89,7926,221,7926,7922,7926,7928,7926,7924,7926,
											121,7927,253,7927,7923,7927,7929,7927,7925,7927,
											7842,'A',7843,'a',7866,'E',7867,'e',7880,'I',7881,'i',
											7886,'O',7887,'o',7910,'U',7911,'u',7926,'Y',7927,'y'
											);
	return UNI(str1,key,codeA);
}

function UNIXX(str1,key)
{
	var codeA=new Array(65,195,193,195,192,195,7842,195,7840,195,
											97,227,225,227,224,227,7843,227,7841,227,
											258,7860,7854,7860,7856,7860,7858,7860,7862,7860,
											259,7861,7855,7861,7857,7861,7859,7861,7863,7861,
											194,7850,7844,7850,7846,7850,7848,7850,7852,7850,
											226,7851,7845,7851,7847,7851,7849,7851,7853,7851,
											69,7868,201,7868,200,7868,7866,7868,7864,7868,
											101,7869,233,7869,232,7869,7867,7869,7865,7869,
											202,7876,7870,7876,7872,7876,7874,7876,7878,7876,
											234,7877,7871,7877,7873,7877,7875,7877,7879,7877,
											73,296,205,296,204,296,7880,296,7882,296,
											105,297,237,297,236,297,7881,297,7883,297,
											79,213,211,213,210,213,7886,213,7884,213,
											111,245,243,245,242,245,7887,245,7885,245,
											212,7894,7888,7894,7890,7894,7892,7894,7896,7894,
											244,7895,7889,7895,7891,7895,7893,7895,7897,7895,
											416,7904,7898,7904,7900,7904,7902,7904,7906,7904,
											417,7905,7899,7905,7901,7905,7903,7905,7907,7905,
											85,360,218,360,217,360,7910,360,7908,360,
											117,361,250,361,249,361,7911,361,7909,361,
											431,7918,7912,7918,7914,7918,7916,7918,7920,7918,
											432,7919,7913,7919,7915,7919,7917,7919,7921,7919,
											89,7928,221,7928,7922,7928,7926,7928,7924,7928,
											121,7929,253,7929,7923,7929,7927,7929,7925,7929,
											195,'A',227,'a',7868,'E',7869,'e',296,'I',297,'i',
											213,'O',245,'o',360,'U',361,'u',7928,'Y',7929,'y'
											);
	return UNI(str1,key,codeA);
}

function UNIJJ(str1,key)
{
	var codeA=new Array(65,7840,193,7840,192,7840,7842,7840,195,7840,
											97,7841,225,7841,224,7841,7843,7841,227,7841,
											258,7862,7854,7862,7856,7862,7858,7862,7860,7862,
											259,7863,7855,7863,7857,7863,7859,7863,7861,7863,
											194,7852,7844,7852,7846,7852,7848,7852,7850,7852,
											226,7853,7845,7853,7847,7853,7849,7853,7851,7853,
											69,7864,201,7864,200,7864,7866,7864,7868,7864,
											101,7865,233,7865,232,7865,7867,7865,7869,7865,
											202,7878,7870,7878,7872,7878,7874,7878,7876,7878,
											234,7879,7871,7879,7873,7879,7875,7879,7877,7879,
											73,7882,205,7882,204,7882,7880,7882,296,7882,
											105,7883,237,7883,236,7883,7881,7883,297,7883,
											79,7884,211,7884,210,7884,7886,7884,213,7884,
											111,7885,243,7885,242,7885,7887,7885,245,7885,
											212,7896,7888,7896,7890,7896,7892,7896,7894,7896,
											244,7897,7889,7897,7891,7897,7893,7897,7895,7897,
											416,7906,7898,7906,7900,7906,7902,7906,7904,7906,
											417,7907,7899,7907,7901,7907,7903,7907,7905,7907,
											85,7908,218,7908,217,7908,7910,7908,360,7908,
											117,7909,250,7909,249,7909,7911,7909,361,7909,
											431,7920,7912,7920,7914,7920,7916,7920,7918,7920,
											432,7921,7913,7921,7915,7921,7917,7921,7919,7921,
											89,7924,221,7924,7922,7924,7926,7924,7928,7924,
											121,7925,253,7925,7923,7925,7927,7925,7929,7925,
											7840,'A',7841,'a',7864,'E',7865,'e',7882,'I',7883,'i',
											7884,'O',7885,'o',7908,'U',7909,'u',7924,'Y',7925,'y'
											);
	return UNI(str1,key,codeA);
}

function UNIZZ(str1,key)
{
 var codeA=new Array(193,65,192,65,7842,65,195,65,7840,65,
										 225,97,224,97,7843,97,227,97,7841,97,
										 7854,258,7856,258,7858,258,7860,258,7862,258,
										 7855,259,7857,259,7859,259,7861,259,7863,259,
										 7844,194,7846,194,7848,194,7850,194,7852,194,
										 7845,226,7847,226,7849,226,7851,226,7853,226,
										 201,69,200,69,7866,69,7868,69,7864,69,
										 233,101,232,101,7867,101,7869,101,7865,101,
										 7870,202,7872,202,7874,202,7876,202,7878,202,
										 7871,234,7873,234,7875,234,7877,234,7879,234,
										 205,73,204,73,7880,73,296,73,7882,73,
										 237,105,236,105,7881,105,297,105, 7883,105,
										 211,79,210,79,7886,79,213,79,7884,79,
										 243,111,242,111,7887,111,245,111,7885,111,
										 7888,212,7890,212,7892,212,7894,212,7896,212,
										 7889,244,7891,244,7893,244,7895,244,7897,244,
										 7898,416,7900,416,7902,416,7904,416,7906,416,
										 7899,417,7901,417,7903,417,7905,417,7907,417,
										 218,85,217,85,7910,85,360,85,7908,85,
										 250,117,249,117,7911,117,361,117,7909,117,
										 7912,431,7914,431,7916,431,7918,431,7920,431,
										 7913,432,7915,432,7917,432,7919,432,7921,432,
										 221,89,7922,89,7926,89,7928,89,7924,89,
										 253,121,7923,121,7927,121,7929,121,7925,121,
										 273,'d',272,'D',226,'a',259,'a',194,'A',258,'A',
										 234,'e',202,'E',244,'o',417,'o',212,'O',416,'O',
										 432,'u',431,'U'
										 );

	var str1=UNI(str1,'',codeA);
	ENGLISH=0;
	if(!CODE) return str1+key
	return str1;
}

function UNI00(str1,key)
{
 var codeA=new Array(7845,225,7847,224,7849,7843,7851,227,7853,7841,
										 7844,193,7846,192,7848,7842,7850,195,7852,7840,
										 7855,225,7857,224,7859,7843,7861,227,7863,7841,
										 7854,193,7856,192,7858,7842,7860,195,7862,7840,
										 7889,243,7891,242,7893,7887,7895,245,7897,7885,
										 7888,211,7890,210,7892,7886,7894,213,7896,7884,
										 7899,243,7901,242,7903,7887,7905,245,7907,7885,
										 7898,211,7900,242,7902,7886,7904,213,7906,7884,
										 7871,233,7873,232,7875,7867,7877,7869,7879,7865,
										 7870,201,7872,200,7874,7866,7876,7868,7878,7864,
										 7913,250,7915,249,7917,7911,7919,361,7921,7909,
										 7912,218,7914,217,7916,7910,7918,360,7920,7908,
										 273,'d',272,'D',
										 226,'a',259,'a',234,'e',244,'o',417,'o',432,'u',
										 194,'A',258,'A',202,'E',212,'O',416,'O',431,'U',
										 225,'a',224,'a',7843,'a',227,'a',7841,'a',193,'A',192,'A',7842,'A',195,'A',7840,'A',
										 233,'e',232,'e',7867,'e',7869,'e',7865,'e',201,'E',200,'E',7866,'E',7868,'E',7864,'E',
										 237,'i',236,'i',7881,'i',297,'i',7883,'i',205,'I',204,'I',7880,'I',296,'I',7882,'I',
										 243,'o',242,'o',7887,'o',245,'o',7885,'o',211,'O',210,'O',7886,'O',213,'O',7884,'O',
										 250,'u',249,'u',7911,'u',361,'u',7909,'u',218,'U',217,'U',7910,'U',360,'U',7908,'U',
										 253,'y',7923,'y',7927,'y',7929,'y',7925,'y',221,'Y',7922,'Y',7926,'Y',7928,'Y',7924,'Y'
										 );

	var str1=UNI(str1,'',codeA);
	ENGLISH=0;
	if(!CODE) return str1+key
	return str1;
}



/**************************************/
document.onclick=function(){ENGLISH=0; printStatus()}
document.onkeypress=doKeypress
document.onkeydown=doKeydown


function keyDownInit(key)
{
	if(key==32||key==13||key==8) ENGLISH=0;

	if(key==120){ TYPMOD++ ; TYPMOD %= 5 } // F9=0/1/2=AUTO/VNI/TELEX
	printStatus()
}

function doKeydown()
{
	var key=event.keyCode
	keyDownInit(key)
}

function keyPressInit(key,obj)
{
	if(TYPMOD == 4 || ENGLISH)return;
	if(NOCHANGE){ NOCHANGE=0;return; }

	var chr= String.fromCharCode(key);
	var chr1= chr.toUpperCase();

	if('SFRXJDAEOWZ1234567890'.indexOf(chr1)>=0) viewViet(obj,chr)
}

function doKeypress()
{
	var el=event.srcElement
	if(el.type=='text'||el.type=='textarea') keyPressInit(event.keyCode,el)

	if(CHANGE){ CHANGE=0; return false; }// abort
	else return true;  // no abort
}

function printStatus()
{
			 if(TYPMOD==4) status='English - Nhấn F9 để dùng bộ gõ tự động, VNI và Telex đều được'
	else if(TYPMOD==0) status='Tự động - Nhấn F9 để đổi sang VNI'
	else if(TYPMOD==1) status='VNI - Nhấn F9 để đổi sang Telex'
	else if(TYPMOD==2) status='Telex - Nhấn F9 để đổi sang VIQR'
	else if(TYPMOD==3) status='VIQR - Nhấn F9 để tắt bộ gõ tiếng Việt'
}
var TempMod = 0;//Để lưu lại kiểu gõ trước khi chuyển sang ENGLISH

function NoV() {
    TempMod = TYPMOD;
    TYPMOD = 4;//Chuyển sang ENG
}
    
function ReturnMOD() {
    TYPMOD = TempMod;//Trả về lại kiểu gõ trước đó
}  

//--------------------------------------
var TempMod = 0;//Để lưu lại kiểu gõ trước khi chuyển sang ENGLISH

function NoViet() {
    TempMod = TYPMOD;
    TYPMOD = 4;//Chuyển sang ENG
}
    
function ReturnMOD() {
    TYPMOD = TempMod;//Trả về lại kiểu gõ trước đó
}  
