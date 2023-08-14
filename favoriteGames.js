async function fetchGameDetails(gameId) {
    const response = await fetch(`test2.php?id=${gameId}`);
    const gameDetails = await response.json();
    return gameDetails;
}

async function fetchFavoriteGames() {
    const response = await fetch("getFavorite.php");
    const favoriteGames = await response.json();
    return favoriteGames;
}

async function removeGameFromFavorites(gameId) {
    try {
        const response = await fetch(`removeFavorite.php?id=${gameId}`, {
            method: "DELETE",
        });

        if (response.ok) {
            // Reload the list of favorite games
            await displayFavoriteGames();
        } else {
            const errorMessage = await response.text();
            console.error("Error removing game from favorites:", errorMessage);

            // Display an error message to the user
            const errorContainer = document.getElementById("error-container");
            errorContainer.textContent = errorMessage;
        }
    } catch (error) {
        console.error("Error removing game from favorites:", error);
    }
}


async function displayFavoriteGames() {
    const favoriteGamesContainer = document.getElementById("favorite-games");

    try {
        const favoriteGames = await fetchFavoriteGames();
        favoriteGamesContainer.innerHTML = ""; // Clear the container

        for (const gameId of favoriteGames) {
            // Fetch game details based on the game ID
            const gameDetails = await fetchGameDetails(gameId);

            // Create a container for each favorited game
            const gameContainer = document.createElement("div");
            gameContainer.classList.add("favorited-game");

            // Display the game image
            const gameImage = document.createElement("img");
            gameImage.src = gameDetails.image;
            gameContainer.appendChild(gameImage);

            // Display the game name
            const gameName = document.createElement("p");
            gameName.textContent = gameDetails.name;
            gameContainer.appendChild(gameName);

            // Create a delete button
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Remove from Favorites";
            deleteButton.addEventListener("click", () => {
                removeGameFromFavorites(gameId);
            });
            gameContainer.appendChild(deleteButton);

            favoriteGamesContainer.appendChild(gameContainer);
        }
    } catch (error) {
        console.error("Error fetching favorite games:", error);
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    await displayFavoriteGames();
});
