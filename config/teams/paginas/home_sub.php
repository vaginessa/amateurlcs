<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$columns;
if($GLOBALS['package'] == 1){
	$columns = array(
    0 => array("titel" => 'Team name',"width" => 9),
    1 => array("titel" => 'Captain',"width" => 9),
    2 => array("titel" => 'Toplane',"width" => 9),
    3 => array("titel" => 'Jungler',"width" => 9),
    4 => array("titel" => 'Midlane',"width" => 9),
    5 => array("titel" => 'Adc',"width" => 9),
    6 => array("titel" => 'Support',"width" => 9),
    7 => array("titel" => 'Sub',"width" => 9),
    8 => array("titel" => 'Actions',"width" => 9));	
}


foreach ($columns as $key => $value) {
	$aColumns[] = $key;
}
/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";
/* DB table to use */
$sTable = "teams";
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
 * no need to edit below this line
 */
/*
 * Local functions
 */
function fatal_error($sErrorMessage = '') {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
	die($sErrorMessage);
}
/*
 * Paging
 */
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
	$sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
}
/*
 * Ordering
 */
$sOrder = "";
if (isset($_GET['iSortCol_0'])) {
	$sOrder = "ORDER BY  ";
	for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
		if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
			$sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
		}
	}
	$sOrder = substr_replace($sOrder, "", -2);
	if ($sOrder == "ORDER BY") {
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
if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
	$sWhere = " AND (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';
}
/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
	if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
		$sWhere .= " AND ";
		$sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
	}
}
/*
 * SQL queries
 * Get data to display
 */
$sQuery = "SELECT id,captain_id,name,tag from teams

	$sLimit";
$rResult = sql($sQuery) or fatal_error('MySQL Error: test ' . mysqli_errno());
/* Data set length after filtering */
$sQuery = "

		SELECT FOUND_ROWS()

	";
$rResultFilterTotal = sql($sQuery) or fatal_error('MySQL Error: ' . mysqli_errno());
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];
/* Total data set length */
$sQuery = "

		SELECT COUNT(`" . $sIndexColumn . "`)

		FROM   $sTable

		

		

	";
$rResultTotal = sql($sQuery) or fatal_error('MySQL Error: ' . mysqli_errno());
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
while ($aRow = mysqli_fetch_array($rResult)) {
	$row = array();
	foreach ($columns as $key => $value) {
		switch($key) {			
			case 0 :
				$row[] = "<a target='_blank' href='index.php?module=teams&id=". $aRow['id']."'>". $aRow["name"].'</a>';
				break;			
			case 1 :
				$row[] = UserGetInfoByColumn('username','id',$aRow["captain_id"]);
				break;
			case 2 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(1, $aRow['id']));
				break;
			case 3 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(2, $aRow['id']));
				break;
			case 4 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(3, $aRow['id']));
				break;
			case 5 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(4, $aRow['id']));
				break;
			case 6 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(5, $aRow['id']));
				break;	
			case 7 :
				$row[] = UserGetInfoByColumn('username','id',GetUserForRosterRole(6, $aRow['id']));
				break;					
			case 8 :
			$row[] = '
								  <button type="button" data-id="' . $aRow['id'] . '" class="btn btn-warning edit"><i class="fa fa-cogs"></i></button>
								   <button type="button" data-id="' . $aRow['id'] . '" class="btn btn-danger delete"><i class="fa fa-times"></i></button>
						      ';
			break;
			
		}
	}
	$output['aaData'][] = $row;
}
echo json_encode($output);
/* Data set length after filtering */
?>