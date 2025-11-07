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
                <th>สถานะ</th><th>กดอัพเดทสถานะ</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($noti as $item)
                <tr>
                    <td>{{ $item->NotirepairId }}</td>
                    <td>{{ $item->equipmentId }}</td>
                    <td>{{ $item->DeatailNotirepair }}</td>
                    <td>{{ $item->DateNotirepair }}</td>
                    {{-- <td>รับของเเล้ว</td> --}}
                    {{-- <td><a href={{ '/noti/' . $item->NotirepairId }}>กดรับ</a></td> --}}
                    {{-- <td>{{ $item->status }}</td> --}}

                   
                    {{-- เดิม --}}
                    {{-- <td>
                        @if ($item->status === 'ยังไม่ได้รับของ')
                            <form action="{{ route('noti.accept', $item->NotirepairId) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    กดรับของ
                                    </button>
                                </form>
                        @else
                            <span class="text-primary">รับของแล้ว</span>
                            <a href="{{ route('noti.show_update_form', $item->NotirepairId) }}"
                                class="btn btn-sm btn-warning">
                                อัพเดต
                            </a>
                        @endif
                        </td> --}}

                        <td>
                            @php
                                $status_text = $item->status ?? 'ไม่มีสถานะ';
                                $badge_class = 'bg-success';
    
                                if ($status_text === 'ได้รับของแล้ว' || $status_text === 'เสร็จสิ้น') {
                                    $badge_class = 'bg-success';
                                } elseif ($status_text === 'กำลังดำเนินการซ่อม') {
                                    $badge_class = 'bg-warning text-dark';
                                } elseif ($status_text === 'ยังไม่ได้รับของ') {
                                    $badge_class = 'bg-danger';
                                }
                                elseif ($status_text === 'ยังไม่ได้รับของ') {
                                    $badge_class = 'bg-danger';
                                }
                                
                            @endphp
                            <span class="badge {{ $badge_class }}">{{ $status_text }}</span>
                        </td>
                        <td>
                            @if ($item->status === 'ยังไม่ได้รับของ')
                                <form action="{{ route('noti.accept', $item->NotirepairId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        กดรับของ
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('noti.show_update_form', $item->NotirepairId) }}"
                                    class="btn btn-sm btn-warning">
                                    อัพเดต
                                </a>
                            @endif
                        </td>
               
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
