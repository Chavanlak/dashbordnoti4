<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

//NotirepairController
// public static function ShowNotiRepair(){
//     return view('notirepair');
// }
// public static function Submit1(Request $request){
//       //dateReceiveFromBranch วันที่รับมาจากสาขา
// //dateSenttoSubplier  วันที่เเจ้งส่งซัพพลายเออร์
// //วันที่ซัพพลายเออร์ซ่อมเสณ้จเเล้วส่งคืน dateReceiveFromSubplier เเสดงว่าเรียบร้อยรอกดปิดงาน
// //ซ่อมเสร็จเเล้วส่งคืนสาขา (วันที่)dateJobReturnToBranch (สถานะการปิดงาน) StatusJobClosed
//     $NotirepairId = $request->NotirepairId;
//     // $dateReceiveFromBranch = $request->dateReceiveFromBranch;
//     $dateReceiveFromBranch = Carbon::now($request->dateReceiveFromBranch)->toDateTimeString();
//     $dateSenttoSubplier = $request->dateSenttoSubplier;
//     $dateReceiveFromSubplier = $request->dateReceiveFromSubplier;
//     $dateJobReturnToBranch = $request->dateJobReturnToBranch;
//     $StatusJobClosed = $request->StatusJobClosed;
//     // dd($dateReceiveFromBranch);

//     // $item ;
//     // if($item->dateReceiveFromBranch == 'ยังไม่ได้รับของ'){
//     //     return $item;
//     // }
//     // if($dateReceiveFromBranch =='ยังไม่ได้รับของ'){
//     //     return redirect('/admintecnicial');
//     // }
//     $notirepair = NotiRepairRepository::SaveRepair($NotirepairId, $dateReceiveFromBranch, $dateSenttoSubplier, $dateReceiveFromSubplier, $dateJobReturnToBranch, $StatusJobClosed);
//     return $notirepair;
//     return view('dashborad.admintecnicial');
  
// }
// public static function updateRepair(){

// }
// public static function getJobDetails($NotirepairId)
// {
// return NotiRepair::select(
//     'dateReceiveFromBranch', 
//     'dateSenttoSubplier', 
//     'dateReceiveFromSubplier', 
//     'dateJobReturnToBranch', 
//     'StatusJobClosed'
// )
// ->find($NotirepairId);
// }
// public static function Submit2(Request $request)
// {
//     // 1. รับค่า NotirepairId
//     $NotirepairId = $request->input('NotirepairId');
    
//     // 2. รับค่าวันที่ที่ต้องการบันทึก (วันที่ส่งมาจาก JS ควรเป็นรูปแบบ ISO 8601, เช่น 2025-10-21 16:03:00)
//     // dateReceiveFromBranch คือ วันที่รับมาจากสาขา
//     $dateReceiveFromBranchRequest = $request->input('dateReceiveFromBranch');
    
//     // 3. แปลงค่าวันที่ด้วย Carbon
//     if ($dateReceiveFromBranchRequest) {
//         // ใช้ Carbon::parse() เพื่อแปลงวันที่ที่เป็นมาตรฐาน (ISO 8601) ให้เป็น DateTime String
//         $dateReceiveFromBranch = Carbon::parse($dateReceiveFromBranchRequest)->toDateTimeString();
//         // ตัวอย่างค่าที่ได้: "2025-10-21 16:03:00" (รูปแบบที่ฐานข้อมูลต้องการ)
//     } else {
//         // ถ้าไม่ได้ส่งค่ามา ให้บันทึกเป็น null หรือค่าตั้งต้นที่ต้องการ (ถ้าฐานข้อมูลอนุญาต)
//         $dateReceiveFromBranch = null; 
//     }

//     // 4. รับค่าวันที่อื่นๆ ที่เกี่ยวข้อง
//     $dateSenttoSubplier = $request->input('dateSenttoSubplier');
//     $dateReceiveFromSubplier = $request->input('dateReceiveFromSubplier');
//     $dateJobReturnToBranch = $request->input('dateJobReturnToBranch');
//     $StatusJobClosed = $request->input('StatusJobClosed');

//     // 5. เรียกใช้ Repository เพื่อบันทึกข้อมูล
//     // ตรวจสอบให้แน่ใจว่า NotiRepairRepository::SaveRepair รองรับค่า null สำหรับวันที่ที่ยังไม่ถูกตั้งค่า
//     $notirepair = NotiRepairRepository::SaveRepair(
//         $NotirepairId, 
//         $dateReceiveFromBranch, // วันที่ที่ถูกแปลงแล้ว
//         $dateSenttoSubplier, 
//         $dateReceiveFromSubplier, 
//         $dateJobReturnToBranch, 
//         $StatusJobClosed
//     );

//     // 6. ส่งค่ากลับ (ตัวอย่างการส่ง JSON response สำหรับ AJAX)
//     return response()->json([
//         'status' => 'success',
//         'message' => 'บันทึกสถานะงานซ่อมเรียบร้อยแล้ว',
//         'data' => $notirepair
//     ]);

    

// }
// public static function getJobStatus(Request $request)
// {
// // ดึง NotirepairId จากพารามิเตอร์ใน URL
// $NotirepairId = $request->route('NotirepairId');

