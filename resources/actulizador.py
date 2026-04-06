import tkinter as tk
from tkinter import ttk, messagebox
import json
import os
from datetime import datetime
from decimal import Decimal, getcontext

# Configurar precisión decimal
getcontext().prec = 10

class OrdenCompraCalculadora:
    def __init__(self, root):
        self.root = root
        self.root.title("Calculadora de Orden de Compra")
        self.root.geometry("900x700")
        
        # Establecer estilo
        self.setup_styles()
        
        # Variables de datos
        self.productos = []
        self.tasa_cambio = Decimal('36.50')
        self.aplica_iva = tk.BooleanVar(value=True)
        self.aplica_deduccion = tk.BooleanVar(value=False)
        
        # Variables para cálculos
        self.total_general = Decimal('0')
        self.iva_calculado = Decimal('0')
        self.total_final = Decimal('0')
        
        # Configurar interfaz
        self.setup_ui()
        
        # Cargar datos de ejemplo
        self.cargar_datos_ejemplo()
    
    def setup_styles(self):
        """Configurar estilos visuales"""
        style = ttk.Style()
        style.theme_use('clam')
        
        # Colores principales
        self.color_primario = "#8a0a27"
        self.color_secundario = "#B22222"
        self.color_fondo = "#f8f9fa"
        self.color_texto = "#333333"
        
        # Configurar colores
        self.root.configure(bg=self.color_fondo)
        
        # Estilos personalizados
        style.configure('Titulo.TLabel', 
                       font=('Segoe UI', 16, 'bold'),
                       foreground=self.color_primario,
                       background=self.color_fondo)
        
        style.configure('Subtitulo.TLabel',
                       font=('Segoe UI', 12),
                       foreground=self.color_secundario,
                       background=self.color_fondo)
        
        style.configure('Total.TLabel',
                       font=('Segoe UI', 12, 'bold'),
                       foreground=self.color_primario)
    
    def setup_ui(self):
        """Configurar la interfaz de usuario"""
        # Frame principal
        main_frame = ttk.Frame(self.root, padding="10")
        main_frame.grid(row=0, column=0, sticky=(tk.W, tk.E, tk.N, tk.S))
        
        # Configurar expansión de filas y columnas
        self.root.columnconfigure(0, weight=1)
        self.root.rowconfigure(0, weight=1)
        main_frame.columnconfigure(0, weight=1)
        
        # Título
        titulo = ttk.Label(main_frame, text="CALCULADORA DE ORDEN DE COMPRA", 
                          style='Titulo.TLabel')
        titulo.grid(row=0, column=0, columnspan=3, pady=(0, 15))
        
        # Panel de configuración
        config_frame = ttk.LabelFrame(main_frame, text="Configuración", padding="10")
        config_frame.grid(row=1, column=0, columnspan=3, sticky=(tk.W, tk.E), pady=(0, 15))
        
        # Tasa de cambio
        ttk.Label(config_frame, text="Tasa de Cambio (Bs/$):").grid(row=0, column=0, padx=(0, 5))
        self.entry_tasa = ttk.Entry(config_frame, width=15)
        self.entry_tasa.insert(0, str(self.tasa_cambio))
        self.entry_tasa.grid(row=0, column=1, padx=(0, 10))
        
        # Opciones de IVA
        ttk.Checkbutton(config_frame, text="Aplicar IVA (16%)", 
                       variable=self.aplica_iva,
                       command=self.actualizar_calculos).grid(row=0, column=2, padx=(10, 5))
        
        ttk.Checkbutton(config_frame, text="Aplicar Deducción (75%)", 
                       variable=self.aplica_deduccion,
                       command=self.actualizar_calculos).grid(row=0, column=3, padx=(5, 0))
        
        # Botón actualizar tasa
        ttk.Button(config_frame, text="Actualizar Tasa", 
                  command=self.actualizar_tasa).grid(row=0, column=4, padx=(10, 0))
        
        # Sección de productos
        producto_frame = ttk.LabelFrame(main_frame, text="Agregar Producto", padding="10")
        producto_frame.grid(row=2, column=0, columnspan=3, sticky=(tk.W, tk.E), pady=(0, 15))
        
        # Campos para nuevo producto
        ttk.Label(producto_frame, text="Producto:").grid(row=0, column=0, padx=(0, 5))
        self.entry_producto = ttk.Entry(producto_frame, width=30)
        self.entry_producto.grid(row=0, column=1, padx=(0, 10))
        
        ttk.Label(producto_frame, text="Cantidad:").grid(row=0, column=2, padx=(0, 5))
        self.entry_cantidad = ttk.Entry(producto_frame, width=10)
        self.entry_cantidad.insert(0, "1")
        self.entry_cantidad.grid(row=0, column=3, padx=(0, 10))
        
        ttk.Label(producto_frame, text="Precio Unitario ($):").grid(row=0, column=4, padx=(0, 5))
        self.entry_precio = ttk.Entry(producto_frame, width=15)
        self.entry_precio.grid(row=0, column=5, padx=(0, 10))
        
        # Botón agregar producto
        ttk.Button(producto_frame, text="Agregar Producto", 
                  command=self.agregar_producto).grid(row=0, column=6)
        
        # Tabla de productos
        columns = ('#', 'Producto', 'Cantidad', 'Unidad', 'Precio Unit. ($)', 'Subtotal ($)')
        self.tree = ttk.Treeview(main_frame, columns=columns, show='headings', height=10)
        
        # Configurar columnas
        for col in columns:
            self.tree.heading(col, text=col)
            self.tree.column(col, width=100)
        
        self.tree.column('#', width=50)
        self.tree.column('Producto', width=200)
        self.tree.column('Precio Unit. ($)', width=120)
        self.tree.column('Subtotal ($)', width=120)
        
        self.tree.grid(row=3, column=0, columnspan=3, pady=(0, 15), sticky=(tk.W, tk.E))
        
        # Scrollbar para tabla
        scrollbar = ttk.Scrollbar(main_frame, orient=tk.VERTICAL, command=self.tree.yview)
        self.tree.configure(yscrollcommand=scrollbar.set)
        scrollbar.grid(row=3, column=3, sticky=(tk.N, tk.S), pady=(0, 15))
        
        # Botones para productos
        btn_frame = ttk.Frame(main_frame)
        btn_frame.grid(row=4, column=0, columnspan=3, pady=(0, 15))
        
        ttk.Button(btn_frame, text="Eliminar Producto", 
                  command=self.eliminar_producto).pack(side=tk.LEFT, padx=5)
        ttk.Button(btn_frame, text="Limpiar Lista", 
                  command=self.limpiar_productos).pack(side=tk.LEFT, padx=5)
        
        # Panel de resumen
        resumen_frame = ttk.LabelFrame(main_frame, text="Resumen de Totales", padding="15")
        resumen_frame.grid(row=5, column=0, columnspan=3, sticky=(tk.W, tk.E))
        
        # Filas de resumen
        self.labels_resumen = {}
        filas_resumen = [
            ('Total General ($):', 'total_general_usd'),
            ('Total General (Bs):', 'total_general_bs'),
            ('IVA 16% ($):', 'iva_usd'),
            ('IVA 16% (Bs):', 'iva_bs'),
            ('Deducción 75% ($):', 'deduccion_usd'),
            ('Deducción 75% (Bs):', 'deduccion_bs'),
            ('Total Final ($):', 'total_final_usd'),
            ('Total Final (Bs):', 'total_final_bs')
        ]
        
        for i, (texto, clave) in enumerate(filas_resumen):
            ttk.Label(resumen_frame, text=texto, font=('Segoe UI', 10)).grid(
                row=i, column=0, sticky=tk.W, padx=(0, 10), pady=2)
            
            label_valor = ttk.Label(resumen_frame, text="$ 0.00", 
                                   font=('Segoe UI', 10, 'bold'))
            label_valor.grid(row=i, column=1, sticky=tk.W, pady=2)
            self.labels_resumen[clave] = label_valor
        
        # Botones de acción
        action_frame = ttk.Frame(main_frame)
        action_frame.grid(row=6, column=0, columnspan=3, pady=(15, 0))
        
        ttk.Button(action_frame, text="Calcular Totales", 
                  command=self.calcular_totales).pack(side=tk.LEFT, padx=5)
        ttk.Button(action_frame, text="Guardar Orden", 
                  command=self.guardar_orden).pack(side=tk.LEFT, padx=5)
        ttk.Button(action_frame, text="Generar PDF", 
                  command=self.generar_pdf_simulado).pack(side=tk.LEFT, padx=5)
        ttk.Button(action_frame, text="Imprimir", 
                  command=self.imprimir_simulado).pack(side=tk.LEFT, padx=5)
        ttk.Button(action_frame, text="Salir", 
                  command=self.root.quit).pack(side=tk.LEFT, padx=5)
    
    def actualizar_tasa(self):
        """Actualizar la tasa de cambio"""
        try:
            nueva_tasa = Decimal(self.entry_tasa.get())
            if nueva_tasa <= 0:
                messagebox.showerror("Error", "La tasa debe ser mayor a cero")
                return
            
            self.tasa_cambio = nueva_tasa
            self.calcular_totales()
            messagebox.showinfo("Éxito", f"Tasa actualizada a Bs. {nueva_tasa}/$")
        except:
            messagebox.showerror("Error", "Tasa de cambio inválida")
    
    def agregar_producto(self):
        """Agregar un producto a la lista"""
        try:
            producto = self.entry_producto.get().strip()
            cantidad = Decimal(self.entry_cantidad.get())
            precio = Decimal(self.entry_precio.get())
            
            if not producto:
                messagebox.showerror("Error", "Debe ingresar un nombre de producto")
                return
            
            if cantidad <= 0 or precio <= 0:
                messagebox.showerror("Error", "Cantidad y precio deben ser mayores a cero")
                return
            
            subtotal = cantidad * precio
            
            # Agregar a la lista interna
            self.productos.append({
                'producto': producto,
                'cantidad': cantidad,
                'precio': precio,
                'subtotal': subtotal,
                'unidad': 'UND'
            })
            
            # Agregar a la tabla
            item_id = len(self.productos)
            self.tree.insert('', tk.END, values=(
                item_id,
                producto,
                self.formatear_numero(cantidad),
                'UND',
                f"$ {self.formatear_numero(precio, 4)}",
                f"$ {self.formatear_numero(subtotal, 4)}"
            ))
            
            # Limpiar campos
            self.entry_producto.delete(0, tk.END)
            self.entry_cantidad.delete(0, tk.END)
            self.entry_cantidad.insert(0, "1")
            self.entry_precio.delete(0, tk.END)
            
            # Recalcular
            self.calcular_totales()
            
        except Exception as e:
            messagebox.showerror("Error", f"Datos inválidos: {str(e)}")
    
    def eliminar_producto(self):
        """Eliminar producto seleccionado"""
        seleccion = self.tree.selection()
        if not seleccion:
            messagebox.showwarning("Advertencia", "Seleccione un producto para eliminar")
            return
        
        # Obtener índice del producto
        item = self.tree.item(seleccion[0])
        indice = item['values'][0] - 1
        
        # Eliminar de lista y tabla
        if 0 <= indice < len(self.productos):
            self.productos.pop(indice)
            self.tree.delete(seleccion[0])
            
            # Renumerar items
            for i, item_id in enumerate(self.tree.get_children()):
                self.tree.set(item_id, '#', i + 1)
            
            # Recalcular
            self.calcular_totales()
    
    def limpiar_productos(self):
        """Limpiar todos los productos"""
        if messagebox.askyesno("Confirmar", "¿Está seguro de limpiar todos los productos?"):
            self.productos.clear()
            for item in self.tree.get_children():
                self.tree.delete(item)
            self.calcular_totales()
    
    def calcular_totales(self):
        """Calcular todos los totales"""
        if not self.productos:
            self.limpiar_resumen()
            return
        
        # Calcular total general
        self.total_general = sum(Decimal(str(p['subtotal'])) for p in self.productos)
        
        # Calcular IVA según opciones
        self.iva_calculado = Decimal('0')
        self.deduccion = Decimal('0')
        
        if self.aplica_iva.get():
            self.iva_calculado = self.total_general * Decimal('0.16')
            
            if self.aplica_deduccion.get():
                self.deduccion = self.iva_calculado * Decimal('0.75')
                self.total_final = self.total_general + self.iva_calculado - self.deduccion
            else:
                self.total_final = self.total_general + self.iva_calculado
        else:
            self.total_final = self.total_general
        
        # Actualizar interfaz
        self.actualizar_resumen()
    
    def actualizar_resumen(self):
        """Actualizar los valores en el resumen"""
        # Formatear números
        total_general_fmt = self.formatear_numero(self.total_general)
        iva_fmt = self.formatear_numero(self.iva_calculado) if self.aplica_iva.get() else "0.00"
        deduccion_fmt = self.formatear_numero(self.deduccion) if self.aplica_deduccion.get() else "0.00"
        total_final_fmt = self.formatear_numero(self.total_final)
        
        # Calcular en bolívares
        total_general_bs = self.total_general * self.tasa_cambio
        iva_bs = self.iva_calculado * self.tasa_cambio
        deduccion_bs = self.deduccion * self.tasa_cambio
        total_final_bs = self.total_final * self.tasa_cambio
        
        # Actualizar etiquetas
        self.labels_resumen['total_general_usd'].config(text=f"$ {total_general_fmt}")
        self.labels_resumen['total_general_bs'].config(text=f"Bs. {self.formatear_numero(total_general_bs)}")
        
        # Mostrar/ocultar según configuración
        if self.aplica_iva.get():
            self.labels_resumen['iva_usd'].config(text=f"$ {iva_fmt}")
            self.labels_resumen['iva_bs'].config(text=f"Bs. {self.formatear_numero(iva_bs)}")
            
            if self.aplica_deduccion.get():
                self.labels_resumen['deduccion_usd'].config(text=f"$ {deduccion_fmt}")
                self.labels_resumen['deduccion_bs'].config(text=f"Bs. {self.formatear_numero(deduccion_bs)}")
            else:
                self.labels_resumen['deduccion_usd'].config(text="$ 0.00")
                self.labels_resumen['deduccion_bs'].config(text="Bs. 0.00")
        else:
            self.labels_resumen['iva_usd'].config(text="$ 0.00")
            self.labels_resumen['iva_bs'].config(text="Bs. 0.00")
            self.labels_resumen['deduccion_usd'].config(text="$ 0.00")
            self.labels_resumen['deduccion_bs'].config(text="Bs. 0.00")
        
        self.labels_resumen['total_final_usd'].config(text=f"$ {total_final_fmt}")
        self.labels_resumen['total_final_bs'].config(text=f"Bs. {self.formatear_numero(total_final_bs)}")
        
        # Actualizar estilo del total final
        self.labels_resumen['total_final_usd'].config(foreground=self.color_primario)
        self.labels_resumen['total_final_bs'].config(foreground=self.color_primario)
    
    def limpiar_resumen(self):
        """Limpiar todos los valores del resumen"""
        for label in self.labels_resumen.values():
            label.config(text="$ 0.00" if 'usd' in str(label) else "Bs. 0.00")
    
    def formatear_numero(self, numero, decimales=2):
        """Formatear número con separadores"""
        if isinstance(numero, Decimal):
            numero = float(numero)
        
        # Formato español (coma como separador decimal)
        format_string = f"{{:,.{decimales}f}}"
        formatted = format_string.format(numero)
        
        # Reemplazar puntos por comas y comas por puntos
        formatted = formatted.replace(',', 'X').replace('.', ',').replace('X', '.')
        
        return formatted
    
    def guardar_orden(self):
        """Guardar orden en archivo JSON"""
        if not self.productos:
            messagebox.showwarning("Advertencia", "No hay productos para guardar")
            return
        
        datos_orden = {
            'fecha': datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
            'tasa_cambio': float(self.tasa_cambio),
            'aplica_iva': self.aplica_iva.get(),
            'aplica_deduccion': self.aplica_deduccion.get(),
            'productos': self.productos,
            'total_general': float(self.total_general),
            'iva_calculado': float(self.iva_calculado),
            'total_final': float(self.total_final)
        }
        
        # Crear directorio si no existe
        if not os.path.exists('ordenes'):
            os.makedirs('ordenes')
        
        # Generar nombre de archivo
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        filename = f"ordenes/orden_compra_{timestamp}.json"
        
        # Guardar archivo
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(datos_orden, f, indent=2, ensure_ascii=False)
        
        messagebox.showinfo("Éxito", f"Orden guardada en:\n{filename}")
    
    def generar_pdf_simulado(self):
        """Simular generación de PDF"""
        if not self.productos:
            messagebox.showwarning("Advertencia", "No hay productos para generar PDF")
            return
        
        # Simular generación de PDF
        messagebox.showinfo("Generar PDF", 
                          "Función de generación de PDF simulada.\n" +
                          "En una implementación real, se usaría una librería como ReportLab o WeasyPrint.")
    
    def imprimir_simulado(self):
        """Simular impresión"""
        if not self.productos:
            messagebox.showwarning("Advertencia", "No hay productos para imprimir")
            return
        
        messagebox.showinfo("Imprimir", 
                          "Función de impresión simulada.\n" +
                          "En una implementación real, se generaría un documento imprimible.")
    
    def actualizar_calculos(self):
        """Actualizar cálculos cuando cambian las opciones"""
        self.calcular_totales()
    
    def cargar_datos_ejemplo(self):
        """Cargar datos de ejemplo"""
        productos_ejemplo = [
            {"producto": "Laptop Dell Inspiron 15", "cantidad": Decimal('2'), "precio": Decimal('850.00')},
            {"producto": "Mouse Inalámbrico Logitech", "cantidad": Decimal('5'), "precio": Decimal('25.50')},
            {"producto": "Teclado Mecánico RGB", "cantidad": Decimal('3'), "precio": Decimal('89.99')},
            {"producto": "Monitor 24\" Full HD", "cantidad": Decimal('2'), "precio": Decimal('210.75')}
        ]
        
        for prod in productos_ejemplo:
            self.entry_producto.delete(0, tk.END)
            self.entry_producto.insert(0, prod['producto'])
            self.entry_cantidad.delete(0, tk.END)
            self.entry_cantidad.insert(0, str(prod['cantidad']))
            self.entry_precio.delete(0, tk.END)
            self.entry_precio.insert(0, str(prod['precio']))
            self.agregar_producto()
        
        # Configurar opciones de ejemplo
        self.aplica_iva.set(True)
        self.aplica_deduccion.set(False)
        self.calcular_totales()

def main():
    root = tk.Tk()
    app = OrdenCompraCalculadora(root)
    root.mainloop()

if __name__ == "__main__":
    main()