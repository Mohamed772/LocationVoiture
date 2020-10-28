<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027125705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facturation (id INT AUTO_INCREMENT NOT NULL, idu_id INT NOT NULL, idv_id INT NOT NULL, date_d DATE NOT NULL, date_f DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, paye TINYINT(1) NOT NULL, INDEX IDX_17EB513A376A6230 (idu_id), INDEX IDX_17EB513A25DFCDDE (idv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A376A6230 FOREIGN KEY (idu_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT FK_17EB513A25DFCDDE FOREIGN KEY (idv_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE facturation ADD CONSTRAINT UC_Facturation UNIQUE (idv_id,idu_id,date_d)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE facturation');
    }
}
