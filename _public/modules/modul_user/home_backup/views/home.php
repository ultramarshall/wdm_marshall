<div class="row mt-3">
    <div class="col-sm-12 col-md-9 col-xl-9 float-left" >
        <div class="lightSlider" data-item="1" data-item-xl="1" data-item-md="1" data-item-sm="1" data-pause="5000" data-pager="false" data-auto="true" data-loop="true">
            <?php foreach ($banners as $value): ?>
                        
            <div style="max-height: 300px; overflow: hidden; position: relative;">
                <div class="white text-center" >
                    <?=show_image($value->banner_logo, 0, 0, 'staft', '', 'img-middle-center w-100')?>
                </div>
            </div>
            <?php endforeach ?>        

        </div>
    </div>
    
    
    <div class="col-md-3 col-xl-3 float-left p-0 d-sm-none d-md-block banner-right-top">
        <?php foreach ($banners as $value): ?>
        <div class="col-12 m-0 mb-3">
            <a href="#" class="nav-link p-0" data-toggle="dropdown">
                    <?=show_image($value->banner_logo, 0, 0, 'staft', '', 'h-120 w-100')?>
            </a>
        </div>
        <?php endforeach ?>  
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h3 class="pt-3 pb-2 mb-3 border-pink bold">Highlight Product</h3>
        <div class="lightSlider" data-item="8" data-item-xl="8" data-item-lg="6" data-item-md="4" data-item-sm="3" data-pause="2000" data-pager="false" data-auto="true" data-loop="true">
            <?php foreach ($highlight_product as $value): ?>
            <div>
                <div class="white text-center">
                    <?php 
                    $img = json_decode($value->product_logo);
                    ?>
                    <?=show_image($img[0]->nama,160, 0, 'slide', '', 'img-middle-center hw-120')?>
                </div>
            </div>
            <?php endforeach ?>
  
        </div>
    </div>
</div>
<div class="row">
    <div class="product-highlight mt-3 col-12 p-2">
        <?php foreach ($categories as $value): ?>
            
        <div class="col-3 col-sm-3 col-md-2 col-lg-1 p-0 float-left pt-1 pb-1">
            <div class="col-10 p-0 m-auto white shadow-sm rounded p-1 text-center">
                <a href="#" class="d-block">
                    <?=show_image($value->category_logo,160, 0, 'staft', '', 'img-middle-center hw-6 p-2')?>
                    <div class="title-produk mr-3 fs-10 w-100"><?=ucwords($value->category_name)?></div>
                </a>
            </div>
        </div>
        
        <?php endforeach ?>
    </div>
    <div class="col-12 mt-3">
        <a href="#" class="float-right">
            <span>Lihat Semua</span>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12 relative">
        <h3 class="pt-3 pb-2 mb-3 border-pink bold">Flash Sale</h3>
        <div class="clock d-flex col-12 float-left p-0" end-event="<?=$flashsale->end_event?>" style="zoom:.3; position: absolute; top: -2px; left: 350px"></div>
        
        <div class="lightSlider" data-item="8" data-item-xl="6" data-item-md="4" data-item-sm="4" data-pause="5000" data-pager="false" data-auto="true" data-loop="true">
           <?php foreach ($flashsale->product_sale as $value): ?>
            <a href="<?=base_url('product/'.$value->id)?>">
            <div>
                <div class="white text-center">
                    <?php 
                    $img = json_decode($value->product_logo);
                    ?>
                    <?=show_image($img[0]->nama,160, 0, 'slide', '', 'img-middle-center hw-120')?>
                </div>
            </div>
            </a>
           <?php endforeach ?>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-5">
        <h3 class="pt-3 pb-2 mb-3 border-pink bold">Brand Terkemuka</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <?php foreach ($brands as $key => $value): ?>
            <?=show_image($value->brand_logo,160, 0, 'staft', '', 'float-left col-3 col-sm-3 col-md-3 col-lg-2 border white h-90 w-100 p-4')?>
        <?php endforeach ?>
    </div>
    <div class="col-4 sm-none d-sm-none d-md-block">
        <img class="w-100 white" src="http://ailinmall.com/assets/img/banner-terkemuka.jpg">
    </div>
</div>
<div class="row">

    <div class="product-highlight mt-3 col-12">
        <h3 class="col-12 p-0 pt-3 pb-2 mb-3 border-pink bold">Produk Terpopuler</h3>
        <?php if (count($products) == 0): ?>
            <div class="text-center p-5 border">
                <img src="http://bright-inside.com.ua/wp-content/themes/une_boutique/images/cart-empty.png" alt="">
            </div>
        <?php else: ?>
            
            <?php foreach ($products as $value): ?>
                <a href="<?=base_url('product/'.$value->id)?>">
                    <div class="col-6 col-sm-6 col-md-3 col-lg-2 p-0 float-left mb-2">
                        <div class="col-10 p-0 m-auto white shadow rounded p-1 text-center cur-pointer">
                            <?php 
                            $img = json_decode($value->product_logo);
                            ?>
                            <?=show_image($img[0]->nama,160, 0, 'slide', '', 'img-middle-center h-90')?>
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

        <?php endif ?>
        
    </div>
    <div class="col-12 dark mt-3 mb-5">
        <a href="#" class="float-right">
            <span>
                Lihat Semua
            </span>
        </a>
    </div>
</div>