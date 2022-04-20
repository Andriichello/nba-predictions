<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;

class PredictScoreRequest extends FormRequest
{
    protected ?Team $homeTeam;

    protected ?Team $awayTeam;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'home' => [
                'required',
                function ($attribute, $value, $fail) {
                    $team = $this->homeTeam();
                    if (empty($team)) {
                        $fail("The $attribute team identifier is invalid.");
                    }
                }
            ],
            'away' => [
                'required',
                'different:home',
                function ($attribute, $value, $fail) {
                    $team = $this->awayTeam();
                    if (empty($team)) {
                        $fail("The $attribute team identifier is invalid.");
                    }
                }
            ],
            'wins' => [
                'string',
                'in:home,away',
            ],
            'away_score' => [
                'required',
                'integer',
            ]
        ];
    }

    protected function team(mixed $identifier): ?Team
    {
        /** @var Team $team */
        $team = Team::query()
            ->where('team_id', $identifier)
            ->orwhere('abbreviation', $identifier)
            ->orWhere('nickname', $identifier)
            ->first();

        return $team;
    }

    public function homeTeam(): ?Team
    {
        if (isset($this->homeTeam)) {
            return $this->homeTeam;
        }

        return $this->homeTeam = $this->team($this->get('home'));
    }

    public function awayTeam(): ?Team
    {
        if (isset($this->awayTeam)) {
            return $this->awayTeam;
        }

        return $this->awayTeam = $this->team($this->get('away'));
    }

    public function homeWins(): bool
    {
        return $this->get('wins') === 'home';
    }
}
