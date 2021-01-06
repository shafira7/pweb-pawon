//ambil elemen dgn penelusuran dom

var keyword = document.getElementById('keyword');
var searchButton = document.getElementById('search-button');
var card = document.getElementById('card');

keyword.addEventListener('keyup', function () {

    //object ajax
    var xhr = new XMLHttpRequest();

    //cek kesiapan ajax
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            card.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', 'assets/ajax/resep.php?keyword=' + keyword.value, true);
    xhr.send();
});