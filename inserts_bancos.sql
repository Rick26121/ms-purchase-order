-- INSERTs para tabla bancos
-- Archivo fuente: data.xlsx
-- Total de registros: 384

-- Registro 1
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = '2PI C.A' AND rif = 'J-502199128'), 'BANCO MERCANTIL\nJ-31441424-0\n04245215708', 'CUENTA CORRIENTE:\n01340879318791025263\nSAMUELMORENO12@HOTMAIL.COM\nCÉDULA: V-26260966', NULL);

-- Registro 2
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'A.V. PESAJES BALANZAS, C.A.' AND rif = 'J-403001383'), '0134-0879-3387-9101-8733\nROLANDO CASTILLO\nV-15.447.477', NULL, NULL);

-- Registro 3
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ACEROS LAMINADOS C.A.' AND rif = 'V-24159383'), NULL, NULL, NULL);

-- Registro 4
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ACRILICOS VIRGUEZ' AND rif = 'J-07521779-9'), NULL, NULL, NULL);

-- Registro 5
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'AIR VENCA' AND rif = 'J-40031173-0'), NULL, NULL, NULL);

-- Registro 6
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALFARERIA GRES' AND rif = 'J-08504433-7'), NULL, NULL, NULL);

-- Registro 7
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALQUI EQUIPOS' AND rif = 'J-29454695-1'), 'V-16139542\n0414-5647090\nBANESCO', '0134-0447-03-4471046436\nJ-297727639\nBANESCO', NULL);

-- Registro 8
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALUMINIOS DIALCA C.A' AND rif = 'J-30127551-9'), 'BANCO FONDO COMUN\n04245025081\nJ-30127551-9', 'ALUMINIOS DIALCA\n0134-0879318791000220\nJ-30127551-9', NULL);

-- Registro 9
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALUMINIOS LA CRUZ C.A.' AND rif = 'J-30127551-9'), NULL, NULL, NULL);

-- Registro 10
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'AMAZON' AND rif = 'J-30069347-3'), NULL, NULL, NULL);

-- Registro 11
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ASERRADERO INDUSTRIAL VENEZUELA' AND rif = 'J-08517025-1'), 'V.-7.364.611.\nBNC 0191\n04143529077', 'BANESCO\n0134-0960-9996-0300-7052\nV-12021307', 'V.-7.364.611.\n0191 0060 0710 6011 2128.\n04143529077');

-- Registro 12
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIAL LA COLMENA' AND rif = 'J-31488981-8'), NULL, '0134-1203-1300-01-007863 BANESCO\nJ-31488981-8\nCOMERCIAL LA COLMENA', NULL);

-- Registro 13
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COPIKAG GLOBAL' AND rif = 'J-41089216-1'), 'J-41089216-1\n0412-2467300\nBANCAMIGA', NULL, NULL);

-- Registro 14
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DB ELECTRICA,C.A (C.O.D.E.B.I.C.A. C.A.)' AND rif = 'J-41285038-5'), 'BANESCO\nJ-41285038-5\n04145208761', 'BANESCO\n01340447074471055716\nRIF. J-41285038-5', NULL);

-- Registro 15
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DB ELECTRICA,C.A (C.O.D.E.B.I.C.A. C.A.)' AND rif = 'J-41285038-5'), 'BANESCO\nJ-41285038-5\n04145208761', 'BANESCO\n01340447074471055716\nRIF. J-41285038-5', NULL);

-- Registro 16
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA DEL FRIO, C.A.' AND rif = 'J-50535419-1'), NULL, '0134-1203-19-000101293\nJ-505354191\nBANESCO', NULL);

-- Registro 17
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DR CUEVAS'), NULL, NULL, NULL);

-- Registro 18
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ELECTRO 20'), NULL, NULL, NULL);

-- Registro 19
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA EPA C.A.' AND rif = 'J-00271144-2'), 'MERCANTIL\n0424-4041760\nJ00271144-2', '0134-0467-41-4673026341\nRIF: J-00271144-2\nBANESCO', NULL);

-- Registro 20
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA MST\nCONSTRUFE DEL ESTE'), '\nBANESCO\n0412-0404402\n25.474.075', NULL, NULL);

-- Registro 21
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO CHANYU C.A.' AND rif = 'V-3446028'), 'BANESCO\nJ-305486395\n04245243191', '0134-0475-53-4751013420\nJ-30548639-5\nBANESCO', NULL);

-- Registro 22
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HGM' AND rif = 'J-40931811-7'), 'J409318117\nBanplus\n04245881835', NULL, NULL);

-- Registro 23
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HIERRO EXPRESS' AND rif = 'J-5011564-9'), 'J-501156549\n04247703348\nPROVINCIAL', NULL, NULL);

-- Registro 24
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'IMPORTADORA ARTIKIN' AND rif = 'J-407379038'), NULL, '0134-0218-32-218-1023551\nBANESCO\nV-9623378', NULL);

-- Registro 25
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES NAZAR' AND rif = 'J-50097121-4'), NULL, 'J-50097121-4\n01341203140001009393\nBANESCO', NULL);

-- Registro 26
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ITALMADERAS LARA 22, C.A' AND rif = 'J-40213367-7'), NULL, NULL, 'BANCO PLAZA\n0138-0017-1801-7003-2840\nJ-40213367');

-- Registro 27
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LA CASA DEL ACUEDUCTO C.A.' AND rif = 'J-30791197-2'), 'J-30791197-2\n04145087101\nBANESCO', 'J-30791197-2\nBANESCO\n0134-0326-1932-6300-2988', NULL);

-- Registro 28
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUBRICANTES SULBARAN' AND rif = 'J-31088494-3'), '04245797330\nV13268060\nBANESCO', NULL, NULL);

-- Registro 29
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'M Y D LOGISTICA' AND rif = 'J-40602410-4'), 'BANCAMIGA\nJ-40602410-4\n04145947826', NULL, NULL);

-- Registro 30
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MADETOR' AND rif = 'J-07540970-1'), NULL, '0134-1000-32-0001006253\nJ-07540970-1\nBANESCO', NULL);

-- Registro 31
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MANGOCENTER, C.A.' AND rif = 'J-29968295-0'), 'PLAZA\nRIF J-29968295-0\n04145497191', 'MANGOCENTER\nRIF J-29968295-0\n0134-0219-1121-9104-4452', NULL);

-- Registro 32
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES Y DECORACIONES MG, C.A' AND rif = 'J-31113278-3'), NULL, '0134-1000-3200-0100-2624\nRif J-31113278-3', NULL);

-- Registro 33
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MERCADO LIBRE'), 'Provincial \n17397902\n04124082611', NULL, NULL);

-- Registro 34
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MI SITIO EN LINEA'), NULL, 'V-15.805.871\n0412-2809292\n0134-0879-35-8793000406', NULL);

-- Registro 35
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OTROS'), NULL, NULL, NULL);

-- Registro 36
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PINTURAS BENAVIDES S.A. (CABUDARE)' AND rif = 'J-29599191-6'), 'BANESCO\n0414-5293591\nJ-29599191-6', NULL, NULL);

-- Registro 37
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PORTUMANIA'), '04245474516\n17858804\nmercantil', NULL, NULL);

-- Registro 38
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REFRIGERACION EL NECTAR' AND rif = 'J-50222202-2'), NULL, 'Banesco  \n01340209412093029057\nV-8055074', NULL);

-- Registro 39
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REPARACIONES MENDOZA' AND rif = 'V-19697585'), '04126778563\nV-19697585\nVENEZUELA', NULL, NULL);

-- Registro 40
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ROLIAUTO LARA C.A.' AND rif = 'J-30714396-7'), '04143528850\nV27666448\nBANCAMIGA', NULL, NULL);

-- Registro 41
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SARVEN C.A.' AND rif = 'J-408142490'), 'Mercantil\nCI: 12.559.375 \nTeléfono: 0412-4740965', NULL, NULL);

-- Registro 42
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SERVICIO TECNICO BJM' AND rif = 'J-31373001-7'), '04245738609\nV-19928421\nprovincial', NULL, NULL);

-- Registro 43
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TODOTUBO DEL CENTRO C.A.' AND rif = 'J-31613114-9'), NULL, 'J-316131149\n0134-0447-0344-7103-7171', NULL);

-- Registro 44
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TOTAL TOOLS' AND rif = 'J-502091807'), NULL, '0134-0326-1132-6111-3025\nJ-502091807', NULL);

