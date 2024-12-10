function shoes_store_open_tab(evt, cityName) {
    var shoes_store_i, shoes_store_tabcontent, shoes_store_tablinks;
    shoes_store_tabcontent = document.getElementsByClassName("tabcontent");
    for (shoes_store_i = 0; shoes_store_i < shoes_store_tabcontent.length; shoes_store_i++) {
        shoes_store_tabcontent[shoes_store_i].style.display = "none";
    }
    shoes_store_tablinks = document.getElementsByClassName("tablinks");
    for (shoes_store_i = 0; shoes_store_i < shoes_store_tablinks.length; shoes_store_i++) {
        shoes_store_tablinks[shoes_store_i].className = shoes_store_tablinks[shoes_store_i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

jQuery(document).ready(function () {
    jQuery( ".tab-sec .tablinks" ).first().addClass( "active" );
});