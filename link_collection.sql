CREATE DATABASE link_collection;

USE link_collection;


CREATE TABLE users (
  id             INT IDENTITY(1,1) PRIMARY KEY,
  username       VARCHAR(50)  NOT NULL UNIQUE,
  password_hash  VARCHAR(255) NOT NULL,
  created_at     DATETIME     NOT NULL DEFAULT GETDATE()
);


CREATE TABLE links (
  id           INT IDENTITY(1,1) PRIMARY KEY,
  user_id      INT NOT NULL,
  url          VARCHAR(2083) NOT NULL,
  description  TEXT           NULL,
  category     VARCHAR(100)   NULL,
  created_at   DATETIME       NOT NULL DEFAULT GETDATE(),
  CONSTRAINT FK_Links_Users FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

