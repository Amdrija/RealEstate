INSERT INTO realEstate.City(name) VALUES ('Beograd');
SET @BeogradId := (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Municipality(name, cityId) VALUES ('Vračar', @BeogradId);
SET @VracarId := (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Municipality(name, cityId) VALUES ('Novi Beograd', @BeogradId);
SET @NBGId := (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Municipality(name, cityId) VALUES ('Voždovac', @BeogradId);
SET @VozdovacId := (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Municipality(name, cityId) VALUES ('Savski Venac', @BeogradId);
SET @SavskiVenacId := (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Municipality(name, cityId) VALUES ('Dorćol', @BeogradId);
SET @DorcolId := (SELECT LAST_INSERT_ID());

INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Crveni Krst', @VracarId);
SET @CrveniKrstId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Vukov Spomenik', @VracarId);
SET @VukovSpomenikId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Južni bulevar', @VracarId);
SET @JuzniBulevarMicroId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Fontana', @NBGId);
SET @FontanaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Autokomanda', @VozdovacId);
SET @AutokomandaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('Dedinje', @SavskiVenacId);
SET @DedinjeId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.MicroLocation(name, municipalityId) VALUES
    ('25. Maj', @DorcolId);
SET @MAJ25Id = (SELECT LAST_INSERT_ID());

INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Makenzijeva', @CrveniKrstId);
SET @MakenzijevaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Žička', @CrveniKrstId);
SET @ZickaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Bulevar kralja Aleksandra', @VukovSpomenikId);
SET @BulevarId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Generala Rajevskog', @JuzniBulevarMicroId);
SET @GeneralaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Južni Bulevar', @JuzniBulevarMicroId);
SET @JuzniBulevarId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Bulevar Zorana Đinđića', @FontanaId);
SET @DjindjicId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Triše Kaclerovića', @AutokomandaId);
SET @GeneralaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Banjčki Venac', @DedinjeId);
SET @BanjickiVenacId = (SELECT LAST_INSERT_ID());

INSERT INTO realEstate.Street(name, microLocationId) VALUES
    ('Tadeuša Košćuška', @MAJ25Id);


INSERT INTO realEstate.Agency(name, pib, streetId, number) VALUES
                                                               ('Agencija Čardak', '1000525443', @BulevarId, 267),
                                                               ('Jovanović nekretnine', '10006587290', @DjindjicId, 105);
SET @JovanovicNekretnineId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.Agency(name, pib, streetId, number) VALUES
    ('Gold Estate', '10004396481', @JuzniBulevarId, 4);
SET @GoldEstateId = (SELECT LAST_INSERT_ID());

INSERT INTO realEstate.ConditionType(name) VALUES ('Izvorno'), ('Renovirano'), ('LUX');
INSERT INTO realEstate.HeatingType(name) VALUES ('Centralno'), ('Struja'), ('Toplotna pumpa'), ('Pelet'), ('Nafta');
INSERT INTO realEstate.Perk(name) VALUES
                                      ('Terasa'), ('Podrum'), ('Internet'), ('Lođa'), ('Garaža'), ('Interfon'),
                                      ('Francuski balkon'), ('Bašta'), ('Telefon'), ('Lift'), ('Klima');
INSERT INTO realEstate.EstateType(name) VALUES ('Stan'), ('Kuća');
INSERT INTO realEstate.BusLine(name) VALUES
    ('2'),('17'),('18'),('19'),('21'),('22'),('24'),('25'),('26'),('27'),('46'),('55'),('78'),('83'), ('402');

INSERT INTO realEstate.User(firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    ('Andrija', 'Jelenković','andrija','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BeogradId ,'1999-05-25', '+381629762725', 'andrija@email.com', null, null, true, true);
SET @AndrijaId = (SELECT LAST_INSERT_ID());

INSERT INTO realEstate.User(firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    ('Nadežda', 'Obradović','nadja','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BeogradId ,'2000-02-25', '+38169762725', 'nadja@email.com', @GoldEstateId, 2560, true, false);
SET @NadjaId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.User(firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    ('Đorđe', 'Dimitrijević','djordje','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BeogradId ,'1999-05-14', '+38169255725', 'djordje@email.com', @JovanovicNekretnineId, 9780, true, false);
SET @DjoleId = (SELECT LAST_INSERT_ID());
INSERT INTO realEstate.User(firstName, lastName, userName, password, cityId, birthDate, telephone, email, agencyId, licenceNumber, verified, isAdministrator) VALUES
    ('Dodović', 'Matija','doktoric','$2y$10$unL8TXcXCtzR4bKFM4XezeTNSoTkyGoG1SUOPQzJUtm6YrwkFTnIC', @BeogradId ,'1999-08-19', '+38169555333', 'dodara@email.com', null, null, true, false);
SET @DodaId = (SELECT LAST_INSERT_ID());