<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518092832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE menus CHANGE burgerss_id burgerss_id INT NOT NULL');
        $this->addSql('ALTER TABLE menus_complement DROP FOREIGN KEY FK_EE28667914041B84');
        $this->addSql('ALTER TABLE menus_complement ADD CONSTRAINT FK_EE28667914041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE menus CHANGE burgerss_id burgerss_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menus_complement DROP FOREIGN KEY FK_EE28667914041B84');
        $this->addSql('ALTER TABLE menus_complement ADD CONSTRAINT FK_EE28667914041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
    }
}
