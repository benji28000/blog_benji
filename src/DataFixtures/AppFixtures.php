<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Avis;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\Types\String_;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $utilisateurs = [];


        for ($i = 0; $i < 5; $i++) {
            $utilisateur = new Utilisateur();

            $utilisateur->setEmail($faker->email());

            $texte = $utilisateur->getEmail();
            $pieces = explode('@', $texte);
            $utilisateur->setNom($pieces[0]);
            $utilisateur->setPassword($faker->password());
            $manager->persist($utilisateur);

            $utilisateurs[] = $utilisateur;
        }

        for ($j = 0; $j < 10; $j++) {
            $categorie = new Categorie();
            $libelle = $faker->unique()->word();
            $categorie->setLibelle($libelle);
            $categorie->setSlug((new Slugify())->slugify($libelle));
            $manager->persist($categorie);


            for ($k = 0; $k < 3; $k++) {
                $article = new Article();
                $article->setTitre($faker->unique()->sentence(3, true));
                $article->setContenu($faker->unique()->text());
                $article->setDate($faker->dateTime());
                $article->setUtilisateur($utilisateurs[rand(0, count($utilisateurs) - 1)]);
                $article->setMaCategorie($categorie);
                $article->setSlug((new Slugify())->slugify($article->getTitre()));
                $article->setImageUrl($faker->randomElement(["https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ6SROVWdB2sMs3Kt2UFbgIaGMWRo6L7-fdQAxZwPLx1LEDVIKP", "https://media.tenor.com/QDAH4iPpfqQAAAAd/troll-monkeytroii.gif"]));
                $manager->persist($article);


                for ($l = 0; $l < 2; $l++) {
                    $avis = new Avis();
                    $avis->setContenu($faker->text());
                    $avis->setNote(rand(0, 5));


                    $avis->setUtilisateur($utilisateurs[rand(0, count($utilisateurs) - 1)]);
                    while ($avis->getUtilisateur() === $article->getUtilisateur()) {
                        $avis->setUtilisateur($utilisateurs[rand(0, count($utilisateurs) - 1)]);
                    }
                    $avis->setArticle($article);

                    $manager->persist($avis);
                }

            }
        }


        $manager->flush();
    }
}