-- Registro 45
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VAL-PLAST' AND rif = 'J-50086639-9'), 'BANESCO\n04145090848\nJ-50086639-9', '0134-0326-12-3261115971\nJ-50086639-9', NULL);

-- Registro 46
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VICTOR MANUEL LOUREIRO PEREIRA' AND rif = 'V-7420084'), '04245197702\nV-7420084\nprovincial', NULL, NULL);

-- Registro 47
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTIMAX STORE, C.A.' AND rif = 'J-50226790-5'), NULL, 'BANESCO\nJ-50226790-5\n0134-0319-8831-91111161', NULL);

-- Registro 48
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETAZO, C.A.' AND rif = 'J-50242530-6'), 'BANCO NACIONAL DE CREDITO\nV-7453192\n04245479402', NULL, NULL);

-- Registro 49
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INNOVALED C.A.' AND rif = 'J-406112658'), NULL, 'J-40611265-8\nBANESCO\n0134-1000-37-000-1013756', NULL);

-- Registro 50
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES BURBUJAS 21 CA' AND rif = 'J-317317661'), 'PROVINCIAL\nE-83606499\n04141576025', NULL, NULL);

-- Registro 51
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES FRIO DEL ESTE CA' AND rif = 'J-500257384'), 'BANESCO\nV-12249873\n04245176236', NULL, NULL);

-- Registro 52
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO ASIA CENTER' AND rif = 'J-40547456-4'), 'PROVINCIAL\nRIF E-82110025\n04126745388', 'PROVINCIAL\nRIF E-82110025\n0108-2413-3401-0004-1121', NULL);

-- Registro 53
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PORTUMANIA' AND rif = 'J-40037478-2'), 'PAGO MOVIL\nBANESCO\nJ311739939\n0424-5742459', NULL, NULL);

-- Registro 54
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES MAXI 2005,C.A' AND rif = 'J-31173993-9'), 'BANESCO\nJ311739939\n0424-5742459', NULL, NULL);

-- Registro 55
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GUAROVISION' AND rif = 'J-31658603-0'), 'BANCO PLAZA\nJ-316586030\n0424-5725510', NULL, NULL);

-- Registro 56
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMPUMORENO'), '04168526174\n16525079\nMercantil', NULL, NULL);

-- Registro 57
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA PORTUGUESA' AND rif = 'J-08500659-1'), 'BANESCO\n04143533747\nJ-08500659-1', 'BANESCO\n0134-0004-1500-4106-3851\nJ-08500659-1', NULL);

-- Registro 58
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TELEPILA CENTER C.A' AND rif = 'J-31558886-2'), 'BANESCO\nJ-31558886-2\n0414-5193620', 'TELEPILA CENTER\n0134-0326-10-3261099037\nJ-31558886-2', NULL);

-- Registro 59
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA RELAMPAGO C.A.' AND rif = 'J-309488767'), '04143500055\nV 16403319\nMercantil (0105)', 'BANESCO\n0134-0218-3621-8102-1005\nV-16403319', NULL);

-- Registro 60
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FIDEMA' AND rif = 'J-40208515-0'), 'BANESCO\nJ-40208515-0\n04123038856', NULL, NULL);

-- Registro 61
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SEIPCA' AND rif = 'J-504557218'), 'PROVINCIAL\n0414-5373173\nJ-504557218', 'PROVINCIAL\n0108-0087-18-0100499171\nJ-504557218', NULL);

-- Registro 62
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANTONELLA BUONO'), NULL, NULL, NULL);

-- Registro 63
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DIANA FREITAS MERCADO LIBRE' AND rif = 'V-30782748'), 'Banco BANESCO\n04244688343\nV-30782748', NULL, NULL);

-- Registro 64
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSORA SAN LORENZO' AND rif = 'V-01124110-3'), NULL, NULL, NULL);

-- Registro 65
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REFRI SERVICIOS D GONZALEZ II' AND rif = 'J-50654606-0'), 'Banco activo\n04245657470\nV-18019598', NULL, NULL);

-- Registro 66
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SUMINISTROS ELECTRICOS G&L' AND rif = 'J-40512807-8'), NULL, 'BANESCO\n0134-0960-9796-0101-8542\nJ-40512807-0', 'PROVINCIAL\n0108-2456-7801-0017-0651\nJ-40512807-0');

-- Registro 67
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MZ INGENIERIA' AND rif = 'J-29827511-1'), NULL, 'BANESCO\n01340447024471048826\nJ-29827511-1', NULL);

-- Registro 68
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES ELECTRICOS Y CONSTRUCCIONES VENELCO CA' AND rif = 'J-50083771-2'), NULL, 'Bancamiga\n01720302983028206492\nRif J-50083771-2', 'Banco Provincial 01080087130100457630\nRif J-50083771-2');

-- Registro 69
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SERVICIOS PACIFICO, C.A.' AND rif = 'J-31109672-8'), 'PROVINCIAL\n04145031430\nV-4034344', NULL, NULL);

-- Registro 70
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA KATINAPO S.R.L.' AND rif = 'J-30220709-6'), 'PROVINCIAL\n04145455051\nV-17859827', NULL, NULL);

-- Registro 71
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MRW NUEVA SEGOVIA'), 'PROVINCIAL\n04245661467\nV-9609518', NULL, NULL);

-- Registro 72
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CORPORACION GOLAR DE VENEZUELA' AND rif = 'J-29821261-6'), NULL, 'BANESCO\n0134-0326-103261101868\nRif J-29821261-6', NULL);

-- Registro 73
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIAL FERREMUNDO' AND rif = 'J-295436203'), NULL, NULL, NULL);

-- Registro 74
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FEDEVEN C.A.' AND rif = 'J-29895043-9'), '0414-5300666\n16.002.950\nMercantil', NULL, NULL);

-- Registro 75
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INTER C.A.'), '12699046\n04265519081\nBanesco', NULL, NULL);

-- Registro 76
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CORPORACION DCM. C.A' AND rif = 'J-40444575-7'), 'Banesco\n0426-1514424\nV-26.006.214', NULL, NULL);

-- Registro 77
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ISIRACDP, C.A' AND rif = 'J-29696704-0'), '04265572883\n13543261\nBanesco', 'V-13543261\n0134-0960-9896-01003885', NULL);

-- Registro 78
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MEGATORCA'), 'VENEZUELA\nV-13211524\n04143523947', NULL, NULL);

-- Registro 79
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREMORAN C.A.' AND rif = 'J-40255590-3'), 'V-21128024\n04245931203\n100% banco', NULL, NULL);

-- Registro 80
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ECODIGITAL C.A.' AND rif = 'J-30672652-7'), 'J-30672652-7\n04125290089\nPROVINCIAL', NULL, NULL);

-- Registro 81
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANDRES MENDEZ' AND rif = 'V-9613965'), 'V-9613965 \n04245181868\nVenezolano de credito', 'V-9613965\n01040058910580081592 \nCC Venezolano de Credito', NULL);

-- Registro 82
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VIPSOLUCIONES' AND rif = 'V-25293519'), 'V-25293519 \n04126973555\nBanesco', 'Cuenta Banesco\nCorriente \n0134-1203-17-0001008881\nCarlos Espinel \n25293519 \n04126973555', NULL);

-- Registro 83
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RR INTEC' AND rif = 'V-17194164'), 'V-17194164\n04245665517\nBANESCO', '01340326173261102710\nV-17194164\n04245665517\nBANESCO\nEMMA RANGEL', NULL);

-- Registro 84
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CANGURO' AND rif = 'J-500455577'), 'J-500455577\n04128019844\nBANCAMIGA', NULL, NULL);

-- Registro 85
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TORNI RODA BARQUISIMETO' AND rif = 'J-50025738-4'), NULL, NULL, NULL);

-- Registro 86
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TORNILLOS LARA' AND rif = 'J-08501144-7'), 'J085011447\n04143503142\nPROVINCIAL', NULL, NULL);

-- Registro 87
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REDCURSOS C.A.' AND rif = 'J-29725765-9'), 'V-11696752\n04145208860\nBanesco', NULL, NULL);

-- Registro 88
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SERVICIOS Y SOLUCIONS TECNOLOGICAS C.A.' AND rif = 'J-29788645-1'), 'V- 12.780.262\n04245610687\nBanesco', '01340447054473024514\nV- 12.780.262\n04245610687\nBanesco\nRafael Arismendi', NULL);

