<form class="needs-validation" novalidate action="{{ route('shelf.add-shelf', $warehouse->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @php
    $maxId = DB::table('shelves')->max('id');
    @endphp
    <div class="mb-3">
        <div class="col s12 m6 l6">
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="shelf_code">Mã giá/kệ:</label>
                    <input type="text" class="form-control" id="shelf_code" placeholder="Mã giá/kệ" required="" value="{{ $maxId + 1 }}"
                        name="shelf_code">
                    <div class="invalid-feedback">
                        Vui lòng nhập mã giá/kệ.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="shelf_position">Vị trí:</label>
                    <input type="text" class="form-control" id="shelf_position" placeholder="vị trí" required="" value="right"
                        name="shelf_position">
                    <div class="invalid-feedback">
                        Vui lòng nhập số vị trí.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="shelf_name">Tên giá/kệ:</label>
                    <input type="text" class="form-control" id="shelf_name" placeholder="Tên giá/kệ" required="" value="Kệ {{ $maxId + 1 }}"
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
            <div class="row mb-2">
                <div class="col s6">
                    <label class="form-label" for="floor">Số tầng:</label>
                    <input type="number" class="form-control" min="1" max="1000" id="floor_id" placeholder="Số tầng" required="" value="3"
                        name="floor">
                    <div class="invalid-feedback">
                        Vui lòng nhập số tầng.
                    </div>
                </div>
                <div class="col s6">
                    <label class="form-label" for="cell">Số ô trong tầng:</label>
                    <input type="number" min="1" max="1000" class="form-control" id="cell" placeholder="Số ô" required="" value="5"
                        name="cell">
                    <div class="invalid-feedback">
                        Vui lòng nhập số ô.
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col s6">
                    <div class="col s6">
                        <label class="form-label" for="cell_capacity">Thể tích của ô:</label>
                        <input type="number" min="5000" max="50000" step="1000" class="form-control" id="cell_capacity" placeholder="Thể tích ô" required="" value="10000"
                            name="cell_capacity">
                        <div class="invalid-feedback">
                            Vui lòng nhập thể tích ô.
                        </div>
                    </div>
                </div>
                <div class=" col s6">
                    <span class="form-label" style="font-weight:600">Kích
                    hoạt ngay:</span><br><br>
                    <input type="checkbox" id="switch3" checked data-switch="success" name="shelf_status" />
                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
</form>
