<?php foreach ($this->cart->contents() as $value): ?>
                            <div class="card-body fs-14 p-1 border-bottom d-inline-block mw-300">
                                <a href="#" class="d-block o-auto">
                                    <img class="float-left w-25 p-0 pt-1 pl-1" src="<?=css_frontend_url('img/demo/portfolio/p1.jpg')?>">
                                    <div class="float-left text-left p-0 pl-1 w-75 fs-12 cur-pointer bold">
                                        <div class="col-12 pt-1 pl-1"><?=$value['name']?> </div>
                                        <div class="col-12 pt-0 pl-1 no-bold">Qty : <?=$value['qty']?> x <?=rupiah($value['price'])?></div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach ?>
                            <div class="card-body pl-2 p-1 text-left">
                                <div class="w-50 float-left bold pl-1">Total</div>
                                <div class="w-50 float-left bold">
                                    <span class="pull-right pr-2">
                                        <?=rupiah($this->cart->total())?>
                                    </span>
                                </div>
                                
                            </div>
                            
                            <div class="card-footer d-block p-1 fs-10">
                                <a href="<?=base_url('cart')?>">lihat semua</a>
                            </div>