document.addEventListener("alpine:init", () => {
  Alpine.data("characters", () => ({
    loading: false,
    characters: [],
    episodes: [],
    loaded: false,
    error: null,
    
    isOpen: true,
    currentCharacter: {},

    fsTitle: "",

    init() {
      this.loadCharacters();
    },

    async loadCharacters() {
      if (this.loaded) return;
      this.loading = true;
      try {
        const response = await fetch(
          "https://rickandmortyapi.com/api/character"
        );

        if (!response.ok) {
          throw new Error("Erreur réseau");
        }

        const data = await response.json();

        setTimeout(async () => {
          this.characters = data.results;

          if (this.characters.length > 0) {
            try {
              this.episodes = await this.getFirstSeenEpisodes(this.characters);
              // console.log("Épisodes", JSON.stringify(this.episodes, null, 2)); // Affichage lisible des épisodes
            } catch (error) {
              this.error =
                "Impossible de charger les épisodes : " + error.message;
            }
          }
          this.currentCharacter = this.characters[0]; // Juste pour mise au point du aside open par défaut
          this.loading = false;
          this.loaded = true;
        }, 1000);
      } catch (error) {
        this.error = "Impossible de charger les personnages : " + error.message;
        this.loading = false;
      }
    },

    async getFirstSeenEpisodes(characters) {
      let urls = [];
      characters.forEach((character) => {
        let num_ep1 = character?.episode[0].split("/").pop();
        urls.push(num_ep1);
        character.num_ep1 = num_ep1;
      });
      let urlsUniques = [...new Set(urls)];
      urlsUniques.sort((a, b) => parseInt(a) - parseInt(b));
      // console.table(urlsUniques);
      console.log("urlsUniques", urlsUniques);

      const endPoint = "https://rickandmortyapi.com/api/episode/";

      try {
        const response = await fetch(endPoint + urlsUniques);
        if (!response.ok) {
          throw new Error("Erreur réseau");
        }
        const data = await response.json();

        // Assurez-vous que data est un tableau
        this.episodes = Array.isArray(data) ? data : [data];
        console.log("data", data);

        characters.forEach((character) => {
          character.episode1 = this.episodes.find(
            (ep) => ep.id == character.num_ep1
          );
        });

        return this.episodes;
      } catch (error) {
        this.error =
          "Impossible de charger le premier episode : " + error.message;
        this.loading = false;
        // Attendre que les épisodes soient chargés
        if (!this.episodes || this.episodes.length === 0) {
          await this.loadCharacters();
        }
      }
    },

    getTooltipText(character) {
        return ` Click here to see all informations about ${character.name} `;
    },
    
    handleClick(character) {
      console.log('Click / character', character.name + ' (Id #' + character.id +')');
      this.isOpen = true;
      this.currentCharacter = character;
    },
  }));
});