-- Registro 89
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PINTURAS Y SUMINISTROS ZG' AND rif = 'J-50064170-2'), NULL, 'J-50064170-2\n01340960989601018158\n04120795168', NULL);

-- Registro 90
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CARJUED SERVICIOS GENERALES' AND rif = 'J-40527713-0'), 'V-17.308.959\n Banesco  \n0426.957.65.79', NULL, NULL);

-- Registro 91
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FILTROS J.J.S. LARA' AND rif = 'J-40979788-0'), '0426.957.65.79"', NULL, NULL);

-- Registro 92
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JORGE ZAMBRANO'), 'V-11495183\nBanesco \n04145251298', NULL, NULL);

-- Registro 93
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CARPITAP' AND rif = 'J-08520384-2'), 'V-20929496 \n04145606148\nBANESCO \nJORGE ANKA', NULL, NULL);

-- Registro 94
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WILKER ANTONIO CASTILLO JUAREZ' AND rif = 'V-29604455'), '04127542977\n29604455\nVENEZUELA', NULL, NULL);

-- Registro 95
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE ROJAS' AND rif = 'V-10854956'), '10854956 \n04245803793\nBanesco', NULL, NULL);

-- Registro 96
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PIOVESAN C.A' AND rif = 'J-311059393'), 'PIOVESAN C.A.\n0134-0218312183006951\nJ-08503518-4', NULL, NULL);

-- Registro 97
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CRISTALERIA GABY'), 'BANESCO\n0424-5683887\nV-7432409', '0134-0326-1532-6111-1988\nV-7432409\nGABRIELA FIORIN', NULL);

-- Registro 98
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MAYRA DURAN CISTERNA' AND rif = 'V-9620913'), NULL, 'MAYRA DURAN\nV-9620913\n0134-0864558641012244', NULL);

-- Registro 99
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUMINARIA DIODI'), '0134 BANESCO\nRIF J504069906\n04144316553', 'BANESCO\n0134-0447-0744-7105-9880\nRIF J504069906', NULL);

-- Registro 100
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FIBRA DE MADERA DE LARA C.A.' AND rif = 'J-30543164-7'), 'J-305431647\n04145251021\nBANESCO', NULL, NULL);

-- Registro 101
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MECICA' AND rif = 'J-40654772-7'), NULL, 'BANESCO\n0134-0218-3421-8102-2768\nV-24.185.236', NULL);

-- Registro 102
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LA BOMBILLERIA DEL ESTE'), 'VENEZUELA\nJ-500292910\n04145105363', 'LA BOMBILLERIA DEL ESTE, C.A\n‎RIF J-500292910\n‎CTA CORRIENTE\n‎BCO VENEZUELA\n‎01020862900000330709', NULL);

-- Registro 103
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTISERVICIOS YEPEZ CA' AND rif = 'J-31589425-4'), NULL, NULL, NULL);

-- Registro 104
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MUNDO CARPINTERO' AND rif = 'J-0356628-0'), NULL, 'Banco nacional de crédito\n0191-0073-1221-7306-3730\nRif:J-50356628-0\nMundo carpintero c.a.', NULL);

-- Registro 105
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'METROTELAS CA' AND rif = 'J402396791'), NULL, NULL, NULL);

-- Registro 106
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES DE ABREU' AND rif = 'J-29503690-6'), NULL, 'BANESCO \n0134-1000-36-0001000627\nRif J-29503690-6', NULL);

-- Registro 107
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ROBERTO COSENTINO' AND rif = 'V-4386344'), 'Provincial \nV-4.386.344 \n0414-5589905 \n', 'Provincial \n0108-2433-8801-0022-9480 \nV-4.386.344 \n', NULL);

-- Registro 108
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HOME READY DEL ESTE' AND rif = 'J-412763725-5'), NULL, NULL, NULL);

-- Registro 109
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES SOSA 19,11, CA' AND rif = 'J-403992231'), NULL, NULL, NULL);

-- Registro 110
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DAIRON CAMPANAS'), 'C.I 15.352.302\nTlf: 0412-2648176\nBanco provincial', 'Jammy  Arias \nC.I 15.352.302\nTlf: 0412-2648176\nBanco provincial\n01082407960100132965', NULL);

-- Registro 111
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRAPHIC CENTER'), NULL, 'ALIRIO LACLE BANESCO\nV-18479758\n0134-0864-57-86-41006913', NULL);

-- Registro 112
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ELECTRONICA NUEVA SION C.A.' AND rif = 'J-50383913-9'), '04245029872 \n16641112\nVenezolano de credito', NULL, NULL);

-- Registro 113
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WOLF TECH'), 'PAGO MOVIL\nV.19.482.113\n0412-152-82-74\nMERCANTIL', NULL, NULL);

-- Registro 114
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'KENEDY AGRELA'), NULL, NULL, NULL);

-- Registro 115
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'THELMO PEREZ VIELMA' AND rif = 'V-9882722'), NULL, 'Banesco Banco Universal\n0134-0447-08-4471061104\nC. I.   V-9882722\nTHELMO PEREZ VIELMA', NULL);

-- Registro 116
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FRIO DEL ESTE'), 'V-12249873\n04245176236\nBANESCO', NULL, NULL);

-- Registro 117
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RUEDAS Y MAS RUEDAS, C.A.' AND rif = 'J-302984831'), 'BANESCO\n04143507610\nJ-302984831', NULL, NULL);

-- Registro 118
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PINTURAS BENAVIDES S.A. (CENTRO)' AND rif = 'J-31105939-3'), 'BANESCO\nJ-31105939-3\n04245549193', NULL, NULL);

-- Registro 119
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OMAR ROJAS REFRIGERACION'), 'V-17858499 \n04245441755\nBanco fondo común', NULL, NULL);

-- Registro 120
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EL PUNTO DEL HIERRO' AND rif = 'J-501287759'), NULL, 'Banesco\n0134-0447-00-4471059805\nJ-501287759', NULL);

-- Registro 121
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FUTURE WATER C.A.' AND rif = 'J-50101229-6'), NULL, 'Futurewater c.a\nJ-501.012.296\n0134-1203-13-0001008950', NULL);

-- Registro 122
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'IMPORTADORA OCCIDENTAL DE VENEZUELA, CA' AND rif = 'J-31210923-8'), 'Banco del tesoro\nJ-312109238\n04125152484', NULL, NULL);

-- Registro 123
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SEIPCA LARA NOTA DE ENTREGA'), 'V-19779621\n04125766832\nPROVINCIAL', NULL, NULL);

-- Registro 124
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTISERVICIOS ARW' AND rif = 'J-40744878-1'), NULL, NULL, NULL);

-- Registro 125
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETANQUES H2O' AND rif = 'J-41096157-0'), 'J-41096157-0\n04145230853\nBANCO DIGITAL DE LOS TRABAJADORES', NULL, NULL);

-- Registro 126
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EXPO FRIO C.A.' AND rif = 'J-29362839-3'), 'BANCO DE VENEZUELA\nJ293628393\n04265517387', 'Expo frio ca \nJ293628393\n01020312100000028118', NULL);

-- Registro 127
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SONIMAX MOVIL' AND rif = 'V33165177'), 'BANESCO\nV33165177\n04128257589', 'BANESCO\nV33165177\n01340960999601017132', NULL);

-- Registro 128
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'BALDOLARA C.A' AND rif = 'J-30426773-8'), 'J-304267738\nBANPLUS\n04166504055', NULL, NULL);

-- Registro 129
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = '3113 REPRESENTACIONES' AND rif = 'J-29450944-4'), '0416-6512545 \nV-14.696.801\nBancamiga', 'V14696801\n01720302953028153447\nBANCAMIGA', NULL);

-- Registro 130
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VICTOR JOSE RODRIGUEZ C.A.' AND rif = 'J-08505667-0'), 'MERCANTIL\nJ-08505667-0\n04245351432', NULL, NULL);

-- Registro 131
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES LA GUARIQUEÑA'), 'V-15811002\nBANCO EXTERIOR\n04145793640', NULL, NULL);

-- Registro 132
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIALIZADORA 1368 C.A' AND rif = 'J-29850272-0'), NULL, 'BANESCO\n01340416014161017423\nJ298502720\nCOMERCIALIZADORA 1368', NULL);

