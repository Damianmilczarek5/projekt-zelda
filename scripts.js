// JavaScript to fetch and display games data

function createGameElement(game) {
    const gameElement = document.createElement("div");
    gameElement.classList.add("game");

    const gameImage = document.createElement("img");
    gameImage.src = game.image;
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

    return gameElement;
}

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
