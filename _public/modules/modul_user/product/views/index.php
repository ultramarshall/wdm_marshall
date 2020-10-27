<?php 
$o = json_decode($product['product_logo']);
$v = explode(' ', ucwords(str_replace(',', ' ', $product['varian'])));
?>


<span id="title" class="fs-32">Shop</span>
<div class="row mt-4 mb-5">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div class="lSSlideOuter">
            <ul id="lightSlider" class="border">
       
                <?php foreach ($o as $value): ?>
                    <li data-thumb="<?=base_url('themes/file/slide/'.$value->nama)?>" class="bg-white" style="">
                        <img src="<?=base_url('themes/file/slide/').$value->nama?>" style="width: auto">
                    </li>
                <?php endforeach ?>
                
            </ul>
            <div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>
        </div>
    </div>
    <div class="right-product-column col-12 col-sm-12 col-md-6 col-lg-6">
        <h2 class="bold text-black mb-0"><?=$product['product_name']?></h2>
        <div class="col-12 p-0 rating">
            <span class="icon-star-3"></span>
            <span class="icon-star-3"></span>
            <span class="icon-star-3"></span>
            <span class="icon-star-3"></span>
            <span class="icon-star_half"></span>
        </div>
        <div class="row">
            <div class="col-9">
                <h3 class="bold text-black"><?=rupiah($product['harga'])?></h3>
            </div>
            <div class="col-12">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur placeat, consectetur suscipit, quam alias repellendus repellat a enim molestiae accusantium, minima aliquam optio nobis eos ad dolor quaerat vitae maiores.</p>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 pl-0 pr-0">
                <div class="col float-left fs-10 pr-0">
                    <span class="w-100 bold" style="line-height: 25px">SKU</span> |
                    <span class="w-100 bold" style="line-height: 25px">KATEGORI</span> |
                    <span class="w-100 bold" style="line-height: 25px">TAG</span> |
                    <span class="icon-heart text-red pull-right border r-30 p-2 mr-4 white shadow-sm cur-pointer">
                        <span class="text-black">Add Wishlist</span>
                    </span> 
                </div>
            </div>
        </div>
        <div class="row">
            <style>
                .hw-40 {
                    height: 40px;
                    width: 40px;
                }
            </style>
            <div class="col-4 col-md-5 text-center">
                <span class="text-center icon-minus float-left border hw-40 white p-3 cur-pointer" id="btn-qty" data-value="min"></span>
                <input type="text" class="text-center form-control hw-40 r-0 float-left white cur-pointer text-dark bold" id="qty" value="1" disabled>
                <span class="text-center icon-plus float-left border hw-40 white p-3 cur-pointer" id="btn-qty" data-value="max"></span>
            </div>
            <div class="col col-md-7">
                <button class="btn-add-cart btn btn-lg bg-ailin-hotpink text-white w-100 r-20 bold"><span class="icon icon-plus"></span>Beli</button>
            </div>
        </div>
        <div class="card bg-transparent no-b mt-2">
            <div class="card-header bg-transparent">
                <div class="row justify-content-end">
                    <div class="col">
                        <ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white ">
                            <li class="nav-item">
                                <a class="bold nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="false">
                                    Pilih Varian
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="bold nav-link" id="tab2" data-toggle="tab" href="#v-pills-tab2" role="tab" aria-controls="tab2" aria-selected="false">
                                    Deskripsi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="bold nav-link" id="tab3" data-toggle="tab" href="#v-pills-tab3" role="tab" aria-controls="tab3" aria-selected="true">
                                    Produk Info
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body no-p">
                <div class="tab-content">
                    <div class="tab-pane fade p-0 active show" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">
                        <div class="row">
                            <div class="col-12 pt-2 pb-2">
                                <?php foreach ($v as $x => $i): ?>
                                    <input type="checkbox" class="o-varian d-none m-0 p-0" id="varian-<?=$i?>"> 
                                    <label for="varian-<?=$i?>" data-varian="<?=$i?>" class="btn-varian r-20 col-sm-6 mt-2 mb-2 col-lg-3 float-left col-md-4 text-center shadow-sm <?=($x==0)?'checked-active':''?>"><?=$i?></label>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-4" id="v-pills-tab2" role="tabpanel" aria-labelledby="v-pills-tab2">
                        <p>
                            <?php 
                            if ($product['product_desc'] ==null) {
                                echo "Belum ada Deskripsi";
                            } else {
                                echo $product['product_desc'];
                            }
                            ?>
                                
                        </p>
                    </div>
                    <div class="tab-pane fade text-center p-5" id="v-pills-tab3" role="tabpanel" aria-labelledby="v-pills-tab3">
                        <h4 class="card-title">No Info</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row mb-5">
    <div class="col-12">
        <div class="card" >
            <div class="card-title p-3 pl-4 bg-ailin-hotpink text-white bold ">
                Ulasan Produk
            </div>
            <div class="card-body chat-widget p-3 ">
                <div class="w-body w-scroll" style="min-height: 160px" id="comment">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?=$product['id']?>" id="idnya">
<input type="hidden" value="<?=$product['harga']?>" id="price">
<input type="hidden" value="<?=$product['product_name']?>" id="name">
