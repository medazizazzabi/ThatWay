let $ = document
let liContainer = $.querySelector(".autocom-box")
let inputElem = $.querySelector("input")
let searchInput = $.querySelector(".search-input")

const autocompleteInput = document.getElementById('autocomplete-input');
async function getLocation() {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    resolve({ latitude, longitude });
                },
                error => {
                    reject(error);
                }
            );
        } else {
            reject(new Error("Geolocation is not supported by this browser."));
        }
    });
}
const radius = 10; // The radius in miles

inputElem.addEventListener("keyup", async () => {
    let inputValue = inputElem.value
    if (inputValue) {
        searchInput.classList.add("active")
        try {
            const { latitude, longitude } = await getLocation();
            const input = autocompleteInput.value;

            // Perform an AJAX request to the Symfony endpoint to fetch the auto-complete results
            const response = await fetch(`/autocomplete?input=${input}&latitude=${latitude}&longitude=${longitude}&radius=${radius}`);
            const predictions = await response.json();

            suggestionWordsGenerator(predictions['predictions'])
        } catch (error) {
            console.error(error);
        }
    } else {
        searchInput.classList.remove("active")
    }

})

let customListItem

function suggestionWordsGenerator(wordArray) {
    let suggestionWord = wordArray.map(function (word) {
        return "<li>" + word['description'] + "</li>"
    }).join("")

    if (suggestionWord) {
        liContainer.innerHTML = suggestionWord
    } else {
        liContainer.innerHTML = "<li>" + inputElem.value + "</li>"
    }
    Select()
}

function Select() {
    let allListItems = liContainer.querySelectorAll("li")
    allListItems.forEach(function (wordItem) {
        wordItem.addEventListener("click", function (e) {
            inputElem.value = e.target.textContent
            searchInput.classList.remove("active")
        })
    })
}