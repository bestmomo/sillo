<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

// Définition du composant avec les attributs de titre et de mise en page
new 
#[Title('Chat')] 
#[Layout('components.layouts.app')] 
class extends Component {
    use Toast;

    #[Rule('required|max:1000')]
    public string $question = '';

    public string $answer = '';

    public function getAnswer()
    {
        // Validation des données du formulaire
        $data = $this->validate();

        // Récupération de la clé API depuis l'environnement
        $token = env('GPT_API_KEY');

        // Récupération du modèle GPT depuis l'environnement
        $gptModel = env('GPT_MODEL', 'gpt-3.5-turbo'); // Utilisation par défaut si la clé n'est pas définie

        // Définition du prompt
        $prompt = __("You're an expert in the Laravel framework, renowned for your ability to explain every concept clearly and patiently. Your aim is to provide detailed and understandable explanations, adapted to all skill levels.");

        // Création du message à envoyer
        $messageContent = $prompt . "\nThe question is: " . $data['question'];

        // Préparation de la requête
        $payload = [
            'model' => $gptModel,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $messageContent,
                ],
            ],
        ];

        // Envoi de la requête à l'API OpenAI
        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', $payload);

            // Vérification du statut de la réponse
            if ($response->successful()) {
                // Décodage de la réponse et récupération du contenu
                $answer = json_decode($response->body())->choices[0]->message->content;

                // Affectez la réponse formatée à la variable Livewire
                $this->answer = $answer;
            } else {
                // Gestion des erreurs
                throw new \Exception(__('Error in API response: ') . $response->body());
            }
        } catch (\Exception $e) {
            $erreur_obj = json_decode($response->body());
            $error_code = $erreur_obj->error->code;
            \Log::error('Failed to get answer from OpenAI: ' . $e);
            $this->answer = __('An error occurred while trying to retrieve the answer') . ' (' . __($error_code) . ')' . "\n";
        }
    }
}; ?>

<div>
    <!-- Formulaire de contact encapsulé dans une carte -->
    <x-card title="{{ __('You have a question about Laravel?') }}" subtitle="{{ __('Use this form to ask me!') }}" shadow
        separator progress-indicator>
        <x-form wire:submit="getAnswer">
            <!-- Champ de message -->
            <x-textarea wire:model="question" rows="5" placeholder="{{ __('Your question here...') }}" inline />
            <!-- Boutons d'actions -->
            <x-slot:actions>
                <x-button label="{{ __('Send') }}" type="submit" icon="o-paper-airplane" class="btn-primary"
                    spinner="login" />
            </x-slot:actions>
        </x-form>
        <br>
        <!-- Réponse -->
        <div class="container mx-auto">
            <div class="prose sm:mx-8 lg:mx-16">
                {!! nl2br(e($answer)) !!}
            </div>
        </div>
    </x-card>
</div>
