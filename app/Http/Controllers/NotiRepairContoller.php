<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Repository\NotiRepairRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\NotiRepair;
use App\Repository\EquipmentRepository;
use App\Repository\EquipmenttypeRepository;
use App\Repository\StatustrackingRepository;
use Illuminate\Support\Facades\DB;
class NotiRepairContoller extends Controller
{
// public static function checkNotiRepair(){
//     $noti = NotiRepairRepository::getAllNotirepair();
//     // dd($noti);
//     return view('dashborad.notirepairlist', compact('noti'));
// }
// public static function checkNotiRepair(){
//     $noti = NotiRepairRepository::getAllNotirepairAndStatus();
//     return view('dashborad.notirepairlist', compact('noti'));
// }
// public static function checkNotiRepair(){
//     // 1. สร้าง Subquery เพื่อค้นหา NotirepairId และ วันที่สถานะล่าสุด (MAX(StatusDate))
//     //    *เราเลือกแค่ 2 คอลัมน์นี้เพื่อหลีกเลี่ยง error GROUP BY*
//     $latestStatusDate = DB::table('statustracking')
//         ->select('NotirepairId', DB::raw('MAX(StatusDate) as latest_update')) 
//         ->groupBy('NotirepairId');

//     // 2. ใช้ Eloquent (NotiRepair Model) ร่วมกับ leftJoinSub
//     $noti = NotiRepair::select('notirepair.*', 'latest_status.status as status')
        
//         // LEFT JOIN ครั้งที่ 1: Join ตารางแจ้งซ่อมกับ Subquery เพื่อให้ได้วันที่ล่าสุดของแต่ละรายการ
//         ->leftJoinSub($latestStatusDate, 'latest_date', function($join) {
//             // เงื่อนไขการ Join: NotirepairId ตรงกัน
//             $join->on('notirepair.NotirepairId', '=', 'latest_date.NotirepairId');
//         })
        
//         // LEFT JOIN ครั้งที่ 2: Join ตารางแจ้งซ่อมกับตาราง statustracking อีกครั้ง 
//         //                   เพื่อดึงสถานะจริงที่ตรงกับวันที่ล่าสุดนั้น (Latest Date)
//         ->leftJoin('statustracking as latest_status', function($join) {
//             $join->on('latest_status.NotirepairId', '=', 'notirepair.NotirepairId')
//                  // เงื่อนไขสำคัญ: ต้องเป็นสถานะที่ตรงกับวันที่ล่าสุดที่หามาได้ใน Subquery
//                  ->on('latest_status.StatusDate', '=', 'latest_date.latest_update'); //<--- ปัญหาน่าจะอยู่ตรงนี้ เลยทำให้มีการเบิ้ล
//         })

//         // ใช้ orderBy เพื่อจัดเรียงการแสดงผล (เช่น เรียงจากวันที่แจ้งล่าสุด)
//         ->orderBy('notirepair.DateNotirepair', 'desc')
//         ->get();
        
//     return view('dashborad.notirepairlist', compact('noti'));
// }
public static function checkNotiRepair(){
    // 1. สร้าง Subquery เพื่อค้นหา NotirepairId และ ID สถานะล่าสุด (MAX(statustrackingId))
    //    ID ล่าสุดมีความน่าเชื่อถือกว่าวันที่/เวลา ในการหา Record ล่าสุด
    $latestStatusId = DB::table('statustracking')
        ->select('NotirepairId', DB::raw('MAX(statustrackingId) as latest_id')) 
        ->groupBy('NotirepairId');

    // 2. ใช้ Eloquent (NotiRepair Model) ร่วมกับ leftJoinSub
    $noti = NotiRepair::select('notirepair.*', 'latest_status.status as status')
        
        // LEFT JOIN ครั้งที่ 1: Join ตารางแจ้งซ่อมกับ Subquery เพื่อให้ได้ ID สถานะล่าสุด
        ->leftJoinSub($latestStatusId, 'latest_id_table', function($join) {
            // เงื่อนไขการ Join: NotirepairId ตรงกัน
            $join->on('notirepair.NotirepairId', '=', 'latest_id_table.NotirepairId');
        })
        
        // LEFT JOIN ครั้งที่ 2: Join ตารางแจ้งซ่อมกับตาราง statustracking อีกครั้ง 
        //                   เพื่อดึงสถานะจริงที่ตรงกับ ID สถานะล่าสุด
        ->leftJoin('statustracking as latest_status', function($join) {
            $join->on('latest_status.NotirepairId', '=', 'notirepair.NotirepairId')
                 // เงื่อนไขสำคัญ: ต้องเป็นสถานะที่ตรงกับ ID ล่าสุดที่หามาได้ใน Subquery
                 // *** เปลี่ยนมาใช้ statustrackingId แทน StatusDate ***
                 ->on('latest_status.statustrackingId', '=', 'latest_id_table.latest_id');
        })

        // ใช้ orderBy เพื่อจัดเรียงการแสดงผล (เช่น เรียงจากวันที่แจ้งล่าสุด)
        ->orderBy('notirepair.DateNotirepair', 'desc')
        ->get();
        
    return view('dashborad.notirepairlist', compact('noti'));
}
public static function reciveNotirepair($notirepaitid){
    $recivenoti = NotiRepairRepository::getNotirepairById($notirepaitid);

    return view('dashborad.notripair', compact('recivenoti'));

}
public static function acceptNotisRepair($notirepaitid){
$acceptnoti = StatustrackingRepository::acceptNotirepair($notirepaitid);
return redirect()->route('noti.show_update_form', ['notirepaitid' => $notirepaitid])
        ->with('success', 'รับเรื่องเรียบร้อยแล้ว! เข้าสู่หน้าอัพเดตสถานะ');

}
// public static function updateStatus($notirepaitid,$statusData){
//     $updatenoti = StatustrackingRepository::updateNotiStatus($notirepaitid,$statusData);
//     return view('dashborad.updatestatus',compact('updatenoti'));
// }
// ฟังก์ชันใหม่สำหรับแสดงหน้าฟอร์มอัพเดตสถานะ (Route: noti.show_update_form)
public function showUpdateStatusForm($notirepaitid){
    // ดึงข้อมูลการแจ้งซ่อมที่ต้องการอัพเดต
    $updatenoti = StatustrackingRepository::getNotiDetails($notirepaitid);

    // คืนค่า View dashborad.updatestatus
    return view('dashborad.updatestatus', compact('updatenoti'));
}
public function updateStatus(Request $request){

    $notirepaitid = $request->NotirepairId;
    $statusData = $request->status;
    $statusDate = $request->statusDate;
    //status เป็นเเค่ชื่อที่ตั้งให้เหมือน name ใน html เเต่ตั้งชื่อให้เหมือน database
    // เรียกใช้ Repository เพื่ออัพเดตสถานะ
    StatustrackingRepository::updateNotiStatus($notirepaitid, $statusData,$statusDate);

    // เปลี่ยนเส้นทางกลับไปยังหน้ารายการแจ้งซ่อมพร้อมข้อความสำเร็จ
    return redirect()->route('noti.list')
        ->with('success', 'อัพเดตสถานะเรียบร้อยแล้ว!');


}
    public static function check(){
    $results = DB::table('statustracking')
    ->join('notirepair', 'statustracking.NotirepairId', '=', 'notirepair.NotirepairId')
    ->select('statustracking.NotirepairId', 'statustracking.status')
    ->get();
    dd($results);
    // return $results;
    }



}
