<?php foreach ($product as $key => $value): ?>
<a href="<?=base_url('product/'.$value->id)?>">
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 p-0 float-left mb-3">
        <div class="col-10 p-0 m-auto white shadow rounded p-1 text-center cur-pointer">
           
           <div class="col-12">
               
                <?=show_image(product_img($value->id),160, 0, 'slide', '', 'img-middle-center h-90')?>
           </div>
            <div class="title-produk border-hotpink ml-3 mr-3 bold text-overflow-hidden"><?=$value->product_name?></div>
            <div class="harga-produk pt-1 pb-0">
                <?php if ($value->diskon == 0): ?>
                <p class="m-0 lh-12 fs-12 p-1 bold" style="min-height: 40px; line-height: 30px">
                    <?=rupiah($value->harga)?>
                </p>
                    
                <?php else: ?>
                    
                <p class="m-0 lh-12 fs-12 p-1" style="min-height: 40px">
                    <?=rupiah(($value->harga - ($value->harga*($value->diskon/100))))?> (<?=$value->diskon?>%)<br> <strike class="fs-10 p-0"><?=rupiah($value->harga)?></strike>
                </p>
                <?php endif ?>
            </div>
        </div>
    </div>
</a>
<?php endforeach ?>
