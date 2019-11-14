DROP TABLE IF EXISTS departamentos CASCADE;

CREATE TABLE departamentos
(
    id        bigserial    PRIMARY KEY
  , num_dep   numeric(2)   NOT NULL UNIQUE
  , dnombre   varchar(255) NOT NULL
  , localidad varchar(255)
);

DROP TABLE IF EXISTS empleados CASCADE;

CREATE TABLE empleados
(
    id              bigserial    PRIMARY KEY
  , num_emp         numeric(4)   NOT NULL UNIQUE
  , nombre          varchar(255) NOT NULL
  , salario         numeric(6,2)
  , departamento_id bigint       NOT NULL REFERENCES departamentos (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
);

INSERT INTO departamentos (num_dep, dnombre, localidad)
VALUES (10, 'Contabilidad', 'Sanlúcar')
     , (20, 'Facturación', 'Chipiona')
     , (30, 'Ventas', 'Trebujena');