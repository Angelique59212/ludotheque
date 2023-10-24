<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024093600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items_collection ADD library_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items_collection ADD CONSTRAINT FK_62555B05FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id)');
        $this->addSql('CREATE INDEX IDX_62555B05FE2541D7 ON items_collection (library_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE items_collection DROP FOREIGN KEY FK_62555B05FE2541D7');
        $this->addSql('DROP INDEX IDX_62555B05FE2541D7 ON items_collection');
        $this->addSql('ALTER TABLE items_collection DROP library_id');
    }
}
