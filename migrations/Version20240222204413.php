<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222204413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD marketing_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6DCB66C FOREIGN KEY (marketing_id) REFERENCES marketing (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCC6DCB66C ON commentaire (marketing_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6DCB66C');
        $this->addSql('DROP INDEX IDX_67F068BCC6DCB66C ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP marketing_id');
    }
}
