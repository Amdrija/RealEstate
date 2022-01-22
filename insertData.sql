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
