<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="import-datatable"
                    class="table table-centered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Mã phiếu nhập</th>
                            <th>Người tạo</th>
                            <th>Vật tư/ Phụ tùng</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th style="width: 10%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imports as $key => $item)
                            <tr>
                                <td>{{ $item->exim_code }}</td>
                                <td>{{ $item->created_by }}</td>
                                <th>
                                    @foreach ($item->item as $vt)
                                        {{ $vt->item }} <br>
                                    @endforeach
                                </th>
                                <th>{{ $item->exim_status == '0' ? 'Chờ duyệt' : 'Đã duyệt' }}</th>
                                <td>{{ $item->created_at }}</td>
                                <td class="table-action">
                                    @can('eim.edit')
                                        <a href="{{ route('import.edit', $item->id) }}" class="action-icon">
                                        <i class="mdi mdi-eye-outline"></i></a>
                                    @endcan
                                    @can('eim.delete')
                                        <a href="{{ route('ex_import.delete', $item->id) }}"
                                        class="action-icon">
                                        <i class="mdi mdi-delete"></i></a>
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
