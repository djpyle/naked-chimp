<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Subscribe to our newsletter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ChimpChamp.com">
    </head>
<body>

    <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'email_error'){?>
        <p style="color:red;font-size:14px">The email entered is invalid</p>
    <?php }?>
    <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'success'){?>
        <p style="color:green;font-size:14px">You have been subscribed successfully!</p>
    <?php } ?>
    <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'update'){?>
        <p style="color:green;font-size:14px">You're already subscribed to this list.</p>
    <?php } ?>

<!-- If your opt-in form is not in the same directory as the rest of the scripts,
replace the form action below with the full path to mailchimp_action.php -->

    <form action="mailchimp_action.php" method="post" class="">
        <input type="hidden" value="" name="action">
        First Name: <input type="text" value="" name="fname"><br>
        Email: <input type="text" value="" name="email"><br>
        <input type="submit" value="Submit" class="btn">
    </form>

</body>
</html>