-- Registro 133
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EMA CARS'), '04245431079\n17191184\nBancamiga', NULL, NULL);

-- Registro 134
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'P.P.F, C.A (P.P.F, C.A)\n' AND rif = 'J501106746'), NULL, 'BANESCO\n01340326173261112539\nJ501106746\nP.P.F.C.A.', 'PROVINCIAL\n01082401080100436015\nJ501106746\nP.P.F.C.A.');

-- Registro 135
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIAL SAFA MUNDO' AND rif = 'J-405626607'), NULL, '0134-1203-1300-0100-3277\nJ-405626607', NULL);

-- Registro 136
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CENTRO CONSTRURAMA, C. A,' AND rif = 'J-40637490-3'), NULL, 'J-40637490-3\n0134-0395-3139-51029938', NULL);

-- Registro 137
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREELECTRICA DEL ESTE, C.A.' AND rif = 'J295931930'), NULL, '0134-0416-0541-6102-4076\nJ-295931930', NULL);

-- Registro 138
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO HIERROCA LARA C.A.' AND rif = 'J501156549'), '04247703348\nJ501156549\nPROVINCIAL', NULL, NULL);

-- Registro 139
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALFARERIA INALVENSA'), 'BANCO NACIONAL DE CREDITO\n04145018103\nV-16898156', NULL, NULL);

-- Registro 140
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARCO ALVAREZ' AND rif = 'V-17860613'), NULL, '0134-1031-3100-0300-0858\nV-17.860.613\nMarco Álvarez', NULL);

-- Registro 141
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SONIA FERNANDEZ FERNANDEZ' AND rif = 'V-13435096'), NULL, '0134-0326-14-3262033669\nV-13435096', NULL);

-- Registro 142
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREDETAL'), 'V7317066\n0412.0579004\nBanesco', NULL, NULL);

-- Registro 143
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUIS PEREZ' AND rif = 'V-7433003-9'), '04245798188  \nV12020824\n Venezuela', NULL, NULL);

-- Registro 144
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'AIRES VENEZUELA (AIRVENCA)' AND rif = 'J-31003960-7'), NULL, NULL, NULL);

-- Registro 145
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ARCOSAN BARQUISIMETO' AND rif = 'J-085185330'), 'PROVINCIAL\n0414-5185028\nJ-085185330', 'J-085185330\n0108-2431-1001-0000-2930', NULL);

-- Registro 146
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DJM SISTEMAS DE SEGURIDAD' AND rif = 'V20351420'), 'BANCO BANESCO\nV20351420\n04245256978\n', NULL, NULL);

-- Registro 147
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALFREDO ANTONIO PARADA COLMENAREZ' AND rif = 'V-11792933'), '0414 5303488 \n11.792.933 \nBanesco', NULL, NULL);

-- Registro 148
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OMAIRA INSTALACIONES'), '13776768 \nBanco provincial \n 04245087293', NULL, NULL);

-- Registro 149
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUBRI REPUESTOS LA 17 CA' AND rif = 'J411202711'), NULL, NULL, NULL);

-- Registro 150
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES FERREMETAL' AND rif = 'J503142189'), NULL, 'Banesco\n01340416004161028746\nJ503142189\n', NULL);

-- Registro 151
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REFRI-CORP'), NULL, 'BANESCO\n0134-0447-03-4471062152\nJ-50219308-1', NULL);

-- Registro 152
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GILBERTO FLORES' AND rif = 'V25838554'), 'V25838554\n04147355803\nBANESCO', 'BANCO DE VENEZUELA\n01020180240000036210\nJesus Mendoza \n16859927', NULL);

-- Registro 153
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TODO RUEDAS' AND rif = 'J-50680407-7'), 'BANCO DE VENEZUELA\nV-12248163\n04125080448', NULL, NULL);

-- Registro 154
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PLASTIC PLANET' AND rif = 'J-40209043-9'), 'BANESCO\nV-17625048\n04145122094', NULL, NULL);

-- Registro 155
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTISERVICIOS RUSO FRIO' AND rif = 'V-24397601-0'), '24397601\nprovincial\n04122376012', NULL, NULL);

-- Registro 156
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CONTROLES LARA' AND rif = 'J301168712'), 'BANESCO\nJ301168712\n04245566511', NULL, NULL);

-- Registro 157
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RODDY PERAZA' AND rif = 'V17572546'), 'BANCO DE VENEZUELA\nV-17572546\n04261522192', NULL, NULL);

-- Registro 158
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MAPLOCA C.A' AND rif = 'J-000244995'), NULL, 'MAPLOCA\nJ-000244995\n0134-0389-9238-9103-5283', NULL);

-- Registro 159
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CARMEN VILLEGAS' AND rif = 'V-15319136'), '15319136 \nBanesco \n04146594657', NULL, NULL);

-- Registro 160
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ERICK RIVAS' AND rif = 'V-22783060'), 'BNC\n22783060\n04129892393', NULL, NULL);

-- Registro 161
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CASTEL LARA' AND rif = 'J-50261973-9'), NULL, '0134-1089-51-000100-8327\nSUPERFICIES LARA\nJ-50261973-9', NULL);

-- Registro 162
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA DUNCAN C.A.' AND rif = 'J085007636'), '0414-3502529\nJ-85007636\nBANESCO\n', NULL, NULL);

-- Registro 163
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VIDEO Y SONIDO CENTER C.A.' AND rif = 'J-29700068-2'), NULL, NULL, NULL);

-- Registro 164
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREMAX BQTO, CA' AND rif = 'J-50036520-9'), 'BANESCO\nJ-500365209\n04147969123', '0134-0218-3621-81024616\nJ-500365209\nBANCO BANESCO', NULL);

-- Registro 165
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TECH SOLUTION STORE CA' AND rif = 'V-15491963'), 'BNC\n15.491.963\n0414-5591333', NULL, NULL);

-- Registro 166
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JONATHAN JOSE VILLEGAS HERNANDEZ' AND rif = 'V-20350140'), 'BANESCO\n04245829091\nV-20350140', NULL, NULL);

-- Registro 167
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOHANNA ANDREA PAREDES GIMENEZ' AND rif = 'V-18421047'), '04245433645 \n18421047\nMercantil', NULL, NULL);

-- Registro 168
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VirtualPC Electronic' AND rif = 'V-18356666'), 'Provincial\n04245387081\nV-18356666\n', NULL, NULL);

-- Registro 169
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA D''AIR, C.A' AND rif = 'J-08517503-2'), 'BANCO BANESCO\nJ-08517503-2\n04245030372', NULL, NULL);

-- Registro 170
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GIUSEPPE VERDE' AND rif = 'V-7418030'), NULL, 'BANCO PROVINCIAL\nV-7418030\n0108-2401-02-0100346237', NULL);

-- Registro 171
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CORPORACION SAN ROQUE'), NULL, NULL, NULL);

-- Registro 172
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SOLO LED' AND rif = 'J-40978166-6'), 'BANCO BANESCO\nJ-409781666\n04245998838', 'J-40978166-6\n0134-0416-094161027539\nBANESCO', NULL);

-- Registro 173
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'NILSON JAVIER HERNANDEZ' AND rif = 'V14482711'), 'BANCO PROVINCIAL\n04145691441\nV-14482711', NULL, NULL);

-- Registro 174
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TODO GOMAS LONVIER C.A' AND rif = 'J-500257384'), NULL, NULL, NULL);

-- Registro 175
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TORNERIA'), 'CI 14879074\nTlf 04245700744\nProvincial', NULL, NULL);

-- Registro 176
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JEALIROS CARUCI GIL' AND rif = 'V-14879574'), 'BANESCO\n04145185537\n14879574', NULL, NULL);

-- Registro 177
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREMATERIALES CASTELLANOS' AND rif = 'J-500257384'), NULL, NULL, NULL);

-- Registro 178
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE PINTURAS LA 50'), NULL, NULL, NULL);

-- Registro 179
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RELEVEN, C.A.' AND rif = 'J-41094282-7'), NULL, NULL, NULL);

-- Registro 180
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OSYDAR DISTRIBUIDORA, C.A' AND rif = 'J-300254569'), NULL, NULL, NULL);

-- Registro 181
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HIDROIN, C.A' AND rif = 'J-30660707-2'), NULL, NULL, NULL);

