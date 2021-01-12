CREATE TABLE IF NOT EXISTS user(
    id BIGINT(11) AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    birth DATE NOT NULL,
    register DATETIME NOT NULL,
    address BIGINT(11) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS address(
    id BIGINT(11) AUTO_INCREMENT,
    code BIGINT(8) NOT NULL,
    estate CHAR(2) NOT NULL,
    city VARCHAR(25) NOT NULL,
    district VARCHAR(25) NOT NULL,
    address VARCHAR(25) NOT NULL,
    number INT(5) NOT NULL,
    complement VARCHAR(20),
    PRIMARY KEY(id)
);

ALTER TABLE user ADD FOREIGN KEY (address) REFERENCES address(id);
