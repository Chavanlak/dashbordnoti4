<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotiRepair extends Model
{
    protected $table = 'notirepair';
    protected $primaryKey = 'NotirepairId';
    public $timestamps = false;
    public function statusTracking()
    {
        // $this->hasOne(Model ที่เชื่อมไปหา, Foreign Key ใน Statustracking, Local Key ใน NotiRepair)
        return $this->hasOne(Statustracking::class, 'NotirepairId', 'NotirepairId');
    }
    use HasFactory;
}
