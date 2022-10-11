<form class="needs-validation" novalidate action="{{ route('unit.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="col s12 m6 l6">
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="unit_name">Tên đơn vị tính</label>
                    <input type="text" class="form-control" id="unit_name" placeholder="Tên đơn vị tính" required=""
                        name="unit_name">
                    <div class="invalid-feedback">
                        Vui lòng nhập tên đơn vị tính.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="unit_amount">Đơn vị</label>
                    <input type="text" class="form-control" id="unit_amount" placeholder="Đơn vị" required=""
                        name="unit_amount">
                    <div class="invalid-feedback">
                        Vui lòng nhập đơn vị.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
</form>
