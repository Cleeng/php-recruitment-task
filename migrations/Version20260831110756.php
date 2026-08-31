<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260831110756 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, currency VARCHAR(3) NOT NULL, billing_period VARCHAR(3) NOT NULL, active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, cancelled_at DATETIME DEFAULT NULL, started_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, customer_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_A3C664D39395C3F3 (customer_id), INDEX IDX_A3C664D353C674EE (offer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D39395C3F3');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D353C674EE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE subscription');
    }
}
