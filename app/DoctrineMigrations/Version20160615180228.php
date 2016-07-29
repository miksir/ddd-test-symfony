<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615180228 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE attributes (id UUID NOT NULL, name VARCHAR(255) NOT NULL, site_name VARCHAR(128) NOT NULL, type INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN attributes.id IS \'(DC2Type:AttributeId)\'');
        $this->addSql('COMMENT ON COLUMN attributes.site_name IS \'(DC2Type:SiteName)\'');
        $this->addSql('CREATE TABLE design_photos (id UUID NOT NULL, interior_id UUID DEFAULT NULL, owner_id UUID DEFAULT NULL, file JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AAB770DAAD2C1AAD ON design_photos (interior_id)');
        $this->addSql('CREATE INDEX IDX_AAB770DA7E3C61F9 ON design_photos (owner_id)');
        $this->addSql('COMMENT ON COLUMN design_photos.id IS \'(DC2Type:DesignPhotoId)\'');
        $this->addSql('COMMENT ON COLUMN design_photos.interior_id IS \'(DC2Type:DesignInteriorId)\'');
        $this->addSql('COMMENT ON COLUMN design_photos.owner_id IS \'(DC2Type:UserId)\'');
        $this->addSql('COMMENT ON COLUMN design_photos.file IS \'(DC2Type:Image)\'');
        $this->addSql('CREATE TABLE design_interiors (id UUID NOT NULL, project_id UUID DEFAULT NULL, room_id UUID DEFAULT NULL, design_style_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E608107166D1F9C ON design_interiors (project_id)');
        $this->addSql('CREATE INDEX IDX_5E60810754177093 ON design_interiors (room_id)');
        $this->addSql('CREATE INDEX IDX_5E60810761EF0232 ON design_interiors (design_style_id)');
        $this->addSql('COMMENT ON COLUMN design_interiors.id IS \'(DC2Type:DesignInteriorId)\'');
        $this->addSql('COMMENT ON COLUMN design_interiors.project_id IS \'(DC2Type:DesignProjectId)\'');
        $this->addSql('COMMENT ON COLUMN design_interiors.room_id IS \'(DC2Type:AttributeId)\'');
        $this->addSql('COMMENT ON COLUMN design_interiors.design_style_id IS \'(DC2Type:AttributeId)\'');
        $this->addSql('CREATE TABLE design_projects (id UUID NOT NULL, owner_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, site_name VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_87B1D1E27E3C61F9 ON design_projects (owner_id)');
        $this->addSql('COMMENT ON COLUMN design_projects.id IS \'(DC2Type:DesignProjectId)\'');
        $this->addSql('COMMENT ON COLUMN design_projects.owner_id IS \'(DC2Type:UserId)\'');
        $this->addSql('COMMENT ON COLUMN design_projects.site_name IS \'(DC2Type:SiteName)\'');
        $this->addSql('CREATE TABLE roles (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN roles.id IS \'(DC2Type:RoleId)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:UserId)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:Email)\'');
        $this->addSql('COMMENT ON COLUMN users.password IS \'(DC2Type:HashedPassword)\'');
        $this->addSql('COMMENT ON COLUMN users.fullname IS \'(DC2Type:FullName)\'');
        $this->addSql('COMMENT ON COLUMN users.phone IS \'(DC2Type:Phone)\'');
        $this->addSql('CREATE TABLE user_roles (user_id UUID NOT NULL, role_id UUID NOT NULL, PRIMARY KEY(user_id, role_id))');
        $this->addSql('CREATE INDEX IDX_54FCD59FA76ED395 ON user_roles (user_id)');
        $this->addSql('CREATE INDEX IDX_54FCD59FD60322AC ON user_roles (role_id)');
        $this->addSql('COMMENT ON COLUMN user_roles.user_id IS \'(DC2Type:UserId)\'');
        $this->addSql('COMMENT ON COLUMN user_roles.role_id IS \'(DC2Type:RoleId)\'');
        $this->addSql('ALTER TABLE design_photos ADD CONSTRAINT FK_AAB770DAAD2C1AAD FOREIGN KEY (interior_id) REFERENCES design_interiors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE design_photos ADD CONSTRAINT FK_AAB770DA7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE design_interiors ADD CONSTRAINT FK_5E608107166D1F9C FOREIGN KEY (project_id) REFERENCES design_projects (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE design_interiors ADD CONSTRAINT FK_5E60810754177093 FOREIGN KEY (room_id) REFERENCES attributes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE design_interiors ADD CONSTRAINT FK_5E60810761EF0232 FOREIGN KEY (design_style_id) REFERENCES attributes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE design_projects ADD CONSTRAINT FK_87B1D1E27E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59FD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE design_interiors DROP CONSTRAINT FK_5E60810754177093');
        $this->addSql('ALTER TABLE design_interiors DROP CONSTRAINT FK_5E60810761EF0232');
        $this->addSql('ALTER TABLE design_photos DROP CONSTRAINT FK_AAB770DAAD2C1AAD');
        $this->addSql('ALTER TABLE design_interiors DROP CONSTRAINT FK_5E608107166D1F9C');
        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT FK_54FCD59FD60322AC');
        $this->addSql('ALTER TABLE design_photos DROP CONSTRAINT FK_AAB770DA7E3C61F9');
        $this->addSql('ALTER TABLE design_projects DROP CONSTRAINT FK_87B1D1E27E3C61F9');
        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT FK_54FCD59FA76ED395');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE design_photos');
        $this->addSql('DROP TABLE design_interiors');
        $this->addSql('DROP TABLE design_projects');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_roles');
    }
}
