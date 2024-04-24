<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

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

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">


<script>

   
$(document).ready(function(){
      $('#emailcheck').hide();
      $('#passlcheck').hide();
    

      var email_err=true;
      var pass_err=true;
 

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

   // Password




      
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


});


</script>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <h1 id="emailcheck"></h1>
      <input type="email" name="email" required placeholder="Enter Your Email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" id="email">
      <h1 id="passcheck"></h1>
      <input type="password" name="pass" required placeholder="Enter Your Password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" id="password">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>Don't Have An Account? <a href="register.php">Register Now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>