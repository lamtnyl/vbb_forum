
  function totalgold(gold,amount)
  {
    if(isNaN(amount) || amount <=0)
     {
     alert("Please input a right number");  
     document.getElementById("submitfshop").disabled="disabled";
     }else
     {
   var total = gold*amount;
    document.getElementById("totalfgold").value=total;
    document.getElementById("submitfshop").disabled="";
     } 
  }  
  