-- Registro 182
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TORNILLERIA LA VIEJA' AND rif = 'J-50082134-4'), 'Banesco\nJ500821344\n04165015056', NULL, NULL);

-- Registro 183
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ARAGAS C.A'), NULL, NULL, NULL);

-- Registro 184
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO ITAPVEN, C.A.' AND rif = 'J-50030712-8'), NULL, 'BANESCO\n0134-0354-6835-4102-1310\nJ-50030712-8', NULL);

-- Registro 185
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE NEWLINK' AND rif = 'V-12565647'), 'PROVINCIAL\nV-12565647\n0416-6439955', NULL, NULL);

-- Registro 186
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES WTS C.A' AND rif = 'V-13786098'), 'BANESCO\nV-13786098\n04245237158', NULL, NULL);

-- Registro 187
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'Technology Store' AND rif = 'V-27346695'), 'BANESCO\n0412-864002\nV-27346695', NULL, NULL);

-- Registro 188
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARIELENA CAROLINA MUJICA GOMEZ\n' AND rif = 'V-24925680'), 'BANESCO\n04145280452\n24925680', NULL, NULL);

-- Registro 189
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ZONA TECNO C.A' AND rif = 'V-13905167'), 'BANESCO\n0414-5143262\nV13905167', NULL, NULL);

-- Registro 190
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SYM REPRESENTACIONES' AND rif = 'J-40612434-6'), 'PROVINCIAL\nV15599445\n04245303402', NULL, NULL);

-- Registro 191
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MUESCA EVENTOS C.A' AND rif = 'J-40074511-0'), 'J-40074511-0\nBanesco\n0424-5209145', NULL, NULL);

-- Registro 192
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JORGE HERNANDEZ' AND rif = 'V15729866'), 'Banesco\n15729866\n04145381123', 'Banesco\nCuenta Corriente\n01340960959601012046\nJorge Hernandez\nV15729866\nJorgehernandezb@gmail.com', NULL);

-- Registro 193
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HIDROTUBERIA DH' AND rif = 'J-50416571-9'), NULL, 'Banesco\n0134-0416-06-4161027955\nV-12699214\nDARLING JOSEFINA HERRERA PEREZ', NULL);

-- Registro 194
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TOTAL TOOLS CENTRO' AND rif = 'J-50350319-0'), NULL, 'BANESCO\n0134-0326-1932-6111-5178\nJ-50350319-0', NULL);

-- Registro 195
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CORP. ESPERANZA DE ELECTRODOMESTICOS' AND rif = 'J-30975798-9'), NULL, NULL, NULL);

-- Registro 196
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CINDY - TRENDY HOUSE'), NULL, NULL, NULL);

-- Registro 197
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ITAlMADERAS LARA, C.A'), NULL, NULL, NULL);

-- Registro 198
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'KAMAL SERVICE' AND rif = 'J-505007211'), '\nC.I. 16.898.190\n04245153819\nBANCO: Banesco', NULL, NULL);

-- Registro 199
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EL CANGURO, C.A.'), 'BANCAMIGA\n0424-1206466\nJ-308565202', NULL, NULL);

-- Registro 200
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTIMUEBLES EK'), '18.861.357\n04245393294\nMercantil', NULL, NULL);

-- Registro 201
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE LEONARDO RODRIGUEZ' AND rif = 'V-19165991'), 'BANESCO\n19165991\n04143543307', NULL, NULL);

-- Registro 202
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MERCANTIL FABULOSO' AND rif = 'E-82239242'), 'BANESCO\n0412-1545231\nE-82239242\n', NULL, NULL);

-- Registro 203
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REFRIPARTES LARA, C.A.' AND rif = 'J-08517503-2'), 'BANESCO\n04245030372\nJ-085175032', 'BANESCO\n0134-1203-1500-0100-1219\nJ-085175032', NULL);

-- Registro 204
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WU JIN JUN' AND rif = 'V17618710'), NULL, 'BANESCO\n0134-0429-114293019125\nV-17618710', NULL);

-- Registro 205
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FUEGOTEXT SISTEMAS C.A.' AND rif = 'J-40772342-1'), 'Banesco \nC.I 17.011.496\nTelf: 0414/5285242', 'PROVINCIAL\n0108-2432-0101-0017-2076\nFUEGOTEXT SISTEMAS, C.A\nRIF: J-40772342-1', 'Banesco \n0134-0326-19-3261111762\nJahzeel Gonzalez\nC.I 17.011.496');

-- Registro 206
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'AGRO- INSUMOS MATA GARRAPATA, C.A'), NULL, NULL, NULL);

-- Registro 207
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE PINTURAS LA 50, C.A' AND rif = 'J-504301485'), 'BANPLUS\nJ-50430148-5\n04145143246', NULL, NULL);

-- Registro 208
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CRISTAL CENTER'), NULL, NULL, NULL);

-- Registro 209
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FABIOLA ANDREINA PASTRAN REINOSO' AND rif = 'V-20186834'), 'V-20186834\n04145643648\nPROVINCIAL', NULL, NULL);

-- Registro 210
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIAL CASTILLO' AND rif = 'J-08532046-6'), 'BANCO MERCANTIL\n04143508557\nV-9557748', 'BANESCO\n0134-0326-13-3261111555\nV-9620352', NULL);

-- Registro 211
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OFFICENET SUMINISTROS Y TECNOLOGIA C.A' AND rif = 'J-40345070-6'), NULL, 'BANESCO\n0134-1031-39-0001006888\nJ-40345070-6', NULL);

-- Registro 212
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DAKA'), NULL, NULL, NULL);

-- Registro 213
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FARMACIA LA 55 DE BQTO, C.A.' AND rif = 'J-500278152'), NULL, NULL, NULL);

-- Registro 214
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LANDYS ANTONIO PINEDA CARUCI' AND rif = 'V-15003857-6'), '15003857\n 04245594013 \nProvincial', NULL, NULL);

-- Registro 215
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE TECH 2024 C.A.' AND rif = 'J-50737791-1'), 'BANCO DE VENEZUELA\n04243399303\nJ-50737791-1', NULL, NULL);

-- Registro 216
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LA CASA DEL ASFALTO' AND rif = 'J-31378616-0'), NULL, 'BANESCO\n0134-0326-11-3261102199\nJ-313786160', NULL);

-- Registro 217
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES PINTAPEG, C.A' AND rif = 'J-412724576'), 'Banesco\nJ- 412724576\n0426-5196026', NULL, NULL);

-- Registro 218
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CARLOS OROPEZA' AND rif = 'V-14376622'), 'BANCO PROVINCIAL\n0416-6469014\nV-14376622', 'BANCO PROVINCIAL \nV-14376622\nCTA CORRIENTE\n01082432030100048251', NULL);

-- Registro 219
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OCEAN´S' AND rif = 'J-500999828'), NULL, NULL, NULL);

-- Registro 220
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OFICINAS TECNICAS PEREZ ARAUJO' AND rif = 'J-178730114'), 'V-17873011\n04245213978\nBANESCO', 'V-17873011\n0134-1000-36-0001005519', NULL);

-- Registro 221
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES ELECTRONIC JNC 2016 CA (MERCADO LIBRE)' AND rif = 'J-41242479-3'), NULL, '01340193401931082602\nJ-41242479-3', NULL);

-- Registro 222
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA OLIN LA 55'), 'BANCO DE VENEZUELA\nV-17853140\n04120515100', NULL, NULL);

-- Registro 223
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'AUTOMARKET VENEZUELA'), 'Provincial\n26.820.035\n0424-5799795', NULL, NULL);

-- Registro 224
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO FRAGA C.A.' AND rif = 'J-40229463-8'), 'BANCO DE VENEZUELA\nJ-40229463-8\n04245155385', NULL, NULL);

-- Registro 225
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA LA CONCORDIA CA' AND rif = 'J-31114922-8'), NULL, 'BANCO BANESCO\n01341203150001003293\nJ-31114922-8', NULL);

-- Registro 226
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ELECTRO INDUSTRIAL BIONDI, C.A.' AND rif = 'J-30566676-8'), NULL, NULL, NULL);

-- Registro 227
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CORPORACION GRUPO SIGMA, C.A.' AND rif = 'J-40707875-5'), NULL, NULL, NULL);

-- Registro 228
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'H.S. CRISTALES 2030, C.A' AND rif = 'J-50301164-5'), 'PROVINCIAL \nV-16324851\n04245898132', NULL, NULL);

