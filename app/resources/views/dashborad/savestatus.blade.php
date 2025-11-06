<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- <table>
        <thead>
            <tr>
                <th>NotirePairId</th>
                <th>Status</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <div class="status-action-section">
                <h3>อัพเดตสถานะการติดตาม</h3>
                
                <form action="{{ route('submit.repair.status') }}" method="POST">
                    @csrf 
                    
                    <input type="hidden" name="NotirepairId" value="{{ $NotirepairId->NotirepairId }}">
                    
                    <button type="submit" class="btn btn-warning">
                        ✅ ยืนยันการรับเรื่อง (NOTRECEIVED)
                    </button>
                    
                </form>
            </div>
        </tbody>
    </table>
    <button>กดรับ</button> --}}


    {{-- <div class="card p-4">
        <h3>อัพเดตสถานะการแจ้งซ่อม</h3>
        
        <form action="{{ route('submit.repair.status') }}" method="POST">
            @csrf 
            
            <input type="hidden" name="NotirepairId" value="{{ $NotirepairId->NotirepairId ?? '' }}">
            
            <input type="hidden" name="statustrackingId" value=""> 
    
            <div class="mb-3">
                <label for="statusSelect" class="form-label">เลือกสถานะ:</label>
                <select name="status" id="statusSelect" class="form-control" required>
                    <option value="" disabled selected>--- กรุณาเลือกสถานะ ---</option>
                    
                    <option value="ยังไม่ได้รับของ">ยังไม่ได้รับของ</option>
                    <option value="ได้รับของเเล้ว">ได้รับของเเล้ว</option>
                    <option value="ยังไม่ส่งSuplier">ยังไม่ส่งSuplier</option>
                    <option value="ส่งSuplierเเล้ว">ส่งSuplierเเล้ว</option>
                    <option value="ยังไม่ดำเนินการซ่อม">ยังไม่ดำเนินการซ่อม</option>
                    <option value="ซ่อมงานเสร็จเเล้ว">ซ่อมงานเสร็จเเล้ว</option>
                </select>
            </div>
    
            <button type="submit" class="btn btn-primary">
                บันทึกสถานะการติดตาม
            </button>
        </form>
        
    </div> --}}
    {{-- <div class="card p-4">
        <h3>อัพเดตสถานะการแจ้งซ่อม: ID #{{ $notirepair->id }}</h3>
        
        <form action="{{ route('submit.repair.status') }}" method="POST">
            @csrf 
            
            <input type="hidden" name="NotirepairId" value="{{ $notirepair->id }}">
            <input type="hidden" name="statustrackingId" value=""> 
    
            <div class="mb-3">
                <label for="statusSelect" class="form-label">เลือกสถานะ:</label>
                <select name="status" id="statusSelect" class="form-control" required>
                    <option value="" disabled selected>--- กรุณาเลือกสถานะ ---</option>
                    
                    @foreach ($statuses as $status_enum)
                        <option value="{{ $status_enum->value }}">
                            {{ $status_enum->value }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <button type="submit" class="btn btn-primary">
                บันทึกสถานะการติดตาม
            </button>
        </form>
    </div> --}}
</body>
</html>