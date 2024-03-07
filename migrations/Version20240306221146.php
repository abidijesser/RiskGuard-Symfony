<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306221146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE constat_vehicule (id INT NOT NULL, type_vehicule VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, matricule INT NOT NULL, lieu VARCHAR(255) NOT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE constatvie (id INT NOT NULL, date_de_deces DATE NOT NULL, cause_de_deces VARCHAR(255) NOT NULL, identifiant_de_linformant VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sinistre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cin INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE constat_vehicule ADD CONSTRAINT FK_2AE46FFBF396750 FOREIGN KEY (id) REFERENCES sinistre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE constatvie ADD CONSTRAINT FK_4B469675BF396750 FOREIGN KEY (id) REFERENCES sinistre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat_vehicule DROP FOREIGN KEY FK_2AE46FFBF396750');
        $this->addSql('ALTER TABLE constatvie DROP FOREIGN KEY FK_4B469675BF396750');
        $this->addSql('DROP TABLE constat_vehicule');
        $this->addSql('DROP TABLE constatvie');
        $this->addSql('DROP TABLE sinistre');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
