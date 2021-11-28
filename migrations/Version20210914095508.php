<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914095508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, code_archive VARCHAR(255) NOT NULL, intitule_archive VARCHAR(255) NOT NULL, date_creation VARCHAR(255) NOT NULL, date_archivage DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archive_users (archive_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_736ECAF32956195F (archive_id), INDEX IDX_736ECAF367B3B43D (users_id), PRIMARY KEY(archive_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive_users ADD CONSTRAINT FK_736ECAF32956195F FOREIGN KEY (archive_id) REFERENCES archive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE archive_users ADD CONSTRAINT FK_736ECAF367B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive_users DROP FOREIGN KEY FK_736ECAF32956195F');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE archive_users');
    }
}
