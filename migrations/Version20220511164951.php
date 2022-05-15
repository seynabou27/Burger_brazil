<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511164951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD nom VARCHAR(255) NOT NULL, ADD prix VARCHAR(255) NOT NULL, ADD details VARCHAR(255) NOT NULL, DROP nom_burger, DROP prix_burger, DROP details_burger');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD nom_burger VARCHAR(255) NOT NULL, ADD prix_burger VARCHAR(255) NOT NULL, ADD details_burger VARCHAR(255) NOT NULL, DROP nom, DROP prix, DROP details');
    }
}
