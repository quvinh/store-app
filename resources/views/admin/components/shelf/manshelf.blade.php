<div class="row mb-2">
    <div class="col-sm-4">
        <a data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"
            class="btn btn-danger mb-2 collapsed">
            Tạo mới giá/kệ
        </a>
    </div>
</div>
<div class="collapse" id="collapseExample">
    <div class="tab-pane show active" id="custom-styles-preview">
        @include('admin.components.shelf.addshelf')
    </div>
</div>
<div>
    <hr>
</div>
<table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã giá/kệ</th>
            <th>Tên giá/kệ</th>
            <th>Vị trí</th>
            <th>Trạng thái</th>
            <th style="width: 10%">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shelf as $key => $shelf)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $shelf->shelf_code }}</td>
                <td>{{ $shelf->shelf_name }}</td>
                <td>{{ $shelf->shelf_position }}</td>
                <td>
                    @if ($shelf->shelf_status == '1')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Deactive</span>
                    @endif
                </td>
                <td class="table-action">
                    <a href="{{ route('shelf.edit', $shelf->id) }}" class="action-icon">
                        <i class="mdi mdi-square-edit-outline"></i></a>

                    <a href="#" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                    <form action="{{ route('shelf.destroy', $shelf->id) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button value="Delete" type="submit" class="action-icon"
                            style="border:0ch; background-color:white"><i class="mdi mdi-delete"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
