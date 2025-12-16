-- INSERTs para tabla bancos
-- Total: 271

INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO MERCANTIL\nJ-31441424-0\n04245215708', 'CUENTA CORRIENTE:\n01340879318791025263\nSAMUELMORENO12@HOTMAIL.COM\nCÉDULA: V-26260966', NULL
FROM proveedores 
WHERE nombre = '2PI C.A' AND rif = 'J-502199128';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0134-0879-3387-9101-8733\nROLANDO CASTILLO\nV-15.447.477', NULL, NULL
FROM proveedores 
WHERE nombre = 'A.V. PESAJES BALANZAS, C.A.' AND rif = 'J-403001383';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-16139542\n0414-5647090\nBANESCO', '0134-0447-03-4471046436\nJ-297727639\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'ALQUI EQUIPOS' AND rif = 'J-29454695-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO FONDO COMUN\n04245025081\nJ-30127551-9', 'ALUMINIOS DIALCA\n0134-0879318791000220\nJ-30127551-9', NULL
FROM proveedores 
WHERE nombre = 'ALUMINIOS DIALCA C.A' AND rif = 'J-30127551-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V.-7.364.611.\nBNC 0191\n04143529077', 'BANESCO\n0134-0960-9996-0300-7052\nV-12021307', 'V.-7.364.611.\n0191 0060 0710 6011 2128.\n04143529077'
FROM proveedores 
WHERE nombre = 'ASERRADERO INDUSTRIAL VENEZUELA' AND rif = 'J-08517025-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1203-1300-01-007863 BANESCO\nJ-31488981-8\nCOMERCIAL LA COLMENA', NULL
FROM proveedores 
WHERE nombre = 'COMERCIAL LA COLMENA' AND rif = 'J-31488981-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-41089216-1\n0412-2467300\nBANCAMIGA', NULL, NULL
FROM proveedores 
WHERE nombre = 'COPIKAG GLOBAL' AND rif = 'J-41089216-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-41285038-5\n04145208761', 'BANESCO\n01340447074471055716\nRIF. J-41285038-5', NULL
FROM proveedores 
WHERE nombre = 'DB ELECTRICA,C.A (C.O.D.E.B.I.C.A. C.A.)' AND rif = 'J-41285038-5';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-41285038-5\n04145208761', 'BANESCO\n01340447074471055716\nRIF. J-41285038-5', NULL
FROM proveedores 
WHERE nombre = 'DB ELECTRICA,C.A (C.O.D.E.B.I.C.A. C.A.)' AND rif = 'J-41285038-5';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1203-19-000101293\nJ-505354191\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA DEL FRIO, C.A.' AND rif = 'J-50535419-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'MERCANTIL\n0424-4041760\nJ00271144-2', '0134-0467-41-4673026341\nRIF: J-00271144-2\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA EPA C.A.' AND rif = 'J-00271144-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '\nBANESCO\n0412-0404402\n25.474.075', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA MST\nCONSTRUFE DEL ESTE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-305486395\n04245243191', '0134-0475-53-4751013420\nJ-30548639-5\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'GRUPO CHANYU C.A.' AND rif = 'V-3446028';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J409318117\nBanplus\n04245881835', NULL, NULL
FROM proveedores 
WHERE nombre = 'HGM' AND rif = 'J-40931811-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-501156549\n04247703348\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'HIERRO EXPRESS' AND rif = 'J-5011564-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-0218-32-218-1023551\nBANESCO\nV-9623378', NULL
FROM proveedores 
WHERE nombre = 'IMPORTADORA ARTIKIN' AND rif = 'J-407379038';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-50097121-4\n01341203140001009393\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES NAZAR' AND rif = 'J-50097121-4';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, NULL, 'BANCO PLAZA\n0138-0017-1801-7003-2840\nJ-40213367'
FROM proveedores 
WHERE nombre = 'ITALMADERAS LARA 22, C.A' AND rif = 'J-40213367-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-30791197-2\n04145087101\nBANESCO', 'J-30791197-2\nBANESCO\n0134-0326-1932-6300-2988', NULL
FROM proveedores 
WHERE nombre = 'LA CASA DEL ACUEDUCTO C.A.' AND rif = 'J-30791197-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245797330\nV13268060\nBANESCO', NULL, NULL
FROM proveedores 
WHERE nombre = 'LUBRICANTES SULBARAN' AND rif = 'J-31088494-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCAMIGA\nJ-40602410-4\n04145947826', NULL, NULL
FROM proveedores 
WHERE nombre = 'M Y D LOGISTICA' AND rif = 'J-40602410-4';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1000-32-0001006253\nJ-07540970-1\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'MADETOR' AND rif = 'J-07540970-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PLAZA\nRIF J-29968295-0\n04145497191', 'MANGOCENTER\nRIF J-29968295-0\n0134-0219-1121-9104-4452', NULL
FROM proveedores 
WHERE nombre = 'MANGOCENTER, C.A.' AND rif = 'J-29968295-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1000-3200-0100-2624\nRif J-31113278-3', NULL
FROM proveedores 
WHERE nombre = 'MATERIALES Y DECORACIONES MG, C.A' AND rif = 'J-31113278-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial \n17397902\n04124082611', NULL, NULL
FROM proveedores 
WHERE nombre = 'MERCADO LIBRE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'V-15.805.871\n0412-2809292\n0134-0879-35-8793000406', NULL
FROM proveedores 
WHERE nombre = 'MI SITIO EN LINEA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n0414-5293591\nJ-29599191-6', NULL, NULL
FROM proveedores 
WHERE nombre = 'PINTURAS BENAVIDES S.A. (CABUDARE)' AND rif = 'J-29599191-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245474516\n17858804\nmercantil', NULL, NULL
FROM proveedores 
WHERE nombre = 'PORTUMANIA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco  \n01340209412093029057\nV-8055074', NULL
FROM proveedores 
WHERE nombre = 'REFRIGERACION EL NECTAR' AND rif = 'J-50222202-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04126778563\nV-19697585\nVENEZUELA', NULL, NULL
FROM proveedores 
WHERE nombre = 'REPARACIONES MENDOZA' AND rif = 'V-19697585';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04143528850\nV27666448\nBANCAMIGA', NULL, NULL
FROM proveedores 
WHERE nombre = 'ROLIAUTO LARA C.A.' AND rif = 'J-30714396-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Mercantil\nCI: 12.559.375 \nTeléfono: 0412-4740965', NULL, NULL
FROM proveedores 
WHERE nombre = 'SARVEN C.A.' AND rif = 'J-408142490';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245738609\nV-19928421\nprovincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'SERVICIO TECNICO BJM' AND rif = 'J-31373001-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-316131149\n0134-0447-0344-7103-7171', NULL
FROM proveedores 
WHERE nombre = 'TODOTUBO DEL CENTRO C.A.' AND rif = 'J-31613114-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-0326-1132-6111-3025\nJ-502091807', NULL
FROM proveedores 
WHERE nombre = 'TOTAL TOOLS' AND rif = 'J-502091807';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04145090848\nJ-50086639-9', '0134-0326-12-3261115971\nJ-50086639-9', NULL
FROM proveedores 
WHERE nombre = 'VAL-PLAST' AND rif = 'J-50086639-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245197702\nV-7420084\nprovincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'VICTOR MANUEL LOUREIRO PEREIRA' AND rif = 'V-7420084';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\nJ-50226790-5\n0134-0319-8831-91111161', NULL
FROM proveedores 
WHERE nombre = 'MULTIMAX STORE, C.A.' AND rif = 'J-50226790-5';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO NACIONAL DE CREDITO\nV-7453192\n04245479402', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETAZO, C.A.' AND rif = 'J-50242530-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-40611265-8\nBANESCO\n0134-1000-37-000-1013756', NULL
FROM proveedores 
WHERE nombre = 'INNOVALED C.A.' AND rif = 'J-406112658';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nE-83606499\n04141576025', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES BURBUJAS 21 CA' AND rif = 'J-317317661';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nV-12249873\n04245176236', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES FRIO DEL ESTE CA' AND rif = 'J-500257384';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nRIF E-82110025\n04126745388', 'PROVINCIAL\nRIF E-82110025\n0108-2413-3401-0004-1121', NULL
FROM proveedores 
WHERE nombre = 'GRUPO ASIA CENTER' AND rif = 'J-40547456-4';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PAGO MOVIL\nBANESCO\nJ311739939\n0424-5742459', NULL, NULL
FROM proveedores 
WHERE nombre = 'PORTUMANIA' AND rif = 'J-40037478-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ311739939\n0424-5742459', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES MAXI 2005,C.A' AND rif = 'J-31173993-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO PLAZA\nJ-316586030\n0424-5725510', NULL, NULL
FROM proveedores 
WHERE nombre = 'GUAROVISION' AND rif = 'J-31658603-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04168526174\n16525079\nMercantil', NULL, NULL
FROM proveedores 
WHERE nombre = 'COMPUMORENO' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04143533747\nJ-08500659-1', 'BANESCO\n0134-0004-1500-4106-3851\nJ-08500659-1', NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA PORTUGUESA' AND rif = 'J-08500659-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-31558886-2\n0414-5193620', 'TELEPILA CENTER\n0134-0326-10-3261099037\nJ-31558886-2', NULL
FROM proveedores 
WHERE nombre = 'TELEPILA CENTER C.A' AND rif = 'J-31558886-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04143500055\nV 16403319\nMercantil (0105)', 'BANESCO\n0134-0218-3621-8102-1005\nV-16403319', NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA RELAMPAGO C.A.' AND rif = 'J-309488767';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-40208515-0\n04123038856', NULL, NULL
FROM proveedores 
WHERE nombre = 'FIDEMA' AND rif = 'J-40208515-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n0414-5373173\nJ-504557218', 'PROVINCIAL\n0108-0087-18-0100499171\nJ-504557218', NULL
FROM proveedores 
WHERE nombre = 'SEIPCA' AND rif = 'J-504557218';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banco BANESCO\n04244688343\nV-30782748', NULL, NULL
FROM proveedores 
WHERE nombre = 'DIANA FREITAS MERCADO LIBRE' AND rif = 'V-30782748';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banco activo\n04245657470\nV-18019598', NULL, NULL
FROM proveedores 
WHERE nombre = 'REFRI SERVICIOS D GONZALEZ II' AND rif = 'J-50654606-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0960-9796-0101-8542\nJ-40512807-0', 'PROVINCIAL\n0108-2456-7801-0017-0651\nJ-40512807-0'
FROM proveedores 
WHERE nombre = 'SUMINISTROS ELECTRICOS G&L' AND rif = 'J-40512807-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n01340447024471048826\nJ-29827511-1', NULL
FROM proveedores 
WHERE nombre = 'MZ INGENIERIA' AND rif = 'J-29827511-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Bancamiga\n01720302983028206492\nRif J-50083771-2', 'Banco Provincial 01080087130100457630\nRif J-50083771-2'
FROM proveedores 
WHERE nombre = 'MATERIALES ELECTRICOS Y CONSTRUCCIONES VENELCO CA' AND rif = 'J-50083771-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n04145031430\nV-4034344', NULL, NULL
FROM proveedores 
WHERE nombre = 'SERVICIOS PACIFICO, C.A.' AND rif = 'J-31109672-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n04145455051\nV-17859827', NULL, NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA KATINAPO S.R.L.' AND rif = 'J-30220709-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n04245661467\nV-9609518', NULL, NULL
FROM proveedores 
WHERE nombre = 'MRW NUEVA SEGOVIA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0326-103261101868\nRif J-29821261-6', NULL
FROM proveedores 
WHERE nombre = 'CORPORACION GOLAR DE VENEZUELA' AND rif = 'J-29821261-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0414-5300666\n16.002.950\nMercantil', NULL, NULL
FROM proveedores 
WHERE nombre = 'FEDEVEN C.A.' AND rif = 'J-29895043-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '12699046\n04265519081\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'INTER C.A.' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\n0426-1514424\nV-26.006.214', NULL, NULL
FROM proveedores 
WHERE nombre = 'CORPORACION DCM. C.A' AND rif = 'J-40444575-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04265572883\n13543261\nBanesco', 'V-13543261\n0134-0960-9896-01003885', NULL
FROM proveedores 
WHERE nombre = 'ISIRACDP, C.A' AND rif = 'J-29696704-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'VENEZUELA\nV-13211524\n04143523947', NULL, NULL
FROM proveedores 
WHERE nombre = 'MEGATORCA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-21128024\n04245931203\n100% banco', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREMORAN C.A.' AND rif = 'J-40255590-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-30672652-7\n04125290089\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'ECODIGITAL C.A.' AND rif = 'J-30672652-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-9613965 \n04245181868\nVenezolano de credito', 'V-9613965\n01040058910580081592 \nCC Venezolano de Credito', NULL
FROM proveedores 
WHERE nombre = 'ANDRES MENDEZ' AND rif = 'V-9613965';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-25293519 \n04126973555\nBanesco', 'Cuenta Banesco\nCorriente \n0134-1203-17-0001008881\nCarlos Espinel \n25293519 \n04126973555', NULL
FROM proveedores 
WHERE nombre = 'VIPSOLUCIONES' AND rif = 'V-25293519';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-17194164\n04245665517\nBANESCO', '01340326173261102710\nV-17194164\n04245665517\nBANESCO\nEMMA RANGEL', NULL
FROM proveedores 
WHERE nombre = 'RR INTEC' AND rif = 'V-17194164';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-500455577\n04128019844\nBANCAMIGA', NULL, NULL
FROM proveedores 
WHERE nombre = 'CANGURO' AND rif = 'J-500455577';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J085011447\n04143503142\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'TORNILLOS LARA' AND rif = 'J-08501144-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-11696752\n04145208860\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'REDCURSOS C.A.' AND rif = 'J-29725765-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V- 12.780.262\n04245610687\nBanesco', '01340447054473024514\nV- 12.780.262\n04245610687\nBanesco\nRafael Arismendi', NULL
FROM proveedores 
WHERE nombre = 'SERVICIOS Y SOLUCIONS TECNOLOGICAS C.A.' AND rif = 'J-29788645-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-50064170-2\n01340960989601018158\n04120795168', NULL
FROM proveedores 
WHERE nombre = 'PINTURAS Y SUMINISTROS ZG' AND rif = 'J-50064170-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-17.308.959\n Banesco  \n0426.957.65.79', NULL, NULL
FROM proveedores 
WHERE nombre = 'CARJUED SERVICIOS GENERALES' AND rif = 'J-40527713-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0426.957.65.79"', NULL, NULL
FROM proveedores 
WHERE nombre = 'FILTROS J.J.S. LARA' AND rif = 'J-40979788-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-11495183\nBanesco \n04145251298', NULL, NULL
FROM proveedores 
WHERE nombre = 'JORGE ZAMBRANO' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-20929496 \n04145606148\nBANESCO \nJORGE ANKA', NULL, NULL
FROM proveedores 
WHERE nombre = 'CARPITAP' AND rif = 'J-08520384-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04127542977\n29604455\nVENEZUELA', NULL, NULL
FROM proveedores 
WHERE nombre = 'WILKER ANTONIO CASTILLO JUAREZ' AND rif = 'V-29604455';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '10854956 \n04245803793\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'JOSE ROJAS' AND rif = 'V-10854956';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PIOVESAN C.A.\n0134-0218312183006951\nJ-08503518-4', NULL, NULL
FROM proveedores 
WHERE nombre = 'PIOVESAN C.A' AND rif = 'J-311059393';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n0424-5683887\nV-7432409', '0134-0326-1532-6111-1988\nV-7432409\nGABRIELA FIORIN', NULL
FROM proveedores 
WHERE nombre = 'CRISTALERIA GABY' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'MAYRA DURAN\nV-9620913\n0134-0864558641012244', NULL
FROM proveedores 
WHERE nombre = 'MAYRA DURAN CISTERNA' AND rif = 'V-9620913';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0134 BANESCO\nRIF J504069906\n04144316553', 'BANESCO\n0134-0447-0744-7105-9880\nRIF J504069906', NULL
FROM proveedores 
WHERE nombre = 'LUMINARIA DIODI' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-305431647\n04145251021\nBANESCO', NULL, NULL
FROM proveedores 
WHERE nombre = 'FIBRA DE MADERA DE LARA C.A.' AND rif = 'J-30543164-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0218-3421-8102-2768\nV-24.185.236', NULL
FROM proveedores 
WHERE nombre = 'MECICA' AND rif = 'J-40654772-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'VENEZUELA\nJ-500292910\n04145105363', 'LA BOMBILLERIA DEL ESTE, C.A\n‎RIF J-500292910\n‎CTA CORRIENTE\n‎BCO VENEZUELA\n‎01020862900000330709', NULL
FROM proveedores 
WHERE nombre = 'LA BOMBILLERIA DEL ESTE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banco nacional de crédito\n0191-0073-1221-7306-3730\nRif:J-50356628-0\nMundo carpintero c.a.', NULL
FROM proveedores 
WHERE nombre = 'MUNDO CARPINTERO' AND rif = 'J-0356628-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO \n0134-1000-36-0001000627\nRif J-29503690-6', NULL
FROM proveedores 
WHERE nombre = 'MATERIALES DE ABREU' AND rif = 'J-29503690-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial \nV-4.386.344 \n0414-5589905 \n', 'Provincial \n0108-2433-8801-0022-9480 \nV-4.386.344 \n', NULL
FROM proveedores 
WHERE nombre = 'ROBERTO COSENTINO' AND rif = 'V-4386344';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'C.I 15.352.302\nTlf: 0412-2648176\nBanco provincial', 'Jammy  Arias \nC.I 15.352.302\nTlf: 0412-2648176\nBanco provincial\n01082407960100132965', NULL
FROM proveedores 
WHERE nombre = 'DAIRON CAMPANAS' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'ALIRIO LACLE BANESCO\nV-18479758\n0134-0864-57-86-41006913', NULL
FROM proveedores 
WHERE nombre = 'GRAPHIC CENTER' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245029872 \n16641112\nVenezolano de credito', NULL, NULL
FROM proveedores 
WHERE nombre = 'ELECTRONICA NUEVA SION C.A.' AND rif = 'J-50383913-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PAGO MOVIL\nV.19.482.113\n0412-152-82-74\nMERCANTIL', NULL, NULL
FROM proveedores 
WHERE nombre = 'WOLF TECH' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco Banco Universal\n0134-0447-08-4471061104\nC. I.   V-9882722\nTHELMO PEREZ VIELMA', NULL
FROM proveedores 
WHERE nombre = 'THELMO PEREZ VIELMA' AND rif = 'V-9882722';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-12249873\n04245176236\nBANESCO', NULL, NULL
FROM proveedores 
WHERE nombre = 'FRIO DEL ESTE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04143507610\nJ-302984831', NULL, NULL
FROM proveedores 
WHERE nombre = 'RUEDAS Y MAS RUEDAS, C.A.' AND rif = 'J-302984831';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-31105939-3\n04245549193', NULL, NULL
FROM proveedores 
WHERE nombre = 'PINTURAS BENAVIDES S.A. (CENTRO)' AND rif = 'J-31105939-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-17858499 \n04245441755\nBanco fondo común', NULL, NULL
FROM proveedores 
WHERE nombre = 'OMAR ROJAS REFRIGERACION' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco\n0134-0447-00-4471059805\nJ-501287759', NULL
FROM proveedores 
WHERE nombre = 'EL PUNTO DEL HIERRO' AND rif = 'J-501287759';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Futurewater c.a\nJ-501.012.296\n0134-1203-13-0001008950', NULL
FROM proveedores 
WHERE nombre = 'FUTURE WATER C.A.' AND rif = 'J-50101229-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banco del tesoro\nJ-312109238\n04125152484', NULL, NULL
FROM proveedores 
WHERE nombre = 'IMPORTADORA OCCIDENTAL DE VENEZUELA, CA' AND rif = 'J-31210923-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-19779621\n04125766832\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'SEIPCA LARA NOTA DE ENTREGA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-41096157-0\n04145230853\nBANCO DIGITAL DE LOS TRABAJADORES', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETANQUES H2O' AND rif = 'J-41096157-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nJ293628393\n04265517387', 'Expo frio ca \nJ293628393\n01020312100000028118', NULL
FROM proveedores 
WHERE nombre = 'EXPO FRIO C.A.' AND rif = 'J-29362839-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nV33165177\n04128257589', 'BANESCO\nV33165177\n01340960999601017132', NULL
FROM proveedores 
WHERE nombre = 'SONIMAX MOVIL' AND rif = 'V33165177';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-304267738\nBANPLUS\n04166504055', NULL, NULL
FROM proveedores 
WHERE nombre = 'BALDOLARA C.A' AND rif = 'J-30426773-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0416-6512545 \nV-14.696.801\nBancamiga', 'V14696801\n01720302953028153447\nBANCAMIGA', NULL
FROM proveedores 
WHERE nombre = '3113 REPRESENTACIONES' AND rif = 'J-29450944-4';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'MERCANTIL\nJ-08505667-0\n04245351432', NULL, NULL
FROM proveedores 
WHERE nombre = 'VICTOR JOSE RODRIGUEZ C.A.' AND rif = 'J-08505667-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-15811002\nBANCO EXTERIOR\n04145793640', NULL, NULL
FROM proveedores 
WHERE nombre = 'MATERIALES LA GUARIQUEÑA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n01340416014161017423\nJ298502720\nCOMERCIALIZADORA 1368', NULL
FROM proveedores 
WHERE nombre = 'COMERCIALIZADORA 1368 C.A' AND rif = 'J-29850272-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245431079\n17191184\nBancamiga', NULL, NULL
FROM proveedores 
WHERE nombre = 'EMA CARS' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n01340326173261112539\nJ501106746\nP.P.F.C.A.', 'PROVINCIAL\n01082401080100436015\nJ501106746\nP.P.F.C.A.'
FROM proveedores 
WHERE nombre = 'P.P.F, C.A (P.P.F, C.A)\n' AND rif = 'J501106746';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1203-1300-0100-3277\nJ-405626607', NULL
FROM proveedores 
WHERE nombre = 'COMERCIAL SAFA MUNDO' AND rif = 'J-405626607';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-40637490-3\n0134-0395-3139-51029938', NULL
FROM proveedores 
WHERE nombre = 'CENTRO CONSTRURAMA, C. A,' AND rif = 'J-40637490-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-0416-0541-6102-4076\nJ-295931930', NULL
FROM proveedores 
WHERE nombre = 'FERREELECTRICA DEL ESTE, C.A.' AND rif = 'J295931930';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04247703348\nJ501156549\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'GRUPO HIERROCA LARA C.A.' AND rif = 'J501156549';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO NACIONAL DE CREDITO\n04145018103\nV-16898156', NULL, NULL
FROM proveedores 
WHERE nombre = 'ALFARERIA INALVENSA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1031-3100-0300-0858\nV-17.860.613\nMarco Álvarez', NULL
FROM proveedores 
WHERE nombre = 'MARCO ALVAREZ' AND rif = 'V-17860613';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-0326-14-3262033669\nV-13435096', NULL
FROM proveedores 
WHERE nombre = 'SONIA FERNANDEZ FERNANDEZ' AND rif = 'V-13435096';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V7317066\n0412.0579004\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREDETAL' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245798188  \nV12020824\n Venezuela', NULL, NULL
FROM proveedores 
WHERE nombre = 'LUIS PEREZ' AND rif = 'V-7433003-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n0414-5185028\nJ-085185330', 'J-085185330\n0108-2431-1001-0000-2930', NULL
FROM proveedores 
WHERE nombre = 'ARCOSAN BARQUISIMETO' AND rif = 'J-085185330';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO BANESCO\nV20351420\n04245256978\n', NULL, NULL
FROM proveedores 
WHERE nombre = 'DJM SISTEMAS DE SEGURIDAD' AND rif = 'V20351420';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0414 5303488 \n11.792.933 \nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'ALFREDO ANTONIO PARADA COLMENAREZ' AND rif = 'V-11792933';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '13776768 \nBanco provincial \n 04245087293', NULL, NULL
FROM proveedores 
WHERE nombre = 'OMAIRA INSTALACIONES' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco\n01340416004161028746\nJ503142189\n', NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES FERREMETAL' AND rif = 'J503142189';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0447-03-4471062152\nJ-50219308-1', NULL
FROM proveedores 
WHERE nombre = 'REFRI-CORP' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V25838554\n04147355803\nBANESCO', 'BANCO DE VENEZUELA\n01020180240000036210\nJesus Mendoza \n16859927', NULL
FROM proveedores 
WHERE nombre = 'GILBERTO FLORES' AND rif = 'V25838554';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nV-12248163\n04125080448', NULL, NULL
FROM proveedores 
WHERE nombre = 'TODO RUEDAS' AND rif = 'J-50680407-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nV-17625048\n04145122094', NULL, NULL
FROM proveedores 
WHERE nombre = 'PLASTIC PLANET' AND rif = 'J-40209043-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '24397601\nprovincial\n04122376012', NULL, NULL
FROM proveedores 
WHERE nombre = 'MULTISERVICIOS RUSO FRIO' AND rif = 'V-24397601-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ301168712\n04245566511', NULL, NULL
FROM proveedores 
WHERE nombre = 'CONTROLES LARA' AND rif = 'J301168712';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nV-17572546\n04261522192', NULL, NULL
FROM proveedores 
WHERE nombre = 'RODDY PERAZA' AND rif = 'V17572546';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'MAPLOCA\nJ-000244995\n0134-0389-9238-9103-5283', NULL
FROM proveedores 
WHERE nombre = 'MAPLOCA C.A' AND rif = 'J-000244995';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '15319136 \nBanesco \n04146594657', NULL, NULL
FROM proveedores 
WHERE nombre = 'CARMEN VILLEGAS' AND rif = 'V-15319136';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BNC\n22783060\n04129892393', NULL, NULL
FROM proveedores 
WHERE nombre = 'ERICK RIVAS' AND rif = 'V-22783060';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1089-51-000100-8327\nSUPERFICIES LARA\nJ-50261973-9', NULL
FROM proveedores 
WHERE nombre = 'CASTEL LARA' AND rif = 'J-50261973-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0414-3502529\nJ-85007636\nBANESCO\n', NULL, NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA DUNCAN C.A.' AND rif = 'J085007636';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-500365209\n04147969123', '0134-0218-3621-81024616\nJ-500365209\nBANCO BANESCO', NULL
FROM proveedores 
WHERE nombre = 'FERREMAX BQTO, CA' AND rif = 'J-50036520-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BNC\n15.491.963\n0414-5591333', NULL, NULL
FROM proveedores 
WHERE nombre = 'TECH SOLUTION STORE CA' AND rif = 'V-15491963';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04245829091\nV-20350140', NULL, NULL
FROM proveedores 
WHERE nombre = 'JONATHAN JOSE VILLEGAS HERNANDEZ' AND rif = 'V-20350140';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245433645 \n18421047\nMercantil', NULL, NULL
FROM proveedores 
WHERE nombre = 'JOHANNA ANDREA PAREDES GIMENEZ' AND rif = 'V-18421047';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial\n04245387081\nV-18356666\n', NULL, NULL
FROM proveedores 
WHERE nombre = 'VirtualPC Electronic' AND rif = 'V-18356666';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO BANESCO\nJ-08517503-2\n04245030372', NULL, NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA D''AIR, C.A' AND rif = 'J-08517503-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANCO PROVINCIAL\nV-7418030\n0108-2401-02-0100346237', NULL
FROM proveedores 
WHERE nombre = 'GIUSEPPE VERDE' AND rif = 'V-7418030';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO BANESCO\nJ-409781666\n04245998838', 'J-40978166-6\n0134-0416-094161027539\nBANESCO', NULL
FROM proveedores 
WHERE nombre = 'SOLO LED' AND rif = 'J-40978166-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO PROVINCIAL\n04145691441\nV-14482711', NULL, NULL
FROM proveedores 
WHERE nombre = 'NILSON JAVIER HERNANDEZ' AND rif = 'V14482711';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'CI 14879074\nTlf 04245700744\nProvincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'TORNERIA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04145185537\n14879574', NULL, NULL
FROM proveedores 
WHERE nombre = 'JEALIROS CARUCI GIL' AND rif = 'V-14879574';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\nJ500821344\n04165015056', NULL, NULL
FROM proveedores 
WHERE nombre = 'TORNILLERIA LA VIEJA' AND rif = 'J-50082134-4';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0354-6835-4102-1310\nJ-50030712-8', NULL
FROM proveedores 
WHERE nombre = 'GRUPO ITAPVEN, C.A.' AND rif = 'J-50030712-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nV-12565647\n0416-6439955', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRE NEWLINK' AND rif = 'V-12565647';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nV-13786098\n04245237158', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES WTS C.A' AND rif = 'V-13786098';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n0412-864002\nV-27346695', NULL, NULL
FROM proveedores 
WHERE nombre = 'Technology Store' AND rif = 'V-27346695';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04145280452\n24925680', NULL, NULL
FROM proveedores 
WHERE nombre = 'MARIELENA CAROLINA MUJICA GOMEZ\n' AND rif = 'V-24925680';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n0414-5143262\nV13905167', NULL, NULL
FROM proveedores 
WHERE nombre = 'ZONA TECNO C.A' AND rif = 'V-13905167';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nV15599445\n04245303402', NULL, NULL
FROM proveedores 
WHERE nombre = 'SYM REPRESENTACIONES' AND rif = 'J-40612434-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-40074511-0\nBanesco\n0424-5209145', NULL, NULL
FROM proveedores 
WHERE nombre = 'MUESCA EVENTOS C.A' AND rif = 'J-40074511-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\n15729866\n04145381123', 'Banesco\nCuenta Corriente\n01340960959601012046\nJorge Hernandez\nV15729866\nJorgehernandezb@gmail.com', NULL
FROM proveedores 
WHERE nombre = 'JORGE HERNANDEZ' AND rif = 'V15729866';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco\n0134-0416-06-4161027955\nV-12699214\nDARLING JOSEFINA HERRERA PEREZ', NULL
FROM proveedores 
WHERE nombre = 'HIDROTUBERIA DH' AND rif = 'J-50416571-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0326-1932-6111-5178\nJ-50350319-0', NULL
FROM proveedores 
WHERE nombre = 'TOTAL TOOLS CENTRO' AND rif = 'J-50350319-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '\nC.I. 16.898.190\n04245153819\nBANCO: Banesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'KAMAL SERVICE' AND rif = 'J-505007211';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCAMIGA\n0424-1206466\nJ-308565202', NULL, NULL
FROM proveedores 
WHERE nombre = 'EL CANGURO, C.A.' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '18.861.357\n04245393294\nMercantil', NULL, NULL
FROM proveedores 
WHERE nombre = 'MULTIMUEBLES EK' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n19165991\n04143543307', NULL, NULL
FROM proveedores 
WHERE nombre = 'JOSE LEONARDO RODRIGUEZ' AND rif = 'V-19165991';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n0412-1545231\nE-82239242\n', NULL, NULL
FROM proveedores 
WHERE nombre = 'MERCANTIL FABULOSO' AND rif = 'E-82239242';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04245030372\nJ-085175032', 'BANESCO\n0134-1203-1500-0100-1219\nJ-085175032', NULL
FROM proveedores 
WHERE nombre = 'REFRIPARTES LARA, C.A.' AND rif = 'J-08517503-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0429-114293019125\nV-17618710', NULL
FROM proveedores 
WHERE nombre = 'WU JIN JUN' AND rif = 'V17618710';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco \nC.I 17.011.496\nTelf: 0414/5285242', 'PROVINCIAL\n0108-2432-0101-0017-2076\nFUEGOTEXT SISTEMAS, C.A\nRIF: J-40772342-1', 'Banesco \n0134-0326-19-3261111762\nJahzeel Gonzalez\nC.I 17.011.496'
FROM proveedores 
WHERE nombre = 'FUEGOTEXT SISTEMAS C.A.' AND rif = 'J-40772342-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANPLUS\nJ-50430148-5\n04145143246', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRE PINTURAS LA 50, C.A' AND rif = 'J-504301485';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-20186834\n04145643648\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'FABIOLA ANDREINA PASTRAN REINOSO' AND rif = 'V-20186834';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO MERCANTIL\n04143508557\nV-9557748', 'BANESCO\n0134-0326-13-3261111555\nV-9620352', NULL
FROM proveedores 
WHERE nombre = 'COMERCIAL CASTILLO' AND rif = 'J-08532046-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-1031-39-0001006888\nJ-40345070-6', NULL
FROM proveedores 
WHERE nombre = 'OFFICENET SUMINISTROS Y TECNOLOGIA C.A' AND rif = 'J-40345070-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '15003857\n 04245594013 \nProvincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'LANDYS ANTONIO PINEDA CARUCI' AND rif = 'V-15003857-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\n04243399303\nJ-50737791-1', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRE TECH 2024 C.A.' AND rif = 'J-50737791-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0326-11-3261102199\nJ-313786160', NULL
FROM proveedores 
WHERE nombre = 'LA CASA DEL ASFALTO' AND rif = 'J-31378616-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\nJ- 412724576\n0426-5196026', NULL, NULL
FROM proveedores 
WHERE nombre = 'MATERIALES PINTAPEG, C.A' AND rif = 'J-412724576';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO PROVINCIAL\n0416-6469014\nV-14376622', 'BANCO PROVINCIAL \nV-14376622\nCTA CORRIENTE\n01082432030100048251', NULL
FROM proveedores 
WHERE nombre = 'CARLOS OROPEZA' AND rif = 'V-14376622';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-17873011\n04245213978\nBANESCO', 'V-17873011\n0134-1000-36-0001005519', NULL
FROM proveedores 
WHERE nombre = 'OFICINAS TECNICAS PEREZ ARAUJO' AND rif = 'J-178730114';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '01340193401931082602\nJ-41242479-3', NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES ELECTRONIC JNC 2016 CA (MERCADO LIBRE)' AND rif = 'J-41242479-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nV-17853140\n04120515100', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA OLIN LA 55' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial\n26.820.035\n0424-5799795', NULL, NULL
FROM proveedores 
WHERE nombre = 'AUTOMARKET VENEZUELA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nJ-40229463-8\n04245155385', NULL, NULL
FROM proveedores 
WHERE nombre = 'GRUPO FRAGA C.A.' AND rif = 'J-40229463-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANCO BANESCO\n01341203150001003293\nJ-31114922-8', NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA LA CONCORDIA CA' AND rif = 'J-31114922-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL \nV-16324851\n04245898132', NULL, NULL
FROM proveedores 
WHERE nombre = 'H.S. CRISTALES 2030, C.A' AND rif = 'J-50301164-5';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL \nV-16260862\n04245019417', 'BANCO PROVICIAL \n01080019690100148092\nV-16260862', NULL
FROM proveedores 
WHERE nombre = 'CASPERSU SEGURIDAD INDUSTRIAL C.A' AND rif = 'V-16260862';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '21126771\n04145670593\nBancamiga', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES CP 2017, C.A.' AND rif = 'J-41176825-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-407587757\n042635956277\nBANCO DE VENEZUELA', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREBOMBAS' AND rif = 'J-407587757';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0414-4158930\nCI: 12.108.622\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERROMETAL, C.A.' AND rif = 'J-31692366-5';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-19263451\n04245885488\nVENEZUELA', NULL, NULL
FROM proveedores 
WHERE nombre = 'EL PUNTO DE FRIO' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04145382354 \nV-20187406\nBanco venezuela', NULL, NULL
FROM proveedores 
WHERE nombre = 'EVER BIANEY BRICEÑO MARIN' AND rif = 'V-20187406';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-50100626-1\n04248197238', NULL, NULL
FROM proveedores 
WHERE nombre = 'PINTURAS BARRETO, C.A.' AND rif = 'J-50100626-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'MERCANTIL\nE84397276\n04145268370', NULL, NULL
FROM proveedores 
WHERE nombre = 'OTROS' AND rif = 'E84397276';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-19883773 \nBANESCO\n0412-0532016', 'J406277991 SEGURITY NETWORW CA \nN° Cuenta: 0156-0035-71-0201919305\n100% BANCO', NULL
FROM proveedores 
WHERE nombre = 'SEGURINET C.A' AND rif = 'V-19883773';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-19727259\nBANESCO\n0424-5756131', NULL, NULL
FROM proveedores 
WHERE nombre = 'OTROSS' AND rif = 'V-19727259';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-296121915\nBANESCO\n01340031800311152674', NULL
FROM proveedores 
WHERE nombre = 'SIANDRE DECOR EL ROSAL, C.A' AND rif = 'J-296121915';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-7433003\nVENEZUELA\n0424-5528603', NULL, NULL
FROM proveedores 
WHERE nombre = 'LUIS PEREZ ARENA' AND rif = 'V-7433003';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-22322517\nPROVINCIAL \n0424-5972545', NULL, NULL
FROM proveedores 
WHERE nombre = 'REFRIGERACION DAIR' AND rif = 'V-22322517';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-21126771\nBANCAMIGA\n04145670593', NULL, NULL
FROM proveedores 
WHERE nombre = 'CESAR PEREIRA' AND rif = 'V-21126771';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '26540929\nBanesco\n04245856237', NULL, NULL
FROM proveedores 
WHERE nombre = 'CESAR ENRIQUE VELIZ BRAVO' AND rif = 'V-26540929';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\n0134-0798-30-7981000778\nJ-29485070-7', NULL
FROM proveedores 
WHERE nombre = 'TECHOLAND MIRANDA LP, C.A.' AND rif = 'J-294850707';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'MERCANTIL\n04125184010\nV-3446028', NULL, NULL
FROM proveedores 
WHERE nombre = 'DIANA LUZ ESPINOZA CAMACARO' AND rif = 'V-3446028';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Venezuela \nV-10.775.405 \n0414 5210199.', NULL, NULL
FROM proveedores 
WHERE nombre = 'MATERIALES SOCI' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\n0414 5145883 \nV-7.884.169.', NULL, NULL
FROM proveedores 
WHERE nombre = 'SERVICRISTAL LARA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nV-7317066\n04120579004', NULL, NULL
FROM proveedores 
WHERE nombre = 'COLCHONES BARQUISIMETO' AND rif = 'J-500278705';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO VENEZOLANO DE CREDITO \nV9626050\n04149502743', NULL, NULL
FROM proveedores 
WHERE nombre = 'EDGAR ENRIQUE FARIAS RIVAS' AND rif = 'V9626050';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\nV-10380316\n0412-2555611', 'Musset Brutus \nV10380316\n0134-0375-97-3751006364', NULL
FROM proveedores 
WHERE nombre = 'BRUTS STORE' AND rif = 'V-10380316';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-0416-0141-6102-0032\nJ-30979025-0', NULL
FROM proveedores 
WHERE nombre = 'FERREGRANITO' AND rif = 'J-30979025-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\n04144296637\nJUAN RUNQUE\nV-16242507', NULL, NULL
FROM proveedores 
WHERE nombre = 'INFIVENITY' AND rif = 'V-16242507';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04149503112\nV 9266573\nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'ORANGEL MECANICO' AND rif = 'V9266573';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04145253411\n V-11785211 \n Banesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'OTROS - FLETE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial\nV-16585485 \n04145160236', NULL, NULL
FROM proveedores 
WHERE nombre = 'GIGABYTE STORE, C.A' AND rif = 'J507488394';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'E-82.229.550\nBanco banesco \n0414-5233501', '0134-0326-11-3261100685\nE-82.229.550\nBanco banesco', NULL
FROM proveedores 
WHERE nombre = 'ECO TECHNE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Venezuela \n04245045395 \nV-18862639', 'BANCO DE VENEZUELA\n0102-0422-41-0000575373\nV18862639', NULL
FROM proveedores 
WHERE nombre = 'JOSE DAVID DE ANDRADE' AND rif = 'V-18862639';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n18628957\n04128205628\nARTURO VILLEGAS\n', NULL, NULL
FROM proveedores 
WHERE nombre = 'ESPACIO ELECTRONIC' AND rif = 'V-18628957';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'FERRE-MATE\nJ-29840192-3\n04245491855\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREMATE' AND rif = 'J-29840192-3';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '01340385643851001157\nJ-306148973\nBANCO BANESCO', NULL
FROM proveedores 
WHERE nombre = 'EQUIP OFFICE' AND rif = 'J-306148973';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Provincial \n17.307.376 \n0414 0550651', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA MADEIRA' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-16300787\n0424-5459920\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'CRISTALES GABY C.A' AND rif = 'V-16300787';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\nV-11.787.876\n0416.656.85.17', '0134 0416 0041 6301 4133\nBanesco\nV-11.787.876', NULL
FROM proveedores 
WHERE nombre = 'GRUPO ACERINOX PARRILLERAS' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANPLUS\nJ-41276372-5\n04147644831', NULL, NULL
FROM proveedores 
WHERE nombre = 'WIPE' AND rif = 'J-41276372-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0134-1203-1100-0100-7170\nJ-304320612\nDISTRIBUIDORA CAMELOT', NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA CAMELLOT' AND rif = 'J-304320612';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nJ-50339181-2\n04245035573', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRE PINTURAS NAZAR, C.A' AND rif = 'J-50339181-2';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO PROVINCIAL\nV-11132486\n04143509730', NULL, NULL
FROM proveedores 
WHERE nombre = 'SANDRA DEL CARMEN RAMOS SEGOVIA' AND rif = 'V-11132486';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Pago movil \n0414 5670055 \n15.384.029 \nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'COMERCIALIZADORA GARCIA, C.A.' AND rif = 'J-30308326-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANCO NACIONAL DE CREDITO\n0191-0062-6221-6200-2844\nRIF. J-00081762-6', NULL
FROM proveedores 
WHERE nombre = 'REPRESENTACIONES Y DISTRIBUCIONES ZARIKIAN , C.A.' AND rif = 'J-00081762-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04146292031\n18120611\nBANCO PLAZA', NULL, NULL
FROM proveedores 
WHERE nombre = 'VIDRIO TEX' AND rif = 'V-18120611';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n6297913 \n04145112250', NULL, NULL
FROM proveedores 
WHERE nombre = 'MANUEL POLIURETANO' AND rif = 'V-6297913';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANPLUS\n19686129\n04145451558', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES JORDAY' AND rif = 'J-403843627';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-7443524\n 04145243434 \nBanco venezolano de crédito', NULL, NULL
FROM proveedores 
WHERE nombre = 'JULIO CESAR BARRETO SANTELIZ' AND rif = 'V-7443524';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-13856324\n04145780627\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'CARLOS SIMON VELIZ' AND rif = 'V-13856324';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J-50263215-8\nBANESCO\n04244349027', 'CONSAGRO LARA\n0134-1089-5200-0100-8326\nJ-502632158', NULL
FROM proveedores 
WHERE nombre = 'CONSAGRO LARA, C.A.' AND rif = 'J-50263215-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-00036157-6\n0108-0032-3401-00040829', NULL
FROM proveedores 
WHERE nombre = 'C.A. TELARES DE PALO GRANDE' AND rif = 'J-00036157-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\nJ-50101186-9\n0134-0447-01-4471059043', NULL
FROM proveedores 
WHERE nombre = 'OXINITRO, C.A.' AND rif = 'J-50101186-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\n04145173739\nJ-311398570', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRETERIA CAMILA C.A.' AND rif = 'J-31139857-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'MERCANTIL\nV19165765\n04245591570', NULL, NULL
FROM proveedores 
WHERE nombre = 'YESENIA PIEDRA' AND rif = 'V-19165765';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '19727259 \n04245756131 \nBanesco', NULL, NULL
FROM proveedores 
WHERE nombre = 'DESIREE ROSANGELA ARENAS DURAN' AND rif = 'V-19727259';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '01082416870100240775 \nV-17625124', NULL
FROM proveedores 
WHERE nombre = 'KATHERINE CRISTINA IDROGO PEREZ' AND rif = 'V-17625124';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-13775994\n04245200906\nMERCANTIL', NULL, NULL
FROM proveedores 
WHERE nombre = 'EDGARD FELIPE GIL D` SANTIAGO\n' AND rif = 'V13775994';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04145147706 \n21311878\nProvincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'MUEBLERIA HOME ELEGANT' AND rif = 'J-50570754-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04141587502\nV-15265480\nBANESCO', NULL, NULL
FROM proveedores 
WHERE nombre = 'YONGER JOSE TUA CASTILLO' AND rif = 'V-15265481';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04245136552\n16085333\nVENEZUELA', NULL, NULL
FROM proveedores 
WHERE nombre = 'JEAN CARLOS ARANGUREN CEDEÑO' AND rif = 'V160853332';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\n04245948627\n15758529', NULL, NULL
FROM proveedores 
WHERE nombre = 'MARJORIE ELIZABETH CASTILLO\n' AND rif = 'V157585297';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '17993775\n04125183084 \nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'MARISELA YULIANA ROJAS PINEDA' AND rif = 'V-17993775';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCAMIGA\nJ-31222537-8\n04140732806', NULL, NULL
FROM proveedores 
WHERE nombre = 'BANYAN AUDIO Y SONIDO' AND rif = 'J-31222537-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '0134-0960-94-9601017661\nV-17378090\nANGGY DAYANA ANCIANI DE LINAREZ', NULL, NULL
FROM proveedores 
WHERE nombre = 'ANGGY DAYANA ANCIANI DE LINAREZ' AND rif = 'V-17378090';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'BANESCO\nJ-41096157-0\n0134-0447-05-4471056785', NULL
FROM proveedores 
WHERE nombre = 'DISTRIBUIDORA DIBROCA, C.A.' AND rif = 'J-41096157-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nV-13543146\n04145654395', NULL, NULL
FROM proveedores 
WHERE nombre = 'PGP IMAGEN CREATIVA, C.A.' AND rif = 'J-29549512-9';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '28338968\n04241210972\nBancamiga', NULL, NULL
FROM proveedores 
WHERE nombre = 'JUSTIN ALFREDO ARIAS PEREZ' AND rif = 'V-28338968-1';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n11785211\n0414 5253411', NULL, NULL
FROM proveedores 
WHERE nombre = 'JUAN CARLOS RODRIGUEZ SEQUERA' AND rif = 'V-117852110';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'Banesco\n0134-0864-56-8641014065\nV-15599937', NULL
FROM proveedores 
WHERE nombre = 'MIGUEL DE SAN MARTIN' AND rif = 'V-15599937';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-14696426\n04145097711\nPROVINCIAL', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREONLINE' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, '0108-2457-55-0100134464\n J-40709163-8\nPROVINCIAL', NULL
FROM proveedores 
WHERE nombre = 'LAMINAIRE C.A.' AND rif = 'J-40709163-8';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04121665220\nJ507222527\nBanco exterior', '01150035871006710757\nJ507222527\nBanco exterior', NULL
FROM proveedores 
WHERE nombre = 'ASERRADERO LOS JUANES' AND rif = 'J-50722252-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, NULL, 'J-504119466\n0108-0944-48-0100031011', NULL
FROM proveedores 
WHERE nombre = 'LAMINADOS Y MADERAS ARAGUANEY C.A.' AND rif = 'J-50411946-6';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'PROVINCIAL\nV-7317066\n04120579004', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERREDETAL LOS BARRETO' AND rif IS NULL;
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DE VENEZUELA\nV-17853140\n04120515100', NULL, NULL
FROM proveedores 
WHERE nombre = 'ANAIS MARLENE RAMIREZ COLMENAREZ' AND rif = 'V-17853140';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banesco\nE-84415801\n04122964754', NULL, NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES JK 8102, C,A,' AND rif = 'J-50069198-0';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'J296279063\nBanesco\n04128957836', 'Inversiones Jomarca, C. A\n01340325283251054275\nJ296279063', NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES JOMARCA C.A' AND rif = 'J296279063';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANCO DEL TESORO\nJ-302698367\n04125520191', NULL, NULL
FROM proveedores 
WHERE nombre = 'ACRILUM' AND rif = 'J-302698367';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '24772981\n0412-1732071 \nBNC', NULL, NULL
FROM proveedores 
WHERE nombre = 'ANDREINA VALLES' AND rif = 'V-24772981';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\n04122500907\nJ312728817', 'BANESCO\n01341031300001005196\nJ312728817', NULL
FROM proveedores 
WHERE nombre = 'INVERSIONES RTT, C.A. (INVERSIONES RTT, C.A.)\n' AND rif = 'J312728817';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '21726314\nProvincial \n04245674529', NULL, NULL
FROM proveedores 
WHERE nombre = 'MOISES ELI MEDINA BULLONES' AND rif = 'V21726314';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '13777975\n04245562735\n0108 (provincial)', NULL, NULL
FROM proveedores 
WHERE nombre = 'SUMINISTROS MCI 2019 C.A.' AND rif = 'V-13777975';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'Banco de Venezuela\n01020422430001494628\nJ-50600166-7\nFERREMATERIALES VENELCO CA', 'Banco Provincial\n01080087150100580939\nJ-50600166-7\nFERREMATERIALES VENELCO CA', NULL
FROM proveedores 
WHERE nombre = 'FERREMATERIALES VENELCO, C.A' AND rif = 'J-50600166-7';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'V-16641112\nBanco nacional de credito \n04245029872', NULL, NULL
FROM proveedores 
WHERE nombre = 'ELECTRONICA NUEVA SION,\nC.A.' AND rif = 'J-503839139';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, '04145347145\n10906764\nProvincial', NULL, NULL
FROM proveedores 
WHERE nombre = 'YSOLINA DEL CARMEN SALCEDO PARRA' AND rif = 'V-10906764';
INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, 'BANESCO\nJ-29837465-9\n04145527815', NULL, NULL
FROM proveedores 
WHERE nombre = 'FERRE- ELECTRICA ALFA, CA.' AND rif = 'J-29837465-9';
