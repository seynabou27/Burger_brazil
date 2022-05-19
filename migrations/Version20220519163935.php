<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519163935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD paiements_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB985086F FOREIGN KEY (paiements_id) REFERENCES paiement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67DB985086F ON commande (paiements_id)');
        $this->addSql('ALTER TABLE paiement DROP date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB985086F');
        $this->addSql('DROP INDEX UNIQ_6EEAA67DB985086F ON commande');
        $this->addSql('ALTER TABLE commande DROP paiements_id');
        $this->addSql('ALTER TABLE paiement ADD date DATE NOT NULL');
    }
}
