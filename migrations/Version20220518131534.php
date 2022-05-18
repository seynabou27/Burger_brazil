<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518131534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger ADD etat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE complement ADD etat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE menus ADD etat VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP etat');
        $this->addSql('ALTER TABLE complement DROP etat');
        $this->addSql('ALTER TABLE menus DROP etat');
    }
}