-- Registro 229
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'IMPORTADORA EL TIO AMMI II, C.A' AND rif = 'J-500374461'), NULL, NULL, NULL);

-- Registro 230
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CONSTRUHOGAR FERRETERIA C.A' AND rif = 'J-504544116'), NULL, NULL, NULL);

-- Registro 231
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CASPERSU SEGURIDAD INDUSTRIAL C.A' AND rif = 'V-16260862'), 'PROVINCIAL \nV-16260862\n04245019417', 'BANCO PROVICIAL \n01080019690100148092\nV-16260862', NULL);

-- Registro 232
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DANY KARAM'), NULL, NULL, NULL);

-- Registro 233
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES CP 2017, C.A.' AND rif = 'J-41176825-1'), '21126771\n04145670593\nBancamiga', NULL, NULL);

-- Registro 234
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREBOMBAS' AND rif = 'J-407587757'), 'J-407587757\n042635956277\nBANCO DE VENEZUELA', NULL, NULL);

-- Registro 235
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERROMETAL, C.A.' AND rif = 'J-31692366-5'), '0414-4158930\nCI: 12.108.622\nBanesco', NULL, NULL);

-- Registro 236
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EL PUNTO DE FRIO'), 'V-19263451\n04245885488\nVENEZUELA', NULL, NULL);

-- Registro 237
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EVER BIANEY BRICEÑO MARIN' AND rif = 'V-20187406'), '04145382354 \nV-20187406\nBanco venezuela', NULL, NULL);

-- Registro 238
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PINTURAS BARRETO, C.A.' AND rif = 'J-50100626-1'), 'BANESCO\nJ-50100626-1\n04248197238', NULL, NULL);

-- Registro 239
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OTROS' AND rif = 'E84397276'), 'MERCANTIL\nE84397276\n04145268370', NULL, NULL);

-- Registro 240
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SEGURINET C.A' AND rif = 'V-19883773'), 'V-19883773 \nBANESCO\n0412-0532016', 'J406277991 SEGURITY NETWORW CA \nN° Cuenta: 0156-0035-71-0201919305\n100% BANCO', NULL);

-- Registro 241
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OTROSS' AND rif = 'V-19727259'), 'V-19727259\nBANESCO\n0424-5756131', NULL, NULL);

-- Registro 242
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SIANDRE DECOR EL ROSAL, C.A' AND rif = 'J-296121915'), NULL, 'J-296121915\nBANESCO\n01340031800311152674', NULL);

-- Registro 243
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUIS PEREZ ARENA' AND rif = 'V-7433003'), 'V-7433003\nVENEZUELA\n0424-5528603', NULL, NULL);

-- Registro 244
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REFRIGERACION DAIR' AND rif = 'V-22322517'), 'V-22322517\nPROVINCIAL \n0424-5972545', NULL, NULL);

-- Registro 245
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CESAR PEREIRA' AND rif = 'V-21126771'), 'V-21126771\nBANCAMIGA\n04145670593', NULL, NULL);

-- Registro 246
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CESAR ENRIQUE VELIZ BRAVO' AND rif = 'V-26540929'), '26540929\nBanesco\n04245856237', NULL, NULL);

-- Registro 247
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TECHOLAND MIRANDA LP, C.A.' AND rif = 'J-294850707'), NULL, 'BANESCO\n0134-0798-30-7981000778\nJ-29485070-7', NULL);

-- Registro 248
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE ANTONIO BRICEÑO' AND rif = 'V-11900541'), NULL, NULL, NULL);

-- Registro 249
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO CHERRY 2015, C.A.' AND rif = 'J-40567389-3'), NULL, NULL, NULL);

-- Registro 250
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES MAZDARENO'), NULL, NULL, NULL);

-- Registro 251
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LA ERA DEL HIELO'), NULL, NULL, NULL);

-- Registro 252
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MAYOR DE SILLAS VENEZUELA'), NULL, NULL, NULL);

-- Registro 253
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES ZAMZIBAR' AND rif = 'J-40846089-0'), NULL, NULL, NULL);

-- Registro 254
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DIANA LUZ ESPINOZA CAMACARO' AND rif = 'V-3446028'), 'MERCANTIL\n04125184010\nV-3446028', NULL, NULL);

-- Registro 255
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MATERIALES SOCI'), 'Venezuela \nV-10.775.405 \n0414 5210199.', NULL, NULL);

-- Registro 256
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SERVICRISTAL LARA'), 'Banesco\n0414 5145883 \nV-7.884.169.', NULL, NULL);

-- Registro 257
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COLCHONES BARQUISIMETO' AND rif = 'J-500278705'), 'PROVINCIAL\nV-7317066\n04120579004', NULL, NULL);

-- Registro 258
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EDGAR ENRIQUE FARIAS RIVAS' AND rif = 'V9626050'), 'BANCO VENEZOLANO DE CREDITO \nV9626050\n04149502743', NULL, NULL);

-- Registro 259
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VIVERO LARA'), NULL, NULL, NULL);

-- Registro 260
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'BRUTS STORE' AND rif = 'V-10380316'), 'Banesco\nV-10380316\n0412-2555611', 'Musset Brutus \nV10380316\n0134-0375-97-3751006364', NULL);

-- Registro 261
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREGRANITO' AND rif = 'J-30979025-0'), NULL, '0134-0416-0141-6102-0032\nJ-30979025-0', NULL);

-- Registro 262
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INFIVENITY' AND rif = 'V-16242507'), 'Banesco\n04144296637\nJUAN RUNQUE\nV-16242507', NULL, NULL);

-- Registro 263
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMPUTRABAJO'), NULL, NULL, NULL);

-- Registro 264
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ORANGEL MECANICO' AND rif = 'V9266573'), '04149503112\nV 9266573\nBanesco', NULL, NULL);

-- Registro 265
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES BARUCH 2851 C,A.'), NULL, NULL, NULL);

-- Registro 266
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OTROS - FLETE'), '04145253411\n V-11785211 \n Banesco', NULL, NULL);

-- Registro 267
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GIGABYTE STORE, C.A' AND rif = 'J507488394'), 'Provincial\nV-16585485 \n04145160236', NULL, NULL);

-- Registro 268
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VENEGROUP'), NULL, NULL, NULL);

-- Registro 269
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ECO TECHNE'), 'E-82.229.550\nBanco banesco \n0414-5233501', '0134-0326-11-3261100685\nE-82.229.550\nBanco banesco', NULL);

-- Registro 270
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'TIJERAZO'), NULL, NULL, NULL);

-- Registro 271
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE DAVID DE ANDRADE' AND rif = 'V-18862639'), 'Venezuela \n04245045395 \nV-18862639', 'BANCO DE VENEZUELA\n0102-0422-41-0000575373\nV18862639', NULL);

-- Registro 272
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ESPACIO ELECTRONIC' AND rif = 'V-18628957'), 'PROVINCIAL\n18628957\n04128205628\nARTURO VILLEGAS\n', NULL, NULL);

-- Registro 273
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREMATE' AND rif = 'J-29840192-3'), 'FERRE-MATE\nJ-29840192-3\n04245491855\nPROVINCIAL', NULL, NULL);

-- Registro 274
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GLOBAL TRUCKS SERVICE'), NULL, NULL, NULL);

-- Registro 275
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EQUIP OFFICE' AND rif = 'J-306148973'), NULL, '01340385643851001157\nJ-306148973\nBANCO BANESCO', NULL);

-- Registro 276
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA MADEIRA'), 'Provincial \n17.307.376 \n0414 0550651', NULL, NULL);

-- Registro 277
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CRISTALES GABY C.A' AND rif = 'V-16300787'), 'V-16300787\n0424-5459920\nPROVINCIAL', NULL, NULL);

-- Registro 278
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO ACERINOX PARRILLERAS'), 'Banesco\nV-11.787.876\n0416.656.85.17', '0134 0416 0041 6301 4133\nBanesco\nV-11.787.876', NULL);

-- Registro 279
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIALIZADORA LOPEZ 2018, C.A'), NULL, NULL, NULL);

-- Registro 280
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WIPE' AND rif = 'J-41276372-2'), 'BANPLUS\nJ-41276372-5\n04147644831', NULL, NULL);

-- Registro 281
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GRUPO RIO 2016' AND rif = 'J-40846251-6'), NULL, NULL, NULL);

