async function getAllUsers (resource) {
    let user = ""
    let response = await fetch("/API/users.json")
       resource = await response.json();
  for (let i = 0; i < resource.length; i++) {
     user = resource[i]; 


      }    
  }
  
  async function getFavorites(resourceId) {
    let favoritesGridContainer = document.createElement("div");
    favoritesGridContainer.id = "favorites-grid-container";
  
    let ratedGridContainer = document.createElement("div");
    ratedGridContainer.id = "rated-grid-container";
  
    let users = "http://localhost/API/getUsers.php";
    let response = await fetch(users);
    let resource = await response.json();
  
    let games = "http://localhost/API/getGames.php";
    let responseGames = await fetch(games);
    let resourceGames = await responseGames.json();
  

    let gameMap = new Map();
    for (let game of resourceGames) {
      gameMap.set(game.name, game);
    }
  
    for (let user of resource) {
      if (user.id == resourceId) {

        for (let favorite of user.favoriteGames) {
          let game = gameMap.get(favorite);
          if (game) {

            let gameDiv = document.createElement("div");
            let gameContainer = document.getElementById("game-container");
            gameContainer.appendChild(favoritesGridContainer);
  
            // Add the game's information to the gameDiv element
            const {
              id,
              name,
              release_date,
              description,
              consoles,
              reviews,
              image,
            } = game;
            // Add the game name
            let nameElement = document.createElement("h1");
            nameElement.textContent = name;
            gameDiv.appendChild(nameElement);
  
            // Add the game image
            let imageElement = document.createElement("img");
            imageElement.src = image;
            gameDiv.appendChild(imageElement);
  
            // Add the gameDiv element to the favorites grid
            favoritesGridContainer.appendChild(gameDiv);
          }
        }
  
        // Add games to the rated grid
        for (let rated of user.ratedGames) {
          let game = gameMap.get(rated);
          if (game) {
            // Create the gameDiv element
            let gameDiv = document.createElement("div");
            let gameContainer = document.getElementById("game-container");
            gameContainer.appendChild(ratedGridContainer);
  
            // Add the game's information to the gameDiv element
            const {
              id,
              name,
              release_date,
              description,
              consoles,
              reviews,
              image,
            } = game;
            // Add the game name
            let nameElement = document.createElement("h1");
            nameElement.textContent = name;
            gameDiv.appendChild(nameElement);
  
            // Add the game image
            let imageElement = document.createElement("img");
            imageElement.src = image;
            gameDiv.appendChild(imageElement);
  
            // Add the gameDiv element to the rated grid
            ratedGridContainer.appendChild(gameDiv);
          }
        }
      }
    }
  }

  
  
  
  
  

    getFavorites(1);
  getAllUsers();