<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220515184244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE complement ADD nom VARCHAR(255) NOT NULL, ADD prix VARCHAR(255) NOT NULL, ADD detail VARCHAR(255) NOT NULL, DROP nom_complement, DROP prix_complement, DROP detail_complement');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE complement ADD nom_complement VARCHAR(255) NOT NULL, ADD prix_complement VARCHAR(255) NOT NULL, ADD detail_complement VARCHAR(255) NOT NULL, DROP nom, DROP prix, DROP detail');
    }
}