-- Registro 282
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA CAMELLOT' AND rif = 'J-304320612'), NULL, '0134-1203-1100-0100-7170\nJ-304320612\nDISTRIBUIDORA CAMELOT', NULL);

-- Registro 283
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CALENTADORES BARQUISIMETO'), NULL, NULL, NULL);

-- Registro 284
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'M.P CAUCHOS' AND rif = 'J-293495016'), NULL, NULL, NULL);

-- Registro 285
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DAYANA TORRES' AND rif = 'V-12128185'), NULL, NULL, NULL);

-- Registro 286
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANGEL LUIS GONZALEZ' AND rif = 'V-30345363'), NULL, NULL, NULL);

-- Registro 287
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VECONINTER C.A'), NULL, NULL, NULL);

-- Registro 288
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SANDRO SIMON GONSALEZ LOPEZ' AND rif = 'V-9618286'), NULL, NULL, NULL);

-- Registro 289
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MULTISERV DON VICTOR C.A'), NULL, NULL, NULL);

-- Registro 290
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANAIS MERLENE RAMIREZ' AND rif = 'V-17853140'), NULL, NULL, NULL);

-- Registro 291
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIAL FERRE MUNDO' AND rif = 'J-295436203'), NULL, NULL, NULL);

-- Registro 292
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE PINTURAS NAZAR, C.A' AND rif = 'J-50339181-2'), 'BANCO DE VENEZUELA\nJ-50339181-2\n04245035573', NULL, NULL);

-- Registro 293
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RODYLSA ELECTROHIDRAULICA' AND rif = 'J-410523786'), NULL, NULL, NULL);

-- Registro 294
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SANDRA DEL CARMEN RAMOS SEGOVIA' AND rif = 'V-11132486'), 'BANCO PROVINCIAL\nV-11132486\n04143509730', NULL, NULL);

-- Registro 295
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'RENY ALBERTO PEREZ' AND rif = 'V-17873011'), NULL, NULL, NULL);

-- Registro 296
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COBARCA' AND rif = 'J-500278705'), NULL, NULL, NULL);

-- Registro 297
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LINDA CAROLINA ROJAS MENDEZ'), NULL, NULL, NULL);

-- Registro 298
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JAMMY MAYE ARIAS LINAREZ' AND rif = 'V-153523025'), NULL, NULL, NULL);

-- Registro 299
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DECOR & ZEN 2022 C.A.' AND rif = 'J-50249155-4'), NULL, NULL, NULL);

-- Registro 300
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FRANKLIN SUAREZ' AND rif = 'V-19348615'), NULL, NULL, NULL);

-- Registro 301
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE URDANETA' AND rif = 'V-10840201'), NULL, NULL, NULL);

-- Registro 302
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'COMERCIALIZADORA GARCIA, C.A.' AND rif = 'J-30308326-9'), 'Pago movil \n0414 5670055 \n15.384.029 \nBanesco', NULL, NULL);

-- Registro 303
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'REPRESENTACIONES Y DISTRIBUCIONES ZARIKIAN , C.A.' AND rif = 'J-00081762-6'), NULL, 'BANCO NACIONAL DE CREDITO\n0191-0062-6221-6200-2844\nRIF. J-00081762-6', NULL);

-- Registro 304
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VIVEROS NUEVA SEGOVIA'), NULL, NULL, NULL);

-- Registro 305
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VIDRIO TEX' AND rif = 'V-18120611'), '04146292031\n18120611\nBANCO PLAZA', NULL, NULL);

-- Registro 306
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MANUEL POLIURETANO' AND rif = 'V-6297913'), 'PROVINCIAL\n6297913 \n04145112250', NULL, NULL);

-- Registro 307
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SANTA ANA 2018, C.A' AND rif = 'J-411231444'), NULL, NULL, NULL);

-- Registro 308
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES JORDAY' AND rif = 'J-403843627'), 'BANPLUS\n19686129\n04145451558', NULL, NULL);

-- Registro 309
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JULIO CESAR BARRETO SANTELIZ' AND rif = 'V-7443524'), 'V-7443524\n 04145243434 \nBanco venezolano de crédito', NULL, NULL);

-- Registro 310
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EYLEEN ALESKA TIMAURE' AND rif = 'V-30872626'), NULL, NULL, NULL);

-- Registro 311
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GERARDO BARAZARTE ASUAJE' AND rif = 'V-24159893'), NULL, NULL, NULL);

-- Registro 312
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CARLOS SIMON VELIZ' AND rif = 'V-13856324'), 'V-13856324\n04145780627\nPROVINCIAL', NULL, NULL);

-- Registro 313
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PATRICIA FERNANDEZ FERNANDEZ'), NULL, NULL, NULL);

-- Registro 314
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CONSAGRO LARA, C.A.' AND rif = 'J-50263215-8'), 'J-50263215-8\nBANESCO\n04244349027', 'CONSAGRO LARA\n0134-1089-5200-0100-8326\nJ-502632158', NULL);

-- Registro 315
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'C.A. TELARES DE PALO GRANDE' AND rif = 'J-00036157-6'), NULL, 'J-00036157-6\n0108-0032-3401-00040829', NULL);

-- Registro 316
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'OXINITRO, C.A.' AND rif = 'J-50101186-9'), NULL, 'BANESCO\nJ-50101186-9\n0134-0447-01-4471059043', NULL);

-- Registro 317
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRETERIA CAMILA C.A.' AND rif = 'J-31139857-0'), 'PROVINCIAL\n04145173739\nJ-311398570', NULL, NULL);

-- Registro 318
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES LUCKY 28, C.A'), NULL, NULL, NULL);

-- Registro 319
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'YESENIA PIEDRA' AND rif = 'V-19165765'), 'MERCANTIL\nV19165765\n04245591570', NULL, NULL);

-- Registro 320
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ERICKZON CAMPOS MARTINEZ' AND rif = 'V-21143656'), NULL, NULL, NULL);

-- Registro 321
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DESIREE ROSANGELA ARENAS DURAN' AND rif = 'V-19727259'), '19727259 \n04245756131 \nBanesco', NULL, NULL);

-- Registro 322
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARIA FERNANDA REGUEIRO LUQUE'), NULL, NULL, NULL);

-- Registro 323
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'KATHERINE CRISTINA IDROGO PEREZ' AND rif = 'V-17625124'), NULL, '01082416870100240775 \nV-17625124', NULL);

-- Registro 324
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ROBERTO FERRETERO'), NULL, NULL, NULL);

