CREATE SCHEMA realEstate;
CREATE TABLE realEstate.City(
                                id int unsigned auto_increment primary key not null,
                                name varchar(30) unicode unique not null);
CREATE TABLE realEstate.Municipality(
                                        id int unsigned auto_increment primary key not null ,
                                        name varchar(30) unicode unique not null ,
                                        cityId int unsigned not null ,
                                        foreign key (cityId) references realEstate.City(id));
CREATE TABLE realEstate.MicroLocation(
                                         id int unsigned auto_increment primary key not null ,
                                         name varchar(30) unicode unique not null ,
                                         municipalityId int unsigned not null ,
                                         foreign key (municipalityId) references realEstate.Municipality(id));
CREATE TABLE realEstate.Street(
                                  id int unsigned auto_increment primary key not null ,
                                  name varchar(100) unicode unique not null ,
                                  microLocationId int unsigned not null ,
                                  foreign key (microLocationId) references realEstate.MicroLocation(id));
CREATE TABLE realEstate.Agency(
                                  id int unsigned auto_increment primary key not null,
                                  name varchar(100) not null,
                                  pib varchar(11) not null unique,
                                  streetId int unsigned not null,
                                  number int unsigned not null,
                                  foreign key (streetId) references realEstate.Street(id)
);
CREATE TABLE realEstate.User(
                                id int unsigned auto_increment primary key not null,
                                firstName varchar(30) not null,
                                lastName varchar(30) not null,
                                userName varchar(30) not null unique,
                                password varchar(255) not null,
                                cityId int unsigned not null ,
                                foreign key (cityId) references realEstate.City(id),
                                birthDate date not null,
                                telephone varchar(30) not null,
                                email varchar(255) not null unique,
                                agencyId int unsigned,
                                foreign key (agencyId) references realEstate.Agency(id),
                                licenceNumber int,
                                verified bool,
                                isAdministrator bool not null,
                                token varchar(255)
);
CREATE TABLE realEstate.ConditionType(
                                         id int unsigned auto_increment primary key not null,
                                         name varchar(30) not null
);
CREATE TABLE realEstate.HeatingType(
                                       id int unsigned auto_increment primary key not null,
                                       name varchar(30) not null
);
CREATE TABLE realEstate.Perk(
                                id int unsigned auto_increment primary key not null,
                                name varchar(30) not null
);
CREATE TABLE realEstate.EstateType(
                                      id int unsigned auto_increment primary key not null,
                                      name varchar(30) not null
);
CREATE TABLE realEstate.BusLine(
                                   id int unsigned auto_increment primary key not null,
                                   name varchar(3) not null
);
CREATE TABLE realEstate.Estate(
                                  id int unsigned auto_increment primary key not null,
                                  price int unsigned not null,
                                  surface double not null,
                                  numberOfRooms int unsigned not null,
                                  typeId int unsigned not null,
                                  foreign key (typeId) references realEstate.EstateType(id),
                                  constructionDate date not null,
                                  conditionId int unsigned not null,
                                  foreign key (conditionId) references realEstate.ConditionType(id),
                                  heatingId int unsigned not null,
                                  foreign key (heatingId) references realEstate.HeatingType(id),
                                  floor int unsigned,
                                  totalFloors int unsigned,
                                  description varchar(500) not null,
                                  advertiserId int unsigned not null,
                                  foreign key (advertiserId) references realEstate.User(id),
                                  streetId int unsigned not null,
                                  foreign key (streetId) references realEstate.Street(id),
                                  streetNumber int unsigned not null,
                                  busLines varchar(40),
                                  images varchar(500) not null
);
CREATE TABLE realEstate.FavouriteUserEstate(
                                               id int unsigned auto_increment primary key not null,
                                               userId int unsigned not null,
                                               foreign key (userId) references realEstate.User(id),
                                               estateId int unsigned not null,
                                               foreign key (estateId) references realEstate.Estate(id)
);
CREATE TABLE realEstate.EstatePerk(
                                      id int unsigned auto_increment primary key not null,
                                      perkId int unsigned not null,
                                      foreign key (perkId) references realEstate.Perk(id),
                                      estateId int unsigned not null,
                                      foreign key (estateId) references realEstate.Estate(id)
);