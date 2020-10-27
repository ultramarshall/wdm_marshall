<div class="row mt-2">
    <div id="demo" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://griyalaptop.com/wp-content/uploads/2020/03/banner-dell-laptops-0518-3.jpg" style="width: 100%; height: 500px; background-size: cover;" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img src="https://griyalaptop.com/wp-content/uploads/2020/03/banner-dell-laptops-0518-3.jpg" style="width: 100%; height: 500px; background-size: cover;" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img src="https://griyalaptop.com/wp-content/uploads/2020/03/banner-dell-laptops-0518-3.jpg" style="width: 100%; height: 500px; background-size: cover;" alt="New York">
        </div>
    </div>



    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>

    </div>
</div>

<style>
#demo {
    width: 100%
}
</style>




<div class="section">
    <div class="row">
        <div class="col-12" style="padding: 40px 0px">
            <div class="col-4 m-auto" style="">
                <input type="email" class="form-control col-12 mb-2" placeholder="NPWP" id="npwp">
                <input type="email" class="form-control col-12 mb-2" placeholder="Settlement No" id="settlement_no">
            </div>
        
            <div class="col-6 m-auto text-center py-4">
                <button class="btn col-4 bg-default text-white bold" id="download">
                    <i class="fa fa-home"></i> Download
                </button>
                <button class="btn col-4 bg-default text-white bold" id="print">
                    <i class="fa fa-home"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="printPreview" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog mw-100 w-75" role="document">
    <div class="modal-content">
      <div class="modal-body" style="min-height: 86vh;">
        <iframe src="https://docs.google.com/viewerng/viewer?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true" frameborder="0" style="height: 82vh;" width="100%"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Print</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>