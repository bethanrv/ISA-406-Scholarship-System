<!DOCTYPE html>
<html lang="en">
<html>
<head>

	<meta charset="utf-8">

    <title>ISA Common App</title>
    <!-- main page icon -->
    <link rel="shortcut icon" href="https://miamioh.edu/fbs/_files/images/page-content/controller/staff/block-m.jpg" >

    <!-- Style sheet -->
    <link rel = "stylesheet" href = "./style.css"> 

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
        <div class="nav-wrapper header row">
        	<div class="col hide-on-small-only" style="padding-top: 2vh;">
        		<a href="admin_login.php" class="waves-effect waves-light btn left" style="background-color: #d94141;">Admin Login</a>
            </div>
            <div class="col hide-on-small-only" style="padding-top: 2vh;">
                <a href="test.php" class="waves-effect waves-light btn left" style="background-color: #d94141;">Test</a>
        	</div>
        	<div class="col">
        		<a href="#" class="brand-logo center">ISA Common App</a>
        	</div>
        </div>
    </nav>


    <!-- sub header info -->
    <div id="descriptionHeader" class="row" style="padding-top: 5vh;">
        <div class="col s12 center">
            <p style="font-size: 1.5em;"> Quickly apply to all ISA department scholarships </p>
        </div>
    </div>


    <!-- user info area -->
    <div id="userInfoForm" class="row" style="padding-left: 5vh; padding-right: 5vh;">
        <div class="col show-on-large l3"> </div>
        <form class="col s12 l6">

            <p class="center step" > Step 1: Your Info</p>

            <!-- name-->
            <div class="row">
                <div class="input-field col s12 center">
                	<label> Name </label>
                    <input id="nameInput" placeholder = "Full Name" type="text">
                </div>
            </div>

             <!-- Email -->
             <div class="row">
                <div class="input-field col s12">
                	<label> Email </label>
                    <input id="emailInput" placeholder="Student@Miamioh.edu" type="email">
                </div>
            </div>   

            <div id="emailErrorMessage" class="row">
            	<div class="col s1 left">
            		 <i class="material-icons errorIcon">error_outline</i>
            	</div>

            	<div  class="col 11 left">
            		 <p style="margin: 0; margin-top: 0.5vh;"> Error:  Please use your Miami University email address </p>
            	</div>
            </div>


            <div id="nameErrorMessage" class="row">
            	<div class="col s1 left">
            		 <i class="material-icons errorIcon">error_outline</i>
            	</div>

            	<div  class="col 11 left">
            		 <p style="margin: 0; margin-top: 0.5vh;"> Error:  Please enter your full name </p>
            	</div>
            </div>


        </form>
    </div>


    <!-- location info area -->
    <div id="addressForm" class="row" style="padding-left: 5vh; padding-right: 5vh;">
        <div class="col show-on-large l3"> </div>
        <form id="userInfoForm" class="col s12 l6">

            <p class="center step" > Step 2: Home Address</p>
            <p class="center subtext"> Where to send your scholarship information </p>

            <!-- Street Address -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Street  Address </label>
                    <input id="streetAddress" placeholder="Street Address" type="text">
                </div>
            </div> 

            <!-- State -->
            <div class="row">
                <div class="input-field col s12">
                	<label> State </label>
                    <input id="stateAddress" placeholder="State" type="text">
                </div>
            </div>   

            <!-- Zip -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Zip </label>
                    <input id="zipAddress" placeholder="Zip Code" type="number">
                </div>
            </div> 

            <!-- Country -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Country </label>
                    <input id="countryAddress" placeholder="Country" type="text">
                </div>
            </div>    

        </form>

         <div id="addressErrorMessage" class="row" style="display: none">
            <div class="col s1 left">
                 <i class="material-icons errorIcon">error_outline</i>
            </div>

            <div  class="col 11 left">
                 <p style="margin: 0; margin-top: 0.5vh;"> Error:  Please fill in all fields</p>
            </div>
        </div>

    </div>
    



    <!-- Dars File Upload -->
    <div id="darsUploadArea" class="row">
        <input id="darFile" type="file" style="display: none" />
        <div class="col s2"></div>
        <div class="col s8 center">
            <p class="step"> Step 3: Upload Your DARS</p>
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <p>Save your dars report as an html file and upload it here</p>
                    </div>
                    <div id="darCard" class="card-action" onmouseover="dim('darCard')"; onmouseleave="revertDim('darCard')">
                    	<i id="darErrorIcon" class="material-icons left errorIcon">warning</i>
                        <a id ="darPrompt" style="color: gray;">Select Dars HTML File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    


    <!-- Personal Statement File Upload -->
    <div id="statementUploadArea" class="row">
        <input id="statementFile" type="file" style="display: none" />
        <div class="col s2"></div>
        <div class="col s8 center">
            <p class="step"> Step 4: Personal Statement</p>
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <p>Upload your personal statement here as a PDF file</p>
                    </div>
                    <div id="statementCard" class="card-action" onmouseover="dim('statementCard')"; onmouseleave="revertDim('statementCard')">
                    	<i id="statementErrorIcon" class="material-icons left errorIcon">warning</i>
                        <a id="statementPrompt" style="color: gray;">Select Personal Statement File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Form navigation button (Next)-->
    <div id="navBtnRow" class="row">
        <div class="col s12 center">
            <a id=formNavBtn class="waves-effect waves-light btn" style="background-color: #d94141;"><i class="material-icons right">send</i>Next</a>
        </div>
    </div>


    <!-- Completion Message -->
    <div id="successMessageRow" class="row">
        <div class="col s12 center">
            <p class="successMessageHead"> Thank You </p>
            <p class="successMessage"> Keep a look out for updates by email and mail </p>
            <p class="successMessageSub"> - Best of luck, ISA Department Staff</p>
        </div>
    </div>




    <!-- padding area -->
    <div style="padding-bottom: 10vh;"></div>


    <!-- footer -->
    <footer id = 'admin_login_link'>
        <p class="right" style="padding-right: 3vh;">
            <a href="admin_login.php" style="text-decoration: underline;">Admin Login</a>
        </p>
    </footer>







