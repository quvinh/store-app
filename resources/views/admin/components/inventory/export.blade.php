<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="export-datatable"
                    class="table table-centered table-striped dt-responsive nowrap w-100">
                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                    <thead>
                        <tr>
                            <th>Mã phiếu xuất</th>
                            <th>Người tạo</th>
                            <th>Vật tư/ Phụ tùng</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th style="width: 10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exports as $key => $item)
                            <tr>
                                <td>{{ $item->exim_code }}</td>
                                <td>{{ $item->created_by }}</td>
                                <th>
                                    @foreach ($item->item as $vt)
                                        {{ $vt->item }}<br>
                                    @endforeach
                                </th>
                                <th>
                                    @if ($item->exim_status == '0' && $item->deleted_at == null)
                                        Chờ duyệt
                                    @elseif ($item->exim_status == '1' && $item->deleted_at == null)
                                        Đã duyệt
                                    @else
                                        Đã xóa
                                    @endif
                                </th>
                                <td>{{ $item->created_at }}</td>
                                <td class="table-action">
                                    <a href="{{ route('export.edit', $item->id) }}" class="action-icon">
                                        <i class="mdi mdi-eye-outline"></i></a>
                                    <a href="{{ route('ex_import.delete', $item->id) }}"
                                        class="action-icon">
                                        <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
