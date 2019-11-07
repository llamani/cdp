<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=0; $i< 10; $i++ ) {
            $project = new Project();
            $project->setName("project_" . $i);
            $project->setDescription("description_project_" . $i);
            $project->setCreatedAt(new \DateTime());
            $manager->persist($project);
        }

        $manager->flush();
    }
}
