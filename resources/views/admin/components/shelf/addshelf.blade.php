<form class="needs-validation" novalidate action="{{ route('shelf.add-shelf', $warehouse->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="col s12 m6 l6">
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="shelf_code">Mã giá/kệ:</label>
                    <input type="text" class="form-control" id="shelf_code" placeholder="Mã giá/kệ" required=""
                        name="shelf_code">
                    <div class="invalid-feedback">
                        Vui lòng nhập mã giá/kệ.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="shelf_position">vị trí:</label>
                    <input type="text" class="form-control" id="shelf_position" placeholder="vị trí" required=""
                        name="shelf_position">
                    <div class="invalid-feedback">
                        Vui lòng nhập số vị trí.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="shelf_name">Tên giá/kệ:</label>
                    <input type="text" class="form-control" id="shelf_name" placeholder="Tên giá/kệ" required=""
                        name="shelf_name">
                    <div class="invalid-feedback">
                        Vui lòng nhập tên giá/kệ.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="shelf_note">Ghi chú:</label>
                    <input type="text" class="form-control" id="shelf_note" placeholder="Ghi chú" name="shelf_note">
                </div>
            </div>
            <div class="row mb-2"><span class="form-label" style="font-weight:600">Kích
                    hoạt ngay:</span>
                <div class=" col s6">
                    <input type="checkbox" id="switch3" checked data-switch="success" name="shelf_status" />
                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
</form>
