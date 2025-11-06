<?php

use App\Models\Mastbranchinfo;
use Laravel\Sanctum\Sanctum;

class MastbranchinfoRepository{
    public static function getAllBranch(){
        return Mastbranchinfo::all();
    }
    public static function getBranchByCode($MBranchInfo_Code){
        return Mastbranchinfo::where('MBranchInfo_Code', $MBranchInfo_Code )->get();
    }
}
?>