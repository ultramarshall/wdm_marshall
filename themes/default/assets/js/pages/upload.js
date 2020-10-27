/*$('#excel_files').on('change', function(){

        

        //Reference the FileUpload element.
        var fileUpload = document.getElementById("excel_files");
 
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {

            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        console.log(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
})
*/

function fileReader(oEvent) {
    var oFile = oEvent.target.files[0];
    var sFilename = oFile.name;

    var reader = new FileReader();
    var result = {};

    reader.onload = function (e) {
        var data = e.target.result;
        data = new Uint8Array(data);
        var workbook = XLSX.read(data, {type: 'array'});
        // console.log(workbook);
        var result = {};
        workbook.SheetNames.forEach(function (sheetName) {
            var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
            if (roa.length) result[sheetName] = roa;
        });
        // see the result, caution: it works after reader event is done.
        upLoadExcel(result);
    };
    reader.readAsArrayBuffer(oFile);
}

$('#excel_files').change(function(ev) {
    fileReader(ev);
})


function upLoadExcel(data) {

        $.ajax({
            type     : 'post',
            url      : base_url + 'upload/upload_excel',
            data     : data,
            success  : function(response) {
                // pesan_toastr('Sukses','info','Prosess','toast-bottom-right');
                $('#excel_files').val('')
                if(response) {
                    location.reload()
                } else {
                    alert('upload gagal. format excel file salah')
                }
            }
        });


}