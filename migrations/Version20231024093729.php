<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024093729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD items_collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F22C4265D FOREIGN KEY (items_collection_id) REFERENCES items_collection (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F22C4265D ON image (items_collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F22C4265D');
        $this->addSql('DROP INDEX IDX_C53D045F22C4265D ON image');
        $this->addSql('ALTER TABLE image DROP items_collection_id');
    }
}
