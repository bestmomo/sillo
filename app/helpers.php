<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2025
 */

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Config;

if (!function_exists('passwordStrength'))
{
	function passwordStrength($password)
	{
		// Initialiser le score de sécurité
		$score = 0;

		// Vérifier la longueur du mot de passe
		if (strlen($password) >= 8)
		{
			++$score;
		}

		// Vérifier la présence de lettres majuscules
		if (preg_match('/[A-Z]/', $password))
		{
			++$score;
		}

		// Vérifier la présence de lettres minuscules
		if (preg_match('/[a-z]/', $password))
		{
			++$score;
		}

		// Vérifier la présence de chiffres
		if (preg_match('/[0-9]/', $password))
		{
			++$score;
		}

		// Vérifier la présence de caractères spéciaux
		if (preg_match('/\W/', $password))
		{
			++$score;
		}

		return $score;
	}
}

// Méthode pour rendre les lien des images relatifs
if (!function_exists('replaceAbsoluteUrlsWithRelative'))
{
	function replaceAbsoluteUrlsWithRelative(string $content)
	{
		$baseUrl = url('/');

		// Assure que le baseUrl se termine par un slash
		if ('/' !== substr($baseUrl, -1))
		{
			$baseUrl .= '/';
		}

		// Utilise une expression régulière pour remplacer les URLs absolues par des URLs relatives
		$pattern     = '/<img\s+[^>]*src="(?:https?:\/\/)?' . preg_quote(parse_url($baseUrl, PHP_URL_HOST), '/') . '\/([^"]+)"/i';
		$replacement = '<img src="/$1"';

		return preg_replace($pattern, $replacement, $content);
	}
}

// Génère une date aléatoire entre deux dates au format '2020-01-01' en entrée
if (!function_exists('generateRandomDateInRange'))
{
	function generateRandomDateInRange($startDate, $endDate)
	{
		// Convertir les dates en instances de Carbon
		$start = Carbon\Carbon::parse($startDate);
		$end   = Carbon\Carbon::parse($endDate);

		// Calculer la différence en secondes entre les deux dates
		$difference = $end->timestamp - $start->timestamp;

		// Générer un nombre aléatoire de secondes dans cette plage
		$randomSeconds = rand(0, $difference);

		// Ajouter les secondes aléatoires à la date de début pour obtenir la date aléatoire
		return $start->copy()->addSeconds($randomSeconds);
	}
}

if (!function_exists('price_without_vat'))
{
	function price_without_vat(float $price_with_vat, float $vat_rate = .2): float
	{
		return round($price_with_vat / (1 + (float) env('VAT_RATE', $vat_rate)), 2);
	}
}

// Translation Lower case first
if (!function_exists('transL'))
{
	function transL($key, $replace = [], $locale = null)
	{
		$key = trans($key, $replace, $locale);

		return mb_substr(mb_strtolower($key, 'UTF-8'), 0, 1) . mb_substr($key, 1);
	}
}
if (!function_exists('__L'))
{
	function __L($key, $replace = [], $locale = null)
	{
		return transL($key, $replace, $locale);
	}
}

if (!function_exists(function: 'bigR'))
{
	/**
	 * Formatte un grand nombre Réel (BIG_Real) en fonction de la locale.
	 *
	 * Ex. :
	 * - fr    : 12 345,00 €
	 * - de_EUR: $12,345.00
	 * - en_USD: $12,345.00
	 * 
	 * Retourne une chaine de caractères correspondant au nombre $r formaté en fonction de la locale $locale.
	 * Si $locale n'est pas fournie, la locale de l'application est utilisée.
	 * Usage si besoin de préciser le nombre n de décimales : bigR(round(r, n))
	 *
	 * @param float|int   $r      le nombre à formatter
	 * @param null|string $locale La locale à utiliser. Si null, la locale de l'application est utilisée.
	 * @param mixed $dec
	 *
	 * @return string la chaine de caractères correspondant au nombre formaté
	 */
	function bigR(float|int $r, $dec = 2, $locale = null): bool|string
	{
		$locale ??= substr(Config::get('app.locale'), 0, 2);
		$fmt = new NumberFormatter(locale: $locale, style: NumberFormatter::DECIMAL);

		// echo "$locale<hr>";

		return $fmt->format(num: round($r, $dec));
	}
}

if (!function_exists('ftA'))
{
	/**
	 * Formatte un montant (FormaT_Amount) en fonction de la locale de l'application.
	 *
	 * Retourne une chaine de caractères correspondant au montant $amount formaté en fonction de la locale de l'application.
	 * La locale est définie par la constante APP_LOCALE dans le fichier .env.
	 * Si le montant est nul ou vide, une chaine vide est retournée.
	 * Ex.: 123456 → 12 456,00 € pour .env/APP_LOCALE=fr
	 * Ex.: 123456 → $12,456.00 pour .env/APP_LOCALE=en_USD
	 *
	 * ⚠️ L'extension 'Intl' doit être activée (Cas par défaut dans les dernières versions de PHP).
	 *
	 * @param float|int   $amount le montant à formatter
	 * @param null|string $locale
	 *	 * @return string la chaine de caractères correspondant au montant formaté
	 */
	function ftA($amount, $locale = null): bool|string
	{
		// Décommenter 1 seule à la fois pour forcer la conf et voir l'affichage du prix (Listing)
		// $locale = 'en_JPY'; // ¥12,345.68
		// $locale = 'de_EUR'; // 12.345,68 €
		// $locale = 'en_GBP'; // £12,345.68
		// $locale = 'en_USD'; // $12,345.68

		$locale ??= config('app.locale');

		$lang = substr($locale, 0, 2);
		preg_match('/_([^_]*)$/', $locale, $matches);
		$currency  = $matches[1] ?? 'EUR';
		$formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
		$formatted = $formatter->formatCurrency($amount, $currency);
		// À oublier pour l'heure: $formatted = $formatter->formatCurrency($amount, match ($matches[1]) {
		// 	'en'    => 'GBP',
		// 	'us'    => 'USD',
		// 	default => 'EUR'
		// });
		Debugbar::addMessage($formatted, 'helpers');

		return $formatted;
	}
}