<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new
#[Layout('components.layouts.acaLight')]
class
 extends Component {
    //2do ranger dans MM: git reset --soft HEAD~1
// → Annule le dernier commit en gardant les changements
}; ?>

<div class='text-lg'>
    <livewire:academy.components.dpt-title title="Academie" />

    <x-header shadow separator progress-indicator />

    <p class='text-justify font-bold text-xl'>L'académie est un espace d'Études, de Travaux Pratiques et de Test.</p><br>

    <p>Bien-sûr, <i>toute cette partie est davantage appréciable après un ' clone ' *** du projet en local</i>...</p><br>

    <p class='text-justify'>
        Conseil: Quelque soient vos développements, n'y utilisez pas les tables de base du projet Laravel. Préférez
        utiliser celles commençant par '<b>academy_</b>' ou créez les vôtres selon un même début de nom séparatif.<br>
        En effet, si plus tard, vous <i>' push ' *</i> votre code au <a class='link' href="https://github.com/bestmomo/sillo"
            target='_blank'>projet officiel</a> <x-ext-link />, de vrais utilisateurs auront accès à ces données...</p><br>

    <p>Pour l'heure, voici les 2 départements (dpts/) ouverts :</p><br>

    <ul class="ml-3 list-disc list-inside">
        <p class='font-bold'>I / Étude de <a class='link' href="{{ route('academy.frameworks') }}"
                title="Explorez-les !">FrameWorks</a> :</p>
        <li><a class='link' href="https://livewire.laravel.com/docs/quickstart" title="Doc. officielle LiveWire"
                target="_blank">LiveWire</a><x-ext-link /></li>
        <li><a class='link' href="https://alpinejs.dev/start-here" title="Doc. officielle AlpineJS"
                target="_blank">AlpineJS</a><x-ext-link /></li>
    </ul>
    <p>→ Jouez ad'libitum avec ces parties !</p>
    <br>
    <ul class="ml-3 list-disc list-inside">
        <p class='font-bold'>II / Études (<a class='link' href="{{ route('academy.cases') }}"
                title="Découvrez-les !">Études de Cas - Travaux Pratiques</a>) :</p>
        <li><a class='link' href="{{ route('academy.case.table-filter.trouble') }}"
                title="Découvrez-en les détails">Cas 1: Problème //** sélection & tri et affichage d'une liste</a></li>
        <li>Cas 2: À venir...</li>
        <li>Cas 3: Un cas résolu (Juste pour l'exemple pour le moment...)</li>
    </ul>
    <p>→ Étudiez les cas déjà réalisés, et tâchez d'y apporter votre solution !</p>
    <br>
    <p class="text-justify">Accessoirement, il existe un fichier de code pour <a class='link'
            href="{{ route('academy.tests.in-progress') }}" title="Pour faire 'mu-muse'... ;-) !">faire un test rapide</a>, ponctuel et
        provisoire (URL : <b>/t</b>) (Afin de simplifier et d'isoler une problématique...)</p>
    <br>
    <hr><br>
    <div class="text-justify">
        Rappels :<br>
        - Si vous souhaitez coder, mais aussi partager vos devs, vous devez :
        <ul class="ml-3 list-disc list-inside">
            <li class="text-justify">Avoir <i>' clone ' ***</i>, et ainsi, pouvoir utiliser tout le projet dans sa toute
                derniere version en local, y apporter toutes les modications qu'il vous plait.</li>
            <li class="text-justify">Et si vous estimez que cela est vraiment digne d'être apporté au projet original,
                faites un <i>' P.R. ' ****</i> !</li>
        </ul>
        <p class="text-justify">- Dans tous les cas, référez-vous aux <a class='link'
                href = 'https://github.com/bestmomo/sillo' target='_blank'>consignes de contribution du projet
                <b>Sillo</b></a> <x-ext-link />.</p>
    </div>
    <br>
    <hr><br>
    <p>//2do Outils préconisés</p>
    <br>
    <hr>
    <table class='my-2 mx-0'>
        <tr class='m-0'>
            <td class='w-1/4 text-right'>*</td>
            <td class='w-1/7 mx-3 px-3'>:</td>
            <td><a class='link'
                    href = 'https://docs.github.com/fr/get-started/learning-about-github/github-glossary#push'
                    target='_blank'><b>Push</b></a> <x-ext-link /></td>
        </tr>
        <tr class='my-0'>
            <td class='w-1/4 text-right'>**</td>
            <td class='w-1/7 mx-3 px-3'>:</td>
            <td>// = 'Par rapport à'</td>
        </tr>
        <tr class='m-0'>
            <td class='w-1/4 text-right'>***</td>
            <td class='w-1/7 mx-3 px-3'>:</td>
            <td><a class='link'
                    href = 'https://docs.github.com/fr/get-started/learning-about-github/github-glossary#clone'
                    target='_blank'><b>Clone</b></a> <x-ext-link />
            </td>
        </tr>
        <tr class='m-0'>
            <td class='w-1/4 text-right'>****</td>
            <td class='w-1/7 mx-3 px-3'>:</td>
            <td><a class='link'
                    href = 'https://docs.github.com/fr/pull-requests/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/about-pull-requests'
                    target='_blank'><b>P.R.</b></a> <x-ext-link />
            </td>
        </tr>
    </table>

    <p class='text-right mr-12'>( ͡° ͜ʖ ͡°)</p>
</div>
