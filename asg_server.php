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
	
	

	header('Content-Type: application/json');
	
	$DB_LINK = mysqli_connect($asg_DbHost, $asg_DbUser, $asg_DbPass, $asg_DbName);
	mysqli_query ($DB_LINK, "SET NAMES 'utf8'");


	if ((isset ($_POST ['query'])) && (trim ($_POST ['query']) != ''))
	{
		$return = array();
		$query = mysqli_real_escape_string ($DB_LINK, trim ($_POST ['query']));
		$result = mysqli_query ($DB_LINK, "SELECT * FROM `$asg_TableName` WHERE `$asg_SearchColumn` LIKE '%{$query}%'");			
		if (mysqli_num_rows ($result) > 0)
		{
			$count = 1;
			
			while ($row = mysqli_fetch_assoc ($result))
			{
				$return[] = array(
					'id' => $row [$asg_resultIdColumn],
					'name' => $row [$asg_SearchColumn],
					'count' => $count
				);
				$count++;
			}
		}
		else
		{
			$returnt[] = array(
				'id' => 0,
				'name' => $asg_notFoundText
			);
		}
	}
	
	echo json_encode($return);
	
?>




