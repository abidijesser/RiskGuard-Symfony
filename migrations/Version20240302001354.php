<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302001354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, nomdupack VARCHAR(255) NOT NULL, promotiondupack VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, typedupack VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assurancevehicule (id INT AUTO_INCREMENT NOT NULL, assurance_id INT DEFAULT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, datedebut DATE NOT NULL, periodedevalidation VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_B93B089CB288C3E3 (assurance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assurancevie (id INT AUTO_INCREMENT NOT NULL, assurance_id INT DEFAULT NULL, datedebut DATE NOT NULL, periodevalidation VARCHAR(255) NOT NULL, salaireclient DOUBLE PRECISION NOT NULL, fichedepaie VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, INDEX IDX_F2138E1AB288C3E3 (assurance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assurancevehicule ADD CONSTRAINT FK_B93B089CB288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE assurancevie ADD CONSTRAINT FK_F2138E1AB288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurancevehicule DROP FOREIGN KEY FK_B93B089CB288C3E3');
        $this->addSql('ALTER TABLE assurancevie DROP FOREIGN KEY FK_F2138E1AB288C3E3');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE assurancevehicule');
        $this->addSql('DROP TABLE assurancevie');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
