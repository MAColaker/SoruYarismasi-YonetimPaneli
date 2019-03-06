
async function ajax(param,func) {

    let res;


    $.ajax
    ({
        //type:Göndereceğimiz metodu belirler
        type	: "POST",
        //url :veri istenilen php dosyasının adresi
        url:'http://localhost/islamiyarisma/network/ajax.php',
        //data :verileri göndermek için
        data:param,
        //veri tipini belirler
        dataType:'json',
        //zaman aşımı süresi 3000 milisaniye
        timeout: 3000,
        //success :İstenilen veri geldi ise
        success	: function (donen_veri) {
            func(donen_veri);
        },
        //error   :Bir hata meydana geldi ise
        error:function(hata) {
            func(false);
        }
    });

    return res;
}
