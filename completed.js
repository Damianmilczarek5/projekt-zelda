async function fetchGameDetails(gameId) {
  const response = await fetch(`gameDetails.php?id=${gameId}`);
  const gameDetails = await response.json();
  return gameDetails;
}

async function fetchCompletedGames() {
  const response = await fetch("completed.php");
  const completedGames = await response.json();
  return completedGames;
}

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

      // Display an error message to the user
      const errorContainer = document.getElementById("error-container");
      errorContainer.textContent = errorMessage;
    }
  } catch (error) {
    console.error("Error removing game from completed:", error);
  }
}

async function displayCompletedGames() {
  const completedGamesContainer = document.getElementById("collection");

  try {
    const completedGames = await fetchCompletedGames();
    completedGamesContainer.innerHTML = ""; // Clear the container

    for (const gameId of completedGames) {
      // Fetch game details based on the game ID
      const gameDetails = await fetchGameDetails(gameId);

      // Create a container for each completed game
      const gameContainer = document.createElement("div");
      gameContainer.classList.add("completed-game");

      const gameLink = document.createElement("a");
      gameLink.href = `game_details.php?id=${gameDetails.id}`;

      // Display the game image
      const gameImage = document.createElement("img");
      gameImage.src = gameDetails.image; 
      gameLink.appendChild(gameImage);
      // Display the game name
      const gameName = document.createElement("p");
      gameName.textContent = gameDetails.name; 
      gameLink.appendChild(gameName);

      gameContainer.appendChild(gameLink);
      // Create a delete button
      const deleteButton = document.createElement("button");
      deleteButton.textContent = "Remove from Completed";
      deleteButton.addEventListener("click", () => {
        removeGameFromCompleted(gameId);
      });
      gameContainer.appendChild(deleteButton);

      completedGamesContainer.appendChild(gameContainer);
    }
  } catch (error) {
    console.error("Error fetching completed games:", error);
  }
}

document.addEventListener("DOMContentLoaded", async () => {
  await displayCompletedGames();
});
