<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191102034851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, priority enum(\'low\', \'medium\', \'high\'), difficulty enum(\'easy\', \'intermediate\', \'difficult\'), status enum(\'todo\', \'in progress\', \'done\'), INDEX IDX_12AD233E166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue_task (issue_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_A9913E95E7AA58C (issue_id), INDEX IDX_A9913E98DB60186 (task_id), PRIMARY KEY(issue_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `release` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, release_date DATETIME NOT NULL, src_link VARCHAR(255) NOT NULL, doc_description LONGTEXT DEFAULT NULL, doc_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sprint (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, release_target_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_EF8055B7166D1F9C (project_id), UNIQUE INDEX UNIQ_EF8055B72F605A73 (release_target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, status enum(\'todo\', \'in progress\', \'done\'), workload DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type enum(\'unit\', \'fonctional\', \'integration\', \'ui\'), expected_result LONGTEXT NOT NULL, obtained_result LONGTEXT NOT NULL, test_date DATETIME NOT NULL, status enum(\'SUCCESS\', \'FAIL\', \'UNKNOWN\'), INDEX IDX_D87F7E0C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_project_relation (id INT AUTO_INCREMENT NOT NULL, project_id_id INT NOT NULL, user_id_id INT NOT NULL, role enum(\'owner\', \'collaborator\'), INDEX IDX_22D28E4F6C1197C9 (project_id_id), INDEX IDX_22D28E4F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE issue_task ADD CONSTRAINT FK_A9913E95E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE issue_task ADD CONSTRAINT FK_A9913E98DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B72F605A73 FOREIGN KEY (release_target_id) REFERENCES `release` (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE user_project_relation ADD CONSTRAINT FK_22D28E4F6C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE user_project_relation ADD CONSTRAINT FK_22D28E4F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issue_task DROP FOREIGN KEY FK_A9913E95E7AA58C');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E166D1F9C');
        $this->addSql('ALTER TABLE sprint DROP FOREIGN KEY FK_EF8055B7166D1F9C');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C166D1F9C');
        $this->addSql('ALTER TABLE user_project_relation DROP FOREIGN KEY FK_22D28E4F6C1197C9');
        $this->addSql('ALTER TABLE sprint DROP FOREIGN KEY FK_EF8055B72F605A73');
        $this->addSql('ALTER TABLE issue_task DROP FOREIGN KEY FK_A9913E98DB60186');
        $this->addSql('ALTER TABLE user_project_relation DROP FOREIGN KEY FK_22D28E4F9D86650F');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE issue_task');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE `release`');
        $this->addSql('DROP TABLE sprint');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_project_relation');
    }
}
