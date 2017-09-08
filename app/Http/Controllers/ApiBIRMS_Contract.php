<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;

class ApiBIRMS_contract extends Controller
{
     

	function get_contract($ocid) {
	    $dbplanning = '2016_birms_eproject_planning';
	    $dbcontract = '2016_birms_econtract';
	    $dbmain 	= '2016_birms_prime';
	   
 		
		$sql = 'SELECT * 
FROM
	2016_birms_econtract.tpengadaan
LEFT JOIN 2016_birms_prime.tbl_skpd ON 2016_birms_econtract.tpengadaan.skpdid = tbl_skpd.skpdid
LEFT JOIN 2016_birms_prime.tbl_instansi ON 2016_birms_prime.tbl_skpd.instansiid = tbl_instansi.instansiid
LEFT JOIN 2016_birms_econtract.tsumberdana ON 2016_birms_econtract.tpengadaan.sumberdanaid = tsumberdana.sumberdanaid
LEFT JOIN 2016_birms_econtract.tklasifikasi ON tpengadaan.klasifikasiID = tklasifikasi.klasifikasiID
LEFT JOIN 2016_birms_econtract.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid       
LEFT JOIN 2016_birms_econtract.tpekerjaan ON tpengadaan.pid = tpekerjaan.pid
LEFT JOIN 2016_birms_econtract.tkontrak_penunjukan ON tpengadaan.pgid = tkontrak_penunjukan.pgid
LEFT JOIN 2016_birms_eproject_planning.tbl_pekerjaan ON tpekerjaan.pekerjaanID = 2016_birms_eproject_planning.tbl_pekerjaan.pekerjaanID
LEFT JOIN 2016_birms_eproject_planning.tbl_sirup ON 2016_birms_eproject_planning.tbl_pekerjaan.sirupID = 2016_birms_eproject_planning.tbl_sirup.sirupID
-- WHERE tpengadaan.ta = 2016 AND tbl_pekerjaan.sirupID <> 0 AND NOT ISNULL(tbl_pekerjaan.sirupID) 
LIMIT 1';
 

		$planning_sql = "SELECT pekerjaanID, 
						2016_birms_eproject_planning.tbl_sirup.sirupID, 
						namapekerjaan, tahun, nama 
						FROM 
						2016_birms_eproject_planning.tbl_sirup ,
						2016_birms_eproject_planning.tbl_pekerjaan
						where 2016_birms_eproject_planning.tbl_sirup.sirupID='3662192'
						AND 2016_birms_eproject_planning.tbl_pekerjaan.sirupID = 2016_birms_eproject_planning.tbl_sirup.sirupID
						";


		$planning  = DB::select($planning_sql);	
		$planning = $planning[0];


		$pekerjaanID = $planning->pekerjaanID;


		$tender_sql = "SELECT * FROM 2016_birms_econtract.tpekerjaan where pekerjaanID = '" . $pekerjaanID .  "'";	

		$tender = DB::select($tender_sql);	
		$tender = $tender[0];		

		$pid = $tender->pid;


		$items_sql = "SELECT * FROM 2016_birms_econtract.tpekerjaan where pid = '" . $pid .  "'";
		$items = DB::select($items_sql);	

		$tender_stage = array('pid' => $pid , 'items'=> $items );

		$planning_tst = "http://localhost:8000/api/contracts/year/2016";


		// $tender_slq = "SELECT * FROM 2016_birms_econtract.tpengadaan_pemenang";

		
		// $results = DB::select($sql);
		// $results = $results[0];
    	

  //   	$ocid = env('OCID') . $results->sirupID ;

		// $id = '1';
		// $date = '20100101';
		// $tag = 'planning';

		// $initiationType = 'tender';
 
    	
 
 	// 	//////////////////////	
 	// 	// planning stage 	//
 	// 	//////////////////////

    	

  //   	$rationale = $results->nama;
  //   	$project =  $results->namapekerjaan;
  //   	$projectID=  $results->pekerjaanID;
  //   	$source = $results->sumberdana;
 
  //   	$planning_value = array('amount' =>  $results->anggaran, 'currency'=> env('CURRENCY') );

  //   	$budget = array(
  //   					'id' => $results->kode ,
  //   					 'description' => $results->sumberdana,
  //   					 'value' => $planning_value,
  //   					 'project' => $project,
  //   					 'projectID' => $projectID,
  //   					 'source' => $source
  //   					);



  //   	///compiling all stages together
  //   	$planning_stage = array('rationale' =>  $rationale,
  //   							'budget' => $budget );

		// //////////////////////	
 	// 	// tender stage 	//
 	// 	//////////////////////

  //   	$tender_id = $results->pekerjaanID;
  //   	$tender_title = $results->namapekerjaan;
  //   	$tender_status= $results->stat;
  //   	$tender_procurementMethod = $results->metode_pengadaan;

  //   	$tender_stage = array ("id" => $tender_id,
  //   							"tender_title" => $tender_title,
  //   							"tender_status" => $tender_status,
  //   							"procurementMethod" => $tender_procurementMethod
  //   							);


  //   	//return $results;

  //   	$release  = array( 'ocid' => $ocid ,
  //   						'id' => $id,
  //   						'date' => $date,
  //   						'tag' => $tag,
  //   						'initiationType' => 'tender',
  //   						'planning' => $planning_stage,
  //   						'tender' => $tender_stage
    						
  //   					  );
    	return response()->json($planning_tst)->header('Access-Control-Allow-Origin', '*');

    	  // return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
