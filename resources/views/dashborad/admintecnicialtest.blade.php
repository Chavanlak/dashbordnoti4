<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-3">
    @php
        use App\Repository\TrackingStatusEnum;
    @endphp
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statusList as $status)
                <tr>
                    <td>{{ $status->statustrackingId }}</td>
                    <td>{{ $status->status }}</td>
                    <td>
                    
                        @if ($status->status === TrackingStatusEnum::NOTRECEIVED->value)
                        <form action="{{ route('status.change', $status->statustrackingId)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">กดรับ</button>
                        </form>
                    @else
                        <span class="text-primary">รับของแล้ว ✅</span>
                    @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
    {{-- @if (trim($status->status) === 'ยังไม่ได้รับของ')
                            <form action="{{ route('status.change', $status->statustrackingId)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">กดรับ</button>
                            </form>
                        @else
                            <span class="text-success">ได้รับของแล้ว</span>
                        @endif --}}
                        {{-- @if (trim($status->status) === 'ยังไม่ได้รับของ')
                            <form action="{{ route('status.change', $status->statustrackingId)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">กดรับ</button>
                            </form>
                        @elseif (trim($status->status) === 'ได้รับของเเล้ว')
                            <form action="{{ route('status.changeSupplier', $status->statustrackingId)}}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">ส่งไป Supplier</button>
                            </form>
                        @elseif (trim($status->status) === 'ส่งSuplierเเล้ว')
                            <span class="text-info">ส่ง Supplier เรียบร้อยแล้ว</span>
                        @else
                            <span class="text-muted">{{$status->status}}</span>
                        @endif --}}


                        {{-- @if ($status->status === TrackingStatusEnum::NOTRECEIVED->value)
                            <form action="{{ route('status.change', $status->statustrackingId) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">กดรับ</button>
                            </form>
                        @elseif ($status->status === TrackingStatusEnum::RECEIVED->value)
                            <form action="{{ route('status.changeSupplier', $status->statustrackingId) }}"
                                method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">ส่งไป Supplier</button>
                            </form>

                            <form action="{{ route('status.changeRepair', $status->statustrackingId) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">ส่งซ่อมช่าง</button>
                            </form>
                        @elseif ($status->status === TrackingStatusEnum::SENTTOSUPPLIER->value)
                            <span class="text-info">ส่ง ช่างซ่อม(store) เรียบร้อยแล้ว</span>
                        @elseif ($status->status === TrackingStatusEnum::REPAIRFINISHED->value)
                            <span class="text-success">ซ่อมงานเสร็จเรียบร้อยแล้ว</span>
                        @else
                            <span class="text-muted">{{ $status->status }}</span>
                        @endif --}}
