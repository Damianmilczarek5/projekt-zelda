

async function fetchGames() {
    const response = await fetch("getGames.php");
    const games = await response.json();
    return games;
}



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



function createGameElement(game) {
    const gameElement = document.createElement("div");
    gameElement.classList.add("game");

    const gameImage = document.createElement("img");
    gameImage.src = game.image;
    gameImage.alt = game.name;
    gameElement.appendChild(gameImage);

    const gameName = document.createElement("p");
    gameName.textContent = game.name;
    gameElement.appendChild(gameName);

    const gameRating = document.createElement("div");
    gameRating.classList.add("rating");
    for (let i = 1; i <= 5; i++) {
        const star = document.createElement("span");
        if (i <= game.rating) {
            star.textContent = "★";
        } else {
            star.textContent = "☆";
        }
        gameRating.appendChild(star);
    }
    gameElement.appendChild(gameRating);

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

async function addGameToCompleted(gameId) {
    try {
        const response = await fetch(`addCompletedGame.php?id=${gameId}`, { method: "PUT" });
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
                alert("Game added to completed games!");
            } catch (error) {
                console.error("Error adding game to completed games:", error);
            }
        });
    });

    async function addGameToFavorite(gameId) {
        try {
            const response = await fetch(`addFavoriteGame.php?id=${gameId}`, { method: "PUT" });
            const result = await response.text();
            console.log("Response from server:", result); // Log the response for debugging
            return result;
        } catch (error) {
            throw error;
        }
    }
    
    
    
    
        // Add event listener to "Add to Completed Games" button
        const addFavoriteGameButtons = document.querySelectorAll("#addFavoriteGame");
        addFavoriteGameButtons.forEach((button) => {
            button.addEventListener("click", async (event) => {
                const gameId = event.target.getAttribute("data-game-id");
                try {
                    await addGameToFavorite(gameId);
                    alert("Game added to favorite games!");
                } catch (error) {
                    console.error("Error adding game to favorite games:", error);
                }
            });
        });


