<style>
    .address-action {
        position: absolute;
        right: 10px;
        z-index: 3;
        top: 30%
    }
</style>
<div class="profile-sec">
    <div class="container">
        <div class="top-title">
            <h2><i class="fa fa-home fa-fw" style="color: hotpink"></i>Alamat</h2>
            <p class="profile-info pl-1 fs-12 p-0 m-0 border-bottom mb-3">
                Kelola informasi profil anda untuk mengontrol, melindungi dan mengamankan akun
                <button class="btn-add btn-ailin r-20 color-hotpink bold btn-sm cur-pointer shadow-sm float-right" data-toggle="modal" data-target=".ailin-modal"
                        style="background-color: #fff; border: 3px solid hotpink; outline: none">
                    <i class="fa fa-plus fa-fw"></i>
                    <span>Tambah</span>
                </button>
            </p>

            <?php 

            $i = 0;
            foreach ($address as $key => $value) {
                $checked = ($value->default==0)?'':'checked';
                $imgGrayscale = ($value->default==0)?'rgba(0, 0, 0, 0.43)':'hotpink';
            ?>

            <div class="address-box text-left r-3 shadow-sm col-12 rad-2 mb-3" style="background-color: <?=$imgGrayscale?>; overflow: hidden;" >
                    <div class="address-title p-2 bold">
                            <?php 
                                $kec = $this->rajaongkir->subdistrict($value->kota, $value->kecamatan);
                                $sub = json_decode($kec);
                            ?>
                            <?=$sub->rajaongkir->results->subdistrict_name?>
                    </div>
                    <div class="address-detail pl-2 pb-2 fs-10">
                        <?=$value->alamat_rumah?> 
                    </div>
                    <div class="address-action pull-right">
                        <div class="switchToggle">
                            <input type="checkbox" id="addr-<?=$i?>" data-id="<?=$value->id?>" class="apa" <?=$checked?> >
                        </div>
                    </div>
                            <label for="addr-<?=$i?>" 
                                style="position: absolute;
                                       left: 0;
                                       right: 0;
                                       top: 0;
                                       bottom: -10px;
                                       cursor: pointer;"></label>
            </div>
            <?php $i++; } ?>
            

           
        </div>
    </div>
</div>

<div class="modal fade ailin-modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md ">
    <div class="modal-content">
        <div class="card bg-white">
            <div class="card-title text-left">Tambah Alamat</div>
            <div class="card-body text-left">
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select class="province form-control" id="province" style="width: 100%">
                            <?php foreach ($provinsi as $x): ?>
                                <option value="<?=$x->province_id?>"><?=$x->province?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group d-none" id="group-city">
                        <label>Kota</label>
                        <select class="city form-control" id="city" style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group d-none" id="group-subdistrict">
                        <label>Kecamatan</label>
                        <select class="subdistrict form-control" id="subdistrict" style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Pos</label>
                        <input type="text" class="form-control" id="kode_pos" style="width: 100%">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat Rumah</label>
                        <textarea id="address_detail" cols="30" rows="3" class="form-control" style="width: 100%"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm bg-pink text-white pull-right simpan">Simpan</button>
                    </div>
            </div>
        </div>
    </div>
  </div>
</div>

<style>
    .address-box {
        transition: background .2s ease;
    }
</style>