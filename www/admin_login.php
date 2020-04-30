<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>ISA Admin Login</title>
    <!-- main page icon -->
    <link rel="shortcut icon" href="https://miamioh.edu/fbs/_files/images/page-content/controller/staff/block-m.jpg" >

    <!-- Style sheet -->
    <link rel = "stylesheet" href = "./front-end/style.css"> 

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>

    <!-- icons pack -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            
</head>

<body>


    <!-- header --->
    <nav>
        <div class="nav-wrapper header">
          <a href="#" class="brand-logo center">ISA Admin Login</a>
        </div>
    </nav>

	<!-- sub header info -->
    <div id="descriptionHeader" class="row" style="padding-top: 5vh;">
        <div class="col s12 center">
            <p style="font-size: 1.5em;"> Admin Login </p>
        </div>
    </div>



    <!-- padding area -->
    <div style="padding-bottom: 10vh;"></div>


   


     <!-- admin login form -->
    <div id="userInfoForm" class="row" style="padding-left: 5vh; padding-right: 5vh;">
        <div class="col show-on-large l3"> </div>
        <form class="col s12 l6">

            <!-- username-->
            <div class="row">
                <div class="input-field col s12 center">
                    <label> Username </label>
                    <input id="usernameInput" placeholder = "Username" type="text">
                </div>
            </div>

             <!-- password -->
             <div class="row">
                <div class="input-field col s12">
                    <label> Password </label>
                    <input id="passwordInput" placeholder="Password" type="password">
                </div>
            </div>   

            <div id="loginErrorMessage" class="row" style="display: none;">
                <div class="col s1 left">
                     <i class="material-icons errorIcon">error_outline</i>
                </div>

                <div  class="col 11 left">
                     <p style="margin: 0; margin-top: 0.5vh;"> Error:  Invalid Credentials </p>
                </div>
            </div>

        </form>
    </div>

    <div class="container center"> 
        <a id="loginBtn" class="waves-effect waves-light btn" style="background-color: #d94141;"> <i class="material-icons"> send </i></a>
    </div>


     <!-- footer -->
    <footer>
        <p class="right" style="padding-right: 3vh;">
            <a href="index.php" style="text-decoration: underline;">Back</a>
        </p>
    </footer>



</body>


<script>
    //send to admin screen or show error message
    $("#loginBtn").click(function(){
        if (verifyCredentials()){
            window.location.replace("admin.php")
        }   
        else{
            document.getElementById("loginErrorMessage").style.display = "block";
        }
    });
    

    //validate user input
    function verifyCredentials(){
        //DB call!!!
        return true;
    }

</script>





</html>