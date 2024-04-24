<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">




   <!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

   $(document).ready(function(){
      $('#namecheck').hide();
      $('#mobilecheck').hide();
      $('#emailcheck').hide();
      $('#msgcheck').hide();

      var name_err=true;
      var mobile_err=true;
      var email_err=true;
      var msg_err=true;
     
      $('#username').keyup(function(){
         name_check();
      });

      function name_check(){
         var nameStr=$('#username').val();
         // alert(nameStr);

         if(nameStr.length==""){
            $('#namecheck').show();
            $('#namecheck').html('<h1>*Please fill the name</h1>');
            $('#namecheck').focus();
            $('#namecheck').css('color','red');
            name_err=false;
            return false;
         }else{
            $('#namecheck').hide();
         }

         if((nameStr.length <3) ||(nameStr.length>10)){
            $('#namecheck').show();
            $('#namecheck').html('<h1>*Please name between 3 to 10 character</h1>');
            $('#namecheck').focus();
            $('#namecheck').css('color','red');
            name_err=false;
            return false;
         }else{
            $('#namecheck').hide();
         }
      };

// *****************************************Mobail

$('#num').keyup(function(){
         num_check();
      });

      function num_check(){
         var numStr=$('#num').val();
         // alert(nameStr);

         if(numStr.length==""){
            $('#mobilecheck').show();
            $('#mobilecheck').html('<h1>*Please fill the Moblie Number</h1>');
            $('#mobilecheck').focus();
            $('#mobilecheck').css('color','red');
            mobile_err=false;
            return false;
         }else{
            $('#mobilecheck').hide();
         }

         if((numStr.length<0) ||(numStr.length<10)){
            $('#mobilecheck').show();
            $('#mobilecheck').html('<h1>*Please fill the number between 1 to 10 character</h1>');
            $('#mobilecheck').focus();
            $('#mobilecheck').css('color','red');
            mobile_err=false;
            return false;
         }else{
            $('#mobilecheck').hide();
         }
      };


      //==================================================== Email validation=========================================================

      $('#email').keyup(function(){
         email_check();
      });

      function email_check(){
         var emailStr=$('#email').val();
         // alert(emailStr);

         if(emailStr.length==""){
            $('#emailcheck').show();
            $('#emailcheck').html('<h1>*Please fill the email</h1>');
            $('#emailcheck').focus();
            $('#emailcheck').css('color','red');
            email_err=false;
            return false;
         }else{
            $('#emailcheck').hide();
         }

         if((emailStr.length <3) ||(emailStr.length>20)){
            $('#emailcheck').show();
            $('#emailcheck').html('<h1>*Please name between 3 to 20 character</h1>');
            $('#emailcheck').focus();
            $('#emailcheck').css('color','red');
            email_err=false;
            return false;
         }else{
            $('#emailcheck').hide();
         }
      };



      // Message check================================================================

      $('#msg').keyup(function(){
         msg_check();
      });

      function msg_check(){
         var msgStr=$('#msg').val();
         // alert(msgStr);

         if(msgStr.length==""){
            $('#msgcheck').show();
            $('#msgcheck').html('<h1>*Please fill the massage</h1>');
            $('#msgcheck').focus();
            $('#msgcheck').css('color','red');
            msg_err=false;
            return false;
         }else{
            $('#msgcheck').hide();
         }
         // if((msgStr.length <3) ||(msgStr.length>10)){
         //    $('#msgcheck').show();
         //    $('#msgcheck').html('*Please character');
         //    $('#msgcheck').focus();
         //    $('#msgcheck').css('color','red');
         //    msg_err=false;
         //    return false;
         // }else{
         //    $('#msgcheck').hide();
         // }
      };



   });

</script>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>contact us</h3>
   <p><a href="home.php">home</a> <span> / contact</span></p>
</div>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>tell us something!</h3>

         <div id="namecheck"></div>
         <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required id="username">


         <div id="mobilecheck"></div>
         <input type="number" name="number" min="1" max="9999999999" class="box" placeholder="enter your number" required maxlength="10" id="num">

         <div id="emailcheck"></div>
         <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required  id="email">

         <div id="msgcheck"></div>
         <textarea name="msg" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10" id="msg"></textarea>


         <input type="submit" value="send message" name="send" class="btn">


      </form>

   </div>

</section>

<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->





<!-- custom js file link  -->
<script src="js/script.js"></script>


<script src="jquery-3.7.1.js"></script>
<!-- <script>
   $(document).ready(function(){
      alert("Hello");
   });
</script> -->

</body>
</html>