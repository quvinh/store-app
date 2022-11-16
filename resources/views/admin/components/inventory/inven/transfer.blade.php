<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="transfer-datatable" class="table table-centered table-striped dt-responsive nowrap w-100">
                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã điều chuyển</th>
                            <th>Người tạo</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th style="width: 10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $key => $transfer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transfer->transfer_code }}</td>
                                <td>{{ $transfer->name }}</td>
                                <td>{{ $transfer->transfer_note }}</td>
                                <td>
                                    @if ($transfer->transfer_status == '0' && $transfer->deleted_at == null)
                                        Chờ duyệt
                                    @elseif ($transfer->transfer_status == '1' && $transfer->deleted_at == null)
                                        Đã duyệt
                                    @else
                                        Đã xóa
                                    @endif
                                </td>
                                <td>{{ $transfer->created_at }}</td>
                                <td class="table-action">
                                    @can('tra.edit')
                                        <a href="{{ route('transfer.edit', $transfer->id) }}" class="action-icon">
                                        <i class="mdi mdi-square-edit-outline" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Sửa phiếu"></i></a>
                                    @endcan
                                    @can('tra.delete')
                                        <a href="{{ route('transfer.delete', $transfer->id) }}" class="action-icon">
                                        <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Xóa phiếu"></i></a>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
