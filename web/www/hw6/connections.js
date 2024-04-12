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
 * Setup a new board with new words
 * Called after startSession and whenever the New Game button is clicked
 */
function setUpNewGame(newCategories) {
  /* update the number of games played, streak, and total guesses */
  const games = JSON.parse(window.localStorage.getItem("games"));
  window.localStorage.setItem("games", JSON.stringify(games + 1));
  const prevWords = JSON.parse(window.localStorage.getItem("words")) || [];
  if (prevWords.length !== 0) window.localStorage.setItem("streak", 0);

  /* get new categories and words */
  const categories = newCategories.categories;
  const words = categories.flatMap((category) => category.words);
  const shuffledWords = shuffleArray(words);
  window.localStorage.setItem("categories", JSON.stringify(categories));
  window.localStorage.setItem("words", JSON.stringify(shuffledWords));

  /* reset the guesses and the selectedCells */
  window.localStorage.setItem("guesses", JSON.stringify([]));
  window.localStorage.setItem("selectedCells", JSON.stringify([]));

  /* re-render the UI */
  document.getElementById("alert").style.display = "none";
  renderGame();
}

/**
 * Render the game
 */
function renderGame() {
  document.getElementById("guess-button").disabled = selectedCells.length !== 4;
  document.getElementById("new-game-button").disabled =
    localStorage.length === 0;
  document.getElementById("shuffle-button").disabled =
    JSON.parse(localStorage.getItem("words") || "[]").length === 0;

  const sessionBtn = document.getElementById("session-button");
  if (localStorage.length === 0) {
    /* no active session, allow user to start new one */
    // update the game buttons
    sessionBtn.textContent = "Start a New Session";
    sessionBtn.onclick = function () {
      startSession();
    };
    sessionBtn.classList.remove("btn-danger");
    sessionBtn.classList.add("btn-success");
  } else {
    /* active session, allow user to end session */
    // update the game buttons
    sessionBtn.textContent = "End Session";
    sessionBtn.onclick = function () {
      endSession();
    };
    sessionBtn.classList.remove("btn-success");
    sessionBtn.classList.add("btn-danger");

    // reset the selectedCells
    window.localStorage.setItem("selectedCells", JSON.stringify([]));
  }
  /* re-render the grid, the guesses, and the stats */
  renderGrid();
  renderGuessesList();
  renderStats();
}

/**
 * Start a new session
 */
function startSession() {
  /* initialize user stats */
  window.localStorage.setItem("games", 0);
  window.localStorage.setItem("wins", 0);
  window.localStorage.setItem("streak", 0);
  window.localStorage.setItem("avg-guesses", 0);
  window.localStorage.setItem("total-guesses", 0);

  /* start a new game */
  getRandomCategories(setUpNewGame);
}

/**
 * End the user's current session
 */
function endSession() {
  /* clear localStorage */
  window.localStorage.clear();

  /* re-render the UI */
  renderGame();
}

/**
 * Render a 4x4 grid of the words
 */
function renderGrid() {
  const table = document.getElementById("words-grid");
  table.innerHTML = "";

  if (localStorage.length !== 0) {
    const words = JSON.parse(window.localStorage.getItem("words"));
    if (words.length === 0) {
      table.innerHTML = "<h1>Game Over!</h1>";
      return;
    }
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
  }
}

/**
 * Select/deselect a cell
 */
function toggleCellSelection(cell) {
  var selectedCells =
    JSON.parse(window.localStorage.getItem("selectedCells")) || [];
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
  document.getElementById("guess-button").disabled = selectedCells.length !== 4;
  window.localStorage.setItem("selectedCells", JSON.stringify(selectedCells));
}

/**
 * Submit a guess
 */
