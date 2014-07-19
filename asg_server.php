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
	
	$csi = new mysqli($asg_DbHost, $asg_DbUser, $asg_DbPass, $asg_DbName);
	$csi->query(' SET NAMES utf8');

	if ((isset ($_POST ['query'])) && (trim ($_POST ['query']) != '')) {
		$return = array();
		$query = $csi->real_escape_string(trim ($_POST ['query']));
		$result = $csi->query("SELECT * FROM `$asg_TableName` WHERE `$asg_SearchColumn` LIKE '%{$query}%'");
		if ($result->num_rows > 0) {
			$count = 1;
			
			while ($row = $result->fetch_assoc()) {
				$return[] = array(
					'id' => $row [$asg_resultIdColumn],
					'name' => $row [$asg_SearchColumn],
					'count' => $count,
					'error' => 0
				);
				$count++;
			}
		} else {
			$return[] = array(
				'id' => 0,
				'name' => $asg_notFoundText,
				'count' => 0,
				'error' => 1
			);
		}
	}
	
	echo json_encode($return);
?>