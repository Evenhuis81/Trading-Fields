<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Advert;


use Illuminate\Database\QueryException;



/**
 * @group proberen
 */
class NewVsCreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAdvertCreate()
    {
        
        echo PHP_EOL; //ff op een nieuwe regel
        echo "Eerst: \$advert = Advert::create()".PHP_EOL;

        $this->expectException(QueryException::class);
        try {
            $advert = Advert::create();
        }
        catch (QueryException $caught) {
            $query = $caught->getSql();
            $bindings = $caught->getBindings();

            echo PHP_EOL; 
            echo "Dit is de query die Advert::create() doet naar de database:".PHP_EOL;
            echo "''{$query}''" . PHP_EOL;
            echo "De (veilige) manier om iets naar een database te sturen is, niet alles in een enkele query.".PHP_EOL;
            echo "Eerst stuur je een query met plekken waar de waardes ingevoegd dienen te worden." . PHP_EOL;
            echo "Vandaar ook die ''(?, ?)''." .PHP_EOL;
            echo "Daarna stuur je de waarden:" . PHP_EOL;
            print_r($bindings);
            echo "Dat doet laravel dus ook zo.".PHP_EOL;       

            
            
            echo "Maar er gaat iets fout want de database accepteert het niet." . PHP_EOL;
            echo "Er is een QueryException 'gegooid'," . PHP_EOL;
            echo PHP_EOL; 
            echo "Je krijgt de boodschap van laravel, die overgenomen is van de database server:".PHP_EOL;
            echo "=====>>>".PHP_EOL;
            echo $caught->getMessage();
            echo PHP_EOL; 
            echo "<<<=====".PHP_EOL;



            /**
             *  Opgevangen, en nu doorgooien zodat de unittest ook slaagt.
             * Als er iets anders fout gegaan is en dus een andere Exception is gegooid
             * dan wordt die hier niet opgevangen en zal ook de unit test klagen dat er
             * iets anders is gegooid dan verwacht .
             */
            throw($caught);
        }
        $this->checkExceptionExpectations();
    }
    public function testNewAdvert()
    {
        echo PHP_EOL; 
        echo "Andere manier:  \$advert = new Advert() ".PHP_EOL;
        $advert = new Advert();
        $this->assertInstanceOf(Advert::class, $advert);
        echo "Geen probleem. Er is slechts een instantie van Advert aangemaakt in php.".PHP_EOL;
        echo "Maar die staat dus pas in de database als je Advert->save() aanroept.".PHP_EOL;

        echo "Als je dat doet, dan zul je dezelfde error krijgen.".PHP_EOL;
        echo "Dit maal doe ik geen try/catch. Ik laat phpunit dit opvangen met expectException, en na afloop checkExceptionExpectations.".PHP_EOL;
        echo "De test slaagt dus alleen als die exception gegooid wordt." .PHP_EOL;

        $this->expectException(QueryException::class);
        $advert->save();
        $this->checkExceptionExpectations();
    }
    public function testAfsluiten()
    {
        echo PHP_EOL;
        echo <<<'EOD'
En nu ff in nowdoc
    want ik ben kotsflauw van dat ge-echo en heredoc is wel handig maar dan moet ik nogsteeds $ enzo escapen
    Maar het komt dus omdat in jouw migration staat
        $table->string('title');
    
    Als je het verandert naar
        $table->string('title')->nullable();
    
    Dan zal deze test alnog slagen, alleen zal hetzelfde gebeuren met 
        'description' in plaats van 'title'. (Vergeet niet je migration weer terug te veranderen.)
            
EOD;
        
        $this->assertTrue(true);
    }
}
