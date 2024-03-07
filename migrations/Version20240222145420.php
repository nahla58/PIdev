<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222145420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE staff ADD id_a_id INT DEFAULT NULL, CHANGE numero numero INT NOT NULL');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392B0FE4F5A FOREIGN KEY (id_a_id) REFERENCES activite (id)');
        $this->addSql('CREATE INDEX IDX_426EF392B0FE4F5A ON staff (id_a_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF392B0FE4F5A');
        $this->addSql('DROP INDEX IDX_426EF392B0FE4F5A ON staff');
        $this->addSql('ALTER TABLE staff DROP id_a_id, CHANGE numero numero INT DEFAULT NULL');
    }
}
