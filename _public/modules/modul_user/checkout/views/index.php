

<div class="card mb-2 p-0 shadow-sm">
    <div class="card-body p-0">
        <?php if ($this->authentication->is_loggedin()): ?>
            
        <input type="hidden" id="destination" value="<?=$destination?>">
        <input type="hidden" id="total_weight" value="<?=$total_weight?>">
        <table class="w-100">
            <tr>
                <td colspan="3" class="bold fs-14 p-2 pl-3 style">
                    Alamat tujuan
                </td>
            </tr>
            <tr>
                <td style="width: 30px" class="p-3">
                    <input type="checkbox" id="check-addr" checked>
                </td>
                <td>
                    <label for="check-addr" class="pl-3" style="line-height: 11px">
                        <?=$alamat->alamat_rumah?>
                    </label>
                </td>
                <td class="justify-content-center pr-3" style="width: 50px">
                    <a href="<?=base_url('address')?>" class="btn btn-sm bg-pink text-white shadow-sm pull-right">ubah</a>
                </td>
            </tr>
        </table>
        <?php endif ?>
        <div class="col-12" id="form-dropship" style="height: 0; overflow: hidden; transition: height .2s, max-height: .2s">
            <table class="table w-100 border-top col-12 " >
                <tr>
                   <tr>
                        <td class="bold fs-12 border-bottom p-2 pl-3">
                            Alamat Dropship
                        </td>
                    </tr>
                    <td class="p-3 pl-5 pr-5">
                        <form class="form-inline">
                            <div class="form-group p-2 col-12">
                                <label style="width: 20%" for="provinsi">Provinsi</label>
                                <select class="city form-control form-control-sm" style="width: 80%;" id="province">
                                    <?php foreach ($provinsi as $x): ?>
                                        <option value="<?=$x->province_id?>"><?=$x->province?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group p-2 col-12 d-none" id="group-city">
                                <label style="width: 20%" for="kota">Kota</label>
                                <select class="city form-control form-control-sm" id="city" style="width: 80%;"></select>
                            </div>
                            <div class="form-group p-2 col-12 d-none" id="group-subdistrict">
                                <label style="width: 20%" for="kecamatan">Kecamatan</label>
                                <select class="city form-control form-control-sm" id="subdistrict" style="width: 80%;"></select>
                            </div>
                            <div class="form-group p-2 col-12" id="group-zip">
                                <label style="width: 20%" for="address">Kode Pos</label>
                                <input type="text" class="form-control" style="width: 120px">
                            </div>
                            <div class="form-group p-2 col-12" id="group-address">
                                <label style="width: 20%" for="address">Alamat Lengkap</label>
                                <textarea id="address" class="form-control" rows="3" style="width: 80%;"></textarea>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card mb-2 p-0 shadow-sm" >
    <div class="card-body p-0">
        <table class="table tbl-no-border">
            <thead>
                <tr>
                    <th class="text-center" width="30%">Product Image</th>
                    <th>Item Product</th>
                    <th width="10%">Price</th>
                    <th width="5%">Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->cart->contents() as $key => $value): ?>

                    <tr>
                        <td class="text-center"> <?=show_image(product_img($value['id']),60, 0, 'slide', 'm-auto')?> </td>
                        <td>
                            <p class="m-0 bold fs-16"><?=$value['name']?></p>
                            <p class="m-0">Varian: <span class="badge bg-ailin-hotpink text-white bold"><?=$value['varian']?></span></p>
                        </td>
                        <td><?=rupiah($value['price'])?></td>
                        <td class="text-center justify-content center text-center" >
                            <div class="d-flex align-center">
                                <input type="text" class="hw-30 float-left p-0 w-30px form-control white text-center r-0 text-black bold" id="qty" value="<?=$value['qty']?>" disabled>
                            </div>    
                        </td>
                        <td><?=rupiah($value['subtotal'])?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <table class="w-100">
            <tr>
                <td class="p-1 pl-3 pr-3" rowspan="2">
                    <div class="col-12 p-0">Tambahkan pesan untuk penjual</div>
                    <textarea class="form-control col-12" cols="30" rows="3"></textarea>
                </td>
                <td class="p-1 align-baseline" width="auto">
                    <div class="text-left col-12">Pilih Kurir</div>
                    <select class="form-control form-control-sm" id="kurir">
                        <option value="jne">JNE</option>
                        <option value="jnt">JNT</option>
                        <option value="tiki">TIKI</option>
                        <option value="pos">POST</option>
                        <option value="sicepat">SiCepat</option>
                        <option value="jet">JET express</option>
                        <option value="ninja">NINJA express</option>
                    </select>
                </td>
                <td class="p-1 align-baseline" width="auto">
                    <div class="text-left col-12">Pilih Kurir</div>
                    <select class="form-control form-control-sm" id="kurir_detail">
                        <?php foreach ($cost as $i => $value): ?>
                            <option value="<?=$value->cost[0]->value?>"><?=$value->service?> (<?=$value->description?>)</option>
                        <?php endforeach ?>
                    </select>
                </td>
                    
            </tr>
            <tr>
                <td colspan="2" class="text-right p-1 pr-3 bold">
                    Ongkos Kirim
                    <span class="fs-16" id="ongkir" style="color: hotpink"><?=rupiah($cost[0]->cost[0]->value)?></span>
                </td>
            </tr>
        </table>
    </div>

</div>
<div class="card mb-5 shadow-sm">
    <div class="card-body">
        <p class="promos"><b>Kode Promo</b> <input type="text" class="form-promo"> <button class="btn-promo">OK</button></p>
        <div class="clearfix"></div>
        <div class="garis-abu"></div>
        <input type="hidden" id="cart_total" value="<?=$this->cart->total()?>">

        <form id="payment-form" method="post" action="<?=base_url('payment/finish')?>">
            <input type="hidden" name="result_type" id="result-type" value=""></div>
            <input type="hidden" name="result_data" id="result-data" value=""></div>
        </form>

        <p class="checkout-sum">Total Pembayaran <b class="pink big checkout_total"><?=rupiah($this->cart->total()+$cost[0]->cost[0]->value)?></b> <a href="#"><button id="pay-button" class="btn-cart-checkout">BAYAR</button></a></p>
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