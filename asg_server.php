<?php

	/* ------------------------ */
	/* ------- SETTINGS ------- */
	
	// database settings
	
	$asg_DbName = '';
	$asg_DbHost = 'localhost';
	$asg_DbUser = '';
	$asg_DbPass = '';
	
	
	
	// search settings
	
	$asg_resultIdColumn = 'id';
	$asg_TableName = '';
	$asg_SearchColumn = '';
	
	$asg_notFoundText = ' result not found :(  ';
	
	
	/* ------------------------ */
	/* ------------------------ */
	
	

	
	
	$DB_LINK = mysqli_connect($asg_DbHost, $asg_DbUser, $asg_DbPass, $asg_DbName);
	mysqli_query ($DB_LINK, "SET NAMES 'utf8'");

	if ((isset ($_POST ['query'])) && (trim ($_POST ['query']) != '')) {
		$query = mysqli_real_escape_string ($DB_LINK, trim ($_POST ['query']));
		$result = mysqli_query ($DB_LINK, "SELECT * FROM `$asg_TableName` WHERE `$asg_SearchColumn` LIKE '%{$query}%'");			
		if (mysqli_num_rows ($result) > 0) {
			$count = 1;
			while ($row = mysqli_fetch_assoc ($result)) {
				echo '<div data-id="'.$row [$asg_resultIdColumn].'" class="cp-asuggest-list cp-asg-onlist-'.$count.'">'.$row [$asg_SearchColumn].'</div>';
				$count++;
			}
		} else {
			echo '<div data-id="0" class="cp-asuggest-list cp-asuggest-list-error">'.$asg_notFoundText.'</div>';
		}
	}
	
?>




