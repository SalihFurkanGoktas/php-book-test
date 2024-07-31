<?php 
        require 'views/templates/navbar.php';
        require 'views/templates/template.php';
	        require 'views/index.view.php';

	try
	{
		$dbh = new PDO("mysql:host=localhost;dbname=sampdb", "testuser", "password");
		$dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->query ("SELECT COUNT(*) FROM student");
		$count = $sth->fetchColumn(0);
		$sth = $dbh->query ("SELECT AVG(age) FROM student");
		$average = $sth->fetchColumn(0);
		$average = round($average, 1);
		print ("<p>we currently have $count members lads (with an average age of $average):</p>");

		$sth2 = $dbh->query ("SELECT * FROM student ORDER BY age DESC");
		$theStudents = $sth2->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($theStudents);


		echo "<div class=\"namelist\">";
		foreach($theStudents as $student) 
		{
			echo "<li class=\"nameitem\">" . $student["name"] . "</li>"; 
		}
		echo "</div>";
		$dbh = NULL;
	}
	catch (PDOException $e)
	{
		echo $e-> getMessage();		
	}
?>
