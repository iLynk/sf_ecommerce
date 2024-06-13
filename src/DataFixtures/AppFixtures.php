<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\GameImage;
use App\Entity\GameCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $categories = [];

        for ($j = 0; $j < 150; $j++) {
            $category = new GameCategory();

            // Ensure the text length does not exceed 255 characters
            $category->setName($this->truncateString($faker->realTextBetween(10, 20), 255));
            $category->setDescription($this->truncateString($faker->realTextBetween(5, 10), 255));

            $categories[] = $category;

            $manager->persist($category);
        }

        for ($i = 0; $i < 150; $i++) {
            $game = new Game();

            // Ensure the text length does not exceed 255 characters
            $game->setName($this->truncateString($faker->realTextBetween(10, 30), 255))
                ->setDescription($this->truncateString($faker->realTextBetween(5, 15), 255))
                ->setPrice($faker->randomFloat(2, 10, 90))
                ->setStock($faker->randomDigit());

            $nbCategory = random_int(1, 10);
            for ($k = 0; $k < $nbCategory; $k++) {
                shuffle($categories);
                $game->addCategory($categories[0]);
            }

            for ($l = 0; $l < 10; $l++) {
                $image = new GameImage();
                // Ensure the text length does not exceed 255 characters
                $image->setName($this->truncateString($faker->realTextBetween(10, 16), 255))
                    ->setFile("https://picsum.photos/" . $faker->numberBetween(1, 900) . "/1024")
                    ->setGame($game);

                $manager->persist($image);
            }

            $manager->persist($game);
        }

        $manager->flush();
    }

    private function truncateString(string $text, int $maxLength): string
    {
        return mb_strimwidth($text, 0, $maxLength, '');
    }
}
