<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
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
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));
        // fixtures aavec faker
        /* // Création des catégories
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
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph())
                    ->setMainPicture($faker->imageUrl(400, 400, true));

                $manager->persist($product);
            }
        } */

        // fixtures perso
        $categorys = [
            0 => [
                "name" => "Soins Visage"
            ],
            1 => [
                "name" => "Soins Corps"
            ],
            2 => [
                "name" => "Nouveautés"
            ]
        ];
        $products = [
            0 => [
                "name" => [
                    0 => "crème jour",
                    1 => "serum beauty",
                    2 => "crème nuit",
                    3 => "roller anti-cerne",
                    4 => "masque vivifiant"
                ]
            ],
            1 => [
                "name" => [
                    0 => "crème auto-bronzante",
                    1 => "gel anti rides",
                    2 => "rol-on jambes",
                    3 => "Huile de massage",
                    4 => "anti cellulite"
                ]
            ],
            2 => [
                "name" => [
                    0 => "rouge à levre",
                    1 => "peluche licorne",
                    2 => "mascara",
                    3 => "peigne",
                    4 => "lisseur"
                ]
            ]
        ];
        // Création des catégories
        for ($c = 0; $c < 3; $c++) {
            $category = new Category();
            $category->setName($categorys[$c]['name'])
                ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
            // création des produits
            for ($p = 0; $p < mt_rand(2, 5); $p++) {
                $product = new Product();
                $product->setName($products[$c]['name'][$p])
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph())
                    ->setMainPicture($faker->imageUrl(400, 400, true));

                $manager->persist($product);
            }
        }


        $manager->flush();
    }
}
