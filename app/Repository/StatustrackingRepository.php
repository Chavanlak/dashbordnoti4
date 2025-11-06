<?php

namespace App\Repository;

use App\Models\Statustracking;
use App\Models\NotiRepair;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

use App\Enums\TrackingStatus;
// enum AsStringable: string
enum TrackingStatusEnum: string
{
    // ค่าต้องตรงกับในฐานข้อมูล'('ยังไม่ได้รับของ','ได้รับของเเล้ว','ยังไม่ส่งSuplier','ส่งSuplierเเล้ว','ยังไม่ดำเนินการซ่อม','ซ่อมงานเสร็จเเล้ว'
    case NOTRECEIVED = 'ยังไม่ได้รับของ';
    case RECEIVED = 'ได้รับของเเล้ว';
    case NOTSENTTOSUPPLIER = 'ยังไม่ส่งSuplier';
    case SENTTOSUPPLIER = 'ส่งSuplierเเล้ว';
    case REPAIRNOTSTARTED = 'ยังไม่ดำเนินการซ่อม';
    case REPAIRFINISHED = 'ซ่อมงานเสร็จเเล้ว';
    // case WORKNOTFINISHED = 'ยังไม่เสร็จงาน';
}
class StatustrackingRepository
{
    public static function getLatestStatusByNotiRepairId($notiRepairId)
    {
        return Statustracking::where('NotirepairId', $notiRepairId)
            ->orderBy('statustrackingId', 'desc') // เรียงลำดับจากใหม่ไปเก่า
            ->first()->status; //จะเอา เเค่ status ไปใส่ใน DTO
            // ดึงแค่รายการแรก (สถานะล่าสุด)
    }


    // public static function getstatustrackingById()
    // {
    //     return Statustracking::where('statustrackingId')->get();
    // }
    public static function getStatustrackingById($statustrackingId) // เพิ่ม parameter
    {
        // ใช้ where() เพื่อกรองตาม ID แล้วใช้ first() เพื่อให้ได้ Model Object เดียว
        return Statustracking::where('statustrackingId', $statustrackingId)->first();
    }

    public static function getNotirepirById()
    {
        //ดึงมาทั้งหมด
        return Statustracking::where('NotirepairId')->get();
    }
    //use this
    public static function updateStatus($statustrackingId, $status)
    {
        DB::table('statustracking')
            ->where('statustrackingId', $statustrackingId)
            ->update(['status' => $status->value]); // enum -> string
    }
    public static function getAllStatustracking()
    {
        return Statustracking::all();
    }
    //one many relation เพื่อดึงสถานะล่าสุดของ notirepair
    public static function updateNotiStatus($notirepaitid, $status,$statusDate)
    {
        $statustracking = new Statustracking();
        $statustracking->NotirepairId = $notirepaitid;
        $statustracking->status = $status;
        // $statustracking->statusDate = $statusDate;
        $statustracking->StatusDate = Carbon::now();
        // $statustracking->statustrackingId;
        $statustracking->save();
        // อัปเดตสถานะใน notirepair
        // self::updateNotiStatus($notirepaitid, 'ได้รับของเเล้ว');
        // Statustracking::where('NotirepairId', $notirepaitid)
        // ->update(['status' => 'ได้รับของแล้ว']);

        return $statustracking;

    }

    public static function acceptNotirepair($notirepaitid)
    {
        $statustracking = new Statustracking();
        $statustracking->NotirepairId = $notirepaitid;
        $statustracking->status = 'ได้รับของเเล้ว';
        // $statustracking->statustrackingId;
        $statustracking->save();
        // อัปเดตสถานะใน notirepair
        // self::updateNotiStatus($notirepaitid, 'ได้รับของเเล้ว');
        // Statustracking::where('NotirepairId', $notirepaitid)
        // ->update(['status' => 'ได้รับของแล้ว']);

        return $statustracking;
    }
//     public static function acceptNotirepair($notirepaitid)
// {
//     return Statustracking::where('NotirepairId', $notirepaitid)
//         ->update(['status' => 'ได้รับของแล้ว']);
// }

    public static function updateStatusNotirepair($notirepaitid, $statusData)
    {
        $statustracking = new Statustracking();
        $statustracking->NotirepairId = $notirepaitid;
        $statustracking->status = $statusData;
        $statustracking->save();
        return $statustracking;
    }
    public static function getNotiDetails($notirepaitid)
    {
        // ดึงข้อมูลการแจ้งซ่อม พร้อมโหลดความสัมพันธ์ของสถานะ (ถ้ามี)
        $notiDetail = Notirepair::where('NotirepairId', $notirepaitid)
            // สมมติว่าใน Notirepair Model มีความสัมพันธ์ชื่อ 'statusTracking'
            // ถ้าไม่มีความสัมพันธ์ ให้ใช้ join() แทน
            ->with('statusTracking')
            ->first();

        return $notiDetail;
    }
    //การรับของ
    // public static function getNotReceivedItems() {

    //     return Statustracking::where('status', AsStringable::NOTRECEIVED)
    //                          ->get();

    // }
    // public static function getNotReceivedItems():Collection{
    //     return Statustracking::where('status', AsStringable::NOTRECEIVED->value)
    //                          ->get();
    // }
    // public static function updateStatus($statustrackingId, AsStringable $newStatus) {
    //     $status = Statustracking::find($statustrackingId);
    //    if(!$status){
    //     return false;
    //    }
    //    $status->status = $newStatus->value;
    //      $status->save();

    //      return true;

    // }


    // public static function getNotSentToSupplierItems()
    // {

    //     return Statustracking::where('status', AsStringable::NOTSENTTOSUPPLIER)
    //         ->get();
    // }
    // public static function checkstatus()
    // {

    //     $status = AsStringable::NOTRECEIVED;
    //     if ($status->value === 'ยังไม่ได้รับของ') {
    //     }
    // }
    //     if(Statustracking::where('status', AsStringable::NOTRECEIVED)->exists()){
    //         return true;
    // }
    // if(AsStringable::NOTRECEIVED === 1){
    //     return true;
    // }
    // if(AsStringable::NOTRECEIVED->value === 'ยังไม่ได้รับของ'){
    //     return true;
    // }




    // ฟังก์ชันสำหรับสร้างรายการสถานะเริ่มต้น
    // public static function createNewItem(array $data)
    // {
    //     $data['status'] = AsStringable::NOTRECEIVED; // กำหนดสถานะด้วย Enum
    //     return Statustracking::create($data);
    // }
    // public static function getNotReceivedItems() {
    //     // ✅ แก้: ใช้ชื่อ Namespace นำหน้า
    //     return Statustracking::where('status', \App\Repository\TrackingStatus::ITEM_NOT_RECEIVED)
    //                          ->get();
    // }

    // public static function createNewItem(array $data) {
    //     // ✅ แก้: ใช้ชื่อ Namespace นำหน้า
    //     $data['status'] = \App\Repository\TrackingStatus::ITEM_NOT_RECEIVED;
    //     return Statustracking::create($data);
    // }
}
//
