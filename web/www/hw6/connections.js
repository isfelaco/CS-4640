/**
 * This function will query the CS4640 server for a new set of categories.
 *
 * It makes use of AJAX and Promises to await the result.  We won't discuss
 * promises in detail, so you're welcome to review this code for more
 * details.  However, essentially we need the browser to send an AJAX query
 * to our API and then wait for a reply.  If it just waits, then the browser
 * tab will appear to be frozen briefly while the HTTP request is taking place.
 * Therefore, we send the request with a Promise that awaits the results.  When
 * the response comes back from the server, the promise will return the result
 * to our getRandomCategories() function and that will call your function.  This happens
 * asynchronously, so you should treat your function like you would an event
 * handler.
 */
function queryCategories() {
  return new Promise((resolve) => {
    // instantiate the object
    var ajax = new XMLHttpRequest();
    // open the request
    ajax.open(
      "GET",
      "https://cs4640.cs.virginia.edu/homework/connections.php",
      true
    );
    // ask for a specific response
    ajax.responseType = "json";
    // send the request
    ajax.send(null);

    // What happens if the load succeeds
    ajax.addEventListener("load", function () {
      // Return the word as the fulfillment of the promise
      if (this.status == 200) {
        // worked
        resolve(this.response);
      } else {
        console.log(
          "When trying to get a new set of categories, the server returned an HTTP error code."
        );
      }
    });

    // What happens on error
    ajax.addEventListener("error", function () {
      console.log(
        "When trying to get a new set of categories, the connection to the server failed."
      );
    });
  });
}

/**
 * This is the function you should call to request a new word.
 * It takes one parameter: a callback function.  The function
 * passed in (i.e., a function you write) should take one
 * parameter (the new categories provided by the server) and handle the
 * setup of your new game.
 */
async function getRandomCategories(callback) {
  var newCategories = await queryCategories();
  callback(newCategories);
}

let selectedCells = [];

/**
 * Setup a new game
 */
function setUpNewGame(newCategories) {
  window.localStorage.clear();
  selectedCells = [];

  const categories = newCategories.categories;
  const words = categories.flatMap((category) => category.words);
  const shuffledWords = shuffleArray(words);

  window.localStorage.setItem("categories", JSON.stringify(categories));
  window.localStorage.setItem("words", JSON.stringify(shuffledWords));
  window.localStorage.setItem("guesses", JSON.stringify([]));
  renderGrid();
  updateGuessesList();
}

/**
 * Shuffle an array
 */
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    // Generate a random index between 0 and i (inclusive)
    const j = Math.floor(Math.random() * (i + 1));

    // Swap elements array[i] and array[j]
    [array[i], array[j]] = [array[j], array[i]];
  }

  return array;
}

/**
 * Render a 4x4 grid of the words
 */
function renderGrid() {
  const words = JSON.parse(window.localStorage.getItem("words"));

  const table = document.getElementById("words-grid");
  table.innerHTML = "";

  if (words.length > 0) {
    for (let i = 0; i < 4; i++) {
      const row = document.createElement("tr");
      for (let j = 0; j < 4; j++) {
        const index = i * 4 + j;
        if (index < words.length) {
          const cell = document.createElement("td");
          cell.textContent = words[index];
          cell.addEventListener("click", () => {
            toggleCellSelection(cell);
          });
          row.appendChild(cell);
        }
      }
      table.appendChild(row);
    }
  } else {
    table.innerHTML = "<h1>Game Over!</h1>";
  }
}

/**
 * Shuffle the board
 */
function shuffleBoard() {
  const words = JSON.parse(window.localStorage.getItem("words"));
  const shuffledWords = shuffleArray(words);
  window.localStorage.setItem("words", JSON.stringify(shuffledWords));
  renderGrid();
}

/**
 * Select/deselect a cell
 */
function toggleCellSelection(cell) {
  if (selectedCells.length === 4 && !cell.classList.contains("selected")) {
    // there are already 4 cells selected
    return;
  }
  if (cell.classList.contains("selected")) {
    // deselect the cell
    cell.classList.remove("selected");
    const index = selectedCells.indexOf(cell.textContent);
    if (index !== -1) {
      selectedCells.splice(index, 1);
    }
  } else {
    // select the cell
    cell.classList.add("selected");
    selectedCells.push(cell.textContent);
  }

  // enable/disable the submit button
  const guessBtn = document.getElementById("guess-button");
  if (selectedCells.length === 4) guessBtn.disabled = false;
  else guessBtn.disabled = true;
}
/**
 * Submit a guess
 */
function handleGuess() {
  console.log("Submitting guess: ", selectedCells);

  const categories = JSON.parse(window.localStorage.getItem("categories"));
  const words = JSON.parse(window.localStorage.getItem("words"));
  console.log(words);

  let matchCount = 0;

  for (const category of categories) {
    const catWords = category.words;

    let curCount = 0;
    // count the number of correct words in the guess for the current category
    selectedCells.forEach((word) => {
      if (catWords.includes(word)) {
        curCount++;
      }
    });

    if (curCount === 1) curCount = 0;
    if (curCount > matchCount) matchCount = curCount;

    // check if the entire guess matches the category
    if (curCount === 4) {
      // remove the correctly guessed words from the grid
      const filteredWords = words.filter(
        (word) => !selectedCells.includes(word)
      );
      window.localStorage.setItem("words", JSON.stringify(filteredWords));
      renderGrid();
      break;
    }
  }
  // add the guess to the array of guesses
  const guesses = JSON.parse(window.localStorage.getItem("guesses"));
  guesses.push({ guess: [...selectedCells], matchCount });
  window.localStorage.setItem("guesses", JSON.stringify(guesses));

  if (matchCount === 4) selectedCells = [];

  // update the guess list
  updateGuessesList(matchCount);
}

function updateGuessesList() {
  const list = document.getElementById("guesses-list");
  list.innerHTML = ""; // Clear previous content

  // Retrieve the current guesses from localStorage
  const guesses = JSON.parse(window.localStorage.getItem("guesses")) || [];

  // Iterate over each guess and create a list item
  guesses.forEach((guessObj) => {
    const { guess, matchCount } = guessObj;

    const guessItem = document.createElement("li");
    guessItem.classList.add("list-group-item");
    guessItem.textContent = guess.join(", "); // Display guess as comma-separated string

    // add a badge for number of correct words
    const badge = document.createElement("span");
    let badgeClass = "";
    switch (matchCount) {
      case 2:
      case 3:
        badgeClass = "bg-warning";
        break;
      case 4:
        badgeClass = "bg-success";
        break;
      default:
        badgeClass = "bg-danger";
        break;
    }
    badge.classList.add("badge", badgeClass);
    badge.textContent = matchCount;
    guessItem.appendChild(badge);

    list.appendChild(guessItem);
  });
}
