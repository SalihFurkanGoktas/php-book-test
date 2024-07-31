<?php
	require 'views/templates/navbar.php';
	require 'views/templates/template.php';
	require 'views/signup.view.php';
?>



<form method="post">
                <label class="signee" for="name">Name</label>
                <input type="text" id="name" name="signee_name" value=""><br>
	     	<label class="signee" for="">Gender</label>
                <input type="text" id="sex" name="signee_sex" value=""><br>
	   	<label class="signee" for "age">Age</label>
		<input type="text" id="age" name="signee_age" value=""><br> 
		<input class="signee" type="submit" name="signee_submit" value="Sign me up!">
	    </form>




  <?php

try{ 	
	if (isset($_POST['signee_submit'])) {

		
	 $dbh = new PDO("mysql:host=localhost;dbname=sampdb", "testuser", "password");
	 $dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 $statement = "INSERT INTO student (name,sex,student_id,age) VALUES(?,?,?,?)";
	 $sth = $dbh->prepare ($statement);
	 $sth->execute (array ($_POST['signee_name'], $_POST['signee_sex'], NULL, $_POST['signee_age']));		 
	 $dbh = NULL;}
}catch(PDOException $e){
	echo $e->getMessage();								}
?>
