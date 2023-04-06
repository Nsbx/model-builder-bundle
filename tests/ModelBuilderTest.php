<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests;

use Nsbx\Bundle\ModelBuilder\Tests\Model\GameModel;
use PHPUnit\Framework\TestCase;

class ModelBuilderTest extends TestCase
{
    public function testBuildGameModel01(): void
    {
        $gameModelResponse = file_get_contents(__DIR__ . '/fixtures/GameModelResponses/01.json');

        $gameModel = new GameModel(json_decode($gameModelResponse));

        $this->assertEquals(4987, $gameModel->getId());
        $this->assertEquals('Game Title', $gameModel->getName());
        $this->assertEquals('https://game.test/', $gameModel->getUrl());
        $this->assertCount(2, $gameModel->getCategories());
        $this->assertCount(3, $gameModel->getImages());
        $this->assertEquals(19.99, $gameModel->getPrice()->getPrice());
        $this->assertEquals('$', $gameModel->getPrice()->getCurrency());
    }

    public function testBuildGameModel02(): void
    {
        $gameModelResponse = file_get_contents(__DIR__ . '/fixtures/GameModelResponses/02.json');

        $gameModel = new GameModel(json_decode($gameModelResponse));

        $this->assertEquals(5897, $gameModel->getId());
        $this->assertEquals('Game Title', $gameModel->getName());
        $this->assertEquals('https://game.test/', $gameModel->getUrl());
        $this->assertCount(3, $gameModel->getCategories());
        $this->assertCount(3, $gameModel->getImages());
        $this->assertEquals(5.99, $gameModel->getPrice()->getPrice());
        $this->assertEquals('€', $gameModel->getPrice()->getCurrency());
    }
}
