<?php
$buttonallow = "fontselect;fontsizeselect;bold;italic;underline;strikethrough;justifyleft,justifycenter,justifyright;link,unlink;forecolor;backcolor";
$arraybutton = explode(";",$buttonallow);
$checkbutton = explode(",",$settingitem);
$getbutton =array();

 for($i=1;$i<count($checkbutton);$i++)
   {
     if($checkbutton[$i]==0)
       {
        continue;
       }
     $getbutton[]=$arraybutton[$i-1];   
   }
$savebutton = implode(",",$getbutton);

if ($checkbutton[13]==1)
   {
    $ajaxbox="<input type='text' id='getusername' name='getusername' class='primary textbox' size='20' onKeyUp='checkusername($itemtype,this.value,$getitem)'>";
   }else
   {
  $ajaxbox="<input type='text' id='getusername' name='getusername' class='primary textbox' size='20'>";
      
   } 
  if($checkbutton[0]!=0)
    {
  
$script = "<script type='text/javascript' src='fshop/script/tinymce/tiny_mce.js'></script>
<script type='text/javascript'>
	tinyMCE.init({
		mode : 'textareas',
		theme : 'advanced',
        theme_advanced_buttons1 : '$savebutton',
        theme_advanced_buttons2 : '',
        theme_advanced_buttons3 : '',
        theme_advanced_toolbar_location : 'top',
 
                         plugins : 'paste',
                    paste_preprocess : function(pl, o) {
                    o.content = o.content.replace(/(<([^>]+)>)/gi,'');
                },
                
                
          setup : function(ed) {
        maxlimit = $checkbutton[11];    
           
    ed.onKeyUp.addToTop(function() {
       
     idbox= tinyMCE.get('changeboxfshop').getContent();
     
      displaybox= document.getElementById('displaybox');
 if (idbox.length > maxlimit)
 {
 tinyMCE.get('changeboxfshop').setContent('');
 alert('Max Limit Characters');
 }
else
{
displaybox.value = maxlimit - idbox.length;
}
});      

     ed.onKeyDown.addToTop(function() {
    idbox= tinyMCE.get('changeboxfshop').getContent();
    displaybox= document.getElementById('displaybox');
 if (idbox.length > maxlimit)
 {
 getold =  idbox.substring(0, maxlimit);
 tinyMCE.get('changeboxfshop').setContent(getold);
}
else
{
displaybox.value = maxlimit - idbox.length;
}
});    
   ed.onChange.addToTop(function() {
    idbox= tinyMCE.get('changeboxfshop').getContent();
    displaybox= document.getElementById('displaybox');
 if (idbox.length > maxlimit)
 {
 getold =  idbox.substring(0, maxlimit);
 tinyMCE.get('changeboxfshop').setContent(getold);
}
else
{
displaybox.value = maxlimit - idbox.length;
}
});    


           
      ed.onKeyPress.addToTop(function(ed, e) {
    if ((e.charCode == 13 || e.keyCode == 13)) {
        return tinymce.dom.Event.cancel(e);
    }
});      
} 

	});
 </script>
 <b>+ Input Username : </b> $ajaxbox
 <span id='ajaxloadimg'></span> 
 <BR><Br>
 <textarea id='changeboxfshop' name='changeboxfshop' rows='2' cols='100'>
</textarea><br><input type='text' id='displaybox' class='primary textbox' value='Characters' size='10' disabled>
 ";
    }else
    {
$script="
<Script>
maxlimit =  $checkbutton[11];  
function textCounter() {
field = document.getElementById('changeboxfshop');
cntfield = document.getElementById('displaybox');
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else
cntfield.value = maxlimit - field.value.length;
}
</script>
<table>
<tr>
 <td width='30%'><b>+ Input Username  </b></td><td>$ajaxbox
 <span id='ajaxloadimg'></span> </td>
 </tr>
 
 <BR>
 <tr>
 <td width='30%'>
<b>+ Change Title</b>  </td><td><input type='text' id='changeboxfshop' name='changeboxfshop' class='primary textbox' size='50' onKeyDown='textCounter()'
onKeyUp='textCounter()'></></tD>
</tr>
<tr>
 <td width='30%'></td>
 <td>
<br><input type='text' id='displaybox' class='primary textbox' value='Characters' size='10' disabled> 
</tD></tr>
</table>
";        
    }
$displayusing ="$script
<input type='hidden' name='hiditem1' value='$checkbutton[0]'>
<input type='hidden' name='hiditem11' value='$checkbutton[11]'>
";

?>
