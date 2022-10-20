<table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã vật tư</th>
            <th>Tên vật tư</th>
            <th>Loại vật tư</th>
            <th>Số lượng</th>
            <th>Đơn vị tính</th>
            <th>Giá nhập</th>
            <th>Giá xuất</th>
            <th>Trọng lượng</th>
            <th>Đơn vị đo trọng lượng</th>
            <th>Chiều dài</th>
            <th>Chiều rộng</th>
            <th>Chiều cao</th>
            <th>SL khả dụng</th>
            <th>SL không khả dụng</th>
            <th>Giá kệ</th>
            <th>Kho</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th style="width: 10%">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->category_name }}</td>
                <td>{{ $item->item_quantity_of_cell }}</td>
                <td>{{ $item->unit_name }}</td>
                <td>{{ $item->item_importprice ? $item->item_importprice : '-----' }}</td>
                <td>{{ $item->item_exportprice ? $item->item_exportprice : '-----' }}</td>
                <td>{{ $item->item_weight ? $item->item_weight : '-----' }}</td>
                <td>{{ $item->item_weightuint ? $item->item_weightuint : '-----'}}</td>
                <td>{{ $item->item_long ? $item->item_long : '-----' }}</td>
                <td>{{ $item->item_width ? $item->item_width : '-----' }}</td>
                <td>{{ $item->item_height ? $item->item_height : '-----' }}</td>
                <td>{{ $item->item_valid[0] }}</td>
                <td>{{ $item->item_valid[1] }}</td>
                <td>{{ $item->shelf_name }}</td>
                <td>{{ $item->warehouse_name }}</td>
                <td>
                    @if ($item->item_valid[0] > 0)
                        <span class="badge bg-success">Còn hàng</span>
                    @else
                        <span class="badge bg-danger">hết hàng</span>
                    @endif
                </td>
                <td>{{ $item->item_note ? $item->item_note : '----- ' }}</td>
                <td class="table-action">
                    x
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
