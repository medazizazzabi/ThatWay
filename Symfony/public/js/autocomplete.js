let $ = document

//Origin
let liContainer1 = $.querySelector(".autocom-box1")
let inputElem1 = $.querySelector(".input1")
let searchInput1 = $.querySelector(".search-input1")
//Desitination
let liContainer = $.querySelector(".autocom-box")
let inputElem = $.querySelector(".input")
let searchInput = $.querySelector(".search-input")


// Get the user's current location
async function getLocation() {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                resolve({ latitude, longitude });
            }, error => {
                reject(error);
            });
        } else {
            reject(new Error("Geolocation is not supported by this browser."));
        }
    });
}
const radius = 10; // The radius in miles

//Origin
let timeoutId1 = null;
inputElem1.addEventListener("keyup", async () => {
    let inputValue1 = inputElem1.value
    if (inputValue1) {
        searchInput1.classList.add("active")
        if (timeoutId1) {
            clearTimeout(timeoutId1);
        }
        timeoutId1 = setTimeout(async () => {
            try {
                const { latitude, longitude } = await getLocation();

                // Perform an AJAX request to the Symfony endpoint to fetch the auto-complete results
                const response = await fetch(`autocomplete?input=${inputValue1}&latitude=${latitude}&longitude=${longitude}&radius=${radius}`);
                const predictions = await response.json();

                suggestionWordsGenerator1(predictions['predictions'])
            } catch (error) {
                console.error(error);
            }
        }, 200);
    } else {
        searchInput1.classList.remove("active")
    }

})


//Desitination
let timeoutId = null;
inputElem.addEventListener("keyup", async () => {
    let inputValue = inputElem.value
    if (inputValue) {
        searchInput.classList.add("active")
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(async () => {
            try {
                const { latitude, longitude } = await getLocation();

                // Perform an AJAX request to the Symfony endpoint to fetch the auto-complete results
                const response = await fetch(`autocomplete?input=${inputValue}&latitude=${latitude}&longitude=${longitude}&radius=${radius}`);
                const predictions = await response.json();

                suggestionWordsGenerator(predictions['predictions'])
            } catch (error) {
                console.error(error);
            }
        }, 200);
    } else {
        searchInput.classList.remove("active")
    }

})

let customListItem

function suggestionWordsGenerator(wordArray) {
    let suggestionWord = wordArray.map(function (word) {
        //word['description']
        return `<li><input type="hidden" value="${word['place_id']}">${word['description']}</li>`
    }).join("")

    if (suggestionWord) {
        liContainer.innerHTML = suggestionWord
    } else {
        liContainer.innerHTML = `<li><input type="hidden" value="">${inputElem1.value}</li>`
    } Select()
}

function suggestionWordsGenerator1(wordArray) {
    let suggestionWord = wordArray.map(function (word) {
        //word['description']
        return `<li><input type="hidden" value="${word['place_id']}">${word['description']}</li>`
    }).join("")

    if (suggestionWord) {
        liContainer1.innerHTML = suggestionWord
    } else {
        liContainer1.innerHTML = `<li><input type="hidden" value="">${inputElem1.value}</li>`;
    } Select1()
}

const hiddenInput1 = document.querySelector('#origin');
function Select1() {
    let allListItems = liContainer1.querySelectorAll("li")
    allListItems.forEach(function (wordItem) {
        wordItem.addEventListener("click", function (e) {
            inputElem1.value = e.target.textContent
            hiddenInput1.value = e.target.querySelector('input').value;
            searchInput1.classList.remove("active")

        })
    })
}

const hiddenInput = document.querySelector('#destination');
function Select() {
    let allListItems = liContainer.querySelectorAll("li")
    allListItems.forEach(function (wordItem) {
        wordItem.addEventListener("click", function (e) {
            inputElem.value = e.target.textContent
            hiddenInput.value = e.target.querySelector('input').value;
            searchInput.classList.remove("active")
        })
    })
}


