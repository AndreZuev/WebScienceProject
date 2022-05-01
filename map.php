<?php 
    require_once("header.php");
?>

<script>
    let myMap;
    let graveyard = new google.maps.LatLng(45.9840329, -112.5408545);
    let marker = null;

    function initialize() {
        let mapOptions = {
            zoom: 17,
            center: graveyard,
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            scrollWheel: false,
            zoomControl: false,
            minZoom: 17,
            maxZoom: 17,
            streetViewControl: false,
            fullscreenControl: false
        }
        myMap = new google.maps.Map(document.getElementById('map'), mapOptions);
    }

    function center() {
        myMap.panTo(graveyard);
    }

    function setMarker(block, lat, long) {
        let marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            title: block
        });
        marker.setMap(myMap);
        return marker;
    }

    function deleteMarker(marker) {
        marker.setMap(null);
    }

    function onSelectChange(idx) {
        $.ajax({
            url: "block.php?blockid=" + idx,
            type: "GET",
            success: (value) => {
                if (marker != null) {
                    deleteMarker(marker);
                }
                marker = setMarker(value.idBlock, value.blockLatitude, value.blockLongitude);
            },
            error: () => {
                showWarningOverMap("Block not found!");
            }
        });
    }

    let myLocation = null;

    function goToMe() {
        if (navigator.geolocation.getCurrentPosition(
            (position) => {
                let pp = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                myMap.panTo(pp);

                console.log(pp);

                if (myLocation != null) {
                    myLocation.setMap(null);
                }

                myLocation = new google.maps.Marker({
                    position: new google.maps.LatLng(pp.lat(), pp.lng()),
                    title: "My Location",
                    map: myMap,
                    icon: "./user_marker.png"
                });
            }
        ));
    }

    function showWarningOverMap(text) {
        let main_div = document.getElementById('warning-over-map');
        let text_p = document.getElementById('warning-over-map-text');
        text_p.textContent = text;
        main_div.style.display = "block";
        setTimeout(() => { main_div.style.display = "none"; }, 5000);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="container main-content">
    <div class="map-wrapper">
        <div id="map" style="height: 90vh; width: 100vw;"></div>

        <div class="over-map">
            <div style="background-color: var(--primary-color);">
                <h1 class="nice-text" style="color: white; margin: 0;">Graveyard Map</h1>
            </div>
            <div class="flex">
                <div class="container">
                    <span class="nice-text">Choose block </span><br>
                    <input list="block" onchange="onSelectChange(this.value);">
                    <datalist name="block" id="block">
                    </datalist>
                </div>
                <div class="container">
                    <img class="lots-image" src="LOT.png" />
                </div>
                <div class="container" style="flex-direction: row; gap: 1rem;">
                    <button class="button" onclick="center();">Center</button>
                    <button class="button" onclick="goToMe();">My Location</button>
                </div>
            </div>
        </div>

        <div id="warning-over-map" style="display: none;">
            <p id="warning-over-map-text"></p>
        </div>
    </div>
</div>

<script>
    $.ajax({
        url: "block.php",
        type: "GET",
        success: (data) => {
            $.each(data, (i, item) => {
                $("#block").append(`
                    <option value=${item.idBlock}>${item.idBlock}</option>
                `);
            });
        },
        error: () => {
            showAlert("Failed to fetch blocks!");
        }
    });
</script>

<?php
    require_once("footer.php");
?>