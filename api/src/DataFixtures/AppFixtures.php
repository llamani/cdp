<?php

namespace App\DataFixtures;

use App\Controller\UserController;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i=0; $i< 10; $i++ ) {
            $project = new Project();
            $project->setName("project_" . $i);
            $project->setDescription("description_project_" . $i);
            $project->setCreatedAt(new \DateTime());
            $manager->persist($project);
        }

        $user = new User();
        $user->setEmail("johndoe@example.com");
        $user->setName("John Doe");
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
