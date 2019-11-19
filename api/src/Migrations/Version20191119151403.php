<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191119151403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tests (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type enum(\'unit\', \'fonctional\', \'integration\', \'ui\'), expected_result LONGTEXT NOT NULL, obtained_result LONGTEXT NOT NULL, test_date DATETIME NOT NULL, status enum(\'SUCCESS\', \'FAIL\', \'UNKNOWN\'), INDEX IDX_1260FC5E166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_user (test_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_88EAFC861E5D0459 (test_id), INDEX IDX_88EAFC86A76ED395 (user_id), PRIMARY KEY(test_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, status enum(\'todo\', \'in progress\', \'done\'), workload DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_projects_relations (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, user_id INT NOT NULL, role enum(\'owner\', \'collaborator\'), INDEX IDX_8E1F3D1B166D1F9C (project_id), INDEX IDX_8E1F3D1BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issues (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, priority enum(\'low\', \'medium\', \'high\'), difficulty enum(\'easy\', \'intermediate\', \'difficult\'), status enum(\'todo\', \'in progress\', \'done\'), INDEX IDX_DA7D7F83166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue_task (issue_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_A9913E95E7AA58C (issue_id), INDEX IDX_A9913E98DB60186 (task_id), PRIMARY KEY(issue_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sprints (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, release_target_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_4EE46971166D1F9C (project_id), UNIQUE INDEX UNIQ_4EE469712F605A73 (release_target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sprint_issue (sprint_id INT NOT NULL, issue_id INT NOT NULL, INDEX IDX_204E8D728C24077B (sprint_id), INDEX IDX_204E8D725E7AA58C (issue_id), PRIMARY KEY(sprint_id, issue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE releases (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, release_date DATETIME NOT NULL, src_link VARCHAR(255) NOT NULL, doc_description LONGTEXT DEFAULT NULL, doc_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tests ADD CONSTRAINT FK_1260FC5E166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE test_user ADD CONSTRAINT FK_88EAFC861E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_user ADD CONSTRAINT FK_88EAFC86A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_projects_relations ADD CONSTRAINT FK_8E1F3D1B166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE users_projects_relations ADD CONSTRAINT FK_8E1F3D1BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE issues ADD CONSTRAINT FK_DA7D7F83166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE issue_task ADD CONSTRAINT FK_A9913E95E7AA58C FOREIGN KEY (issue_id) REFERENCES issues (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE issue_task ADD CONSTRAINT FK_A9913E98DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sprints ADD CONSTRAINT FK_4EE46971166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE sprints ADD CONSTRAINT FK_4EE469712F605A73 FOREIGN KEY (release_target_id) REFERENCES releases (id)');
        $this->addSql('ALTER TABLE sprint_issue ADD CONSTRAINT FK_204E8D728C24077B FOREIGN KEY (sprint_id) REFERENCES sprints (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sprint_issue ADD CONSTRAINT FK_204E8D725E7AA58C FOREIGN KEY (issue_id) REFERENCES issues (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test_user DROP FOREIGN KEY FK_88EAFC861E5D0459');
        $this->addSql('ALTER TABLE issue_task DROP FOREIGN KEY FK_A9913E98DB60186');
        $this->addSql('ALTER TABLE test_user DROP FOREIGN KEY FK_88EAFC86A76ED395');
        $this->addSql('ALTER TABLE users_projects_relations DROP FOREIGN KEY FK_8E1F3D1BA76ED395');
        $this->addSql('ALTER TABLE issue_task DROP FOREIGN KEY FK_A9913E95E7AA58C');
        $this->addSql('ALTER TABLE sprint_issue DROP FOREIGN KEY FK_204E8D725E7AA58C');
        $this->addSql('ALTER TABLE sprint_issue DROP FOREIGN KEY FK_204E8D728C24077B');
        $this->addSql('ALTER TABLE tests DROP FOREIGN KEY FK_1260FC5E166D1F9C');
        $this->addSql('ALTER TABLE users_projects_relations DROP FOREIGN KEY FK_8E1F3D1B166D1F9C');
        $this->addSql('ALTER TABLE issues DROP FOREIGN KEY FK_DA7D7F83166D1F9C');
        $this->addSql('ALTER TABLE sprints DROP FOREIGN KEY FK_4EE46971166D1F9C');
        $this->addSql('ALTER TABLE sprints DROP FOREIGN KEY FK_4EE469712F605A73');
        $this->addSql('DROP TABLE tests');
        $this->addSql('DROP TABLE test_user');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE users_projects_relations');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE issues');
        $this->addSql('DROP TABLE issue_task');
        $this->addSql('DROP TABLE sprints');
        $this->addSql('DROP TABLE sprint_issue');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE releases');
    }
}
