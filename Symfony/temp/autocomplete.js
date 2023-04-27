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
inputElem1.addEventListener("keyup", async () => {
    let inputValue1 = inputElem1.value
    if (inputValue1) {
        searchInput1.classList.add("active")
        try {
            const { latitude, longitude } = await getLocation();

            // Perform an AJAX request to the Symfony endpoint to fetch the auto-complete results
            // const response = await fetch(`http://127.0.0.1:8000/autocomplete?input=${inputValue}&latitude=${latitude}&longitude=${longitude}&radius=${radius}`);
            // const predictions = await response.json();
            // console.log(predictions['predictions']);

            suggestionWordsGenerator1(["random", "words", "for", "testing", "purpose", "only"])
        } catch (error) {
            console.error(error);
        }
    } else {
        searchInput1.classList.remove("active")
    }

})


//Desitination
inputElem.addEventListener("keyup", async () => {
    let inputValue = inputElem.value
    if (inputValue) {
        searchInput.classList.add("active")
        try {
            const { latitude, longitude } = await getLocation();

            // Perform an AJAX request to the Symfony endpoint to fetch the auto-complete results
            // const response = await fetch(`http://127.0.0.1:8000/autocomplete?input=${inputValue}&latitude=${latitude}&longitude=${longitude}&radius=${radius}`);
            // const predictions = await response.json();
            // console.log(predictions['predictions']);

            suggestionWordsGenerator(["random", "words", "for", "testing", "purpose", "only"])
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
        //word['description']
        return "<li>" + word + "</li>"
    }).join("")

    if (suggestionWord) {
        liContainer.innerHTML = suggestionWord
    } else {
        liContainer.innerHTML = "<li>" + inputElem.value + "</li>"
    } Select()
}

function suggestionWordsGenerator1(wordArray) {
    let suggestionWord = wordArray.map(function (word) {
        //word['description']
        return "<li>" + word + "</li>"
    }).join("")

    if (suggestionWord) {
        liContainer1.innerHTML = suggestionWord
    } else {
        liContainer1.innerHTML = "<li>" + inputElem1.value + "</li>"
    } Select1()
}

function Select1() {
    let allListItems = liContainer1.querySelectorAll("li")
    allListItems.forEach(function (wordItem) {
        wordItem.addEventListener("click", function (e) {
            inputElem1.value = e.target.textContent
            searchInput1.classList.remove("active")
        })
    })
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


//fill inputElem1 with location when icon clicked
let icon1 = $.querySelector(".search-input1 .icon")
icon1.addEventListener("click", async () => {
    try {
        const { latitude, longitude } = await getLocation();
        console.log(latitude, longitude)
    }
    catch (error) {
        console.error(error);
    }
})
