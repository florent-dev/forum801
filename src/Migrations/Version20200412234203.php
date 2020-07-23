<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412234203 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message CHANGE content content MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD section_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1BD823E37A ON topic (section_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message CHANGE content content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BD823E37A');
        $this->addSql('DROP INDEX IDX_9D40DE1BD823E37A ON topic');
        $this->addSql('ALTER TABLE topic DROP section_id');
    }
}
