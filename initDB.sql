CREATE TABLE realEstate.City(
                                id char(36) primary key,
                                name varchar(30) unicode unique not null);
CREATE TABLE realEstate.Municipality(
                                        id char(36) primary key,
                                        name varchar(30) unicode unique not null ,
                                        cityId char(36) not null ,
                                        foreign key (cityId) references realEstate.City(id));
CREATE TABLE realEstate.MicroLocation(
                                         id char(36) primary key,
                                         name varchar(30) unicode unique not null ,
                                         municipalityId char(36) not null ,
                                         foreign key (municipalityId) references realEstate.Municipality(id));
CREATE TABLE realEstate.Street(
                                  id char(36) primary key,
                                  name varchar(100) unicode unique not null ,
                                  microLocationId char(36) not null ,
                                  foreign key (microLocationId) references realEstate.MicroLocation(id));
CREATE TABLE realEstate.Agency(
                                  id char(36) primary key,
                                  name varchar(100) not null,
                                  pib varchar(11) not null unique,
                                  streetId char(36) not null,
                                  number int unsigned not null,
                                  foreign key (streetId) references realEstate.Street(id)
);
CREATE TABLE realEstate.User(
                                id char(36) primary key,
                                firstName varchar(30) not null,
                                lastName varchar(30) not null,
                                userName varchar(30) not null unique,
                                password varchar(255) not null,
                                cityId char(36) not null ,
                                foreign key (cityId) references realEstate.City(id),
                                birthDate date not null,
                                telephone varchar(30) not null,
                                email varchar(255) not null unique,
                                agencyId char(36),
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
                                   id char(36) primary key,
                                   name varchar(3) not null
);
CREATE TABLE realEstate.Estate(
                                  id char(36) primary key,
                                  name varchar(64) not null,
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
                                  advertiserId char(36) not null,
                                  foreign key (advertiserId) references realEstate.User(id),
                                  streetId char(36) not null,
                                  foreign key (streetId) references realEstate.Street(id),
                                  streetNumber int unsigned not null,
                                  busLines varchar(40),
                                  images varchar(500) not null,
                                  dateAdded datetime default current_timestamp not null,
                                  sold bool default false not null,
                                  dateSold datetime null
);
CREATE TABLE realEstate.FavouriteUserEstate(
                                               id int unsigned auto_increment primary key not null,
                                               userId char(36) not null,
                                               foreign key (userId) references realEstate.User(id),
                                               estateId char(36) not null,
                                               foreign key (estateId) references realEstate.Estate(id)
);
CREATE TABLE realEstate.EstatePerk(
                                      id int unsigned auto_increment primary key not null,
                                      perkId int unsigned not null,
                                      foreign key (perkId) references realEstate.Perk(id),
                                      estateId char(36) not null,
                                      foreign key (estateId) references realEstate.Estate(id) on DELETE cascade
);

SET @BelgradeId := (SELECT UUID());
INSERT INTO realEstate.City(id, name) VALUES (@BelgradeId, 'Belgrade');



SET @VracarId := (SELECT UUID());
INSERT INTO realEstate.Municipality(id, name, cityId) VALUES (@VracarId, 'Vračar', @BelgradeId);

SET @NBGId := (SELECT UUID());
INSERT INTO realEstate.Municipality(id, name, cityId) VALUES (@NBGId, 'Novi Belgrade', @BelgradeId);

SET @VozdovacId := (SELECT UUID());
INSERT INTO realEstate.Municipality(id, name, cityId) VALUES (@VozdovacId, 'Voždovac', @BelgradeId);

SET @SavskiVenacId := (SELECT UUID());
INSERT INTO realEstate.Municipality(id, name, cityId) VALUES (@SavskiVenacId, 'Savski Venac', @BelgradeId);

SET @DorcolId := (SELECT UUID());
INSERT INTO realEstate.Municipality(id, name, cityId) VALUES (@DorcolId, 'Dorćol', @BelgradeId);



SET @CrveniKrstId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@CrveniKrstId, 'Crveni Krst', @VracarId);

SET @VukovSpomenikId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@VukovSpomenikId, 'Vukov Spomenik', @VracarId);

SET @JuzniBulevarMicroId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@JuzniBulevarMicroId, 'Južni bulevar', @VracarId);

SET @FontanaId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@FontanaId, 'Fontana', @NBGId);