// if (!$NotirepairId) {
//     return response()->json([
//         'status' => 'error',
//         'message' => 'ไม่พบ NotirepairId ที่ต้องการค้นหา'
//     ], 400); 
// }

// // 1. เรียกใช้ Repository เพื่อดึงข้อมูลงานซ่อม
// // Repository จะใช้ NotiRepair::select(...) ตามที่คุณกำหนด
// $jobDetails = NotiRepairRepository::getJobDetails($NotirepairId);

// if (!$jobDetails) {
//     return response()->json([
//         'status' => 'error',
//         'message' => 'ไม่พบข้อมูลงานซ่อมสำหรับ ID นี้'
//     ], 404);
// }

// // 2. ส่งข้อมูลกลับแบบ JSON เพื่อให้หน้า Blade นำไปแสดงผล
// return response()->json([
//     'status' => 'success',
//     'data' => $jobDetails
// ]);
// }

// /**
// * ดำเนินการบันทึกสถานะการซ่อม (สำหรับ Route POST)
// * Route: /submit
// *
// * @param Request $request
// * @return \Illuminate\Http\JsonResponse
// */
// public static function Submit(Request $request)
// {
// // 1. รับค่า NotirepairId
// $NotirepairId = $request->input('NotirepairId');

// // 2. รับค่าวันที่ที่ต้องการบันทึก (วันที่ส่งมาจาก JS เป็นรูปแบบ ISO 8601, ค.ศ.)
// $dateReceiveFromBranchRequest = $request->input('dateReceiveFromBranch');

// // 3. แปลงค่าวันที่ด้วย Carbon
// $dateReceiveFromBranch = null; 
// if ($dateReceiveFromBranchRequest) {
//     // แปลง ISO 8601 (ค.ศ.) ให้เป็น DateTime String ที่ฐานข้อมูลต้องการ
//     try {
//         $dateReceiveFromBranch = Carbon::parse($dateReceiveFromBranchRequest)->toDateTimeString();
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'error', 'message' => 'รูปแบบวันที่รับจากสาขาไม่ถูกต้อง'], 400);
//     }
// } 

// // 4. รับค่าวันที่และสถานะอื่นๆ ที่เหลือ
// $dateSenttoSubplier = $request->input('dateSenttoSubplier');
// $dateReceiveFromSubplier = $request->input('dateReceiveFromSubplier');
// $dateJobReturnToBranch = $request->input('dateJobReturnToBranch');
// $StatusJobClosed = $request->input('StatusJobClosed');

// // 5. เรียกใช้ Repository เพื่อบันทึกข้อมูล
// $notirepair = NotiRepairRepository::SaveRepair(
//     $NotirepairId, 
//     $dateReceiveFromBranch, 
//     $dateSenttoSubplier, 
//     $dateReceiveFromSubplier, 
//     $dateJobReturnToBranch, 
//     $StatusJobClosed
// );

// // 6. ส่งค่ากลับแบบ JSON
// return response()->json([
//     'status' => 'success',
//     'message' => 'บันทึกสถานะงานซ่อมเรียบร้อยแล้ว',
//     'data' => $notirepair
// ]);
// }
// //หลัก
// public static function adminTechTest(){
// $notirepairs = NotiRepair::all();
// return view('dashborad.admintechtest', compact('notirepairs'));
// }
// public static function submitRepair(Request $request){
// // ดึง ID จาก Form
// $NotirepairId = $request->NotirepairId;

// // กำหนดสถานะใหม่ 
// $ReciveStateFromBranch = 'ได้รับของแล้ว';

// // กำหนดวันที่ได้รับของเป็นเวลาปัจจุบัน
// $dateReceiveFromBranch = now()->toDateTimeString();

// // เรียก Repository เพื่ออัปเดตข้อมูล
// $isUpdated = NotiRepairRepository::saveNotiRepair(
//     $NotirepairId,
//     $dateReceiveFromBranch,
//     $ReciveStateFromBranch
// );

// // 5. Redirect พร้อมข้อความแจ้งเตือน
// if($isUpdated){
//     return redirect('/admintechtest')->with('success', "รายการ ID $NotirepairId ได้รับการอัปเดตแล้ว ");
// }

// return redirect('/admintechtest')->with('error', "เกิดข้อผิดพลาดในการอัปเดตรายการ ID $NotirepairId ");
// }

//StatusTrackngConttroller
// public static function Submit(Request $request){
//     $statusupdate = $request->statusupdate;
//     $dateReceiveFromBranch = $request->dateReceiveFromBranch;
//     $dateReturntoSup = $request->dateReturntoSup;
//     $dateReceiveFromsub = $request->dateReceiveFromsub;

//     $statustracking = StatustrackingRepository::save($statusupdate, $dateReceiveFromBranch, $dateReturntoSup, $dateReceiveFromsub);
//     if($statusupdate == 'รับของเเล้ว'){
//         return redirect('/technical');
//     }
//     else if($statusupdate == 'ยังไม่ได้รับของ'){
//         return redirect('/statustracking');
//     }
//     return view();
// }