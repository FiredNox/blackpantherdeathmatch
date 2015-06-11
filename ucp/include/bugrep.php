<?php
//if "email" variable is filled out, send email
  if (isset($_REQUEST['email']))  {
  
  //Email information
  $admin_email = "report@firednox.com";
  $email = $_REQUEST['email'];
  $igname = $_REQUEST['igname'];
  $datum = $_REQUEST['datum'];
  $subject = $_REQUEST['subject'];
  $comment = $_REQUEST['comment'];
  
  //send email
  mail($admin_email, "$subject", $igname, $comment, "Kitöl:" . $email , $datum);
  
  //Email response
  echo "Köszönjük a jelentésed, amint tudunk hozzálátunk a hiba javításához";
  }
  
  else  {
	  

?>
 <center><form method="post">
  Játékbeli neved: <input name="igname" type="text" /><br />
  E-mail címed: <input name="email" type="text" /><br />
  A hiba megnevezése: <input name="subject" type="text" /><br />
  Dátum: <input name="datum" type="text" /><br />
  <br>
  <b>A hiba leírása:<b><br />
  <table border='0' style='width: 25%'>
  <td>
  <textarea name="comment" type="text" maxlength="256" rows="10" cols="80" ></textarea><br /></td></table>
  <input type="submit" value="Küldés" />
  </form></center>
<?php
  }
?>