//fill inputElem1 with location when icon clicked
let icon1 = $.querySelector(".search-input1 .icon")
icon1.addEventListener("click", async () => {
    try {
        const { latitude, longitude } = await getLocation();
        const response = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=`);
        const predictions = await response.json();
        inputElem1.value = predictions['results'][0]['formatted_address']
        hiddenInput1.value = predictions['results'][0]['place_id']

        //center map
        map.setCenter({
            lat: latitude,
            lng: longitude
        });
    
    }
    catch (error) {
        console.error(error);
    }
})

//
var map;

async function initializeMap() {
    const { latitude, longitude } = await getLocation();

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: latitude,
                lng: longitude
            },
            zoom: 12,
        });


        class LabelOverlay extends google.maps.OverlayView {
            constructor(position, text) {
                super();
                this.position = position;
                this.text = text;
                this.container = document.createElement('div');
                this.container.classList.add('label-overlay');
            }

            onAdd() {
                const panes = this.getPanes();
                panes.floatPane.appendChild(this.container);
            }

            draw() {
                const projection = this.getProjection();
                const position = projection.fromLatLngToDivPixel(this.position);

                this.container.style.left = `${position.x - 60}px`;
                this.container.style.top = `${position.y - 60}px`; // Adjust this value to position the label above the pin
                this.container.innerHTML = this.text;
            }

            onRemove() {
                this.container.remove();
            }
        }

        var currentLocationIcon = {
            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        };

        var currentLocationMarker = new google.maps.Marker({
            position: { lat: latitude, lng: longitude },
            map: map,
            icon: currentLocationIcon,
        });


        // Add a custom label above the blue pin
        var labelOverlay = new LabelOverlay(
            currentLocationMarker.getPosition(),
            'Current Location'
        );
        labelOverlay.setMap(map);
    }
    initMap();
}

initializeMap();

const searchBtn = document.querySelector("#search-btn");
const ol = document.querySelector('.numbered');

let markers = [];

let polyline = null;

searchBtn.addEventListener("click", async () => {

    class LabelOverlay extends google.maps.OverlayView {
        constructor(position, text) {
            super();
            this.position = position;
            this.text = text;
            this.container = document.createElement('div');
            this.container.classList.add('label-overlay');
        }

        onAdd() {
            const panes = this.getPanes();
            panes.floatPane.appendChild(this.container);
        }

        draw() {
            const projection = this.getProjection();
            const position = projection.fromLatLngToDivPixel(this.position);

            this.container.style.left = `${position.x - 60}px`;
            this.container.style.top = `${position.y - 60}px`; // Adjust this value to position the label above the pin
            this.container.innerHTML = this.text;
        }

        onRemove() {
            this.container.remove();
        }
    }



    // Clear the old markers from the map
    markers.forEach(marker => marker.setMap(null));
    // Empty the markers array
    markers = [];

    // Remove the old polyline from the map
    if (polyline) {
        polyline.setMap(null);
    }

    // Fetch /getstations and add a marker for every station
    try {
        const response = await fetch(`/findstations?startid=${hiddenInput.value}&endid=${hiddenInput1.value}`);
        const stations = await response.json();
        if(stations.length == 0){
            //insert a div inside the ol
            let div = document.createElement('div');
            div.innerHTML = "No routes found";
            div.classList.add('no-routes');
            ol.appendChild(div);
            return;
        }

        //reverse the array
        stations.reverse();
        // console.log(stations);

        // Create an array to store the LatLng coordinates of the stations
        let pathCoordinates = [];

        stations.forEach(station => {
            const position = {
                lat: parseFloat(station['longitude']),
                lng: parseFloat(station['latitude'])
            };
            var marker = new google.maps.Marker({
                position: position,
                map: map,
                title: station['name']
            });

            // Add the marker to the markers array
            markers.push(marker);

            // Add the LatLng coordinates to the pathCoordinates array
            pathCoordinates.push(position);
        });

        // Draw the polyline between the markers
        polyline = new google.maps.Polyline({
            path: pathCoordinates,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        polyline.setMap(map);

        // add the station name as an li wiht the station name inside ol.numbered*
        ol.innerHTML = '';
        stations.forEach(station => {
            let li = document.createElement('li');
            li.innerText = station['name'];
            ol.appendChild(li);
        });


    }
    catch (error) {
        console.error(error);
    }
});
