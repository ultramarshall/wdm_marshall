<button class="btn-promo btn border r-20 pull-right ml-2 white cur-pointer p-0 m-0 pl-3 pr-3" id="btn-kode-promo" style="line-height: 28px">oke</button>
<input type="text" id="code" class="form-control r-20 w-100px pull-right" value="<?=$kode?>">
<span class="pull-right mr-2" style="line-height: 31px">Kode Promo</span>
	
<div class="col-12 float-right px-0 pt-3">
	<?php if (!$kode_status): ?>
		<div class="alert alert-danger text-danger bold float-right w-100px" >
			EXPIRED
		</div>
	<?php else: ?>
		<input type="hidden" id="cashback" value="<?=$kode_status[0]['cash_back']?>">
		<div class="alert alert-success text-success bold float-right w-200px" >
			CASHBACK <?php echo rupiah($kode_status[0]['cash_back']);?>
			<script>
				(function(){
					diskon = parseInt(<?=$kode_status[0]['cash_back']?>)
					var total = parseInt($('#total').val()) - diskon;
					$('#subtotal').text(accounting.formatMoney(total))

				})();
			</script>
		</div>
	<?php endif ?>
</div>