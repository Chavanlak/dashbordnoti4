<?php
namespace App\DTO;
class NotiRepairDTO
{
    public $NotirepairId;
    public $equipmentId;
    public $userId;
    public $MBranchInfo_Code ;
    public $DateNotirepair;
    public $DeatailNotirepair;
    public $zone;
    public $branch;
    public $status; // สมมติว่าเป็นอ็อบเจ็กต์ที่เก็บสถานะล่าสุด

    public function __construct($NotirepairId, $equipmentId, $userId, $MBranchInfo_Code, $DateNotirepair, $DeatailNotirepair, $zone, $branch, $status)
    {
        $this->NotirepairId = $NotirepairId;
        $this->equipmentId = $equipmentId;
        $this->userId = $userId;
        $this->MBranchInfo_Code = $MBranchInfo_Code;
        $this->DateNotirepair = $DateNotirepair;
        $this->DeatailNotirepair = $DeatailNotirepair;
        $this->zone = $zone;
        $this->branch = $branch;
        $this->status = $status;

    }
}
