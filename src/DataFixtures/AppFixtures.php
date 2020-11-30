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
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) 
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create();
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
