<?php declare(strict_types=1);

namespace App\test\Unit;

use Twig\Environment;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FirstTest extends KernelTestCase
{
    private Environment $twig;

    /**
     * @test
     */
    public function first(): void
    {
        self::assertTrue('Never trust a test you didn\'t see failing');
    }

    /**
     * @test
     */
    public function twigRender(): void
    {
        $expected = '<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
<table>
    <tr>
        <td>
            <h1>Game Type</h1>
                            <ul>
                                            <input type="radio" id="301" name="games"
                               value="301"  checked="checked">
                        <label for="huey">301</label><br>
                                            <input type="radio" id="501" name="games"
                               value="501" >
                        <label for="huey">501</label><br>
                                    </ul>
                    </td>
        <td>
            <h1>Players</h1>
                            <ul>
                                            <input type="checkbox" id="John Doe" name="John Doe"
                               value="John Doe">
                        <label for="John Doe"> John Doe</label><br>
                                            <input type="checkbox" id="Same Name" name="Same Name"
                               value="Same Name">
                        <label for="Same Name"> Same Name</label><br>
                                            <input type="checkbox" id="Max Mustermann" name="Max Mustermann"
                               value="Max Mustermann">
                        <label for="Max Mustermann"> Max Mustermann</label><br>
                                            <input type="checkbox" id="Tudor Eu" name="Tudor Eu"
                               value="Tudor Eu">
                        <label for="Tudor Eu"> Tudor Eu</label><br>
                                            <input type="checkbox" id="Erika Mustermann" name="Erika Mustermann"
                               value="Erika Mustermann">
                        <label for="Erika Mustermann"> Erika Mustermann</label><br>
                                    </ul>
                    </td>
        <td>
            <h1>Game-End-Option</h1>
                            <ul>
                                            <input type="radio" id="Single-Out" name="gameEnds"
                               value="Single-Out"  checked="checked">
                        <label for="huey">Single-Out</label><br>
                                            <input type="radio" id="Double-Out" name="gameEnds"
                               value="Double-Out" >
                        <label for="huey">Double-Out</label><br>
                                    </ul>
                    </td>
    </tr>
    <tr>
        <td>
            <button type="button" , id="new_game">Start new game</button>
        </td>
        <td>
            <button type="button" , id="new_player">Add player to database</button>
        </td>
    </tr>
</table>
</body>
</html>';


        $players = [
            ['name' => 'John Doe'],
            ['name' => 'Same Name'],
            ['name' => 'Max Mustermann'],
            ['name' => 'Tudor Eu'],
            ['name' => 'Erika Mustermann'],
        ];

        $gameTypes = [
            ['type' => '301', 'checked' => true],
            ['type' => '501', 'checked' => false]
        ];

        $gameEnds = [
            ['type' => 'Single-Out', 'checked' => true],
            ['type' => 'Double-Out', 'checked' => false]
        ];

        $actual = $this->twig->render('darty/startPage.html.twig', [
            'players' => $players,
            'games' => $gameTypes,
            'gameEnds' => $gameEnds,
        ]);

        self::assertEquals($expected, $actual);
    }

}
