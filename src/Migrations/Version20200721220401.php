<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200721220401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE community (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(2) NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, topic_id INT NOT NULL, status_author_id INT DEFAULT NULL, content MEDIUMTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status INT NOT NULL, status_reason VARCHAR(255) DEFAULT NULL, INDEX IDX_B6BD307FF675F31B (author_id), INDEX IDX_B6BD307F1F55203D (topic_id), INDEX IDX_B6BD307F7EE0735A (status_author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, linked_section_id INT DEFAULT NULL, community_id INT NOT NULL, name VARCHAR(30) NOT NULL, icon VARCHAR(20) NOT NULL, deleted TINYINT(1) NOT NULL, sort INT NOT NULL, INDEX IDX_2D737AEF4FE7383D (linked_section_id), INDEX IDX_2D737AEFFDA7B0BF (community_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, section_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, postit TINYINT(1) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_9D40DE1BF675F31B (author_id), INDEX IDX_9D40DE1BD823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7EE0735A FOREIGN KEY (status_author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF4FE7383D FOREIGN KEY (linked_section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFFDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFFDA7B0BF');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF4FE7383D');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BD823E37A');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1F55203D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF675F31B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F7EE0735A');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BF675F31B');
        $this->addSql('DROP TABLE community');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE user');
    }
}
