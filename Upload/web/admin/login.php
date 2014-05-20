<html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <SCRIPT language=JavaScript>
       function checkInput()
           {

                   if (document.frmLogin.txtUser.value=="")
                {
                        alert("Bạn chưa gõ tên đăng nhập");
                        document.frmLogin.txtUser.focus();
                        return false;
                }

                if (document.frmLogin.txtPWD.value=="")
                {
                        alert("Bạn chưa nhập mật khẩu");
                        document.frmLogin.txtPWD.focus();
                        return false;
                }
                return true;
           }
         </script>
         <style type="text/css">
		 table{
			 border-collapse:collapse;
		 }
		 </style>
        </head>
        <body>
        <div align="center">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><br>
          </p>
          <table width="286" border="1">
            <form name="frmLogin" method="post" action="login_check.php" onSubmit="return checkInput();">
              <tr>
                <td colspan="2" align="left" bgcolor="#CCCCCC" class="content-sm"><p><strong>Login Vào Bảng Quản Trị</strong></p></td>
                </tr>
              <tr>
                <td width="116" align="left" class="input">Tên truy cập:</td>
                <td width="154" align="left" class="input">
                  <input type="text" name="txtUser" size="20" maxlength="30" class="textbox">
                </td>
                </tr>
              <tr>
                <td align="left" class="input"><span class="content-sm">Mật khẩu:</span></td>
                <td align="left" class="input">
                  <input type="password" name="txtPWD" size="20" maxlength="20" class="textbox">
                </td>
                </tr>
              <tr bgcolor="#CCCCCC">
                <td align="left" valign="top" class="text_normal">&nbsp;</td>
                <td align="left" valign="top" class="text_normal"><input type="submit" style="width=80px" name="Signin" value="Đăng nhập" class="button">
                  <input type="reset" name="Reset" value="Làm lại" class="button"></td>
                </tr> </form>
          </table>
        </div>
        <?php
        function no_injection($string)
			{
			$string = htmlspecialchars($string);
			$string = trim($string);
			$string = stripslashes($string);
			return $string;
			}
        if (isset($_GET['fall']) && (no_injection($_GET['fall']))=='1') {
        	echo "<script language='javascript'> alert('Sai username hoac mat khau'); </script>";
        }
        ?>
        </body>
</html>