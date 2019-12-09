<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125165206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonces ADD user_id_id INT NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD date DATETIME NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD location VARCHAR(255) NOT NULL, ADD category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F9D86650F ON annonces (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F9D86650F');
        $this->addSql('DROP INDEX IDX_CB988C6F9D86650F ON annonces');
        $this->addSql('ALTER TABLE annonces DROP user_id_id, DROP description, DROP prix, DROP date, DROP state, DROP location, DROP category');
    }
}