-- Registro 325
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EDGARD FELIPE GIL D` SANTIAGO\n' AND rif = 'V13775994'), 'V-13775994\n04245200906\nMERCANTIL', NULL, NULL);

-- Registro 326
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MUEBLERIA HOME ELEGANT' AND rif = 'J-50570754-0'), '04145147706 \n21311878\nProvincial', NULL, NULL);

-- Registro 327
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'YONGER JOSE TUA CASTILLO' AND rif = 'V-15265481'), '04141587502\nV-15265480\nBANESCO', NULL, NULL);

-- Registro 328
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUIS EDUARDO SUAREZ' AND rif = 'V178598275'), NULL, NULL, NULL);

-- Registro 329
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WILLIAN CELESTINO TORRES PACHECO' AND rif = 'V073548140'), NULL, NULL, NULL);

-- Registro 330
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FILTROS TRANSALCA, C.A.' AND rif = 'J504112330'), NULL, NULL, NULL);

-- Registro 331
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LUIS EDGARDO PEREZ HERNANDEZ\n' AND rif = 'V140045604'), NULL, NULL, NULL);

-- Registro 332
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ALBERTO ENRIQUE ARGENTINO MICELI\n' AND rif = 'V096164404'), NULL, NULL, NULL);

-- Registro 333
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JEAN CARLOS ARANGUREN CEDEÑO' AND rif = 'V160853332'), '04245136552\n16085333\nVENEZUELA', NULL, NULL);

-- Registro 334
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARJORIE ELIZABETH CASTILLO\n' AND rif = 'V157585297'), 'Banesco\n04245948627\n15758529', NULL, NULL);

-- Registro 335
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARISELA YULIANA ROJAS PINEDA' AND rif = 'V-17993775'), '17993775\n04125183084 \nPROVINCIAL', NULL, NULL);

-- Registro 336
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'EMPRENDIMIENTO ANA PERDIGON (EMPRENDIMIENTO ANA PERDIGON)\n' AND rif = 'J507216446'), NULL, NULL, NULL);

-- Registro 337
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FRANCO LANZILLOTTI CEDEÑO\n' AND rif = 'V128502803'), NULL, NULL, NULL);

-- Registro 338
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'GERARDO BARAZARTE AZUAJE\n' AND rif = 'V241598930'), NULL, NULL, NULL);

-- Registro 339
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'CENTRO DE REPARACION CA (CENTRO DE REPARACION CA)\n' AND rif = 'J310581240'), NULL, NULL, NULL);

-- Registro 340
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'BANYAN AUDIO Y SONIDO' AND rif = 'J-31222537-8'), 'BANCAMIGA\nJ-31222537-8\n04140732806', NULL, NULL);

-- Registro 341
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANGGY DAYANA ANCIANI DE LINAREZ' AND rif = 'V-17378090'), '0134-0960-94-9601017661\nV-17378090\nANGGY DAYANA ANCIANI DE LINAREZ', NULL, NULL);

-- Registro 342
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE MUEBLES EK, C.A.' AND rif = 'J501236879'), NULL, NULL, NULL);

-- Registro 343
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'UMESH KISHEN TAURANI' AND rif = 'V-252639019'), NULL, NULL, NULL);

-- Registro 344
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DISTRIBUIDORA DIBROCA, C.A.' AND rif = 'J-41096157-0'), NULL, 'BANESCO\nJ-41096157-0\n0134-0447-05-4471056785', NULL);

-- Registro 345
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LEBIS CORDERO' AND rif = 'V052591674'), NULL, NULL, NULL);

-- Registro 346
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PGP IMAGEN CREATIVA, C.A.' AND rif = 'J-29549512-9'), 'BANESCO\nV-13543146\n04145654395', NULL, NULL);

-- Registro 347
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JUSTIN ALFREDO ARIAS PEREZ' AND rif = 'V-28338968-1'), '28338968\n04241210972\nBancamiga', NULL, NULL);

-- Registro 348
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JUAN CARLOS RODRIGUEZ SEQUERA' AND rif = 'V-117852110'), 'BANESCO\n11785211\n0414 5253411', NULL, NULL);

-- Registro 349
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JORGE LUIS GOMEZ BORAURE' AND rif = 'V-107727708'), NULL, NULL, NULL);

-- Registro 350
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SYRIANA VALENTINA DOMINGUEZ RODRIGUEZ' AND rif = 'V-321217997'), NULL, NULL, NULL);

-- Registro 351
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MIGUEL DE SAN MARTIN' AND rif = 'V-15599937'), NULL, 'Banesco\n0134-0864-56-8641014065\nV-15599937', NULL);

-- Registro 352
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREONLINE'), 'V-14696426\n04145097711\nPROVINCIAL', NULL, NULL);

-- Registro 353
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LAMINAIRE C.A.' AND rif = 'J-40709163-8'), NULL, '0108-2457-55-0100134464\n J-40709163-8\nPROVINCIAL', NULL);

-- Registro 354
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'Victor Granado'), NULL, NULL, NULL);

-- Registro 355
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ASERRADERO LOS JUANES' AND rif = 'J-50722252-7'), '04121665220\nJ507222527\nBanco exterior', '01150035871006710757\nJ507222527\nBanco exterior', NULL);

-- Registro 356
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JESUS ANTONIO RODRIGUEZ SUAREZ' AND rif = 'V-40309628'), NULL, NULL, NULL);

-- Registro 357
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'WILLIAN HAROLDO CENTENO RODRIGUEZ' AND rif = 'V-201760972'), NULL, NULL, NULL);

-- Registro 358
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'VANESSA CAROLINA ALVARADO SANCHEZ' AND rif = 'V-172278619'), NULL, NULL, NULL);

-- Registro 359
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'DIESELINE C.A' AND rif = 'J-30062530-3'), NULL, NULL, NULL);

-- Registro 360
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'LAMINADOS Y MADERAS ARAGUANEY C.A.' AND rif = 'J-50411946-6'), NULL, 'J-504119466\n0108-0944-48-0100031011', NULL);

-- Registro 361
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'NORMA DE JESUS EREU PACHECO' AND rif = 'V-5260634'), NULL, NULL, NULL);

-- Registro 362
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREDETAL LOS BARRETO'), 'PROVINCIAL\nV-7317066\n04120579004', NULL, NULL);

-- Registro 363
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MARLY JOHANA BASTIDAS VILLAREAL' AND rif = 'V-197957588'), NULL, NULL, NULL);

-- Registro 364
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE GREGORIO PAEZ' AND rif = 'V-175327815'), NULL, NULL, NULL);

-- Registro 365
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JESUS GABRIEL GOMEZ RAMOS' AND rif = 'V-268310602'), NULL, NULL, NULL);

-- Registro 366
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANAIS MARLENE RAMIREZ COLMENAREZ' AND rif = 'V-17853140'), 'BANCO DE VENEZUELA\nV-17853140\n04120515100', NULL, NULL);

-- Registro 367
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'PEDRO PABLO ALMAZAN LATIEGUE' AND rif = 'V-176256830'), NULL, NULL, NULL);

-- Registro 368
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'HOME STYLE 1442, C,A' AND rif = 'J-500913257'), NULL, NULL, NULL);

-- Registro 369
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES JK 8102, C,A,' AND rif = 'J-50069198-0'), 'Banesco\nE-84415801\n04122964754', NULL, NULL);

-- Registro 370
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES JOMARCA C.A' AND rif = 'J296279063'), 'J296279063\nBanesco\n04128957836', 'Inversiones Jomarca, C. A\n01340325283251054275\nJ296279063', NULL);

-- Registro 371
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ACRILUM' AND rif = 'J-302698367'), 'BANCO DEL TESORO\nJ-302698367\n04125520191', NULL, NULL);

-- Registro 372
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANDREINA VALLES' AND rif = 'V-24772981'), '24772981\n0412-1732071 \nBNC', NULL, NULL);

-- Registro 373
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ELBER JAHIR TORRES SALAS' AND rif = 'V-239178355'), NULL, NULL, NULL);

-- Registro 374
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JOSE GREGORIO ALVAREZ CUICAS' AND rif = 'V-25715867'), NULL, NULL, NULL);

-- Registro 375
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'JAVIER ERIK PEREZ RIVERO' AND rif = 'V-209275984'), NULL, NULL, NULL);

-- Registro 376
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ORLANDO JOSE PEREZ MONTILLA' AND rif = 'V-120279730'), NULL, NULL, NULL);

-- Registro 377
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'INVERSIONES RTT, C.A. (INVERSIONES RTT, C.A.)\n' AND rif = 'J312728817'), 'BANESCO\n04122500907\nJ312728817', 'BANESCO\n01341031300001005196\nJ312728817', NULL);

-- Registro 378
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'MOISES ELI MEDINA BULLONES' AND rif = 'V21726314'), '21726314\nProvincial \n04245674529', NULL, NULL);

-- Registro 379
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ANTONY ENRIQUE GUTIERREZ SUAREZ' AND rif = 'V-254740752'), NULL, NULL, NULL);

-- Registro 380
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'SUMINISTROS MCI 2019 C.A.' AND rif = 'V-13777975'), '13777975\n04245562735\n0108 (provincial)', NULL, NULL);

-- Registro 381
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERREMATERIALES VENELCO, C.A' AND rif = 'J-50600166-7'), 'Banco de Venezuela\n01020422430001494628\nJ-50600166-7\nFERREMATERIALES VENELCO CA', 'Banco Provincial\n01080087150100580939\nJ-50600166-7\nFERREMATERIALES VENELCO CA', NULL);

-- Registro 382
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'ELECTRONICA NUEVA SION,\nC.A.' AND rif = 'J-503839139'), 'V-16641112\nBanco nacional de credito \n04245029872', NULL, NULL);

-- Registro 383
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'YSOLINA DEL CARMEN SALCEDO PARRA' AND rif = 'V-10906764'), '04145347145\n10906764\nProvincial', NULL, NULL);

-- Registro 384
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
VALUES ((SELECT id_proveedor FROM proveedores WHERE nombre = 'FERRE- ELECTRICA ALFA, CA.' AND rif = 'J-29837465-9'), 'BANESCO\nJ-29837465-9\n04145527815', NULL, NULL);

