<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Académie')]
#[Layout('components.layouts.acaLight')]
class extends Component
{
}; ?>

<div>
    <x-header class="text-green-400 font-shadow" title="L'ACADEMIE" shadow separator progress-indicator />
    
        <p>L'Académie est un espace d'Études et de Travaux Pratiques.</p><br>
        
        <p>Pour l'heure :</p><br>
        
        <ul class="ml-3 list-disc list-inside">
            <p class='font-bold'>I / Étude de FrameWorks :</p>//2do link
            <li>LiveWire</li>
            <li>AlpineJS</li>
        </ul>
        <br>
        <ul class="ml-3 list-disc list-inside">
            <p class='font-bold'>II / T.P. (Travaux Pratiques - Études de cas) :</p>//2do link
            <li>Cas 1: Problème // sélection & tri et affichage d'une liste*</li>
            <li>Cas 2: À venir...</li>
        </ul>
        
        <br><hr><br>
        Rappels :
        - Si vous souhaitez coder, mais aussi partager vos devs, vous devez :
            <ul class="ml-3 list-disc list-inside">
                <li>Avoir 'cloné', et ainsi, pouvoir utiliser tout le projet dans sa toute derniere version en local, y apporter toutes les modications qu'il vous plait.</li>
                <li>Et si vous estimez que cela est vraiment digne d'être apporté au projet original, faire un <i>P.R.</i>**</li>
            </ul>            <p>Dans tous les cas, référez-vous aux <u><a href = 'https://github.com/bestmomo/sillo' target='_blank'>consignes de contribution du projet <b>Sillo</b></a></u>.
                
            </p>
        <br><hr><br>
        <p>//2do Outils préconisés</p>
        <br>
        <hr>
        <br>
        *  : // = 'Par rapport à'<br>
        ** : <b>P</b>ull <b>R</b>equest
</div>
