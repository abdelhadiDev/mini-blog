<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    const DEFAULT_USER = ["email" => "abdelhadi@test.com", "password" => "passpass", "status" => true, "age" => 26];

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create();

        $defaultUser = new User();
        $passwordHash = $this->encoder->encodePassword($defaultUser, self::DEFAULT_USER['password']);

        $defaultUser->setEmail(self::DEFAULT_USER['email'])
            ->setPassword($passwordHash)
            ->setAge($fake->numberBetween(18, 50))
            ->setStatus($fake->boolean(90));

        $manager->persist($defaultUser);


        for ($i = 0; $i < 50; $i++) {
            $user = new User();

            $passwordHash = $this->encoder->encodePassword($user, 'password');
            $user->setEmail($fake->email)
            ->setPassword($passwordHash)
            ->setAge($fake->numberBetween(18, 50))
            ->setStatus($fake->boolean(90));

            $manager->persist($user);

            for ($a = 0; $a < random_int(5, 15); $a++) {
                $article = (new Article())->setAuthor($user)
                ->setContent($fake->text(300))
                ->setName($fake->text(50));

                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