</body>


<script>
    //Fade out for user info form
    $(document).ready(function(){

    	let testing = false;

        //initialize forms and upload areas
        initForms();

        //naviage thru information and file upload fields...
        let stepNumber = 1;

        $("#formNavBtn").click(function(){

            if(stepNumber == 1){

            	let email = $("#emailInput").val();
            	let name = $("#nameInput").val();

            	//verify miami emial & name field
            	if(testing || (verifyEmail(email) && verifyName(name))){
            		$("#userInfoForm").fadeOut();
            		$("#admin_login_link").fadeOut();
	                $("#addressForm").fadeIn();
	                stepNumber++;
            	}        
            }

            else if(stepNumber == 2){
                if(validateAddress()){
                	$("#addressForm").fadeOut();
                	$("#darErrorIcon").fadeOut();
                	$("#navBtnRow").fadeOut();
                	$("#darsUploadArea").fadeIn();
                    stepNumber++;
                }
                else{
                    showAddressFormError();
                }
            }

            else if (stepNumber == 3){
                $("#darsUploadArea").fadeOut();
                $("#statementErrorIcon").fadeOut();   
                $("#navBtnRow").fadeOut(); 
                $("#statementUploadArea").fadeIn();
                stepNumber++;
            }

            else if (stepNumber == 4){
                $("#statementUploadArea").fadeOut();
                $("#navBtnRow").fadeOut();
                $("#descriptionHeader").fadeOut();
                $("#successMessageRow").fadeIn();
                stepNumber++;
            }


        });



        //open file selection
        //dars...
        $("#darCard").on("click", function() {
            $("#darFile").trigger("click");
        });


        $("#darFile").on('input', function(){
        	let fileName = $("#darFile").val().substring(12);

        	let fileExtension = fileName.split(".")[1];

        	//verify file type
			if(fileExtension == "html"){
				$("#darPrompt").text(fileName);
				$("#darErrorIcon").fadeOut();
				$("#navBtnRow").fadeIn();
			}
			else{
				$("#darPrompt").text("Please upload your DARS as an html file");
				$("#darErrorIcon").fadeIn();
			}

        });

        //statement...
        $("#statementCard").on("click", function() {
            $("#statementFile").trigger("click");

        });

        $("#statementFile").on('input', function(){
        	let fileName = $("#statementFile").val().substring(12);

        	let fileExtension = fileName.split(".")[1];

        	//verify file type
			if(fileExtension == "pdf"){
				$("#statementCard").text(fileName);
				$("#statementErrorIcon").fadeOut();
				$("#navBtnRow").fadeIn();
			}
			else{
				$("#statementErrorIcon").fadeIn();
				$("#statementPrompt").text("Please upload your personal statement as a pdf file");
			}

        });


    });


    //fade out all steps other than 1 to start
    function initForms(){
    	$("#emailErrorMessage").fadeOut();
    	$("#nameErrorMessage").fadeOut();
    	$("#addressForm").fadeOut();
        $("#darsUploadArea").fadeOut();
        $("#statementUploadArea").fadeOut();
        $("#successMessageRow").fadeOut();    
    }


    //modify brightness of given element
    function dim(id){
        let element = document.getElementById(id);
        element.style.background ="#aqua";
        element.style.filter = "brightness(70%)";
    }

    function revertDim(id){
        let element = document.getElementById(id);
        element.style.background ="white";
        element.style.filter = "brightness(100%)";
    }


    //verify email is a miami email address
    function verifyEmail(email){
    	if(email.toLowerCase().endsWith('@miamioh.edu')){
    		$("#emailErrorMessage").fadeOut();  
    		return true;
    	}
    	$("#emailErrorMessage").fadeIn(); 
    	return false;
    }

    //verify name input has a value
    function verifyName(name){
    	if(name == ""){
    		$("#nameErrorMessage").fadeIn();
    		return false;
    	}
    	return true;
    }

    //validate that all requisite fields in address form are complete
    function validateAddress(){
        //fields = ["streetAddress", "stateAddress", "zipAddress", "countryAddress"];
        //fields.forEach(function(entry){
        //    if(document.getElementById(entry).value.length == 0)
        //        return false;
        //    console.log(document.getElementById(entry).value);
        //});

        if(document.getElementById('streetAddress').value.length == 0)
            return false;
        if(document.getElementById('stateAddress').value.length == 0)
            return false;
        if(document.getElementById('zipAddress').value.length == 0)
            return false;
        if(document.getElementById('countryAddress').value.length == 0)
            return false;
        
        return true;
    }

    //function to identify errors in address form to user
    function showAddressFormError(){
        document.getElementById("addressErrorMessage").style.display = 'block';
    }

</script>





</html>
