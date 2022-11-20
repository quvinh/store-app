<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="category" class="form-label">loại vật tư:</label>
            <input type="text" class="form-control" name="" value="{{ $item[0]->category_name }}" id="category"
                aria-describedby="helpId" placeholder="" readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="item_name" class="form-label">Tên vật tư:</label>
            <input type="text" class="form-control" name="" id="item_name" value="{{ $item[0]->item_name }}"
                aria-describedby="helpId" placeholder="" readonly>
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
            <label for="supplier" class="form-label">Nhà sản xuất:</label>
            <input type="text" class="form-control" name="" id="supplier" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->supplier_name }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="item_quantity" class="form-label">Số lượng:</label>
            <input type="text" class="form-control" name="" id="item_quantity"
                value="{{ $item[0]->item_detail_quantity }}" aria-describedby="helpId" placeholder="" readonly>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="item_valid" class="form-label">Khả dụng:</label>
                    <input type="text" class="form-control" name="" id="item_valid" aria-describedby="helpId"
                        placeholder="" readonly value="{{ $item[0]->item_quantity[0] }}">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="item_invalid" class="form-label">Không khả dụng:</label>
                    <input type="text" class="form-control" name="" id="item_invalid" aria-describedby="helpId"
                        placeholder="" readonly value="{{ $item[0]->item_quantity[1] }}">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="unit" class="form-label">Đơn vị tính:</label>
                    <input type="text" class="form-control" name="" id="unit" aria-describedby="helpId"
                        placeholder="" readonly value="{{ $item[0]->unit_name }}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="item_weight" class="form-label">Trọng lượng:</label>
            <input type="text" class="form-control" name="" id="item_weight" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->item_weight }}">
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
            <label for="item_height" class="form-label">Chiều cao:</label>
            <input type="text" class="form-control" name="" id="item_height" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->item_height }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="item_long" class="form-label">Chiều dài:</label>
            <input type="text" class="form-control" name="" id="item_long" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->item_long }}">
        </div>
    </div>
    <div class="col">
        <div class="mb-3">
            <label for="item_width" class="form-label">Chiều rộng:</label>
            <input type="text" class="form-control" name="" id="item_width" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->item_width }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            <label for="item_note" class="form-label">Mô tả:</label>
            <input type="text" class="form-control" name="" id="item_note" aria-describedby="helpId"
                placeholder="" readonly value="{{ $item[0]->item_note }}">
        </div>
    </div>
</div>
