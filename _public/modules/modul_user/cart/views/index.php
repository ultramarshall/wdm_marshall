<h1 class="text-black bold mb-5">Keranjang Belanja</h1>

<div class="card mt-3 mb-5 shadow-sm">
     <div class="card-body p-0" id="item" style="border: 0;">
        <?php if (count($this->cart->contents()) == 0): ?>
            <div class="text-center p-5 border">
                <img src="https://orig00.deviantart.net/c477/f/2015/224/b/3/giphy__3__by_electricookie-d95d30j.gif" width="200" alt=""><br>
                <span class="fs-18 bold ">Belum ada belanjaan</span><br>
                <a href="<?=base_url()?>" class="btn btn-lg bg-ailin-pink text-white bold w-200px mt-2">cari produk</a>
            </div>
        <?php else: ?>
            <table class="table table-sm bg-white m-0 tbl-no-border">
                <thead>
                    <tr>
                        <th class="p-2 bordered-pink text-center" colspan="2">Produk</th>
                        <th class="p-2 bordered-pink text-right">Harga Satuan</th>
                        <th class="p-2 bordered-pink text-center" width="10" align="center">Kuantitas</th>
                        <th class="p-2 bordered-pink text-right">Total Harga</th>
                        <th class="p-2 bordered-pink text-center">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($this->cart->contents() as $item): ?>
            <?php 
                $product = $this->data->get_product_detail($item['id'])[0];
                $pic = show_image(json_decode($product->product_logo)[0]->nama,60, 0, 'slide', 'm-auto');
                $varian = '<span class="badge badge-secondary">'.$item['varian'].'</span> ';
            ?>
            <tr>
                <td class="text-center"><?=$pic?></td>
                <td>Varian: <?=$varian?></td>
                <td class="text-right"><?=rupiah($item['price'])?></td>
                <td class="text-center justify-content center text-center" >
                    <div class="d-flex align-center">
                        <button id="btn-qty" data-action="min" data-id="<?=$item['rowid']?>" class="hw-30 bold white r-0 float-left border" data-id="<?=$item['rowid']?>">-</button>
                        <input type="text" class="hw-30 float-left p-0 w-30px form-control white text-center r-0" id="qty" value="<?=$item['qty']?>" disabled>
                        <button id="btn-qty" data-action="max" data-id="<?=$item['rowid']?>" class="hw-30 bold white r-0 float-left border" data-id="<?=$item['rowid']?>">+</button>
                    </div>    
                </td>
                <td class="text-right"><?=rupiah($item['subtotal'])?></td>
                <td class="text-center">
                    <button class="delete-item btn btn-danger m-auto" data-id="<?=$item['rowid']?>">
                        <i class="fa fa-trash red"></i> Hapus
                    </button>
                </td>
            </tr>
            <?php endforeach ?>
                </tbody>
            </table>
            
        <?php endif ?>
    </div>
</div>


<div class="card mt-3 mb-5 shadow-sm">
     <div class="card-body p-0" id="item" style="border: 0;">
            <table class="table table-sm bg-white m-0 tbl-no-border">
                <tbody>
                    <tr>
                        <td class="p-5 text-right" id="kode-promosi">
                            <button class="btn-promo btn border r-20 pull-right ml-2 white cur-pointer p-0 m-0 pl-3 pr-3" id="btn-kode-promo" style="line-height: 28px">oke</button>
                            <input type="text" id="code" class="form-control r-20 w-100px pull-right" value="MAKINKECE">
                            <span class="pull-right mr-2" style="line-height: 31px">Kode Promo</span>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</div>


<div class="card mt-3 mb-5 shadow-sm">
     <div class="card-body p-0" id="item" style="border: 0;">
            <table class="table table-sm bg-white m-0 tbl-no-border">
                <tbody>
                    <tr>
                        <td class="p-5 text-right fs-20" style="line-height: 43px">
                            <span class="bold">Subtotal</span> <span id="subtotal" class="color-hotpink bold mr-3"><?=rupiah($this->cart->total())?></span>
                            <a href="<?=base_url('checkout')?>" class="btn bg-ailin-hotpink text-white bold text-center w-25 btn-sm pull-right r-30">
                                <span class="icon-payment fa-2x"></span> 
                                <span class="fa-2x">Checkout</span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</div>
<input type="hidden" id="cashback">
<input type="hidden" id="total" value="<?=$this->cart->total()?>">



<div class="row mt-5 mb-5">
    <div class="col-12">
        
    </div>
</div>

<style>
    .card {
        border: 0;
    }
    .tbl-no-border {
        border-collapse: none;
    }
    table.tbl-no-border th,
    .tbl-no-border td {
        border: 0;
    }
    thead {
        border-bottom: 3px solid hotpink
    }

    .border-none {
        border: 0;
    }
    .btn-promo:hover {
        color: #000;
    }

    .btn-promo:active {
        color: #000;
        background-color: hotpink;
    }

</style>