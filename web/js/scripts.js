
function addEditAjax(url, postData, csrfToken) {

    //console.log(JSON.stringify(postData));
    $.ajax({
        type: 'POST',
        url: url,
        data: postData,
        error: function () {
            console.log('Hata oluştu');
        },
        success: function (data) {
            console.log('data : ');
            console.log(JSON.stringify(data));


            if (data.isError == false) {
                delete data.isError;
                table
                        .clear()
                        .draw();

                $.each(data, function (k, x) {
                    console.log(x["sofor_sicil_no"]);
                    table.row.add([
                        x["sofor_sicil_no"],
                        x["ad"],
                        x["soyad"],
                        x["gsm"],
                        x["operator_adi"],
                        x["tckimlik_no"],
                        x["pdks_sicil_no"]
                    ]).draw();
                });
            }else {
                alert(data.errorMessage);
            }
        }
    });
}

function drawTableByData() {

}