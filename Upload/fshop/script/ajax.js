   function checkusername(itemtype,username,itemid)
{
        AJAX_Obj = new vB_AJAX_Handler(true);
        AJAX_Obj.onreadystatechange(ajaxcallcheckusername); 
	    AJAX_Obj.send('fshop/loadajax.php','itemtype=' + itemtype+'&username='+username+'&itemid='+itemid );
    
}
 
function ajaxcallcheckusername()
{
   divimgid = document.getElementById("ajaxloadimg"); 
        if (AJAX_Obj.handler.readyState == 4 && AJAX_Obj.handler.status == 200)
        {
      divimgid.innerHTML = AJAX_Obj.handler.responseText;
        }else
        {
      divimgid.innerHTML = "<img src='./fshop/image/progress.gif'>";  
        }
}  