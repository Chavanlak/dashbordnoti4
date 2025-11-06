<?php

namespace App\Repository;

use App\DTO\NotiRepairDTO;
use App\Models\NotiRepair;
use App\Models\Statustracking;
use Carbon\Carbon;

class NotiRepairRepository
{
    // public static function getNotirepirById()
    //     {
    //         // return NotiRepair::where('NotirepairId')->get();
    //         return NotiRepair::where('NotirepairId')->first();

    //     }


    // public static function getNotirepirById($statustrackingId)
    // {
    //     // สมมติว่าในตาราง NotiRepair มีฟิลด์ 'statustrackingId' สำหรับเชื่อมโยง

    //     // ใช้ where() ตามด้วย get() ซึ่งจะคืนค่าเป็น Collection (Array/Object) เสมอ
    //     // ถ้าไม่พบข้อมูล จะคืนค่าเป็น Collection เปล่า ซึ่ง foreach สามารถจัดการได้
    //     return NotiRepair::where('statustrackingId', $statustrackingId)->get();

    //     // หรือถ้าคุณต้องการให้สามารถใช้ foreach ได้แม้ว่าจะดึงข้อมูลเดียว:
    //     // return NotiRepair::where('statustrackingId', $statustrackingId)->get();
    // }
    // ใน NotiRepairRepository

    public static function getNotirepirById($notiRepairId)
    {
        return NotiRepair::where('NotirepairId', $notiRepairId)->get();
    }
    public static function getAllNotirepair()
    {
        return NotiRepair::all();
    }
    //6/11/68
    public static function getAllNotirepairAndStatus(){
        return NotiRepair::select('notirepair.NotirepairId',
        'notirepair.equipmentId',
        'notirepair.userId',
        'notirepair.MBranchInfo_Code',
        'notirepair.DateNotirepair',
        'notirepair.DeatailNotirepair',
        'notirepair.zone',
        'notirepair.branch',
        'statustracking.status')->join('statustracking', 'statustracking.NotirepairId', '=', 'notirepair.NotirepairId')
        ->get();
    }
    public static function getNotirepairById($notirepaitid)
    {
        return NotiRepair::where('NotirepairId', $notirepaitid)->first();
    }
    //inner join กับ statustracking
    public static function getNotirepairandStatusById($notirepaitid) {}
    public static function getNotiRepairDTO()
    {
        // ดึงข้อมูล NotiRepairปกติ ออกกมาก่อน
        $notiRepairs = NotiRepair::all();
        $notiRepairDTOs = [];
        foreach ($notiRepairs as $notiRepair) {
            // ดึงสถานะล่าสุดจาก StatustrackingRepository
            $latestStatus = StatustrackingRepository::getLatestStatusByNotiRepairId($notiRepair->NotirepairId);
            // สร้าง NotiRepairDTO
            $notiRepairDTO = new NotiRepairDTO(
                $notiRepair->NotirepairId,
                $notiRepair->equipmentId,
                $notiRepair->userId,
                $notiRepair->MBranchInfo_Code,
                $notiRepair->DateNotirepair,
                $notiRepair->DeatailNotirepair,
                $notiRepair->zone,
                $notiRepair->branch,
                $latestStatus
            );
            $notiRepairDTOs[] = $notiRepairDTO;
        }
        return $notiRepairDTOs;
    }
    public static function getStatus() {
        $statusList = Statustracking::join('notirepair','statustracing.NotirepairId','=','notirepair.NotirepairId')
        ->select('statustracking.NotirepairId', 'statustracking.status')
        ->get();
        dd($statusList);
        // return $statusList;
    }
    public static function updateStatus() {

    }
}
