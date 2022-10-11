<form class="needs-validation" novalidate action="{{ route('warehouse.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <div class="col s12 m6 l6">
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="warehouse_code">Mã kho:</label>
                    <input type="text" class="form-control" id="warehouse_code" placeholder="Mã kho" required=""
                        name="warehouse_code">
                    <div class="invalid-feedback">
                        Vui lòng nhập mã kho.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="warehouse_contact">Liên hệ:</label>
                    <input type="text" class="form-control" id="warehouse_contact" placeholder="Liên hệ"
                        required="" data-toggle="input-mask" data-mask-format="(000) 000-0000"
                        name="warehouse_contact">
                    {{-- <span class="font-13 text-muted">e.g "(xxx) xxx-xxxx"</span> --}}
                    <div class="invalid-feedback">
                        Vui lòng nhập số điện thoại.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="warehouse_name">Tên kho:</label>
                    <input type="text" class="form-control" id="warehouse_name" placeholder="Tên kho" required=""
                        name="warehouse_name">
                    <div class="invalid-feedback">
                        Vui lòng nhập tên kho.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="warehouse_note">Ghi chú:</label>
                    <input type="text" class="form-control" id="warehouse_note" placeholder="Ghi chú"
                        name="warehouse_note">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="warehouse_street">Địa chỉ:</label>
                    <input type="text" class="form-control" id="warehouse_street" placeholder="Đại chỉ"
                        required="" name="warehouse_street">
                    <div class="invalid-feedback">
                        Vui lòng nhập địa chỉ.
                    </div>
                </div>
                <div class="col s6">
                    <div class="row">
                        <div class="col s6">
                            {{-- <label class="form-label" for="warehouse_code">Mã kho:</label>
                                                            <input type="text" class="form-control"
                                                                id="warehouse_code" placeholder="First name"
                                                                required="">
                                                            <div class="invalid-feedback">
                                                                Vui lòng nhập mã kho.
                                                            </div> --}}
                        </div>
                        <div class="col s6">
                            {{-- <label class="form-label" for="warehouse_code">Mã kho:</label>
                                                            <input type="text" class="form-control"
                                                                id="warehouse_code" placeholder="First name"
                                                                required="">
                                                            <div class="invalid-feedback">
                                                                Vui lòng nhập mã kho.
                                                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2"><span class="form-label" style="font-weight:600">Kích
                    hoạt ngay:</span>
                <div class=" col s6">
                    <input type="checkbox" id="switch3" checked data-switch="success" name="warehouse_status" />
                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <label class="form-label" for="warehouse_image">Chọn ảnh kho max:2MB</label>
            <input type="file" name="warehouse_image" class="form-control" data-max-file-size="2M"
                accept=".jpg, .jepg, .png">
        </div>
    </div>
    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
</form>
