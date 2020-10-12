drop database if exists dentalclinic;
create database dentalclinic default character set utf8;
use dentalclinic;

#alter database persefon_edunovaPP19 default character set utf8;b

create table operater(
sifra int not null primary key auto_increment,
email varchar(255) not null,
lozinka char(60) not null,
ime varchar(50) not null,
prezime varchar(50) not null,
uloga varchar(20) not null
);

#admin a
insert into operater values (null,'admin@edunova.hr',
'$2y$10$VHFCIUVQ7F.j7aXA07GjjuzRCYhbk7AHu4Q513zeaF9ThgkoK/AYa',
'Admin','Edunova','admin');

#operater o
insert into operater values (null,'oper@edunova.hr',
'$2y$10$12.XWIaCWGM3CbPUB2hR9OOelvIqkVc5aauBK/VMaTolAl.had1nq',
'Operater','Edunova','oper');

#pacijent p
insert into operater values (null,'pacijent@dentalclinic.hr',
'$2y$10$CgA343FuHFPQ3EYF1HI.8u15riZY7O.noMrM4AKu.dX1JqB8VstCK',
'Ivo','Ivić','pacijent');

#doktor d
insert into operater values (null,'doktor@dentalclinic.hr',
'$2y$10$WRN39Rd6VhXQSxZG6AOy4O7ii7bMrX3cR7lpZ2hEal.WCNYfWgYFS',
'Pero','Perić','doktor');

create table ordinacija(
sifra int not null primary key auto_increment,
naziv varchar(50)
);

create table doktor(
sifra int not null primary key auto_increment,
ime varchar(30),
prezime varchar(30),
iban char(32),
pregled datetime,
ordinacija int not null
);

create table tehnicar(
sifra int not null primary key auto_increment,
ime varchar(30),
prezime varchar(30),
mbo char(10),
pregled datetime,
laboratorij int not null
);

create table pacijent(
sifra int not null primary key auto_increment,
ime varchar(30),
prezime varchar(30),
mbo char(10),
pregled datetime
);

create table termin(
pacijent int not null,
doktor int not null
);

alter table tehnicar add foreign key (laboratorij) references laboratorij(sifra);

alter table doktor add foreign key (ordinacija) references ordinacija(sifra);

alter table termin add foreign key (doktor) references doktor(sifra);
alter table termin add foreign key (pacijent) references pacijent(sifra);


insert into ordinacija (naziv) values
('Ordinacija dentalne medicine Sandra'),
('Ordinacija dentalne medicine Josip'),
('Ordinacija dentalne medicine Damir');

insert into pacijent (ime, prezime, mbo) values
('Ivo', 'Ivić', '6852347620'),
('Pero', 'Perić', '134567891'),
('Ivana', 'Kovačević','9874561232');
