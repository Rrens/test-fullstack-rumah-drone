@if (!empty($data[0]))
    @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="barcode">{{ $item->item[0]->barcode }}</td>
            <td>{{ $item->item[0]->name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->jumlah_jual }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->discount_item }}</td>
            <td id="total">{{ $item->total }}</td>
            <td class="text-center" width="160px">
                <button id="update_cart" data-toggle="modal" data-target="#modal-item-edit"
                    data-cartid="{{ $item->item_id }}"
                    data-barcode="{{ $item->item[0]->barcode }}"
                    data-product="{{ $item->item[0]->name }}"
                    data-stock="{{ $item->item[0]->stock }}"
                    data-price="{{ $item->price }}"
                    data-jual="{{ $item->jumlah_jual }}"
                    data-qty="{{ $item->quantity }}"
                    data-discount="{{ $item->discount_item }}"
                    data-total="{{ $item->total }}"
                    class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil"></i> Update
                </button>
                
                <button id="del_cart" data-cartid="{{ $item->id }}" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i>Delete
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" class="text-center">No item</td>
    </tr>
@endif
