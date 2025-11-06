<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>รายละเอียดแจ้งซ่อม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3>รายละเอียดแจ้งซ่อม</h3>

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
            @foreach ($noti as $item)
                <tr>
                    <td>{{ $item->NotirepairId }}</td>
                    <td>{{ $item->equipmentId }}</td>
                    <td>{{ $item->DeatailNotirepair }}</td>
                    <td>{{ $item->DateNotirepair }}</td>
                    <td><a href={{ '/noti/' . $item->NotirepairId }}>กดรับ</a></td>
                    <td>{{ $item->Status }}</td>

                    {{-- <td>
                        @if (trim($item->status) === 'ยังไม่ได้รับของแล้ว')
                            <span class="badge bg-primary">✅ ได้รับของแล้ว</span>
                        @else
                            <form action="{{ route('noti.receive', $item->NotirepairId) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    กดรับของ
                                </button>
                            </form>
                        @endif
                    </td> --}}

                    <td>
                        @if ($item->status === 'ยังไม่ได้รับของ')
                            {{-- ใช้ Route POST ใหม่: noti.accept --}}
                            <form action="{{ route('noti.accept', $item->NotirepairId) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    กดรับของ
                                    </button>
                                </form>
                        @else
                            <span class="text-primary">รับของแล้ว</span>
                            {{-- เพิ่มปุ่มอัพเดตสถานะสำหรับรายการที่รับแล้ว (ลิงก์ไปยัง Route GET ใหม่) --}}
                            <a href="{{ route('noti.show_update_form', $item->NotirepairId) }}"
                                class="btn btn-sm btn-warning">
                                อัพเดต
                            </a>
                        @endif
                        </td>


                    {{-- <td>
                        @if ($item->Status == null || $item->Status == 'ยังไม่ได้รับของ')
                            <a href="{{ url('/noti/'.$item->NotirepairId) }}" class="btn btn-success btn-sm">
                                กดรับของ
                            </a>
                        @else
                            <span class="badge bg-primary">ได้รับของแล้ว</span>
                        @endif
                    </td> --}}
                    {{-- <td>
                        @if ($item->status == 'ได้รับของเเล้ว')
                            <span class="badge bg-success">ได้รับของแล้ว</span>
                        @else
                            <span class="badge bg-warning text-dark">ยังไม่ได้รับของ</span>
                        @endif
                    </td>

                    <td>
                        @if ($item->status != 'ได้รับของเเล้ว')
                            <a class="btn btn-primary btn-sm" href="{{'/noti/'.$item->NotirepairId}}">
                                กดรับ
                            </a>
                        @else
                            ✅ เสร็จแล้ว
                        @endif
                    </td> --}}
                    {{-- @if ($item->status == 'ยังไม่ได้รับของ')
                    <form action="{{'/noti/'.$item->NotirepairId}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">กดรับ</button>
                    </form>
                @else
                    <span class="badge bg-success">ได้รับของแล้ว</span>
                @endif
            </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    {{--     
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif --}}

    <a href="{{ url()->previous() }}" class="btn btn-secondary">ย้อนกลับ</a>
</body>

</html>
