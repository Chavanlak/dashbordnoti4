<!DOCTYPE html>
<html lang="en">
<body class="p-4">

    <h3>รายละเอียดแจ้งซ่อม (อัพเดตสถานะ)</h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>รหัสแจ้งซ่อม</th>
                <th>อุปกรณ์</th>
                <th>รายละเอียด</th>
                <th>วันที่แจ้ง</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- ✅ ใช้ $updatenoti ที่ถูกส่งมาจาก Controller --}}
                <td>{{ $updatenoti->NotirepairId }}</td>
                <td>{{ $updatenoti->equipmentId }}</td>
                <td>{{ $updatenoti->DeatailNotirepair }}</td>
                <td>{{ $updatenoti->DateNotirepair }}</td>
                <td>
                    {{-- แสดงสถานะปัจจุบัน --}}
                    {{ $updatenoti->statusTracking->status ?? 'ไม่พบสถานะ' }}
                </td>
            </tr>
        </tbody>
    </table>

    <hr>
    
    {{-- ตัวอย่าง Form สำหรับอัพเดตสถานะ --}}
    <form action="{{ route('notiupdate', $updatenoti->NotirepairId) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label">เลือกสถานะใหม่:</label>
            <select name="status" id="status" class="form-select">
                <option value="ได้รับของเเล้ว" {{ ($updatenoti->statusTracking->status ?? '') == 'ได้รับของเเล้ว' ? 'selected' : '' }}>ได้รับของแล้ว</option>
                <option value="กำลังดำเนินการซ่อม" {{ ($updatenoti->statusTracking->status ?? '') == 'กำลังดำเนินการซ่อม' ? 'selected' : '' }}>กำลังดำเนินการซ่อม</option>
                <option value="ซ่อมเสร็จสิ้น" {{ ($updatenoti->statusTracking->status ?? '') == 'ซ่อมเสร็จสิ้น' ? 'selected' : '' }}>ซ่อมเสร็จสิ้น</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">บันทึกสถานะ</button>
    </form>
    
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">ย้อนกลับ</a>
</body>
</html>