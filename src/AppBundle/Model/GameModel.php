<?php
/**
 * Created by PhpStorm.
 * User: ami
 * Date: 10/29/15
 * Time: 12:30 PM
 */

namespace AppBundle\Model;


use AppBundle\Tic\Game;
use Symfony\Component\HttpFoundation\Session\Session;

class GameModel
{
    /** @var  Session */
    private $session;

    /** @var  Game */
    private $game;

    /**
     * GameModel constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->loadGame();
        $this->storeGame();
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame($game)
    {
        $this->game = $game;
        $this->storeGame();
    }

    public function loadGame($name='game')
    {
        $json = $this->session->get($name, $this->emptyGameJson());
        $game = new Game();
        $game->unserialize($json);
        $this->game = $game;
        return $this->game;
    }

    public function storeGame($name='game')
    {
        $this->session->set($name, $this->game->serialize());
    }

    private function emptyGameJson()
    {
        $game = new Game();
        $game->start();
        return $game->serialize();
    }

    public function startGame()
    {
        $this->game->start();
        $this->storeGame();
    }
}