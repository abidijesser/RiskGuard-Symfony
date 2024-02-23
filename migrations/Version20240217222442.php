<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217222442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat_vehicule CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE constat_vehicule ADD CONSTRAINT FK_2AE46FFBF396750 FOREIGN KEY (id) REFERENCES sinistre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE constatvie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE constatvie ADD CONSTRAINT FK_4B469675BF396750 FOREIGN KEY (id) REFERENCES sinistre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sinistre ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constatvie DROP FOREIGN KEY FK_4B469675BF396750');
        $this->addSql('ALTER TABLE constatvie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE constat_vehicule DROP FOREIGN KEY FK_2AE46FFBF396750');
        $this->addSql('ALTER TABLE constat_vehicule CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sinistre DROP type');
    }
}
