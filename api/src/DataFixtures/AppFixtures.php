<?php

namespace App\DataFixtures;

use App\Controller\UserController;
use App\Entity\Issue;
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
        $projectRoot = new Project();
        $projectRoot->setName("project_root");
        $projectRoot->setDescription("description_project_");
        $projectRoot->setCreatedAt(new \DateTime());
        $manager->persist($projectRoot);
        // php bin/console doctrine:fixtures:load
        for($i=0; $i< 10; $i++ ) {
            $project = new Project();
            $project->setName("project_" . $i);
            $project->setDescription("description_project_" . $i);
            $project->setCreatedAt(new \DateTime());
            $manager->persist($project);
        }
        for($i=0; $i< 100; $i++ ) {
            $issue = new Issue();
            $issue->setCreatedAt(new \DateTime());
            $issue->setName("isuue test".$i);
            $issue->setDescription("desc");
            $issue->setDifficulty("easy");
            $issue->setProject($projectRoot);
            $issue->setPriority("low");
            $issue->setStatus("done");
            $manager->persist($issue);
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
