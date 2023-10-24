<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024093416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items_collection ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items_collection ADD CONSTRAINT FK_62555B0512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_62555B0512469DE2 ON items_collection (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items_collection DROP FOREIGN KEY FK_62555B0512469DE2');
        $this->addSql('DROP INDEX IDX_62555B0512469DE2 ON items_collection');
        $this->addSql('ALTER TABLE items_collection DROP category_id');
    }
}
