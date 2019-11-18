<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191114125206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*$this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E166D1F9C');
        $this->addSql('ALTER TABLE sprint DROP FOREIGN KEY FK_EF8055B7166D1F9C');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C166D1F9C');
        $this->addSql('ALTER TABLE user_project_relation DROP FOREIGN KEY FK_22D28E4F6C1197C9');
        $this->addSql('ALTER TABLE sprint DROP FOREIGN KEY FK_EF8055B72F605A73');
        $this->addSql('ALTER TABLE user_project_relation DROP FOREIGN KEY FK_22D28E4F9D86650F');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE `release`');
        $this->addSql('DROP TABLE sprint');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_project_relation');*/
        $this->addSql('ALTER TABLE issues ADD sprint_id INT DEFAULT NULL, CHANGE priority priority enum(\'low\', \'medium\', \'high\'), CHANGE difficulty difficulty enum(\'easy\', \'intermediate\', \'difficult\'), CHANGE status status enum(\'todo\', \'in progress\', \'done\')');
        $this->addSql('ALTER TABLE issues ADD CONSTRAINT FK_DA7D7F838C24077B FOREIGN KEY (sprint_id) REFERENCES sprints (id)');
        $this->addSql('CREATE INDEX IDX_DA7D7F838C24077B ON issues (sprint_id)');
        $this->addSql('ALTER TABLE releases CHANGE doc_file doc_file VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sprints CHANGE release_target_id release_target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE status status enum(\'todo\', \'in progress\', \'done\')');
        $this->addSql('ALTER TABLE tests CHANGE type type enum(\'unit\', \'fonctional\', \'integration\', \'ui\'), CHANGE status status enum(\'SUCCESS\', \'FAIL\', \'UNKNOWN\')');
        $this->addSql('ALTER TABLE users_projects_relations CHANGE role role enum(\'owner\', \'collaborator\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*$this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, priority VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, difficulty VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, INDEX IDX_12AD233E166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `release` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, release_date DATETIME NOT NULL, src_link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, doc_description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, doc_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sprint (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, release_target_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_EF8055B72F605A73 (release_target_id), INDEX IDX_EF8055B7166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, workload DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, expected_result LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, obtained_result LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, test_date DATETIME NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D87F7E0C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_project_relation (id INT AUTO_INCREMENT NOT NULL, project_id_id INT NOT NULL, user_id_id INT NOT NULL, role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, INDEX IDX_22D28E4F6C1197C9 (project_id_id), INDEX IDX_22D28E4F9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B7166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE sprint ADD CONSTRAINT FK_EF8055B72F605A73 FOREIGN KEY (release_target_id) REFERENCES `release` (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE user_project_relation ADD CONSTRAINT FK_22D28E4F6C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE user_project_relation ADD CONSTRAINT FK_22D28E4F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');*/
        $this->addSql('ALTER TABLE issues DROP FOREIGN KEY FK_DA7D7F838C24077B');
        $this->addSql('DROP INDEX IDX_DA7D7F838C24077B ON issues');
        $this->addSql('ALTER TABLE issues DROP sprint_id, CHANGE priority priority VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE difficulty difficulty VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE releases CHANGE doc_file doc_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sprints CHANGE release_target_id release_target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tests CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users_projects_relations CHANGE role role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
