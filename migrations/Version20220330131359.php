<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330131359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168EA9FDD75');
        $this->addSql('DROP INDEX IDX_BFDD3168EA9FDD75 ON articles');
        $this->addSql('ALTER TABLE articles DROP media_id');
        $this->addSql('ALTER TABLE media ADD articles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C1EBAF6CC ON media (articles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168EA9FDD75 ON articles (media_id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C1EBAF6CC');
        $this->addSql('DROP INDEX IDX_6A2CA10C1EBAF6CC ON media');
        $this->addSql('ALTER TABLE media DROP articles_id');
    }
}
