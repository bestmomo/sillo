console.log("Je suis le script character.js");

document.addEventListener("alpine:init", () => {
  Alpine.data("characters", () => ({
    loading: false,
    characters: [],
    loaded: false,
    error: null,

    fsTitle: "",

    init() {
      this.loadCharacters().then(() => {
        if (this.characters.length > 0) {
          this.getFirstSeenTitle(this.characters);
        }
      });
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
        this.characters = data.results;
        // await this.getFirstSeenTitle(this.characters)
        this.loading = false;
        this.loaded = true;
      } catch (error) {
        this.error = "Impossible de charger les personnages : " + error.message;
        this.loading = false;
      }
    },

    async getFirstSeenTitle(characters) {
      let table = [];

      let urls = [];
      characters.forEach((character) => {
        urls.push(character?.episode[0].split("/").pop());
      });
      let urlsUniques = [...new Set(urls)];
      urlsUniques.sort((a, b) => parseInt(a) - parseInt(b));
      console.table(urlsUniques);
      console.log(urlsUniques);

      // table.push({ "id": character.id, "name": character.name, 'episode1': character?.episode[0] });
      // console.log("Character: ", character.id + " : " + character.name);
      
      const endPoint = "https://rickandmortyapi.com/api/episode/";

      firstEpisodeUrl = characters[4]?.episode[0];
      console.log("firstEpisodeUrl:", firstEpisodeUrl);

      try {
        const response = await fetch(endPoint + urlsUniques);
        if (!response.ok) {
          throw new Error("Erreur réseau");
        }
        const data = await response.json();
        console.log("data", data);
        this.episode = data;
        console.log("dataResults", this.episode.name);
        this.loading = false;
        this.loaded = true;
      } catch (error) {
        this.error =
          "Impossible de charger le premier episode : " + error.message;
        this.loading = false;
      }

      return 1;
    },
  }));
});
