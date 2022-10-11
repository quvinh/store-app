<form class="needs-validation" novalidate action="{{ route('category.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="col s12 m6 l6">
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="category_code">Mã loại vật tư:</label>
                    <input type="text" class="form-control" id="category_code" placeholder="Mã loại vật tư"
                        required="" name="category_code">
                    <div class="invalid-feedback">
                        Vui lòng nhập mã loại vật tư.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="category_name">Tên loại vật tư:</label>
                    <input type="text" class="form-control" id="category_name" placeholder="Tên loại vật tư"
                        required="" name="category_name">
                    <div class="invalid-feedback">
                        Vui lòng nhập tên loại vật tư.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="category_note">Ghi chú:</label>
                    <input type="text" class="form-control" id="category_note" placeholder="Ghi chú"
                        name="category_note">
                </div>

                <div class="col s6">
                    <span class="form-label" style="font-weight:600">Kích
                        hoạt ngay:</span><br><br>
                    <input type="checkbox" id="switch3" checked data-switch="success" name="category_status" />
                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>

            <div class="row mb-2">
            </div>
        </div>
    </div>
    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
</form>