SET @AutokomandaId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@AutokomandaId, 'Autokomanda', @VozdovacId);

SET @DedinjeId = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@DedinjeId, 'Dedinje', @SavskiVenacId);

SET @MAJ25Id = (SELECT UUID());
INSERT INTO realEstate.MicroLocation(id, name, municipalityId) VALUES
    (@MAJ25Id, '25. Maj', @DorcolId);


SET @MakenzijevaId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@MakenzijevaId, 'Makenzijeva', @CrveniKrstId);

SET @ZickaId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@ZickaId, 'Žička', @CrveniKrstId);

SET @BulevarId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@BulevarId, 'Bulevar kralja Aleksandra', @VukovSpomenikId);

SET @GeneralaId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@GeneralaId, 'Generala Rajevskog', @JuzniBulevarMicroId);

SET @JuzniBulevarId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@JuzniBulevarId, 'Južni Bulevar', @JuzniBulevarMicroId);

SET @DjindjicId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@DjindjicId, 'Bulevar Zorana Đinđića', @FontanaId);

SET @TriseId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@TriseId, 'Triše Kaclerovića', @AutokomandaId);

SET @BanjickiVenacId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@BanjickiVenacId, 'Banjčki Venac', @DedinjeId);

SET @TadeusaId = (SELECT UUID());
INSERT INTO realEstate.Street(id, name, microLocationId) VALUES
    (@TadeusaId, 'Tadeuša Košćuška', @MAJ25Id);



SET @JovanovicNekretnineId = (SELECT UUID());
INSERT INTO realEstate.Agency(id, name, pib, streetId, number) VALUES
                                                                   (UUID(), 'Home Sweet Home', '1000525443', @BulevarId, 267),
                                                                   (@JovanovicNekretnineId, 'Jovanović Real Estate', '10006587290', @DjindjicId, 105);

SET @GoldEstateId = (SELECT UUID());
INSERT INTO realEstate.Agency(id, name, pib, streetId, number) VALUES
    (@GoldEstateId, 'Gold Estate', '10004396481', @JuzniBulevarId, 4);

INSERT INTO realEstate.ConditionType(name) VALUES ('Original'), ('Renovated'), ('LUX');
INSERT INTO realEstate.HeatingType(name) VALUES ('Central Heating'), ('Electricity'), ('Heat pump'), ('Pellets'), ('Oil');
INSERT INTO realEstate.Perk(name) VALUES
                                      ('Teracce'), ('Basement'), ('Internet'), ('Loggia'), ('Garage'), ('Intercom'),
                                      ('French balcony'), ('Garden'), ('Telephone'), ('Elevator'), ('Air conditioning');
INSERT INTO realEstate.EstateType(name) VALUES ('Apartment'), ('House');
INSERT INTO realEstate.BusLine(id, name) VALUES
                                             (UUID(), '2'),(UUID(), '17'),(UUID(), '18'),(UUID(), '19'),
                                             (UUID(), '21'),(UUID(), '22'),(UUID(), '24'),(UUID(), '25'),
                                             (UUID(), '26'),(UUID(), '27'),(UUID(), '46'),(UUID(), '55'),
                                             (UUID(), '78'),(UUID(), '83'), (UUID(), '402');

SET @AndrijaId = (SELECT UUID());
INSERT INTO realEstate.User(id, firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    (@AndrijaId, 'Andrija', 'Jelenković','andrija','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BelgradeId ,'1999-05-25', '+381629762725', 'andrija@email.com', null, null, true, true);

SET @NadjaId = (SELECT UUID());
INSERT INTO realEstate.User(id, firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    (@NadjaId, 'Nadežda', 'Obradović','nadja','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BelgradeId ,'2000-02-25', '+38169762725', 'nadja@email.com', @GoldEstateId, 2560, true, false);

SET @DjoleId = (SELECT UUID());
INSERT INTO realEstate.User(id, firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    (@DjoleId, 'Đorđe', 'Dimitrijević','djordje','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BelgradeId ,'1999-05-14', '+38169255725', 'djordje@email.com', @JovanovicNekretnineId, 9780, true, false);

SET @DodaId = (SELECT UUID());
INSERT INTO realEstate.User(id, firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    (@DodaId, 'Dodović', 'Matija','doktoric','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BelgradeId ,'1999-08-19', '+38169555333', 'dodara@email.com', null, null, true, false);
