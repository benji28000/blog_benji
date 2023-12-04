<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\Slugger;

class TestSluggerTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }


    public function testSlugifyBasic(): void
    {
        $text = "Hello World!";
        $slugger = new Slugger();
        $this->assertEquals("hello-world", $slugger->slugify($text));
    }

    public function testSlugifyWithSpecialCharacters(): void
    {
        $text = "This is a test with special characters: !@#$%^&*()";
        $slugger = new Slugger();
        $this->assertEquals("this-is-a-test-with-special-characters", $slugger->slugify($text));
    }

    public function testSlugifyWithAccentedLetters(): void
    {
        $text = "C'est l'été!";
        $slugger = new Slugger();
        $this->assertEquals("c-est-l-ete", $slugger->slugify($text));
    }

    public function testSlugifyWithTrimmedSpaces(): void
    {
        $text = "   Trimmed Spaces   ";
        $slugger = new Slugger();
        $this->assertEquals("trimmed-spaces", $slugger->slugify($text));
    }

    public function testSlugifyWithUppercaseLetters(): void
    {
        $text = "Uppercase Letters";
        $slugger = new Slugger();
        $this->assertEquals("uppercase-letters", $slugger->slugify($text));
    }

    public function testSlugifyWithHyphenatedWords(): void
    {
        $text = "word-with-hyphens";
        $slugger = new Slugger();
        $this->assertEquals("word-with-hyphens", $slugger->slugify($text));
    }

    public function testSlugifyWithEmptyString(): void
    {
        $text = "";
        $slugger = new Slugger();
        $this->assertEquals("n-a", $slugger->slugify($text));
    }

    public function testSlugifyCustomFont(): void{
        $text = "𝕤𝕒𝕝𝕦𝕥 𝕥'𝕖𝕤 𝕞𝕠𝕔𝕙𝕖";
        $slugger = new Slugger();
        $this->assertEquals("salut-t-es-moche", $slugger->slugify($text));
    }




}


