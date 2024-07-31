
    <?php
    require 'views/templates/navbar.php';
    require 'views/templates/template.php';
    require 'views/bookpage.view.php';
    

    if (isset($_POST['query_submit'])) 
    {
	    $temp_var_wtf = strlen($_POST['query_text_entered']);
    	if (isset($_POST['query_choice']) && $temp_var_wtf != 0) 
	{
		try {
		$dbh = new PDO('mysql:host=localhost;dbname=sampdb', 'testuser', 'password');

		$dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//we need to check for either case. first case: if they chose author
		if ($_POST['query_choice'] === 'author') {
		$sth = $dbh->prepare('SELECT title FROM book INNER JOIN ownership INNER JOIN author ON book.book_id = ownership.book_id AND author.author_id=ownership.author_id WHERE name = ?');
		$choiceVar = 'title';
		} else {
		$sth = $dbh->prepare('SELECT name FROM author INNER JOIN ownership INNER JOIN book ON book.book_id = ownership.book_id AND author.author_id=ownership.author_id WHERE title = ?');
		$choiceVar = 'name';
		}

		$sth->execute([$_POST['query_text_entered']]);
		$result = $sth->fetchAll();
		foreach($result as $oneline) 
		{
			echo "<li class=\"nameitem\">" . $oneline[$choiceVar] . "</li>"; 
		}
		echo "</div>";

		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	else if ($temp_var_wtf === 0)
	{
					
		echo "<p class=\"errorMsg\"> PLEASE INPUT SOME TEXT IN THE FIELD <p>";
	}
	else 
	{
		echo "<p class=\"errorMsg\"> PLEASE SELECT BETWEEN AUTHOR AND BOOK <p>";
	}	
    }
?>
