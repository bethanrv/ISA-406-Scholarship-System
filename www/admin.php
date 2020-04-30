<!DOCTYPE html>
<?php
include 'db_connection.php';
$conn = OpenCon();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected Successfully";
$sql = "SELECT * FROM `test`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "test: " . $row["Test"]. "<br>";
    }
} else {
    echo "0 results";
}
CloseCon($conn);
?>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>ISA Admin</title>
    <!-- main page icon -->
    <link rel="shortcut icon" href="https://miamioh.edu/fbs/_files/images/page-content/controller/staff/block-m.jpg" >

    <!-- Style sheet -->
    <link rel = "stylesheet" href = "./front-end/style.css"> 


    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- icons pack -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            
</head>

<style type="text/css">
	table.dataTable thead .sorting:after,
	table.dataTable thead .sorting:before,
	table.dataTable thead .sorting_asc:after,
	table.dataTable thead .sorting_asc:before,
	table.dataTable thead .sorting_asc_disabled:after,
	table.dataTable thead .sorting_asc_disabled:before,
	table.dataTable thead .sorting_desc:after,
	table.dataTable thead .sorting_desc:before,
	table.dataTable thead .sorting_desc_disabled:after,
	table.dataTable thead .sorting_desc_disabled:before {
	bottom: .5em;
	}

	#dtBasicExample_filter label {
 	    font-size: 1.5em;
 	    font-weight: 100 ;
 	    color: black;
	}
</style>

<body>


    <!-- header --->
    <nav>
        <div class="nav-wrapper header">
          <p class="brand-logo center">Scholarship Submisions</p>
        </div>
    </nav>


    <!-- Summary Area -->
    <div class="row" style="padding: 5vh;">
        <div class="col s4"> </div>
        <div class="col s4"> 
             <table class="center" >
                <tbody >
                  <tr> <td class="center" style="font-weight: 700 ;"> Summary </td> </tr>
                  <tr>
                    <td class="center">Total Submission: 10</td>
                  </tr>
                  <tr>
                    <td class="center">Average GPA: 3.0</td>
                  </tr>
                </tbody>
            </table>
        </div>
        <div class="col s4"> </div>
    </div>



    <div class="container center" style="padding-bottom: 5vh;">
	    <table id="studentDataTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="padding: 5vh;">
		  <thead>
		    <tr>
		      <th class="th-sm">Name</th>
		      <th class="th-sm">Year</th>
		      <th class="th-sm">Application Date</th>
		      <th class="th-sm">Cum. GPA</th>
		      <th class="th-sm">ISA GPA</th>
		      <th class="th-sm">Maj. GPA</th>
		      <th class="th-sm"> ISA Grades </th>
		      <th class="th-sm"> DARS </th>
		      <th class="th-sm"> CV </th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td>Tiger Nixon</td>
		      <td>Freshmen</td>
		      <td>04/15/2020</td>
		      <td>2.7</td>
		      <td>2.9</td>
		      <td>2.1</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Ella Johnson</td>
		      <td>Sophomore</td>
		      <td>12/21/2019</td>
		      <td>3.8</td>
		      <td>3.7</td>
		      <td>3.7</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Brian Rodgers Vargo</td>
		      <td>Senior</td>
		      <td>1/29/2020</td>
		      <td>2.9</td>
		      <td>2.5</td>
		      <td>2.7</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Betty Smith</td>
		      <td>Freshmen</td>
		      <td>2/11/2020</td>
		      <td>3.3</td>
		      <td>3.7</td>
		      <td>3.6</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Mike Wolzaski</td>
		      <td>Junior</td>
		      <td>3/1/2020</td>
		      <td>3.2</td>
		      <td>3.3</td>
		      <td>3.3</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>James P. Sullivan</td>
		      <td>Junior</td>
		      <td>4/13/2020</td>
		      <td>2.5</td>
		      <td>2.9</td>
		      <td>2.8</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Randall Boggs</td>
		      <td>Senior</td>
		      <td>12/12/2019</td>
		      <td>3.5</td>
		      <td>3.4</td>
		      <td>3.2</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Henry J. Waternoose III</td>
		      <td>Senior</td>
		      <td>4/19/2020</td>
		      <td>4.0</td>
		      <td>4.0</td>
		      <td>4.0</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>George Sanderson</td>
		      <td>Freshmen</td>
		      <td>4/10/2020</td>
		      <td>1.3</td>
		      <td>1.7</td>
		      <td>1.8</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    <tr>
		      <td>Pete C. Ward</td>
		      <td>Sophomore</td>
		      <td>2/21/2020</td>
		      <td>2.9</td>
		      <td>2.7</td>
		      <td>2.8</td>
		      <td class="center"><i class="material-icons"> edit </i></td>
		      <td class="center"><i class="material-icons"> folder_open </i></td>
		      <td class="center"><i class="material-icons"> format_align_left </i></td>
		    </tr>
		    </tbody>
		</table>
	</div>


	<!-- download all-->
	<div class="container center">
		<a class="btn waves-effect waves-light" style="background-color: #d94141;"> Download Results</a>
	</div>
	


	<!--  footer -->
	<div style="padding-bottom: 5vh;"> </div>



</body>


<script>

    //on page load...
    $(document).ready(function(){
        //DB Call for all application info + load summary (total apps and avg gpa)
    });


    //table sorting
    // Must add custom sory
	$(document).ready(function () {
	$('#studentDataTable').DataTable({
		"ordering": true, // false to disable sorting (or any other option)
		"paging": false
	});
	$('.dataTables_length').addClass('bs-select');
	});




</script>


</html>