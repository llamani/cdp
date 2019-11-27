<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126022240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issues CHANGE priority priority enum(\'low\', \'medium\', \'high\'), CHANGE difficulty difficulty enum(\'easy\', \'intermediate\', \'difficult\'), CHANGE status status enum(\'todo\', \'in progress\', \'done\')');
        $this->addSql('ALTER TABLE releases ADD sprint_id INT NOT NULL, DROP doc_description, DROP doc_file');
        $this->addSql('ALTER TABLE releases ADD CONSTRAINT FK_7896E4D18C24077B FOREIGN KEY (sprint_id) REFERENCES sprints (id)');
        $this->addSql('CREATE INDEX IDX_7896E4D18C24077B ON releases (sprint_id)');
        $this->addSql('ALTER TABLE sprints DROP FOREIGN KEY FK_4EE469712F605A73');
        $this->addSql('DROP INDEX UNIQ_4EE469712F605A73 ON sprints');
        $this->addSql('ALTER TABLE sprints DROP release_target_id');
        $this->addSql('ALTER TABLE tasks CHANGE status status enum(\'todo\', \'in progress\', \'done\')');
        $this->addSql('ALTER TABLE tests CHANGE type type enum(\'unit\', \'fonctional\', \'integration\', \'ui\'), CHANGE status status enum(\'SUCCESS\', \'FAIL\', \'UNKNOWN\')');
        $this->addSql('ALTER TABLE users_projects_relations CHANGE role role enum(\'owner\', \'collaborator\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issues CHANGE priority priority VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE difficulty difficulty VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE releases DROP FOREIGN KEY FK_7896E4D18C24077B');
        $this->addSql('DROP INDEX IDX_7896E4D18C24077B ON releases');
        $this->addSql('ALTER TABLE releases ADD doc_description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD doc_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP sprint_id');
        $this->addSql('ALTER TABLE sprints ADD release_target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sprints ADD CONSTRAINT FK_4EE469712F605A73 FOREIGN KEY (release_target_id) REFERENCES releases (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EE469712F605A73 ON sprints (release_target_id)');
        $this->addSql('ALTER TABLE tasks CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tests CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users_projects_relations CHANGE role role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
