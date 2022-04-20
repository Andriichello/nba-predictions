<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Team.
 *
 * @property int $team_id
 * @property int $league_id
 * @property string $city
 * @property string $arena
 * @property string $nickname
 * @property string $abbreviation
 */
class Team extends Model
{
    protected $primaryKey = 'team_id';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'league_id',
        'city',
        'arena',
        'nickname',
        'abbreviation',
    ];
}
