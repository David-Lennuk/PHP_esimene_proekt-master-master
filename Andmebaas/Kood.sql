CREATE TABLE loomad(
                       id int PRIMARY KEY AUTO_INCREMENT,
                       loomanimi varchar(20),
                       omanik varchar(30),
                       varv varchar(20));

insert into loomad(loomanimi, omanik, varv)
VALUES ('kass Vassily', 'David', 'red');

select *from loomad;






CREATE TABLE osalejad(
                           id INT PRIMARY KEY AUTO_INCREMENT,
                           nimi VARCHAR(20),
                           telefon varchar(12),
                           synniaeg DATE
);

INSERT INTO osalejad(nimi, telefon, synniaeg)
VALUES
    ('David', 58533524, '2020-10-10'),
    ('Eva', 58234567, '1995-03-15'),
    ('Alex', 58987654, '2001-07-22'),
    ('Maria', 57324689, '1992-12-05'),
    ('John', 58673421, '1987-01-10');

SELECT * FROM osalejad;