<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    
    $password=md5($_POST['password']);
    $ret="select Email,MobileNumber from tbluser where Email=:email || MobileNumber=:mobno";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
    
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$sql="insert into tbluser(FullName,MobileNumber,Email,Password)Values(:fname,:mobno,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);

$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('You have successfully registered with us');</script>";
echo "<script>window.location.href ='signin.php'</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('Email-id or Mobile Number is already exist. Please try again');</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>ONSS || Signup</title>
   

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ONSS</h3>
                            </a>
                            <h3>Sign Up</h3>
                        </div>
                        <form id="signupForm" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" name="fname" id="fname" class="form-control" placeholder="Name" required>
                                <label for="floatingInput">Name</label>
                                <div id="fnameFeedback" class="invalid-feedback">Please enter your name.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="mobno" id="mobno" class="form-control" placeholder="Mobile Number" maxlength="10" pattern="[0-9]{10}" required>
                                <label for="floatingInput">Mobile Number</label>
                                <div id="mobnoFeedback" class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                                <label for="floatingInput">Email Address</label>
                                <div id="emailFeedback" class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <label for="floatingInput">Password</label>
                                <div id="passwordFeedback" class="invalid-feedback">Password must be at least 6 characters long.</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="signin.php">Already Registered !!</a>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="submit">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#spinner').fadeOut('slow');

            function validateName() {
    const name = $('#fname').val().trim();
    const nameRegex = /^[a-zA-Z]+$/; // Regular expression to match alphabets only

    if (name === '' || !nameRegex.test(name)) {
        $('#fname').addClass('is-invalid');
        return false;
    } else {
        $('#fname').removeClass('is-invalid').addClass('is-valid');
        return true;
    }
}


            function validateMobile() {
                const mobno = $('#mobno').val().trim();
                const mobnoPattern = /^[0-9]{10}$/;
                if (!mobnoPattern.test(mobno)) {
                    $('#mobno').addClass('is-invalid');
                    return false;
                } else {
                    $('#mobno').removeClass('is-invalid').addClass('is-valid');
                    return true;
                }
            }

            function validateEmail() {
                const email = $('#email').val().trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    $('#email').addClass('is-invalid');
                    return false;
                } else {
                    $('#email').removeClass('is-invalid').addClass('is-valid');
                    return true;
                }
            }

            function validatePassword() {
                const password = $('#password').val().trim();
                if (password.length < 6) {
                    $('#password').addClass('is-invalid');
                    return false;
                } else {
                    $('#password').removeClass('is-invalid').addClass('is-valid');
                    return true;
                }
            }

            $('#fname').on('input', validateName);
            $('#mobno').on('input', validateMobile);
            $('#email').on('input', validateEmail);
            $('#password').on('input', validatePassword);

            $('#signupForm').on('submit', function(e) {
                if (!validateName() || !validateMobile() || !validateEmail() || !validatePassword()) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>