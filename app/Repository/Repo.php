<?php
//NotiRepairRepository.php
//  public static function getAll(){
//     return NotiRepair::all();
// }   
// //dateReceiveFromBranch วันที่รับมาจากสาขา
// //dateSenttoSubplier  วันที่เเจ้งส่งซัพพลายเออร์
// //วันที่ซัพพลายเออร์ซ่อมเสณ้จเเล้วส่งคืน dateReceiveFromSubplier เเสดงว่าเรียบร้อยรอกดปิดงาน
// //ซ่อมเสร็จเเล้วส่งคืนสาขา (วันที่)dateJobReturnToBranch (สถานะการปิดงาน) StatusJobClosed
// public static function SaveRepair1($NotirepairId,$dateReceiveFromBranch,$dateSenttoSubplier,$dateReceiveFromSubplier,$dateJobReturnToBranch,$StatusJobClosed){
// $notirepair = new NotiRepair();
// $notirepair->NotirepairId = $NotirepairId;
// $notirepair->dateReceiveFromBranch = $dateReceiveFromBranch;
// $notirepair->dateSenttoSubplier = $dateSenttoSubplier;
// $notirepair->dateJobReturnToBranch = $dateJobReturnToBranch;
// $notirepair->StatusJobClosed = $StatusJobClosed;


// return $notirepair;
// }
// public static function update($dateReceiveFromBranch,$dateJobReturnToBranch,$dateSenttoSubplier,$dateReceiveFromSubplier,$StatusJobClosed){
// // $dateJobReturnToBranch = Carbon::now()->toDateString();
// // $dateSenttoSubplier = Carbon::now()->toDateString();
// $dateReceiveFromBranch = Carbon::now()->toDateTimeString();
// $dateJobReturnToBranch = Carbon::now()->toDateTimeString();
// $dateSenttoSubplier = Carbon::now()->toDateTimeString();
// $dateReceiveFromSubplier = Carbon::now()->toDateTimeString();

//   //กรณีที่ปิดงานเเล้ว
//   if($StatusJobClosed !='ยังไม่ปิดงาน'){
//     return $dateJobReturnToBranch;
// }
// //
// if($dateReceiveFromBranch != 'ยังไม่ได้รับของ'){
//     return $dateReceiveFromBranch;
//     if($dateReceiveFromBranch != Null){
//         return $dateSenttoSubplier;
//         if($dateSenttoSubplier != NUll)
//         {
//             return $dateReceiveFromSubplier;

//         }
//     }
//     return view('dashborad.admintecnicial');
// }
// else{
//     return view('dashborad.admintecnicial');
// }
// }

// public static function getID(){
//     return NotiRepair::select('NotirepairId')->get();
// }
// public static function getNotiRepairById($NotirepairId){
//     return NotiRepair::where('NotirepairId',$NotirepairId)->first();
// }
// public static function getJobDetails($NotirepairId)
// {
//     // โค้ดดึงข้อมูลที่คุณให้มา
//     return NotiRepair::select(
//         'dateReceiveFromBranch', 
//         'dateSenttoSubplier', 
//         'dateReceiveFromSubplier', 
//         'dateJobReturnToBranch', 
//         'StatusJobClosed'
//     )
//     ->find($NotirepairId);
// }

// /**
//  * บันทึกหรืออัปเดตสถานะงานซ่อม
//  * @param int $NotirepairId
//  * @param string|null $dateReceiveFromBranch
//  * @param string|null $dateSenttoSubplier
//  * @param string|null $dateReceiveFromSubplier
//  * @param string|null $dateJobReturnToBranch
//  * @param string|null $StatusJobClosed
//  * @return NotiRepair
//  */
// public static function SaveRepair(
//     $NotirepairId, 
//     $dateReceiveFromBranch, 
//     $dateSenttoSubplier, 
//     $dateReceiveFromSubplier, 
//     $dateJobReturnToBranch, 
//     $StatusJobClosed
// )
// {
//     $job = NotiRepair::findOrNew($NotirepairId); // ใช้ findOrNew ในกรณีที่อาจจะยังไม่มี
    
//     // อัปเดตเฉพาะฟิลด์ที่มีค่าถูกส่งมา
//     if ($dateReceiveFromBranch) {
//         $job->dateReceiveFromBranch = $dateReceiveFromBranch;
//     }
//     if ($dateSenttoSubplier) {
//         $job->dateSenttoSubplier = $dateSenttoSubplier;
//     }
//     if ($dateReceiveFromSubplier) {
//         $job->dateReceiveFromSubplier = $dateReceiveFromSubplier;
//     }
//     if ($dateJobReturnToBranch) {
//         $job->dateJobReturnToBranch = $dateJobReturnToBranch;
//     }
//     if ($StatusJobClosed) {
//         $job->StatusJobClosed = $StatusJobClosed;
//     }
    
//     $job->save();
//     return $job;
// }



// // public static function SaveRepair($NotirepairId, $dateReceiveFromBranch, $dateSenttoSubplier)
// // {
// //     $job = NotiRepair::find($NotirepairId);

// //     $job->dateReceiveFromBranch = $dateReceiveFromBranch; 
// //     $job->dateSenttoSubplier = $dateSenttoSubplier;


// //     $job->save();
// //     return $job;
// // }
// //หลัก
// public static function saveNotiRepair($NotirepairId, $dateReceiveFromBranch, $ReciveStateFromBranch){
// // 1. ค้นหาเรคคอร์ดที่มีอยู่ด้วย ID
// // สมมติชื่อ Model คือ NotiRepair (เปลี่ยนตาม Model ของคุณ)
// $notiRepair = NotiRepair::find($NotirepairId); 

// // 2. ตรวจสอบว่าพบเรคคอร์ดหรือไม่
// if ($notiRepair) {
//     // 3. อัปเดตฟิลด์ที่ต้องการ
//     $notiRepair->dateReceiveFromBranch = $dateReceiveFromBranch;
//     $notiRepair->ReciveStateFromBranch = $ReciveStateFromBranch;

//     // 4. บันทึกการเปลี่ยนแปลง (Update)
//     return $notiRepair->save(); 
// }

// // หากไม่พบ ID ให้คืนค่า false
// return false;
// }

//StatustrackingRepository.php
// public static function getAllStatustracking(){
//     return Statustracking::all();
// }

// public static function save($statusupdate,$dateReceiveFromBranch,$dateReturntoSup,$dateReceiveFromsub){
//     $statustracking = new Statustracking();
//     $statustracking->statusupdate = $statusupdate;
//     $statustracking->dateReceiveFromBranch = $dateReceiveFromBranch;
//     $statustracking->dateReturntoSup = $dateReturntoSup;
//     $statustracking->dateReceiveFromsub = $dateReceiveFromsub;
//     $statustracking->save();
//     return $statustracking;
// }
// public static function findStatus(){
//     return Statustracking::where('statusupdate','ยังไม่ได้รับของ')->get();
// }
?>