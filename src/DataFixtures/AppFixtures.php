<?php

namespace App\DataFixtures;


use Faker\Factory;
use Faker\Generator;
use App\Entity\TTime;

use App\Entity\TUser;
use App\Entity\TTitle;
use App\Entity\TStatus;
use App\Entity\TProduct;
use Faker\Provider\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AppFixtures extends Fixture
{

    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');

    }

    public function load(ObjectManager $manager)
    {
        // Users
        $users = [];

        //admin user
        $admin = new TUser();
        $admin->setUseFirstName('Administrateur')
            ->setUseLastName('de Cretegny')
            ->setEmail('admin@cretegny.ch')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setUseNumberPhone('+41000000000')
            ->setUseCreatedDate($this->faker->dateTimeThisMonth())
            ->setPassword('$2y$13$KYgZNICcEJKJt7bpBDtMcuIkLWe7Fzkd1I42hxjduViiC50eEhIb.'); //12345678$

        $users[] = $admin;
        $manager->persist($admin);


        //random users
        for ($i = 0; $i < 10; $i++) {
            $user = new TUser();
            $user->setUseFirstName($this->faker->firstName())
                ->setUseLastName($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setUseNumberPhone($this->faker->e164PhoneNumber())
                ->setUseCreatedDate($this->faker->dateTimeThisMonth())
                ->setPassword('$2y$13$88EpDrWOBWc/SQAqZBBFzuypQHXSHC7eJCWF4IeceLVk37.ZWMJeq') //12345678 
            ;
            $users[] = $user;
            $manager->persist($user);
        }

        // create title
        $titles = ['Monsieur', 'Madame'];

        foreach ($titles as $name) {
            $title = new TTitle();
            $title->setTitName($name);
            $manager->persist($title);
        }
        $manager->flush();



        // create slice of the journey
        $slices = ['Dans la matinée', 'Dans l\'après midi'];

        foreach ($slices as $time) {
            $slice = new TTime();
            $slice->setTimSlice($time);
            $manager->persist($slice);
        }
        $manager->flush();

        // create status of command
        $status = ['En cours', 'Livré'];

        foreach ($status as $staName) {
            $statu = new TStatus();
            $statu->setStaName($staName);
            $manager->persist($statu);
        }
        $manager->flush();





        //products creation
        for ($i = 0; $i < 100; $i++) {
            $product = new TProduct();
            $product->setProName('Produit ' . $i)
                ->setProPrice(mt_rand(5, 20))
                ->setProQuantity(mt_rand(15, 100))
                ->setProDescription($this->faker->text(300))
                ->setProIsActive(mt_rand(0, 1));
                
            $manager->persist($product);
        }

        $manager->flush();

    }
}