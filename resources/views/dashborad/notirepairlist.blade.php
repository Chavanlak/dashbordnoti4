<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดแจ้งซ่อม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3>รายละเอียดแจ้งซ่อม</h3>

    {{-- แสดงข้อความแจ้งเตือนความสำเร็จ --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>รหัสแจ้งซ่อม</th>
                <th>อุปกรณ์</th>
                <th>รายละเอียด</th>
                <th>วันที่แจ้ง</th>
                <th>สถานะ</th>
                <th>กดอัพเดทสถานะ</th>
                <th>รายละเอียดการติดตามงาน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($noti as $item)
                <tr>
                    <td>{{ $item->NotirepairId}}</td>
                    <td>{{ $item->equipmentId}}</td>
                    <td>{{ $item->DeatailNotirepair}}</td>
                    <td>{{ $item->DateNotirepair}}</td>
             

                    {{-- ดึงค่าสถานะที่ถูก JOIN มาจาก statustracking และกำหนดสี Badge --}}
                    <td>
                        @php
                            // ใช้ $item->status ที่ถูก Join เข้ามา
                            $status_text = $item->status ?? 'ยังไม่ได้รับของ'; // กำหนดสถานะเริ่มต้นถ้าเป็น NULL
                            $badge_class = 'bg-secondary';

                            switch ($status_text) {
                                case 'ซ่อมงานเสร็จเเล้ว | ช่างStore':
                                case 'ซ่อมงานเสร็จเเล้ว | Supplier':
                                    $badge_class = 'bg-success';
                                    break;
                                case 'ได้รับของเเล้ว':
                                    $badge_class = 'bg-primary'; // น้ำเงิน: รับเรื่องแล้ว
                                    break;
                                case 'ยังไม่ได้รับของ':
                                    $badge_class = 'bg-danger'; // แดง: ยังไม่เริ่ม
                                    break;

                                case 'ส่งSuplierเเล้ว':
                                case 'กำลังดำเนินการซ่อม | ช่างStore':
                                case 'กำลังดำเนินการซ่อม': // <-- เพิ่มเผื่อกรณีที่บันทึกแค่ 'กำลังดำเนินการซ่อม'
                                case 'รอส่งSuplier': // <-- เพิ่มสถานะนี้เข้ากลุ่มกำลังดำเนินการ
                                    $badge_class = 'bg-warning text-dark';
                                    break;

                                // ⬜ สถานะอื่นๆ (เทา)
                                default:
                                    $badge_class = 'bg-secondary';
                                    break;
                            }
                        @endphp
                        <span class="badge {{ $badge_class }}">{{ $status_text}}</span>
                    </td>

                    {{-- ปุ่มกดอัพเดทสถานะ --}}
                    <td>
                        @if ($status_text === 'ซ่อมงานเสร็จเเล้ว | ช่างStore' || $status_text === 'ซ่อมงานเสร็จเเล้ว | Supplier')
                            {{-- ถ้าเสร็จสมบูรณ์แล้ว ไม่ต้องมีปุ่มอัปเดต --}}
                            <span class="text-success">เสร็จสิ้น</span>
                        @elseif ($status_text === 'ยังไม่ได้รับของ')
                            {{-- สถานะแรก: แสดงปุ่มกดรับของเท่านั้น --}}
                            <form action="{{route('noti.accept', $item->NotirepairId)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    กดรับของ
                                </button>
                            </form>
                        @else
                            {{-- สถานะอื่นๆ ทั้งหมด: แสดงปุ่มอัปเดตสถานะ --}}
                            <a href="{{route('noti.show_update_form', $item->NotirepairId)}}"
                                class="btn btn-sm btn-warning">
                                อัพเดต
                            </a>
                            {{-- <a href="{{route('noti.list', $item->NotirepairId)}}"
                                class="btn btn-sm btn-warning">
                                อัพเดต
                            </a> --}}
                        @endif
                    </td>
                    <td><a href="">ดูรายละเอียด</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary">ย้อนกลับ</a> --}}

    {{-- เพิ่ม script สำหรับ Bootstrap 5 เพื่อให้ alert ใช้งานได้ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
