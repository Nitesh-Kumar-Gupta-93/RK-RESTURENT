<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">


<script>



$(document).ready(function(){
      $('#namecheck').hide();
      $('#emailcheck').hide();
      $('#numcheck').hide();
      $('#passcheck').hide();
      $('#conpasscheck').hide();

      var name_err=true;
      var emai_err=true;
      var num_err=true;
      var pass_err=true;
      var conpass_err=true;
     
      $('#name').keyup(function(){
         name_check();
      });

      function name_check(){
         var nameStr=$('#name').val();
         // alert(nameStr);
         if(nameStr.length==""){
            $('#namecheck').show();
            $('#namecheck').html('*Please fill the name');
            $('#namecheck').focus();
            $('#namecheck').css('color','red');
            name_err=false;
            return false;
         }else{
            $('#namecheck').hide();
         }

         if((nameStr.length <3) ||(nameStr.length>10)){
            $('#namecheck').show();
            $('#namecheck').html('*Please name between 3 to 10 character');
            $('#namecheck').focus();
            $('#namecheck').css('color','red');
            name_err=false;
            return false;
         }else{
            $('#namecheck').hide();
         }
      };


      //second

      $('#email').keyup(function(){
         email_check();
      });

      function email_check(){
         var emailStr=$('#email').val();
         // alert(nameStr);
         if(emailStr.length==""){
            $('#emailcheck').show();
            $('#emailcheck').html('*Please fill the name');
            $('#emailcheck').focus();
            $('#emailcheck').css('color','red');
            email_err=false;
            return false;
         }else{
            $('#emailcheck').hide();
         }

         if((emailStr.length <3) ||(emailStr.length>10)){
            $('#emailcheck').show();
            $('#emailcheck').html('*Please name between 3 to 10 character');
            $('#emailcheck').focus();
            $('#emailcheck').css('color','red');
            email_err=false;
            return false;
         }else{
            $('#emailcheck').hide();
         }
      };


      // 3rd


      $('#num').keyup(function(){
         num_check();
      });

      function num_check(){
         var numStr=$('#num').val();
         // alert(nameStr);

         if(numStr.length==""){
            $('#mobilecheck').show();
            $('#mobilecheck').html('*Please fill the Moblie Number');
            $('#mobilecheck').focus();
            $('#mobilecheck').css('color','red');
            mobile_err=false;
            return false;
         }else{
            $('#mobilecheck').hide();
         }

         if((numStr.length<0) ||(numStr.length<10)){
            $('#mobilecheck').show();
            $('#mobilecheck').html('*Please fill the number between 1 to 10 character');
            $('#mobilecheck').focus();
            $('#mobilecheck').css('color','red');
            mobile_err=false;
            return false;
         }else{
            $('#mobilecheck').hide();
         }
      };

      // 4rth

      $('#password').keyup(function(){
         pass_check();
      });

      function pass_check(){
         var passStr=$('#password').val();
         // alert(nameStr);

         if(passStr.length==""){
            $('#passcheck').show();
            $('#passcheck').html('*Please fill the Password');
            $('#passcheck').focus();
            $('#passcheck').css('color','red');
            pass_err=false;
            return false;
         }else{
            $('#passcheck').hide();
         }

         if((passStr.length<0) ||(passStr.length<10)){
            $('#passcheck').show();
            $('#passcheck').html('*Please fill the number between 1 to 10 character');
            $('#passcheck').focus();
            $('#passcheck').css('color','red');
            pass_err=false;
            return false;
         }else{
            $('#passcheck').hide();
         }
      };

      // 5th


      $('#conpassword').keyup(function(){
         conpass_check();
      });

      function conpass_check(){
         var conpassStr=$('#conpassword').val();
         // alert(nameStr);

         if(conpassStr.length==""){
            $('#conpasscheck').show();
            $('#conpasscheck').html('*Please fill the Password');
            $('#conpasscheck').focus();
            $('#conpasscheck').css('color','red');
            conpass_err=false;
            return false;
         }else{
            $('#conpasscheck').hide();
         }

         if((conpassStr.length<3) ||(conpassStr.length<3)){
            $('#conpasscheck').show();
            $('#conpasscheck').html('*Please fill the number between 1 to 6 character');
            $('#conpasscheck').focus();
            $('#conpasscheck').css('color','red');
            conpass_err=false;
            return false;
         }else{
            $('#conpasscheck').hide();
         }
      };

});

</script>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <div id="namecheck"></div>
      <input type="text" name="name" required placeholder="enter your name" class="box" maxlength="50" id="name">
      <div id="emailcheck"></div>
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" id="email">
      <div id="mobilecheck"></div>
      <input type="number" name="number" required placeholder="enter your number" class="box" min="0" max="9999999999" maxlength="10" id="num">
      <div id="passcheck"></div>
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" id="password">
      <div id="conpasscheck"></div>
      <input type="password" name="cpass" required placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" id="conpassword">

      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>