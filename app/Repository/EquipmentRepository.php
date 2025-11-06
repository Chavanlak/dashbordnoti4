<?php
namespace App\Repository;
use App\Models\Equipment;
class EquipmentRepository{
    public static function getEquipmentById(){
        return Equipment::where('equipmentId')->get();
    
    }
    public static function getAllEquipment(){
        return Equipment::all();
    }
    //ดึงอุปกรณ์มารายการเดียว
    public static function getEquipmentnameById($equipId){
        return Equipment::select(['equipmentName'])->where('equipmentId','=',$equipId)->first();
    }
    //ดึงหลายรายการ
    public static function getEquipmentNameandId(){
        return Equipment::select('equipmentId','equipmentName')->get();
    }
}
?>