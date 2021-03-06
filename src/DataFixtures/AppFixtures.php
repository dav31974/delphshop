<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker)); // extension faker pour des prix réaliste
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));  //extension faker pour avoir des produits réaliste

        for ($c = 0; $c < 3; $c++) {
            $category = new Category();
            $category->setName($faker->department)
                ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
            // création des produits
            for ($p = 0; $p < mt_rand(5, 10); $p++) {
                $product = new Product();
                $product->setName($faker->productName())
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category);

                $manager->persist($product);
            }
        }


        $manager->flush();
    }
}
