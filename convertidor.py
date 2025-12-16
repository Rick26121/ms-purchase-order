import pandas as pd
import re
import os

def limpiar_texto(texto):
    """Limpia y formatea el texto para SQL"""
    if pd.isna(texto):
        return None
    texto = str(texto).replace("'", "''")
    texto = texto.replace('\n', '\\n')
    return texto.strip()

def normalizar_rif(rif):
    """Normaliza el formato del RIF"""
    if pd.isna(rif):
        return None
    rif = str(rif).strip()
    rif = re.sub(r'[.\s]', '', rif)
    return rif

def generar_sql_completo(archivo_excel):
    """Genera SQL que crea proveedores si no existen"""
    try:
        df = pd.read_excel(archivo_excel)
    except Exception as e:
        print(f"Error al leer el archivo Excel: {e}")
        return []
    
    sql_proveedores = []
    sql_bancos = []
    
    for index, row in df.iterrows():
        try:
            # Obtener y limpiar datos
            proveedor = limpiar_texto(row.get('PROVEEDOR', row.get('Proveedor', '')))
            rif = normalizar_rif(row.get('RIF', row.get('Rif', '')))
            pago_movil = limpiar_texto(row.get('PAGO MOVIL', row.get('PAGO_MOVIL', row.get('Pago Movil', ''))))
            datos1 = limpiar_texto(row.get('DATOS BANCARIOS 1', row.get('DATOS_BANCARIOS_1', row.get('Datos Bancarios 1', ''))))
            datos2 = limpiar_texto(row.get('DATOS BANCARIOS 2', row.get('DATOS_BANCARIOS_2', row.get('Datos Bancarios 2', ''))))
            
            # Validar datos mínimos
            if not proveedor:
                continue
            
            # Preparar valores para INSERT
            pago_movil_val = f"'{pago_movil}'" if pago_movil else 'NULL'
            datos1_val = f"'{datos1}'" if datos1 else 'NULL'
            datos2_val = f"'{datos2}'" if datos2 else 'NULL'
            
            # Si no hay datos bancarios, saltar
            if not any([pago_movil, datos1, datos2]):
                continue
            
            # SQL para crear proveedor si no existe (INSERT IGNORE)
            if rif:
                sql_proveedor = f"""INSERT IGNORE INTO proveedores (nombre, rif, direccion, telefono, email, contacto)
VALUES ('{proveedor}', '{rif}', NULL, NULL, NULL, NULL);"""
            else:
                sql_proveedor = f"""INSERT IGNORE INTO proveedores (nombre, rif, direccion, telefono, email, contacto)
VALUES ('{proveedor}', NULL, NULL, NULL, NULL, NULL);"""
            
            # SQL para insertar en bancos usando el ID del proveedor
            if rif:
                sql_banco = f"""INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, {pago_movil_val}, {datos1_val}, {datos2_val}
FROM proveedores 
WHERE nombre = '{proveedor}' AND rif = '{rif}';"""
            else:
                sql_banco = f"""INSERT INTO bancos (id_proveedor, pagomovil, bancos1, bancos2)
SELECT id_proveedor, {pago_movil_val}, {datos1_val}, {datos2_val}
FROM proveedores 
WHERE nombre = '{proveedor}' AND rif IS NULL;"""
            
            sql_proveedores.append(sql_proveedor)
            sql_bancos.append(sql_banco)
            
        except Exception as e:
            print(f"Error en fila {index}: {e}")
            continue
    
    return sql_proveedores, sql_bancos

def generar_sql_transaccion(sql_proveedores, sql_bancos):
    """Genera un script SQL con transacción completa"""
    
    sql = """-- SCRIPT COMPLETO PARA IMPORTAR PROVEEDORES Y SUS DATOS BANCARIOS
-- Iniciar transacción para asegurar integridad de datos
START TRANSACTION;

-- ====================================================
-- PRIMERO: CREAR PROVEEDORES SI NO EXISTEN
-- ====================================================

"""
    
    # Agregar INSERTs de proveedores
    for i, sql_prov in enumerate(sql_proveedores, 1):
        sql += f"-- Proveedor {i}\n"
        sql += sql_prov + "\n\n"
    
    sql += """-- ====================================================
-- SEGUNDO: INSERTAR DATOS BANCARIOS
-- ====================================================

"""
    
    # Agregar INSERTs de bancos
    for i, sql_banco in enumerate(sql_bancos, 1):
        sql += f"-- Datos bancarios {i}\n"
        sql += sql_banco + "\n\n"
    
    sql += """-- ====================================================
-- CONFIRMAR TRANSACCIÓN
-- ====================================================

COMMIT;

-- Verificar resultados
SELECT 
    'Proveedores insertados' as Tabla,
    COUNT(*) as Total
FROM proveedores;

SELECT 
    'Datos bancarios insertados' as Tabla,
    COUNT(*) as Total
FROM bancos;

-- Listar proveedores con datos bancarios
SELECT 
    p.nombre,
    p.rif,
    b.pagomovil,
    b.bancos1,
    b.bancos2
FROM proveedores p
LEFT JOIN bancos b ON p.id_proveedor = b.id_proveedor
WHERE b.id_banco IS NOT NULL
ORDER BY p.nombre;"""
    
    return sql

def main():
    # Archivo de entrada
    archivo_excel = "data.xlsx"
    
    # Verificar si el archivo existe
    if not os.path.exists(archivo_excel):
        print(f"Error: El archivo '{archivo_excel}' no existe.")
        return
    
    print(f"Procesando archivo: {archivo_excel}")
    
    # Generar los SQLs
    sql_proveedores, sql_bancos = generar_sql_completo(archivo_excel)
    
    if not sql_proveedores or not sql_bancos:
        print("No se generaron SQLs. Verifica que el archivo tenga datos válidos.")
        return
    
    print(f"Generados {len(sql_proveedores)} INSERTs para proveedores")
    print(f"Generados {len(sql_bancos)} INSERTs para datos bancarios")
    
    # Generar script completo con transacción
    sql_completo = generar_sql_transaccion(sql_proveedores, sql_bancos)
    
    # Guardar en archivo
    with open('import_completo.sql', 'w', encoding='utf-8') as f:
        f.write(sql_completo)
    
    # También guardar archivos separados
    with open('insert_proveedores.sql', 'w', encoding='utf-8') as f:
        f.write("-- INSERTs para tabla proveedores\n")
        f.write(f"-- Total: {len(sql_proveedores)}\n\n")
        for sql in sql_proveedores:
            f.write(sql + "\n")
    
    with open('insert_bancos.sql', 'w', encoding='utf-8') as f:
        f.write("-- INSERTs para tabla bancos\n")
        f.write(f"-- Total: {len(sql_bancos)}\n\n")
        for sql in sql_bancos:
            f.write(sql + "\n")
    
    print("\nArchivos creados:")
    print("  - import_completo.sql (recomendado - con transacción)")
    print("  - insert_proveedores.sql")
    print("  - insert_bancos.sql")
    print("\nInstrucciones:")
    print("1. Ejecuta 'import_completo.sql' en tu base de datos MySQL")
    print("2. Usa 'INSERT IGNORE' para evitar duplicados en proveedores")
    print("3. Los proveedores se crearán automáticamente si no existen")

if __name__ == "__main__":
    main()