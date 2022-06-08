<?php 
session_start();
$nameErr='';
if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $_SESSION["email"] = $email;
    $phone=$_POST['phone'];
    $pass=$_POST['password'];   
    $age=$_POST['age'];   
    $tmp=$_FILES['att']['tmp_name'];
    $fname=$_FILES['att']['name'];
    $ext=pathinfo($fname,PATHINFO_EXTENSION);
    if(empty($email) || empty($pass) || empty($name || empty($age)  || empty($phone) || empty($tmp))){
        $errMsg="Please fill the blank fields";
    }
    else if(!preg_match("/^[a-zA-Z ]+$/",$name)){
        $nameErr="Only alphabate is allow in name field";
     }
     else if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email)){
        $errMsg="Invalid email format";
     }
    else {
        if($ext=="jpg" || $ext=="png" || $ext=="gif" || $ext=="jpeg")//check the extension
        {
           if(is_dir("users/$email"))//check the user
           {
               $errMsg="Email already registerd";
           }
           else {
            mkdir("users/$email");//create user
               if(move_uploaded_file($tmp,"users/$email/$email".".jpg"))//upload image
               {
              
               file_put_contents("users/$email/details.txt","$name\n$pass\n$age\n$phone");//create file and store details
               header("location:welcome.php");//redirect to login
               }
               else {
                   $errMsg="Uploading error";
               }
           }
        }
        else {
            $errMsg="Only jpg | png | gif supported";
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
    <main class="container">
        <div class="p-5 my-4 bg-light rounded-3">
             <h1>Registration form</h1>
        </div>
        <section>
              <?php
               if(isset($errMsg))
               {
                 ?>
            <div class="alert alert-danger"><?= $errMsg;?></div>
                 <?php 
               }
               ?>
            <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                    <label> Full Name </label>
                    <input id="name" type="text" name="name" class="form-control" onkeyup="Validatename();"/>
                    <span id="nError" style="color: red"></span>
                    </div>
                <div class="form-group">
                    <label> Email </label>
                    <input id="email" type="email" name="email" class="form-control" onkeyup="ValidateEmail();"/>
                    <span id="eError" style="color: red"></span>
                </div>
                <div class="form-group">
                <label> Phone Number </label>
                     <input id="phone" type="text" name="phone" class="form-control" placeholder="" aria-label="Phone" onkeyup="Validatephone();">
               <span id="pError" style="color: red"></span>
               </div>
                <div class="form-group">
                    <label> Password </label>
                    <input type="password" name="password" class="form-control"/>
                </div>                
                <div class="form-group">
                    <label> Age </label>
                    <input type="text" name="age" class="form-control"/>
                </div>
                              
                <div class="form-group">
                    <label> Image </label>
                    <input type="file" name="att" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="register" name="register"/>
                   
                </div>
            </form>
        </section>
    </main>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <!--Client side validation-->
   <script type="text/javascript">
    function ValidateEmail() {
        var email = document.getElementById("email").value;
        var lblError = document.getElementById("eError");
        lblError.innerHTML = "";
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(email)) {
            lblError.innerHTML = "Invalid email address.";
        }
    }

    //Only chaeacters

    function Validatename() {
        var email = document.getElementById("name").value;
        var lblError = document.getElementById("nError");
        lblError.innerHTML = "";
        var expr =/^[a-zA-Z ]+$/;
        if (!expr.test(email)) {
            lblError.innerHTML = "Only alphabates allowed.";
        }
    }

    //Phone number

    function Validatephone() {
        var phone = document.getElementById("phone").value;
        var lblError = document.getElementById("pError");
        lblError.innerHTML = "";
        var expr =/^\d{10}$/;
        if (!expr.test(phone)) {
            lblError.innerHTML = "Please enter 10 digit number";
        }
    }

</script>

  </body>
</html>