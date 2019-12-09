<?php

namespace App\DataFixtures;

use App\Controller\UserController;
use App\Entity\Issue;
use App\Entity\Project;
use App\Entity\Release;
use App\Entity\Sprint;
use App\Entity\Task;
use App\Entity\Test;
use App\Entity\User;
use App\Entity\UserProjectRelation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use vendor\project\StatusTest;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /***** USERS *****/
        $users = [];
        $lucie = new User();
        $lucie->setEmail("lucie@example.com");
        $lucie->setName("Lucie Almansa");
        $lucie->setPassword($this->passwordEncoder->encodePassword(
            $lucie,
            'test'
        ));
        $users[] = $lucie;
        $manager->persist($lucie);

        $laura = new User();
        $laura->setEmail("laura@example.com");
        $laura->setName("Laura Lamani");
        $laura->setPassword($this->passwordEncoder->encodePassword(
            $laura,
            'test'
        ));
        $users[] = $laura;
        $manager->persist($laura);

        $guillaume = new User();
        $guillaume->setEmail("guillaume@example.com");
        $guillaume->setName("Guillaume Nedelec");
        $guillaume->setPassword($this->passwordEncoder->encodePassword(
            $guillaume,
            'test'
        ));
        $users[] = $guillaume;
        $manager->persist($guillaume);

        $otherUser = new User();
        $otherUser->setEmail("johndoe@example.com");
        $otherUser->setName("John Doe");
        $otherUser->setPassword($this->passwordEncoder->encodePassword(
            $otherUser,
            'test'
        ));
        $manager->persist($otherUser);

        /*** PROJECTS ***/
        $cdpProject = new Project();
        $cdpProject->setName("Conduite de projet");
        $cdpProject->setDescription("Projet de conduite de projet 2019-2020");
        $cdpProject->setCreatedAt(new \DateTime("2019-10-21"));
        $manager->persist($cdpProject);

        $owner = true;
        foreach ($users as $u) {
            $userProjRelation = new UserProjectRelation();
            $userProjRelation->setUser($u);

            $userProjRelation->setProject($cdpProject);
            if ($owner) {
                $userProjRelation->setRole("owner");
            } else {
                $userProjRelation->setRole("collaborator");
            }
            $manager->persist($userProjRelation);
        }

        for($i=0; $i< 5; $i++ ) {
            $project = new Project();
            $project->setName("Autre projet - " . $i);
            $project->setDescription("Description du projet " . $i);
            $project->setCreatedAt(new \DateTime());
            $manager->persist($project);

            $owner = true;
            foreach ($users as $u) {
                $userProjRelation = new UserProjectRelation();
                $userProjRelation->setUser($u);
                $userProjRelation->setProject($project);
                if ($owner) {
                    $userProjRelation->setRole("owner");
                } else {
                    $userProjRelation->setRole("collaborator");
                }
                $manager->persist($userProjRelation);
            }
        }

        /**** ISSUES ***/
        $priority = ["low", "medium", "high"];
        $difficulty = ["easy", "intermediate", "difficult"];
        $issues = [];
        for($i=0; $i< 15; $i++ ) {
            $issue = new Issue();
            $issue->setCreatedAt(new \DateTime("2019-10-21"));
            $issue->setName("Issue number ".$i);
            $issue->setDescription("Description de l'issue");
            $issue->setDifficulty($difficulty[array_rand($difficulty, 1)]);
            $issue->setProject($cdpProject);
            $issue->setPriority($priority[array_rand($priority, 1)]);
            $issue->setStatus("todo");
            $issues[] = $issue;
            $manager->persist($issue);
        }

        /**** SPRINTS ****/
        $sprints = [];
        $startDate = ["2019-10-21", "2019-11-12", "2019-11-25"];
        $endDate = ["2019-11-08", "2019-11-22", "2019-12-10"];
        $j=0;
        for($i=0; $i< 3; $i++ ) {
            $sprint = new Sprint();
            $sprint->setProject($cdpProject);
            $sprint->setStartDate(new \DateTime($startDate[$i]));
            $sprint->setEndDate(new \DateTime($endDate[$i]));
            for($inc=$j; $inc < $j+5; $inc++) {
                $sprint->addIssue($issues[$inc]);
            }
            $sprints[] = $sprint;
            $manager->persist($sprint);
        }

        /**** TASKS ***/
        $status = ['todo', 'in progress', 'done'];
        $workload = [0.5, 1, 1.5, 2, 2.5, 3];
        for($i=0; $i< 30; $i++ ) {
            $number_issues_related = random_int(1,5);
            $task = new Task();
            $task->setName("Tache number " . $i);
            $task->setDescription("Description de la tache ". $i);
            $task->setCreatedAt(new \DateTime());
            $task->setStatus($status[array_rand($status, 1)]);
            $task->setWorkload($workload[array_rand($workload,1)]);
            $indexes = [];
            for($inc=0; $inc < $number_issues_related; $inc++) {
                $indexIssue = array_rand($issues,1);
                while (in_array($indexIssue, $indexes)) {
                    $indexIssue = array_rand($issues,1);
                }
                $task->addIssue($issues[$indexIssue]);
            }
            $manager->persist($task);
        }

        /**** TESTS ***/
        $statusTest = ['SUCCESS', 'FAIL', 'UNKNOWN'];
        $typeTest = ['unit', 'fonctional', 'integration', 'ui'];
        for($i=0; $i< 30; $i++ ) {
            $status_selected = $statusTest[array_rand($statusTest, 1)];
            $type_selected = $typeTest[array_rand($typeTest, 1)];
            $test = new Test();
            $test->setName("Test number " . $i);
            $test->setDescription("Description du test " . $i);
            $test->setType($type_selected);

            switch ($status_selected) {
                case 'SUCCESS':
                    $test->setExpectedResult("MA_VARIABLE = 1");
                    $test->setObtainedResult("MA_VARIABLE = 1");
                    break;
                case 'FAIL':
                    $test->setExpectedResult("MA_VARIABLE = 1");
                    $test->setObtainedResult("MA_VARIABLE = 0");
                    break;
                case 'UNKNOWN':
                    $test->setExpectedResult("MA_VARIABLE = 1");
                    $test->setObtainedResult("");
                    break;
            }
            $test->setTestDate(new \DateTime());
            $test->setStatus($status_selected);
            $test->setProject($cdpProject);
            $test->addTestManager($users[array_rand($users, 1)]);
            $manager->persist($test);
        }

        /**** RELEASES ***/
        for($i=0; $i< 3; $i++ ) {
            $release = new Release();
            $release->setName("Release number ". $i);
            $release->setDescription("Description de la release " . $i);
            $release->setReleaseDate(new \DateTime($endDate[$i]));
            $release->setSrcLink("https://github.com/llamani/cdp/releases");
            $release->setSprint($sprints[$i]);
            $manager->persist($release);
        }


        /*** SAVE ALL DATA FIXTURES ***/
        $manager->flush();
    }
}
