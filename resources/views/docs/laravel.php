<script type="module" src="http://[::1]:8000/@vite/client" data-navigate-track="reload"></script>
<style>
html,
body {
  margin: 0;
}

.discretDansLeCoinEnHautADroite {
  line-height: .9;
  font-size: 11px;
  .5 color: red;
  text-align: right;
  /* font-style: italic; */
  /* color: white; */
  /* background-color: maroon; */
  margin: 4px 0 0 0;
  padding: 0 10px;
}
</style>
<?php
Barryvdh\Debugbar\Facades\Debugbar::disable();
$fichier_compteur = 'docs/mindmaps/moncms_views.txt';
if (!file_exists($fichier_compteur))
{
	file_put_contents($fichier_compteur, '0');
}
$compteur = (int) file_get_contents($fichier_compteur);
$compteur++;
file_put_contents($fichier_compteur, $compteur);

echo "<div class='discretDansLeCoinEnHautADroite'><b>" . number_format($compteur, 0, ',', ' ') . '</b> <i>ouvertures (Depuis le 21/11/2024)</i></div>';

include_once 'moncms.html';
