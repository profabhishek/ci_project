<!DOCTYPE html>  
<html>
<head>
<title>Send Message</title>
</head>
 
<body>
	<form method="post" action="<?php echo base_url(); ?>Message_send/message">
	 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<table width="600" border="1" cellspacing="5" cellpadding="5">
 <tr>
    <td>Enter Your Mobile </td>
    <td><input type="text" name="phone"/></td>
  </tr>

<tr>
    <td>Enter Your Message</td>
   <td><textarea rows="4" cols="50" name="message">

</textarea></td>
  </tr>

 <tr>
    <td colspan="2" align="center"><input type="submit" name="save" value="Save Data"/></td>
 </tr>
</table>
 
</form>
</body>
</html>