function handleGuess() {
  const alert = document.getElementById("alert");
  alert.style.display = "none";

  var selectedCells = JSON.parse(window.localStorage.getItem("selectedCells"));
  console.log("Submitting guess: ", selectedCells);

  const categories = JSON.parse(window.localStorage.getItem("categories"));
  const words = JSON.parse(window.localStorage.getItem("words"));

  let matchCount = 0;
  let filteredWords = words;

  for (const category of categories) {
    const catWords = category.words;

    let curCount = 0;
    /* count the number of correct words in the guess for the current category */
    selectedCells.forEach((word) => {
      if (catWords.includes(word)) {
        curCount++;
      }
    });

    if (curCount === 1) curCount = 0;
    if (curCount > matchCount) matchCount = curCount;

    /* check if the entire guess matches the category */
    if (curCount === 4) {
      // remove the correctly guessed words from the grid
      filteredWords = words.filter((word) => !selectedCells.includes(word));
      window.localStorage.setItem("words", JSON.stringify(filteredWords));

      // send feedback with correct category
      alert.style.display = "block";
      alert.textContent = "Correct! The category is " + category.category;

      break;
    }
  }

  /* add the guess to the array of guesses */
  const guesses = JSON.parse(window.localStorage.getItem("guesses"));
  guesses.push({ guess: [...selectedCells], matchCount });
  window.localStorage.setItem("guesses", JSON.stringify(guesses));

  /* reset the selectedCells */
  if (matchCount === 4) selectedCells = [];
  window.localStorage.setItem("selectedCells", JSON.stringify(selectedCells));

  /* if there are no words left, the game is over */
  if (filteredWords.length === 0) handleWin();

  /* re-render the UI */
  renderGame();
}

/**
 * Perform actions if user wins a game
 */
function handleWin() {
  /* increment the number of wins */
  var wins = JSON.parse(window.localStorage.getItem("wins"));
  window.localStorage.setItem("wins", JSON.stringify(wins + 1));

  /* increment the streak */
  var streak = JSON.parse(window.localStorage.getItem("streak"));
  window.localStorage.setItem("streak", JSON.stringify(streak + 1));

  /* update avg-guesses */
  const games = JSON.parse(window.localStorage.getItem("games"));
  const curGuesses = JSON.parse(window.localStorage.getItem("guesses"));

  // add curGuesses to get totalGuesses
  const totalGuesses =
    JSON.parse(window.localStorage.getItem("total-guesses")) +
    curGuesses.length;

  // set the new total-guesses
  window.localStorage.setItem("total-guesses", JSON.stringify(totalGuesses));

  // calculate and set the new avg-guesses
  const avgGuesses = totalGuesses / games;
  window.localStorage.setItem("avg-guesses", avgGuesses.toFixed(2));

  /* re-render the UI */
  renderGame();
}

/**
 * Display the guess list
 */
function renderGuessesList() {
  const list = document.getElementById("guesses-list");
  list.innerHTML = "";

  const guesses = JSON.parse(window.localStorage.getItem("guesses")) || [];

  if (guesses.length !== 0) {
    guesses.forEach((guessObj) => {
      const { guess, matchCount } = guessObj;

      const guessItem = document.createElement("li");
      guessItem.classList.add("list-group-item");
      guessItem.textContent = guess.join(", ");

      /* add a badge for number of correct words */
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
      guessItem.appendChild(document.createTextNode(" "));
      guessItem.appendChild(badge);

      list.appendChild(guessItem);
    });
  }
}

/**
 * Display the user's stats
 */
function renderStats() {
  const list = document.getElementById("user-stats");
  list.innerHTML = "";

  if (localStorage.length !== 0) {
    const gamesItem = document.createElement("li");
    gamesItem.classList.add("list-group-item");
    gamesItem.textContent =
      "Games Played: " + window.localStorage.getItem("games");
    list.appendChild(gamesItem);

    const winsItem = document.createElement("li");
    winsItem.classList.add("list-group-item");
    winsItem.textContent = "Games Won: " + window.localStorage.getItem("wins");
    list.appendChild(winsItem);

    const streakItem = document.createElement("li");
    streakItem.classList.add("list-group-item");
    streakItem.textContent =
      "Current Streak: " + window.localStorage.getItem("streak");
    list.appendChild(streakItem);

    const avgGuessesItem = document.createElement("li");
    avgGuessesItem.classList.add("list-group-item");
    avgGuessesItem.textContent =
      "Average Guesses per Win: " + window.localStorage.getItem("avg-guesses");
    list.appendChild(avgGuessesItem);
  }
}

/**
 * Shuffle an array
 */
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

/**
 * Shuffle the board
 */
function shuffleBoard() {
  const words = JSON.parse(window.localStorage.getItem("words"));
  const shuffledWords = shuffleArray(words);
  window.localStorage.setItem("words", JSON.stringify(shuffledWords));

  /* reset selectedCells */
  window.localStorage.setItem("selectedCells", JSON.stringify([]));

  /* re-render the UI */
  renderGrid();
}
