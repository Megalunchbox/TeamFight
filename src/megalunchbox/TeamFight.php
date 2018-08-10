<?php
/**
 * Created by PhpStorm.
 * User: megal
 * Date: 8/4/2018
 * Time: 6:29 PM
 */

namespace megalunchbox;


class TeamFight {

    private $redTeam;
    private $blueTeam;

    public function __construct(array $redTeam, array $blueTeam) {
        $this->redTeam = $redTeam;
        $this->blueTeam = $blueTeam;
    }


}