<html>
 <head>
  <title>Chores</title>

  <meta charset="utf-8"> 

  <link rel="stylesheet" type="text/css" href="common/css/fontawesome-all.min.css" />
  <link rel="stylesheet" type="text/css" href="common/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="common/css/main.css" />


</head>
<body id="homepage">
	
	<?php

<<<<<<< HEAD
	$DB_HOST = getenv('DB_HOST');
	$DB_USER = getenv('DB_USER');
	$DB_PASS = getenv('DB_PASS');
	$DB_NAME = getenv('DB_NAME');

	$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
=======
	$conn = mysqli_connect($_ENV[DB_HOST], $_ENV[DB_USER], $_ENV[DB_PASS], $_ENV[DB_NAME]);
>>>>>>> fcf74396290d2a5a95b3d9bb5727628e4d03833f

        if (empty($_POST['id']) && !empty($_POST['task'])) {
                $taskname = mysqli_real_escape_string($conn, $_POST['task']);
                $querynew = "INSERT INTO Task (name) VALUES ('". $taskname ."');";
                $dump = mysqli_query($conn, $querynew);
        }
	if (!empty($_POST['id']) && !empty($_POST['update'])) {
		$curtime = date('Y-m-d H:i:s');
		$queryinsert = "INSERT INTO Task_Events (Task_ID) VALUES (". $_POST['id'] .");";
		$dump = mysqli_query($conn, $queryinsert);
	}
        if (!empty($_POST['id']) && !empty($_POST['delete'])) {
		$querydelete = "DELETE FROM Task WHERE id = ". $_POST['id'];
		$dump = mysqli_query($conn, $querydelete);
	}

	$query = 'SELECT Task.name, Task_Events.time, Task.id 
                From Task 
                INNER JOIN (
                select max(time) as Time, Task_ID
                        from Task_Events 
                        group by Task_ID) events ON Task.id = events.Task_ID
                INNER JOIN Task_Events on Task.id = Task_Events.Task_ID AND Task_Events.Time = events.Time
                ORDER BY Task.name';
	$result = mysqli_query($conn, $query);


    echo '<div class="container" style="padding-left:5px; padding-right:5px; width:90%;"  id="wrapper">';
	echo '<table class="table table-striped" style="max-width:99%">';
	echo '<thead><tr><td colspan=3><h2>Chore Tracker</h2></td></tr></thead>';

	echo '<thead ><tr><th>Task</th><th>Last Done</th><th>Update</th></tr></thead>';
	while($value = $result->fetch_array(MYSQLI_ASSOC)){
		$phpdate = strtotime($value["time"]);
        	echo '<form method="post" onsubmit="return validate_form();" name="taskform"><tr><input type="hidden" name="id" class="id" value="'. $value["id"] . '" />';
		echo '<td>' . $value["name"] . '</td><td>' . date('g:i a -  M jS ' ,$phpdate) . '</td>';
		echo '<td><input name="update" class="btn btn-outline-secondary" type="submit" value="Now" /> <input name="delete" id="delete" onclick="submission=\'deletetask\'" style="margin-left:1em;" type="submit" class="btn btn-outline-danger btn-sm" value="x"/></td>';
        	echo '</tr></form>';
	}
	echo '<form method="post"><tr><td><input class="form-control" name="task" style="background-color:transparent;" type="text"></input></td>';
	echo '<td></td><td><input class="btn btn-outline-secondary" type="submit" value="New" /></table>';

	$result->close();
	mysqli_close($conn);


	?>
	</div>

                <script type="text/javascript" src="common/js/jquery.min.js"></script>
                <script src="common/js/trianglify.min.js"></script>
                <script>
                        function addTriangleTo(target) {
                                var dimensions = target.getClientRects()[0];
                                var pattern = Trianglify({
                                        width: dimensions.width,
                                        height: dimensions.height
                                });

                                target.style['background-image'] = 'url(' + pattern.png() + ')';
                                target.style['background-size'] = 'cover';
                                target.style['-webkit-background-size'] = 'cover';
                                target.style['-moz-background-size'] = 'cover';
                                target.style['-o-background-size'] = 'cover';
                        }

                        var resizeTimer;
                        $(window).on('resize', function(e) {
                                clearTimeout(resizeTimer);
                                resizeTimer = setTimeout(function() {
                                        addTriangleTo(homepage);
                                }, 400);
                        });

                        addTriangleTo(homepage);
                </script>
				<script>
				var submission = "";
				function validate_form() {
					if (submission == "deletetask") {
						var r = confirm('Do you really want to delete this task?');
						if (r == false) {	
							return false;
						}
					}
				}

				</script>
	<?php
 	#if (!empty($_POST['id'])) {     echo '<script type="text/javascript"> $(document).ready(function(){    alert("' . $_POST['id'] . '");}); </script> '; };
	?>


</body>
</html>
