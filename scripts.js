// Fetches the list of games from the server
async function fetchGames() {
  const response = await fetch("getGames.php");
  const games = await response.json();
  return games;
}

// When the page is fully loaded
document.addEventListener("DOMContentLoaded", async () => {
  const gameListContainer = document.getElementById("gameList");

  try {
    const games = await fetchGames();
    games.forEach((game) => {
      const gameElement = createGameElement(game);
      gameListContainer.appendChild(gameElement);
    });
  } catch (error) {
    console.error("Error fetching games:", error);
  }
});

// Creates an element to display game information
function createGameElement(game) {
  const gameElement = document.createElement("div");
  gameElement.classList.add("game");

      // Create and set the game image
  const gameImage = document.createElement("img");
  gameImage.src = game.image;
  gameImage.alt = game.name;
  gameElement.appendChild(gameImage);

      // Create and set the game name
  const gameName = document.createElement("p");
  gameName.textContent = game.name;
  gameElement.appendChild(gameName);

  // Create a link to the game details page with the game ID as a query parameter
  const gameLink = document.createElement("a");
  gameLink.href = "game_details.php?id=" + game.id; // Add game ID as query parameter
  gameLink.appendChild(gameElement);

  return gameLink;
}

async function fetchGames() {
  const response = await fetch("getGames.php");
  const games = await response.json();
  return games;
}

// Code for adding games to completed and favorite lists
async function addGameToCompleted(gameId) {
  try {
    const response = await fetch(`addCompletedGame.php?id=${gameId}`, {
      method: "PUT",
    });
    const result = await response.text();
    console.log("Response from server:", result); // Log the response for debugging
    return result;
  } catch (error) {
    throw error;
  }
}

// Add event listener to "Add to Completed Games" button
const addCompletedGameButtons = document.querySelectorAll("#addCompletedGame");
addCompletedGameButtons.forEach((button) => {
  button.addEventListener("click", async (event) => {
    const gameId = event.target.getAttribute("data-game-id");
    try {
      await addGameToCompleted(gameId);
      button.textContent = "Game added to completed!";
    } catch (error) {
      console.error("Error adding game to completed games:", error);
    }
  });
});

async function addGameToFavorite(gameId) {
  try {
    const response = await fetch(`addFavoriteGame.php?id=${gameId}`, {
      method: "PUT",
    });
    const result = await response.text();
    console.log("Response from server:", result); // Log the response for debugging
    return result;
  } catch (error) {
    throw error;
  }
}

const addFavoriteGameButtons = document.querySelectorAll("#addFavoriteGame");
addFavoriteGameButtons.forEach((button) => {
  button.addEventListener("click", async (event) => {
    const gameId = event.target.getAttribute("data-game-id");
    try {
      const message = await addGameToFavorite(gameId);
      button.textContent = "Game added to favorites!";
      if (message === "Maximum number of favorite games reached (3).") {
        // Display a message in the button if the user can't add more favorites
        button.textContent = "Max 3 favorite games reached!";
        button.disabled = true; // Disable the button
      }
    } catch (error) {
      console.error("Error adding game to favorite games:", error);
    }
  });
});


async function removeGameFromCompleted(gameId) {
  try {
    const response = await fetch(`removeCompleted.php?id=${gameId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      // Reload the list of completed games
      await displayCompletedGames();
    } else {
      const errorMessage = await response.text();
      console.error("Error removing game from completed:", errorMessage);
    }
  } catch (error) {
    console.error("Error removing game from completed:", error);
  }
}

async function removeGameFromFavorite(gameId) {
  try {
    const response = await fetch(`removeFavorite.php?id=${gameId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      // Reload the list of favorite games
      await displayFavoriteGames();
    } else {
      const errorMessage = await response.text();
      console.error("Error removing game from favorite:", errorMessage);
    }
  } catch (error) {
    console.error("Error removing game from favorite:", error);
  }
}

// Add event listener to "Remove from Completed" buttons
const removeCompletedGameButtons =
  document.querySelectorAll("#removeCompleted");
removeCompletedGameButtons.forEach((button) => {
  button.addEventListener("click", async (event) => {
    const gameId = event.target.getAttribute("data-game-id");
    try {
      await removeGameFromCompleted(gameId);
      button.textContent = "Deleted from completed";
    } catch (error) {
      console.error("Error removing game from completed:", error);
    }
  });
});

// Add event listener to "Remove from Favorite Games" buttons
const removeFavoriteGameButtons = document.querySelectorAll(
  "#removeFavoriteGame"
);
removeFavoriteGameButtons.forEach((button) => {
  button.addEventListener("click", async (event) => {
    const gameId = event.target.getAttribute("data-game-id");
    try {
      await removeGameFromFavorite(gameId);
      button.textContent = "Deleted from favorite";
    } catch (error) {
      console.error("Error removing game from favorite:", error);
    }
  });
});
