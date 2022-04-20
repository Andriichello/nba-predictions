<?php

namespace App\Http\Controllers;

use App\Http\Requests\PredictScoreRequest;

class PredictionsController extends Controller
{
    /**
     * Predict the score of the game between two NBA teams.
     *
     * @param PredictScoreRequest $request
     *
     * @return array
     */
    public function predictScore(PredictScoreRequest $request) : array
    {
        $args = [
            $request->homeTeam()->team_id,
            $request->awayTeam()->team_id,
            (int) $request->homeWins(),
            $request->get('away_score')
        ];

        $result = shell_exec(resource_path('/py/predict-score.py') . ' ' . implode(' ', $args));

        return array_merge(
            [
                'home' => $request->homeTeam(),
                'away' => $request->awayTeam(),
                'wins' => $request->get('wins'),
                'away_score' => (int) $request->get('away_score'),
            ],
            json_decode($result, true)
        );
    }
}
