<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$columns = array(
	"username" => array("titel" => 'Username',"width" => 30),
	"email" => array("titel" => 'Email',"width" => 20),
	"type" => array("titel" => 'Type',"width" => 10),
	"rank" => array("titel" => 'Rank',"width" => 10),
	"team" => array("titel" => 'Team',"width" => 20),
	"role" => array("titel" => 'Role',"width" => 20),
	"last_login" => array("titel" => 'Last login',"width" => 20),
	"actions" => array("titel" => 'Actions',"width" => 10)
);
foreach($columns as $key =>$value)
	{
		$aColumns[] = $key;
	}
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	/* DB table to use */
	$sTable = "users";
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
		intval( $_GET['iDisplayLength'] );
	}
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0']))
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}	
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = " AND (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			$sWhere .= " AND ";
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "SELECT id,username,email,type,last_login from users
	$sLimit";
	$rResult = sql($sQuery) or fatal_error( 'MySQL Error: test ' . mysqli_errno() );
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = sql($sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = sql($sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno() );
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	/*
	 * Output
	 */
	$output = array(
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$row = array();
		foreach($columns as $key => $value)
		{
				switch($key)
				{
					case "username" : $row[] =  "<a href='index?module=user_profile&id=". $aRow['id']. "' target='_blank'>". $aRow["username"]."</a>";
						break;
					case "email" : $row[] = ($aRow["email"]);
						break;
					case "type" :
								$row[] = GlobalGetAccountType($aRow['type']);
						break;
					case "rank" :						
						$rank = UserGetStatistics($aRow['id']);					
						$row[]= GlobalGetRank('value','id',$rank[0]['rank_solo']);
						break;
					case "team" : 				
						$row[] = TeamGetInfoByColumn('name','id',GetTeamOfUser($aRow['id']));					
						break;
					case "role" :
						$row[]= GlobalGetRole(GetCurrentRoleOfUser($aRow['id']));
						break;
					case "last_login" :
						if(date('d-m-Y H:i:s',strtotime($aRow['last_login'])) == '01-01-1970 01:00:00'){
							$row[] = "No data";
						}else {
							$row[] = date('d-m-Y H:i:s',strtotime($aRow['last_login']));
						}
						break;		
					case 'actions' : $row[]= '
  											  <button type="button" data-id="'.$aRow['id'] .'" class="btn btn-danger delete"><i class="fa fa-times"></i></button>
 											  <button type="button" data-id="'.$aRow['id'] .'" class="btn btn-warning edit"><i class="fa fa-cogs"></i></button>
										';
					break;
					}

		}
		$output['aaData'][] = $row;

		}
	echo json_encode( $output );
	/* Data set length after filtering */
?>