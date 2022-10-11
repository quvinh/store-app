<table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã vật tư</th>
            <th>Tên vật tư</th>
            <th>Ảnh</th>
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
            <th>Tổng số lượng trong kho</th>
            <th>Giá kệ</th>
            <th>Kho</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th style="width: 10%">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $key => $items)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $items->item_code }}</td>
                <td>{{ $items->item_name }}</td>
                <td>
                    @if ($items->item_images == '' || $items->item_images == null)
                        <img src="{{ asset('images/img/no-image.jpg') }}" alt="No-image" height="32">
                    @else
                        <img src="{{ asset($items->item_images) }}" alt="image" height="32">
                    @endif
                </td>
                <td>{{ $items->category_name }}</td>
                <td>{{ $items->item_quantity_of_shelf }}</td>
                <td>{{ $items->unit_name }}</td>
                <td>{{ $items->item_importprice }}</td>
                <td>{{ $items->item_exportprice }}</td>
                <td>{{ $items->item_weight }}</td>
                <td>{{ $items->item_weightuint }}</td>
                <td>{{ $items->item_long }}</td>
                <td>{{ $items->item_width }}</td>
                <td>{{ $items->item_height }}</td>
                <td>{{ $items->item_quantity }}</td>
                <td>{{ $items->shelf_name }}</td>
                <td>{{ $items->warehouse_name }}</td>
                <td>
                    @if ($items->item_status === 1)
                        <span class="badge bg-success">Còn hàng</span>
                    @else
                        <span class="badge bg-danger">hết hàng</span>
                    @endif
                </td>
                <td>{{ $items->item_note }}</td>
                <td class="table-action">
                    x
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
