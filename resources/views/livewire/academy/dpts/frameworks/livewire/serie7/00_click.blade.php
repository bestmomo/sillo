<script>
    // Déclenchement automatique d'un onglet
    window.onload = function() {
        setTimeout(function() {
            console.log('Argument reçu :', btnToClick);
            // Choix du bouton cliqué par défaut
            let btn = btnToClick;
            if (!btn) {
                console.log('Pas de bouton cliqué par défaut')
            } else {

                console.log('JS clique sur ' + btn);
                const btnTabs = document.querySelector('button[id=' + btn + ']');
                if (btnTabs) {
                    btnTabs.click();
                } else {
                    console.log("Le bouton '" + btn + "' n'a pas été trouvé.");
                }
            }
        }, 700); // Attend .007 seconde avant d'exécuter le script
    };
</script>
