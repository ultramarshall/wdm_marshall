
$(document).on("change", "#file", function() {

  if (this.files && this.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.img').attr('src', e.target.result);
    }

    reader.readAsDataURL(this.files[0]);
  }
});


var cleave = new Cleave('.hp', {
    phone: true,
    phoneRegionCode: 'ID'
});


$(document).ready(function(){
  var i = 0;
  window.setInterval(function () {
      console.log(i)

      i = i + 1;
      clearTimeouts();
  }, 1000);

  function clearTimeouts() {
    window.clearTimeout();
  }
})