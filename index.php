<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Subscribe to our newsletter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ChimpChamp">

    <!-- Le styles -->
    </head>

    <body>
<header id="header" class="navbar navbar-fixed-top">
      <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
          <div class="container">
      </div>
        </div>
  </div>
    </header>
<div class="container"> 
  <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'email_error'){?>
      <p style="color:red;font-size:10px">The email entered is invalid</p>
  <?php }?>
  <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'success'){?>
    <p style="color:green;font-size:10px">You have been subscribed successfully!</p>
  <?php } ?>
  <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'update'){?>
    <p style="color:green;font-size:10px">You're already subscribed to this list.</p>
  <?php } ?>
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div id="login_form">
    <form action="mailchimp_action.php" method="post" class="">
          <input type="hidden" value="" name="action">
          First Name: <input type="text" value="" name="fname"><br>
          Email: <input type="text" value="" name="email"><br>
          <input type="submit" value="Submit" class="btn">
        </form>
  </div>
      <hr>
      <footer>
    <p>&copy; 2013</p>
  </footer>
    </div>
<!-- /container --> 

<!-- Le javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
</body>
</html>
