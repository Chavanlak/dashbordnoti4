<?php
namespace App\Repository;
use App\Models\Equipmenttype;
class EquipmenttypeRepository{
    public static function getAllEquipmenttype(){
        return Equipmenttype::all();
    }
    public static function getEquipmentTypeById($TypeId){
        return Equipmenttype::where('TypeId',$TypeId)->first();
    }
    public static function getEmailRepair(){
        return Equipmenttype::select(
            'emailrepair.emailRepairId',
            'emailrepair.emailRepair',
            'equipmenttype.TypeName'
        )
        ->join('emailrepair','equipmenttype.emailRepairId','=','emailrepair.emailRepairId')
        ->where('equipmenttype.TypeId')
        ->first();
      

    }
    // public static function getEmailRepair($typeId)
    // {
    //     return Equipmenttype::select(
    //             'emailrepair.emailRepairId',
    //             'emailrepair.emailRepair',
    //             'equipmenttype.TypeName'
    //         )
    //         ->join('emailrepair','equipmenttype.emailRepairId','=','emailrepair.emailRepairId')
    //         ->where('equipmenttype.TypeId', $typeId)  
    //         ->first();  
    // }
    
}
?>