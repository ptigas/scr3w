CREATE TABLE addresses (
  a_id        INT(11)      NOT NULL AUTO_INCREMENT, -- PK
  a_city      VARCHAR(255) NOT NULL,
  a_street    VARCHAR(255) NOT NULL,
  a_number    VARCHAR(255) NOT NULL,
  a_zip       VARCHAR(255) NOT NULL,

  PRIMARY KEY (a_id)
) ENGINE = InnoDB;

CREATE TABLE continents (
  con_id   INT(11)      NOT NULL AUTO_INCREMENT, -- PK
  con_name VARCHAR(255) NOT NULL,

  PRIMARY KEY (con_id)
) ENGINE = InnoDB;

CREATE TABLE countries (
  cou_id     INT(11)      NOT NULL AUTO_INCREMENT, -- PK
  cou_name   VARCHAR(255) NOT NULL,
  cou_con_id INT(11)      NOT NULL, -- FK

  PRIMARY KEY (cou_id),
  FOREIGN KEY (cou_con_id) REFERENCES continents(con_id)
) ENGINE = InnoDB;

CREATE TABLE customers (
  cu_id      INT(11)      NOT NULL AUTO_INCREMENT, -- PK
  cu_name    VARCHAR(255) NOT NULL,
  cu_balance DECIMAL(6,3) NOT NULL,
  cu_a_id    INT(11)      NOT NULL, -- FK
  cu_cou_id  INT(11)      NOT NULL, -- FK

  PRIMARY KEY (cu_id),
  FOREIGN KEY (cu_a_id) REFERENCES addresses(a_id),
  FOREIGN KEY (cu_cou_id) REFERENCES countries(cou_id)
) ENGINE = InnoDB;

CREATE TABLE telephones (
  t_cu_id  INT(11)      NOT NULL,
  t_number VARCHAR(255) NOT NULL,

  PRIMARY KEY (t_cu_id, t_number),
  FOREIGN KEY (t_cu_id) REFERENCES customers(cu_id)
) ENGINE = InnoDB;


CREATE TABLE orders (
  o_id                INT(11)       NOT NULL AUTO_INCREMENT, -- PK
  o_cu_id             INT(11)       NOT NULL, -- FK
  o_date              DATETIME      NOT NULL,
  o_shipping_priority INT(2)        NOT NULL,
  o_overall_price     DECIMAL(11,3) NOT NULL,
  o_employee          VARCHAR(255)  NOT NULL,
  o_priority          INT(2)        NOT NULL,

  PRIMARY KEY (o_id),
  FOREIGN KEY (o_cu_id) REFERENCES customers(cu_id)
) ENGINE = InnoDB;

CREATE TABLE parts (
  p_id           INT(11)       NOT NULL AUTO_INCREMENT, -- PK
  p_name         VARCHAR(255)  NOT NULL,
  p_price        DECIMAL(11,3) NOT NULL,
  p_size         INT(11)       NOT NULL,
  p_manufacturer VARCHAR(255)  NOT NULL,
  p_packaging    VARCHAR(255)  NOT NULL,
  p_brand        VARCHAR(255)  NOT NULL,
  p_type         VARCHAR(255)  NOT NULL,

  PRIMARY KEY (p_id)
) ENGINE = InnoDB;

CREATE TABLE order_lines (
  ol_o_id                INT(11)        NOT NULL,  -- PK FK
  ol_p_id                INT(11)        NOT NULL,  -- PK FK
  ol_tax                 DECIMAL(11,2)  NOT NULL,
  ol_quantity            INT(11)        NOT NULL,
  ol_approved            BOOL           NOT NULL,
  ol_shipping_date       DATETIME       NOT NULL,
  ol_price               DECIMAL(11,3)  NOT NULL,
  ol_status              VARCHAR(255)   NOT NULL,
  ol_discount            DECIMAL(11, 2) NOT NULL,
  ol_agreed_arrival_date DATE           NOT NULL,
  ol_actual_arrival_date DATE           NOT NULL,

  PRIMARY KEY (ol_o_id, ol_p_id),
  FOREIGN KEY (ol_o_id) REFERENCES orders(o_id),
  FOREIGN KEY (ol_p_id) REFERENCES parts(p_id)
) ENGINE = InnoDB;

-- LOAD DATA LOCAL INFILE 'addresses.dat' INTO TABLE addresses;
-- LOAD DATA LOCAL INFILE 'customers.dat' INTO TABLE customers;
-- LOAD DATA LOCAL INFILE 'telephones.dat' INTO TABLE telephones;
-- LOAD DATA LOCAL INFILE 'countries.dat' INTO TABLE countries;
-- LOAD DATA LOCAL INFILE 'continents.dat' INTO TABLE continents;
-- LOAD DATA LOCAL INFILE 'orders.dat' INTO TABLE orders;
-- LOAD DATA LOCAL INFILE 'parts.dat' INTO TABLE parts;
-- LOAD DATA LOCAL INFILE 'order_lines.dat' INTO TABLE order_lines;
