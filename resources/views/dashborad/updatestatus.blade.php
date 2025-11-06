<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>รายละเอียดแจ้งซ่อม</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
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
    <form action="/updaterecive" method="POST">
        @csrf
        <input type="hidden" value="{{$updatenoti->NotirepairId}}" name="NotirepairId">
        <div class="mb-3">
            <label for="status" class="form-label">เลือกสถานะใหม่:</label>
            <select name="status" id="status" class="form-select">
                {{-- value ต้องตรง --}}
                <option value="ได้รับของเเล้ว" {{ ($updatenoti->statusTracking->status ?? '') == 'ได้รับของเเล้ว' ? 'selected' : '' }}>ได้รับของแล้ว</option>
                <option value="ยังไม่ดำเนินการซ่อม" {{ ($updatenoti->statusTracking->status ?? '') == 'ยังไม่ดำเนินการซ่อม' ? 'selected' : '' }}>ยังไม่ดำเนินการซ่อม</option>
                <option value="ซ่อมงานเสร็จเเล้ว" {{ ($updatenoti->statusTracking->status ?? '') == 'ซ่อมงานเสร็จเเล้ว' ? 'selected' : '' }}>ซ่อมงานเสร็จเเล้ว</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">บันทึกสถานะ</button>
    </form>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">ย้อนกลับ</a>
</body>
</html>
