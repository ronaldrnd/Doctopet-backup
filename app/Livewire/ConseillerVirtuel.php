<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Animal;

class ConseillerVirtuel extends Component
{
    public $question = '';
    public $messages = []; // Stockage des messages dans la discussion
    public $animals = [];
    public $selectedAnimalId = null;
    public $typing = false; // Animation "Doctopet AI is typing..."

    protected $listeners = ['submitQuestion']; // Listener pour l'envoi de la question

    public function mount()
    {
        // Charger les animaux de l'utilisateur connecté
        if (Auth::check()) {
            $this->animals = Auth::user()->animaux;
        }

        // Initialiser le tableau des messages comme un tableau vide
        $this->messages = [];
    }

    #[On('submitQuestion')]
    public function submitQuestion($question)
    {


        // Ajouter la question de l'utilisateur dans la discussion
        $this->question = $question;
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->question,
        ];


        // Déclencher l'animation "Doctopet AI is typing..."
        $this->typing = true;

        $this->fetchAIResponse();
    }

    public function fetchAIResponse()
    {

        $animalDetails = '';
        if ($this->selectedAnimalId) {
            $animal = Animal::find($this->selectedAnimalId);
            if ($animal) {
                $animalDetails = "Informations de l'animal : \nNom : {$animal->nom}, \nEspèce : {$animal->espece->nom}, \nRace : {$animal->race->nom}, \nHistorique médical : {$animal->historique_medical}.";
            }

        }

        // Construction du prompt pour l'IA
        $systemPrompt = "Tu es spécialiste dans le conseil sur le doute de problème sur les animaux.
        Les utilisateurs décrivent leurs problèmes potentiels sur leurs animaux, et tu dois donner des conseils précis pour les soigner.
        Répond toujours en français comme un être humain. Analyse bien le besoin de l'être humain derrière et répond directement à sa question en étant le plus utile possible.
        Fais des réponses brèves quand tu en as l'occasion et que la solution et rapide.";
        $prompt = $systemPrompt . "\nUtilisateur demande : {$this->question}\n{$animalDetails}";

        // Requête HTTP vers OpenRouter
        $apiKey = env('OPENROUTER_API_KEY');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $apiKey",
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => "deepseek/deepseek-chat:free",
            'messages' => [
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $prompt],
            ],
            'max_tokens' => 300,
            'temperature' => 0.7,
        ]);


        // Traiter la réponse
        if ($response->successful()) {
            $aiMessage = $response->json()['choices'][0]['message']['content'] ?? 'Je ne peux pas répondre à cette question pour le moment.';
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $aiMessage,
            ];
        } else {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Une erreur est survenue. Veuillez réessayer plus tard.',
            ];
        }

        // Désactiver l'animation
        $this->typing = false;


        // Réinitialiser la question
        $this->question = '';
    }

    public function render()
    {
        return view('livewire.conseiller-virtuel', [
            'animals' => $this->animals,
            'typing' => $this->typing,
        ]);
    }
}
