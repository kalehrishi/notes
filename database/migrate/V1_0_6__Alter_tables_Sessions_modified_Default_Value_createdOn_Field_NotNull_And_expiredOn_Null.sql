ALTER TABLE Sessions modify createdOn TIMESTAMP NOT NULL;
ALTER TABLE Sessions modify expiredOn TIMESTAMP DEFAULT NULL;
