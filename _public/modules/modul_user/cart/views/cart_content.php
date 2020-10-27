<?php if (count($this->cart->contents()) == 0): ?>
            <div class="text-center p-5 border">
                <img class="mb-2" src="https://orig00.deviantart.net/c477/f/2015/224/b/3/giphy__3__by_electricookie-d95d30j.gif" height="100" alt=""><br>
                <span class="fs-18 bold ">Belum ada belanjaan</span><br>
                <a href="<?=base_url()?>" class="btn btn-lg bg-ailin-pink text-white bold w-200px mt-2">cari produk</a>
            </div>
        <?php else: ?>
            <table class="table table-hover table-sm bg-white">
                <thead class="thead-dark">
                    <tr>
                        <th class="bordered-pink text-center" colspan="2">Produk</th>
                        <th class="bordered-pink text-right">Harga Satuan</th>
                        <th class="bordered-pink text-center" width="10" align="center">Kuantitas</th>
                        <th class="bordered-pink text-center">Total Harga</th>
                        <th class="bordered-pink text-center">Pilihan</th>
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
                                <button id="btn-qty" data-action="min" data-id="<?=$item['rowid']?>" class="btn btn-sm bg-ailin-hotpink bold text-white float-left btn-default" data-id="<?=$item['rowid']?>">-</button>
                                <input type="text" class="float-left p-0 w-30px form-control white text-center" id="qty" value="<?=$item['qty']?>" disabled>
                                <button id="btn-qty" data-action="max" data-id="<?=$item['rowid']?>" class="btn btn-sm bg-ailin-hotpink bold text-white float-left btn-default" data-id="<?=$item['rowid']?>">+</button>
                            </div>    
                        </td>
                        <td id="subtotal"><?=rupiah($item['subtotal'])?></td>
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