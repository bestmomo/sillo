<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

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
