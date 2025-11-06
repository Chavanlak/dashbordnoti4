@if ($status->status === AsStringable::NOTRECEIVED->value)
    <!-- ปุ่มกดรับ -->
    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#receiveModal{{ $status->statustrackingId }}">
        กดรับ
    </button>

    <!-- Modal -->
    <div class="modal fade" id="receiveModal{{ $status->statustrackingId }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">เลือกการดำเนินการต่อ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <form action="{{ route('status.changeSupplier', $status->statustrackingId) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">ส่งไป Supplier</button>
            </form>

            <form action="{{ route('status.changeRepair', $status->statustrackingId) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-warning">ส่งซ่อมช่าง</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endif
