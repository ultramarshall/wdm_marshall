<div class="filter">
    <table class="table table-filter">
        <!-- <tr>
            <td class="p-0">
                <div class="fs-10 bold pl-2">Category</div>
                <div class="col p-2 brands">
                    <div class="badge badge-pill badge-primary mb-1 cur-pointer bold selected">Category</div>
                    <div class="badge badge-pill badge-primary mb-1 cur-pointer bold">Category</div>
                    <div class="badge badge-pill badge-primary mb-1 cur-pointer bold">Category</div>
                    <div class="badge badge-pill badge-primary mb-1 cur-pointer bold">Category</div>
                </div>
            </td>
        </tr> -->
        <tr>
            <td class="p-0 pt-2">
                <div class="fs-10 bold pl-2">
                    <div class="float-left col-4 pl-0">Brand</div>
                    <div class="float-left col badge badge-primary mb-1 cur-pointer fs-12 selected" id="key">Miniso</div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="p-0">
                <div class="fs-10 bold pl-2 mb-1">Price</div>
                  <input type="text" id="prange" class="d-none">
            </td>
        </tr>
       
    </table>
</div>
<div id="x-content" class="mb-5"></div>              
                    
<style>

.filter {
    width: 180px;
    float: left;
    position: relative;
}

#x-content {
    width: calc(100% - 180px);
    float: left;
    position: relative;
}
.brands > .selected {
    background: #ED5564;
}

</style>