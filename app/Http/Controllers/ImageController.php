<?php

/**
 *  (ɔ) LARAVEL.Sillo.org - 2012-2024
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
	public function upload(Request $request)
	{
		if ($request->hasFile('image'))
		{
			$file     = $request->file('image');
			$filename = time() . '_' . $file->getClientOriginalName();

			// Enregistre le fichier dans storage/app/public/images
			$path = $file->storeAs('public/images', $filename);

			// Génère l'URL publique pour l'image
			$url = Storage::url($path);

			return response()->json([
				'success' => true,
				'url'     => $url,
			]);
		}

		return response()->json([
			'success' => false,
			'message' => 'Aucun fichier n\'a été téléchargé.',
		], 400);
	}
}
