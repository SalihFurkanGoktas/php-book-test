

    <?php
    require 'views/templates/navbar.php';
    require 'views/templates/template.php';
    require 'views/addbook.view.php';

    if (isset($_POST['addbook_submit'])) {
	    //some preparation work
	    $authorArr= explode(',',$_POST['addbook_authors']);
	    for($i = 0; $i < count($authorArr); $i++)
		    $authorArr[$i] = trim($authorArr[$i]);
	//    var_dump($authorArr);
	    $booktitle = $_POST['addbook_title'];
	//    var_dump($booktitle);
    	
    
	$dbh = new PDO('mysql:host=localhost;dbname=sampdb', 'testuser', 'password');
   	 
	$dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   	$sth = $dbh->prepare('SELECT COUNT(*) FROM book WHERE title = ?');

	$sth->execute([$booktitle]);

	$presenceOfBook = $sth->fetchColumn(0);	
    
   	if ($presenceOfBook)
		echo "That book is already in the system!";
	else {
		$sth2 = $dbh->prepare('INSERT INTO book VALUES(?,NULL)');
		$sth2->execute([$booktitle]);
		echo "Book titled " . $booktitle ." has been added to the system.";
		//add authors if needed
		var_dump($authorArr);
		foreach($authorArr as $author) {
			$sth3 = $dbh->prepare('SELECT COUNT(*) FROM author WHERE name = ?');
			$sth3->execute([$author]);
			$presenceOfAuthor = $sth3->fetchColumn(0);
			if ($presenceOfAuthor)
				echo "That author " . $author  ." is already present in the system!<br>";
			else {
				$sth7 = $dbh->prepare('INSERT INTO author VALUES(?,NULL)');
				$sth7->execute([$author]);
				echo "Author titled " . $author ." has been added to the system.";
			}

		}
		//now make the ownership connections
		$sth4 = $dbh->prepare('INSERT INTO ownership VALUES(?,?)');
		$sth5 = $dbh->prepare('SELECT book_id FROM book WHERE title = ?');
		$sth5->execute([$booktitle]);
		$addedBookId = $sth5->fetchColumn(0);		
		foreach($authorArr as $author) {
			$sth6 = $dbh->prepare('SELECT author_id FROM author WHERE name = ?');
			$sth6->execute([$author]);
			$addedAuthorId = $sth6->fetchColumn(0);
			$sth4->execute([$addedBookId,$addedAuthorId]);
			echo "author connection added";
	}	
    }
}
