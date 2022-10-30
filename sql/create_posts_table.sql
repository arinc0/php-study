CREATE TABLE IF NOT EXISTS posts (
    id         INTEGER NOT NULL AUTO_INCREMENT,
    name       VARCHAR(40),
    comment    VARCHAR(200),
    created_at DATETIME,
    PRIMARY KEY (id)
) ENGINE = INNODB;